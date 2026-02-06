<?php

namespace App\Controllers;

use App\Libraries\ReporteAgent;

class AgenteReporte extends BaseController
{
    public function index(): string
    {
        return $this->render('pages/shared/reporte/agente-reporte', [
            'title'  => 'Agente de reporte',
            'assets' => 'agente_reportes',
        ]);
    }

    /**
     * POST: pregunta (JSON body o form) -> JSON con respuesta_nl y opcional datos.
     */
    public function ask()
    {
        $pregunta = $this->request->getPost('pregunta')
            ?? $this->request->getJSON(true)['pregunta']
            ?? null;

        if ($pregunta === null || trim((string) $pregunta) === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'ok'    => false,
                'error' => 'Falta el campo pregunta',
            ]);
        }

        $agent  = new ReporteAgent();
        $result = $agent->ask(trim((string) $pregunta));

        return $this->response->setJSON($result);
    }
}
