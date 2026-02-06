<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
*/

/**************************************
 * FUERA DE FILTRO DE AUTENTICACIÓN
***************************************/
$routes->group('', function($routes) {

    /* Auth */
    $routes->get('/', 'Auth::index');
    $routes->post('/auth/login', 'Auth::login');

    //WooCommerce Webhook
    $routes->post('webhook/orden/create', 'WooCommerce::webhookCreate');
    $routes->post('webhook/orden/update', 'WooCommerce::webhookUpdate');
});


/**************************************
 * ROL USUARIO / ADMINISTRADOR / PROVEEDOR / EXTERNO (CLIENTE)
***************************************/
$routes->group('', ['filter' => 'auth:admin,user,proveedor,externo,gml_operador'], function($routes) {

    /* Auth */
    $routes->get('/auth/logout', 'Auth::logout');

    /* Profile */
    $routes->get('/profile', 'User::profile');
    $routes->post('/profile/update/password', 'User::updatePassword');
    $routes->post('/profile/update/photo', 'User::updatePhoto');
    $routes->post('/profile/update/profile', 'User::updateProfile');
 
});

/**************************************
 * ROL USUARIO / ADMINISTRADOR / EXTERNO (CLIENTE)
***************************************/
$routes->group('', ['filter' => 'auth:admin,user,externo'], function($routes) {

    /* Reportes */
    $routes->get('/mx/informes/ordenes', 'Reporte::indexMx');
    $routes->get('/mx/informes/productos-vendidos', 'Reporte::productosVendidos');
    $routes->get('/reportes/get-productos-vendidos', 'Reporte::getProductosVendidos');
    $routes->get('/reportes/get-gastos-paqueteria', 'Reporte::getGastosPaqueria');
    
    $routes->get('/reportes/get-ventas-por-dia', 'Reporte::getVentasPorDia');
    $routes->get('/informes/reporte-de-ventas', 'Reporte::reporteVentas');

    /* Dashboard */
    $routes->get('/mx/dashboard', 'Dashboard::indexMX');

    /* Orden */
    $routes->get('/mx/ordenes/(:num)', 'Orden::interiorOrdenMX/$1');

    /* Promociones tienda*/
    $routes->get('/mx/informes/promociones-tienda', 'PromocionTienda::calendar');

    /* Dashboard Ajax */
    $routes->get('/dashboard/data', 'Dashboard::getDashboardData');
    $routes->get('/dashboard/data/graphics', 'Dashboard::getGraphicsData');
    $routes->get('/dashboard/data/graphics-venta', 'Dashboard::getGraphicsVentasData');
    $routes->get('/dashboard/data/graphics-month', 'Dashboard::getGraphicsDataByMonth');

    /* Orden Ajax */
    $routes->get('/ordenes/get-ordenes',        'Orden::getOrdenes');
    $routes->get('/ordenes/get-ordenes-filtro', 'Orden::getOrdenesFiltro');

});

/**************************************
 * ROL USUARIO / ADMINISTRADOR / PROVEEDOR
***************************************/
$routes->group('', ['filter' => 'auth:admin,user,proveedor'], function($routes) {

    /* Pedidos Personalizables */
    $routes->get('/ventas/personalizables', 'OrdenPersonalizable::index');
    $routes->get('/ventas/personalizables/edit/(:num)', 'OrdenPersonalizable::edit/$1');
    $routes->get('/ventas/personalizables/edit/wc/(:num)', 'OrdenPersonalizable::editByWC/$1');
    $routes->get('/ventas/personalizables/reporte', 'OrdenPersonalizable::reporte');
    $routes->get('/ventas/personalizables/reporte/get-reporte', 'OrdenPersonalizable::getReporte');

    $routes->post('/personalizables/edit', 'OrdenPersonalizable::update');    
});

/**************************************
 * ROL GML OPERADOR Y ADMINISTRADOR
***************************************/
$routes->group('', ['filter' => 'auth:admin,gml_operador'], function($routes) {

    /* GML Ajax */
    $routes->get('/gml/guias/get-guias', 'GMLEnvios::getGuias');
    $routes->get('/gml/guias/get-guias-filtro', 'GMLEnvios::getGuiasFiltro');
    $routes->get('/gml/guias/uid/(:segment)', 'GMLEnvios::getGuiasUid/$1');

    $routes->get('/gml/data', 'GMLEnvios::getDashboardData');

    /* GML Operador*/
    $routes->get('/gml/operador', 'GMLOperador::operador');
    $routes->get('/gml/operador/guias', 'GMLOperador::operadorGuias');
    $routes->get('/gml/operador/scanner', 'GMLOperador::operadorScanner');
    $routes->get('/gml/operador/scanner/recolectar', 'GMLOperador::operadorScannerRecolectar');
    $routes->get('/gml/operador/scanner/trayecto', 'GMLOperador::operadorScannerTrayecto');
    $routes->get('/gml/operador/scanner/entregar', 'GMLOperador::operadorScannerEntregar');
    $routes->get('/gml/operador/scanner/consultar', 'GMLOperador::operadorScannerConsultar');

    $routes->post('/gml/operador/scanner/recolectar', 'GMLOperador::operadorScannerRecolectarAction');
    $routes->post('/gml/operador/scanner/trayecto', 'GMLOperador::operadorScannerTransitoAction');
    $routes->post('/gml/operador/scanner/entregar', 'GMLOperador::operadorScannerEntregarAction');    

    /* GML Envios */
    $routes->get('/gml/guias/guia/(:segment)', 'GMLEnvios::guiasInterior/$1');
});


/**************************************
 * ROL USUARIO Y ADMINISTRADOR
***************************************/
$routes->group('', ['filter' => 'auth:admin,user'], function($routes) {

    /* WooCommerce Ajax */
    $routes->get('/woocommerce/get-cliente/(:num)', 'WooCommerce::getCliente/$1');
    $routes->get('/woocommerce/ordenes/get-notas/(:num)', 'WooCommerce::getNotas/$1');
    $routes->post('/woocommerce/ordenes/complete-order', 'WooCommerce::updateStatus');

    /* Orden */
    $routes->get('/ventas/ordenes', 'Orden::index');
    $routes->get('/ventas/ordenes/(:num)', 'Orden::interiorOrden/$1');
    $routes->get('/ventas/ordenes/imprimir-orden/(:num)', 'Orden::imprimirOrden/$1');
    $routes->get('/ventas/ordenes/orden/(:num)', 'Orden::getOrdenAjax/$1');
    $routes->post('/ordenes/orden/costos-real/edit', 'Orden::ordenActualizarCostos');

    /* Truedesk */
    $routes->post('/truedesk/generar-incidente', 'Truedesk::createTicket');

    /* Servicio Cliente */
    $routes->get('/soporte/tickets', 'Incidente::index');
    $routes->get('/soporte/tickets/(:num)', 'Incidente::interior/$1');

    $routes->get('/truedesk/tickets/(:num)', 'Truedesk::getTicketAjax/$1');
    $routes->post('/truedesk/tickets/addComment', 'Truedesk::addCommentToTicket');

    $routes->post('/openai/generar-correo', 'OpenAI::generarCorreo');

    /* Promociones tienda */
    $routes->get('/informes/promociones-tienda', 'PromocionTienda::calendar');

    /* GML Envios */
    $routes->get('/gml/guias', 'GMLEnvios::guias');
    $routes->get('/gml/guias/guia/(:segment)', 'GMLEnvios::guiasInterior/$1');
    $routes->get('/gml/guias/imprimir/(:segment)', 'GMLEnvios::guiaImprimir/$1');
    $routes->get('/gml/guias/nuevo', 'GMLEnvios::guiaCrear');
    $routes->post('/gml/guias/nuevo', 'GMLEnvios::guiaCreate');

    /* GML Ajax */
    $routes->get('/gml/guias/get-guias', 'GMLEnvios::getGuias');
    $routes->get('/gml/guias/get-guias-filtro', 'GMLEnvios::getGuiasFiltro');

    $routes->get('/gml/data', 'GMLEnvios::getDashboardData');
});

/**************************************
 * ADMINISTRADOR
***************************************/
$routes->group('', ['filter' => 'auth:admin'], function($routes) {
    
    /* Auth */
    $routes->post('/auth/register', 'Auth::register');
    $routes->post('/auth/user/update', 'Auth::updateUser');
    $routes->post('/auth/user/active', 'Auth::activeUser');
    $routes->post('/auth/user/inactive', 'Auth::inactiveUser');
    
    /* Users */
    $routes->get('/settings/user', 'User::index');
    $routes->get('/settings/user/new', 'User::newUser');
    $routes->get('/settings/user/edit/(:num)', 'User::editUser/$1');

    /* Paqueteria */
    $routes->get('/settings/paqueteria', 'Paqueteria::index');
    $routes->get('/settings/paqueteria/new', 'Paqueteria::newPaqueteria');
    $routes->get('/settings/paqueteria/edit/(:num)', 'Paqueteria::editPaqueteria/$1');
    $routes->post('/paqueteria/new', 'Paqueteria::createPaqueteria');
    $routes->post('/paqueteria/edit', 'Paqueteria::updatePaqueteria');
    $routes->post('/paqueteria/delete', 'Paqueteria::deletePaqueteria');
    
    /* Promociones */
    $routes->get('/settings/envios', 'Promocion::index');
    $routes->get('/settings/envios/new', 'Promocion::newPromocion');
    $routes->get('/settings/envios/edit/(:num)', 'Promocion::editPromocion/$1');
    $routes->post('/promocion/new', 'Promocion::createPromocion');
    $routes->post('/promocion/edit', 'Promocion::updatePromocion');
    $routes->post('/promocion/delete', 'Promocion::deletePromocion');

    /* Informes */
    $routes->get('/informes/ordenes', 'Reporte::index');
    $routes->get('/informes/productos-vendidos', 'Reporte::productosVendidos');
    $routes->get('/informes/get-productos-vendidos', 'Reporte::getProductosVendidos');

    $routes->get('/informes/gastos-paqueteria', 'Reporte::gastosPaqueteria');

    /* Agente de reporte (Ollama) */
    $routes->get('/informes/agente-reporte', 'AgenteReporte::index');
    $routes->post('/informes/agente-reporte/ask', 'AgenteReporte::ask');

    /* Productos */
    $routes->get('/settings/productos', 'ProductoCosto::index');
    $routes->get('/settings/productos/new', 'ProductoCosto::newProductoCosto');
    $routes->get('/settings/productos/edit/(:num)', 'ProductoCosto::editProductoCosto/$1');
    $routes->post('/producto-costo/new', 'ProductoCosto::createProductoCosto');
    $routes->post('/producto-costo/edit', 'ProductoCosto::updateProductoCosto');
    $routes->post('/producto-costo/delete', 'ProductoCosto::deleteProductoCosto');

    $routes->get('/producto-costo/producto/(:num)', 'ProductoCosto::getProducto/$1');

    /* WooCommerce Ajax */
    $routes->get('/woocommerce/get-productos', 'WooCommerce::getProductos');
    $routes->post('/woocommerce/productos/sincronizar', 'WooCommerce::sincronizarProductos');

    /* Dashboard */
    $routes->get('/dashboard', 'Dashboard::index');

    /* Developer */
    $routes->get('/settings/logs/wc', 'WebhookLog::index');
    $routes->get('/settings/logs/wc/(:num)', 'WebhookLog::getWCLog/$1');

    /* Promociones tienda */
    $routes->get('/settings/promociones', 'PromocionTienda::index');
    $routes->get('/settings/promociones/new', 'PromocionTienda::newPromocionTienda');
    $routes->get('/settings/promociones/edit/(:num)', 'PromocionTienda::editPromocionTienda/$1');
    $routes->post('/promociones-tienda/new', 'PromocionTienda::createPromocionTienda');
    $routes->post('/promociones-tienda/edit', 'PromocionTienda::updatePromocionTienda');
    $routes->post('/promociones-tienda/delete', 'PromocionTienda::deletePromocionTienda');

    /* OpenAI */
    $routes->get('/settings/openai', 'OpenAI::settings');
    $routes->post('settings/openai', 'OpenAI::updateSettings');

    /* GML Remitentes*/
    $routes->get('/settings/gml/remitentes', 'GMLRemitentes::settingsRemitentes');
    $routes->get('/settings/gml/remitentes/new', 'GMLRemitentes::settingsRemitentesNew');
    $routes->get('/settings/gml/remitentes/edit/(:num)', 'GMLRemitentes::settingsRemitentesEdit/$1');
    $routes->post('/settings/gml/remitentes/new', 'GMLRemitentes::settingsRemitentesCreate');
    $routes->post('/settings/gml/remitentes/edit', 'GMLRemitentes::settingsRemitentesUpdate');

    /* Proveedores */
    $routes->get('/settings/proveedor', 'Proveedor::index');
    $routes->get('/settings/proveedor/new', 'Proveedor::newProveedor');
    $routes->get('/settings/proveedor/edit/(:num)', 'Proveedor::editProveedor/$1');
    $routes->post('/proveedor/new', 'Proveedor::createProveedor');
    $routes->post('/proveedor/edit', 'Proveedor::updateProveedor');

    /* Cuenta por pagar */
    $routes->get('/contabilidad/cuenta-por-pagar', 'CuentaPorPagar::index');
    $routes->get('/contabilidad/cuenta-por-pagar/new', 'CuentaPorPagar::newCuentaPorPagar');
    $routes->get('/contabilidad/cuenta-por-pagar/edit/(:num)', 'CuentaPorPagar::editCuentaPorPagar/$1');

    $routes->get('/contabilidad/get-cuenta-por-pagar', 'CuentaPorPagar::getCuentasPorPagar');
    $routes->get('/contabilidad/get-cuenta-por-pagar-filtro', 'CuentaPorPagar::getCuentasPorPagarFiltro');

    $routes->post('/cuenta-por-pagar/new', 'CuentaPorPagar::createCuentaPorPagar');
    $routes->post('/cuenta-por-pagar/edit', 'CuentaPorPagar::updateCuentaPorPagar');

    /* Facturas categorias Ajax */
    $routes->post('/settings/contabilidad/facura-categoria', 'FacturaCategoria::createItem');
    $routes->post('/settings/contabilidad/facura-categoria-edit', 'FacturaCategoria::updateItem');
});



