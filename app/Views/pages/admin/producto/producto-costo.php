<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Producto</h5>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary d-block me-2" id="getProductosInventario">
                  <div id="getProductsLoader" class="spinner-border spinner-border-sm me-2" role="status" style="display:none">
                    <span class="sr-only"></span>
                  </div>
                  <i class="ti ti-cloud"></i> Sincronizar productos / inventario
                </button>
              <a href="<?= base_url('settings/productos/new') ?>" class="btn btn btn__simple border d-block"><i class="ti ti-plus"></i> Nuevo</a>
            </div>
          </div>
          <div class="mt-5 table-responsive directory">
            <table class="table text-nowrap table-hover mb-0 align-middle dt_table">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Id</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Id Wc</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">SKU</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Nombre</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Precio Venta</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Costo</h6>
                  </th>
                  <th class="border-bottom-0 text-center">
                    <h6 class="fw-semibold mb-0">Inventario</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Acción</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($productos_costos as $producto_costo): ?>
                  <tr>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $producto_costo->id ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $producto_costo->id_wc ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $producto_costo->sku ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <span class="fw-normal">
                        <?= $producto_costo->nombre ?>
                      </span>
                    </td>
                    <td class="border-bottom-0 text-end">
                      <span class="fw-normal">
                      $<?= number_format($producto_costo->precio_venta, 2, '.', ',') ?>
                      </span>
                    </td>
                    <td class="border-bottom-0 text-end">
                      <span class="fw-normal">
                      $<?= number_format($producto_costo->costo, 2, '.', ',') ?>
                      </span>
                    </td>
                    <td class="border-bottom-0 text-center">
                      <span class="fw-normal text-center">
                        <?= $producto_costo->inventario ?>
                      </span>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-normal mb-0 fs-4">
                        <a class="btn p-1 px-2" href="<?= base_url('settings/productos/edit/'.$producto_costo->id) ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                          </svg>
                        </a>
                        <button class="btn p-1 px-2 removeItem" itemId="<?= $producto_costo->id?>">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" width="24" height="24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                          </svg>
                        </button>
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
<div class="modal" id="modalViewContent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalViewContent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalViewContentTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalViewContentBody">
            </div>
            <div class="modal-footer" id="modalViewContentFooter" style="display:none">
              <div class="row container-fluid">
                <div class="col-12" id="errorSKUDuplicados" style="display:none">
                </div>
                <div class="col-12" id="alertContent" style="display:none">
                  <div class="alert alert-warning" id="alertMessage">
                    <strong>Esto puede tardar unos minutos, por favor no cierre la ventana.</strong>
                  </div>
                </div>
                <div class="col-12">
                  <div class="alert alert-danger" id="errorAlert" style="display:none">
                    <strong id="errorMessage"></strong>
                  </div>
                </div>
                <div class="col-12 text-end">
                  <button type="button" class="btn btn btn__simple border me-2" data-bs-dismiss="modal" id="cancelarSincronizacion">Cancelar</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal" id="iniciarSincronizacion">
                    <div id="syncLoader" class="spinner-border spinner-border-sm me-2" role="status" style="display:none">
                      <span class="sr-only"></span>
                    </div>
                    Iniciar sincronización
                  </button>
                </div>
              </div>
            </div>'
        </div>
    </div>
</div>

<script>
  var deleteURL     = "<?= base_url('producto-costo/delete'); ?>"
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>