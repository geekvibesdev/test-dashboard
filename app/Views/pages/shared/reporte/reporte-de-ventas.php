<div class="container-fluid mw-1600">
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-md-12 mb-6 order-0 mt-2">
          <div class="card sticky-header mb-2">
            <div class="card-body p-3">
              <div class="d-flex align-items-start row">
                <div class="d-flex align-items-center justify-content-between px-4">
                    <h5 class="card-title m-0">Reporte de ventas</h5>
                    <div class="d-flex align-items-center filter__container" id="filter__container">
                      <div class="input-group">
                        <button class="btn btn-primary" id="descargar_xls" style="display: none;">
                          <i class="ti ti-download"></i> Excel
                        </button>
                        <button class="btn btn-primary" id="descargar_pdf" style="display: none;">
                          <i class="ti ti-download"></i> PDF
                        </button>
                        <label for="fecha_inicio" class="form-label d_d-none">Año</label>
                        <select class="form-select" name="anio" id="anio">
                          <option value="">Año</option>
                          <option value="2025">2025</option>
                        </select>
                        <label for="fecha_inicio" class="form-label d_d-none">Mes</label>
                        <select class="form-select" name="mes" id="mes">
                          <option value="">Mes</option>
                          <option value="05">Mayo</option>
                          <option value="06">Junio</option>
                          <option value="07">Julio</option>
                          <option value="08">Agosto</option>
                          <option value="09">Septiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>
                        </select>
                        <button id="btn_filtrar" class="btn btn-primary">
                          <i class="ti ti-filter"></i> Aplicar
                        </button>
                      </div>
                    </div>
                    <button id="btn_filtrar__mobile" class="btn btn-primary" onclick="showModalFilter()">
                      <i class="ti ti-filter"></i>
                    </button>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="reporte-ventas-initial" class="text-center">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Reporte de ventas</h5>
                <p class="card-text">Selecciona año y mes para visualizar reporte.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="reporte-ventas-empty" class="text-center" style="display: none;">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">No hay datos disponibles</h5>
                <p class="card-text">Por favor, ajusta los filtros para ver los datos.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="reporte-ventas-loading" class="text-center" style="display :none;">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div id="dashboard-loading" style="display: flex; align-items: center; justify-content: center; height: 80vh;">
                  <div class="text-center">
                    <img src="<?= base_url('assets/images/logos/logo-gm-4.png') ?>" height="60" class="mb-4" />
                    <br/>
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                      <span class="visually-hidden">Cargando...</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="reporte-ventas-container" style="display: none;">
        <div id="tabla__xls" style="width:100%;display: none;">
          <table id="tabla__reportes__mx" class="table text-nowrap table-hover borderless">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Orden</th>
                <th>Estatus</th>
                <th>Cliente</th>
                <th>Direccion de envío</th> 
                <th>Envío</th>
                <th>Productos</th>
                <th>Orden <br>descuentos</th>
                <th>Orden <br>subtotal</th>
                <th>Orden <br>envío</th>
                <th>Orden <br>impuestos</th>
                <th>Orden <br>total</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body dash__card">
                <p class="mb-1">Reporte</p>
                <h4 id="mes__filtrado"></h4>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6 mb-6">
            <div class="card mb-2">
              <div class="card-body dash__card">
                <p class="mb-1">Total Venta</p>
                <h4 class="card-title mb-2" id="totalVentaAmount">0</h4>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6 mb-6">
            <div class="card mb-2">
              <div class="card-body dash__card">
                <p class="mb-1">Total Ordenes</p>
                <h4 class="card-title mb-2" id="totalVenta">0</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Ventas por día</h5>
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
                  <h5 class="m-0 me-2">Ordenes por día</h5>
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
                <h5 class="card-title m-0 me-2">Productos vendidos</h5>
              </div>
              <div class="card-body pt-4 mh__400__o_scroll" id="productos-vendidos-container">
                <ul class="p-0 m-0" id="productos-vendidos-ul"></ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Días con más ventas</h5>
              </div>
              <div class="card-body pt-4 mh__400__o_scroll" id="dias-ventas-container">
                <ul class="p-0 m-0" id="dias-ventas-ul"></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>