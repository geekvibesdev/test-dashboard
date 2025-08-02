<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenCostoRealModel extends Model{

    protected $table              = 'ordenes_costo_real';
    protected $primaryKey         = 'id';
    protected $returnType         = "object";
    protected $useAutoIncrement   = true;
    protected $useTimestamps      = true;
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'promocion', 'promocion_tipo', 'real_envio_paqueteria', 'real_envio_guia', 'real_envio_costo'];
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function crearOrdenCostoreal($wc_orden, $promocion)
    {
        $data = [
            'wc_orden'          => $wc_orden,
            'promocion'         => $promocion,
        ];
        return $this->insert($data);
    }
    
    public function actualizarOrdenCostoReal($orden, $promocion, $promocion_tipo, $real_envio_paqueteria, $real_envio_guia, $real_envio_costo)
    {
        $data = [
            'promocion'             => $promocion,
            'promocion_tipo'        => $promocion_tipo,
            'real_envio_paqueteria' => $real_envio_paqueteria,
            'real_envio_guia'       => $real_envio_guia,
            'real_envio_costo'      => $real_envio_costo,
        ];
        return $this->where('wc_orden', $orden)->set($data)->update();
    }
}
