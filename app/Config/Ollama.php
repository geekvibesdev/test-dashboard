<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Ollama extends BaseConfig
{
    /** URL base de Ollama (ej. http://localhost:11434 o https://xxx.trycloudflare.com) */
    public string $baseUrl = 'http://localhost:11434';

    /** Modelo a usar (ej. qwen3-coder-next) */
    public string $model = 'qwen3-coder-next';

    /** Timeout en segundos para requests a Ollama */
    public int $timeout = 60;

    public function __construct()
    {
        parent::__construct();
        $this->baseUrl  = rtrim(env('ollama_base_url', $this->baseUrl), '/');
        $this->model    = env('ollama_model', $this->model);
        $this->timeout  = (int) env('ollama_timeout', (string) $this->timeout);
    }
}
