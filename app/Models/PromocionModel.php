<?php

namespace App\Models;

use CodeIgniter\Model;

class PromocionModel extends Model{

    protected $table              = 'promociones';
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
    
    public function getPromociones($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getPromocionByName($nombre)
    {
        return $this->where('nombre', $nombre)->first();
    }

    public function createPromocion($nombre)
    {
        $data = [
            'nombre'     => $nombre
        ];

        return $this->insert($data);
    }

    public function updatePromocion($id, $nombre)
    {
        return $this->update($id, [
            'nombre' => $nombre,
        ]);
    }
    
    public function deletePromocion($id)
    {
        return $this->delete(['id' => $id]);
    }
}
