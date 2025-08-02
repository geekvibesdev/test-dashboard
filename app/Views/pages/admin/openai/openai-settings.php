<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">OpenAI Settings</h5>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <form id="openai-settings-form" method="post" action="<?= base_url('settings/openai') ?>">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">API URL <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-link"></i></span>
                        <input type="text" class="form-control" id="url" name="url" value="<?= esc($settings->url) ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="mb-3">
                      <label class="form-label">API Token <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-password"></i></span>
                        <input type="password" class="form-control" id="token" name="token" value="<?= esc($settings->token) ?>" required>
                        <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="toggleTokenVisibility()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                          <i class="ti ti-eye" id="toggleTokenIcon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Model <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-box-model"></i></span>
                        <input type="text" class="form-control" id="model" name="model" value="<?= esc($settings->model) ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Temperature <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-temperature"></i></span>
                        <input type="number" step="0.01" class="form-control" id="temperature" name="temperature" value="<?= esc($settings->temperature) ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Max Tokens <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-maximize"></i></span>
                        <input type="number" class="form-control" id="max_token" name="max_token" value="<?= esc($settings->max_token) ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="mb-3">
                      <label class="form-label">System Email Writer Prompt <small style="color:red;">*</small></label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-pencil"></i></span>
                        <textarea rows="10" class="form-control" id="system_prompt" name="system_prompt"><?= esc($settings->system_prompt) ?></textarea>
                      </div>
                    </div>
                  </div>                  
                  <div class="col-12">
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
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
<script>
  function toggleTokenVisibility() {
    const tokenInput = document.getElementById('token');
    const icon = document.getElementById('toggleTokenIcon');
    if (tokenInput.type === 'password') {
      tokenInput.type = 'text';
      icon.classList.remove('ti-eye');
      icon.classList.add('ti-eye-off');
    } else {
      tokenInput.type = 'password';
      icon.classList.remove('ti-eye-off');
      icon.classList.add('ti-eye');
    }
  }
</script>