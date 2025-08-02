$(document).ready(function() {

    function toggleUser(action, successMessage) {
        $.post(baseUrl + "/" + action, { id: userId, [csrfName]: csrfHash }, function(resp) {
            try {
                if (resp.ok == true) {
                    showMessage('alert-success', successMessage);
                    $("#active_user, #inactive_user").toggle();
                } else {
                    showMessage('alert-danger', resp.error);
                }
                if (resp.csrf_name && resp.csrf_token) {
                    actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
                }
            } catch (e) {
                showMessage('alert-danger', 'Error en el procesamiento de la respuesta.');
            }
        }).fail(function() {
            showMessage('alert-danger', 'Error en la solicitud.');
        });
    }

    $('#active_user').on('click', function() {
        toggleUser('active', 'Usuario activado correctamente');
    });

    $('#inactive_user').on('click', function() {
        toggleUser('inactive', 'Usuario desactivado correctamente');
    });

    $('#photo').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#actualImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

});
