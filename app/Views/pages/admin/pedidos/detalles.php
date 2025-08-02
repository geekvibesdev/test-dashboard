<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <h3>Detalles del Pedido #<?= esc($pedido['PEDIDO']) ?></h3>
            <table class="table table-bordered">
                <tr>
                    <th>Fecha</th>
                    <td><?= esc($pedido['FECHA']) ?></td>
                </tr>
                <tr>
                    <th>Plataforma</th>
                    <td><?= esc($pedido['PLATAFORMA']) ?></td>
                </tr>
                <tr>
                    <th>Estado de Pago</th>
                    <td><?= esc($pedido['PAGO']) ?></td>
                </tr>
                <tr>
                    <th>Paquetería</th>
                    <td><?= esc($pedido['PAQUETERIA']) ?></td>
                </tr>
                <tr>
                    <th>Tipo de Envío</th>
                    <td><?= esc($pedido['TIPO_DE_ENVIO']) ?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td><?= esc($pedido['TOTAL']) ?></td>
                </tr>
            </table>

            <?php 
                if($pedido['PAQUETERIA_REAL'] != null) {
                    echo '<h4>Datos de la paquetería real</h4>';
                    echo '<table class="table table-bordered">';
                    echo '<tr><th>Paquetería real</th><td>' . esc($pedido['PAQUETERIA_REAL']) . '</td></tr>';
                    echo '<tr><th>Número de seguimiento</th><td>' . esc($pedido['NUM_GUIA_REAL']) . '</td></tr>';
                    echo '<tr><th>Costo real</th><td>' . esc($pedido['COSTO_REAL_PAQUETERIA']) . '</td></tr>';
                    echo '</table>';
                }
                if($pedido['CON_PROMOCION'] == 1) {
                    echo '<h4>Datos de la promoción</h4>';
                    echo '<table class="table table-bordered">';
                    echo '<tr><th>Tipo de descuento</th><td>' . esc($pedido['TIPO_DE_PROMOCION']) . '</td></tr>';
                    echo '</table>';
                }
            ?>

            <div class="container__form">
                <div class="item__form">
                    <div class="container__form__title">
                        <h4>Actualizar Datos del pedido </h4>
                    </div>
                    <form method="post" action="<?= base_url('pedidos/update') ?>" id="update__pedido" class="form__pedido">
                        <input type="hidden" name="id_pedido" value="<?= esc($pedido['ID']) ?>">
                        <div class="form__group">
                            <label for="name_paqueteria">Nombre de la paquetería real </label>
                            <input type="text" class="form-control" id="name_paqueteria" name="name_paqueteria" placeholder="Paquetería" required>
                        </div>
                        <div class="form__group">
                            <label for="tracking_number">Número de seguimiento</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" placeholder="#00000" required>
                        </div>
                        <div class="form__group">
                            <label for="costo_tracking">Costo</label>
                            <input type="text" class="form-control" id="costo_tracking" name="costo_tracking" placeholder="$0.00" required>
                        </div>
                        <div class="form__group promocion__check">
                            <label for="pedido_promocion">¿El pedido tuvo algun descuento?</label>
                            <input type="checkbox" id="pedido_promocion" name="pedido_promocion">
                        </div>
                        <div class="form__group">
                            <label for="tipo_descuento">Tipo de descuento</label>
                            <input type="text" class="form-control" id="tipo_descuento" name="tipo_descuento">
                        </div>
                        <div class="container__form__btn mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="d-flex justify-content-end">
                <a href="<?= base_url('pedidos') ?>" class="btn btn-secondary">Volver a la lista de pedidos</a>
            </div>
        </div>
    </div>
</div>
