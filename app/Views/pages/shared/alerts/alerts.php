<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Alertas</h5>
      <?php if (!empty($alerts)): ?>
        <ul class="list-group">
          <?php foreach ($alerts as $alert): ?>
            <?php

              /***
               * PASAR TODO ESTO AL CONTROLADOR
              */

              // Decodificamos el JSON
              $alert->data = json_decode($alert->data);
              $action = ''; // URL donde envia la alerta
              $title = ''; // Titulo de la alerta
              /***
               * PASAR TODO ESTO AL CONTROLADOR
              */
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center <?= $alert->readed == 0 ? 'alert__closed'  : '' ?>">
              <p class="m-0"><?= $title ?> <small><b><?= htmlspecialchars(date('j F, Y', strtotime($alert->created_at))) ?></b></small></p>
              <div class="d-flex">
                <?php if ($alert->readed == 0): ?>
                  <button type="button" alertType="button" class="btn btn-outline-secondary p-1 px-2 markAsRead" alertId="<?=$alert->id ?>">Marcar leido</button>
                <?php endif; ?>
                <a alertId="<?=$alert->id ?>" href="<?= $action ?>" class="btn btn-outline-primary p-1 px-2 ms-2 markAsRead scroll-link">Ver</a>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="mb-0">No hay alertas nuevas</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>