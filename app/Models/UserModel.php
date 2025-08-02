<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table              = 'users';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'email', 'password', 'last_login', 'active', 'photo', 'rol'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getUsers($id = null)
    {

        $this->select('*');
        
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }
   

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function createUser($name, $email, $password, $photo,  $rol)
    {
        $data = [
            'name'        => $name,
            'email'       => $email,
            'password'    => $password,
            'photo'       => $photo,
            'rol'         => $rol,
        ];

        return $this->insert($data);
    }

    public function setLoginUpdate($id)
    {
        return $this->update($id, [
            'last_login' => date("Y-m-d H:i:s"),
        ]);
    }
    
    public function setNewPassword($id, $password)
    {
        return $this->update($id, [
            'password' => $password,
        ]);
    }

    public function setNewPhoto($id, $photo)
    {
        return $this->update($id, [
            'photo'       => $photo,
        ]);
    }

    public function updateProfile($id, $name)
    {
        return $this->update($id, [
            'name'        => $name
        ]);
    }
    
    public function updateUser($id, $name, $email, $photo, $rol)
    {
        return $this->update($id, [
            'name'        => $name,
            'email'       => $email,
            'photo'       => $photo,
            'rol'         => $rol,
        ]);
    }

    public function activeUser($id)
    {
        return $this->update($id, [
            'active' => 1,
        ]);
    }
    
    public function inactiveUser($id)
    {
        return $this->update($id, [
            'active' => 0,
        ]);
    }
}
