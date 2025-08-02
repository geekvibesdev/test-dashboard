$(document).ready(function() {

    $(document).on('click', '#getNotas', function(e) {
        e.preventDefault();
        let orden = $(this).attr('orden');

        $('#getNotas').hide()
        $('#getNotasLoader').show()

        //Muestra el modal
        $.ajax({
            url: base_url + 'woocommerce/ordenes/get-notas/' + orden,
            type: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.ok) {
                    $('#modalViewContentTitle').html('Notas de la orden #' + orden);
                    $('#modalViewContentBody').html(
                        '<div class="table-responsive">' +
                        '<table class="table table-striped table-bordered">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Fecha</th>' +
                        '<th>Autor</th>' +
                        '<th>Nota</th>' +
                        '<th>N. Interna</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        resp.notas.map(nota => {
                            return `<tr>
                                        <td>${new Date(nota.date_created).toLocaleDateString()} ${new Date(nota.date_created).toLocaleTimeString()}</td>
                                        <td>${nota.author}</td>
                                        <td>${nota.note}</td>
                                        <td>${nota.customer_note == false ? 'Si' : '<span style="color:red;">No</span>'}</td>
                                    </tr>`;
                        }).join('') +
                        '</tbody>' +
                        '</table>' +
                        '</div>'
                    );
                    $('#modalViewContent').modal('show');
                } else {
                    showMessage('alert-danger', 'Error al obtener notas.');
                }
            },
            error: function() {
                showMessage('alert-danger', 'Error en la solicitud.');
            },
            complete: function() {
                $('#getNotas').show()
                $('#getNotasLoader').hide()
            }
        });
    });

    $(document).on('click', '#getCliente', function(e) {
        e.preventDefault();
        let cliente = $(this).attr('cliente');

        $('#getCliente').hide()
        $('#getClientesLoader').show()

        $.ajax({
            url: base_url + 'woocommerce/get-cliente/' + cliente,
            type: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.ok) {
                    $('#modalViewContentTitle').html('Datos de cliente');
                    $('#modalViewContentBody').html(
                        '<div class="table-responsive">' +
                        '<table class="table table-bordered">' +
                        '<tbody>' +
                        `<tr>
                            <td><strong>Nombre</strong></td>
                            <td>${resp.cliente.first_name} ${resp.cliente.last_name}</td>
                        </tr>
                        <tr>
                            <td><strong>E-mail</strong></td>
                            <td>${resp.cliente.email}</td>
                        </tr>
                        <tr>
                            <td><strong>Rol</strong></td>
                            <td>${resp.cliente.role}</td>
                        </tr>
                        <tr>
                            <td><strong>Username</strong></td>
                            <td>${resp.cliente.username}</td>
                        </tr>
                        <tr>
                            <td><strong>Alta</strong></td>
                            <td>${new Date(resp.cliente.date_created).toLocaleDateString()} ${new Date(resp.cliente.date_created).toLocaleTimeString()}</td>
                        </tr>
                        ` +
                        '</tbody>' +
                        '</table>' +
                        '</div>'
                    );
                    $('#modalViewContent').modal('show');
                } else {
                    showMessage('alert-danger', 'Error al obtener el cliente.');
                }
            },
            error: function() {
                showMessage('alert-danger', 'Error en la solicitud.');
            },
            complete: function() {
                $('#getCliente').show()
                $('#getClientesLoader').hide()
            }
        });
    });
    
    $(document).on('click', '#completeOrder', function(e) {        
        e.preventDefault();

        // Muestra alerta de confirmación con confirm
        if (!confirm('¿Está seguro de completar la órden?, asegurese de que ya no es requerido ningún seguimiento sobre el envío y que los costos de la mensajeria han sido capturados correctamente.')) {
            return;
        }
        let order = $(this).attr('orderId');
        $('#completeOrder').attr('disabled', true);
        $('#completeOrderLoader').show();

        // Send request
        $.post(base_url + `/woocommerce/ordenes/complete-order`, { [csrfName]: csrfHash, order }, handleResponse)
          .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
          .done(() => {
            setTimeout(() => {
                location.reload();
            }, 1000);
          });
    });
});