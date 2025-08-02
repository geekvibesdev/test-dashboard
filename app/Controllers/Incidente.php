<?php

namespace App\Controllers;

use App\Controllers\Truedesk;
use App\Controllers\Orden;

use App\Models\IncidenteModel;

class Incidente extends BaseController
{
    
    protected $incidenteModel;
    protected $orden;
    protected $truedesk;
    protected $truedesk_url;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->incidenteModel   = new IncidenteModel();
        $this->orden            = new Orden();
        $this->truedesk         = new Truedesk();
        $this->truedesk_url     = env('truedesk_url');
    }
    public function index(): string
    {
        return $this->render('pages/shared/incidente/incidente', [
            'title'  => 'Incidentes',
            'assets' => 'incidente',
            'incidentes' => $this->incidenteModel->getIncidente()
            
        ]);
    }

    public function interior($id): string
    {
        $incidente = $this->incidenteModel->getIncidenteByIncidenteId($id);
        if (!$incidente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $orden = $this->orden->getOrden($incidente->wc_orden);
        if (!$orden) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        
        $incidente->incidente_data  = json_decode($incidente->incidente_data, true);

        return $this->render('pages/shared/incidente/incidente-interior', [
            'title'  => "Incidente #$incidente->incidente_id",
            'assets' => 'incidente_interior',
            'incidente'     => $incidente, 
            'truedesk_url'  => $this->truedesk_url, 
            'orden'         => $orden,
            'csrfName'      => csrf_token(),    
            'csrfHash'      => csrf_hash(),
        ]);
    }

    public function updateIncidente($id, $data)
    {
        // Validar ID
        if (empty($id) || empty($data)) {
            return json_encode(['status' => 'error', 'message' => 'ID y datos son obligatorios']);
        }

        if ($this->incidenteModel->updateIncidente($id, $data)) {
            return json_encode(['status' => 'success', 'message' => 'Incidente actualizado correctamente']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Error al actualizar el incidente']);
        }
    }

}
