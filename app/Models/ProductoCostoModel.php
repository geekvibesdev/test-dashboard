<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoCostoModel extends Model{

    protected $table              = 'productos_costos';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['id_wc', 'sku', 'nombre', 'precio_venta', 'costo', 'inventario', 'slug', 'data', 'kit', 'kit_cantidad', 'kit_producto'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getProductoCosto($id = null)
    {

        $this->select('productos_costos.*, productos_costos.nombre as kit_producto_nombre');
        $this->join('productos_costos as pc2', 'productos_costos.kit_producto = pc2.id', 'left');

        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getProductoCostoByIdWc($id_wc)
    {
        return $this->where('id_wc', $id_wc)->limit(1)->first();
    }

    public function createProductoCosto($id_wc, $sku, $nombre, $precio_venta ,$costo, $inventario, $slug, $data, $kit, $kit_cantidad, $kit_producto)
    {
        $data = [
            'id_wc'      => $id_wc,
            'sku'        => $sku,
            'nombre'     => $nombre,
            'precio_venta' => $precio_venta,
            'costo'      => $costo,
            'inventario' => $inventario,
            'slug'       => $slug,
            'data'       => $data,
            'kit'        => $kit,
            'kit_cantidad' => $kit_cantidad,
            'kit_producto' => $kit_producto
        ];

        return $this->insert($data);
    }

    public function updateProductoCosto($id, $id_wc, $sku, $nombre, $precio_venta, $costo, $inventario, $slug, $data, $kit, $kit_cantidad, $kit_producto)
    {
        return $this->update($id, [
            'id_wc'      => $id_wc,
            'sku'        => $sku,
            'nombre'     => $nombre,
            'precio_venta' => $precio_venta,
            'costo'      => $costo,
            'inventario' => $inventario,
            'slug'       => $slug,
            'data'       => $data,
            'kit'        => $kit,
            'kit_cantidad' => $kit_cantidad,
            'kit_producto' => $kit_producto
        ]);
    }

    public function deleteProductoCosto($id)
    {
        return $this->delete(['id' => $id]);
    }
}
