<?php

namespace App\Controllers;

use App\Controllers\GMLHelper;

use App\Models\OrdenModel;
use App\Models\GMLEnviosModel;
use App\Models\GMLRemitentesModel;
use App\Models\GMLDestinatariosModel;

class GMLEnvios extends BaseController
{
    protected $ordenModel;
    protected $gmlEnviosModel;
    protected $gmlRemitentesModel;
    protected $gmlDestinatariosModel;
    protected $gmlEnviosHelper;
    protected $gvqr_url;
   
    public function __construct()
    {
        $this->ordenModel           = new OrdenModel();
        $this->gmlEnviosModel       = new GMLEnviosModel();
        $this->gmlRemitentesModel   = new GMLRemitentesModel();
        $this->gmlDestinatariosModel = new GMLDestinatariosModel();
        $this->gmlEnviosHelper      = new GMLHelper();
        $this->gvqr_url             = env('gvqr_url');
    }

    public function guias()
    {
        return $this->render('pages/shared/gml/guia/guias', [
            'title' => 'GML Guias',
            'assets'=> 'gml_guias',
            'guias' => $this->gmlEnviosModel->getItemsWithRemitDest(),
        ]);
    }

    public function guiaCrear()
    {
        return $this->render('pages/shared/gml/guia/guia-crear', [
            'title' => 'Crear guia',
            'assets'=> 'gml_guias_new',
            'remitentes'    => $this->gmlRemitentesModel->getItem(),
            'destinatarios' => $this->gmlDestinatariosModel->getItem(),
            'csrfName'      => csrf_token(),    
            'csrfHash'      => csrf_hash(),
        ]);
    }
   
    public function guiasInterior($guia)
    {
        $guiaObj = $this->gmlEnviosModel->getItemByGuia($guia);
        if (!$guiaObj) {
            Throw new \CodeIgniter\Exceptions\PageNotFoundException('Guia no encontrada');
        }

        return $this->render('pages/shared/gml/guia/guia-interior', [
            'title'         => $guia,
            'guia'          => $guiaObj,
            'remitente'     => $this->gmlRemitentesModel->getItem($guiaObj->remitente),
            'destinatario'  => $this->gmlDestinatariosModel->getItem($guiaObj->destinatario),
            'qr'            => $this->gvqr_url
        ]);
    }

    public function guiaImprimir($guia)
    {
        $guiaObj = $this->gmlEnviosModel->getItemByGuia($guia);
        if (!$guiaObj) {
            Throw new \CodeIgniter\Exceptions\PageNotFoundException('Guia no encontrada');
        }

        return $this->renderHeadOnly('pages/shared/gml/guia/guia-imprimir', [
            'title'         => $guia,
            'guia'         => $guiaObj,
            'remitente'    => $this->gmlRemitentesModel->getItem($guiaObj->remitente),
            'destinatario' => $this->gmlDestinatariosModel->getItem($guiaObj->destinatario),
            'qr'   
        ]);
    }

    public function guiaCreate()
    {
        $remitente          = $this->request->getPost('remitente');
        $nombre             = $this->request->getPost('nombre');
        $apellidos          = $this->request->getPost('apellidos');
        $correo_electronico = $this->request->getPost('correo_electronico');
        $telefono           = $this->request->getPost('telefono');
        $calle_numero       = $this->request->getPost('calle_numero');
        $colonia            = $this->request->getPost('colonia');
        $ciudad             = $this->request->getPost('ciudad');
        $estado             = $this->request->getPost('estado');
        $codigo_postal      = $this->request->getPost('codigo_postal');
        $referencias        = $this->request->getPost('referencias');
        $largo_cm           = $this->request->getPost('largo_cm');
        $ancho_cm           = $this->request->getPost('ancho_cm');
        $alto_cm            = $this->request->getPost('alto_cm');
        $peso_kg            = $this->request->getPost('peso_kg');
        $wc_orden           = $this->request->getPost('wc_orden');
        $tipo_envio         = $this->request->getPost('tipo_envio');
        $entrega_estimada   = $this->request->getPost('entrega_estimada');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $remitente, $nombre, $apellidos, $correo_electronico, $telefono, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $referencias, $largo_cm, $ancho_cm, $alto_cm, $peso_kg, $wc_orden, $tipo_envio, $entrega_estimada])){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Campos faltantes'
            ]);
        }

        // Validar que la orden existe
        $orden = $this->ordenModel->getOrdenesByOrden($wc_orden);
        if(!$orden){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Orden inválida'
            ]);
        }

        // Validar que remitente exista
        $remitente_obj = $this->gmlRemitentesModel->getItem($remitente);
        if(!$remitente_obj){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Remitente inválido'
            ]);
        }

        //Crear destinatario
        $destinatario = $this->gmlEnviosHelper->createPersona( $nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias, 'destinatario');
        if(!$destinatario['ok']) {
            return $this->respondWithCsrf($destinatario);
        }

        $data = [
            'wc_orden'              => $wc_orden, 
            'remitente'             => $remitente, 
            'destinatario'          => $destinatario['id'], 
            'largo_cm'              => $largo_cm,
            'ancho_cm'              => $ancho_cm,
            'alto_cm'               => $alto_cm,
            'peso_kg'               => $peso_kg,
            'tipo_envio'            => $tipo_envio,
            'entrega_estimada'      => $entrega_estimada,
            'historico'             => json_encode(
                array(
                    array(
                        'fecha'     => date('Y-m-d'),
                        'hora'      => date('H:i:s'),
                        'nota'      => 'Guia creada',
                    )
                )
            ),
            'uid'                   => $this->gmlEnviosHelper->generateUUID(),
            'guia_fecha_creada'     => date('Y-m-d H:i:s'),
            'guia_fecha_recolectada'=> null,
            'guia_fecha_en_transito'=> null,
            'guia_fecha_entregada'  => null,
            'firma'                 => null,
            'guia'                  => $this->gmlEnviosHelper->createGuiaId()
        ];

        // Crear guia
        $guia = $this->gmlEnviosModel->createItem($data);
        if($guia){
            return $this->respondWithCsrf([
                'ok'        => true,
                'guia'      => $data['guia'],
                'uid'       => $data['uid'],
            ]);
        }
    }

    public function getGuias()
    {
        $guias = $this->gmlEnviosModel->getItemsWithRemitDest();

        return     $this->response->setJSON([
            'ok'        => true,
            'guias'     => $guias,
        ]);   
    }

    public function getGuiasFiltro()
    {
        $fechaInicio    = $this->request->getGet('fecha_inicio');
        $fechaFin       = $this->request->getGet('fecha_fin');
        $estatus        = $this->request->getGet('estatus');

        $guias = $this->gmlEnviosModel->getItemsWithRemitDestFiltro($fechaInicio, $fechaFin, $estatus);

        return $this->response->setJSON([
            'ok'        => true,
            'guias'   => $guias,
        ]);
    }

    public function getGuiasUid($uid)
    {
        $guia = $this->gmlEnviosModel->getItemsByUid($uid);

        if(!$guia){
            return     $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Uid inválido',
            ]);   
        }

        return     $this->response->setJSON([
            'ok'        => true,
            'guia'      => $guia,
        ]);   
    }

    public function getDashboardData()
    {
        $fechaInicio    = $this->request->getGet('fecha_inicio');
        $fechaFin       = $this->request->getGet('fecha_fin');
        $estatus        = $this->request->getGet('estatus');
        $envios         = $this->gmlEnviosModel->getItemsWithRemitDestFiltro($fechaInicio, $fechaFin, $estatus);
        $estatus_envios = $this->initializeEstatusEnvios();

        foreach ($envios as $envio) {
            $this->updateEstatusEnvios($envio, $estatus_envios);
        }

        return $this->response->setJSON([
            'ok'                => true,
            'estatus_envios'    => $estatus_envios,
        ]);
    }

    private function initializeEstatusEnvios(): array
    {
        return [
            'creada'        => 0,
            'recolectada'   => 0,
            'en_transito'   => 0,
            'entregada'     => 0,
            'cancelada'     => 0,
            'total'         => 0,
        ];
    }

    private function updateEstatusEnvios($envio, &$estatus_envios): void
    {
        if (isset($estatus_envios[$envio->estatus])) {
            $estatus_envios[$envio->estatus]++;
            $estatus_envios["total"]++;
        }
    }
}
