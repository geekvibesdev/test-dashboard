$(document).ready(function() {
    $(document).on('click', '#btn_filtrar', function() {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin    = $('#fecha_fin').val();
        var texto       = "";

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
        tablePedidos.ajax.url(base_url + "reportes/get-productos-vendidos?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin).load();
        $('#modalFilter').modal('hide');
    });

    var tablePedidos = $('#tabla__ordenes').DataTable({
        "ajax": {
            url: base_url + "reportes/get-productos-vendidos",
            type: 'GET',
            dataSrc: function(resp) {
                if(resp.ok) showMessage('alert-info', 'Información obtenida')
                return resp.productos.map(function(producto) {
                    return {
                        producto: producto.producto,
                        sku: producto.sku,
                        cantidad: producto.cantidad,
                        ordenes: producto.ordenes,
                    };
                });
            }
        },
        pageLength: 50,
        order: [[2, 'desc']],
        columns: [
            { data: 'producto' },
            { data: 'sku' },
            { data: 'cantidad' },
            { data: 'ordenes' },
        ],
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
        responsive: true,
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        error: function(xhr, error, code) {
            console.error("Error en DataTables:", error, code, xhr.responseText);
        },
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Helper para limpiar y convertir a número
            let parseNumber = function (i) {
                return typeof i === 'string'
                    ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                    : typeof i === 'number'
                    ? i
                    : 0;
            };

           // Total de órdenes
            let totalProductosVendidos = api
                .column(2, { page: 'current' }) // índice columna "ordenes"
                .data()
                .reduce((a, b) => parseNumber(a) + parseNumber(b), 0);
                 // Total de gastos

            // Mostrar en el footer
            $(api.column(2).footer()).html(totalProductosVendidos);
        },
        paging: false,
        info: false,  
    });
});