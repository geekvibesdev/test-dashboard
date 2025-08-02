<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\HelperUtility;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->userModel        = new UserModel();
    }

    public function index(): string
    {
        return $this->renderHeadOnly('pages/shared/auth/login', [
            'title' => 'Login',
        ]);
    }

    public function register()
    {
        $email          = $this->request->getPost('email');             // Mandatory
        $name           = $this->request->getPost('name');              // Mandatory
        $password       = $this->request->getPost('password');          // Mandatory
        $password2      = $this->request->getPost('password-confirm');  // Mandatory
        $rol            = $this->request->getPost('rol');               // Mandatory
        $photo          = $this->request->getFile('photo');             // Optional
        
        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $email, $name, $password, $password2, $rol])){
            return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.missing_fields'));
        }

        // Verificar si las contraseñas coinciden
        if ($password !== $password2) {
            return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.auth_password_not_match'));
        }

        // Verificar si el usuario ya existe
        if ($this->userModel->getUserByEmail($email)) {
            return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.auth_email_exist'));
        }

        // Verificar si la imagen es valida
        if(!$photo->isValid()){
            $photoURL = 'assets/images/anonimo.jpg';

        }else{

            // Subir la imagen
            $this->handlePhotoUpload($photo);

            // Guardar la imagen
            $newName = $photo->getName();
            $photoURL = 'uploads/images/profiles/' . $newName;
        }

        // Encriptar la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    
        // Crear nuevo usuario
        if ($this->userModel->createUser($name, $email, $passwordHash, $photoURL, $rol)) {
            return HelperUtility::redirectWithMessage('/settings/user/new', 'Usuario creado exitosamente', 'success');
        }
    
        // En caso de error
        return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.error_try_again_later'));
    }

    public function activeUser()
    {
        $id = $this->request->getPost('id');

        return $this->respondWithCsrf([
            'ok' => $this->userModel->activeUser($id),
        ]);
    }
    
    public function inactiveUser()
    {
        $user       = $this->session->get('user'); 
        $id         = $this->request->getPost('id');

        // Verificar si se quiere auto desactivar
        if($id == $user->id){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.auth_inactive_samne_account'),
            ]);
        }
    
        return $this->respondWithCsrf([
            'ok' => $this->userModel->inactiveUser($id),
        ]);
        
    }

    public function updateUser()
    {
        $id             = $this->request->getPost('id');                // Mandatory
        $email          = $this->request->getPost('email');             // Mandatory
        $name           = $this->request->getPost('name');              // Mandatory
        $rol            = $this->request->getPost('rol');               // Mandatory
        $password       = $this->request->getPost('password');          // Optional
        $photo          = $this->request->getFile('photo');             // Optional

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $id, $email, $name, $rol])){
            return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.missing_fields'));
        }

        // Encontrar al usuario actual
        $actualUser = $this->userModel->getUsers($id);
        $newImage   = $actualUser->photo;

        // Verificar si el usuario existe
        if (!$actualUser) {
            return HelperUtility::redirectWithMessage("/settings/user/edit/$id", lang('Errors.user_not_found'));
        }

        // En caso de modificar el correo validar si el correo existe
        if($email != $actualUser->email){
            if ($this->userModel->getUserByEmail($email)) {
                return HelperUtility::redirectWithMessage("/settings/user/edit/$id", lang('Errors.auth_email_exist'));
            }
        }

        // En caso de modificar la imagen eliminar la anterior y guardar la nueva
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            // Subir la imagen
            if (!$this->handlePhotoUpload($photo)) {

                // En caso de error
                return HelperUtility::redirectWithMessage('/settings/user/new', lang('Errors.gral_upload_file_error'));
            }

            if($actualUser->photo != 'assets/images/anonimo.jpg'){
                if (file_exists(ROOTPATH . 'public/' . $actualUser->photo)) {
                    unlink(ROOTPATH . 'public/' . $actualUser->photo);
                }
            }

            $newName    = $photo->getName();
            $newImage   = 'uploads/images/profiles/' . $newName;
        }

        // En caso de modificar la contraseña setear la nueva
        if($password != ""){
            $this->setNewPassword($id, $password);
        }

        // Actualizar usuario
        if ($this->updateUserData($id, $name, $email, $newImage, $rol)) {
            return HelperUtility::redirectWithMessage("/settings/user/edit/$id", 'Usuario actualizado exitosamente', 'success');
        }

        return HelperUtility::redirectWithMessage("/settings/user/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user     = $this->userModel->getUserByEmail($email);

        // Verificar si el usuario existe, la contraseña es válida y si esta activo
        if ($user && password_verify($password, $user->password) && $user->active == 1) {
            $this->session->set("user", $user);
            $this->userModel->setLoginUpdate($user->id);

            if($user->rol == 'user'){
                return redirect()->to(base_url('ventas/ordenes'));    
            }
            
            if($user->rol == 'proveedor'){
                return redirect()->to(base_url('ventas/personalizables'));    
            }
           
            if($user->rol == 'externo'){
                return redirect()->to(base_url('/mx/dashboard'));    
            }
           
            if($user->rol == 'gml_operador'){
                return redirect()->to(base_url('/gml/operador'));    
            }

            return redirect()->to(base_url('/dashboard'));
        }

        // En caso credenciales invalidas
        return HelperUtility::redirectWithMessage('/', lang('Errors.auth_invalid_credentials'));
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/'));
    }
    
    // Función auxiliar para actualizar password a un usuario
    private function setNewPassword(int $id, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $this->userModel->setNewPassword($id, $passwordHash);
    }

    // Función auxiliar para actualizar a un usuario
    private function updateUserData(int $id, string $name, string $email, string $photo, string $rol): bool
    {
        return $this->userModel->updateUser($id, $name, $email, $photo, $rol);
    }

    private function handlePhotoUpload($photo) : bool
    {
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            if (in_array($photo->getClientMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {

                $uploadPath = ROOTPATH . 'public/uploads/images/profiles';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $photo->getRandomName();
                $photo->move($uploadPath, $newName);

                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }
}
