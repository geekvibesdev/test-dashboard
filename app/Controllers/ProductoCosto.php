<?php

namespace App\Controllers;

use App\Models\ProductoCostoModel;
use App\Controllers\HelperUtility;

class ProductoCosto extends BaseController
{
    protected $productoCostoModel;

    public function __construct()
    {
        $this->lang                 = \Config\Services::language();
        $this->lang                 ->setLocale('es');
        $this->productoCostoModel   = new ProductoCostoModel();
    }

    public function index(): string
    {
        $productosCosto = $this->productoCostoModel->getProductoCosto();
        return $this->render('pages/admin/producto/producto-costo', [
            'title'  => 'Productos',
            'assets' => 'admin_productos',
            'csrfName' => csrf_token(),    
            'csrfHash' => csrf_hash(),
            'productos_costos' => $productosCosto
        ]);
    }

    public function newProductoCosto(): string
    {
        return $this->render('pages/admin/producto/producto-costo-new', [
            'title'  => 'Nuevo Producto',
            'assets' => 'admin_productos_new',
        ]);
    }

    public function editProductoCosto($id): string
    {
        $productoCosto = $this->productoCostoModel->getProductoCosto($id);
        if(!$productoCosto) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        return $this->render('pages/admin/producto/producto-costo-edit', [
            'title'  => 'Editar Producto',
            'assets' => 'admin_productos_edit',
            'productos' =>  $this->productoCostoModel->getProductoCosto(),
            'producto_costo' => $productoCosto,
        ]);
    }

    public function createProductoCosto()
    {
        $id_wc          = $this->request->getPost('id_wc');
        $sku            = $this->request->getPost('sku');
        $nombre         = $this->request->getPost('nombre');
        $precio_venta   = $this->request->getPost('precio_venta');
        $costo          = $this->request->getPost('costo');
        $inventario     = $this->request->getPost('inventario');
        $slug           = $this->request->getPost('slug');
        $kit            = $this->request->getPost('kit');
        $kit_cantidad   = $this->request->getPost('kit_cantidad');
        $kit_producto   = $this->request->getPost('kit_producto');
        $data           = json_encode(array('data' => null, 'created_on' => 'panel'));

        // Validación inicial de los campos requeridos
        if (!$id_wc ||!$sku || !$nombre || !$precio_venta || !$costo || !$inventario || !$slug) {
            return HelperUtility::redirectWithMessage('/settings/productos/new', lang('Errors.missing_fields'));
        }

        // Verificar si el ID de WC ya existe
        if ($this->productoCostoModel->getProductoCostoByIdWc($id_wc)) {
            return HelperUtility::redirectWithMessage('/settings/productos/new', lang('Errors.gral_duplicated_ID_WC'));
        }

        // Crear nuevo producto costo
        if ($this->productoCostoModel->createProductoCosto($id_wc, $sku, $nombre, $precio_venta, $costo, $inventario, $slug, $data, $kit == 'om' ? 1 : 0, $kit_cantidad, $kit_producto)) {
            return HelperUtility::redirectWithMessage('/settings/productos/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/settings/productos/new', lang('Errors.error_try_again_later'));
    }

    public function updateProductoCosto()
    {
        $id_wc          = $this->request->getPost('id_wc');
        $sku            = $this->request->getPost('sku');
        $nombre         = $this->request->getPost('nombre');
        $precio_venta   = $this->request->getPost('precio_venta');
        $costo          = $this->request->getPost('costo');
        $inventario     = $this->request->getPost('inventario');
        $kit            = $this->request->getPost('kit');
        $kit_cantidad   = $this->request->getPost('kit_cantidad');
        $kit_producto   = $this->request->getPost('kit_producto');
        $id             = $this->request->getPost('id');
        
        $productoCosto  = $this->productoCostoModel->getProductoCosto($id);

        if(!$productoCosto){
            return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Errors.gral_not_found'));
        }

        if($kit == 'on'){
            if (!$kit_producto ) {
                return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Errors.missing_fields'));
            }
            if ($kit_cantidad < 1 ) {
                return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", 'Cantidad de productos por Kit inválida');
            }
        }

        // Validación inicial de los campos requeridos
        if (!$id_wc || !$sku || !$nombre || !$precio_venta || !$costo || !$inventario ) {
            return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el producto costo existe
        if ($this->productoCostoModel->getProductoCosto($id) && $productoCosto->id != $id) {
            return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Errors.missing_fields'));
        }

        // Actualizar producto costo
        if ($this->productoCostoModel->updateProductoCosto($id, $id_wc, $sku, $nombre, $precio_venta, $costo, $inventario, $productoCosto->slug, $productoCosto->data, $kit == 'on' ? 1 : 0, $kit == 'on' ? $kit_cantidad : null, $kit == 'on' ? $kit_producto : null)) {
            return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/settings/productos/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deleteProductoCosto()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $productoCosto = $this->productoCostoModel->getProductoCosto($id);
        if (!$productoCosto) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->productoCostoModel->deleteProductoCosto($id)){
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

    public function getProducto($id)
    {
        // Verificar si existe
        $productoCosto = $this->productoCostoModel->getProductoCosto($id);

        if (!$productoCosto) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // En caso de error
        return $this->respondWithCsrf([
            'ok'            => true,
            'producto'      => $productoCosto,
        ]);
    }
}
