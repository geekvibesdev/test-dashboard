<?php

namespace App\Controllers;

use App\Controllers\Email;

use App\Models\OrdenModel;
use App\Models\IncidenteModel;

class Truedesk extends BaseController
{

    protected $ordenModel;
    protected $incidenteModel;
    protected $truedesk_url;
    protected $truedesk_access_token;
    protected $truedesk_owner;
    protected $truedesk_group;
    protected $truedesk_type;
    protected $truedesk_priority;
    protected $email;
   
    public function __construct()
    {
        $this->ordenModel           = new OrdenModel();
        $this->incidenteModel       = new IncidenteModel();
        $this->email                = new Email();
        $this->truedesk_url         = env('truedesk_url');
        $this->truedesk_access_token = env('truedesk_access_token');
        $this->truedesk_owner       = env('truedesk_owner');
        $this->truedesk_group       = env('truedesk_group');
        $this->truedesk_type        = env('truedesk_type');
        $this->truedesk_priority    = env('truedesk_priority');
    }

    private function truedeskAPICall($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'accesstoken: ' . $this->truedesk_access_token
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        } else {
            $data = json_decode($response);
            curl_close($ch);
            return $data;
        }
    }

    private function truedeskAPIPost($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'accesstoken: ' . $this->truedesk_access_token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        } else {
            $result = json_decode($response);
            curl_close($ch);
            return $result;
        }
    }

    public function createTicket()
    {
        $orderId        = $this->request->getPost('ordenId');
        $subject        = $this->request->getPost('titulo');
        $description    = $this->request->getPost('descripcion');

        $existingOrder = $this->ordenModel->getOrdenesByOrden($orderId);
        $clienteNombre = json_decode($existingOrder->envio_direccion);

        if (!$existingOrder) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Orden inválida'
            ]);
        }

        $url            = $this->truedesk_url . '/api/v1/tickets/create';
        $subjectFinal   = "Orden #$orderId - " . $clienteNombre->first_name ." " .$clienteNombre->last_name. " - " .$subject;

        $data   = [
                    'subject'   => $subjectFinal,
                    'issue'     => $description . "\n\n" . "Detalles de la orden: <a href='".base_url()."ventas/ordenes/".$orderId."' target='_blank'>#$orderId</a>",
                    'owner'     => $this->truedesk_owner,
                    'group'     => $this->truedesk_group,
                    'type'      => $this->truedesk_type,
                    'priority'  => $this->truedesk_priority,
                ];

        $response = $this->truedeskAPIPost($url, $data);

        // Error en CURL
        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al procesar.'
            ]);
        }

        // Error en Truedesk
        if($response->success == false) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al procesar la solicitud.',
                'resp'      => $response
            ]);
        }

        // Insertar Incidente en Orden
        $this->ordenModel->actualizarOrdenByWcOrden($orderId, ['incidente' => $response->ticket->uid, 'incidente_titulo' => $subjectFinal]);

        // Crear el Incidente en incidentes
        $incidenteData = [
            'wc_orden'              => $orderId,
            'incidente_id'          => $response->ticket->uid,
            'incidente_titulo'      => $subject,
            'incidente_descripcion' => $description,
            'incidente_estatus'     => 'Open',
            'incidente_data'        => json_encode($response->ticket)
        ];

        log_message('debug', json_encode($incidenteData));
        
        $this->incidenteModel->createIncidente($incidenteData);

        return $this->response->setJSON([
            'ok'        => true,
            'ticket'    => $response,
            'uid'       => $response->ticket->uid,
        ]);
    }    

    public function getTicket($ticket)
    {
        $url = $this->truedesk_url . '/api/v1/tickets/' . $ticket;

        $response = $this->truedeskAPICall($url);

        // Error en CURL
        if (is_null($response)) {
            return null;
        }

        // Error en Truedesk
        if ($response->success == false) {
            return null;
        }

        return $response->ticket;
    }

    public function getTicketAjax($ticket)
    {
        $ticketData = $this->getTicket($ticket);

        if (is_null($ticketData)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener el ticket.'
            ]);
        }

        return $this->response->setJSON([
            'ok'        => true,
            'ticket'    => $ticketData
        ]);
    }

    public function addCommentToTicket()
    {
        $url = $this->truedesk_url . '/api/v1/tickets/addcomment';

        $_id            = $this->request->getPost('_id');
        $comment        = $this->request->getPost('comment');
        $owner          = $this->truedesk_owner;

        $data = [
            'ticketId'  => false,
            '_id'       => $_id,
            'owner'     => $owner,
            'comment'   => $comment,
            'note'      => false,
        ];

        $response = $this->truedeskAPIPost($url, $data);

        // Error en CURL
        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al ejecutar.'
            ]);
        }

        // Error en Truedesk
        if ($response->success == false) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al postear.',
                'resp'      => $response

            ]);
        }

        $this->email->sendEmail("jcperezs2021@gmail.com", 'Hola', 'Mi mensaje');
        return $this->response->setJSON([
            'ok'        => true,
            'resp'      => $response,
        ]);
    }

}
