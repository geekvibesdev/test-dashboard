$(function() {
    function renderComments(comments) {
        if (!Array.isArray(comments) || comments.length === 0) {
            return `
                <div class="card__ticket__body mt-4">
                    <h5 class="card-title fw-semibold">No existen notas.</h5>
                </div>`;
        }

        let html = `
            <div class="card__ticket__body mt-4">
                <h5 class="mb-3 card-title fw-semibold">Seguimiento del incidente:</h5>
            </div>`;
        comments
            .slice()
            .sort((a, b) => new Date(b.date) - new Date(a.date))
            .forEach(comment => {
                const formattedDate = new Date(comment.date).toLocaleString();
                html += `
                    <div class="my-4 card__ticket__comment">
                        <div class="row">
                            <div class="col-2 col-md-2 col-lg-1">
                                <div class="card__ticket__header">
                                    <img class="img-fluid" style="height:45px;width:45px;" src="${imagePath}${comment.owner.image}" alt="${comment.owner.fullname}">
                                </div>
                            </div>
                            <div class="col-10 col-md-10 col-lg-11">
                                <div class="card__ticket__header__data">
                                    <p class="m-0"><strong>${comment.owner.fullname} | ${comment.owner.email}</strong></p>
                                    <small>Fecha: <strong>${formattedDate}</strong></small>
                                </div>
                                <div class="ticket__comment mb-0 mt-2">${comment.comment}</div>
                            </div>
                        </div>
                    </div>`;
            });
        return html;
    }

    function getTicketData() {
        $.ajax({
            url: `${base_url}truedesk/tickets/${ticketId}`,
            type: 'GET',
            dataType: 'json',
            success(resp) {
                if (resp.ok) {
                    const htmlTicket = renderComments(resp.ticket.comments);
                    $('#ticket__comments').html(htmlTicket);
                }
            },
            error(xhr, status, error) {
                console.error('Error fetching tickets:', error);
            }
        });
    }

    async function copyToClipboard(elementId) {
        const el = document.getElementById(elementId);
        if (!el) return;
        try {
            await navigator.clipboard.writeText(el.value || el.innerText);
            showMessage('alert-success', 'Copiado al portapapeles.');
        } catch (err) {
            showMessage('alert-danger', 'No se pudo copiar.');
        }
    }

    function toggleButton($btn, isLoading) {
        $btn.prop('disabled', isLoading);
        $btn.html(isLoading ? 'Generando...' : '<i class="ti ti-robot"></i> Generar nueva sugerencia');
    }

    // Inicialización
    getTicketData();

    $('#btnCopiarSeguimientoAI').on('click', function() {
        copyToClipboard('seguimiento__respuesta__sugerencia');
    });

    $('#btn__modal__ai').on('click', function() {
        $('#modalSeguimientoContent').modal('show');
        $('#seguimientoAI').focus();
    });

    $('#btnGenerarSeguimientoAI').on('click', function() {
        var $btn = $(this);
        var cliente = $('#cliente').val().trim();
        var solicitud = $('#seguimientoAI').val().trim();
        var contexto = $('#contexto').val().trim();
        var incluirContexto = $('#incluirContexto').is(':checked') ? 1 : 0;

        if (cliente.length < 1 ) {
            showMessage('alert-danger', 'Nombre de cliente es requerido.');
            return;
        }
        
        if (solicitud.length < 1 ) {
            showMessage('alert-danger', 'Solicitud es requerido.');
            return;
        }
        
        if(incluirContexto == 1 ) {
            if (contexto.length < 1 ) {
                showMessage('alert-danger', 'Desactiva el contexto o incluye uno.');
                return;
            }
            solicitud += `\n\nContexto: ${contexto}`
        }

        toggleButton($btn, true);

        $.post(`${base_url}openai/generar-correo`, {
            cliente,
            solicitud,
            [csrfName]: csrfHash,
        }, function(resp) {
            if (resp.csrf_name && resp.csrf_token) {
                actualizarCsrfToken(resp.csrf_name, resp.csrf_token);
            }
            if (resp.ok) {
                $('#seguimientoAI').val(resp.seguimiento);
                $('#seguimiento__respuesta').show();
                $('#seguimiento__respuesta__sugerencia').html(resp.respuesta);
            } else {
                showMessage('alert-danger', resp.message);
            }
            toggleButton($btn, false);
        }).fail(function() {
            showMessage('alert-danger', 'Error al generar el seguimiento.');
            toggleButton($btn, false);
        });
    });
    
    $('#btnPostearSeguimientoAI').on('click', function() {
        var $btn = $(this);
        var comment = $('#seguimiento__respuesta__sugerencia').val().trim();;

        if (comment < 1 ) {
            showMessage('alert-danger', 'El campo sugerencia es requerido.');
            return;
        }

        toggleButton($btn, true);

        $.post(`${base_url}truedesk/tickets/addComment`, {
            comment,
            _id,
            [csrfName]: csrfHash,
        }, function(resp) {
            console.log(resp)
            if (resp.ok) {
                showMessage('alert-success', 'Comentario agregado.');
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                showMessage('alert-danger', resp.message);
            }
            toggleButton($btn, false);
        }).fail(function() {
            showMessage('alert-danger', 'Error al generar el seguimiento.');
            toggleButton($btn, false);
        });
    });
});