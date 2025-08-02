function imprimirPedido(ordenId) {
    const url = `${base_url}ventas/ordenes/imprimir-orden/${ordenId}`;
    const printWindow = window.open(url, '_blank');
    printWindow.focus();
    printWindow.print();
}
$(document).ready(function() {

    $('.select2').select2({
        placeholder: 'Selecciona',
        allowClear: true
    });
    // Si el checkbox de promoción está marcado, habilita el select de promociones y lo coloca como requerido
    $('#promocion').change(function() {
        if ($(this).is(':checked')) {
            $('select[name="promocion_tipo"]').prop('disabled', false).prop('required', true);
        } else {
            $('select[name="promocion_tipo"]').prop('disabled', true).prop('required', false);
            $('select[name="promocion_tipo"]').val(null).trigger('change');
        }
    });

    $('#generarIncidente').on('click', function() {
        $('#modalTicket').modal('show');
        $('#titulo').focus();
    });
    
    $('#ticketCancelar').on('click', function() {
        $('#modalTicket').modal('hide');
    });

    $('#ticketCrear').on('click', function() {
        const titulo        = $('#titulo').val();
        const descripcion   = $('#descripcion').val();
        const ordenId       = $('#ordenId').val();
        
        if (!titulo || !descripcion || !ordenId) {
            showMessage('alert-danger', 'Todos los campos son obligatorios.');
            return;
        }

        $('#ticketCrear').prop('disabled', true);
        $('#ticketCrear').html('<i class="fa fa-spinner fa-spin"></i> Generando...');

        $.post(base_url + 'truedesk/generar-incidente', {
            [csrfName]: csrfHash,
            titulo: titulo,
            descripcion: descripcion,
            ordenId: ordenId
        }, function(resp) {
            if (resp.ok) {
                showMessage('alert-success', 'Incidente: #' + resp.uid +' generado correctamente.');
                $('#modalTicket').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showMessage('alert-danger', resp.message);
            }
        }).fail(function() {
            showMessage('alert-danger', 'Error al generar el incidente.');
            setTimeout(() => {
                location.reload();
            }, 2000);
        });
    });

    $('#crearGuia').on('click', function() {
        $('#modalCrearGuia').modal('show');
    });
});