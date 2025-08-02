<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar puesto</h5>
            <a href="<?= base_url('settings/paqueteria') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('paqueteria/edit') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Puesto</label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $paqueteria->id ?>"
                  >
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Nombre puesto"
                      type="text" 
                      id="name" 
                      name="name"
                      value="<?= $paqueteria->nombre ?>"
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
            </div>
            <div id="message__response" class="alert alert-success" style="display:none">
            </div>
            <?php if (session('message') !== null) : ?>
              <div class="alert alert-danger">
                <?= session('message'); ?>
              </div>
            <?php endif; ?>
            <?php if (session('success') !== null) : ?>
              <div class="alert alert-success">
                <?= session('success'); ?>
              </div>
            <?php endif; ?>
            <div class="d-flex">
              <button type="submit" class="btn btn-primary d-block"><i class="ti ti-edit"></i> Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
