<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar <?= $producto_costo->nombre ?></h5>
            <a href="<?= base_url('settings/productos') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('producto-costo/edit') ?>">
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
                      value="<?= $producto_costo->id_wc ?>"
                      readonly="readonly"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">SKU<small style="color:red;">*</small></label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $producto_costo->id ?>"
                  >
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      value="<?= $producto_costo->sku ?>"
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
                      value="<?= $producto_costo->precio_venta ?>"
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
                      value="<?= $producto_costo->costo ?>"
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
                      value="<?= $producto_costo->inventario ?>"
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
                      value="<?= $producto_costo->nombre ?>"
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
                  <label class="form-label">Slug</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      value="<?= $producto_costo->slug ?>"
                      placeholder="Slug"
                      type="text" 
                      id="slug" 
                      name="slug" 
                      class="form-control" 
                      maxlength="255"
                      pattern="[a-z0-9\-]+"
                      oninput="this.value = this.value.toLowerCase().replace(/[^a-z0-9\-]/g, '').replace(/\s+/g, '-');"
                      readonly="readonly"
                    >
                  </div>
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="row my-2">
              <div class="col-md-2">
                <div class="mb-3 form-check">
                  <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="kit" 
                    name="kit" 
                    <?= $producto_costo->kit == 1 ? 'checked' : '' ?>
                  >
                  <label class="form-check-label" for="kit">Producto KIT</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Cantidad de productos por Kit<small class="required_input" style="color:red; display:none;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      <?= $producto_costo->kit == 0 ? 'disabled' : '' ?>
                      value="<?= $producto_costo->kit_cantidad ?>"
                      placeholder="Cantidad"
                      type="text" 
                      id="kit_cantidad" 
                      name="kit_cantidad" 
                      class="form-control" 
                      maxlength="2"
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Selecciona producto base<small class="required_input" style="color:red; display:none;">*</small></label>
                  <select class="form-select select2" name="kit_producto" <?= $producto_costo->kit == 0 ? 'disabled' : '' ?>>
                    <option value="<?= $producto_costo->kit_producto ?>"><?= $producto_costo->kit_producto_nombre ?? 0 ?></option>
                    <?php foreach($productos as $producto): ?>
                      <?php if($producto->sku != $producto_costo->sku): ?>
                        <option value="<?= $producto->id ?>"><?= $producto->nombre ?> (SKU: <?= $producto->sku ?>) <?= $producto->costo ? " - $$producto->costo" : ''?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
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