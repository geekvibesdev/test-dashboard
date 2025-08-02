<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenPersonalizableModel extends Model{

    protected $table              = 'ordenes_personalizables';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'fecha_envio', 'fecha_entrega', 'estatus', 'notas'];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    

    public function getOrdenPersonalizable($id = null)
    {        
        if ($id !== null) {
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getOrdenPersonalizableOrdenData()
    {        
        $this->select('ordenes_personalizables.*, ordenes.*, ordenes_facturacion.*, ordenes_productos.*, ordenes_costo_real.*');
        $this->join('ordenes', 'ordenes.orden = ordenes_personalizables.wc_orden', 'left');
        $this->join('ordenes_facturacion', 'ordenes_facturacion.wc_orden = ordenes_personalizables.wc_orden', 'left');
        $this->join('ordenes_productos', 'ordenes_productos.wc_orden = ordenes_personalizables.wc_orden', 'left');
        $this->join('ordenes_costo_real', 'ordenes_costo_real.wc_orden = ordenes_personalizables.wc_orden', 'left');
        
        return $this->orderBy('ordenes_personalizables.fecha_creado', 'DESC')->findAll();
    }

     public function getOrdenPersonalizableByWcOrden($wc_orden)
    {
        return $this->where('wc_orden', $wc_orden)->first();
    }

    public function crearOrdenPersonalizable($wc_orden)
    {
        $data = [
            'wc_orden'          => $wc_orden,
            'estatus'           => 'Nuevo',
        ];
        return $this->insert($data);
    }
    
    public function actualizarOrdenPersonalizable($wc_orden, $fecha_envio, $fecha_entrega, $estatus, $notas)
    {
        $data = [
            'fecha_envio'      => $fecha_envio,
            'fecha_entrega'    => $fecha_entrega,
            'estatus'          => $estatus,
            'notas'            => $notas,
        ];
        return $this->where('wc_orden', $wc_orden)->set($data)->update();
    }
}
