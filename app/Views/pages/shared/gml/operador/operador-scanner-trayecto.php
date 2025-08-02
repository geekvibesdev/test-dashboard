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
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="22" class="me-2">
                <path d="M55.46 16.1a4 4 0 104-4 4.05 4.05 0 00-4 4zm6.56 0a2.5 2.5 0 11-2.49-2.49A2.48 2.48 0 0162 16.1z"></path>
                <path d="M88.47 32L90 30.43 74.85 15.29V6.55H72.7v6.56L59.59 0 45.31 14.3H0v29.77h3.91v6.6h-1.7v5h9.45A5.88 5.88 0 0014 59.23H0v2.15h87.68v-2.15h-2.16V29zM2.17 42V16.45h42.45v25.48zm4.05 12.1H3.81v-1.87h2.41zm5.36-.6h-3.8v-2.8h-1.7v-6.63h40.7V29.19h11.71l3.15 10.87 2.73 2.46L66 50.68h-1.56v2.82h-2a5.88 5.88 0 00-5.81-5.13h-.53a5.88 5.88 0 00-5.3 5.1H23.18a5.85 5.85 0 00-5.78-5h-.53a5.88 5.88 0 00-5.29 5zm54.76-12.11l-2.81-2.54-1.87-6.55h6.19v13.91h-.56zm2.07 10.84v1.87H66v-1.87zm-50.64 6.46h-.4a4.31 4.31 0 01-.37-8.61h.4a4.31 4.31 0 01.37 8.61zm3 .52a5.93 5.93 0 002.39-3.57H50.9a5.91 5.91 0 002.59 3.57zm35.86-.66a4.31 4.31 0 01-.38-8.61h.4a4.31 4.31 0 01.35 8.61zm26.78.66h-23.7a5.9 5.9 0 002.59-3.57H70v-5h-1.87l-.57-2.91h9.72v-17H61.19L60.09 27H46.77V15.88L59.58 3.07l23.81 23.78zm-14-13V32.34h6.34v13.87z"></path>
                <path d="M49.66 23h19.71v1.55H49.66zM26.18 50h20.89v1.55H26.18zM55.84 45.28a8.46 8.46 0 00-6.22 3.62l1.28.89a6.92 6.92 0 0111.39 0l1.28-.88a8.5 8.5 0 00-7.73-3.63zM23.14 49.79l1.27-.88a8.42 8.42 0 00-13.95 0l1.28.89a6.92 6.92 0 0111.39 0zM57.28 30.63h-8.91v8.14h11.1zm-7.35 1.55h6.16l1.35 5.07H50zM48.37 40.16h2.53v1.55h-2.53zM17.39 52.18a.58.58 0 10.48.9.59.59 0 00-.07-.74.57.57 0 00-.41-.16zM15.75 53.82a.57.57 0 00-.57.46.59.59 0 00.35.65.56.56 0 00.7-.22.58.58 0 00-.07-.73.53.53 0 00-.41-.16zM17.39 55.45a.58.58 0 00-.22 1.12.57.57 0 00.7-.22.58.58 0 00-.07-.73.58.58 0 00-.41-.17zM19 53.82a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16zM56.6 52a.58.58 0 10.48.9.56.56 0 00-.08-.7.54.54 0 00-.4-.2zM55 53.67a.57.57 0 00-.57.46.58.58 0 00.35.65.56.56 0 00.7-.22.56.56 0 00-.07-.73.53.53 0 00-.41-.16zM56.6 55.3a.58.58 0 00-.22 1.12.58.58 0 00.63-1 .58.58 0 00-.41-.12zM58.23 53.67a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16z"></path>
              </svg> <strong>En trayecto</strong>
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
              <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/trayecto') ?>">
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
                <path d="M55.46 16.1a4 4 0 104-4 4.05 4.05 0 00-4 4zm6.56 0a2.5 2.5 0 11-2.49-2.49A2.48 2.48 0 0162 16.1z"></path>
                <path d="M88.47 32L90 30.43 74.85 15.29V6.55H72.7v6.56L59.59 0 45.31 14.3H0v29.77h3.91v6.6h-1.7v5h9.45A5.88 5.88 0 0014 59.23H0v2.15h87.68v-2.15h-2.16V29zM2.17 42V16.45h42.45v25.48zm4.05 12.1H3.81v-1.87h2.41zm5.36-.6h-3.8v-2.8h-1.7v-6.63h40.7V29.19h11.71l3.15 10.87 2.73 2.46L66 50.68h-1.56v2.82h-2a5.88 5.88 0 00-5.81-5.13h-.53a5.88 5.88 0 00-5.3 5.1H23.18a5.85 5.85 0 00-5.78-5h-.53a5.88 5.88 0 00-5.29 5zm54.76-12.11l-2.81-2.54-1.87-6.55h6.19v13.91h-.56zm2.07 10.84v1.87H66v-1.87zm-50.64 6.46h-.4a4.31 4.31 0 01-.37-8.61h.4a4.31 4.31 0 01.37 8.61zm3 .52a5.93 5.93 0 002.39-3.57H50.9a5.91 5.91 0 002.59 3.57zm35.86-.66a4.31 4.31 0 01-.38-8.61h.4a4.31 4.31 0 01.35 8.61zm26.78.66h-23.7a5.9 5.9 0 002.59-3.57H70v-5h-1.87l-.57-2.91h9.72v-17H61.19L60.09 27H46.77V15.88L59.58 3.07l23.81 23.78zm-14-13V32.34h6.34v13.87z"></path>
                <path d="M49.66 23h19.71v1.55H49.66zM26.18 50h20.89v1.55H26.18zM55.84 45.28a8.46 8.46 0 00-6.22 3.62l1.28.89a6.92 6.92 0 0111.39 0l1.28-.88a8.5 8.5 0 00-7.73-3.63zM23.14 49.79l1.27-.88a8.42 8.42 0 00-13.95 0l1.28.89a6.92 6.92 0 0111.39 0zM57.28 30.63h-8.91v8.14h11.1zm-7.35 1.55h6.16l1.35 5.07H50zM48.37 40.16h2.53v1.55h-2.53zM17.39 52.18a.58.58 0 10.48.9.59.59 0 00-.07-.74.57.57 0 00-.41-.16zM15.75 53.82a.57.57 0 00-.57.46.59.59 0 00.35.65.56.56 0 00.7-.22.58.58 0 00-.07-.73.53.53 0 00-.41-.16zM17.39 55.45a.58.58 0 00-.22 1.12.57.57 0 00.7-.22.58.58 0 00-.07-.73.58.58 0 00-.41-.17zM19 53.82a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16zM56.6 52a.58.58 0 10.48.9.56.56 0 00-.08-.7.54.54 0 00-.4-.2zM55 53.67a.57.57 0 00-.57.46.58.58 0 00.35.65.56.56 0 00.7-.22.56.56 0 00-.07-.73.53.53 0 00-.41-.16zM56.6 55.3a.58.58 0 00-.22 1.12.58.58 0 00.63-1 .58.58 0 00-.41-.12zM58.23 53.67a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16z"></path>
              </svg>
              Marcar en trayecto
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
            <h2 class="text-success mb-4">Guia en trayecto</h2>
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/trayecto') ?>">
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
            <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/trayecto') ?>">
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