<?php

namespace App\Models;

use CodeIgniter\Model;

class GMLEnviosModel extends Model{

    protected $table              = 'gml_envios';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['wc_orden', 'remitente', 'destinatario', 'largo_cm', 'ancho_cm', 'alto_cm', 'peso_kg', 'uid', 'historico', 'tipo_envio', 'entrega_estimada', 'guia_fecha_creada', 'guia_fecha_recolectada', 'guia_fecha_en_transito', 'guia_fecha_entregada', 'guia', 'estatus', 'firma'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function addRemitDestJoinsAndSelects()
    {
        $this->join('gml_destinatarios', 'gml_destinatarios.id = gml_envios.destinatario', 'left');
        $this->join('gml_remitentes', 'gml_remitentes.id = gml_envios.remitente', 'left');

        $destinatarioFields = array_map(function($field) {
            return "gml_destinatarios.$field AS destinatario_$field";
        }, $this->db->getFieldNames('gml_destinatarios'));

        $remitenteFields = array_map(function($field) {
            return "gml_remitentes.$field AS remitente_$field";
        }, $this->db->getFieldNames('gml_remitentes'));

        $this->select('gml_envios.*,' . implode(',', $destinatarioFields) . ',' . implode(',', $remitenteFields));
    }

    public function getItemsWithRemitDest()
    {
        $this->addRemitDestJoinsAndSelects();
        return $this->orderBy('gml_envios.fecha_creado', 'DESC')->findAll();
    }

    public function getItemsWithRemitDestFiltro($fechaInicio = null, $fechaFin = null, $estatus = null)
    {
        $this->addRemitDestJoinsAndSelects();

        if ($fechaInicio && $fechaFin) {
            $this->where('gml_envios.fecha_creado >=', $fechaInicio)
                ->where('gml_envios.fecha_creado <=', $fechaFin . ' 23:59:59');
        }

        if ($estatus) {
            $this->where('gml_envios.estatus', $estatus);
        }

        return $this->orderBy('gml_envios.fecha_creado', 'DESC')->findAll();
    }

    public function getItemsByUid($uid)
    {
        $this->addRemitDestJoinsAndSelects();
        return $this->where('uid', $uid)->first();
    }
    
    
    public function getItem($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function getByWcOrden($wc_orden)
    {
        return $this->where('wc_orden', $wc_orden)->first();
    }
    
    public function getItemByGuia($guia)
    {
        return $this->where('guia', $guia)->first();
    }

    public function createItem($data)
    {
        return $this->insert($data);
    }

    public function updateItem($id, $data)
    {
        return $this->update($id, $data);
    }
    
    public function deteleteIitem($id)
    {
        return $this->delete(['id' => $id]);
    }
}
