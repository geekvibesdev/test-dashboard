<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use App\Controllers\HelperUtility;

class Proveedor extends BaseController
{
    protected $proveedoresModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->proveedoresModel   = new ProveedorModel();
    }

    public function index(): string
    {
        $proveedores = $this->proveedoresModel->getItem();
        return $this->render('pages/admin/proveedor/proveedor', [
            'title'         => 'Proveedores',
            'proveedores'   => $proveedores
        ]);
    }

    public function newProveedor(): string
    {
        return $this->render('pages/admin/proveedor/proveedor-new', [
            'title'         => 'Proveedor Alta',
            'assets'        => 'proveedor',
        ]);
    }

    public function editProveedor($id): string
    {
        $proveedor = $this->proveedoresModel->getItem($id);
        if(!$proveedor) {
            Throw new \CodeIgniter\Exceptions\PageNotFoundException('Proveedor no encontrado');
        }

        return $this->render('pages/admin/proveedor/proveedor-edit', [
            'title'         => 'Editar Proveedor',
            'assets'        => 'proveedor',
            'proveedor'     => $proveedor
        ]);
    }

    public function createProveedor()
    {
        $razon_social               = $this->request->getPost('razon_social');
        $sitio_web                  = $this->request->getPost('sitio_web');
        $rfc                        = $this->request->getPost('rfc');
        $contacto_nombre            = $this->request->getPost('contacto_nombre');
        $contacto_email             = $this->request->getPost('contacto_email');
        $contacto_telefono          = $this->request->getPost('contacto_telefono');
        $fecha_inicio_operaciones   = $this->request->getPost('fecha_inicio_operaciones');
        $pago_clabe                 = $this->request->getPost('pago_clabe');
        $pago_banco                 = $this->request->getPost('pago_banco');
        $pago_cuenta                = $this->request->getPost('pago_cuenta');
        $oficina_calle_numero       = $this->request->getPost('oficina_calle_numero');
        $oficina_colonia            = $this->request->getPost('oficina_colonia');
        $oficina_ciudad             = $this->request->getPost('oficina_ciudad');
        $oficina_estado             = $this->request->getPost('oficina_estado');
        $oficina_codigo_postal      = $this->request->getPost('oficina_codigo_postal');
        $oficina_telefono           = $this->request->getPost('oficina_telefono');
        $oficina_observaciones      = $this->request->getPost('oficina_observaciones');
        $fiscal_calle_numero        = $this->request->getPost('fiscal_calle_numero');
        $fiscal_colonia             = $this->request->getPost('fiscal_colonia');
        $fiscal_ciudad              = $this->request->getPost('fiscal_ciudad');
        $fiscal_estado              = $this->request->getPost('fiscal_estado');
        $fiscal_codigo_postal       = $this->request->getPost('fiscal_codigo_postal');
        $fiscal_telefono            = $this->request->getPost('fiscal_telefono');
        $fiscal_observaciones       = $this->request->getPost('fiscal_observaciones');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $razon_social, $rfc, $contacto_nombre, $contacto_email, $contacto_telefono, $pago_clabe, $pago_banco, $pago_cuenta, $oficina_calle_numero, $oficina_colonia, $oficina_ciudad, $oficina_estado, $oficina_codigo_postal, $oficina_telefono, $fiscal_calle_numero, $fiscal_colonia, $fiscal_ciudad, $fiscal_estado, $fiscal_codigo_postal, $fiscal_telefono ])){
            return HelperUtility::redirectWithMessage('/settings/proveedor/new', lang('Errors.missing_fields'));
        }

        // Verificar si el proveedor ya existe
        if ($this->proveedoresModel->getByRFC($rfc)) {
            return HelperUtility::redirectWithMessage('/settings/proveedor/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo proveedor
        if ($this->proveedoresModel->createItem($razon_social, $sitio_web, $rfc, $contacto_nombre, $contacto_email, $contacto_telefono, $fecha_inicio_operaciones, $pago_clabe, $pago_banco, $pago_cuenta, $oficina_calle_numero, $oficina_colonia, $oficina_ciudad, $oficina_estado, $oficina_codigo_postal, $oficina_telefono, $oficina_observaciones, $fiscal_calle_numero, $fiscal_colonia, $fiscal_ciudad, $fiscal_estado, $fiscal_codigo_postal, $fiscal_telefono, $fiscal_observaciones)) {
            return HelperUtility::redirectWithMessage('/settings/proveedor/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/proveedor/new', lang('Errors.error_try_again_later'));
    }

    public function updateProveedor()
    {
        $id                         = $this->request->getPost('id');
        $razon_social               = $this->request->getPost('razon_social');
        $sitio_web                  = $this->request->getPost('sitio_web');
        $rfc                        = $this->request->getPost('rfc');
        $contacto_nombre            = $this->request->getPost('contacto_nombre');
        $contacto_email             = $this->request->getPost('contacto_email');
        $contacto_telefono          = $this->request->getPost('contacto_telefono');
        $fecha_inicio_operaciones   = $this->request->getPost('fecha_inicio_operaciones');
        $pago_clabe                 = $this->request->getPost('pago_clabe');
        $pago_banco                 = $this->request->getPost('pago_banco');
        $pago_cuenta                = $this->request->getPost('pago_cuenta');
        $oficina_calle_numero       = $this->request->getPost('oficina_calle_numero');
        $oficina_colonia            = $this->request->getPost('oficina_colonia');
        $oficina_ciudad             = $this->request->getPost('oficina_ciudad');
        $oficina_estado             = $this->request->getPost('oficina_estado');
        $oficina_codigo_postal      = $this->request->getPost('oficina_codigo_postal');
        $oficina_telefono           = $this->request->getPost('oficina_telefono');
        $oficina_observaciones      = $this->request->getPost('oficina_observaciones');
        $fiscal_calle_numero        = $this->request->getPost('fiscal_calle_numero');
        $fiscal_colonia             = $this->request->getPost('fiscal_colonia');
        $fiscal_ciudad              = $this->request->getPost('fiscal_ciudad');
        $fiscal_estado              = $this->request->getPost('fiscal_estado');
        $fiscal_codigo_postal       = $this->request->getPost('fiscal_codigo_postal');
        $fiscal_telefono            = $this->request->getPost('fiscal_telefono');
        $fiscal_observaciones       = $this->request->getPost('fiscal_observaciones');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $razon_social, $rfc, $contacto_nombre, $contacto_email, $contacto_telefono, $pago_clabe, $pago_banco, $pago_cuenta, $oficina_calle_numero, $oficina_colonia, $oficina_ciudad, $oficina_estado, $oficina_codigo_postal, $oficina_telefono, $fiscal_calle_numero, $fiscal_colonia, $fiscal_ciudad, $fiscal_estado, $fiscal_codigo_postal, $fiscal_telefono ])){
            return HelperUtility::redirectWithMessage('/settings/proveedor/edit/$id', lang('Errors.missing_fields'));
        }

        // Verificar si el proveedor existe
        if ($this->proveedoresModel->getByRFC($rfc) && $this->proveedoresModel->getByRFC($rfc)->id != $id) {
            return HelperUtility::redirectWithMessage("/settings/proveedor/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar proveedor
        $data = [  
            'razon_social'              => $razon_social,
            'sitio_web'                 => $sitio_web,
            'rfc'                       => $rfc,
            'contacto_nombre'           => $contacto_nombre,
            'contacto_email'            => $contacto_email,
            'contacto_telefono'         => $contacto_telefono,
            'fecha_inicio_operaciones'  => $fecha_inicio_operaciones,
            'pago_clabe'                => $pago_clabe,
            'pago_banco'                => $pago_banco,
            'pago_cuenta'               => $pago_cuenta,
            'oficina_calle_numero'      => $oficina_calle_numero,
            'oficina_colonia'           => $oficina_colonia,
            'oficina_ciudad'            => $oficina_ciudad,
            'oficina_estado'            => $oficina_estado,
            'oficina_codigo_postal'     => $oficina_codigo_postal,
            'oficina_telefono'          => $oficina_telefono,
            'oficina_observaciones'     => $oficina_observaciones,
            'fiscal_calle_numero'       => $fiscal_calle_numero,
            'fiscal_colonia'            => $fiscal_colonia,
            'fiscal_ciudad'             => $fiscal_ciudad,
            'fiscal_estado'             => $fiscal_estado,
            'fiscal_codigo_postal'      => $fiscal_codigo_postal,
            'fiscal_telefono'           => $fiscal_telefono,
            'fiscal_observaciones'      => $fiscal_observaciones
        ];

        if ($this->proveedoresModel->updateItem($id, $data)) {
            return HelperUtility::redirectWithMessage("/settings/proveedor/edit/$id", lang('Success.gral_update'), 'success');
        }
        return HelperUtility::redirectWithMessage("/settings/proveedor/edit/$id", lang('Errors.error_try_again_later'));
    }
}
