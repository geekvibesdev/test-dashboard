<?php

namespace App\Controllers;

use App\Models\GMLEnviosModel;
use App\Models\GMLRemitentesModel;
use App\Models\GMLDestinatariosModel;

class GMLHelper extends BaseController
{
    protected $gmlEnviosModel;
    protected $gmlRemitentesModel;
    protected $gmlDestinatariosModel;
   
    public function __construct()
    {
        $this->gmlEnviosModel       = new GMLEnviosModel();
        $this->gmlRemitentesModel   = new GMLRemitentesModel();
        $this->gmlDestinatariosModel = new GMLDestinatariosModel();
    }

    public function generateUUID()
    {
        return uniqid('gml_', true);
    }

    public function createGuiaId()
    {
        $fecha      = date('Ymd');
        $guiasHoy   = $this->gmlEnviosModel->where('DATE(fecha_creado)', date('Y-m-d'))->countAllResults();
        $contador   = $guiasHoy + 1;
        $contadorF  = str_pad($contador, 3, '0', STR_PAD_LEFT);
        $guia       = "GML{$fecha}{$contadorF}";

        return $guia;
    }
    
    public function createPersona( $nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias, $tipo = 'destinatario') // 'destinatario' o 'remitente'
    {
        // Validar que el tipo sea válido
        if (!in_array($tipo, ['destinatario', 'remitente'])) {
            return [
                'ok'    => false,
                'message' => 'Tipo inválido'
            ];
        }

        // Validar los datos de la persona
        $validation = $this->validarPersona($nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias);
        if (!$validation['ok']) {
            return $validation;
        }

        // Seleccionar el modelo
        $model      = ($tipo === 'remitente') ? $this->gmlRemitentesModel : $this->gmlDestinatariosModel;
        $persona    = $model->createItem($nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias);

        if ($persona) {
            return [
                'ok'        => true,
                'message'   => ucfirst($tipo) . ' creado exitosamente',
                'id'        => $persona
            ];
        } else {
            return [
                'ok'        => false,
                'message'     => 'Error al crear ' . $tipo
            ];
        }
    }

    public function validarPersona($nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias)
    {
        // Validar que los campos requeridos no estén vacíos
        if ( empty($nombre) || empty($apellidos) || empty($correo_electronico) || empty($calle_numero) || empty($colonia) || empty($ciudad) ||empty($estado) || empty($codigo_postal) || empty($telefono) || empty($referencias) ) {
            return [
                'ok'    => false,
                'message' => 'Todos los campos son obligatorios'
            ];
        }

        // Validar formato de correo electrónico
        if (!filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
            return [
                'ok'    => false,
                'message' => 'Correo electrónico inválido'
            ];
        }

        // Validar que codigo postal tenga 5 dígitos
        if (!preg_match('/^\d{5}$/', $codigo_postal)) {
            return [
                'ok'    => false,
                'message' => 'Código postal debe tener 5 dígitos'
            ];
        }

        // Validar que telefono tenga 10 dígitos
        if (!preg_match('/^\d{10}$/', $telefono)) {
            return [
                'ok'    => false,
                'message' => 'Teléfono debe tener 10 dígitos'
            ];
        }

        // Si todas las validaciones pasan retornar ok
        return [
            'ok'    => true
        ];
    }
}
