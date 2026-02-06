<script>var csrfName = '<?= csrf_token() ?>'; var csrfHash = '<?= csrf_hash() ?>';</script>
<div class="container-fluid mw-1600">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-12 mb-4 mt-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-3">Agente de reporte</h5>
              <p class="text-body-secondary mb-3">Pregunta en lenguaje natural sobre ventas y ordenes. El agente traduce a consulta y responde con un resumen.</p>
              <div class="mb-3">
                <label for="agente-pregunta" class="form-label">Pregunta</label>
                <textarea class="form-control" id="agente-pregunta" rows="2" placeholder="Ej: Cuantas ordenes completadas hubo en enero 2025?"></textarea>
              </div>
              <button type="button" class="btn btn-primary" id="agente-btn-ask">
                <i class="ti ti-send"></i> Enviar
              </button>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div id="agente-loading" class="text-center py-4" style="display: none;">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 mb-0">Consultando...</p>
          </div>
          <div id="agente-error" class="alert alert-danger" style="display: none;" role="alert"></div>
          <div id="agente-response" class="card" style="display: none;">
            <div class="card-header">
              <h6 class="card-title mb-0">Respuesta</h6>
            </div>
            <div class="card-body">
              <div id="agente-respuesta-nl" class="mb-3"></div>
              <details class="small text-body-secondary">
                <summary>SQL ejecutado</summary>
                <pre id="agente-sql" class="bg-light p-2 rounded mt-1 mb-0"></pre>
              </details>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
