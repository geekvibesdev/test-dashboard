<?php

namespace App\Controllers;

use App\Models\ProductoCostoModel;

class OrdenHelper extends BaseController
{
    protected $productoCostoModel;

    public function __construct()
    {
        $this->productoCostoModel = new ProductoCostoModel();
    }
    
    public function setOrdenes($ordenes)
    {
        foreach ($ordenes as $orden) {
            // Decodificar datos de la orden
            $this->decodeOrdenData($orden);

            // Calcular costos de productos
            $costos = $this->calcularCostosProductos($orden);

            // Calcular utilidades
            $utilidad = $this->calcularUtilidades($orden, $costos);

            // Calcular costos de envío y descuentos
            $envioYDescuentos = $this->calcularEnvioYDescuentos($orden, $costos['descuentos']);

            // Calcular utilidad_orden_sin_impuestos_mas_50_prom
            $utilidad_orden_sin_impuestos_mas_50_prom = 'Pendiente';
            if ($utilidad['utilidad_orden_sin_impuestos'] !== 'Pendiente' ) {
                $utilidad_orden_sin_impuestos_mas_50_prom =  round((float)$utilidad['utilidad_orden_sin_impuestos'], 2);
                if ($envioYDescuentos['descuentos_50'] !== 'Pendiente') {
                    $utilidad_orden_sin_impuestos_mas_50_prom += round((float)$envioYDescuentos['descuentos_50'], 2);
                }
            }

            // Calcular utilidad_final_sin_impuestos_con_promociones_porcentaje
            $utilidad_final_sin_impuestos_con_promociones_porcentaje = 'Pendiente';
            if ($utilidad_orden_sin_impuestos_mas_50_prom !== 'Pendiente' && $costos['subtotal'] > 0 ) {
                $utilidad_final_sin_impuestos_con_promociones_porcentaje = round(((float)$utilidad_orden_sin_impuestos_mas_50_prom /  (float)$costos['subtotal']) * 100, 2);
            }
            
            // Calcular utilidad_final_sin_impuestos_sin_promociones_porcentaje
            $utilidad_final_sin_impuestos_sin_promociones_porcentaje = 'Pendiente';
            if ($utilidad['utilidad_orden_sin_impuestos'] !== 'Pendiente' && $costos['subtotal'] > 0 ) {
                $utilidad_final_sin_impuestos_sin_promociones_porcentaje = round(((float)$utilidad['utilidad_orden_sin_impuestos'] /  (float)$costos['subtotal']) * 100, 2);
            }

            // Agregar costos, utilidades y otros datos a la orden
            $orden->orden_envio                     = $orden->cot_envio_total;
            $orden->orden_subtotal                  = round($costos['subtotal'], 2);
            $orden->orden_descuentos                = round($costos['descuentos'], 2);
            $orden->orden_descuentos_50_porciento   = $envioYDescuentos['descuentos_50'];
            $orden->orden_descuentos_titulos        = $costos['descuentos_aplicados'];
            $orden->orden_geek_merchandise          = $this->formatearGeekMerchandise($costos, $orden->real_envio_costo);
            $orden->utilidad                        = $utilidad;
            $orden->utilidad['utilidad_orden_sin_impuestos_mas_50_prom']    = $utilidad_orden_sin_impuestos_mas_50_prom;
            $orden->utilidad['utilidad_final_sin_impuestos_con_promociones_porcentaje']     = $utilidad_final_sin_impuestos_con_promociones_porcentaje;
            $orden->utilidad['utilidad_final_sin_impuestos_sin_promociones_porcentaje']     = $utilidad_final_sin_impuestos_sin_promociones_porcentaje;

            // Elimina webhook_request de la respuesta del objeto
            unset($orden->webhook_request);
        }

        return $ordenes;
    }

    private function decodeOrdenData($orden)
    {
        $orden->productos           = json_decode($orden->productos);
        $orden->envio_direccion     = json_decode($orden->envio_direccion);
        $orden->facturacion_datos   = json_decode($orden->facturacion_datos);
        $orden->webhook_request     = json_decode($orden->webhook_request);
        $orden->metodo_pago         = $orden->webhook_request->payment_method_title ?? null;
        $orden->impuestos           = $orden->webhook_request->tax_lines ?? [];

        // Construir dirección de envío completa
        $direccion_envio_completa = $orden->envio_direccion->address_1 . ', ' . 
                                    $orden->envio_direccion->address_2 . ', ' . 
                                    $orden->envio_direccion->city . ', ' . 
                                    $orden->envio_direccion->state . ', C.P. ' . 
                                    $orden->envio_direccion->postcode;

        $orden->direccion_envio_completa    = strtoupper($direccion_envio_completa);
        $orden->notas_de_entrega            = $orden->webhook_request->customer_note;

        // Agrega a $orden->facturacion_datos el nombre y la ruta del PDF con la constancia de situacion fiscal
        $orden->facturacion_datos->csf_url = null;
        foreach ($orden->webhook_request->meta_data as $meta) {
            if (isset($meta->key) && $meta->key == '_billing_constancia_sit_fiscal') {
                $meta->value = json_decode($meta->value);

                // Obtener el primer elemento del objeto
                $arrayMetaValue = (array)$meta->value;
                $elemento = reset($arrayMetaValue);

                if (is_object($elemento) && isset($elemento->url)) {
                    $orden->facturacion_datos->csf_url = $elemento->url;
                }
            }
        }
    }

    private function calcularCostosProductos($orden)
    {
        $orden->productos_personalizados = false;
        $costos = [
            'con_impuestos' => 0,
            'sin_impuestos' => 0,
            'pendientes'    => false,
            'subtotal'      => 0,
            'descuentos'    => 0,
            'descuentos_aplicados' => [],
        ];
    
        foreach ($orden->productos as $producto) {
            
            $productoObject                         = $this->productoCostoModel->getProductoCostoByIdWc($producto->product_id);
            $producto->producto_personalizado       = false;
            $producto->tiene_descuento              = false;
            $producto->descuento_aplicado           = "";
            $producto->producto_personalizado_texto = "";

            if ($productoObject && $productoObject->costo > 0) {
                $costos['con_impuestos'] += round($productoObject->costo * $producto->quantity, 2);
                $costos['sin_impuestos'] += round(($productoObject->costo * $producto->quantity) / ($orden->impuestos[0]->rate_percent / 100 + 1), 2);
    
                // Calcular el costo unitario con y sin impuestos
                $producto->costo_unitario               = round($productoObject->costo / ($orden->impuestos[0]->rate_percent / 100 + 1), 2);
                $producto->costo_unitario_mas_impuestos = $productoObject->costo;
            } else {
                $costos['pendientes'] = true;
            }
    
            // Procesar descuentos
            if (isset($producto->meta_data)) {
                foreach ($producto->meta_data as $meta) {
                    if (isset($meta->key) && $meta->key == '_wdr_discounts') {
                        $producto->tiene_descuento      = true;
                        $producto->descuento_aplicado   = $meta->value->applied_rules[0]->title;
                        $costos['descuentos'] += $meta->value->saved_amount;
                        $costos['descuentos_aplicados'][] = $meta->value->applied_rules[0]->title;
                    }
                }
            }

            // Procesar personalizados
            if (isset($producto->meta_data)) {
                foreach ($producto->meta_data as $meta) {
                    if (isset($meta->key) && $meta->key == 'Linea 1') {
                        $orden->productos_personalizados = true;
                        $producto->producto_personalizado       = true;
                        $producto->producto_personalizado_texto .= $meta->value;
                    }
                    if (isset($meta->key) && $meta->key == 'Linea 2 (opcional)') {
                        if($meta->value != ""){
                            $producto->producto_personalizado       = true;
                            $producto->producto_personalizado_texto .= " | ".$meta->value;
                        }
                    }
                    if (isset($meta->key) && $meta->key == 'Las aplicaciones de flores naturales en las etiquetas pueden variar de color y tamaño.') {
                        $producto->producto_personalizado       = true;
                        $producto->producto_personalizado_texto .= " | ".$meta->value;
                    }
                    if (isset($meta->key) && $meta->key == 'Texto sobre caja de madera') {
                        $orden->productos_personalizados = true;
                        $producto->producto_personalizado       = true;
                        $producto->producto_personalizado_texto .= "Texto sobre caja de madera: ".$meta->value;
                    }
                    if (isset($meta->key) && $meta->key == 'Inicial sobre sello de madera') {
                        $producto->producto_personalizado       = true;
                        $producto->producto_personalizado_texto .= " | Inicial sobre sello de madera: ".$meta->value;
                    }
                    if (isset($meta->key) && $meta->key == 'Texto sobre etiqueta personalizada') {
                        $producto->producto_personalizado       = true;
                        $producto->producto_personalizado_texto .= " | Texto sobre etiqueta personalizada: ".$meta->value;
                    }
                }
            }

    
            $costos['subtotal'] += $producto->total;
        }
    
        return $costos;
    }

    private function calcularUtilidades($orden, $costos)
    {
        $utilidad = [
            'utilidad_productos_sin_impuestos'          => round($costos['subtotal'] - $costos['sin_impuestos'],2),
            'utilidad_paqueteria'                       => 'Pendiente',
            'utilidad_orden_sin_impuestos'              => 'Pendiente',
            'utilidad_productos_sin_impuestos_porcentaje' => $costos['sin_impuestos'] > 0 ? round((1 - ($costos['sin_impuestos'] / $costos['subtotal'])) * 100, 2) : 0,
        ];

        if ($orden->real_envio_costo > 0 && is_numeric($utilidad['utilidad_productos_sin_impuestos'])) {
            $utilidad['utilidad_paqueteria'] = round($orden->cot_envio_total - $orden->real_envio_costo, 2);
            $real_envio_costo = is_numeric($orden->real_envio_costo) ? $orden->real_envio_costo : 0;
            $utilidad['utilidad_orden_sin_impuestos'] = round($utilidad['utilidad_productos_sin_impuestos'] - $real_envio_costo +  $orden->cot_envio_total, 2);
        }

        return $utilidad;
    }

    private function calcularEnvioYDescuentos($orden, $descuentos)
    {

        return [
            'descuentos_50'     => round($descuentos * 0.5, 2),
        ];
    }

    private function formatearGeekMerchandise($costos, $real_envio_costo)
    {
        return [
            'orden_costos_productos_pendientes'     => $costos['pendientes'],
            'orden_costos_productos_con_impuestos'  => round($costos['con_impuestos'], 2),
            'orden_costos_productos_sin_impuestos'  => round($costos['sin_impuestos'], 2),
            'orden_costos_productos_impuestos'      => round($costos['con_impuestos'] - $costos['sin_impuestos'], 2),
            'orden_costos_envio'                    => $real_envio_costo !== null ? round($real_envio_costo, 2) : null,
        ];
    }
}
