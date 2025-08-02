<?php

namespace App\Controllers;

use App\Models\PromocionModel;
use App\Controllers\HelperUtility;

class Promocion extends BaseController
{
    protected $promocionModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->promocionModel   = new PromocionModel();
    }

    public function index(): string
    {
        $promocions = $this->promocionModel->getPromociones();
        return $this->render('pages/admin/promocion/promocion', [
            'title'  => 'Promociones',
            'assets' => 'admin_promociones_envios',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
            'promocions' => $promocions
        ]);
    }

    public function newPromocion(): string
    {
        return $this->render('pages/admin/promocion/promocion-new', [
            'title'  => 'Nueva Promocion',
            'assets' => 'admin_promociones_envios_new',
        ]);
    }

    public function editPromocion($id): string
    {
        $promocion = $this->promocionModel->getPromociones($id);
        if (!$promocion) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/promocion/promocion-edit', [
            'title'  => 'Editar Promocion',
            'assets' => 'admin_promociones_envios_edit',
            'promocion' => $promocion,
        ]);
    }

    public function createPromocion()
    {
        $name = $this->request->getPost('name');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage('/settings/envios/new', lang('Errors.missing_fields'));
        }

        // Verificar si el promocion ya existe
        if ($this->promocionModel->getPromocionByName($name)) {
            return HelperUtility::redirectWithMessage('/settings/envios/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo promocion
        if ($this->promocionModel->createPromocion($name)) {
            return HelperUtility::redirectWithMessage('/settings/envios/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/envios/new', lang('Errors.error_try_again_later'));
    }

    public function updatePromocion()
    {
        $name   = $this->request->getPost('name');
        $id     = $this->request->getPost('id');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage("/settings/envios/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el promocion existe
        if ($this->promocionModel->getPromocionByName($name) && $this->promocionModel->getPromocionByName($name)->id != $id) {
            return HelperUtility::redirectWithMessage("/settings/envios/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar promocion
        if ($this->promocionModel->updatePromocion($id, $name)) {
            return HelperUtility::redirectWithMessage("/settings/envios/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/settings/envios/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deletePromocion()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $promocion = $this->promocionModel->getPromociones($id);
        if (!$promocion) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->promocionModel->deletePromocion($id)){
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
