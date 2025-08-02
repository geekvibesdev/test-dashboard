<div class="container-fluid mobile__fw">
  <div class="card w-100 sticky-header">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-semibold m-0">Promociones en tienda</h5>
      </div>
      <hr>
      <div class="row mt-2">
        <div class="col-12 mb-2">
            <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Bootstrap centrado -->
<div class="modal" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="title__section-table">
            <p class="m-0"><strong>Detalle del Evento</strong></p>
          </div>
          <table class="table borderless">
            <tbody>
              <tr>
                <td><strong>Título</strong></td>
                <td><span id="modalTitle"></span></td>
              </tr>
              <tr>
                <td><strong>Inicio</strong></td>
                <td><span id="modalStart"></span></td>
              </tr>
              <tr>
                <td><strong>Fin</strong></td>
                <td><span id="modalEnd"></span></td>
              </tr>
              <tr>
                <td><strong>Descuento</strong></td>
                <td><span id="modalDescuento"></span></td>
              </tr>
              <tr>
                <td><strong>Portafolio</strong></td>
                <td><span id="modalPortafolio"></span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    contentHeight: 'auto',
    initialView: 'dayGridMonth',
    locale: 'es',
    events: <?= json_encode($events) ?>,
    eventClick: function(info) {
      info.jsEvent.preventDefault();
      const evento = info.event;
      document.getElementById('modalTitle').textContent = evento.title;
      document.getElementById('modalStart').textContent = evento.start ? evento.start.toLocaleString() : '';
      document.getElementById('modalEnd').textContent = evento.end ? evento.end.toLocaleString() : '';
      document.getElementById('modalDescuento').textContent = evento.extendedProps.descuento;
      document.getElementById('modalPortafolio').textContent = evento.extendedProps.portafolio;
      const modal = new bootstrap.Modal(document.getElementById('eventModal'));
      modal.show();
    }
  });
  calendar.render();
});
</script>