<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;

class HelperUtility
{
    // Función auxiliar para renovar CSRF
    public static function getCsrfToken(): array
    {
        $security               = Services::security();
        $response['csrfName']   = $security->getTokenName();
        $response['csrfHash']   = $security->getHash();
        return $response;
    }

    // Función auxiliar para manejar las redirecciones con mensajes
    public static function redirectWithMessage(string $route, string $message, string $type = 'message')
    {
        return redirect()->to(base_url($route))->with($type, $message);
    }

    // Funcion para encriptar una cadena
    public static function encrypt(string $string)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            return base64_encode($encrypter->encrypt($string));
        } catch (\Exception $e) {
            return false;
        }
    }

    // Funcion para desencriptar una cadena
    public static function decrypt(string $string)
    {
        try {
            $encrypter = \Config\Services::encrypter();
            return $encrypter->decrypt(base64_decode($string));
        } catch (\Exception $e) {
            return false;
        }
    }
}
