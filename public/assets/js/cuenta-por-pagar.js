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
        tableCuentas.ajax.url(base_url + "contabilidad/get-cuenta-por-pagar-filtro?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&estatus=" + estatus).load();
    });

    $('#btn_limpiar').on('click', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        tableCuentas.ajax.url(base_url + "contabilidad/get-cuenta-por-pagar").load();
    });

    $('#btn_refresh').on('click', function() {
        $('#btn_filtrar').click();
    });

    function getEstatusName(estatus){
        if(estatus == 'en_proceso')return 'En proceso'; 
        if(estatus == 'pagada')return 'Pagada'; 
        if(estatus == 'vencida')return 'Vencida'; 
        if(estatus == 'cancelada')return 'Cancelada'; 
        return 'Error';
    }

    var tableCuentas = $('#tabla__cuentas_por_pagar').DataTable({
        "ajax": {
            url: base_url + "contabilidad/get-cuenta-por-pagar",
            type: 'GET',
            dataSrc: function(resp) {
                console.log(resp)
                if(resp.ok){
                    showMessage('alert-info', 'Información obtenida')
                    let { cuentas_por_pagar } = resp;
                    return cuentas_por_pagar.map(function(cuenta_por_pagar) {
                        return {
                            id:  cuenta_por_pagar.id,
                            fecha_emision: cuenta_por_pagar.fecha_emision,
                            proveedor: cuenta_por_pagar.razon_social,
                            factura_folio: `<a target="_blank" href="${base_url}${cuenta_por_pagar.factura_pdf}">${cuenta_por_pagar.factura_folio}</a>`,
                            factura_monto: setCurrency(cuenta_por_pagar.factura_monto),
                            fecha_pago: cuenta_por_pagar.fecha_pago,
                            pago_estatus: `<a href="${base_url}contabilidad/cuenta-por-pagar/edit/${cuenta_por_pagar.id}">${getEstatusName(cuenta_por_pagar.pago_estatus)}</a>`,
                            factura_tipo: cuenta_por_pagar.factura_tipo,
                            factura_categoria: cuenta_por_pagar.factura_categoria_nombre,
                            credito_dias: cuenta_por_pagar.credito_dias,
                            factura_pdf: base_url + cuenta_por_pagar.factura_pdf,
                        };
                    });
                }
            }
        },
        order: [[1, 'desc']],
        columnDefs: [
            { 
                targets: [7,8,9,10],
                visible: false 
            },
            {
                targets: [0,5], 
                className: 'text-center'
            },
            {
                targets: [1,2,3,6], 
                className: 'text-start'
            },
        ],
        columns: [
            { data: 'id'}, 
            { data: 'fecha_emision'}, 
            { data: 'proveedor'},     
            { data: 'factura_folio'}, 
            { data: 'factura_monto'}, 
            { data: 'fecha_pago'},    
            { data: 'pago_estatus'},  
            { data: 'factura_tipo'},  
            { data: 'factura_categoria'},  
            { data: 'credito_dias'},  
            { data: 'factura_pdf'},  
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