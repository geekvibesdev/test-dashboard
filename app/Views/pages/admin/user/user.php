<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Usuarios</h5>
            <a href="<?= base_url('settings/user/new') ?>" class="btn btn-primary d-block"><i class="ti ti-plus"></i> Nuevo</a>
          </div>
          <div class="mt-5 table-responsive directory">
            <table class="table text-nowrap table-hover mb-0 align-middle dt_table">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Nombre</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">E-mail</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Estatus</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Conexión</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Rol</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Acción</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($users as $user): ?>
                  <tr>
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center">
                        <img
                          class="rounded-circle" width="35" height="35"
                          alt="<?= $user->name ?>"
                          src="<?= base_url( $user->photo) ?>"
                        />
                        <div class="ms-2">
                          <h6 class="fw-semibold mb-1">
                            <?= $user->name ?>
                          </h6>                     
                        </div>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <p class="mb-0 fw-normal">
                        <?= $user->email ?>
                      </p>
                    </td>
              
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-2">
                        <span class="<?= $user->active == 1 ? 'bg-success' : 'bg-danger' ?> badge rounded-3 fw-semibold">
                          <?= $user->active == 1 ? 'Activo' : 'Inactivo' ?>
                        </span>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <p class="mb-0 fw-normal">
                        <?= $user->last_login == NULL ? 'Sin actividad' : $user->last_login ?>
                      </p>
                    </td>
                    <td class="border-bottom-0">
                      <p class="mb-0 fw-normal">
                        <?php
                          if ($user->rol == 'admin') {
                            echo 'Administrador';
                          } 
                          if ($user->rol == 'user') {
                            echo 'Usuario';
                          } 
                          if ($user->rol == 'externo') {
                            echo 'Cliente';
                          } 
                          if ($user->rol == 'proveedor') {
                            echo 'Proveedor';
                          } 
                          if ($user->rol == 'gml_operador') {
                            echo 'GML Operador';
                          } 
                        ?>
                      </p>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-normal mb-0 fs-4">
                        <a class="btn p-1 px-2" href="<?= base_url('settings/user/edit/'.$user->id) ?>">
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
  </div>
</div>