<?php

namespace App\Controllers;

use App\Models\WebhookLogModel;

class WebhookLog extends BaseController
{
    protected $webhookLogModel;

    public function __construct()
    {
        $this->webhookLogModel      = new WebhookLogModel();
    }

    public function index(): string
    {
        $logs   = $this->webhookLogModel->getLogs();
        return $this->render('pages/admin/logs/wc', [
            'title'  => 'Logs WC - Webhooks',
            'assets' => 'admin_webhooks_logs',
            'logs'   => $logs
        ]);
    }
   
    public function getWCLog($id): string
    {
        $log = $this->webhookLogModel->getLogs($id);
        if (!$log) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/logs/wc-detail', [
            'title'  => 'Logs WC - Webhooks',
            'assets' => 'admin_webhooks_logs_detail',
            'log'    => $log
        ]);
    }

    public function crearLog(array $data)
    {
        $logData = [
            'type'      => $data['type'] ?? null,
            'request'   => $data['request'] ?? null,
            'response'  => $data['response'] ?? null,
            'status'    => $data['status'] ?? null,
        ];
        $this->webhookLogModel->crearLog($logData);
    }
}
