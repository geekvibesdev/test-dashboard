<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Ollama as OllamaConfig;
use Config\Services;

/**
 * Cliente HTTP para la API de Ollama (generate/chat).
 * Usa el modelo configurado en Config\Ollama.
 */
class OllamaClient
{
    private OllamaConfig $config;
    private CURLRequest $client;

    public function __construct(?OllamaConfig $config = null)
    {
        $this->config = $config ?? config(OllamaConfig::class);
        $this->client = Services::curlrequest([
            'base_uri' => $this->config->baseUrl,
            'timeout'  => $this->config->timeout,
        ], null, null, false);
    }

    /**
     * Envia un mensaje de usuario y devuelve la respuesta del asistente.
     * Usa POST /api/chat con stream=false.
     *
     * @param string $userMessage Contenido del mensaje del usuario
     * @return string Contenido de la respuesta del modelo
     * @throws \RuntimeException Si la API falla o la respuesta no es valida
     */
    public function ask(string $userMessage): string
    {
        return $this->chat([['role' => 'user', 'content' => $userMessage]]);
    }

    /**
     * Envia una conversacion (array de messages) y devuelve la respuesta del asistente.
     * Formato de cada message: ['role' => 'user'|'assistant'|'system', 'content' => string]
     *
     * @param array<int, array{role: string, content: string}> $messages
     * @return string Contenido de la respuesta del modelo
     * @throws \RuntimeException Si la API falla o la respuesta no es valida
     */
    public function chat(array $messages): string
    {
        $body = [
            'model'    => $this->config->model,
            'messages' => $messages,
            'stream'   => false,
        ];

        $response = $this->client->post('api/chat', ['json' => $body]);

        if ($response->getStatusCode() >= 400) {
            $bodyRaw = $response->getBody();
            throw new \RuntimeException(
                'Ollama API error: ' . $response->getStatusCode() . ' - ' . $bodyRaw
            );
        }

        $data = json_decode($response->getBody(), true);
        if (! is_array($data) || ! isset($data['message']['content'])) {
            throw new \RuntimeException('Ollama response invalid: missing message.content');
        }

        return (string) $data['message']['content'];
    }
}
