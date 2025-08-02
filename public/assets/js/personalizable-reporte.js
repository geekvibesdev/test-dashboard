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
        tableCuentas.ajax.url(base_url + "ventas/personalizables/reporte/get-reporte-filtro?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&estatus=" + estatus).load();
    });

    $('#btn_limpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        tableCuentas.ajax.url(base_url + "ventas/personalizables/reporte/get-reporte").load();
    });

    $('#btn_refresh').on('click', function() {
        $('#btn_filtrar').click();
    });

    var tableCuentas = $('#tabla_personalizable_reporte').DataTable({
        "ajax": {
            url: base_url + "ventas/personalizables/reporte/get-reporte",
            type: 'GET',
            dataSrc: function(resp) {
                console.log(resp)
                if(resp.ok){
                    showMessage('alert-info', 'Información obtenida')
                    let { personalizables } = resp;
                    return personalizables.map(function(personalizable) {
                        return {
                            id:  personalizable.id,
                            fecha_creado: personalizable.fecha_creado,
                            orden_wc: `<a target="_blank" href="${base_url}ventas/ordenes/${personalizable.wc_orden}">${personalizable.wc_orden}</a>`,
                            estatus: personalizable.estatus,
                            etiqueta: personalizable.personalizados_linea_1,
                            etiqueta_costo: setCurrency(personalizable.personalizados_linea_1_costos),
                            flores_naturales: personalizable.personalizados_aplicar_flores_naturales,
                            flores_naturales_costo: setCurrency(personalizable.personalizados_aplicar_flores_naturales_costos),
                            caja_sello: personalizable.personalizados_texto_sobre_caja,
                            caja_sello_costo: setCurrency(personalizable.personalizados_texto_sobre_caja_costos),
                            total: setCurrency(personalizable.personalizados_total_costo),
                        };
                    });
                }
            }
        },
        order: [[1, 'desc']],
        columnDefs: [
            { 
                targets: [0],
                visible: false 
            },
            { 
                targets: [1,3],
                className: 'text-start' 
            },
            { 
                targets: [2,4,6,8],
                className: 'text-center' 
            },
            { 
                targets: [5,7,9,10],
                className: 'text-end' 
            },
        ],
        columns: [
            { data: 'id'}, 
            { data: 'fecha_creado'}, 
            { data: 'orden_wc'},     
            { data: 'estatus'}, 
            { data: 'etiqueta'}, 
            { data: 'etiqueta_costo'}, 
            { data: 'flores_naturales'},    
            { data: 'flores_naturales_costo'},    
            { data: 'caja_sello'},  
            { data: 'caja_sello_costo'},  
            { data: 'total'},  
        ],
        pageLength: 10,
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
    });
});