<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Nuevo remitente</h5>
            <a href="<?= base_url('settings/gml/remitentes') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('settings/gml/remitentes/new') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Nombres</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Nombres"
                      type="text" 
                      id="nombre" 
                      name="nombre" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Apellidos</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Apellidos"
                      type="text" 
                      id="apellidos" 
                      name="apellidos" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Correo electrónico</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                    <input 
                      placeholder="Correo electrónico"
                      type="email" 
                      id="correo_electronico" 
                      name="correo_electronico" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Telefono</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-phone"></i></span>
                    <input 
                      placeholder="Telfono"
                      type="text" 
                      id="telefono" 
                      name="telefono" 
                      class="form-control" 
                      required=""
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Calle y número</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <input 
                      placeholder="Calle y número"
                      type="text" 
                      id="calle_numero" 
                      name="calle_numero" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Colonia</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <input 
                      placeholder="Colonia"
                      type="text" 
                      id="colonia" 
                      name="colonia" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Ciudad</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <input 
                      placeholder="Ciudad"
                      type="text" 
                      id="ciudad" 
                      name="ciudad" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Estado</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <input 
                      placeholder="Estado"
                      type="text" 
                      id="estado" 
                      name="estado" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Código postal</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <input 
                      placeholder="Código postal"
                      type="text" 
                      id="codigo_postal" 
                      name="codigo_postal" 
                      class="form-control" 
                      required=""
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="5"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Referencias</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-map-pin"></i></span>
                    <textarea 
                      placeholder="Referencias"
                      type="text" 
                      id="referencias" 
                      name="referencias" 
                      class="form-control" 
                      required=""
                      rows="3"
                    ></textarea>
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
            <button type="submit" class="btn btn-primary d-block"><i class="ti ti-edit"></i> Crear</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>