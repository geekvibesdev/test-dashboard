<?php

namespace App\Models;

use App\Controllers\HelperUtility;
use CodeIgniter\Model;

class OpenAIQuerysModel extends Model{

    protected $table              = 'openai_queries';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['req_model', 'req_temperature', 'req_system_content', 'req_user_content', 'resp_id', 'resp_object', 'resp_message', 'resp_usage_prompt_tokens', 'resp_usage_completion_tokens', 'resp_usage_total_tokens', 'resp_created_at', 'resp_response'];
    protected $useTimestamps      = true;
    protected $createdField       = 'fecha_creado';
    protected $updatedField       = 'fecha_actualizado';
    protected $deletedField       = 'fecha_eliminado';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getQueries($id = null)
    {
        if ($id !== null) {
            return $this->find($id);
        }

        return $this->orderBy('fecha_creado', 'DESC')->findAll();
    }

    public function createQuery($data)
    {
        return $this->insert($data);
    }

}
