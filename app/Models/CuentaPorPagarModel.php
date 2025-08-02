<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentaPorPagarModel extends Model{

    protected $table              = 'cuentas_por_pagar';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['id_proveedor', 'factura_folio', 'factura_tipo', 'factura_monto', 'factura_categoria', 'factura_pdf', 'pago_estatus', 'credito_dias', 'fecha_emision', 'fecha_pago'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    private function baseQuery()
    {
        $builder = $this->db->table($this->table)
            ->select("{$this->table}.*, proveedores.razon_social, proveedores.rfc, factura_categorias.nombre AS factura_categoria_nombre")
            ->join('proveedores', "{$this->table}.id_proveedor = proveedores.id", 'left')
            ->join('factura_categorias', "{$this->table}.factura_categoria = factura_categorias.id", 'left');

        return $builder;
    }

    public function getItem($id = null)
    {
        $builder = $this->baseQuery();

        if ($id !== null) {
            $builder->where("{$this->table}.id", $id);
            return $builder->get()->getRow();
        }

        $builder->orderBy("{$this->table}.fecha_emision", 'DESC');
        return $builder->get()->getResult();
    }

    public function getItemFiltro($fechaInicio = null, $fechaFin = null, $estatus = null)
    {
        $builder = $this->baseQuery();

        // Normaliza fechas a formato YYYY-MM-DD si vienen en otro formato
        if ($fechaInicio && strpos($fechaInicio, '/') !== false) {
            $fechaInicio = date('Y-m-d', strtotime(str_replace('/', '-', $fechaInicio)));
        }
        if ($fechaFin && strpos($fechaFin, '/') !== false) {
            $fechaFin = date('Y-m-d', strtotime(str_replace('/', '-', $fechaFin)));
        }

        // Filtrar por rango de fechas
        if ($fechaInicio && $fechaFin) {
            $builder->where("{$this->table}.fecha_emision >=", $fechaInicio . ' 00:00:00')
                    ->where("{$this->table}.fecha_emision <=", $fechaFin . ' 23:59:59');
        }

        // Filtrar por estatus
        if ($estatus) {
            $builder->where("{$this->table}.pago_estatus", $estatus)->orderBy("{$this->table}.fecha_emision", 'DESC');
        }
        return $builder->get()->getResult();
    }

    public function getByFolio($factura_folio)
    {
        return $this->where('factura_folio', $factura_folio)->first();
    }

    public function createItem($id_proveedor, $factura_folio, $factura_tipo, $factura_monto, $factura_categoria, $factura_pdf, $pago_estatus, $credito_dias, $fecha_emision, $fecha_pago) 
    {
        $data = [  
            'id_proveedor'     => $id_proveedor,
            'factura_folio'    => $factura_folio,
            'factura_tipo'     => $factura_tipo,
            'factura_monto'    => $factura_monto,
            'factura_categoria'=> $factura_categoria,
            'factura_pdf'      => $factura_pdf,
            'pago_estatus'     => $pago_estatus,
            'credito_dias'     => $credito_dias,
            'fecha_emision'    => $fecha_emision,
            'fecha_pago'       => $fecha_pago
        ];
        return $this->insert($data);
    }

    public function updateItem($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deteleteItem($id)
    {
        return $this->delete(['id' => $id]);
    }
}
