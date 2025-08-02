<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">WC Log</h5>
            <a href="<?= base_url('settings/logs/wc') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <div class="row mt-4 mb-3">
            <div class="col-md-3">
              <strong>Date:</strong> <?=$log->fecha_creado?>
            </div>
            <div class="col-md-3">
              <strong>ID:</strong> <?=$log->id?>
            </div>
            <div class="col-md-3">
              <strong>Type:</strong> <?=$log->type?>
            </div>
            <div class="col-md-3">
              <strong>Status:</strong> <?=$log->status?>
            </div>
          </div>
          <div class="row mt-4 pb-4">
            <div class="col-md-9">
              <strong>Request:</strong><br/>
                <textarea class="form-control" rows="30" readonly><?= json_encode(json_decode($log->request), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></textarea>
            </div>
            <div class="col-md-3">
              <strong>Response:</strong><br/>
              <textarea class="form-control" rows="30" readonly><?= $log->response ?></textarea>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
