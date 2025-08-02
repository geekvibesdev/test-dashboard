<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenFacturacionModel extends Model{

    protected $table              = 'ordenes_facturacion';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'facturacion_datos', 'requiere_factura', 'facturado', 'factura_pdf', 'factura_xml'];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function crearOrdenFacturacion($wc_orden, $facturacion_datos, $requiere_factura)
    {
        $data = [
            'wc_orden'          => $wc_orden,
            'facturacion_datos' => $facturacion_datos,
            'requiere_factura'  => $requiere_factura,
            'facturado'         => 0,
        ];
        return $this->insert($data);
    }

    public function obtenerOrdenFacturacion($wc_orden)
    {
        return $this->where('wc_orden', $wc_orden)->first();
    }

    public function actualizarOrdenFacturacionDatosByWcOrden($wc_orden, $facturacion_datos)
    {
        $data = [
            'facturacion_datos' => $facturacion_datos,
        ];
        return $this->where('wc_orden', $wc_orden)->set($data)->update();
    }

    public function actualizarOrdenFacturacion($id, $facturado, $factura_pdf, $factura_xml)
    {
        $data = [
            'facturado'          => $facturado,
            'factura_pdf'        => $factura_pdf,
            'factura_xml'        => $factura_xml,
        ];
        return $this->update($id, $data);
    }
}
