<?php

namespace App\Models;

use App\Controllers\HelperUtility;
use CodeIgniter\Model;

class OpenAISettingsModel extends Model{

    protected $table              = 'openai_settings';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['token', 'url', 'model', 'temperature', 'max_token', 'system_prompt'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getOpenAISettings()
    {
        $settings = $this->first();
        if (!$settings) {
            $this->insert([
                'token'     => HelperUtility::encrypt('your-openai-api-key-here'),
                'url'       => 'https://api.openai.com/v1',
                'model'     => 'gpt-3.5-turbo',
                'max_token' => 300,
                'temperature' => 0.7,
                'system_prompt' => ''
            ]);
            $settings = $this->first();
        }
        return $settings;
    }

    public function updateOpenAISettings($data)
    {
        return $this->update(1, $data);
    }

}
