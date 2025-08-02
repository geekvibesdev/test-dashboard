<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar promocion</h5>
            <a href="<?= base_url('settings/promociones') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('promociones-tienda/edit') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-4">
                <div class="mb-4">
                  <label class="form-label">Titulo <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-pencil"></i></span>
                    <input 
                      type="hidden" 
                      id="id" 
                      name="id"
                      value="<?= $promocion->id ?>"
                    >
                    <input 
                      placeholder="Titulo promocion"
                      type="text" 
                      id="titulo" 
                      name="titulo" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->titulo ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Titulo descuento WC <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-pencil"></i></span>
                    <input 
                      placeholder="Titulo de promocion en WooCommerce"
                      type="text" 
                      id="titulo_descuento_wc" 
                      name="titulo_descuento_wc" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->titulo_descuento_wc ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label class="form-label">Inicio <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                    <input 
                      placeholder="Fecha inicio"
                      type="date" 
                      id="fecha_inicio" 
                      name="fecha_inicio" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->fecha_inicio ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="mb-3">
                  <label class="form-label">Fin <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                    <input 
                      placeholder="Fecha fin"
                      type="date" 
                      id="fecha_fin" 
                      name="fecha_fin" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->fecha_fin ?>"
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="row my-2">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Descuento <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-percentage"></i></span>
                    <input 
                      placeholder="Descuento en porcentaje"
                      type="text" 
                      id="descuento" 
                      name="descuento" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->descuento ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label class="form-label">Portafolio <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-box"></i></span>
                    <input 
                      placeholder="Linea de productos en promocion"
                      type="text" 
                      id="portafolio" 
                      name="portafolio" 
                      class="form-control" 
                      required=""
                      value="<?= $promocion->portafolio ?>"
                    >
                  </div>
                </div>
              </div>
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
