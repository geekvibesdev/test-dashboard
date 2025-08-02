<?php

namespace App\Controllers;

use App\Models\OrdenModel;
use App\Models\PromocionModel;
use App\Models\PaqueteriaModel;
use App\Models\OrdenCostoRealModel;
use App\Controllers\WooCommerce;
use App\Controllers\OrdenHelper;

class Orden extends BaseController
{

    protected $ordenModel;
    protected $woocommerce;
    protected $promocionModel;
    protected $paqueteriaModel;
    protected $ordenCostoRealModel;
    protected $ordenHelper;
    protected $lang;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->ordenModel       = new OrdenModel();
        $this->woocommerce      = new WooCommerce();
        $this->promocionModel   = new PromocionModel();
        $this->paqueteriaModel  = new PaqueteriaModel();
        $this->ordenCostoRealModel = new OrdenCostoRealModel();
        $this->ordenHelper      = new OrdenHelper();
        if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
            ob_start('ob_gzhandler');
        } else {
            ob_start();
        }
    }

    public function index(): string
    {
        return $this->render('pages/shared/orden/orden', [
            'title'         => 'Ordenes',
            'assets'        => 'orden',
        ]);
    }
    
    public function interiorOrden($id): string
    {
        $orden = $this->getOrden($id);
        if (!$orden) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->render('pages/shared/orden/orden-interior', [
            'title'         => '#' . $id,
            'assets'        => 'orden_interior',
            'orden'         =>  $orden,
            'promociones'   => $this->promocionModel->getPromociones(),
            'paqueterias'   => $this->paqueteriaModel->getPaqueterias(),
            'csrfName'      => csrf_token(),    
            'csrfHash'      => csrf_hash(),
            'facturacion_url'   => env('facturacion_url'),
            'truedesk_url'   => env('truedesk_url'),
        ]);
    }
   
    public function interiorOrdenMX($id): string
    {
        $orden = $this->getOrden($id);
        if (!$orden) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->render('pages/externo/orden/orden-interior', [
            'title'         => '#' . $id,
            'orden'         =>  $orden,
        ]);
    }
    
    public function imprimirOrden($id): string
    {
        $orden = $this->getOrden($id);
        if (!$orden) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->renderHeadOnly('pages/shared/orden/orden-imprimir-orden', [
            'title'         => '#' . $id,
            'orden'         =>  $orden,
        ]);
    }

    public function getOrden($id)
    {
        $orden = $this->ordenModel->getOrdenesByOrden($id);

        if (!$orden) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $orden_final = $this->ordenHelper->setOrdenes([$orden]);
        return $orden_final[0];
    }

    public function getOrdenes()
    {
        $ordenes = $this->ordenModel->getOrdenes();
        return     $this->response->setJSON([
            'ok'        => true,
            'ordenes'   => $this->ordenHelper->setOrdenes($ordenes),
        ]);   
    }

    public function getOrdenesFiltro()
    {

        $fechaInicio        = $this->request->getGet('fecha_inicio');
        $fechaFin           = $this->request->getGet('fecha_fin');
        $estatus            = $this->request->getGet('estatus');
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
            $ordenes = $this->ordenModel->getOrdenesFiltradasProcesadas($fechaInicio, $fechaFin);
        }else{

            $ordenes = $this->ordenModel->getOrdenesFiltradas($fechaInicio, $fechaFin, $estatus);
        }

        return $this->response->setJSON([
            'ok'        => true,
            'ordenes'   => $this->ordenHelper->setOrdenes($ordenes),
        ]);
    }

    public function ordenActualizarCostos()
    {
        $real_envio_paqueteria      = $this->request->getPost('real_envio_paqueteria');
        $real_envio_guia            = $this->request->getPost('real_envio_guia');
        $real_envio_costo           = $this->request->getPost('real_envio_costo');
        $promocion                  = $this->request->getPost('promocion');
        $promocion_tipo             = $this->request->getPost('promocion_tipo');
        $orden                      = $this->request->getPost('orden_id');

        // Obtener la orden
        $ordenObject = $this->ordenModel->getOrdenesByOrden($orden);
        if(!$ordenObject){
            return HelperUtility::redirectWithMessage("ventas/ordenes/$orden", lang('Errors.error_try_again_later'));
        }
        
        if($ordenObject->cot_envio_total == 0 && $promocion == null){
            return HelperUtility::redirectWithMessage("ventas/ordenes/$orden", 'La orden tiene un envío con costo 0, selecciona la promoción correspondiente');
        }

        // Validación inicial de los campos requeridos
        if (!$real_envio_paqueteria || !$real_envio_guia || !$real_envio_costo || !$orden) {
            return HelperUtility::redirectWithMessage("ventas/ordenes/$orden", lang('Errors.missing_fields'));
        }

        //Crea la nota en WooCommerce
        if($ordenObject->real_envio_guia === null){
            $paqueteria = $this->paqueteriaModel->getPaqueterias($real_envio_paqueteria);
            $mensaje    = "El pedido fue enviado por la paquetería $paqueteria->nombre con el número de guía: $real_envio_guia";
            $this->woocommerce->crearNota( $ordenObject->orden, $mensaje );
        }

        // Actualiza la orden en la base de datos
        if ($this->ordenCostoRealModel->actualizarOrdenCostoReal($orden, $promocion == 'on' ? 1 : 0, $promocion == 'on' ? $promocion_tipo : null, $real_envio_paqueteria, $real_envio_guia, $real_envio_costo)) {
            return HelperUtility::redirectWithMessage("ventas/ordenes/$orden", lang('Success.gral_update'), 'success');
        }

        // Si la actualización falla, redirige con un mensaje de error
        return HelperUtility::redirectWithMessage("ventas/ordenes/$orden", lang('Errors.error_try_again_later'));
    }

    public function getOrdenAjax($id)
    {
        $orden = $this->ordenModel->getOrdenesByOrden($id);

        if (!$orden) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Orden inválida',

            ]);
        }

        $orden_final = $this->ordenHelper->setOrdenes([$orden]);
        return $this->respondWithCsrf([
            'ok'        => true,
            'orden'     => $orden_final[0],
        ]);
    }
}
