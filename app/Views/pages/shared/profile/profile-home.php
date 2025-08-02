<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="mb-2 d-flex align-items-center">
        <form enctype="multipart/form-data" id="updatePhoto" style="display:none;">
          <div class="mb-3">
            <label for="photo" class="form-label">Foto de perfil</label>
            <input type="file" class="form-control" id="photo" name="photo" accept=".jpg, .jpeg, .png" required>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar foto de perfil</button>
        </form>
        <img 
          id="actualImage"
          alt="<?= base_url($user->name) ?>"
          src="<?= base_url($user->photo) ?>"
          class="rounded-circle update__image"
          width="100"
          height="100"
        />
        <div class="ms-3">
          <h5 class="card-title fw-semibold mb-0"><?= $user->name ?></h5>
          <small class="text-muted">(<?= $user->email ?>)</small>
        </div>
      </div>
      <hr />
      <div class="row mt-4">
        <div class="col-md-6">
          <h6 class="fw-semibold mb-4">Actualizar información</h6>
            <form id="updateProfile">
              <div class="mb-3">
                <label class="form-label">Nombre(s) <small style="color:red;">*</small></label>
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
              <div class="d-block">
                <button type="submit" class="btn btn-primary d-block w-100">
                  <i class="ti ti-edit"></i> Actualizar información
                </button>
                <a class="btn btn__simple border mt-2  d-block w-100" href="<?= base_url('auth/logout') ?>">
                  <i class="ti ti-logout"></i> Cerrar sesión
                </a>
              </div>
            </form>
        </div>  
        <div class="col mt-4 mt-md-0">
          <h6 class="fw-semibold mb-4">Actualizar contraseña</h6>
          <form id="updatePassword">
            <div class="mb-3">
              <label class="form-label">Contraseña actual</label>
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-lock"></i></span>
                <input type="password" class="form-control" id="oldPassword" name="oldPassword" required placeholder="Contraseña actual">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nueva contraseña</label>
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Nueva contraseña">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Repetir contraseña</label>
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-lock"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirmar contraseña">
              </div>
            </div>
            <button type="submit" class="btn btn__simple border w-100">
              <i class="ti ti-edit"></i> Actualizar contraseña
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var baseUrl       = "<?= base_url('profile/update'); ?>"
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>