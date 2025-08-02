<?php

namespace App\Controllers;

use App\Controllers\OrdenHelper;
use App\Models\OrdenModel;

class Reporte extends BaseController
{

    protected $ordenHelper;
    protected $ordenModel;

    public function __construct()
    {
        $this->ordenHelper  = new OrdenHelper();
        $this->ordenModel   = new OrdenModel();
    }

    public function index(): string
    {
        return $this->render('pages/shared/reporte/reporte', [
            'title' => 'Ordenes',
            'assets'=> 'ordenes_reporte',
        ]);
    }

    public function indexMX(): string
    {
        return $this->render('pages/externo/reporte/reporte', [
            'title' => 'Ordenes',
            'assets'=> 'ordenes_reporte_mx',
        ]);
    }
    
    public function productosVendidos(): string
    {
        return $this->render('pages/shared/reporte/productos-vendidos', [
            'title' => 'Productos vendidos',
            'assets'=> 'productos_vendidos',
        ]);
    }

    public function gastosPaqueteria(): string
    {
        return $this->render('pages/shared/reporte/gastos-paqueteria', [
            'title' => 'Gastos paqueteria',
            'assets'=> 'gastos_paqueteria',
        ]);
    }

    public function reporteVentas(): string
    {
        return $this->render('pages/shared/reporte/reporte-de-ventas', [
            'title' => 'Reporte de ventas',
            'assets'=> 'reporte_ventas',
        ]);
    }
    
    public function getProductosVendidos()
    {
        $fechaInicio        = $this->request->getGet('fecha_inicio');
        $fechaFin           = $this->request->getGet('fecha_fin');
        $temporalidad       = $this->request->getGet('temporalidad');
        $tipo_temporalidad  = [ 'mes_filtrado' ];

        if($temporalidad){
            if (in_array($temporalidad, $tipo_temporalidad)) {
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
                return $this->response->setJSON([
                    'ok' => false,
                    'error' => 'Temporalidad no válida'
                ]);
            }
        }

        $ordenes        = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        $ordenes        = $this->ordenHelper->setOrdenes($ordenes);

        // Recorre las ordenes y agrupa los productos
        $productosVendidos = [];
        foreach ($ordenes as $orden) {
            if (isset($orden->productos) && is_array($orden->productos)) {
                foreach ($orden->productos as $producto) {
                    $sku = $producto->sku;
                    if (!isset($productosVendidos[$sku])) {
                        $productosVendidos[$sku] = [
                            'sku' => $producto->sku,
                            'producto' => $producto->name,
                            'cantidad' => 0,
                            'ordenes'  => 0,
                        ];
                    }
                    $productosVendidos[$sku]['cantidad'] += $producto->quantity;
                    $productosVendidos[$sku]['ordenes']++;
                }
            }
        }
        // Convierte el array a un formato adecuado para la respuesta
        $productosVendidos = array_values($productosVendidos);

        // Prepara el resultado para la respuesta
        $result = [];
        foreach ($productosVendidos as $producto) {
            $result[] = [
                'sku'        => $producto['sku'],
                'producto'   => $producto['producto'],
                'cantidad'   => $producto['cantidad'],
                'ordenes'    => $producto['ordenes'],
            ];
        }
        // Retorna la respuesta JSON
        return $this->response->setJSON([
            'ok'        => true,
            'productos' => $result,
        ]);
    }

    public function getVentasPorDia()
    {
        $fechaInicio        = $this->request->getGet('fecha_inicio');
        $fechaFin           = $this->request->getGet('fecha_fin');
        $temporalidad       = $this->request->getGet('temporalidad');
        $tipo_temporalidad  = [ 'mes_filtrado' ];

        if($temporalidad){
            if (in_array($temporalidad, $tipo_temporalidad)) {
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
                return $this->response->setJSON([
                    'ok' => false,
                    'error' => 'Temporalidad no válida'
                ]);
            }
        }

        $ordenes        = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        $ordenes        = $this->ordenHelper->setOrdenes($ordenes);

        // Recorre las ordenes y agrupa por fecha
        $ventasPorDia = [];
        foreach ($ordenes as $orden) {
            if (isset($orden->fecha_creado)) {
                $fecha = date('Y-m-d', strtotime($orden->fecha_creado));
                if (!isset($ventasPorDia[$fecha])) {
                    $ventasPorDia[$fecha] = [
                        'fecha' => $fecha,
                        'total' => 0,
                        'cantidad' => 0,
                    ];
                }
                $ventasPorDia[$fecha]['total'] += $orden->orden_total;
                $ventasPorDia[$fecha]['cantidad']++;
            }
        }
        // Convierte el array a un formato adecuado para la respuesta
        $ventasPorDia = array_values($ventasPorDia);

        // Prepara el resultado para la respuesta
        return $this->response->setJSON([
            'ok' => true,
            'ventas_por_dia' => $ventasPorDia,
        ]);
    }

    public function getGastosPaqueria()
    {
        $fechaInicio    = $this->request->getGet('fecha_inicio');
        $fechaFin       = $this->request->getGet('fecha_fin');
        $ordenes        = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        $ordenes        = $this->ordenHelper->setOrdenes($ordenes);

        // Recorre las ordenes y agrupa las paqueterias
        $paqueteriasUtilizadas = [];
        foreach ($ordenes as $orden) {
            if (isset($orden->real_envio_costo) ) {
                $idPaqueteria = $orden->real_envio_paqueteria;
                if (!isset($paqueteriasUtilizadas[$idPaqueteria])) {
                    $paqueteriasUtilizadas[$idPaqueteria] = [
                        'real_envio_paqueteria'         => $orden->real_envio_paqueteria,
                        'real_envio_paqueteria_nombre'  => $orden->real_envio_paqueteria_nombre,
                        'real_envio_costo'              => 0,
                        'paqueteria_ordenes'            => 0,
                    ];
                }
                $paqueteriasUtilizadas[$idPaqueteria]['paqueteria_ordenes'] ++;
                $paqueteriasUtilizadas[$idPaqueteria]['real_envio_costo'] += $orden->real_envio_costo;
            }
        }
        // Convierte el array a un formato adecuado para la respuesta
        $paqueteriasUtilizadas = array_values($paqueteriasUtilizadas);

        // Prepara el resultado para la respuesta
        $result         = [];
        $resultConteo   = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Gasto por Paquetería',
                    'data'  => [],
                ]
            ]
        ];

        foreach ($paqueteriasUtilizadas as $paqueteria) {
            $promedio = $paqueteria['paqueteria_ordenes'] > 0
            ? $paqueteria['real_envio_costo'] / $paqueteria['paqueteria_ordenes']
            : 0;
            $result[] = [
                'id'            => $paqueteria['real_envio_paqueteria'],
                'paqueteria'    => $paqueteria['real_envio_paqueteria_nombre'],
                'ordenes'       => $paqueteria['paqueteria_ordenes'],
                'gastos'        => $paqueteria['real_envio_costo'],
                'promedio'      => $promedio,
            ];
            $resultConteo['labels'][] = $paqueteria['real_envio_paqueteria_nombre'];
            $resultConteo['datasets'][0]['data'][] = $paqueteria['real_envio_costo'];
        }
        // Retorna la respuesta JSON
        return $this->response->setJSON([
            'ok'                    => true,
            'paqueterias'           => $result,
            'paqueterias_graphic'   => $resultConteo,
        ]);
    }
}
