<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Alta Proveedor</h5>
            <a href="<?= base_url('settings/proveedor') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('proveedor/new') ?>">
            <?php echo csrf_field(); ?>
            <h5>Generales</h5>
            <div class="row mt-3">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">RFC <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="RFC"
                      type="text" 
                      id="rfc" 
                      name="rfc" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^A-Z0-9]/g, '');"
                      maxlength="15"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Razon Social <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Razon Social"
                      type="text" 
                      id="razon_social" 
                      name="razon_social" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Sitio Web</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Sitio Web"
                      type="text" 
                      id="sitio_web" 
                      name="sitio_web" 
                      class="form-control" 
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Inicio de operaciones</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Sitio Web"
                      type="date" 
                      id="fecha_inicio_operaciones" 
                      name="fecha_inicio_operaciones" 
                      class="form-control" 
                    >
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h5 class="mt-4">Contacto Principal</h5>
            <div class="row mt-4">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Nombre <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Nombre"
                      type="text" 
                      id="contacto_nombre" 
                      name="contacto_nombre" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Correo electrónico <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Correo electrónico"
                      type="email" 
                      id="contacto_email" 
                      name="contacto_email" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Teléfono <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Teléfono"
                      type="text" 
                      id="contacto_telefono" 
                      name="contacto_telefono" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h5 class="mt-4">Datos de Pago</h5>
            <div class="row mt-4">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">CLABE Interbancaria <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="CLABE Interbancaria"
                      type="text" 
                      id="pago_clabe" 
                      name="pago_clabe" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="18"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Banco <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Banco"
                      type="text" 
                      id="pago_banco" 
                      name="pago_banco" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">No. Cuenta <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="No. Cuenta"
                      type="text" 
                      id="pago_cuenta" 
                      name="pago_cuenta" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h5 class="mt-4">Dirección de Oficina</h5>
            <div class="row mt-4">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Calle y Número <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Calle y Número"
                      type="text" 
                      id="oficina_calle_numero" 
                      name="oficina_calle_numero" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Colonia <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Colonia"
                      type="text" 
                      id="oficina_colonia" 
                      name="oficina_colonia" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Ciudad <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Ciudad"
                      type="text" 
                      id="oficina_ciudad" 
                      name="oficina_ciudad" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Estado <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Estado"
                      type="text" 
                      id="oficina_estado" 
                      name="oficina_estado" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Código Postal <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Código Postal"
                      type="text" 
                      id="oficina_codigo_postal" 
                      name="oficina_codigo_postal" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="5"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Teléfono <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Teléfono"
                      type="text" 
                      id="oficina_telefono" 
                      name="oficina_telefono" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Observaciones</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Observaciones"
                      type="text" 
                      id="oficina_observaciones" 
                      name="oficina_observaciones" 
                      class="form-control" 
                    >
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h5 class="mt-4">Dirección Fiscal</h5>
            <div class="input-group">
              <input 
                type="checkbox" 
                id="copy_address" 
                name="copy_address" 
                class="form-check-input me-2"
              >
              <label class="form-check-label" for="copy_address">Usar la misma dirección de oficina para la fiscal</label>
            </div>
            <div class="row my-4">
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Calle y Número <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Calle y Número"
                      type="text" 
                      id="fiscal_calle_numero" 
                      name="fiscal_calle_numero" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Colonia <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Colonia"
                      type="text" 
                      id="fiscal_colonia" 
                      name="fiscal_colonia" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Ciudad <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Ciudad"
                      type="text" 
                      id="fiscal_ciudad" 
                      name="fiscal_ciudad" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Estado <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Estado"
                      type="text" 
                      id="fiscal_estado" 
                      name="fiscal_estado" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Código Postal <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Código Postal"
                      type="text" 
                      id="fiscal_codigo_postal" 
                      name="fiscal_codigo_postal" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="5"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label class="form-label">Teléfono <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Teléfono"
                      type="text" 
                      id="fiscal_telefono" 
                      name="fiscal_telefono" 
                      class="form-control" 
                      required=""
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Observaciones</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Observaciones"
                      type="text" 
                      id="fiscal_observaciones" 
                      name="fiscal_observaciones" 
                      class="form-control" 
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
            <button type="submit" class="btn btn-primary d-block"><i class="ti ti-edit"></i> Crear</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>