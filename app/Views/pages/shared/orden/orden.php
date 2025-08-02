<div class="container-fluid mw-1600">
    <div class="card mb-3 sticky-header">
        <div class="card-body mobile__pb0">       
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Ordenes <span id="filter__result" class="text-success">Mostrando processing</span></h5>
                <div class="d-flex align-items-center filter__container">
                    <div>
                        <select class="form-select" name="estatus" id="estatus">
                            <option value="processing">En proceso</option>
                            <option value="">Todos</option>
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
    <div class="card mb-0">
        <div class="card-body mobile__pt10">
            <div class="table-responsive">
                <div id="botonera"></div>
                    <table id="tabla__ordenes" class="table text-nowrap table-hover borderless" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Orden</th>
                                <th>Estatus</th>
                                <th>Cliente</th>
                                <th>Envío</th>
                                <th>Edo.</th>
                                <th>C.P.</th>
                                <th>Personalizado</th>
                                <th>Paqueteria</th>
                                <th>Guia</th>
                                <th>Costo guia</th>
                                <th>Total orden</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>