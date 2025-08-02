<?php

namespace App\Controllers;

use App\Controllers\HelperUtility;
use App\Controllers\GMLHelper;

use App\Models\GMLRemitentesModel;

class GMLRemitentes extends BaseController
{
    protected $gmlRemitentesModel;
    protected $gmlEnviosHelper;
   
    public function __construct()
    {
        $this->gmlRemitentesModel   = new GMLRemitentesModel();
        $this->gmlEnviosHelper   = new GMLHelper();
    }

    public function settingsRemitentes()
    {
        return $this->render('pages/admin/gml/gml-settings', [
            'title' => "GML Remitentes",
            'assets'=> 'gml_remitentes',
            'remitentes' => $this->gmlRemitentesModel->getItem()
        ]);
    }

    public function settingsRemitentesNew()
    {

        return $this->render('pages/admin/gml/gml-settings-new', [
            'title' => "Crear Remitente",
            'assets'=> 'gml_remitentes',
            'remitentes' => $this->gmlRemitentesModel->getItem()
        ]);
    }

    public function settingsRemitentesEdit($id)
    {
        $remitente = $this->gmlRemitentesModel->getItem($id);
        if (!$remitente) {
            Throw new \CodeIgniter\Exceptions\PageNotFoundException('Remitente no encontrado');
        }

        return   view('shared/header',                      ['title'     => 'Actualizar Remitente'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/gml/gml-settings-edit',  ['remitente' => $remitente])
                .view('shared/footer');
    }

    public function settingsRemitentesCreate()
    {
        $nombre                 = $this->request->getPost('nombre');
        $apellidos              = $this->request->getPost('apellidos');
        $correo_electronico     = $this->request->getPost('correo_electronico');
        $calle_numero           = $this->request->getPost('calle_numero');
        $colonia                = $this->request->getPost('colonia');
        $ciudad                 = $this->request->getPost('ciudad');
        $estado                 = $this->request->getPost('estado');
        $codigo_postal          = $this->request->getPost('codigo_postal');
        $telefono               = $this->request->getPost('telefono');
        $referencias            = $this->request->getPost('referencias');

        $response = $this->gmlEnviosHelper->createPersona( $nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias, 'remitente');

        if($response['ok']) {
            return HelperUtility::redirectWithMessage('/settings/gml/remitentes/new', $response['message'], 'success');
        } else {
            return HelperUtility::redirectWithMessage('/settings/gml/remitentes/new', $response['message']);
        }
    }

    public function settingsRemitentesUpdate()
    {
        $id                     = $this->request->getPost('id');
        $nombre                 = $this->request->getPost('nombre');
        $apellidos              = $this->request->getPost('apellidos');
        $correo_electronico     = $this->request->getPost('correo_electronico');
        $calle_numero           = $this->request->getPost('calle_numero');
        $colonia                = $this->request->getPost('colonia');
        $ciudad                 = $this->request->getPost('ciudad');
        $estado                 = $this->request->getPost('estado');
        $codigo_postal          = $this->request->getPost('codigo_postal');
        $telefono               = $this->request->getPost('telefono');
        $referencias            = $this->request->getPost('referencias');

        // Validar datos de la persona
        $validation = $this->gmlEnviosHelper->validarPersona($nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias);
        if (!$validation['ok']) {
            return HelperUtility::redirectWithMessage('/settings/gml/remitentes/edit/' . $id, $validation['error']);
        }

        // Actualizar el remitente
        $data = [
            'nombre'                => $nombre,
            'apellidos'             => $apellidos,
            'correo_electronico'    => $correo_electronico,
            'calle_numero'          => $calle_numero,
            'colonia'               => $colonia,
            'ciudad'                => $ciudad,
            'estado'                => $estado,
            'codigo_postal'         => $codigo_postal,
            'telefono'              => $telefono,
            'referencias'           => $referencias
        ];

        $response = $this->gmlRemitentesModel->updateItem($id, $data);

        if ($response) {
            return HelperUtility::redirectWithMessage('/settings/gml/remitentes/edit/' . $id, 'Remitente actualizado exitosamente', 'success');
        } else {
            return HelperUtility::redirectWithMessage('/settings/gml/remitentes/edit/' . $id, 'Error al actualizar remitente');
        }
    }
}
