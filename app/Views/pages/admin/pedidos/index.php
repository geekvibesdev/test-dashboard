<div class="container-fluid">
    <h2>Listado de Pedidos</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>PEDIDO</th>
                <th>FECHA</th>
                <th>PLATAFORMA</th>
                <th>PAGO</th>
                <th>PAQUETERIA</th>
                <th>TIPO DE ENVÍO</th>
                <th>TOTAL</th>
                <th>VER DETALLE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= esc($pedido['ID']) ?></td>
                    <td><?= esc($pedido['PEDIDO']) ?></td>
                    <td><?= esc($pedido['FECHA']) ?></td>
                    <td><?= esc($pedido['PLATAFORMA']) ?></td>
                    <td><?= esc($pedido['PAGO']) ?></td>
                    <td><?= esc($pedido['PAQUETERIA']) ?></td>
                    <td><?= esc($pedido['TIPO_DE_ENVIO']) ?></td>
                    <td><?= esc($pedido['TOTAL']) ?></td>
                    <td>
                        <a href="<?= base_url('pedidos/detalles/'. esc($pedido['ID'])) ?>" class="btn btn-info">Ver Detalle</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
