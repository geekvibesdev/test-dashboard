<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        // Si no está autenticado, redirigir al login
        if (!session('user')) {
            return redirect()->to('/')->with('message', 'Por favor inicia sesión');
        }

        // Si no tiene permisos, redirigir a 404
        if($arguments){
            $rol = session('user')->rol;
            if(!in_array($rol, $arguments)){
                return redirect()->to('/404');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Lógica después de la solicitud (si es necesario)
    }
}