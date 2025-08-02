<?php

namespace App\Controllers;

use App\Controllers\OrdenHelper;
use App\Controllers\OrdenPersonalizable;

use App\Models\OrdenModel;
use App\Models\OrdenProductosModel;
use App\Models\OrdenFacturacionModel;
use App\Models\OrdenCostoRealModel;
use App\Models\ProductoCostoModel;
use App\Models\OrdenPersonalizableModel;

use App\Controllers\WebhookLog;

class WooCommerce extends BaseController
{

    protected $environment;
    protected $webhookSecret;
    protected $webhookLog;
    protected $ordenModel;
    protected $ordenProductosModel;
    protected $ordenFacturacionModel;
    protected $ordenCostoRealModel;
    protected $wooCommerceUrl;
    protected $wooCommerceConsumerKey;
    protected $wooCommerceConsumerSecret;
    protected $productoCostoModel;
    protected $ordenHelper;
    protected $ordenPersonalizable;
    protected $ordenPersonalizableModel;

    public function __construct()
    {
        $this->webhookSecret        = env('woo_commerce_webhook_secret');
        $this->environment          = env('CI_ENVIRONMENT');
        $this->ordenModel           = new OrdenModel();
        $this->ordenProductosModel  = new OrdenProductosModel();
        $this->ordenFacturacionModel = new OrdenFacturacionModel();
        $this->ordenCostoRealModel  = new OrdenCostoRealModel();
        $this->webhookLog           = new WebhookLog();
        $this->wooCommerceUrl       = env('woo_commerce_url');
        $this->wooCommerceConsumerKey = env('woo_commerce_consumer_key');
        $this->wooCommerceConsumerSecret = env('woo_commerce_consumer_secret');
        $this->productoCostoModel   = new ProductoCostoModel();
        $this->ordenHelper          = new OrdenHelper();
        $this->ordenPersonalizable  = new OrdenPersonalizable();
        $this->ordenPersonalizableModel = new OrdenPersonalizableModel();
    }

    private function wooCommerceAPICall($url)
    {
        $consumerKey    = $this->wooCommerceConsumerKey;
        $consumerSecret = $this->wooCommerceConsumerSecret;

        // Configuración de cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        if (curl_errno($ch)) {

            return null;
        } else {

            // Decodificar la respuesta JSON y convierte a objeto
            $data = json_decode($response);
            return $data;

        }

        curl_close($ch);
    }

    private function wooCommerceAPIPost($url, $data)
    {
        $consumerKey    = $this->wooCommerceConsumerKey;
        $consumerSecret = $this->wooCommerceConsumerSecret;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        } else {
            $result = json_decode($response);
            curl_close($ch);
            return $result;
        }
    }

    private function wooCommerceAPIPut($url, $data)
    {
        $consumerKey    = $this->wooCommerceConsumerKey;
        $consumerSecret = $this->wooCommerceConsumerSecret;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        } else {
            $result = json_decode($response);
            curl_close($ch);
            return $result;
        }
    }

    public function crearNota( $orderId, $note )
    {

        if (!$orderId || !$note || strlen(trim($note)) <= 3) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Campos mandatorios faltantes'
            ]);
        }

        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/orders/'. $orderId .'/notes';
        $data           = [
                            'note' => $note
                        ];
        $response       = $this->wooCommerceAPIPost($url, $data);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al procesar la nota.'
            ]);
        }

        return [
            'ok'        => true,
            'nota'      => $response
        ];
    }

    /*
     ***** Ajax
    */
    public function getProductos()
    {
        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/products?per_page=100';
        $response       = $this->wooCommerceAPICall($url);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener productos.'
            ]);
        }

        return $this->response->setJSON([
            'ok'            => true,
            'productos'     => $response
        ]);
    }

    public function sincronizarProductos()
    {
        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/products?per_page=100';
        $response       = $this->wooCommerceAPICall($url);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener productos.'
            ]);
        }

        $productos = [];

        // Recorre los productos y omite los que tienen status distinto a 'publish'
        foreach ($response as $producto) {
            if ($producto->status == 'publish') {
                $productos[] = [
                    'id_wc'         => $producto->id,
                    'sku'           => $producto->sku,
                    'nombre'        => $producto->name,
                    'precio_venta'  => $producto->price,
                    'inventario'    => $producto->stock_quantity,
                    'slug'          => $producto->slug,
                    'data'          => json_encode($producto),
                    'kit'           => 0,
                    'kit_cantidad'  => null,
                    'kit_producto'  => null,

                ];
            }
        }

        // Recorre el nuevo arreglo y valida que el id_wc tenga formato numerico
        foreach ($productos as $key => $producto) {
            if (!is_numeric($producto['id_wc'])) {
                return $this->response->setJSON([
                    'ok'        => false,
                    'message'   => 'Error en el producto: ' . $producto['nombre'] . ' ID no es numerico.'
                ]);
            }
        }

        // Recorre el nuevo arreglo y valida que SKU tenga formato numerico
        foreach ($productos as $key => $producto) {
            if (!is_numeric($producto['sku'])) {
                return $this->response->setJSON([
                    'ok'        => false,
                    'message'   => 'Error en el producto: ' . $producto['nombre'] . ' SKU no es numerico.'
                ]);
            }
        }

        // Recorre el nuevo arreglo y valida que precio_venta tenga formato numerico
        foreach ($productos as $key => $producto) {
            if (!is_numeric($producto['precio_venta'])) {
                return $this->response->setJSON([
                    'ok'        => false,
                    'message'   => 'Error en el producto: ' . $producto['nombre'] . ' Precio de venta no es numerico.'
                ]);
            }
        }
        
        // Recorre el nuevo arreglo y valida que inventario tenga formato numerico o null
        foreach ($productos as $key => $producto) {
            if (!is_numeric($producto['inventario']) && !is_null($producto['inventario'])) {
                return $this->response->setJSON([
                    'ok'        => false,
                    'message'   => 'Error en el producto: ' . $producto['nombre'] . ' Inventario no es numerico.'
                ]);
            }
        }
        
        // Recorre el nuevo arreglo, si el SKU ya existe, actualiza el producto y si no existe, lo crea
        foreach ($productos as $key => $producto) {
            $existingProduct = $this->productoCostoModel->getProductoCostoByIdWc($producto['id_wc']);
            if ($existingProduct) {
                $this->productoCostoModel->updateProductoCosto($existingProduct->id, $producto['id_wc'], $producto['sku'], $producto['nombre'], $producto['precio_venta'], $existingProduct->costo, $producto['inventario'] == null ? 0 : $producto['inventario'], $producto['slug'], $producto['data'], $existingProduct->kit, $existingProduct->kit_cantidad, $existingProduct->kit_producto);
            } else {
                $this->productoCostoModel->createProductoCosto($producto['id_wc'], $producto['sku'], $producto['nombre'], $producto['precio_venta'], null, $producto['inventario'], $producto['slug'], $producto['data'], $producto['kit'], $producto['kit_cantidad'], $producto['kit_producto']);
            }
        }

        return $this->response->setJSON([
            'ok'            => true,
            'message'       => 'Productos sincronizados correctamente.',
        ]);
    }

    public function getTaxes()
    {
        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/settings/tax';
        $response       = $this->wooCommerceAPICall($url);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener impuestos.'
            ]);
        }

        return $this->response->setJSON([
            'ok'            => true,
            'impuestos'     => $response
        ]);
    }

    public function getCliente($clientId)
    {
        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/customers/' . $clientId;
        $response       = $this->wooCommerceAPICall($url);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener cliente.'
            ]);
        }

        return $this->response->setJSON([
            'ok'        => true,
            'cliente'     => $response
        ]);
    }

    public function getNotas($orderId)
    {
        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/orders/' . $orderId . '/notes';
        $response       = $this->wooCommerceAPICall($url);

        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al obtener las notas de la orden.'
            ]);
        }

        return $this->response->setJSON([
            'ok'        => true,
            'notas'     => $response
        ]);
    }

    public function updateStatus()
    {

        $orderId        = $this->request->getPost('order');
        $existingOrder  = $this->ordenModel->getOrdenesByOrden($orderId);

        if ( !$existingOrder ) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Orden inválida'
            ]);
        }

        $url            = $this->wooCommerceUrl . '/wp-json/wc/v3/orders/'. $orderId;
        $data           = [
                            'status' => 'completed'
                        ];
        $response       = $this->wooCommerceAPIPut($url, $data);

        // Error en CURL
        if (is_null($response)) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al procesar el estatus.'
            ]);
        }

        // Error en WooCommerce
        if(isset($response->code)){
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Error al procesar el estatus code.',
                'resp'      => $response
            ]);
        }

        // Actualizar estatus en la base de datos
        $this->ordenModel->actualizarOrdenByWcOrden($orderId, ['estatus_orden' => 'completed']);
        return $this->response->setJSON([
            'ok'        => true,
            'orden'     => $response
        ]);
    }

    /*
     ***** WebhookS
    */

    public function validarWebhook()
    {
        // Si el entorno es local, no validar la firma del webhook
        if ($this->environment == 'development'){
            return true;
        }

        $signatureHeader    = $this->request->getHeaderLine('X-WC-Webhook-Signature');
        $rawBody            = file_get_contents('php://input');
        $webhookSecret      = $this->webhookSecret;
        $expectedSignature  = base64_encode(hash_hmac('sha256', $rawBody, $webhookSecret, true));
        return hash_equals($expectedSignature, $signatureHeader);
    }

    public function webhookLog($type, $request, $response, $status)
    {
        $this->webhookLog->crearLog([
            'type'      => $type,
            'request'   => json_encode($request),
            'response'  => json_encode($response),
            'status'    => $status,
        ]);
    }

    public function webhookCreate()
    {
        // Validar la firma del webhook
        if (!$this->validarWebhook()) {
            $response = [
                'ok'        => false, 
                'message'   => 'Firma de Webhook no válida.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 401);
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        // Obtener el cuerpo de la solicitud y decodificar el JSON
        $order = $this->request->getJson(true);

        // Verificar si el cuerpo de la solicitud es válido
        $orderId        = $order['id'];
        $existingOrder  = $this->ordenModel->getOrdenesByOrden($orderId);

        // Verificar si el ID de la orden es válido
        if (is_null($orderId)) {
            $response = [
                'ok'        => false, 
                'message'   => 'El ID de la orden no es válido.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 400);
            return $this->response->setJSON($response);
        }

        // Si la orden ya existe, devolver un mensaje de error
        if (!empty($existingOrder)) {
            $response = [
                'ok'        => false, 
                'message'   => 'La orden ya existe.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 409);
            return $this->response->setJSON($response);
        }

        // Guardar productos de la orden
        $productos = $this->ordenProductosModel->crearOrdenProductos($orderId, json_encode($order['line_items']));
        if (!$productos) {
            $response = [
                'ok'        => false, 
                'message'   => 'Error al guardar los productos de la orden.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 500);
            return $this->response->setJSON($response);
        }

        // Guardar datos de facturación
        $facturacion = $this->ordenFacturacionModel->crearOrdenFacturacion($orderId, json_encode($order['billing']), $order['billing']['billing_require_facturacion']);
        if (!$facturacion) {
            $response = [
                'ok'        => false, 
                'message'   => 'Error al guardar los datos de facturación.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 500);
            return $this->response->setJSON($response);
        }

        // Crear orden de costo real
        $costoReal = $this->ordenCostoRealModel->crearOrdenCostoreal($orderId, $order['shipping_total'] == 0 ? 1 : null );
        if (!$costoReal) {
            $response = [
                'ok'        => false, 
                'message'   => 'Error al guardar los datos de costo real.'
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 500);
            return $this->response->setJSON($response);
        }

        // Crear arreglo de datos de orden
        $data = [
            'orden'                => $order['id'],
            'cliente_id'           => $order['customer_id'],
            'fecha_orden'          => $order['date_created'],
            'estatus_orden'        => $order['status'],
            'envio_direccion'      => json_encode($order['shipping']),
            'envio_tipo'           => $order['shipping_lines'][0]['method_title'] ?? null,
            'cot_envio_total'      => $order['shipping_total'],
            'orden_impuestos'      => $order['total_tax'],
            'orden_total'          => $order['total'],
            'pago_metodo'          => $order['payment_method'],
            'pago_id'              => $order['transaction_id'],
            'webhook_request'      => json_encode($order),
            'productos'            => $productos,
            'facturacion'          => $facturacion,
            'costo_real'           => $costoReal,
        ];

        // Guardar la orden en la base de datos
        if ($this->ordenModel->crearOrden($data)) {

            // Verificar si cuenta con productos personalizables y de ser asi crear el correspondiente
            $ordenObject    = $this->ordenModel->getOrdenesByOrden($order['id']);
            $orden          = $this->ordenHelper->setOrdenes([$ordenObject]);
            if($ordenObject && $orden[0]->productos_personalizados && $orden[0]->estatus_orden == 'processing'){
                $this->ordenPersonalizable->create($order['id']);
            }

            $response = [
                'ok' => true
            ];
            $this->webhookLog('create', $this->request->getJson(true), $response, 200);
            return $this->response->setJSON($response);
        }

        // Si no se pudo guardar la orden, devolver un mensaje de error
        $response = [
            'ok'        => false, 
            'message'   => 'Error al guardar la orden.'
        ];
        $this->webhookLog('create', $this->request->getJson(true), $response, 500);
        return $this->response->setJSON($response);
    }

    public function webhookUpdate()
    {
        // Validar la firma del webhook
        if (!$this->validarWebhook()) {
            $response = [
                'ok'        => false, 
                'message'   => 'Firma de Webhook no válida.'
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 401);
            return $this->response->setStatusCode(401)->setJSON($response);
        }

        // Obtener el cuerpo de la solicitud y decodificar el JSON
        $order = $this->request->getJson(true);

        // Verificar si el cuerpo de la solicitud es válido
        $orderId        = $order['id'];
        $existingOrder  = $this->ordenModel->getOrdenesByOrden($orderId);

        // Verificar si el ID de la orden es válido
        if (is_null($orderId)) {
            $response = [
                'ok'        => false, 
                'message'   => 'El ID de la orden no es válido.'
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 400);
            return $this->response->setJSON($response);
        }

        // Si la orden NO existe, devolver un mensaje de error
        if (empty($existingOrder)) {
            $response = [
                'ok'        => false, 
                'message'   => 'La orden no existe.'
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 409);
            return $this->response->setJSON($response);
        }

        // Actualizar productos de la orden
        $productos = $this->ordenProductosModel->actualizarOrdenProductosByWcOrden($orderId, json_encode($order['line_items']));
        if (!$productos) {
            $response = [
                'ok'        => false, 
                'message'   => 'Error al actualizar los productos de la orden.'
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 500);
            return $this->response->setJSON($response);
        }
       
        // Actualizar datos de facturación
        $facturacion = $this->ordenFacturacionModel->actualizarOrdenFacturacionDatosByWcOrden($orderId, json_encode($order['billing']));
        if (!$facturacion) {
            $response = [
                'ok'        => false, 
                'message'   => 'Error al actualizar los datos de facturación.'
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 500);
            return $this->response->setJSON($response);
        }

        // Actualizar estado de la orden y otros datos 
        $data = [
            'estatus_orden'         => $order['status'],
            'envio_direccion'       => json_encode($order['shipping']),
            'pago_metodo'           => $order['payment_method'],
            'pago_id'               => $order['transaction_id'],
            'webhook_request'       => json_encode($order),
        ];

        // Actualizar la orden en la base de datos
        if ($this->ordenModel->actualizarOrdenByWcOrden($orderId, $data)) {

            // Verificar si cuenta con productos personalizables y de ser asi crear el correspondiente
            $ordenPersonalizable = $this->ordenPersonalizableModel->getOrdenPersonalizableByWcOrden($orderId);
            $ordenObject    = $this->ordenModel->getOrdenesByOrden($orderId);
            $orden          = $this->ordenHelper->setOrdenes([$ordenObject]);
            if($ordenObject && $orden[0]->productos_personalizados && $orden[0]->estatus_orden == 'processing' && !$ordenPersonalizable){
                $this->ordenPersonalizable->create($orderId);
            }

            $response = [
                'ok' => true
            ];
            $this->webhookLog('update', $this->request->getJson(true), $response, 200);
            return $this->response->setJSON($response);
        }

        // Si no se pudo actualizar la orden, devolver un mensaje de error
        $response = [
            'ok'        => false, 
            'message'   => 'Error al actualizar la orden.'
        ];
        $this->webhookLog('update', $this->request->getJson(true), $response, 500);
        return $this->response->setJSON($response);
    }
}
