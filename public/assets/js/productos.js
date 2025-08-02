$(document).ready(function() {
    new DataTable('.dt_table', {
        responsive: true,
        order: [[0, 'desc']],
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
    });

    $(document).on('click', '#getProductosInventario', function(e) {
        e.preventDefault();

        // Inicia la carga
        $('#getProductosInventario').attr('disabled', true);
        $('#getProductsLoader').show();

        $.ajax({
            url: base_url + 'woocommerce/get-productos',
            type: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.ok) {                    
                    // recorre los productos y omite los que tienen status diferente a publish
                    let productos = resp.productos.filter(producto => producto.status == "publish");

                    // Valida si en el arreglo hay SKU duplicados
                    let skuDuplicados = productos.filter((producto, index, self) =>
                        self.findIndex(p => p.sku === producto.sku) !== index
                    );
                    if (skuDuplicados.length > 0) {
                        $('#errorSKUDuplicados').show();
                        $('#errorSKUDuplicados').html(
                            `<div class="alert alert-warning"><strong>Existen ${skuDuplicados.length} SKU de productos duplicados en WooCommerce (${skuDuplicados.map(p => p.sku).join(', ')}), esto puede generar resultados no esperados.</strong></div>`
                        );
                    }

                    $('#modalViewContentFooter').show();
                    $('#modalViewContentTitle').html('Productos en WooCommerce: ' + productos.length);
                    $('#modalViewContentBody').html(
                        '<div class="table-responsive">' +
                        '<table class="table table-striped table-bordered">' +
                        '<thead>' +
                        '<tr>' +
                        '<th class="text-center">#</th>' +
                        '<th>ID</th>' +
                        '<th>SKU</th>' +
                        '<th>Nombre</th>' +
                        '<th>Precio Venta</th>' +
                        '<th>Inventario</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        resp.productos
                            .filter(producto => producto.status == "publish")
                            .map((producto, index) => {
                                return `<tr>
                                            <td class="text-center">${index + 1}</td>
                                            <td>${producto.id}</td>
                                            <td>${producto.sku}</td>
                                            <td>${producto.name}</td>
                                            <td class="text-end">${parseFloat(producto.price).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })}</td>
                                            <td>${producto.stock_quantity}</td>
                                        </tr>`;
                            }).join('') +
                        '</tbody>' +
                        '</table>' +
                        '</div>' 
                    );
                    $('#modalViewContent').modal('show');
                } else {
                    showMessage('alert-danger', 'Error al obtener productos.');
                }
            },
            error: function() {
                showMessage('alert-danger', 'Error en la solicitud.');
                $('#modalViewContentFooter').hide();
            },
            complete: function() {
                $('#getProductosInventario').attr('disabled', false);
                $('#getProductsLoader').hide();
            }
        });
    });

    // iniciarSincronizacion
    $(document).on('click', '#iniciarSincronizacion', function(e) {
        e.preventDefault();

        // Muestra alerta de confirmación con confirm
        if (!confirm('¿Está seguro de que desea iniciar la sincronización?, esta acción no puede deshacerse, la sincronización se realiza con la tienda en linea (WooCommerce), si el SKU ya existe será actualizado junto con sus precios y cantidad de inventario, se recomienda hacer un respaldo de la base de datos antes de continuar, si no está seguro de lo que hace, consulte a su administrador.')) {
            return;
        }

        // Inicia la sincronización
        $('#iniciarSincronizacion').attr('disabled', true);
        $('#syncLoader').show();
        $('#alertContent').show();
        $('#alertMessage').show();
        $('#cancelarSincronizacion').hide();

        $.ajax({
            url: base_url + 'woocommerce/productos/sincronizar',
            type: 'post',
            dataType: 'json',
            data: {
                [csrfName]: csrfHash
            },
            success: function(resp) {
                if (resp.ok) {
                    showMessage('alert-success', 'Sincronización concluida con exito.');
                    $('#cancelarSincronizacion').html('Cerrar');
                    $('#iniciarSincronizacion').hide();
                    $('#alertMessage').removeClass('alert-warning');
                    $('#alertMessage').addClass('alert-success');
                    $('#alertMessage').html("<strong>Sincronización concluida con exito.</strong>");
                    setTimeout(function() {
                        $('#modalViewContent').modal('hide');
                        location.reload();
                    }, 5000);

                } else {
                    $('#errorAlert').show();
                    $('#errorMessage').html(resp.message);
                    showMessage('alert-danger', 'Error al sincronizar.');
                }
            },
            error: function() {
                showMessage('alert-danger', 'Error en la solicitud.');
            },
            complete: function() {
                // desbloquea el boton
                $('#syncLoader').hide();
                $('#cancelarSincronizacion').show();
            }
        });
    });
});