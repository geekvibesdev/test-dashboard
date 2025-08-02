<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaCategoriaModel extends Model{

    protected $table              = 'factura_categorias';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['nombre'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getItem($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getByName($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }

    public function createItem($nombre)
    {
        $data = [
            'nombre'     => $nombre
        ];

        return $this->insert($data);
    }

    public function updateItem($id, $nombre)
    {
        return $this->update($id, [
            'nombre' => $nombre,
        ]);
    }
    
    public function deleteItem($id)
    {
        return $this->delete(['id' => $id]);
    }
}
