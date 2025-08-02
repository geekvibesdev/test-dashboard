<?php

namespace App\Models;

use App\Controllers\HelperUtility;
use CodeIgniter\Model;

class IncidenteModel extends Model{

    protected $table              = 'incidentes';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'incidente_id', 'incidente_titulo', 'incidente_descripcion', 'incidente_estatus', 'incidente_data'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getIncidente($id = null)
    {
        if ($id !== null) {
            return $this->find($id);
        }
        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function createIncidente($data)
    {
        return $this->insert($data);
    }
    
    public function updateIncidente($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deleteIncidente($id)
    {
        return $this->delete($id);
    }
    
    public function getIncidenteByIncidenteId($incidente_id)
    {
        return $this->where('incidente_id', $incidente_id)->first();
    }

    public function getIncidenteByOrden($wc_orden)
    {
        return $this->where('wc_orden', $wc_orden)->findAll();
    }
}
