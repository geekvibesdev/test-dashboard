<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        // Obtener el rol del usuario desde la sesión
        $session    = session();
        $user       = $session->get('user');

        // Verificar si el usuario está en la sesión y tiene un rol
        if ($user && isset($user->rol)) {
            $userRole = $user->rol;

            // Verificar si el rol del usuario está permitido
            if (!in_array($userRole, $arguments)) {
                // Si el rol no está permitido, redirigir a la página de error 404
                return redirect()->to('/404');
            }
        } else {
            // Si no hay usuario en la sesión o no tiene rol, redirigir a la página de inicio de sesión
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Lógica después de la solicitud (si es necesario)
    }
}