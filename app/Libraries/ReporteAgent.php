<?php

namespace App\Libraries;

use App\Models\AgenteReportesLogModel;
use Config\Database;

/**
 * Agente de reporte: lenguaje natural -> SQL (validado) -> ejecucion -> respuesta en NL.
 * Usa Ollama para NL<->SQL y guarda historial en agente_reportes_log.
 */
class ReporteAgent
{
    private const SCHEMA_REPORTES = <<<'TEXT'
Tablas permitidas (MySQL):

- ordenes: id, orden, cliente_id, fecha_orden, estatus_orden, envio_tipo, envio_direccion (JSON), cot_envio_total, orden_impuestos, orden_total, pago_metodo, pago_id, fecha_creado. estatus_orden puede ser 'completed', 'processing', 'pending', etc.

- ordenes_productos: id, wc_orden, productos (JSON con line items). Relacion: ordenes.orden = ordenes_productos.wc_orden.

- ordenes_facturacion: id, wc_orden, facturacion_datos, requiere_factura, facturado. Relacion: ordenes.orden = ordenes_facturacion.wc_orden.

- ordenes_costo_real: id, wc_orden, promocion, promocion_tipo, real_envio_paqueteria, real_envio_guia, real_envio_costo. Relacion: ordenes.orden = ordenes_costo_real.wc_orden.

- paqueterias: id, nombre. Relacion: ordenes_costo_real.real_envio_paqueteria = paqueterias.id.

- promociones: id, nombre. Relacion: ordenes_costo_real.promocion_tipo = promociones.id.

fecha_orden es DATETIME (formato 'YYYY-MM-DD HH:MM:SS'). Para filtrar por mes: DATE(fecha_orden) o YEAR(fecha_orden), MONTH(fecha_orden).
Solo puedes generar una unica sentencia SELECT. No uses INSERT, UPDATE, DELETE ni subconsultas que modifiquen datos.
TEXT;

    private OllamaClient $ollama;
    private SqlReadOnlyValidator $validator;
    private AgenteReportesLogModel $logModel;
    private int $queryTimeoutSeconds;

    public function __construct(
        ?OllamaClient $ollama = null,
        ?SqlReadOnlyValidator $validator = null,
        ?AgenteReportesLogModel $logModel = null,
        int $queryTimeoutSeconds = 10
    ) {
        $this->ollama               = $ollama ?? new OllamaClient();
        $this->validator             = $validator ?? new SqlReadOnlyValidator();
        $this->logModel              = $logModel ?? new AgenteReportesLogModel();
        $this->queryTimeoutSeconds   = $queryTimeoutSeconds;
    }

    /**
     * Pregunta en lenguaje natural -> ejecuta SQL seguro -> respuesta en lenguaje natural.
     *
     * @return array{ok: bool, respuesta_nl?: string, datos?: array, error?: string, sql?: string}
     */
    public function ask(string $pregunta): array
    {
        $sqlGenerado       = null;
        $resultadoResumido = null;
        $respuestaNl      = null;
        $error             = null;

        try {
            $sqlGenerado = $this->generarSql($pregunta);
            if ($sqlGenerado === null || $sqlGenerado === '') {
                $error = 'No se pudo generar una consulta SQL a partir de la pregunta.';
                $this->logModel->guardarConsulta($pregunta, null, null, null, $error);
                return ['ok' => false, 'error' => $error];
            }

            $validacion = $this->validator->validate($sqlGenerado);
            if (! $validacion['valid']) {
                $error = $validacion['error'] ?? 'SQL no permitido.';
                $this->logModel->guardarConsulta($pregunta, $sqlGenerado, null, null, $error);
                return ['ok' => false, 'error' => $error];
            }
            $sqlSeguro = $validacion['sql'];

            $datos = $this->ejecutarSql($sqlSeguro);
            if ($datos === null) {
                $error = 'Error al ejecutar la consulta en la base de datos.';
                $this->logModel->guardarConsulta($pregunta, $sqlSeguro, null, null, $error);
                return ['ok' => false, 'error' => $error];
            }

            $resultadoResumido = json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            if (strlen($resultadoResumido) > 8000) {
                $resultadoResumido = substr($resultadoResumido, 0, 8000) . "\n... (truncado)";
            }

            $respuestaNl = $this->resultadoANatural($pregunta, $datos);
            $this->logModel->guardarConsulta($pregunta, $sqlSeguro, $resultadoResumido, $respuestaNl, null);

            return [
                'ok'           => true,
                'respuesta_nl' => $respuestaNl,
                'datos'        => $datos,
                'sql'          => $sqlSeguro,
            ];
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            $this->logModel->guardarConsulta($pregunta, $sqlGenerado, $resultadoResumido, $respuestaNl, $error);
            return ['ok' => false, 'error' => $error];
        }
    }

    private function generarSql(string $pregunta): ?string
    {
        $system = 'Eres un asistente que convierte preguntas en español sobre ventas y ordenes a una unica sentencia SQL (MySQL). '
            . "Usa solo las tablas y columnas del siguiente esquema.\n\n" . self::SCHEMA_REPORTES
            . "\n\nResponde UNICAMENTE con la sentencia SELECT, sin explicacion ni markdown. Una sola linea si es posible.";

        $respuesta = $this->ollama->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $pregunta],
        ]);

        $sql = trim($respuesta);
        if (preg_match('/```(?:\w*)\s*([\s\S]*?)```/', $sql, $m)) {
            $sql = trim($m[1]);
        }
        return $sql !== '' ? $sql : null;
    }

    private function ejecutarSql(string $sql): ?array
    {
        $limit = $this->queryTimeoutSeconds;
        set_time_limit($limit + 5);

        try {
            $db     = Database::connect();
            $result = $db->query($sql);
            if ($result === false) {
                return null;
            }
            return $result->getResultArray();
        } catch (\Throwable) {
            return null;
        }
    }

    private function resultadoANatural(string $pregunta, array $datos): string
    {
        $resumen = count($datos) > 20
            ? json_encode(array_slice($datos, 0, 20), JSON_UNESCAPED_UNICODE) . ' ... (' . count($datos) . ' filas en total)'
            : json_encode($datos, JSON_UNESCAPED_UNICODE);

        $system = 'Eres un asistente que resume resultados de consultas de ventas en lenguaje natural, en español. '
            . 'Responde de forma breve y clara, con numeros y datos concretos cuando aplique.';

        $user = "Pregunta del usuario: {$pregunta}\n\nResultado de la consulta (JSON):\n{$resumen}\n\nResponde en un parrafo corto en lenguaje natural.";

        return $this->ollama->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => $user],
        ]);
    }
}
