<div class="container-fluid mobile__fw">
  <div class="card w-100">
    <div class="card-body p-4 sticky-header">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title fw-semibold m-0">Personalizables</h5>
      </div>
      <div class="mt-5 table-responsive directory">
        <table class="table text-nowrap table-hover mb-0 align-middle dt_table_s" id="">
          <thead class="text-dark fs-4">
            <tr>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Fecha creado</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Orden WC</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Estatus</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Fecha de envío</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Fecha de entrega</h6>
              </th>
              <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Acciones</h6>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($ordenPersonalizable as $orden_personalizable): ?>
              <tr>
                <td class="border-bottom-0">
                  <span class="fw-normal">
                    <?= date('d/m/Y H:i', strtotime($orden_personalizable->fecha_creado)) ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <span class="fw-normal">
                    <?= $orden_personalizable->wc_orden ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <span class="fw-normal">
                    <?= $orden_personalizable->estatus ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <span class="fw-normal">
                    <?= $orden_personalizable->fecha_envio ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <span class="fw-normal">
                    <?= $orden_personalizable->fecha_entrega ?>
                  </span>
                </td>
                <td class="border-bottom-0">
                  <h6 class="fw-normal mb-0 fs-4">
                    <a class="btn p-1 px-2" href="<?= base_url('ventas/personalizables/edit/'.$orden_personalizable->id) ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                      </svg>
                    </a>
                  </h6>
                </td>
              </tr>     
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>  