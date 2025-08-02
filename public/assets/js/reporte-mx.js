$(document).ready(function() {
    $('#btn_filtrar').on('click', function() {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin    = $('#fecha_fin').val();
        var estatus     = $('#estatus').val();
        var texto       = "";
        if(estatus){
            texto += "Mostrando " + estatus;
        }
        if (fechaInicio && fechaFin) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                return;
            }
            if(fechaInicio && fechaFin){
                texto += " del " + fechaInicio + " al " + fechaFin;
            }
        }
        $('#filter__result').html(texto);
        tablePedidos.ajax.url(base_url + "ordenes/get-ordenes-filtro?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&estatus=" + estatus).load();
    });

    $('#btn_limpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        tablePedidos.ajax.url(base_url + "ordenes/get-ordenes").load();
    });

    $('#btn_refresh').on('click', function() {
        $('#btn_filtrar').click();
    });

    var tablePedidos = $('#tabla__reportes__mx').DataTable({
        "ajax": {
            url: base_url + "ordenes/get-ordenes",
            type: 'GET',
            dataSrc: function(resp) {
                console.log(resp)
                if(resp.ok) showMessage('alert-info', 'Información obtenida')
                return resp.ordenes.map(function(orden) {
                    return {
                        fecha: new Date(orden.fecha_orden).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' }),
                        orden: `<a href="${base_url}mx/ordenes/${orden.orden}">${orden.orden}</a>`,
                        estatus: orden.estatus_orden,
                        cliente: orden.envio_direccion.first_name + ' ' + orden.envio_direccion.last_name,
                        envio_direccion: orden.direccion_envio_completa,
                        envio: orden.envio_tipo,

                        requiere_factura: orden.requiere_factura == 1 ? 'Sí' : 'No',
                        productos: orden.productos.map(function(producto) {
                            return `${producto.name} (SKU: ${producto.sku}) x ${producto.quantity}\n` +
                                   `${producto.tiene_descuento ? `Desc: ${producto.descuento_aplicado}\n` : ''}`;
                        }).join('-'),
                        descuentos: setCurrency(orden.orden_descuentos),
                        subtotal: setCurrency(orden.orden_subtotal),
                        costo_envio: setCurrency(orden.orden_envio),
                        costo_impuestos: setCurrency(orden.orden_impuestos),
                        costo_orden: setCurrency(orden.orden_total),                       
                        pasarela: orden.pago_metodo,
                        transaccion: orden.pago_id,
                    };
                });
            }
        },
        order: [[1, 'desc']],
        columnDefs: [
            { 
                targets: [ 4,7,13,14 ],
                visible: false 
            }
        ],
        columns: [
            { data: 'fecha' },                          // 0        
            { data: 'orden' },                          // 1        
            { data: 'estatus' },                        // 2        
            { data: 'cliente' },                        // 3        
            { data: 'envio_direccion' },                // 4    
            { data: 'envio' },                          // 5        
            { data: 'requiere_factura' },               // 6
            { data: 'productos' },                      // 7
            { data: 'descuentos' },                     // 8               
            { data: 'subtotal' },                       // 9        
            { data: 'costo_envio' },                    // 10       
            { data: 'costo_impuestos' },                // 11       
            { data: 'costo_orden' },                    // 12       
            { data: 'pasarela' },                       // 13
            { data: 'transaccion' },                    // 14
        ],
        pageLength: 50,
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
        createdRow: function(row, data, dataIndex) {
            if (data.costos_prod_pendientes == 'Si') {
                $(row).addClass('highlight-row');
            }
        },
    });
});