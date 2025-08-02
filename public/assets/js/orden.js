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

    var tablePedidos = $('#tabla__ordenes').DataTable({
        "ajax": {
            url: base_url + "ordenes/get-ordenes-filtro?estatus=processing",
            type: 'GET',
            dataSrc: function(resp) {
                if(resp.ok) showMessage('alert-info', 'Información obtenida')
                return resp.ordenes.map(function(orden) {
                    return {
                        fecha: new Date(orden.fecha_orden).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' }),
                        orden: `<a target="_blank" href="${base_url}ventas/ordenes/${orden.orden}">${orden.orden}</a>`,
                        estatus: orden.estatus_orden,
                        cliente: orden.envio_direccion.first_name + ' ' + orden.envio_direccion.last_name,
                        envio: orden.envio_tipo,
                        direccion: orden.envio_direccion.state,
                        cp: orden.envio_direccion.postcode,
                        personalizado: orden.productos_personalizados ? `<a href="${base_url}ventas/personalizables/edit/wc/${orden.orden}">Personalizado</a>` : 'No',
                        paq_nombre: orden.real_envio_paqueteria_nombre,
                        paq_guia: orden.real_envio_guia,
                        paq_costo: orden.real_envio_costo ? orden.real_envio_costo : '',
                        costo_orden: setCurrency(orden.orden_total),
                    };
                });
            }
        },
        pageLength: 50,
        order: [[1, 'desc']],
        columnDefs: [
            { 
                targets: [4],
                visible: false 
            }
        ],
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        columns: [
            { data: 'fecha' },
            { data: 'orden' },
            { data: 'estatus' },
            { data: 'cliente' },
            { data: 'envio' },
            { data: 'direccion' },
            { data: 'cp' },
            { data: 'personalizado' },
            { data: 'paq_nombre' },
            { data: 'paq_guia' },
            { data: 'paq_costo' },
            { data: 'costo_orden' },
        ],
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        error: function(xhr, error, code) {
            console.error("Error en DataTables:", error, code, xhr.responseText);
        },
        createdRow: function(row, data, dataIndex) {
            if (data.estatus === 'processing' && data.paq_guia === null) {
                $(row).addClass('highlight-row');
            }
        },
    });
});