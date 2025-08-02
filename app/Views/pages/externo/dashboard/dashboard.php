<div class="container-fluid mw-1600">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-md-12 mb-6 order-0 mt-2">
          <div class="card mb-2">
            <div class="card-body p-3">
              <div class="d-flex align-items-start row">
                <div class="d-flex align-items-center justify-content-between px-4">
                    <h5 class="card-title m-0">Dashboard <span id="filter__result" class="text-success"></span></h5>
                    <div class="d-flex align-items-center filter__container">
                    <div>
                      <select class="form-select select2" name="estatus" id="estatus" style="display:none">
                        <option value="">Todos</option>
                        <option value="processing">En proceso</option>
                        <option value="completed">Completada</option>
                        <option value="on-hold">En espera</option>
                        <option value="cancelled">Cancelada</option>
                        <option value="refunded">Reembolsada</option>
                        <option value="failed">Fallida</option>
                        <option value="pending">Pendiente</option>
                        <option value="draft">Borrador</option>
                      </select>
                    </div>
                      <div class="input-group">
                        <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio" max="<?php echo date('Y-m-d'); ?>">
                        <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin" max="<?php echo date('Y-m-d'); ?>">
                        <button id="btn_filtrar" class="btn btn-primary">
                          <i class="ti ti-filter"></i>Filtrar
                        </button>
                        <button id="btn_limpiar" class="btn btn__simple">
                          <i class="ti ti-clear-all"></i>Limpiar
                        </button>
                        <button id="btn_refresh" class="btn btn-primary">
                          <i class="ti ti-refresh"></i>
                        </button>
                      </div>
                    </div>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Total Venta</p>
              <h4 class="card-title mb-2" id="totalVenta">0</h4>
              <small class="text-success fw-medium"><span id="totalVentaAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Completada</p>
              <h4 class="card-title mb-2" id="completed">0</h4>
              <small class="text-success fw-medium"><span id="completedAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">En proceso</p>
              <h4 class="card-title mb-2" id="processing">0</h4>
              <small class="text-success fw-medium"><span id="processingAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">En espera</p>
              <h4 class="card-title mb-2" id="on-hold">0</h4>
              <small class="text-success fw-medium"><span id="on-holdAmount">0</span></small>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Fallida</p>
              <h4 class="card-title mb-2" id="failed">0</h4>
              <small class="text-success fw-medium"><span id="failedAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Rembolsado</p>
              <h4 class="card-title mb-2" id="refunded">0</h4>
              <small class="text-success fw-medium"><span id="refundedAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Cancelado</p>
              <h4 class="card-title mb-2" id="cancelled">0</h4>
              <small class="text-success fw-medium"><span id="cancelledAmount">0</span></small>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-6">
          <div class="card mb-2">
            <div class="card-body dash__card">
              <p class="mb-1">Pendiente</p>
              <h4 class="card-title mb-2" id="pending">0</h4>
              <small class="text-success fw-medium"><span id="pendingAmount">0</span></small>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Transacciones por mes <span id="filter__result_graphics__month" class="text-success"></span></h5>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="totalRevenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-base bx ti ti-dots icon-lg text-body-secondary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue" style="">
                  <a class="dropdown-item graph-filter" href="#" data-type="month" data-url="/dashboard/data/graphics-month?anio=2025" data-title="2025">2025</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div>
                <canvas id="totalByMonth"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Transacciones por día <span id="filter__result_graphics" class="text-success"></span></h5>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="totalRevenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-base bx ti ti-dots icon-lg text-body-secondary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalRevenue" style="">
                  <a class="dropdown-item graph-filter" href="#" data-type="day" data-url="/dashboard/data/graphics?temporalidad=ultimos_7_dias" data-title="Últimos 7 días">Últimos 7 días</a>
                  <a class="dropdown-item graph-filter" href="#" data-type="day" data-url="/dashboard/data/graphics?temporalidad=ultimos_30_dias" data-title="Últimos 30 días">Últimos 30 días</a>
                  <a class="dropdown-item graph-filter" href="#" data-type="day" data-url="/dashboard/data/graphics?temporalidad=este_mes" data-title="Este mes">Este mes</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div>
                <canvas id="totalByDay"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Ventas por día <span id="filter__result_graphics_venta" class="text-success"></span></h5>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="totalVentasGraphic" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-base bx ti ti-dots icon-lg text-body-secondary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalVentasGraphic" style="">
                  <a class="dropdown-item graph-filter" href="#" data-type="ventaDay" data-url="/dashboard/data/graphics-venta?temporalidad=ultimos_7_dias" data-title="Últimos 7 días">Últimos 7 días</a>
                  <a class="dropdown-item graph-filter" href="#" data-type="ventaDay" data-url="/dashboard/data/graphics-venta?temporalidad=ultimos_30_dias" data-title="Últimos 30 días">Últimos 30 días</a>
                  <a class="dropdown-item graph-filter" href="#" data-type="ventaDay" data-url="/dashboard/data/graphics-venta?temporalidad=este_mes" data-title="Este mes">Este mes</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div>
                <canvas id="totalVentasByDay"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0 me-2">Transacciones por estado</h5>
              </div>
            </div>
            <div class="card-body">
              <div>
                <canvas id="totalByEstate" style="height: 300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
