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
                                            <?= $orden->estatus_orden ?>
                                        </td>
                                        <td id="cliente__td">
                                            <?= $orden->envio_direccion->first_name . ' ' . $orden->envio_direccion->last_name ?>
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
                                    <th class="text-center">Precio unitario</th>
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
                                                    echo '<strong style="color:green;">Personalizado: </strong>' .$producto->producto_personalizado_texto."<br>";
                                                }
                                            ?>
                                            <?php
                                                if(isset($producto->tiene_descuento) && $producto->tiene_descuento == true) {
                                                    echo '<strong style="color:red;">Desc.: </strong>' . $producto->descuento_aplicado;
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center">$<?= number_format($producto->price, 2) ?></td>
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
                                    <td class="text-center"></td>
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
                </div>  
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            <div class="card">
                <div class="card-body p-0">    
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