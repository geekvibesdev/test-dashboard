<style>
    @media print {
        @page {
            margin: 0; /* Elimina márgenes para intentar ocultar encabezados/pies */
        }
        body {
            margin: 0;
        }
    }
</style>
<div class="min__h__100">
    <div class="card mb-2" style="box-shadow: none;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
				<div class="d-flex flex-column">
					<h5 class="mb-1">
						<strong>Orden: #<?= $orden->orden ?> </strong>
						<small class="text-muted">| Estatus: 
							<span class="color__primary__bg p-1"><?= $orden->estatus_orden ?></span>
						</small>
					</h5> 
					<p class="mb-0"><strong>Fecha: </strong><?= date('d/m/Y H:i', strtotime($orden->fecha_orden)) ?></p>
				</div>
				<img src="<?= base_url('assets/images/logos/mx-gm.png') ?>" height="80">
            </div>  
			<div class="row">
				<div class="col-12">
					<div class="table-responsive">
						<div id="botonera">
							<table class="table borderless">
								<tbody>
									<tr>
										<td class="p-1"><strong>Cliente</strong></td>
										<td class="p-1"><?= strtoupper($orden->envio_direccion->first_name . ' ' . $orden->envio_direccion->last_name) ?></td>
									</tr>
									<tr>
										<td class="p-1"><strong>Dirección de envío:</strong></td>
										<td class="p-1"><?= $orden->direccion_envio_completa ?></td>
									</tr>
									<tr>
										<td class="p-1"><strong>Teléfono:</strong></td>
										<td class="p-1"><?= $orden->envio_direccion->phone ?></td>
									</tr>
									<tr>
										<td class="p-1"><strong>Correo:</strong></td>
										<td class="p-1"><?= $orden->envio_direccion->billing_email ?></td>
									</tr>
									<tr>
										<td class="p-1"><strong>Notas de entrega</strong></td>
										<td class="p-1"><?= $orden->notas_de_entrega == "" ? 'No proporcionado' : $orden->notas_de_entrega ?></td>
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
		<div class="col-12">
			<div class="card" style="box-shadow: none;">
				<div class="card-body">    
					<div class="col-md-12">
						<table class="table table-hover mb-2">
							<thead>
								<tr>
									<th>Productos</th>
									<th class="text-center">Cantidad</th>
									<th class="text-end">Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($orden->productos as $producto): ?>
									<tr>
										<td>
											<?= $producto->name ?><br>
											<?php
                                                if($producto->producto_personalizado == true){
                                                    echo "<strong>Personalizado: </strong>" .$producto->producto_personalizado_texto."<br>";
                                                }
                                            ?>
											<strong>SKU:</strong> <?= $producto->sku ?><br>
										</td>
										<td class="text-center"><?= $producto->quantity ?></td>
										<td class="text-end">$<?= number_format($producto->subtotal + $producto->subtotal_tax, 2) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="d-flex justify-content-end mt-4">
							<div class="col-md-4">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td class="p-1"><strong>Envío:</strong></td>
											<td class="p-1 text-end">$<?= number_format($orden->cot_envio_total, 2) ?></td>
										</tr>
										<tr>
											<td class="p-1"><strong>Subtotal:</strong></td>
											<td class="p-1 text-end">$<?= number_format($orden->orden_total, 2) ?></td>
										</tr>
										<tr>
											<td class="p-1"><strong>Total:</strong></td>
											<td class="p-1 text-end">$<?= number_format($orden->orden_total, 2) ?> <br> <span class="f-12">(Incluye $<?= number_format($orden->orden_impuestos, 2) ?> en impuestos)</span></td>
										</tr>
									</tbody>
								</table>
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td class="p-1"><strong>Método de pago:</strong></td>
											<td class="p-1 text-end"><?= $orden->metodo_pago ?></td>
										</tr>
									</tbody>
								</table>	
							</div>
						</div>
					</div>
				</div>  
			</div>
		</div>
	</div>
</div>
