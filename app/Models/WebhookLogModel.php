<?php

namespace App\Models;

use CodeIgniter\Model;

class WebhookLogModel extends Model{

    protected $table              = 'webhook_log';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['type', 'request', 'response', 'status'];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getLogs($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }
        return $this->orderBy('fecha_creado', 'DESC')->findAll(50);
    }
   
    public function crearLog($data)
    {
        return $this->insert($data);
    }
}
