<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Nuevo producto</h5>
            <a href="<?= base_url('settings/productos') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('producto-costo/new') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Id WooCommerce<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Id WooCommerce"
                      type="text" 
                      id="id_wc" 
                      name="id_wc" 
                      class="form-control" 
                      required=""
                      maxlength="8"
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">SKU<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="SKU"
                      type="text" 
                      id="sku" 
                      name="sku" 
                      class="form-control" 
                      required=""
                      maxlength="8"
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Precio Venta<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-cash"></i></span>
                    <input 
                      placeholder="Precio Venta"
                      type="text" 
                      id="precio_venta" 
                      name="precio_venta"
                      class="form-control" 
                      required=""
                      maxlength="8"
                      pattern="\d+(\.\d{1,2})?"
                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Costo<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-cash"></i></span>
                    <input 
                      placeholder="Costo"
                      type="text" 
                      id="costo" 
                      name="costo" 
                      class="form-control" 
                      required=""
                      maxlength="8"
                      pattern="\d+(\.\d{1,2})?"
                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Cantidad Inventario</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Cantidad Inventario"
                      type="text" 
                      id="inventario" 
                      name="inventario" 
                      class="form-control" 
                      maxlength="5"
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nombre<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Nombre"
                      type="text" 
                      id="nombre" 
                      name="nombre" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Slug<small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      required=""
                      placeholder="Slug"
                      type="text" 
                      id="slug" 
                      name="slug" 
                      class="form-control" 
                      maxlength="255"
                      pattern="[a-z0-9\-]+"
                      oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9\-]/g, '').replace(/\s+/g, '-');"
                    >
                  </div>
                  <small class="text-muted">Debe estar en minúsculas, sin espacios, y utilizar guiones (-) para separar palabras. </small>
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