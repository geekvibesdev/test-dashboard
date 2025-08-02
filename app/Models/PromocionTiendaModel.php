<?php

namespace App\Models;

use CodeIgniter\Model;

class PromocionTiendaModel extends Model{

    protected $table              = 'promociones_tienda';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['titulo', 'fecha_inicio', 'fecha_fin', 'descuento', 'portafolio', 'titulo_descuento_wc'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getPromocionesTienda($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function createPromocionTienda($titulo, $fecha_inicio, $fecha_fin, $descuento, $portafolio, $titulo_descuento_wc)
    {
        $data = [
            'titulo'        => $titulo,
            'fecha_inicio'  => $fecha_inicio,
            'fecha_fin'     => $fecha_fin,
            'descuento'     => $descuento,
            'portafolio'    => $portafolio,
            'titulo_descuento_wc' => $titulo_descuento_wc,
        ];

        return $this->insert($data);
    }

    public function updatePromocionTienda($id, $titulo, $fecha_inicio, $fecha_fin, $descuento, $portafolio, $titulo_descuento_wc)
    {
        $data = [
            'titulo'        => $titulo,
            'fecha_inicio'  => $fecha_inicio,
            'fecha_fin'     => $fecha_fin,
            'descuento'     => $descuento,
            'portafolio'    => $portafolio,
            'titulo_descuento_wc' => $titulo_descuento_wc,
        ];

        return $this->update($id, $data);
    }
    
    public function deletePromocionTienda($id)
    {
        return $this->delete(['id' => $id]);
    }
}
