<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="dash__container">
            <h5 class="m-0">Bienvenido: <?= session('user')->name ?></h5> 
            <div class="buttons__container">
              <a class="btn btn-primary w-100 d-flex align-items-center justify-content-center operador__button me-3" href="<?= base_url('gml/operador/scanner') ?>"><i class="ti ti-scan me-2" style="font-size:24px;"></i> GML Scanner</a>
              <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" href="<?= base_url('gml/operador/guias') ?>"><i class="ti ti-box me-2" style="font-size:24px;"></i> Guias</a>
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>
  <div class="row px-4 px-md-0">
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">Total</p>
          <h4 class="card-title mb-2" id="total">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">Por recolectar</p>
          <h4 class="card-title mb-2" id="creada">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">Reclolectado</p>
          <h4 class="card-title mb-2" id="recolectada">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">En transito</p>
          <h4 class="card-title mb-2" id="en_transito">0</h4>
        </div>
      </div>
    </div>
  </div>
  <div class="row px-4 px-md-0">
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">Entregado</p>
          <h4 class="card-title mb-2" id="entregada">0</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6 mb-6">
      <div class="card mb-2">
        <div class="card-body dash__card">
          <p class="mb-1">Cancelado</p>
          <h4 class="card-title mb-2" id="cancelada">0</h4>
        </div>
      </div>
    </div>
  </div>
</div>
