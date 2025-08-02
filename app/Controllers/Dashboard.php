<?php

namespace App\Controllers;

use App\Controllers\OrdenHelper;
use App\Models\OrdenModel;

class Dashboard extends BaseController
{
    protected $ordenHelper;
    protected $ordenModel;

    public function __construct()
    {
        $this->lang = \Config\Services::language();
        $this->lang->setLocale('es');
        $this->ordenHelper  = new OrdenHelper();
        $this->ordenModel   = new OrdenModel();
    }

    public function index(): string
    {
        return $this->render('pages/shared/dashboard/dashboard', [
            'title' => 'Dashboard',
            'assets'=> 'dashboard',
        ]);
    }

    public function indexMX(): string
    {
        return $this->render('pages/externo/dashboard/dashboard', [
            'title' => 'Dashboard MX',
            'assets'=> 'dashboard',
        ]);
    }

    private function getColoresEstatus()
    {
        return [
            'processing' => ['borderColor' => 'rgb(0, 242, 139)', 'backgroundColor' => 'rgba(0, 242, 139, 0.5)'],
            'pending'    => ['borderColor' => 'rgb(255, 99, 132)', 'backgroundColor' => 'rgba(255, 99, 132, 0.5)'],
            'cancelled'  => ['borderColor' => 'rgb(255, 159, 64)', 'backgroundColor' => 'rgba(255, 159, 64, 0.5)'],
            'failed'     => ['borderColor' => 'rgb(255, 205, 86)', 'backgroundColor' => 'rgba(255, 205, 86, 0.5)'],
            'completed'  => ['borderColor' => 'rgb(75, 192, 192)', 'backgroundColor' => 'rgba(75, 192, 192, 0.5)'],
            'on-hold'    => ['borderColor' => 'rgb(153, 102, 255)', 'backgroundColor' => 'rgba(153, 102, 255, 0.5)'],
            'refunded'   => ['borderColor' => 'rgb(201, 203, 207)', 'backgroundColor' => 'rgba(201, 203, 207, 0.5)'],
            'draft'      => ['borderColor' => 'rgb(100, 100, 100)', 'backgroundColor' => 'rgba(100, 100, 100, 0.5)'],
        ];
    }

    public function getGraphicsDataByMonth()
    {
        $anio       = $this->request->getGet('anio') ?? date('Y');
        $ordenes    = $this->ordenModel->getOrdenesFiltradas($anio . '-01-01', $anio . '-12-31');
        $ordenes    = $this->ordenHelper->setOrdenes($ordenes);

        // Inicializa meses y estatus
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = $meses;
        $estatusList = [];
        foreach ($ordenes as $orden) {
            $estatusList[$orden->estatus_orden] = true;
        }

        // Inicializa el arreglo de conteo
        $ordenesPorMesEstatus = [];
        foreach (array_keys($estatusList) as $estatus) {
            foreach (range(1, 12) as $mes) {
                $ordenesPorMesEstatus[$estatus][$mes] = 0;
            }
        }

        // Cuenta las órdenes por mes y estatus
        foreach ($ordenes as $orden) {
            $mes = (int)date('n', strtotime($orden->fecha_orden)); // 1-12
            $estatus = $orden->estatus_orden;
            $ordenesPorMesEstatus[$estatus][$mes]++;
        }

        // Prepara los datasets
        $colores = $this->getColoresEstatus();

        $datasets = [];
        foreach ($ordenesPorMesEstatus as $estatus => $mesesData) {
            $data = [];
            foreach (range(1, 12) as $mes) {
                $data[] = $mesesData[$mes];
            }
            $color = $colores[$estatus] ?? ['borderColor' => 'rgb(0,0,0)', 'backgroundColor' => 'rgba(0,0,0,0.2)'];
            $datasets[] = [
                'label' => $estatus,
                'data' => $data,
                'borderWidth' => 2,
                'borderColor' => $color['borderColor'],
                'backgroundColor' => $color['backgroundColor'],
            ];
        }

        $grafica_ordenes_por_mes = [
            'labels' => $labels,
            'datasets' => $datasets
        ];

        return $this->response->setJSON([
            'ok' => true,
            'grafica_ordenes_por_mes' => $grafica_ordenes_por_mes,
            'anio' => $anio,
        ]);
    }

    public function getGraphicsData()
    {
        $temporalidad       = $this->request->getGet('temporalidad');
        $tipo_temporalidad  = [
            'ultimos_7_dias',
            'ultimos_30_dias',
            'este_mes',
            'mes_filtrado'
        ];

        $fechaInicio = null;
        $fechaFin = null;

        if (in_array($temporalidad, $tipo_temporalidad)) {
            $hoy = new \DateTime();
            switch ($temporalidad) {
            case 'ultimos_7_dias':
                $fechaInicio = (clone $hoy)->modify('-6 days')->format('Y-m-d');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'ultimos_30_dias':
                $fechaInicio = (clone $hoy)->modify('-29 days')->format('Y-m-d');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'este_mes':
                $fechaInicio = $hoy->format('Y-m-01');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'mes_filtrado':
                $anioGet = $this->request->getGet('anio');
                $mesGet  = $this->request->getGet('mes');
                
                if (!$anioGet || !is_numeric($anioGet) || $anioGet < 2000 || $anioGet > date('Y') || !$mesGet || !is_numeric($mesGet) || $mesGet < 1 || $mesGet > 12) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'error' => 'Año ó Mes no válidos'
                    ]);
                }
                $fechaInicio    = $anioGet . '-' . str_pad($mesGet, 2, '0', STR_PAD_LEFT) . '-01';
                $fechaFin       = (new \DateTime($fechaInicio))->modify('last day of this month')->format('Y-m-d');
                break;
            }
        }else{
            return $this->response->setJSON([
                'ok' => false,
                'error' => 'Temporalidad no válida'
            ]);
        }

        if($temporalidad == 'mes_filtrado') {
            $ordenes = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        }else{
            $ordenes = $this->ordenModel->getOrdenesFiltradas($fechaInicio, $fechaFin);
        }

        $ordenes = $this->ordenHelper->setOrdenes($ordenes);

        $ordenesPorDiaEstatus = [];
        $labels = [];

        // Obtener rango de fechas
        $fechas = [];
        foreach ($ordenes as $orden) {
            $fechas[] = date('Y-m-d', strtotime($orden->fecha_orden));
        }
        if (!empty($fechas)) {
            $fechaMin = min($fechas);
            $fechaMax = max($fechas);

            $period = new \DatePeriod(
                new \DateTime($fechaMin),
                new \DateInterval('P1D'),
                (new \DateTime($fechaMax))->modify('+1 day')
            );

            foreach ($period as $dt) {
                $labels[] = $dt->format('M-j');
            }
        }

        // Inicializar $ordenesPorDiaEstatus con ceros para todos los días y estatus
        $estatusList = [];
        foreach ($ordenes as $orden) {
            $estatusList[$orden->estatus_orden] = true;
        }
        foreach (array_keys($estatusList) as $estatusOrden) {
            foreach ($labels as $fechaLabel) {
                $ordenesPorDiaEstatus[$estatusOrden][$fechaLabel] = 0;
            }
        }

        // Contar ordenes por día y estatus
        foreach ($ordenes as $orden) {
            $fecha = date('M-j', strtotime($orden->fecha_orden));
            $estatusOrden = $orden->estatus_orden;
            $ordenesPorDiaEstatus[$estatusOrden][$fecha]++;
        }
        
        // Preparar datasets para el gráfico
        $colores = $this->getColoresEstatus();
        $datasets = [];
        foreach ($ordenesPorDiaEstatus as $estatusLabel => $dias) {
            $data = [];
            foreach ($labels as $fecha) {
                $data[] = isset($dias[$fecha]) ? $dias[$fecha] : 0;
            }
            $color = $colores[$estatusLabel] ?? ['borderColor' => 'rgb(0,0,0)', 'backgroundColor' => 'rgba(0,0,0,0.2)'];
            $datasets[] = [
                'label' => $estatusLabel,
                'data' => $data,
                'borderWidth' => 2,
                'borderColor' => $color['borderColor'],
                'backgroundColor' => $color['backgroundColor'],
            ];
        }

        $grafica_ordenes_por_dia = [
            'labels' => $labels,
            'datasets' => $datasets
        ];

        return $this->response->setJSON([
            'ok'                        => true,
            'grafica_ordenes_por_dia'   => $grafica_ordenes_por_dia, 
            'temporalidad'              => $temporalidad,
        ]);
    }

    public function getGraphicsVentasData()
    {
        $temporalidad       = $this->request->getGet('temporalidad');
        $tipo_temporalidad  = [
            'ultimos_7_dias',
            'ultimos_30_dias',
            'este_mes',
            'mes_filtrado'
        ];

        $fechaInicio = null;
        $fechaFin = null;

        if (in_array($temporalidad, $tipo_temporalidad)) {
            $hoy = new \DateTime();
            switch ($temporalidad) {
            case 'ultimos_7_dias':
                $fechaInicio = (clone $hoy)->modify('-6 days')->format('Y-m-d');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'ultimos_30_dias':
                $fechaInicio = (clone $hoy)->modify('-29 days')->format('Y-m-d');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'este_mes':
                $fechaInicio = $hoy->format('Y-m-01');
                $fechaFin = $hoy->format('Y-m-d');
                break;
            case 'mes_filtrado':
                $anioGet = $this->request->getGet('anio');
                $mesGet  = $this->request->getGet('mes');
                
                if (!$anioGet || !is_numeric($anioGet) || $anioGet < 2000 || $anioGet > date('Y') || !$mesGet || !is_numeric($mesGet) || $mesGet < 1 || $mesGet > 12) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'error' => 'Año ó Mes no válidos'
                    ]);
                }
                $fechaInicio    = $anioGet . '-' . str_pad($mesGet, 2, '0', STR_PAD_LEFT) . '-01';
                $fechaFin       = (new \DateTime($fechaInicio))->modify('last day of this month')->format('Y-m-d');
                break;
            }
        }else{
            return $this->response->setJSON([
                'ok' => false,
                'error' => 'Temporalidad no válida'
            ]);
        }

        $ordenes = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        $ordenes = $this->ordenHelper->setOrdenes($ordenes);

        $ordenesPorDiaEstatus = [];
        $labels = [];

        // Obtener rango de fechas
        $fechas = [];
        foreach ($ordenes as $orden) {
            $fechas[] = date('Y-m-d', strtotime($orden->fecha_orden));
        }
        if (!empty($fechas)) {
            $fechaMin = min($fechas);
            $fechaMax = max($fechas);

            $period = new \DatePeriod(
                new \DateTime($fechaMin),
                new \DateInterval('P1D'),
                (new \DateTime($fechaMax))->modify('+1 day')
            );

            foreach ($period as $dt) {
                $labels[] = $dt->format('M-j');
            }
        }

        // Inicializar $ordenesPorDiaEstatus con ceros para todos los días y estatus
        $estatusList = [];
        foreach ($ordenes as $orden) {
            $estatusList[$orden->estatus_orden] = true;
        }
        foreach (array_keys($estatusList) as $estatusOrden) {
            foreach ($labels as $fechaLabel) {
                $ordenesPorDiaEstatus[$estatusOrden][$fechaLabel] = 0;
            }
        }

        // Contar ordenes por día y estatus
        foreach ($ordenes as $orden) {
            $fecha = date('M-j', strtotime($orden->fecha_orden));
            $estatusOrden = $orden->estatus_orden;
            $ordenesPorDiaEstatus[$estatusOrden][$fecha] += $orden->orden_total; // Sumar el total de la orden
        }
        
        // Preparar datasets para el gráfico
        $colores = $this->getColoresEstatus();
        $datasets = [];
        foreach ($ordenesPorDiaEstatus as $estatusLabel => $dias) {
            $data = [];
            foreach ($labels as $fecha) {
                $data[] = isset($dias[$fecha]) ? $dias[$fecha] : 0;
            }
            $color = $colores[$estatusLabel] ?? ['borderColor' => 'rgb(0,0,0)', 'backgroundColor' => 'rgba(0,0,0,0.2)'];
            $datasets[] = [
                'label' => $estatusLabel,
                'data' => $data,
                'borderWidth' => 2,
                'borderColor' => $color['borderColor'],
                'backgroundColor' => $color['backgroundColor'],
            ];
        }

        $grafica_ordenes_por_dia = [
            'labels' => $labels,
            'datasets' => $datasets
        ];

        return $this->response->setJSON([
            'ok'                        => true,
            'grafica_ventas_por_dia'   => $grafica_ordenes_por_dia, 
            'temporalidad'              => $temporalidad,
        ]);
    }

    public function getDashboardData()
    {
        $temporalidad    = $this->request->getGet('temporalidad');

        if($temporalidad) {
            $tipo_temporalidad = [
                'mes_filtrado'
            ];
            if (!in_array($temporalidad, $tipo_temporalidad)) {
                return $this->response->setJSON([
                    'ok' => false,
                    'error' => 'Temporalidad no válida'
                ]);
            }
            $anioGet = $this->request->getGet('anio');
            $mesGet  = $this->request->getGet('mes');
            
            if (!$anioGet || !is_numeric($anioGet) || $anioGet < 2000 || $anioGet > date('Y') || !$mesGet || !is_numeric($mesGet) || $mesGet < 1 || $mesGet > 12) {
                return $this->response->setJSON([
                    'ok' => false,
                    'error' => 'Año ó Mes no válidos'
                ]);
            }
            $fechaInicio    = $anioGet . '-' . str_pad($mesGet, 2, '0', STR_PAD_LEFT) . '-01';
            $fechaFin       = (new \DateTime($fechaInicio))->modify('last day of this month')->format('Y-m-d');

        }else{
            $fechaInicio    = $this->request->getGet('fecha_inicio');
            $fechaFin       = $this->request->getGet('fecha_fin');
        }

        $estatus        = $this->request->getGet('estatus');

        $ordenes = $this->ordenModel->getOrdenesFiltradas($fechaInicio, $fechaFin, $estatus);
        $ordenes = $this->ordenHelper->setOrdenes($ordenes);

        $ordenesProcesadas = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        $ordenesProcesadas = $this->ordenHelper->setOrdenes($ordenesProcesadas);


        $estatus_ordenes    = $this->initializeEstatusOrdenes();
        $total_ordenes      = $this->initializeEstatusOrdenes();
        $pasarelas_monto    = $this->initializePasarelasMonto();
        $costos_y_utilidades = $this->initializeCostosYUtilidades();

        $ut_final_orden_mas_50_prom_porcentaje = [];
        $ut_final_orden_sin_50_prom_porcentaje = [];

        // Arreglo para contar estados
        $estados_conteo = [];
        foreach ($ordenes as $orden) {
   
            // Contar estados
            if (
                ($orden->estatus_orden === 'completed' || $orden->estatus_orden === 'processing') &&
                isset($orden->envio_direccion->state) && !empty($orden->envio_direccion->state)
            ) {
                $estado = $orden->envio_direccion->state;
                if (!isset($estados_conteo[$estado])) {
                    $estados_conteo[$estado] = 0;
                }
                $estados_conteo[$estado]++;
            }
        }

        // Ordenes procesadas
        foreach ($ordenesProcesadas as $orden) {
            $this->normalizeOrdenData($orden);
            $this->updatePasarelasMonto($orden, $pasarelas_monto);
            $this->updateCostosYUtilidades($orden, $costos_y_utilidades, $ut_final_orden_mas_50_prom_porcentaje, $ut_final_orden_sin_50_prom_porcentaje);
        }
        // Ordenes totales
        foreach ($ordenes as $orden) {
            $this->normalizeOrdenData($orden);
            $this->updateEstatusOrdenes($orden, $estatus_ordenes, $total_ordenes);
        }

        $costos_y_utilidades['ut_final_orden_mas_50_prom_porcentaje'] = $this->calculatePromedio($ut_final_orden_mas_50_prom_porcentaje);
        $costos_y_utilidades['ut_final_orden_sin_50_prom_porcentaje'] = $this->calculatePromedio($ut_final_orden_sin_50_prom_porcentaje);
        $costos_y_utilidades['nota_de_credito'] =$costos_y_utilidades['orden_descuentos'] * 0.5;

        // Procesa respuesta
        $estatus_ordenes['on_hold']         = $estatus_ordenes['on-hold'];
        $total_ordenes['on_hold']           = $total_ordenes['on-hold'];
        $pasarelas_monto['ppcp_gateway']    = $pasarelas_monto['ppcp-gateway'];

        // Totales venta
        $estatus_ordenes['totalVenta']  = $estatus_ordenes['completed'] + $estatus_ordenes['processing'];
        $total_ordenes['totalVenta']    = $total_ordenes['completed'] + $total_ordenes['processing'];

        return $this->response->setJSON([
            'ok'                => true,
            'estatus_ordenes'   => $estatus_ordenes,
            'total_ordenes'     => $total_ordenes,
            'pasarelas_monto'   => $pasarelas_monto,
            'costos_y_utilidades' => $costos_y_utilidades,
            'estados_conteo'    => $estados_conteo, 
        ]);
    }

    private function initializeEstatusOrdenes(): array
    {
        return [
            'processing' => 0,
            'completed' => 0,
            'on-hold' => 0,
            'cancelled' => 0,
            'refunded' => 0,
            'failed' => 0,
            'pending' => 0,
            'draft' => 0,
            'total' => 0,
        ];
    }

    private function initializePasarelasMonto(): array
    {
        return [
            'openpay_cards' => 0,
            'ppcp-gateway' => 0,
        ];
    }

    private function initializeCostosYUtilidades(): array
    {
        return [
            'orden_descuentos' => 0,
            'paqueteria_costos' => 0,
            'total_desc_prod_env_50' => 0,
            'ut_orden_mas_50_prom' => 0,
            'ut_orden_sin_50_prom' => 0,
            'ut_final_orden_mas_50_prom_porcentaje' => 0,
            'ut_final_orden_sin_50_prom_porcentaje' => 0,
        ];
    }

    private function normalizeOrdenData(&$orden): void
    {
        $orden->orden_total         = $this->toFloat($orden->orden_total);
        $orden->orden_descuentos    = $this->toFloat($orden->orden_descuentos);
        $orden->real_envio_costo    = $this->toFloat($orden->real_envio_costo);
        $orden->utilidad["utilidad_orden_sin_impuestos_mas_50_prom"] = $this->toFloat($orden->utilidad["utilidad_orden_sin_impuestos_mas_50_prom"]);
    }

    private function toFloat($value): float
    {
        return is_string($value) ? floatval(str_replace(',', '', $value)) : (is_numeric($value) ? floatval($value) : 0.0);
    }

    private function updateEstatusOrdenes($orden, &$estatus_ordenes, &$total_ordenes): void
    {
        if (isset($estatus_ordenes[$orden->estatus_orden])) {
            $estatus_ordenes[$orden->estatus_orden]++;
            $estatus_ordenes["total"]++;
        }

        if (isset($total_ordenes[$orden->estatus_orden]) && is_numeric($orden->orden_total)) {
            $total_ordenes[$orden->estatus_orden] += $orden->orden_total;
            $total_ordenes["total"] += $orden->orden_total;
        }
    }

    private function updatePasarelasMonto($orden, &$pasarelas_monto): void
    {
        if (
            (isset($pasarelas_monto[$orden->pago_metodo]) && is_numeric($orden->orden_total)) &&
            ($orden->estatus_orden === 'completed' || $orden->estatus_orden === 'processing')
        ) {
            $pasarelas_monto[$orden->pago_metodo] += $orden->orden_total;
        }
    }

    private function updateCostosYUtilidades($orden, &$costos_y_utilidades, &$ut_final_orden_mas_50_prom_porcentaje, &$ut_final_orden_sin_50_prom_porcentaje): void
    {
        if (is_numeric($orden->orden_descuentos)) {
            $costos_y_utilidades["orden_descuentos"]        += $orden->orden_descuentos;
            $costos_y_utilidades["paqueteria_costos"]       += $orden->real_envio_costo;
            $costos_y_utilidades["ut_orden_mas_50_prom"]    += $orden->utilidad["utilidad_orden_sin_impuestos_mas_50_prom"];
            $costos_y_utilidades["ut_orden_sin_50_prom"]    += (float)$orden->utilidad["utilidad_orden_sin_impuestos"];

            if ($orden->utilidad["utilidad_final_sin_impuestos_con_promociones_porcentaje"] !== 'Pendiente') {
                $ut_final_orden_mas_50_prom_porcentaje[] = $orden->utilidad["utilidad_final_sin_impuestos_con_promociones_porcentaje"];
            }
            
            if ($orden->utilidad["utilidad_final_sin_impuestos_sin_promociones_porcentaje"] !== 'Pendiente') {
                $ut_final_orden_sin_50_prom_porcentaje[] = $orden->utilidad["utilidad_final_sin_impuestos_sin_promociones_porcentaje"];
            }
        }
    }

    private function calculatePromedio(array $values): string
    {
        if (empty($values)) {
            return '0.00';
        }

        $sum = array_sum(array_map('floatval', $values));
        $count = count($values);
        return number_format($sum / $count, 2);
    }
}