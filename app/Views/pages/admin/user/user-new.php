<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Nuevo usuario <small class="f-12" style="color:red;">Campos con * son obligatorios.</small></h5>
            <a href="<?= base_url('settings/user') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('auth/register') ?>" enctype="multipart/form-data" id="register__form">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nombre(s) <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Nombre(s)"
                      type="text" 
                      id="name" 
                      name="name" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">E-mail <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                    <input 
                      placeholder="E-mail"
                      type="email" 
                      id="email" 
                      name="email" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Foto</label>
                  <input 
                    type="file" 
                    id="photo" 
                    name="photo" 
                    class="form-control" 
                    accept=".png, .jpg, .jpeg"
                  >
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Password <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-lock"></i></span>
                    <input 
                      placeholder="Password"
                      type="password" 
                      id="password" 
                      name="password" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Confirma Password <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-lock"></i></span>
                    <input 
                      placeholder="Confirma Password"
                      type="password" 
                      id="password-confirm" 
                      name="password-confirm" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-4">
                  <label class="form-label">Selecciona rol <small style="color:red;">*</small></label>
                  <select class="form-select select2" name="rol" required>
                    <option value="">Selecciona un rol</option>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                    <option value="externo">Cliente</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="gml_operador">GML Operador</option>
                  </select>
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

