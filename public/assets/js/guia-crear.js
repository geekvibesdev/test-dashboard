$(document).ready(function() {

    $('.select2').select2({
        placeholder: 'Selecciona',
        allowClear: true
    });

    function getOrdenFromUrl() {
        const params = new URLSearchParams(window.location.search);
        if (params.has('orden')) {
            return params.get('orden');
        }
        return null;
    }

    // Ejemplo de uso:
    const orden = getOrdenFromUrl();
    if (orden) {
        $.get( base_url + 'ventas/ordenes/orden/' + orden, function(resp) {
            console.log(resp)
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
            }
            if(resp.ok){
                var { orden } = resp;
                $('#nombre').val( orden.envio_direccion.first_name );
                $('#apellidos').val( orden.envio_direccion.last_name );
                $('#correo_electronico').val( orden.envio_direccion.billing_email );
                $('#telefono').val( orden.envio_direccion.phone );
                $('#calle_numero').val( orden.envio_direccion.address_1 );
                $('#colonia').val( orden.envio_direccion.address_2 );
                $('#ciudad').val( orden.envio_direccion.city );
                $('#estado').val( orden.envio_direccion.state );
                $('#codigo_postal').val( orden.envio_direccion.postcode );
                $('#referencias').val( orden.notas_de_entrega == '' ? 'No proporcionado' :  orden.notas_de_entrega);
                $('#wc_orden').val( orden.orden);
            }
        }).fail(function() {
            showMessage('alert-danger', 'Error al obtener orden.');
        });
    }
    
    $('#crearGuiaBtn').on('click', function(){

        var remitente       = $('#remitente').val();
        var nombre          = $('#nombre').val();
        var apellidos       = $('#apellidos').val();
        var correo_electronico = $('#correo_electronico').val();
        var telefono        = $('#telefono').val();
        var calle_numero    = $('#calle_numero').val();
        var colonia         = $('#colonia').val();
        var ciudad          = $('#ciudad').val();
        var estado          = $('#estado').val();
        var codigo_postal   = $('#codigo_postal').val();
        var referencias     = $('#referencias').val();
        var largo_cm        = $('#largo_cm').val();
        var ancho_cm        = $('#ancho_cm').val();
        var alto_cm         = $('#alto_cm').val();
        var peso_kg         = $('#peso_kg').val();
        var wc_orden        = $('#wc_orden').val();
        var tipo_envio      = $('#tipo_envio').val();
        var entrega_estimada= $('#entrega_estimada').val();

        // Validar que no esten vacios
        if(remitente.trim() == '' || nombre.trim() == '' || apellidos.trim() == ''|| correo_electronico.trim() == '' || telefono.trim() == '' || calle_numero.trim() == ''|| colonia.trim() == '' || ciudad.trim() == ''|| estado.trim() == '' || codigo_postal.trim() == '' || referencias.trim() == ''|| largo_cm.trim() == '' || ancho_cm.trim() == '' || alto_cm.trim() == '' || peso_kg.trim() == '' || wc_orden.trim() == '' || tipo_envio.trim() == '' || entrega_estimada.trim() == ''){
            $('#alerta').addClass('alert-danger').html('Todos los campos son obligatorios').show();
            return;
        }

        // Validar que telefono tenga 10 digitos
        if(telefono.length < 10){
            $('#alerta').addClass('alert-danger').html('Telefono inválido, 10 digitos requeridos').show();
            return;
        }
        
        // Validar que CP tenga 5 digitos
        if(codigo_postal.length < 5){
            $('#alerta').addClass('alert-danger').html('Código Postal inválido, 5 digitos requeridos').show();
            return;
        }

        // Enviar formulario
        $.post( base_url + 'gml/guias/nuevo', {
            [csrfName]: csrfHash,
            remitente, 
            nombre, 
            apellidos,
            correo_electronico,
            telefono,
            calle_numero,
            colonia,
            ciudad,
            estado,
            codigo_postal,
            referencias,
            largo_cm,
            ancho_cm,
            alto_cm,
            peso_kg,
            wc_orden,
            tipo_envio,
            entrega_estimada,
        }, function(resp) {
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
            }
            if (resp.ok) {
                showMessage('alert-success', 'Guia: ' + resp.guia +' creada correctamente.');
                $('#guiaForm').hide();
                $('#successGuia').html(resp.guia);
                $('#successGuiaUrl').attr('href', base_url + 'gml/guias/imprimir/' + resp.guia);
                $('#successGuiaUrlDetail').attr('href', base_url + 'gml/guias/guia/' + resp.guia);
                $('#guiaCreada').show();
            } else {
                showMessage('alert-danger', resp.message);
            }
        }).fail(function() {
            showMessage('alert-danger', 'Error al generar guia.');
        });
    })
});