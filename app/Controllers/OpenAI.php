<?php

namespace App\Controllers;

use App\Controllers\HelperUtility;

use App\Models\OpenAIQuerysModel;
use App\Models\OpenAISettingsModel;

class OpenAI extends BaseController
{
    protected $openAISettingsModel;
    protected $openAIQuerysModel;
    protected $helperUtility;
   
    public function __construct()
    {
        $this->openAISettingsModel  = new OpenAISettingsModel();
        $this->openAIQuerysModel    = new OpenAIQuerysModel();
        $this->helperUtility        = new HelperUtility();
    }

    public function settings(): string
    {
        $settings = $this->openAISettingsModel->getOpenAISettings();
        if (!$settings) {
            return redirect()->to(base_url('settings/openai'))->with('error', 'No se encontraron configuraciones de OpenAI.');
        }
       $settings->token = HelperUtility::decrypt($settings->token);
       return $this->render('pages/admin/openai/openai-settings', [
            'title'  => 'OpenAI Settings',
            'assets' => 'admin_openai',
            'settings' => $settings,
        ]);
    }

    public function updateSettings()
    {
        $data = [
            'url'           => $this->request->getPost('url'),
            'token'         => HelperUtility::encrypt($this->request->getPost('token')),
            'model'         => $this->request->getPost('model'),
            'temperature'   => $this->request->getPost('temperature'),
            'max_token'     => $this->request->getPost('max_token'),
            'system_prompt' => $this->request->getPost('system_prompt')
        ];

         // Validación inicial de los campos requeridos
        if (empty($data['url']) || empty($data['token']) || empty($data['model']) || 
            empty($data['temperature']) || empty($data['max_token']) || empty($data['system_prompt'])) {
            return HelperUtility::redirectWithMessage('settings/openai', 'Todos los campos son obligatorios.');
        }
        // Validación de la URL
        if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            return HelperUtility::redirectWithMessage('settings/openai', 'La URL proporcionada no es válida.');
        }
        // Validacion de temperature
        if (!is_numeric($data['temperature']) || $data['temperature'] < 0 || $data['temperature'] > 1) {
            return HelperUtility::redirectWithMessage('settings/openai', 'La temperatura debe ser un número entre 0 y 1.');
        }
        // Validacion de max_token
        if (!is_numeric($data['max_token']) || $data['max_token'] <= 0 ) {
            return HelperUtility::redirectWithMessage('settings/openai', 'El número máximo de tokens debe ser un número positivo.');
        }

        // Guardar las configuraciones
        if ($this->openAISettingsModel->updateOpenAISettings($data)) {
            return HelperUtility::redirectWithMessage('settings/openai', 'Configuraciones actualizadas correctamente.', 'success');
        } else {
            return HelperUtility::redirectWithMessage('settings/openai', 'Error al actualizar las configuraciones.');
        }
    }

    private function openaiAPI($url, $data, $token)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        } else {
            curl_close($ch);
            return $response;
        }
    }

    private function generarRespuestaCorreo($solicitud, $cliente)
    {
        $settings = $this->openAISettingsModel->getOpenAISettings();

        if (!$settings) {
            return null;
        }
        $settings->token = HelperUtility::decrypt($settings->token);

        $url  = $settings->url . '/chat/completions';
        $data = [
            'model'         => $settings->model,
            'temperature'   => floatval($settings->temperature),
            'max_tokens'    => intval($settings->max_token),
            'messages'      => [
                ['role' => 'system', 'content' => $settings->system_prompt],
                ['role' => 'user', 'content' => "Genera correo para: $solicitud, Nombre del cliente: $cliente"],
            ],
        ];

        $response = $this->openaiAPI($url, $data, $settings->token);

        if ($response) {
            $result = json_decode($response, true);

            // Guarda en la base de datos la respuesta
            $queryData = [
                'req_model'                 => $settings->model,
                'req_temperature'           => $settings->temperature,
                'req_system_content'        => $settings->system_prompt,
                'req_user_content'          => "Seguimiento: $solicitud, Nombre del cliente: $cliente",
                'resp_id'                   => $result['id'] ?? null,
                'resp_object'               => $result['object'] ?? null,
                'resp_message'              => json_encode($result['choices'][0]['message'] ?? []),
                'resp_usage_prompt_tokens'  => $result['usage']['prompt_tokens'] ?? 0,
                'resp_usage_completion_tokens' => $result['usage']['completion_tokens'] ?? 0,
                'resp_usage_total_tokens'   => $result['usage']['total_tokens'] ?? 0,
                'resp_created_at'           => date('Y-m-d H:i:s'),
                'resp_response'             => $response
            ];
            $this->openAIQuerysModel->createQuery($queryData);

            return $result['choices'][0]['message']['content'] ?? null;
        }

        return null;
    }

    public function generarCorreo()
    {
        $solicitud = $this->request->getPost('solicitud');
        $cliente   = $this->request->getPost('cliente');

        if (empty($solicitud) || empty($cliente)) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'Solicitud y cliente son requeridos.']);
        }

        $respuesta = $this->generarRespuestaCorreo($solicitud, $cliente);

        if ($respuesta) {
            return $this->respondWithCsrf([
                'ok'        => true,
                'respuesta' => $respuesta
            ]);
        } else {
            return $this->respondWithCsrf([
                'ok'        => false,
                'error'     => 'Error al generar el correo.',
                'respuesta' => $respuesta
            ]);
        }
    }
}
