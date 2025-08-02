<div class="container-fluid mobile__fw">
    <div class="card mb-3 sticky-header">
        <div class="card-body">       
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Guias <span id="filter__result" class="text-success">Mostrando Guia creada</span></h5>
                <div class="d-flex align-items-center filter__container">
                    <div>
                        <select class="form-select" name="estatus" id="estatus">
                            <option value="creada">Guia creada</option>
                            <option value="recolectada">Reclolectado</option>
                            <option value="en_transito">En transito</option>
                            <option value="entregada">Entregado</option>
                            <option value="cancelada">Cancelado</option>
                            <option value="">Todos</option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-0">
        <div class="card-body">
            <div class="table-responsive">
                <div id="botonera"></div>
                    <table id="tabla__ordenes" class="table text-nowrap table-hover borderless" style="width:100%">
                        <thead class="text-dark fs-4">
                          <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Guia</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Estatus</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Fecha creada</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Remitente</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Destinatario</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tipo</h6>
                            </th>
                            <th class="border-bottom-0 text-center">
                                <h6 class="fw-semibold mb-0">Orden</h6>
                            </th>
                          </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>