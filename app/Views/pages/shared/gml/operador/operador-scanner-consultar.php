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
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" height="18" class="me-2" stroke-width="1" >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg> <strong>Consultar</strong>
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
              <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button mb-3" href="<?= base_url('gml/operador/scanner/consultar') ?>">
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
</div>

<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>