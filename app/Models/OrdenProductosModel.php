<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenProductosModel extends Model{

    protected $table              = 'ordenes_productos';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'productos'];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function crearOrdenProductos($wc_orden, $productos)
    {
        $data = [
            'wc_orden'          => $wc_orden,
            'productos'         => $productos,
        ];
        return $this->insert($data);
    }

    public function obtenerOrdenProductos($wc_orden)
    {
        return $this->where('wc_orden', $wc_orden)->findAll();
    }

    public function actualizarOrdenProductosByWcOrden($wc_orden, $productos)
    {
        $data = [
            'productos' => $productos,
        ];
        return $this->where('wc_orden', $wc_orden)->set($data)->update();
    }
    
}
