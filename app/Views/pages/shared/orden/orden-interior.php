<div class="container-fluid mw-1600">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>
                            Orden: #<?= $orden->orden ?> 
                            <small class="text-muted">| Estatus: 
                                <span class="color__primary__bg"><strong><?= $orden->estatus_orden ?></strong></span>
                            </small>
                        </h5> 
                        <div class="d-flex order__actions">
                            <a onclick="imprimirPedido(<?= $orden->orden ?>)" class="btn btn__simple border me-2">
                                <i class="ti ti-printer"></i> Imprimir orden
                            </a>
                            <?php if (!isset($orden->incidente) || $orden->incidente === null): ?>
                                <button class="btn btn__simple border me-2" target="_blank" id="generarIncidente">
                                    <i class="ti ti-ticket"></i> Incidente
                                </button>
                            <?php endif; ?>
                            <a class="btn btn__simple border me-2" href="<?= base_url('gml/guias/nuevo')."?orden=".$orden->orden ?>">
                                <i class="ti ti-truck"></i> Crear guia
                            </a>
                            <?php if($orden->estatus_orden == "processing" && $orden->real_envio_costo !== null &&  $orden->real_envio_costo != 0): ?>
                                <button class="btn btn-primary me-2" id="completeOrder" orderId="<?= $orden->orden ?>">
                                    <div id="completeOrderLoader" class="spinner-border spinner-border-sm me-2" role="status" style="display:none">
                                        <span class="sr-only"></span>
                                    </div>
                                    <i class="ti ti-cloud"></i> Completar Orden
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>  
                    <div class="table-responsive">
                        <div id="botonera">
                            <table class="table table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Estatus</th>
                                        <th>Cliente</th>
                                        <th>Descuentos</th>
                                        <th>Subtotal</th>
                                        <th>Envío</th>
                                        <th>Impuestos</th>
                                        <th>Total orden</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= date('d/m/Y H:i:s', strtotime($orden->fecha_orden)) ?></td>
                                        <td id="notas__td">
                                            <div id="getNotasLoader" class="spinner-border" role="status" style="display:none"><span class="sr-only"></span></div>
                                            <a id="getNotas" orden="<?= $orden->orden ?>" href="#"><?= $orden->estatus_orden ?></a>
                                        </td>
                                        <td id="cliente__td">
                                            <div id="getClientesLoader" class="spinner-border" role="status" style="display:none"><span class="sr-only"></span></div>
                                            <a id="getCliente" cliente="<?= $orden->cliente_id ?>" href="#"><?= $orden->envio_direccion->first_name . ' ' . $orden->envio_direccion->last_name ?></a>
                                        </td>
                                        <td>$<?= number_format($orden->orden_descuentos, 2) ?></td>
                                        <td>$<?= number_format($orden->orden_subtotal, 2) ?></td>
                                        <td>$<?= number_format($orden->cot_envio_total, 2) ?></td>
                                        <td>$<?= number_format($orden->orden_impuestos, 2) ?></td>
                                        <td>$<?= number_format($orden->orden_total, 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-9">
            <div class="card">
                <div class="card-body table-responsive">    
                    <div class="col-md-12">
                        <table class="table table-hover table-responsive mb-2">
                            <thead>
                                <tr>
                                    <th>Productos</th>
                                    <th class="text-center mb__d-none">Costo unitario</th>
                                    <th class="text-center mb__d-none">Precio unitario</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orden->productos as $producto): ?>
                                    <tr>
                                        <td>
                                            <?= $producto->name ?><br>
                                            <strong>SKU:</strong> <?= $producto->sku ?><br>
                                            <?php
                                                if($producto->producto_personalizado == true){
                                                    echo '<strong style="color:red !important;">Personalizado: </strong>' .$producto->producto_personalizado_texto."<br>";
                                                }
                                            ?>
                                            <?php
                                                if(isset($producto->tiene_descuento) && $producto->tiene_descuento == true) {
                                                    echo '<strong style="color:red;">Desc.: </strong>' . $producto->descuento_aplicado;
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center mb__d-none"><?= isset($producto->costo_unitario) ? "$" . number_format($producto->costo_unitario, 2) : '<span style="color:red;">Faltante</span>' ?></td>
                                        <td class="text-center mb__d-none">$<?= number_format($producto->price, 2) ?></td>
                                        <td class="text-center"><?= $producto->quantity ?></td>
                                        <td class="text-end">$<?= number_format($producto->subtotal, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td>
                                        <strong class="d-flex align-items-center">
                                            <i class="ti ti-truck me-2" style="font-size:24px;"></i> <?= $orden->envio_tipo ?><br>
                                        </strong>
                                    </td>
                                    <td class="text-center mb__d-none"></td>
                                    <td class="text-center mb__d-none"></td>
                                    <td class="text-center"></td>
                                    <td class="text-end">$<?= number_format($orden->cot_envio_total, 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4">
                                <table class="table table-borderless table-responsive">
                                    <tbody>
                                        <tr>
                                            <td class="p-1">
                                                <?php if (count($orden->orden_descuentos_titulos) > 0): ?>
                                                    <strong>Descuentos</strong>
                                                <?php else: ?>
                                                    <strong>Sin descuentos</strong>
                                                <?php endif; ?>
                                            </td>
                                            <td class="p-1 text-end">-$<?= number_format($orden->orden_descuentos, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1"><strong>Subtotal:</strong></td>
                                            <td class="p-1 text-end">$<?= number_format($orden->orden_subtotal, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1"><strong>Envío:</strong></td>
                                            <td class="p-1 text-end">$<?= number_format($orden->cot_envio_total, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1"><strong>Impuestos <span class="f-12">(<?= $orden->impuestos[0]->label ?> <?= $orden->impuestos[0]->rate_percent ?> %)</span>:</strong></td>
                                            <td class="p-1 text-end">$<?= number_format($orden->orden_impuestos, 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-1"><strong>Total orden:</strong></td>
                                            <td class="p-1 text-end">$<?= number_format($orden->orden_total, 2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php if($orden->estatus_orden == 'processing' || $orden->estatus_orden == 'completed'): ?>
                    <hr class="mt-4 mb-3">
                    <div class="col-md-12">
                        <form method="post" action="<?= base_url('ordenes/orden/costos-real/edit') ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Selecciona paqueteria <small style="color:red;">*</small></label>
                                        <select class="form-select select2" name="real_envio_paqueteria" required>
                                            <option value="<?= $orden->real_envio_paqueteria ?>"><?= $orden->real_envio_paqueteria_nombre ?></option>
                                            <?php foreach($paqueterias as $paqueteria): ?>
                                                <option value="<?= $paqueteria->id ?>"><?= $paqueteria->nombre ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Guia <small style="color:red;">*</small></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-tags"></i></span>
                                            <input 
                                                placeholder="Guia"
                                                type="text" 
                                                id="real_envio_guia" 
                                                name="real_envio_guia"
                                                value="<?= $orden->real_envio_guia ?>"
                                                class="form-control" 
                                                required=""
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Costo guia <small style="color:red;">*</small></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ti ti-cash"></i></span>
                                            <input 
                                                placeholder="Costo guia"
                                                type="text" 
                                                id="real_envio_costo" 
                                                name="real_envio_costo"
                                                value="<?= $orden->real_envio_costo ?>"
                                                class="form-control" 
                                                required=""
                                                maxlength="10"
                                                pattern="\d+"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 form-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input" 
                                            id="promocion" 
                                            name="promocion" 
                                            <?= $orden->promocion == 1 ? 'checked' : '' ?>
                                        >
                                        <label class="form-check-label" for="promocion">Promoción de envío</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label">Selecciona promoción de envío<small style="color:red;">*</small></label>
                                        <select class="form-select select2" name="promocion_tipo" <?php if($orden->promocion != 1) echo 'disabled'; ?> required>
                                            <option value="<?= $orden->promocion_tipo ?>"><?= $orden->promocion_tipo_nombre ?></option>
                                            <?php foreach($promociones as $promocion): ?>
                                                <option value="<?= $promocion->id ?>"><?= $promocion->nombre ?></option>
                                            <?php endforeach; ?>
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
                            <button type="submit" class="btn btn-primary"><i class="ti ti-edit"></i> Actualizar datos de envío</button>
                            <input type="hidden" name="orden_id" value="<?= $orden->orden ?>">
                        </form>
                    </div>
                    <?php endif; ?>
                </div>  
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body p-0">    
                    <?php if ( $orden->incidente != null): ?>
                        <div class="col-md-12">
                            <div class="title__section-table" style="background-color: #f8d7da; color: #721c24; padding: 10px;">
                                <p class="m-0"><strong>Incidente generado</strong></p>
                            </div>
                            <table class="table borderless">
                                <tbody>
                                    <tr>
                                        <td><strong>Incidente</strong></td>
                                        <td>
                                            <a href="<?= base_url() ?>soporte/tickets/<?= $orden->incidente ?>">
                                                #<?= $orden->incidente ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Titulo</strong></td>
                                        <td>
                                            <a href="<?= $truedesk_url ?>/tickets/<?= $orden->incidente ?>" target="_blank">
                                                <?= $orden->incidente_titulo ?>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12">
                        <div class="title__section-table">
                            <p class="m-0"><strong>Envío</strong></p>
                        </div>
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Nombre</strong></td>
                                    <td><?= $orden->envio_direccion->first_name . ' ' . $orden->envio_direccion->last_name ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección:</strong></td>
                                    <td><?= $orden->direccion_envio_completa ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono</strong></td>
                                    <td><?= $orden->envio_direccion->phone ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo</strong></td>
                                    <td><?= $orden->envio_tipo ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <div class="title__section-table">
                            <p class="m-0"><strong>Facturación</strong></p>
                        </div>
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Requiere factura</strong></td>
                                    <td><?= $orden->facturacion_datos->billing_require_facturacion ?></td>
                                </tr>
                                <?php if($orden->facturacion_datos->csf_url): ?>
                                <tr>
                                    <td><strong>CSF</strong></td>
                                    <td><a href="<?=$orden->facturacion_datos->csf_url?>" target="_blank">Ver</a></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($orden->estatus_orden == "processing" || $orden->estatus_orden == "completed"): ?>
                                <tr>
                                    <td><strong>PDF</strong></td>
                                    <td><a href="<?= $facturacion_url."/pdf/$orden->orden" ?>" target="_blank">Ver</a></td>
                                </tr>
                                <tr>
                                    <td><strong>XML</strong></td>
                                    <td><a href="<?= $facturacion_url."/xml/$orden->orden" ?>" download target="_blank">Ver</a></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 ">
                        <div class="title__section-table">
                            <p class="m-0"><strong>Pago</strong></p>
                        </div>
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Pasarela</strong></td>
                                    <td><?=  $orden->pago_metodo ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Transacción</strong></td>
                                    <td><?=  $orden->pago_id ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalViewContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalViewContent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalViewContentTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalViewContentBody">
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalTicket" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTicket" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Reportar una incidencia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Estas a punto de generar un reporte para esta órden, por favor se especifico con la solicitud que debe ser atentida en la descripción.</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Descripción corta <small>(máximo 50 caracteres)</small> <small style="color:red;">*</small></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-pencil"></i></span>
                                <input 
                                    id="ordenId"
                                    type="hidden" 
                                    value="<?= $orden->orden ?>"
                                >
                                <input 
                                    placeholder="Ej. Producto no llegó, Producto dañado, etc."
                                    maxlength="50"
                                    type="text" 
                                    id="titulo" 
                                    class="form-control" 
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Descripción completa <small style="color:red;">*</small></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-details"></i></span>
                                <textarea 
                                    placeholder="Especifica a detalle lo sucedido."
                                    id="descripcion" 
                                    class="form-control" 
                                    rows="10"
                                    style="resize:vertical;"
                                ></textarea>
                            </div>
                            <small class="text-muted">Puedes pegar aquí correos electrónicos.</small>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn__simple border d-block me-2" id="ticketCancelar"><i class="ti ti-arrow-back"></i> Cancelar</button>
                        <button type="button" class="btn btn-primary d-block" id="ticketCrear"><i class="ti ti-edit"></i> Crear</button>
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