<div class="container-fluid mw-1600">
    <div class="card mb-3 sticky-header">
        <div class="card-body mobile__pb0">       
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Ordenes <span id="filter__result" class="text-success"></span></h5>
                <div class="d-flex align-items-center filter__container">
                    <div>
                        <label for="fecha_inicio" class="form-label d_d-none">Estatus</label>
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
                        <button id="btn_refresh" class="btn btn-primary">
                          <i class="ti ti-refresh"></i>
                        </button>
                    </div>
                </div>
                <button id="btn_filtrar__mobile" class="btn btn-primary" onclick="showModalFilter()">
                    <i class="ti ti-filter"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card mb-0">
        <div class="card-body mobile__pt10">
            <div class="table-responsive">
                <div id="botonera"></div>
                    <table id="tabla__reportes" class="table text-nowrap table-hover borderless" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Orden</th>
                                <th>Estatus</th>
                                <th>Cliente</th>
                                <th>Direccion de envío</th> 
                                <th>Envío</th>
                                <th>Promoción de envío</th>
                                <th>Promoción de envío titulo</th>
                                <th>Paquetería nombre</th>
                                <th>Paquetería guía</th>
                                <th>Requiere factura</th> 
                                <th>Productos</th>
                                <th>Impuesto</th>
                                <th>Descuentos en productos aplicados</th>
                                <th>Orden <br>descuentos</th>
                                <th>Orden <br>subtotal</th>
                                <th>Orden <br>envío</th>
                                <th>Orden <br>impuestos</th>
                                <th>Orden <br>total</th>
                                <th>Paquetería <br>costo</th>
                                <th>Paquetería utilidad</th>
                                <th>Productos con costos pendientes</th>
                                <th>Costo de compra <br>de productos <br>sin impuestos</th>
                                <th>Utilidad <br>productos <br>sin impuestos</th>
                                <th>Utilidad productos porcentaje</th>
                                <th>50% descuentos productos</th>
                                <th>Utilidad orden <br>sin impuestos <br>(Ut. productos <br>- Costos mensajeria<br> + Orden envío )</th>
                                <th>Utilidad orden <br>sin impuestos <br>mas 50% de <br>promociones</th>
                                <th>Utilidad final <br>porcentaje <br>(sin promociones) </th>
                                <th>Utilidad final <br>porcentaje <br>(mas 50% de <br>promociones) </th>
                                <th>Pasarela</th>
                                <th>Transacción</th>
                                <th>Estado</th>
                                <th>Municipio</th>
                                <th>CP</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-2">
                <a class="f-12 "href="<?= base_url('mx/informes/ordenes') ?>">Ver como MX</a>
            </div>
        </div>
    </div>
</div>