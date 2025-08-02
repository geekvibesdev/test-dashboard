<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-0 bn__br0">
        <div class="card-body py-0">
          <div class="dash__container mobile__header">
            <div class="action">
              <a class="" href="<?= base_url('gml/operador/scanner') ?>"><i class="ti ti-arrow-left" style="font-size:24px;"></i></a>
            </div>
            <span class="d-flex align-items-center justify-content-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="18" class="me-2" stroke-width="1" >
                <path d="M53.66 0l-33 42.16L5.12 27 0 32.3l21.43 20.82 38-48.59zM76.36 0l-33 42.16L39.12 38 34 43.29l10.13 9.83 38-48.59z" class="cls-1"></path>
              </svg> <strong>Entregar</strong>
            </span>
          </div>  
        </div>
      </div>
    </div>
  </div>
  <div class="mt-0">
    <div id="reader"></div>
  </div>
  <div class="row" id="qrResult">
    <div class="col-12">
      <div class="card bn__br0">
        <div class="card-body">
          <div class="mt-2">
            <div id="result">Esperando código QR...</div>
          </div>
        </div>
      </div>    
    </div>
  </div>
  <div class="row" id="qrResultFailed" style="display:none;">
    <div class="col-12">
      <div class="card bn__br0">
        <div class="card-body">
          <div class="text-center">
              <h4 class="text-warning my-4">No se encontró la guia</h4>
              <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/entregar') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="24" class="me-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Intentar de nuevo
              </a>
          </div>
        </div>
      </div>    
    </div>
  </div>
  <div class="row" id="qrResultSuccess" style="display:none;">
    <div class="col-md-12">
      <div class="card mb-0 bn__br0">
        <div class="card-body py-4">
          <div class="text-center">
            <h2>Guia:</h2>
            <h4 class="text-info my-4" id="successGuia"></h4>
            <button class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" id="successGuiaBtnActionSign">
              <img src="<?= base_url('/assets/images/icons/firma.png') ?>" alt="firma" height="24" class="me-2">
              Firmar
            </button>
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" id="successGuiaBtnDetail" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="24" class="me-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
              </svg>
              Ver detalle
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="qrResultSuccessAction" style="display:none;">
    <div class="col-md-12">
      <div class="card mb-0 bn__br0">
        <div class="card-body py-4">
          <div class="text-center">
            <h2 class="text-success mb-4">Guia entregada correctamente</h2>
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/entregar') ?>">
              <i class="ti ti-scan me-2" height="24"></i>
              Escanear nuevo
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" id="qrResultFailedAction" style="display:none;">
    <div class="col-md-12">
      <div class="card mb-0 bn__br0">
        <div class="card-body py-4">
          <div class="text-center">
            <h2 class="text-danger mb-4" id="qrResultFailedActionError"></h2>
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/entregar') ?>">
              <i class="ti ti-scan me-2" height="24"></i>
              Escanear nuevo
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="modalSignature" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSignature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Firma</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <canvas id="signature-pad" class="signature"></canvas>
            </div>
            <div class="modal-footer">
              <button id="clearSignatureBtn"  type="button" class="btn btn__simple border d-block me-2"><i class="ti ti-trash"></i> Borrar</button>
              <button id="saveSignatureBtn" type="button" class="btn btn-primary d-block"><i class="ti ti-edit"></i> Firmar y Entregar</button>
            </div>
        </div>
    </div>
</div>

<script>
  var csrfName        = '<?= $csrfName ?>';
  var csrfHash        = '<?= $csrfHash ?>';
</script>