<?php

namespace App\Models;

use CodeIgniter\Model;

class AgenteReportesLogModel extends Model
{
    protected $table         = 'agente_reportes_log';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_creado';
    protected $updatedField  = null;
    protected $allowedFields = [
        'pregunta',
        'sql_generado',
        'resultado_resumido',
        'respuesta_nl',
        'error',
    ];

    public function guardarConsulta(
        string $pregunta,
        ?string $sqlGenerado,
        ?string $resultadoResumido,
        ?string $respuestaNl,
        ?string $error = null
    ): int|false {
        return $this->insert([
            'pregunta'            => $pregunta,
            'sql_generado'        => $sqlGenerado,
            'resultado_resumido'  => $resultadoResumido,
            'respuesta_nl'        => $respuestaNl,
            'error'               => $error,
        ]);
    }
}
