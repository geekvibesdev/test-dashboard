<div class="container-fluid mobile__fw">
    <div class="card mb-3 sticky-header">
        <div class="card-body mobile__pb0">       
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Gastos paqueteria <span id="filter__result" class="text-success"></span></h5>
                <div class="d-flex align-items-center filter__container">
                    <div class="input-group">
                        <label for="fecha_inicio" class="form-label d_d-none">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio" max="<?php echo date('Y-m-d'); ?>">
                        <label for="fecha_inicio" class="form-label d_d-none">Fecha fin</label>
                        <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin" max="<?php echo date('Y-m-d'); ?>">
                        <button id="btn_filtrar" class="btn btn-primary">
                          <i class="ti ti-filter"></i>Filtrar
                        </button>
                    </div>
                </div>
                <button id="btn_filtrar__mobile" class="btn btn-primary" onclick="showModalFilter()">
                    <i class="ti ti-filter"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-0 h-100">
                <div class="card-body mobile__pt10">
                    <div class="table-responsive">
                        <table id="tabla__ordenes" class="table text-nowrap table-hover borderless" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Paqueteria</th>
                                    <th>Promedio costo</th>
                                    <th>Ordenes</th>
                                    <th>Gastos</th>
                                </tr>
                            </thead>
                             <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th style="text-align:right">Totales:</th>
                                    <th id="total_ordenes"></th>
                                    <th id="total_gastos"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-2 mt-md-0">
            <div class="card h-100">
                <div class="card-body">
                    <div>
                        <canvas id="totalByPaqueteria"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>