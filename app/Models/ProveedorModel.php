<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model{

    protected $table              = 'proveedores';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['razon_social', 'sitio_web', 'rfc', 'contacto_nombre', 'contacto_email', 'contacto_telefono', 'fecha_inicio_operaciones', 'pago_clabe', 'pago_banco', 'pago_cuenta', 'oficina_calle_numero', 'oficina_colonia', 'oficina_ciudad', 'oficina_estado', 'oficina_codigo_postal', 'oficina_telefono', 'oficina_observaciones', 'fiscal_calle_numero', 'fiscal_colonia', 'fiscal_ciudad', 'fiscal_estado', 'fiscal_codigo_postal', 'fiscal_telefono', 'fiscal_observaciones'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getItem($id = null)
    {
        if ($id !== null) {
            return $this->find($id);
        }

        $items = $this->orderBy('fecha_creado', 'DESC')->findAll();
        return $items;
    }

    public function getByRFC($rfc)
    {
        return $this->where('rfc', $rfc)->first();
    }

    public function createItem($razon_social, $sitio_web, $rfc, $contacto_nombre, $contacto_email, $contacto_telefono, $fecha_inicio_operaciones, $pago_clabe, $pago_banco, $pago_cuenta, $oficina_calle_numero, $oficina_colonia, $oficina_ciudad, $oficina_estado, $oficina_codigo_postal, $oficina_telefono, $oficina_observaciones, $fiscal_calle_numero, $fiscal_colonia, $fiscal_ciudad, $fiscal_estado, $fiscal_codigo_postal, $fiscal_telefono, $fiscal_observaciones) 
    {
        $data = [  
            'razon_social'              => $razon_social,
            'sitio_web'                 => $sitio_web,
            'rfc'                       => $rfc,
            'contacto_nombre'           => $contacto_nombre,
            'contacto_email'            => $contacto_email,
            'contacto_telefono'         => $contacto_telefono,
            'fecha_inicio_operaciones'  => $fecha_inicio_operaciones,
            'pago_clabe'                => $pago_clabe,
            'pago_banco'                => $pago_banco,
            'pago_cuenta'               => $pago_cuenta,
            'oficina_calle_numero'      => $oficina_calle_numero,
            'oficina_colonia'           => $oficina_colonia,
            'oficina_ciudad'            => $oficina_ciudad,
            'oficina_estado'            => $oficina_estado,
            'oficina_codigo_postal'     => $oficina_codigo_postal,
            'oficina_telefono'          => $oficina_telefono,
            'oficina_observaciones'     => $oficina_observaciones,
            'fiscal_calle_numero'       => $fiscal_calle_numero,
            'fiscal_colonia'            => $fiscal_colonia,
            'fiscal_ciudad'             => $fiscal_ciudad,
            'fiscal_estado'             => $fiscal_estado,
            'fiscal_codigo_postal'      => $fiscal_codigo_postal,
            'fiscal_telefono'           => $fiscal_telefono,
            'fiscal_observaciones'      => $fiscal_observaciones
        ];
        return $this->insert($data);
    }

    public function updateItem($id, $data)
    {
        return $this->update($id, $data);
    }
}
