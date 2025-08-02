<div class="container-fluid mobile__fw">
  <div class="card mb-3 sticky-header">
    <div class="card-body mobile__pb0">       
      <div class="d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0">Cuentas por pagar <span id="filter__result" class="text-success"></span></h5>
        <div class="d-flex align-items-center filter__container">
          <div>
            <label for="fecha_inicio" class="form-label d_d-none">Estatus</label>
            <select class="form-select" name="estatus" id="estatus">
              <option value="">Todos</option>
              <option value="en_proceso">En proceso</option>
              <option value="pagada">Pagada</option>
              <option value="vencida">Vencida</option>
              <option value="cancelada">Cancelada</option>
            </select>
          </div>
          <div class="input-group">
            <label for="fecha_inicio" class="form-label d_d-none">Fecha inicio</label>
            <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio" max="<?php echo date('Y-m-d'); ?>">
            <label for="fecha_inicio" class="form-label d_d-none">Fecha fin</label>
            <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin" max="<?php echo date('Y-m-d'); ?>">
            <button id="btn_filtrar" class="btn btn-primary">
              <i class="ti ti-filter"></i>Filtrar
            </button>
            <button id="btn_limpiar" class="btn btn__simple">
              <i class="ti ti-clear-all"></i>Limpiar
            </button>
            <a href="<?= base_url('contabilidad/cuenta-por-pagar/new') ?>" class="btn btn-primary">
              <i class="ti ti-plus"></i>
            </a>
          </div>
        </div>
        <button id="btn_filtrar__mobile" class="btn btn-primary" onclick="showModalFilter()">
          <i class="ti ti-filter"></i>
        </button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="mt-5 table-responsive directory">
            <table class="table text-nowrap table-hover mb-0 align-middle dt_table" id="tabla__cuentas_por_pagar">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Id</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Fecha emisión</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Proveedor</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Factura</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Monto</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Fecha pago</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Estatus pago</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Tipo factura</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Categoría</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Días de crédito</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Factura PDF</h6>
                  </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
