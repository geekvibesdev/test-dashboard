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
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="18" class="me-2">
                <path d="M77.6 26.39A3.13 3.13 0 0075 25h-3.12a3.13 3.13 0 00-3.13 3.13v18.75A3.13 3.13 0 0071.88 50h12.5a3.12 3.12 0 003.12-3.12v-4.69a3.17 3.17 0 00-.5-1.74zm6.78 20.48h-12.5V28.12H75l9.38 14.07z"></path>
                <path d="M98.43 38.55L85.93 19.8a9.38 9.38 0 00-7.81-4.18h-12.5V9.38A9.38 9.38 0 0056.25 0H9.38A9.39 9.39 0 000 9.38v34.37a9.38 9.38 0 009.38 9.37v9.38a9.38 9.38 0 009.37 9.38h3.57a12.44 12.44 0 0024.11 0h16.51a12.45 12.45 0 0024.12 0h3.57A9.39 9.39 0 00100 62.5V43.75a9.32 9.32 0 00-1.57-5.2zM9.37 46.88a3.13 3.13 0 01-3.12-3.13V9.38a3.13 3.13 0 013.12-3.13h46.88a3.12 3.12 0 013.12 3.13v34.37a3.12 3.12 0 01-3.12 3.13zM34.38 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0134.38 75zM75 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0175 75zm18.75-12.5a3.12 3.12 0 01-3.13 3.12h-3.57a12.44 12.44 0 00-24.11 0H46.43a12.44 12.44 0 00-24.11 0h-3.57a3.12 3.12 0 01-3.13-3.12v-9.38h40.63a9.38 9.38 0 009.37-9.37V21.88h12.5a3.12 3.12 0 012.6 1.39L93.22 42a3.12 3.12 0 01.53 1.73z"></path>
              </svg> <strong>Recolectando</strong>
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
              <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/recolectar') ?>">
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
            <button class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" id="successGuiaBtnAction">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="24" class="me-2">
                <path d="M77.6 26.39A3.13 3.13 0 0075 25h-3.12a3.13 3.13 0 00-3.13 3.13v18.75A3.13 3.13 0 0071.88 50h12.5a3.12 3.12 0 003.12-3.12v-4.69a3.17 3.17 0 00-.5-1.74zm6.78 20.48h-12.5V28.12H75l9.38 14.07z"></path>
                <path d="M98.43 38.55L85.93 19.8a9.38 9.38 0 00-7.81-4.18h-12.5V9.38A9.38 9.38 0 0056.25 0H9.38A9.39 9.39 0 000 9.38v34.37a9.38 9.38 0 009.38 9.37v9.38a9.38 9.38 0 009.37 9.38h3.57a12.44 12.44 0 0024.11 0h16.51a12.45 12.45 0 0024.12 0h3.57A9.39 9.39 0 00100 62.5V43.75a9.32 9.32 0 00-1.57-5.2zM9.37 46.88a3.13 3.13 0 01-3.12-3.13V9.38a3.13 3.13 0 013.12-3.13h46.88a3.12 3.12 0 013.12 3.13v34.37a3.12 3.12 0 01-3.12 3.13zM34.38 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0134.38 75zM75 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0175 75zm18.75-12.5a3.12 3.12 0 01-3.13 3.12h-3.57a12.44 12.44 0 00-24.11 0H46.43a12.44 12.44 0 00-24.11 0h-3.57a3.12 3.12 0 01-3.13-3.12v-9.38h40.63a9.38 9.38 0 009.37-9.37V21.88h12.5a3.12 3.12 0 012.6 1.39L93.22 42a3.12 3.12 0 01.53 1.73z"></path>
              </svg> 
              Marcar recolección
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
            <h2 class="text-success mb-4">Guia recolectada correctamente</h2>
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/recolectar') ?>">
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
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/recolectar') ?>">
              <i class="ti ti-scan me-2" height="24"></i>
              Escanear nuevo
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>