<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenModel extends Model{

    protected $table              = 'ordenes';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = [ 
                                        'orden', 'cliente_id', 'fecha_orden', 'estatus_orden', 'envio_tipo', 'envio_direccion', 
                                        'cot_envio_total', 'orden_impuestos', 'orden_total', 
                                        'pago_metodo', 'pago_id', 'webhook_request', 'productos', 'facturacion', 'costo_real', 'incidente', 'incidente_titulo'
                                    ];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    private function baseQuery()
    {
        $this->select('ordenes.*, ordenes_productos.*, ordenes_facturacion.*, ordenes_costo_real.*, paqueterias.nombre as real_envio_paqueteria_nombre, promociones.nombre as promocion_tipo_nombre');
        $this->join('ordenes_productos', 'ordenes_productos.wc_orden = ordenes.orden', 'left');
        $this->join('ordenes_facturacion', 'ordenes_facturacion.wc_orden = ordenes.orden', 'left');
        $this->join('ordenes_costo_real', 'ordenes_costo_real.wc_orden = ordenes.orden', 'left');
        $this->join('paqueterias', 'paqueterias.id = ordenes_costo_real.real_envio_paqueteria', 'left');
        $this->join('promociones', 'promociones.id = ordenes_costo_real.promocion_tipo', 'left');
    }

    public function getOrdenes($id = null)
    {
        $this->baseQuery();
        
        if ($id !== null) {
            return $this->where('ordenes.id', $id)->first();
        }
        return $this->orderBy('ordenes.fecha_creado', 'DESC')->findAll();
    }

    public function getOrdenesByOrden($orden = null)
    {
        $this->baseQuery();
        
        if ($orden !== null) {
            return $this->where('ordenes.orden', $orden)->first();
        }
        return $this->orderBy('ordenes.fecha_creado', 'DESC')->findAll();
    }
   
    public function getOrdenesByCliente($cliente_id = null)
    {
        if($cliente_id !== null){
            return $this->where('cliente_id', $cliente_id)->orderBy('fecha_creado', 'DESC')->findAll();
        }
        return [];
    }

    public function getOrdenesByEstatus($estatus = null)
    {
        if($estatus !== null){
            return $this->where('estatus_pago', $estatus)->orderBy('fecha_creado', 'DESC')->findAll();
        }
        return [];
    }

    public function crearOrden($data)
    {
        return $this->insert($data);
    }
    
    public function actualizarOrdenByWcOrden($orden, $data)
    {
        return $this->where('orden', $orden)->set($data)->update();
    }

    public function getOrdenesFiltradas($fechaInicio = null, $fechaFin = null, $estatus = null)
    {
        $this->baseQuery();

        // Filtrar por rango de fechas
        if ($fechaInicio && $fechaFin) {
            $this->where('ordenes.fecha_creado >=', $fechaInicio)
                ->where('ordenes.fecha_creado <=', $fechaFin . ' 23:59:59');
        }

        // Filtrar por estatus
        if ($estatus) {
            $this->where('ordenes.estatus_orden', $estatus);
        }

        return $this->orderBy('ordenes.fecha_creado', 'DESC')->findAll();
    }
    
    public function getOrdenesFiltradasProcesadas($fechaInicio = null, $fechaFin = null)
    {
        $this->baseQuery();

        // Filtrar por rango de fechas
        if ($fechaInicio && $fechaFin) {
            $this->where('ordenes.fecha_creado >=', $fechaInicio)
                ->where('ordenes.fecha_creado <=', $fechaFin . ' 23:59:59');
        }


        $this->groupStart()
            ->where('ordenes.estatus_orden', 'completed')
            ->orWhere('ordenes.estatus_orden', 'processing')
        ->groupEnd();

        return $this->orderBy('ordenes.fecha_creado', 'DESC')->findAll();
    }
}
