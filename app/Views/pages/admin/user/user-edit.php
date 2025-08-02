<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar usuario</h5>
            <a href="<?= base_url('settings/user') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('auth/user/update') ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nombre(s) <small style="color:red;">*</small></label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $user->id ?>"
                  >
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Nombre(s)"
                      type="text" 
                      id="name" 
                      name="name"
                      value="<?= $user->name ?>"
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
                      value="<?= $user->email ?>"
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <label class="form-label">Foto</label>
                <div class="mb-4 d-flex align-items-center">
                  <img
                    class="rounded-circle" width="50" height="50"
                    alt="<?= $user->name ?>"
                    src="<?= base_url( $user->photo) ?>"
                    id="actualImage"
                  />
                  <div class="ms-2 w-100">
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
                  <div class="mb-4">
                    <label class="form-label">Rol <small style="color:red;">*</small></label>
                    <select class="form-select select2" name="rol" required>
                      <option value="<?= $user->rol ?>">
                        <?php
                          if ($user->rol == 'admin') {
                            echo 'Administrador';
                          } 
                          if ($user->rol == 'user') {
                            echo 'Usuario';
                          } 
                          if ($user->rol == 'externo') {
                            echo 'Cliente';
                          } 
                          if ($user->rol == 'proveedor') {
                            echo 'Proveedor';
                          } 
                          if ($user->rol == 'gml_operador') {
                            echo 'GML Operador';
                          } 
                        ?>
                      </option>
                      <option value="user">Usuario</option>
                      <option value="admin">Administrador</option>
                      <option value="externo">Cliente</option>
                      <option value="proveedor">Proveedor</option>
                      <option value="gml_operador">GML Operador</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="mb-4">
                    <label class="form-label">Restablecer password</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="ti ti-lock"></i></span>
                      <input 
                        placeholder="Escribe nueva contraseña"
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                      >
                    </div>
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
              <button type="submit" class="btn btn-primary d-block" id="employeDischargeSave"><i class="ti ti-edit"></i> Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
