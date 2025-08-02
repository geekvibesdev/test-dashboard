<?php

namespace App\Controllers;

use App\Models\CuentaPorPagarModel;
use App\Models\ProveedorModel;
use App\Models\FacturaCategoriaModel;

use App\Controllers\HelperUtility;

class CuentaPorPagar extends BaseController
{
    protected $cuentaPorPagarModel;
    protected $proveedorModel;

    public function __construct()
    {
        $this->lang                     = \Config\Services::language();
        $this->lang                     ->setLocale('es');
        $this->proveedorModel           = new ProveedorModel();
        $this->facturaCategoriaModel    = new FacturaCategoriaModel();
        $this->cuentaPorPagarModel      = new CuentaPorPagarModel();
        $this->assets                   = new Assets();
    }

    public function index(): string
    {
        return $this->render('pages/admin/contabilidad/cuenta-por-pagar', [
            'title' => 'Cuentas por Pagar',
            'assets'=> 'cuentas_por_pagar',
            'cuentas_por_pagar' => $this->cuentaPorPagarModel->getItem(),
        ]);
    }

    public function newCuentaPorPagar(): string
    {
        return $this->render('pages/admin/contabilidad/cuenta-por-pagar-new', [
            'title'                 => 'Cuentas por Pagar - Alta',
            'assets'                => 'cuentas_por_pagar_new',
            'proveedores'           => $this->proveedorModel->getItem(),
            'factura_categorias'    => $this->facturaCategoriaModel->getItem()
        ]);
    }

    public function editCuentaPorPagar($id): string
    {
        $cuentaPorPagar = $this->cuentaPorPagarModel->getItem($id);
        if (!$cuentaPorPagar) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/contabilidad/cuenta-por-pagar-edit', [
            'title'             => 'Cuentas por Pagar - Alta',
            'assets'            => 'cuentas_por_pagar_edit',
            'cuenta_por_pagar'  => $cuentaPorPagar,
            'proveedores'       => $this->proveedorModel->getItem(),
            'factura_categorias'=> $this->facturaCategoriaModel->getItem()
        ]);
    }

    public function createCuentaPorPagar()
    {
        $id_proveedor       = $this->request->getPost('id_proveedor');
        $factura_folio      = $this->request->getPost('factura_folio');
        $factura_tipo       = $this->request->getPost('factura_tipo');
        $factura_monto      = $this->request->getPost('factura_monto');
        $factura_categoria  = $this->request->getPost('factura_categoria');
        $factura_pdf        = $this->request->getFile('factura_pdf');
        $pago_estatus       = 'en_proceso';
        $credito_dias       = $this->request->getPost('credito_dias');
        $fecha_emision      = $this->request->getPost('fecha_emision');
        $fecha_pago         = $this->request->getPost('fecha_pago');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $id_proveedor, $factura_folio, $factura_tipo, $factura_monto, $factura_categoria, $factura_pdf, $credito_dias, $fecha_emision, $fecha_pago ])){
            return HelperUtility::redirectWithMessage('/contabilidad/cuenta-por-pagar/new', lang('Errors.missing_fields'));
        }

        // Subir PDF de la factura
        if($this->handleFacturaUpload($factura_pdf)){
            $newName            = $factura_pdf->getName();
            $factura_pdf_url    = 'uploads/facturas/' . $newName;
        }else{
            return HelperUtility::redirectWithMessage('/contabilidad/cuenta-por-pagar/new', 'Error al subir PDF');
        }

        // Crear nuevo
        if ($this->cuentaPorPagarModel->createItem($id_proveedor, $factura_folio, $factura_tipo, $factura_monto, $factura_categoria, $factura_pdf_url, $pago_estatus, $credito_dias, $fecha_emision, $fecha_pago)) {
            return HelperUtility::redirectWithMessage('/contabilidad/cuenta-por-pagar/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/contabilidad/cuenta-por-pagar/new', lang('Errors.error_try_again_later'));
    }

    public function updateCuentaPorPagar()
    {
        $id                 = $this->request->getPost('id');
        $id_proveedor       = $this->request->getPost('id_proveedor');
        $factura_folio      = $this->request->getPost('factura_folio');
        $factura_tipo       = $this->request->getPost('factura_tipo');
        $factura_monto      = $this->request->getPost('factura_monto');
        $factura_categoria  = $this->request->getPost('factura_categoria');
        $factura_pdf_url    = $this->request->getPost('factura_pdf_url');
        $factura_pdf        = $this->request->getFile('factura_pdf');
        $pago_estatus       = $this->request->getPost('pago_estatus');
        $credito_dias       = $this->request->getPost('credito_dias');
        $fecha_emision      = $this->request->getPost('fecha_emision');
        $fecha_pago         = $this->request->getPost('fecha_pago');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([ $id, $id_proveedor, $factura_pdf_url, $factura_folio, $factura_tipo, $factura_monto, $factura_categoria, $pago_estatus, $credito_dias, $fecha_emision, $fecha_pago ])){
            return HelperUtility::redirectWithMessage("/contabilidad/cuenta-por-pagar/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si enviaron nuevo PDF
        if ($factura_pdf && $factura_pdf->isValid() && !$factura_pdf->hasMoved()) {
            // Subir PDF de la factura
            if($this->handleFacturaUpload($factura_pdf)){
                $newName            = $factura_pdf->getName();
                $factura_pdf        = 'uploads/facturas/' . $newName;
            }else{
                return HelperUtility::redirectWithMessage("/contabilidad/cuenta-por-pagar/edit/$id", 'Error al subir PDF');
            }
        }else{
            $factura_pdf = $factura_pdf_url; // Mantener el PDF existente si no se subió uno nuevo
        }

        // Actualizar cuenta por pagar
        $data = [  
            'id_proveedor'     => $id_proveedor,
            'factura_folio'    => $factura_folio,
            'factura_tipo'     => $factura_tipo,
            'factura_monto'    => $factura_monto,
            'factura_categoria'=> $factura_categoria,
            'factura_pdf'      => $factura_pdf,
            'pago_estatus'     => $pago_estatus,
            'credito_dias'     => $credito_dias,
            'fecha_emision'    => $fecha_emision,
            'fecha_pago'       => $fecha_pago
        ];

        if ($this->cuentaPorPagarModel->updateItem($id, $data)) {
            return HelperUtility::redirectWithMessage("/contabilidad/cuenta-por-pagar/edit/$id", lang('Success.gral_update'), 'success');
        }
        return HelperUtility::redirectWithMessage("/contabilidad/cuenta-por-pagar/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deleteCuentaPorPagar()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $cuentaPorPagar = $this->cuentaPorPagarModel->getItem($id);
        if (!$cuentaPorPagar) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->cuentaPorPagarModel->deteleteItem($id)){
            return $this->respondWithCsrf([
                'ok'            => true,
            ]);
        }

        // En caso de error
        return $this->respondWithCsrf([
            'ok'            => false,
            'error'         => lang('Errors.error_try_again_later'),
        ]);
    }
    
    public function getCuentasPorPagar()
    {
        $cuentasPorPagar = $this->cuentaPorPagarModel->getItem();
        return $this->response->setJSON([
            'ok'                => true,
            'cuentas_por_pagar' => $cuentasPorPagar
        ]);
    }
    
    public function getCuentasPorPagarFiltro()
    {
        $fechaInicio        = $this->request->getGet('fecha_inicio');
        $fechaFin           = $this->request->getGet('fecha_fin');
        $estatus            = $this->request->getGet('estatus');

        $cuentasPorPagar = $this->cuentaPorPagarModel->getItemFiltro($fechaInicio, $fechaFin, $estatus);

        return $this->response->setJSON([
            'ok'                => true,
            'cuentas_por_pagar' => $cuentasPorPagar
        ]);
    }

    private function handleFacturaUpload($factura_pdf) : bool
    {
        if ($factura_pdf && $factura_pdf->isValid() && !$factura_pdf->hasMoved()) {
            if ($factura_pdf->getClientMimeType() === 'application/pdf') {
                $uploadPath = ROOTPATH . 'public/uploads/facturas';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $newName = $factura_pdf->getRandomName();
                $factura_pdf->move($uploadPath, $newName);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
