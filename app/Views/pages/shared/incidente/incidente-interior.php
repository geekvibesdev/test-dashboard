<div class="container-fluid mw-1600">
  <div class="row">
     <div class="col-md-8 col-lg-9">
       <div class="row">
          <div class="col-lg-12 d-flex align-items-stretch">
           <div class="card w-100">
             <div class="card-body p-4">
               <div class="d-flex justify-content-between align-items-center">
                 <h5 class="card-title fw-semibold m-0">Incidente <a style="font-size:20px" href="<?=$truedesk_url?>/tickets/<?=$incidente->incidente_id?>" target="_blank">#<?=$incidente->incidente_id?></a> - <?=$incidente->incidente_titulo?> <small class="text-muted">| Estatus: <span class="color__primary__bg"><strong><?= $incidente->incidente_estatus ?></strong></span></small></h5>
                 <div class="d-flex">
                   <button class="btn btn-primary  d-block me-2" id="btn__modal__ai"><i class="ti ti-robot"></i> Sugerencia IA</button>
                 </div>
               </div>
               <div class="row mt-4">
                 <div class="col-md-12">
                   <div class="card__ticket">
                     <div class="card__ticket__header">
                       <img class="img-fluid" style="height:50px;width:50px;" src="<?= $truedesk_url ?>/uploads/users/<?= $incidente->incidente_data["owner"]["image"] ?>" alt="">
                       <div class="card__ticket__header__data">
                         <p class="m-0"><strong><?= $incidente->incidente_data["owner"]["fullname"] ?> | <?= $incidente->incidente_data["owner"]["email"] ?></strong></p>
                         <small>Fecha: <strong><?=$incidente->fecha_creado?></strong></small>
                       </div>
                     </div>
                     <div class="card__ticket__body mb-4">
                       <p class="card-title fw-semibold">Detalles del incidente:</p>
                       <div class="ticket__comment"><?= $incidente->incidente_descripcion ?></div>
                     </div>
                     <hr>
                     <div id="ticket__comments">
                       <div class="text-center my-4 mt-5" id="loaderComments">
                         <div class="spinner-border text-muted" role="status">
                           <span class="visually-hidden">Loading...</span>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
    </div>  
    <div class="col-md-4 col-lg-3">
      <div class="card mb-3 sticky-header">
          <div class="card-body p-0">
            <div class="col-md-12">
              <div class="title__section-table">
                <p class="m-0"><strong>Datos Orden</strong></p>
              </div>
              <table class="table borderless">
                <tbody>
                  <tr>
                    <td><strong>Orden</strong></td>
                    <td>
                      <a href="<?= base_url() ?>ventas/ordenes/<?= $orden->orden ?>">
                        #<?= $orden->orden ?> - <?= $orden->estatus_orden ?>
                      </a>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Fecha</strong></td>
                    <td>
                        <?= date('d/m/Y H:i', strtotime($orden->fecha_orden)) ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Cliente</strong></td>
                    <td>
                      <?= $orden->envio_direccion->first_name ?> <?= $orden->envio_direccion->last_name ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Dirección</strong></td>
                    <td>
                      <?= $orden->direccion_envio_completa ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Personalizados</strong></td>
                    <td>
                      <?= $orden->productos_personalizados ? 'Si' : 'No' ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Descuentos</strong></td>
                    <td>$<?= number_format($orden->orden_descuentos, 2) ?></td>
                  </tr>
                  <tr>
                    <td><strong>Envío</strong></td>
                    <td>$<?= number_format($orden->cot_envio_total, 2) ?></td>
                  </tr>
                  <tr>
                    <td><strong>Total orden</strong></td>
                    <td>$<?= number_format($orden->orden_total, 2) ?></td>
                  </tr>
                  <tr>
                    <td><strong>Paqueteria</strong></td>
                    <td>
                      <?= $orden->real_envio_paqueteria_nombre ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Guia</strong></td>
                    <td>
                      <?= $orden->real_envio_guia ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="modalSeguimientoContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSeguimientoContent" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalSeguimientoContentTitle">Sugerencia con IA</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="modalSeguimientoContentBody">
            <div class="row">
              <div class="col-12">
                <p class="text-muted">Genera un correo electrónico de seguimiento para el ticket. Puedes ajustar el texto antes de enviarlo.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Cliente <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Nombre del cliente"
                      type="text" 
                      id="cliente" 
                      name="cliente" 
                      class="form-control" 
                      value="<?= $orden->envio_direccion->first_name ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="mb-3">
                  <label class="form-label d-flex align-items-center">
                    Contexto inicial
                    <div class="form-check ms-3">
                      <input class="form-check-input" type="checkbox" value="1" id="incluirContexto" checked>
                      <label class="form-check-label" for="incluirContexto">
                        Incluir contexto
                      </label>
                    </div>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-history"></i></span>
                    <input 
                      placeholder="Reporte inicial del ticket"
                      type="text" 
                      id="contexto" 
                      name="contexto" 
                      class="form-control" 
                      value="<?= $incidente->incidente_titulo ?>"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Seguimiento <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-edit"></i></span>
                    <input class="form-control" id="seguimientoAI" placeholder="Escribe aquí tu mensaje para que lo afine la IA, se breve y directo con lo que necesitas"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12 text-end">
                <button class="btn btn-primary" id="btnGenerarSeguimientoAI"><i class="ti ti-robot"></i> Generar sugerencia</button>
              </div>
            </div>
            <div class="row mt-2" id="seguimiento__respuesta" style="display:none;">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Sugerencia</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-edit"></i></span>
                    <textarea style="resize:none" class="form-control" id="seguimiento__respuesta__sugerencia" rows="15"></textarea>
                  </div>
                </div>
              </div>
              <div class="col-12 text-end">
                <button class="btn btn__simple border me-2" id="btnCopiarSeguimientoAI"><i class="ti ti-copy"></i> Copiar</button>
                <button class="btn btn-primary" id="btnPostearSeguimientoAI"><i class="ti ti-edit"></i> Postear</button>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>
<script>
  var ticketId      = "<?= $incidente->incidente_id ?>";
  var imagePath     = "<?= $truedesk_url ?>/uploads/users/"
  var _id           = "<?= $incidente->incidente_data["_id"] ?>";
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>

