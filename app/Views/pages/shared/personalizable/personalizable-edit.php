<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="div">
              <h5 class="card-title fw-semibold m-0">Pedido <a class="card-title text-info" href="<?= base_url('ventas/ordenes/'.$orden_personalizable->wc_orden) ?>">#<?= $orden_personalizable->wc_orden ?></a></h5>
              <small>Solo son mostrados los productos con personalización.</small>
            </div>
            <a href="<?= base_url('ventas/personalizables') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Ver todas</a>
          </div>
          <div class="row mt-4">
            <div class="col-12">
              <strong>Cliente:</strong> <?= $orden->envio_direccion->first_name . ' ' . $orden->envio_direccion->last_name ?>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7 col-lg-8">
              <div class="mt-4">
                <div class="table-responsive">
                  <div class="col-md-12">
                    <table class="table table-responsive mb-2">
                      <thead>
                        <tr>
                          <th>Productos</th>
                          <th class="text-center">Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($orden->productos as $producto): ?>
                          <?php if($producto->producto_personalizado == true): ?>
                          <tr>
                            <td>
                              <?= $producto->name ?><br>
                              <?php
                                $personalizado_textos = explode('|', $producto->producto_personalizado_texto);
                                echo "<strong>Personalizado: </strong><br>";
                                foreach ($personalizado_textos as $texto) {
                                  echo trim($texto) . "<br>";
                                }
                              ?>
                            </td>
                            <td class="text-center"><?= $producto->quantity ?></td>
                          </tr>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-lg-4">
              <div class="">
                <div class="card-body p-0">
                  <form method="post" class="py-4 mt-3" action="<?= base_url('personalizables/edit') ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label">Estatus<small class="required_input" style="color:red; display:none;">*</small></label>
                          <select class="form-select select2" name="estatus">
                            <option value="<?= $orden_personalizable->estatus ?>"><?= $orden_personalizable->estatus ?></option>
                            <option value="Nuevo">Nuevo</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Listo para recoleccion">Listo para recolección</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Pagado">Pagado</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label">Fecha de envío</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                            <input 
                              placeholder="Fecha de envío"
                              type="date" 
                              id="fecha_envio" 
                              name="fecha_envio" 
                              class="form-control" 
                              value="<?= $orden_personalizable->fecha_envio ?>"
                            >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label">Fecha de entrega</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                            <input 
                              placeholder="Fecha de entrega"
                              type="date" 
                              id="fecha_entrega" 
                              name="fecha_entrega" 
                              class="form-control" 
                              value="<?= $orden_personalizable->fecha_entrega ?>"
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label">Notas</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                            <textarea 
                              rows="4"
                              style="resize:none"
                              placeholder="Notas"
                              id="notas" 
                              name="notas" 
                              class="form-control" 
                            ><?= $orden_personalizable->notas ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input 
                      type="hidden" 
                      name="wc_orden" 
                      value="<?= $orden_personalizable->wc_orden ?>"
                    >
                    <input 
                      type="hidden" 
                      name="id" 
                      value="<?= $orden_personalizable->id ?>"
                    >
                    <div id="message__response" class="alert alert-success" style="display:none"></div>
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
                      <button type="submit" class="btn btn-primary d-block w-100"><i class="ti ti-edit"></i> Guardar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>