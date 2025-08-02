$(document).ready(function() {
    $(document).on('click', '#btn_filtrar', function() {
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
        $('#modalFilter').modal('hide');
    });

    $(document).on('click', '#btn_limpiar', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        tablePedidos.ajax.url(base_url + "ordenes/get-ordenes").load();
        $('#modalFilter').modal('hide');
    });

    $('#btn_refresh').on('click', function() {
        $('#btn_filtrar').click();
    });

    var tablePedidos = $('#tabla__reportes').DataTable({
        "ajax": {
            url: base_url + "ordenes/get-ordenes",
            type: 'GET',
            dataSrc: function(resp) {
                if(resp.ok) showMessage('alert-info', 'Información obtenida')
                return resp.ordenes.map(function(orden) {
                    return {
                        fecha: new Date(orden.fecha_orden).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' }),
                        orden: `<a href="${base_url}ventas/ordenes/${orden.orden}">${orden.orden}</a>`,
                        estatus: orden.estatus_orden,
                        cliente: orden.envio_direccion.first_name + ' ' + orden.envio_direccion.last_name,
                        envio_direccion: orden.direccion_envio_completa,
                        envio: orden.envio_tipo,
                        prom_envio: orden.promocion != null ? (orden.promocion == 1 ? 'Sí' : 'No') : '',
                        prom_envio_titulo: orden.promocion_tipo_nombre,
                        paq_nombre: orden.real_envio_paqueteria_nombre,
                        paq_guia: orden.real_envio_guia,
                        requiere_factura: orden.requiere_factura == 1 ? 'Sí' : 'No',
                        productos: orden.productos.map(function(producto) {
                            return `${producto.name} (SKU: ${producto.sku}) x ${producto.quantity}\n` +
                                   `${producto.tiene_descuento ? `Desc: ${producto.descuento_aplicado}\n` : ''}`;
                        }).join('-'),
                        impuesto: orden.impuestos[0].label + ' ' + orden.impuestos[0].rate_percent + '%',
                        desc_prod_aplicados: orden.orden_descuentos_titulos.map(function(descuento) {
                            return `${descuento}`;
                        }).join(', '),
                        descuentos: setCurrency(orden.orden_descuentos),
                        subtotal: setCurrency(orden.orden_subtotal),
                        costo_envio: setCurrency(orden.orden_envio),
                        costo_impuestos: setCurrency(orden.orden_impuestos),
                        costo_orden: setCurrency(orden.orden_total),
                        paq_costo: orden.real_envio_costo ? setCurrency(orden.real_envio_costo) : '',
                        paq_utilidad: orden.utilidad.utilidad_paqueteria != 'Pendiente' ? setCurrency(orden.utilidad.utilidad_paqueteria) : orden.utilidad.utilidad_paqueteria,
                        costos_prod_pendientes: orden.orden_geek_merchandise.orden_costos_productos_pendientes ? 'Si' : 'No',
                        costos_compra_productos: setCurrency(orden.orden_geek_merchandise.orden_costos_productos_sin_impuestos),
                        ut_prod_sin_imp: setCurrency(orden.utilidad.utilidad_productos_sin_impuestos),
                        ut_prod_porcentaje: `${orden.utilidad.utilidad_productos_sin_impuestos_porcentaje} %`,
                        desc_productos_50: setCurrency(orden.orden_descuentos_50_porciento),
                        ut_orden_sin_imp: orden.utilidad.utilidad_orden_sin_impuestos != 'Pendiente' ? setCurrency(orden.utilidad.utilidad_orden_sin_impuestos) : orden.utilidad.utilidad_orden_sin_impuestos,
                        ut_orden_sin_imp_mas_50_prom: orden.utilidad.utilidad_orden_sin_impuestos_mas_50_prom != 'Pendiente' ? setCurrency(orden.utilidad.utilidad_orden_sin_impuestos_mas_50_prom) : orden.utilidad.utilidad_orden_sin_impuestos_mas_50_prom,
                        ut_final_porcentaje_sin_prom: orden.utilidad.utilidad_final_sin_impuestos_sin_promociones_porcentaje != 'Pendiente' ? setPercentaje(orden.utilidad.utilidad_final_sin_impuestos_sin_promociones_porcentaje) : orden.utilidad.utilidad_final_sin_impuestos_sin_promociones_porcentaje,
                        ut_final_porcentaje_con_prom: orden.utilidad.utilidad_final_sin_impuestos_con_promociones_porcentaje != 'Pendiente' ? setPercentaje(orden.utilidad.utilidad_final_sin_impuestos_con_promociones_porcentaje) : orden.utilidad.utilidad_final_sin_impuestos_con_promociones_porcentaje,
                        pasarela: orden.pago_metodo,
                        transaccion: orden.pago_id,
                        estado: orden.envio_direccion.state,
                        municipio: orden.envio_direccion.city,
                        cp: orden.envio_direccion.postcode,
                    };
                });
            }
        },
        order: [[1, 'desc']],
        columnDefs: [
            { 
                targets: [3,4,5,6,7,8,9,10,11,12,13,        20,21,      24,25,26,27,28,29,        32,33,34],
                visible: false 
            }
        ],
        columns: [
            { data: 'fecha' },                          // 0        -> visible
            { data: 'orden' },                          // 1        -> visible
            { data: 'estatus' },                        // 2        -> visible
            { data: 'cliente' },                        // 3        
            { data: 'envio_direccion' },                // 4
            { data: 'envio' },                          // 5
            { data: 'prom_envio' },                     // 6        
            { data: 'prom_envio_titulo' },              // 7
            { data: 'paq_nombre' },                     // 8
            { data: 'paq_guia' },                       // 9
            { data: 'requiere_factura' },               // 10
            { data: 'productos' },                      // 11
            { data: 'impuesto' },                       // 12 
            { data: 'desc_prod_aplicados' },            // 13 
            { data: 'descuentos' },                     // 14       -> visible       
            { data: 'subtotal' },                       // 15       -> visible
            { data: 'costo_envio' },                    // 16       -> visible
            { data: 'costo_impuestos' },                // 17       -> visible
            { data: 'costo_orden' },                    // 18       -> visible
            { data: 'paq_costo' },                      // 19       -> visible
            { data: 'paq_utilidad' },                   // 20       
            { data: 'costos_prod_pendientes' },         // 21       
            { data: 'costos_compra_productos' },        // 22       -> visible
            { data: 'ut_prod_sin_imp' },                // 23       -> visible
            { data: 'ut_prod_porcentaje' },             // 24
            { data: 'desc_productos_50' },              // 25
            { data: 'ut_orden_sin_imp' },               // 28       -> visible
            { data: 'ut_orden_sin_imp_mas_50_prom' },   // 29       -> visible
            { data: 'ut_final_porcentaje_sin_prom' },   // 30       -> visible
            { data: 'ut_final_porcentaje_con_prom' },   // 31       -> visible
            { data: 'pasarela' },                       // 32
            { data: 'transaccion' },                    // 33
            { data: 'estado' },                         // 34
            { data: 'municipio' },                      // 35
            { data: 'cp' },                             // 36
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
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        createdRow: function(row, data, dataIndex) {
            if (data.costos_prod_pendientes == 'Si') {
                $(row).addClass('highlight-row');
            }
        },
    });
});