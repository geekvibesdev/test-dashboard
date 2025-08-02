<div class="container-fluid mw-1600">
    <div class="card mb-3 sticky-header">
        <div class="card-body">       
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Reporte <span id="filter__result" class="text-success"></span></h5>
                <div class="d-flex align-items-center filter__container">
                    <div>
                        <select class="form-select" name="estatus" id="estatus">
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
    <div class="card mb-0">
        <div class="card-body">
            <div class="table-responsive">
                <div id="botonera"></div>
                    <table id="tabla__reportes__mx" class="table text-nowrap table-hover borderless" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Orden</th>
                                <th>Estatus</th>
                                <th>Cliente</th>
                                <th>Direccion de envío</th> 
                                <th>Envío</th>
                                <th>Requiere factura</th> 
                                <th>Productos</th>
                                <th>Orden <br>descuentos</th>
                                <th>Orden <br>subtotal</th>
                                <th>Orden <br>envío</th>
                                <th>Orden <br>impuestos</th>
                                <th>Orden <br>total</th>
                                <th>Pasarela</th>
                                <th>Transacción</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>