$(document).ready(function () {
  var $pregunta = $('#agente-pregunta');
  var $btn = $('#agente-btn-ask');
  var $loading = $('#agente-loading');
  var $error = $('#agente-error');
  var $response = $('#agente-response');
  var $respuestaNl = $('#agente-respuesta-nl');
  var $sql = $('#agente-sql');

  function hideAll() {
    $loading.hide();
    $error.hide();
    $response.hide();
  }

  $('#agente-btn-ask').on('click', function () {
    var pregunta = $pregunta.val().trim();
    if (!pregunta) {
      $error.text('Escribe una pregunta.').show();
      $response.hide();
      return;
    }

    hideAll();
    $loading.show();
    $btn.prop('disabled', true);

    $.ajax({
      url: base_url + 'informes/agente-reporte/ask',
      type: 'POST',
      data: {
        pregunta: pregunta,
        [typeof csrfName !== 'undefined' ? csrfName : 'csrf_test_name']: typeof csrfHash !== 'undefined' ? csrfHash : ''
      },
      dataType: 'json'
    })
      .done(function (resp) {
        hideAll();
        if (resp.ok) {
          $respuestaNl.text(resp.respuesta_nl || '');
          $sql.text(resp.sql || '');
          $response.show();
        } else {
          $error.text(resp.error || 'Error desconocido').show();
        }
      })
      .fail(function (xhr) {
        hideAll();
        var msg = 'Error de conexion.';
        if (xhr.responseJSON && xhr.responseJSON.error) {
          msg = xhr.responseJSON.error;
        } else if (xhr.responseText) {
          try {
            var j = JSON.parse(xhr.responseText);
            if (j.error) msg = j.error;
          } catch (e) {}
        }
        $error.text(msg).show();
      })
      .always(function () {
        $loading.hide();
        $btn.prop('disabled', false);
      });
  });
});
