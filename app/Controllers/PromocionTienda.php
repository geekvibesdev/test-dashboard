<?php

namespace App\Controllers;

use App\Models\PromocionTiendaModel;
use App\Controllers\HelperUtility;

class PromocionTienda extends BaseController
{
    protected $promocionTiendaModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->promocionTiendaModel   = new PromocionTiendaModel();
    }

    public function calendar(): string
    {
        $promocionesTienda = $this->promocionTiendaModel->getPromocionesTienda();

        // Convertir promociones a formato para calendario
        $events = [];
        foreach ($promocionesTienda as $promocion) {
            $events[] = [
                'id'            => $promocion->id,
                'title'         => $promocion->titulo,
                'start'         => $promocion->fecha_inicio,
                'end'           => $promocion->fecha_fin,
                'descuento'     => $promocion->descuento,
                'portafolio'    => $promocion->portafolio,
                'titulo_descuento_wc' => $promocion->titulo_descuento_wc,
            ];
        }
        
        return $this->render('pages/admin/promocion_tienda/promocion-tienda-calendar', [
            'title' => 'Promociones en tienda',
            'assets'=> 'promociones_tienda',
            'events'=> $events
        ]);
    }

    public function index(): string
    {
        $promocionesTienda = $this->promocionTiendaModel->getPromocionesTienda();
        return $this->render('pages/admin/promocion_tienda/promocion-tienda', [
            'title'  => 'Promociones en tienda',
            'assets' => 'admin_promociones_tienda_envios',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
            'promocionesTienda' => $promocionesTienda
        ]);
    }

    public function newPromocionTienda(): string
    {
        return $this->render('pages/admin/promocion_tienda/promocion-new', [
            'title'  => 'Nueva Promocion',
            'assets' => 'admin_promociones_tienda_envios_new',
        ]);
    }

    public function editPromocionTienda($id): string
    {
        $promocion = $this->promocionTiendaModel->getPromocionesTienda($id);
        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/promocion_tienda/promocion-edit', [
            'title'  => 'Editar Promocion',
            'assets' => 'admin_promociones_tienda_envios_edit',
            'promocion' => $promocion,
        ]);
    }

    public function createPromocionTienda()
    {
        $titulo         = $this->request->getPost('titulo');
        $fecha_inicio   = $this->request->getPost('fecha_inicio');
        $fecha_fin      = $this->request->getPost('fecha_fin');
        $descuento      = $this->request->getPost('descuento');
        $portafolio     = $this->request->getPost('portafolio');
        $titulo_descuento_wc = $this->request->getPost('titulo_descuento_wc');

        // Validación inicial de los campos requeridos
        if ( !$titulo || !$fecha_inicio || !$fecha_fin || !$descuento || !$portafolio || !$titulo_descuento_wc) {
            return HelperUtility::redirectWithMessage('/settings/promociones/new', lang('Errors.missing_fields'));
        }

        // Crear nuevo promocion
        if ($this->promocionTiendaModel->createPromocionTienda($titulo, $fecha_inicio, $fecha_fin, $descuento, $portafolio, $titulo_descuento_wc)) {
            return HelperUtility::redirectWithMessage('/settings/promociones/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/promociones/new', lang('Errors.error_try_again_later'));
    }

    public function updatePromocionTienda()
    {
        $id             = $this->request->getPost('id');
        $titulo         = $this->request->getPost('titulo');
        $fecha_inicio   = $this->request->getPost('fecha_inicio');
        $fecha_fin      = $this->request->getPost('fecha_fin');
        $descuento      = $this->request->getPost('descuento');
        $portafolio     = $this->request->getPost('portafolio');
        $titulo_descuento_wc = $this->request->getPost('titulo_descuento_wc');

        // Validación inicial de los campos requeridos
        if ( !$titulo || !$fecha_inicio || !$fecha_fin || !$descuento || !$portafolio || !$titulo_descuento_wc) {
            return HelperUtility::redirectWithMessage('/settings/promociones/edit/'.$id, lang('Errors.missing_fields'));
        }

        // Actualizar promocion
        if ($this->promocionTiendaModel->updatePromocionTienda($id, $titulo, $fecha_inicio, $fecha_fin, $descuento, $portafolio, $titulo_descuento_wc)) {
            return HelperUtility::redirectWithMessage('/settings/promociones/edit/'.$id, lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/promociones/edit/'.$id, lang('Errors.error_try_again_later'));
    }

    public function deletePromocionTienda()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $promocion = $this->promocionTiendaModel->getPromocionesTienda($id);
        if (!$promocion) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->promocionTiendaModel->deletePromocionTienda($id)){
            return $this->respondWithCsrf([
                'ok'            => true,
            ]);
        }

        // En caso de error
        return $this->respondWithCsrf([
            'ok'            => false,
            'error'         => lang('Errors.error_try_again_later'),
        ]);
    }


}
