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
        tableGuias.ajax.url(base_url + "gml/guias/get-guias-filtro?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&estatus=" + estatus).load();
    });

    $('#btn_limpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        tableGuias.ajax.url(base_url + "gml/guias/get-guias").load();
    });

    var tableGuias = $('#tabla__ordenes').DataTable({
        "ajax": {
            url: base_url + "gml/guias/get-guias",
            type: 'GET',
            dataSrc: function(resp) {
                if(resp.ok) showMessage('alert-info', 'Información obtenida')
                return resp.guias.map(function(guia) {
                    return {
                        guia: `<a href="${base_url}gml/guias/guia/${guia.guia}">${guia.guia}</a>`,
                        estatus: guia.estatus,
                        fechaCreada: new Date(guia.guia_fecha_creada).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' }),
                        remitente: `${guia.remitente_nombre} ${guia.remitente_apellidos}`,
                        destinatario: `${guia.destinatario_nombre} ${guia.destinatario_apellidos}`,
                        tipo: guia.tipo_envio.charAt(0).toUpperCase() + guia.tipo_envio.slice(1),
                        orden: `<a href="${base_url}ventas/ordenes/${guia.wc_orden}">${guia.wc_orden}</a>`,
                    };
                });
            }
        },
        responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        pageLength: 20,
        order: [[2, 'desc']],
        columns: [
            { data: 'guia'},
            { data: 'estatus'},
            { data: 'fechaCreada'},
            { data: 'remitente'},
            { data: 'destinatario'},
            { data: 'tipo'},
            { data: 'orden'},
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