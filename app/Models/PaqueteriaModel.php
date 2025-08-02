<?php

namespace App\Models;

use CodeIgniter\Model;

class PaqueteriaModel extends Model{

    protected $table              = 'paqueterias';
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
    
    public function getPaqueterias($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getPaqueteriaByName($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }

    public function createPaqueteria($nombre)
    {
        $data = [
            'nombre'     => $nombre
        ];

        return $this->insert($data);
    }

    public function updatePaqueteria($id, $nombre)
    {
        return $this->update($id, [
            'nombre' => $nombre,
        ]);
    }
    
    public function deletePaqueteria($id)
    {
        return $this->delete(['id' => $id]);
    }
}
