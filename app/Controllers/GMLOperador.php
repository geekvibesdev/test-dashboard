<?php

namespace App\Controllers;

use App\Models\GMLEnviosModel;

class GMLOperador extends BaseController
{

    protected $gmlEnviosModel;
   
    public function __construct()
    {
        $this->gmlEnviosModel       = new GMLEnviosModel();
    }

    public function operador()
    {
        return $this->render('pages/shared/gml/operador/operador', [
            'title'  => 'GML Operador',
            'assets' => 'gml_operador',
        ]);
    }
 
    public function operadorGuias()
    {
        return $this->render('pages/shared/gml/operador/operador-guias', [
            'title'  => 'GML Guias',
            'assets' => 'gml_guias',
        ]);
    }
    
    public function operadorScanner()
    {
        return $this->render('pages/shared/gml/operador/operador-scanner', [
            'title'  => 'GML Scanner',
            'assets' => 'gml_scanner',
        ]);
    }
    
    public function operadorScannerRecolectar()
    {
        return $this->render('pages/shared/gml/operador/operador-scanner-recolectar', [
            'title'  => 'GML Recolectar',
            'assets' => 'gml_scanner_recolectar',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function operadorScannerTrayecto()
    {
        return $this->render('pages/shared/gml/operador/operador-scanner-trayecto', [
            'title'  => 'GML Trayecto',
            'assets' => 'gml_scanner_trayecto',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function operadorScannerEntregar()
    {
        return $this->render('pages/shared/gml/operador/operador-scanner-entregar', [
            'title'  => 'GML Entregar',
            'assets' => 'gml_scanner_entregar',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
        ]);
    }
    
    public function operadorScannerConsultar()
    {
        return $this->render('pages/shared/gml/operador/operador-scanner-consultar', [
            'title'  => 'GML Consultar',
            'assets' => 'gml_scanner_consultar',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function operadorScannerRecolectarAction()
    {
        $guia = $this->request->getPost('guia');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $guia ])){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Campos faltantes'
            ]);
        }

        // Validar que la guia exista
        $guiaObj = $this->gmlEnviosModel->getItemByGuia($guia);
        if (!$guiaObj) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no existe'
            ]);
        }

        // Validar que no se haya registrado recolección
        if ($guiaObj->guia_fecha_recolectada) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia ya fue recolectada'
            ]);
        }

        // Agrega historico
        $historico = json_decode($guiaObj->historico);
        array_push($historico,
            array(
                'fecha'     => date('Y-m-d'),
                'hora'      => date('H:i:s'),
                'nota'      => 'Guia recolectada',
            )
        );

        // Actualizar recolección
        $data = [
            'historico'             => json_encode($historico),
            'estatus'               => 'recolectada',
            'guia_fecha_recolectada'=> date('Y-m-d H:i:s'),
        ];

        // Respuesta correcta
        if($this->gmlEnviosModel->updateItem($guiaObj->id, $data)){
            return $this->respondWithCsrf([
                'ok'        => true,
            ]);
        }

        // Error al guardar
        return $this->respondWithCsrf([
            'ok'        => false,
            'message'   => 'Error al guardar'
        ]);
    }
    
    public function operadorScannerTransitoAction()
    {
        $guia = $this->request->getPost('guia');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $guia ])){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Campos faltantes'
            ]);
        }

        // Validar que la guia exista
        $guiaObj = $this->gmlEnviosModel->getItemByGuia($guia);
        if (!$guiaObj) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no existe'
            ]);
        }

        // Validar que no se haya registrado transito
        if ($guiaObj->guia_fecha_en_transito) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia ya fue marcada en transito'
            ]);
        }

        // Validar que se haya registrado recolección
        if (!$guiaObj->guia_fecha_recolectada) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no ha sido recolectada, recolecte primero'
            ]);
        }

        // Agrega historico
        $historico = json_decode($guiaObj->historico);
        array_push($historico,
            array(
                'fecha'     => date('Y-m-d'),
                'hora'      => date('H:i:s'),
                'nota'      => 'Guia en transito',
            )
        );

        // Actualizar en transito
        $data = [
            'historico'             => json_encode($historico),
            'estatus'               => 'en_transito',
            'guia_fecha_en_transito'=> date('Y-m-d H:i:s'),
        ];

        // Respuesta correcta
        if($this->gmlEnviosModel->updateItem($guiaObj->id, $data)){
            return $this->respondWithCsrf([
                'ok'        => true,
            ]);
        }

        // Error al guardar
        return $this->respondWithCsrf([
            'ok'        => false,
            'message'   => 'Error al guardar'
        ]);
    }

    public function operadorScannerEntregarAction()
    {
        $guia   = $this->request->getPost('guia');
        $firmaB = $this->request->getPost('firma');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $guia, $firmaB ])){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Campos faltantes'
            ]);
        }

        // Validar que la guia exista
        $guiaObj = $this->gmlEnviosModel->getItemByGuia($guia);
        if (!$guiaObj) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no existe'
            ]);
        }

        // Validar que no se haya registrado entregada
        if ($guiaObj->guia_fecha_entregada) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia ya fue entregada'
            ]);
        }

        // Validar que no se haya registrado transito
        if (!$guiaObj->guia_fecha_en_transito) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no ha sido colocada en transito, registre en transito primero'
            ]);
        }

        // Validar que se haya registrado recolección
        if (!$guiaObj->guia_fecha_recolectada) {
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Guia no ha sido recolectada, recolecte primero'
            ]);
        }

        // Agrega historico
        $historico = json_decode($guiaObj->historico);
        array_push($historico,
            array(
                'fecha'     => date('Y-m-d'),
                'hora'      => date('H:i:s'),
                'nota'      => 'Guia entregada',
            )
        );

        // Guardar firma
        $data   = str_replace('data:image/png;base64,', '', $firmaB);
        $data   = base64_decode($data);
        $firma  = $this->handleFirmaUpload($data);

        // Subir firma
        if(!$firma){
            return $this->respondWithCsrf([
                'ok'        => false,
                'message'   => 'Error al subir firma'
            ]);
        }

        // Actualizar entregado
        $data = [
            'historico'             => json_encode($historico),
            'estatus'               => 'entregada',
            'guia_fecha_entregada'  => date('Y-m-d H:i:s'),
            'firma'                 => $firma,
        ];

        // Respuesta correcta
        if($this->gmlEnviosModel->updateItem($guiaObj->id, $data)){
            return $this->respondWithCsrf([
                'ok'        => true,
            ]);
        }

        // Error al guardar
        return $this->respondWithCsrf([
            'ok'        => false,
            'message'   => 'Error al guardar'
        ]);
    }

    private function handleFirmaUpload($data)
    {
        $firmaArchivo = bin2hex(random_bytes(16)) . '.png';
        $uploadPath = ROOTPATH . 'public/uploads/firmas';

        try {
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0755, true) && !is_dir($uploadPath)) {
                    return false;
                }
            }

            $filePath = $uploadPath . '/' . $firmaArchivo;

            if (empty($data) || !is_writable($uploadPath) || file_put_contents($filePath, $data) === false) {
                return false;
            }

            return 'uploads/firmas/' . $firmaArchivo;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
