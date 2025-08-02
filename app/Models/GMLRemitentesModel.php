<?php

namespace App\Models;

use CodeIgniter\Model;

class GMLRemitentesModel extends Model{

    protected $table              = 'gml_remitentes';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['nombre', 'apellidos', 'correo_electronico', 'calle_numero', 'colonia', 'ciudad', 'estado', 'codigo_postal', 'telefono', 'referencias'];
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
            $item = $this->find($id);
            if ($item) {
                $item->nombre_completo = $item->nombre . ' ' . $item->apellidos;
                $item->direccion_completa = $item->calle_numero . ', ' . $item->colonia . ', ' . $item->ciudad . ', ' . $item->estado . ', CP: ' . $item->codigo_postal;
            }
            return $item;
        }

        $items = $this->orderBy('fecha_creado', 'DESC')->findAll();
        foreach ($items as $item) {
            $item->nombre_completo = $item->nombre . ' ' . $item->apellidos;
            $item->direccion_completa = $item->calle_numero . ', ' . $item->colonia . ', ' . $item->ciudad . ', ' . $item->estado . ', CP: ' . $item->codigo_postal;
        }
        return $items;
    }

    public function getByEmail($correo_electronico)
    {
        return $this->where('correo_electronico', $correo_electronico)->first();
    }

    public function createItem($nombre, $apellidos, $correo_electronico, $calle_numero, $colonia, $ciudad, $estado, $codigo_postal, $telefono, $referencias)
    {
        $data = [
            'nombre'             => $nombre,
            'apellidos'          => $apellidos,
            'correo_electronico' => $correo_electronico,
            'calle_numero'       => $calle_numero,
            'colonia'            => $colonia,
            'ciudad'             => $ciudad,
            'estado'             => $estado,
            'codigo_postal'      => $codigo_postal,
            'telefono'           => $telefono,
            'referencias'        => $referencias
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
