<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Logs WC <span class="text-success">Mostrando los últimos 50 registros</span></h5>
          </div>
          <div class="mt-5 table-responsive directory">
            <table class="table text-nowrap table-hover mb-0 align-middle dt_table_s">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">date</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">type</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">request</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">status</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">actions</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($logs as $log): ?>
                  <tr>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $log->fecha_creado ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $log->type ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                      <?= substr($log->request, 0, 50) ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $log->status ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-normal mb-0 fs-4">
                        <a class="btn p-1 px-2" href="<?= base_url('settings/logs/wc/'.$log->id) ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
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
  </div>
</div>  