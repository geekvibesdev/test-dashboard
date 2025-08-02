<?php

namespace App\Controllers;

use App\Models\FacturaCategoriaModel;

class FacturaCategoria extends BaseController
{
    protected $facturaCategoriaModel;

    public function __construct()
    {
        $this->lang                 = \Config\Services::language();
        $this->lang                 ->setLocale('es');
        $this->facturaCategoriaModel = new FacturaCategoriaModel();
    }

    public function createItem()
    {
        $nombre = $this->request->getPost('nombre');

        // Verificar si existe
        $iten = $this->facturaCategoriaModel->getByName($nombre);
        if ($iten) {
            return $this->duplicatedItem();
        }

        // Crear elemento
        $id = $this->facturaCategoriaModel->createItem($nombre);
        if($id){
            return $this->respondWithCsrf([
                'ok'           => true,
                'id'           => $id,
                'nombre'       => $nombre,
            ]);
        }

        // En caso de error
        return $this->generalError();
    }

    public function updateItem()
    {
        $id     = $this->request->getPost('id');
        $nombre = $this->request->getPost('nombre');

        // Verificar si existe
        $iten = $this->facturaCategoriaModel->getByName($nombre);
        if ($iten) {
            return $this->duplicatedItem();
        }

        // Actualizar elemento
        if($this->facturaCategoriaModel->updateItem($id, $nombre)){
            return $this->respondWithCsrf([
                'ok'           => true,
                'id'           => $id,
                'nombre'       => $nombre,
            ]);
        }

        // En caso de error
        return $this->generalError();
    }

    public function deleteItem()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $iten = $this->facturaCategoriaModel->getItem($id);
        if (!$iten) {
            return $this->duplicatedItem();
        }

        // Eliminar
        if($this->facturaCategoriaModel->deleteItem($id)){
            return $this->respondWithCsrf([
                'ok'            => true,
            ]);
        }

        // En caso de error
        return $this->generalError();
    }

    private function generalError()
    {
        return $this->respondWithCsrf([
            'ok'            => false,
            'message'         => lang('Errors.error_try_again_later'),
        ]);
    }

    private function duplicatedItem()
    {
        return $this->respondWithCsrf([
            'ok'            => false,
            'message'         => lang('Errors.gral_duplicated'),
        ]);
    }
}
