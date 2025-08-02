<?php

namespace App\Controllers;

use App\Models\PaqueteriaModel;
use App\Controllers\HelperUtility;

class Paqueteria extends BaseController
{
    protected $paqueteriaModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->paqueteriaModel   = new PaqueteriaModel();
    }

    public function index(): string
    {
        $paqueterias = $this->paqueteriaModel->getPaqueterias();
        return $this->render('pages/admin/paqueteria/paqueteria', [
            'title'  => 'Paqueterias',
            'assets' => 'admin_paqueterias',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
            'paqueterias'    => $paqueterias
        ]);
    }

    public function newPaqueteria(): string
    {
        return $this->render('pages/admin/paqueteria/paqueteria-new', [
            'title'  => 'Nueva Paqueteria',
            'assets' => 'admin_paqueterias_new',
        ]);
    }

    public function editPaqueteria($id): string
    {
        $paqueteria = $this->paqueteriaModel->getPaqueterias($id);
        if (!$paqueteria) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/paqueteria/paqueteria-edit', [
            'title'  => 'Editar Paqueteria',
            'assets' => 'admin_paqueterias_edit',
            'paqueteria' => $paqueteria,
        ]);
    }

    public function createPaqueteria()
    {
        $name = $this->request->getPost('name');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage('/settings/paqueteria/new', lang('Errors.missing_fields'));
        }

        // Verificar si el paqueteria ya existe
        if ($this->paqueteriaModel->getPaqueteriaByName($name)) {
            return HelperUtility::redirectWithMessage('/settings/paqueteria/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo paqueteria
        if ($this->paqueteriaModel->createPaqueteria($name)) {
            return HelperUtility::redirectWithMessage('/settings/paqueteria/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/paqueteria/new', lang('Errors.error_try_again_later'));
    }

    public function updatePaqueteria()
    {
        $name   = $this->request->getPost('name');
        $id     = $this->request->getPost('id');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage("/settings/paqueteria/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el paqueteria existe
        if ($this->paqueteriaModel->getPaqueteriaByName($name) && $this->paqueteriaModel->getPaqueteriaByName($name)->id != $id) {
            return HelperUtility::redirectWithMessage("/settings/paqueteria/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar paqueteria
        if ($this->paqueteriaModel->updatePaqueteria($id, $name)) {
            return HelperUtility::redirectWithMessage("/settings/paqueteria/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/settings/paqueteria/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deletePaqueteria()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $paqueteria = $this->paqueteriaModel->getPaqueterias($id);
        if (!$paqueteria) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->paqueteriaModel->deletePaqueteria($id)){
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
