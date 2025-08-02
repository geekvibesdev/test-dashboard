$(document).ready(function() {   
    $(document).on('change', '#copy_address', function(){
        let checked = $(this).is(':checked');
        if(checked){
            let oficina_calle_numero = $('#oficina_calle_numero').val();
            let oficina_colonia = $('#oficina_colonia').val();
            let oficina_ciudad = $('#oficina_ciudad').val();
            let oficina_estado = $('#oficina_estado').val();
            let oficina_codigo_postal = $('#oficina_codigo_postal').val();
            let oficina_telefono = $('#oficina_telefono').val();
            let oficina_observaciones = $('#oficina_observaciones').val();
            $('#fiscal_calle_numero').val(oficina_calle_numero);
            $('#fiscal_colonia').val(oficina_colonia);
            $('#fiscal_ciudad').val(oficina_ciudad);
            $('#fiscal_estado').val(oficina_estado);
            $('#fiscal_codigo_postal').val(oficina_codigo_postal);
            $('#fiscal_telefono').val(oficina_telefono);
            $('#fiscal_observaciones').val(oficina_observaciones);
        }
    })
});