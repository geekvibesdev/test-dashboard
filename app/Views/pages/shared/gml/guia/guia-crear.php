<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100 h-100" id="guiaForm">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Crear guia</h5>
          </div>
          <div class="row mt-4">
            <div class="d-flex align-items-start">
              <div class="nav flex-column nav-pills me-3 nav__tab" id="v-pills-tab" role="tablist" aria-orientation="vertical" >
                <button class="nav-link active" id="v-pills-direccion-tab" data-bs-toggle="pill" data-bs-target="#v-pills-direccion" type="button" role="tab" aria-controls="v-pills-direccion" aria-selected="true">Direccón</button>
                <button class="nav-link" id="v-pills-dimensiones-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dimensiones" type="button" role="tab" aria-controls="v-pills-dimensiones" aria-selected="false">Dimensiones y peso</button>
                <button class="nav-link" id="v-pills-envio-tab" data-bs-toggle="pill" data-bs-target="#v-pills-envio" type="button" role="tab" aria-controls="v-pills-envio" aria-selected="false">Envío</button>
              </div>
              <div class="tab-content px-4 w-100" id="v-pills-tabContent">
                <!-- Direccion -->
                <div class="tab-pane show active" id="v-pills-direccion" role="tabpanel" aria-labelledby="v-pills-direccion-tab">
                  <h5>Remitente</h5>
                  <div class="col-md-12">
                    <div class="mb-4">
                      <select class="form-select select2" name="rol" required id="remitente">
                        <?php foreach($remitentes as $remitente): ?>
                          <option value="<?= $remitente->id ?>"><?= $remitente->nombre_completo ?> - <?= $remitente->direccion_completa ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <h5>Destinatario</h5>
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
                </div>
                <!-- Dimensiones -->
                <div class="tab-pane" id="v-pills-dimensiones" role="tabpanel" aria-labelledby="v-pills-dimensiones-tab">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Largo (cm)</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-box"></i></span>
                          <input 
                            placeholder="Largo (cm)"
                            type="text" 
                            id="largo_cm" 
                            name="largo_cm" 
                            class="form-control" 
                            required=""
                            pattern="\d+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            maxlength="4"
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Ancho (cm)</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-box"></i></span>
                          <input 
                            placeholder="Ancho (cm)"
                            type="text" 
                            id="ancho_cm" 
                            name="ancho_cm" 
                            class="form-control" 
                            required=""
                            pattern="\d+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            maxlength="4"
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Altura (cm)</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-box"></i></span>
                          <input 
                            placeholder="Altura (cm)"
                            type="text" 
                            id="alto_cm" 
                            name="alto_cm" 
                            class="form-control" 
                            required=""
                            pattern="\d+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            maxlength="4"
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Peso (kg)</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-box"></i></span>
                          <input 
                            placeholder="Peso (kg)"
                            type="text" 
                            id="peso_kg" 
                            name="peso_kg" 
                            class="form-control" 
                            required=""
                            pattern="\d+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            maxlength="4"
                          >
                        </div>
                      </div>
                    </div>
                  </div>  
                </div>
                <!-- Envio -->
                <div class="tab-pane" id="v-pills-envio" role="tabpanel" aria-labelledby="v-pills-envio-tab">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Orden asociada</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-id"></i></span>
                          <input 
                            placeholder="Orden asociada"
                            type="text" 
                            id="wc_orden" 
                            name="wc_orden" 
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
                        <label class="form-label">Tipo de envío</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-ship"></i></span>
                          <select class="form-select" name="rol" required id="tipo_envio">
                            <option value="estandar">Estandar</option>
                            <option value="prioritario">Prioritario</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Entrega estimada o requerida</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                          <input 
                            placeholder="Entrega estimada o requerida"
                            type="date" 
                            id="entrega_estimada" 
                            name="entrega_estimada" 
                            class="form-control" 
                            required=""
                            min="<?php echo date('Y-m-d'); ?>"
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row px-3">
                    <div class="col-12 d-flex justify-content-end">
                      <button class="btn btn-primary d-block" id="crearGuiaBtn"><i class="ti ti-edit"></i> Crear</button>
                    </div>
                    <div class="mt-4 alert" id="alerta" style="display:none;">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card w-100 h-100 py-5" id="guiaCreada" style="display:none!important;">
        <div class="row mt-4 d-flex justify-content-center align-items-center">
          <div class="col-md-4 text-center">
            <h2>Guia creada:</h2>
            <h4 class="text-info mt-4" id="successGuia"></h4>
            <a class="btn btn__simple border mt-4 me-3" href="<?= base_url('/gml/guias/nuevo') ?>">Generar nueva</a>
            <a class="btn btn__simple border mt-4 me-3" id="successGuiaUrlDetail">Ver detalle</a>
            <a class="btn btn-primary mt-4" id="successGuiaUrl" target="_blank">Imprimir guia</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>