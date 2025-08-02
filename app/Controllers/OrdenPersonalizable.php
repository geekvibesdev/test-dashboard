<?php

namespace App\Controllers;

use App\Controllers\OrdenHelper;
use App\Controllers\HelperUtility;

use App\Models\OrdenPersonalizableModel;
use App\Models\OrdenModel;

class OrdenPersonalizable extends BaseController
{
    protected $ordenPersonalizableModel;
    protected $ordenModel;
    protected $ordenHelper;
    protected $costoEtiqueta;
    protected $costoFlorNatural;
    protected $costoFlorCajaSello;

    public function __construct()
    {
        $this->lang                         = \Config\Services::language();
        $this->lang                         ->setLocale('es');
        $this->ordenPersonalizableModel     = new OrdenPersonalizableModel();
        $this->ordenModel                   = new OrdenModel();
        $this->ordenHelper                  = new OrdenHelper();
        $this->costoEtiqueta                = env('costo_etiqueta');
        $this->costoFlorNatural             = env('costo_flor_natural');
        $this->costoTextoSobreCaja          = env('costo_texto_sobre_caja');
    }

    public function index(): string
    {
        $ordenPersonalizable = $this->ordenPersonalizableModel->getOrdenPersonalizable();

        return $this->render('pages/shared/personalizable/personalizable', [
            'title'  => 'Ordenes personalizables',
            'assets' => 'orden_personalizable',
            'ordenPersonalizable' => $ordenPersonalizable
        ]);
    }

    public function edit($id): string
    {
        $ordenPersonalizable = $this->ordenPersonalizableModel->getOrdenPersonalizable($id);
        if (!$ordenPersonalizable) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $ordenObject = $this->ordenModel->getOrdenesByOrden($ordenPersonalizable->wc_orden);
        $orden       = $this->ordenHelper->setOrdenes([$ordenObject]);
        if (!$ordenObject || !$orden[0]->productos_personalizados) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->render('pages/shared/personalizable/personalizable-edit', [
            'title'  => 'Orden personalizables',
            'assets' => 'orden_personalizable_edit',
            'orden'  => $orden[0],
            'orden_personalizable'  => $ordenPersonalizable,
        ]);
    }

    public function reporte():string
    {
        return $this->render('pages/shared/personalizable/personalizable-reporte', [
            'title'  => 'Personalizables reporte',
            'assets' => 'orden_personalizable_reporte',
        ]);
    }

    public function getReporte()
    {
        $ordenes = $this->ordenPersonalizableModel->getOrdenPersonalizableOrdenData();
        $ordenes = $this->ordenHelper->setOrdenes($ordenes);
        return     $this->response->setJSON([
            'ok' => true,
            'personalizables' => $this->procesarPersonalizados($ordenes),
        ]);      
    }
    
    public function editByWC($id): string
    {
        $ordenPersonalizable = $this->ordenPersonalizableModel->getOrdenPersonalizableByWcOrden($id);
        if (!$ordenPersonalizable) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $ordenObject = $this->ordenModel->getOrdenesByOrden($ordenPersonalizable->wc_orden);
        $orden       = $this->ordenHelper->setOrdenes([$ordenObject]);
        if (!$ordenObject || !$orden[0]->productos_personalizados) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->render('pages/shared/personalizable/personalizable-edit', [
            'title'  => 'Orden personalizables',
            'assets' => 'orden_personalizable_edit',
            'orden'  => $orden[0],
            'orden_personalizable'  => $ordenPersonalizable,
        ]);
    }

    public function create($wc_orden)
    {
        // Validación inicial de los campos requeridos
        if (!$wc_orden) {
            return false;
        }

        // Crear nuevo
        return $this->ordenPersonalizableModel->crearOrdenPersonalizable($wc_orden);
    }

    public function update()
    {
        $id             = $this->request->getPost('id');
        $wc_orden       = $this->request->getPost('wc_orden');
        $fecha_envio    = $this->request->getPost('fecha_envio');
        $fecha_entrega  = $this->request->getPost('fecha_entrega');
        $estatus        = $this->request->getPost('estatus');
        $notas          = $this->request->getPost('notas');

        // Validación inicial de los campos requeridos
        if (!$estatus) {
            return HelperUtility::redirectWithMessage("/ventas/personalizables/edit/$id", lang('Errors.missing_fields'));
        }

        // Actualizar
        if ($this->ordenPersonalizableModel->actualizarOrdenPersonalizable($wc_orden, $fecha_envio, $fecha_entrega, $estatus, $notas)) {
            return HelperUtility::redirectWithMessage("/ventas/personalizables/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/ventas/personalizables/edit/$id", lang('Errors.error_try_again_later'));
    }

    private function procesarPersonalizados($ordenes)
    {
        foreach ($ordenes as $orden) {
            
            $orden->personalizados_linea_1 = 0;
            $orden->personalizados_aplicar_flores_naturales = 0;
            $orden->personalizados_texto_sobre_caja = 0;

            foreach ($orden->productos as $producto) {
                // Procesar personalizados
                if (isset($producto->meta_data)) {
                    foreach ($producto->meta_data as $meta) {
                        if (isset($meta->key) && $meta->key == 'Linea 1') {
                            $orden->personalizados_linea_1 = $orden->personalizados_linea_1 == 0
                                ? $producto->quantity
                                : $orden->personalizados_linea_1 + $producto->quantity;
                        }
                        if (isset($meta->key) && $meta->key == 'Las aplicaciones de flores naturales en las etiquetas pueden variar de color y tamaño.') {
                            $orden->personalizados_aplicar_flores_naturales = $orden->personalizados_aplicar_flores_naturales == 0
                                ? $producto->quantity
                                : $orden->personalizados_aplicar_flores_naturales + $producto->quantity;
                        }
                        if (isset($meta->key) && $meta->key == 'Texto sobre caja de madera') {
                            $orden->personalizados_texto_sobre_caja = $orden->personalizados_texto_sobre_caja == 0
                                ? $producto->quantity
                                : $orden->personalizados_texto_sobre_caja + $producto->quantity;
                        }
                    }
                }
            }

            // Quitar data no necesaria
            unset($orden->direccion_envio_completa);
            unset($orden->envio_direccion);
            unset($orden->envio_tipo);
            unset($orden->facturacion);
            unset($orden->facturacion_datos);
            unset($orden->utilidad);
            unset($orden->orden_geek_merchandise);
            unset($orden->impuestos);
            unset($orden->orden_descuentos_titulos);
            unset($orden->productos);

            // Validar que los valores sean enteros y mayores a 0
            $orden->personalizados_linea_1                  = (is_numeric($orden->personalizados_linea_1) && $orden->personalizados_linea_1 > 0) ? (int)$orden->personalizados_linea_1 : 0;
            $orden->personalizados_aplicar_flores_naturales = (is_numeric($orden->personalizados_aplicar_flores_naturales) && $orden->personalizados_aplicar_flores_naturales > 0) ? (int)$orden->personalizados_aplicar_flores_naturales : 0;
            $orden->personalizados_texto_sobre_caja         = (is_numeric($orden->personalizados_texto_sobre_caja) && $orden->personalizados_texto_sobre_caja > 0) ? (int)$orden->personalizados_texto_sobre_caja : 0;

            // Resta del total de etiquetas normales las que tienen flor natural que tiene un costo distinto
            $orden->personalizados_linea_1 = $orden->personalizados_linea_1 - $orden->personalizados_aplicar_flores_naturales;

            // Calcular costos
            $orden->personalizados_linea_1_costos                   = $orden->personalizados_linea_1 * $this->costoEtiqueta;
            $orden->personalizados_aplicar_flores_naturales_costos  = $orden->personalizados_aplicar_flores_naturales * $this->costoFlorNatural;
            $orden->personalizados_texto_sobre_caja_costos          = $orden->personalizados_texto_sobre_caja * $this->costoTextoSobreCaja;
            $orden->personalizados_total_costo                      = $orden->personalizados_linea_1_costos +  $orden->personalizados_aplicar_flores_naturales_costos + $orden->personalizados_texto_sobre_caja_costos;
        }
        return $ordenes;
    }
}
