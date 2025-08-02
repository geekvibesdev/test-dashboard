$(document).ready(function() {

    titulo = ''

    // Instancias de gráficos
    const chartInstances = {};

    // Función genérica para crear gráficos
    function renderChart(canvasId, chartType, chartData, chartTitle, instanceKey, responsive = true) {
        const ctx = document.getElementById(canvasId);
        if (chartInstances[instanceKey]) {
            chartInstances[instanceKey].destroy();
        }
        chartInstances[instanceKey] = new Chart(ctx, {
            type: chartType,
            data: chartData,
            options: {
                responsive,
            }
        });
    }

    // Actualiza las tarjetas del dashboard
    function updateDashboardCards(resp) {
        const estatus = ['totalVenta'];
        estatus.forEach(status => {
            $('#' + status.replace('_', '-')).html(resp.estatus_ordenes[status]);
            $('#' + status.replace('_', '-') + 'Amount').html(setCurrency(resp.total_ordenes[status]));
        });
    }

    // Obtiene y actualiza el dashboard
    function getDashboardData(url) {
        $('#reporte-ventas-initial').hide();
        $('#reporte-ventas-empty').hide();
        $('#reporte-ventas-container').hide();
        $('#descargar_pdf').hide();
        $('#descargar_xls').hide();
        $('#reporte-ventas-loading').show();
        $.get(url, function(resp){
            if(resp.ok){
                if(resp.total_ordenes.total == 0){
                    $('#reporte-ventas-empty').show();
                }else{
                    updateDashboardCards(resp);
                    showMessage('alert-info', 'Información obtenida');
                    $('#reporte-ventas-container').show();
                    $('#descargar_pdf').show();
                    $('#descargar_xls').show();
                }
            }
            $('#reporte-ventas-loading').hide();
        });
    }

    // Gráfico de ventas por día
    function getGraphicsVentaData(url, title){
        $.get(url, function(resp){
            if(resp.ok){
                renderChart('totalVentasByDay', 'line', resp.grafica_ventas_por_dia, title, 'ventaDay');
            }
        });
    }

    // Gráfico de ordenes por día
    function getGraphicsData(url, title){
        $.get(url, function(resp){
            if(resp.ok){
                renderChart('totalByDay', 'line', resp.grafica_ordenes_por_dia, title, 'day');
            }
        });
    }
    
    // Productos vendidos
    function getProductSales(url){
        $.get(url, function(resp){
            if(resp.ok){
                const productosOrdenados = resp.productos.sort((a, b) => b.cantidad - a.cantidad);
                let html = '';
                productosOrdenados.forEach(prod => {
                    html += `
                        <li class="d-flex align-items-center mb-2">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">SKU ${prod.sku}</small>
                                    <h6 class="fw-normal mb-0"><strong>${prod.producto}</strong></h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <span class="text-body-secondary"><strong>${prod.cantidad}</strong></span>
                                </div>
                            </div>
                        </li>
                    `;
                });
                $('#productos-vendidos-ul').html(html);
            }
        });
    }

    function getSalesByDay(url){
          $.get(url, function(resp){
            if(resp.ok){
                const diasOrdenados = resp.ventas_por_dia.sort((a, b) => b.total - a.total);
                let html = '';
                diasOrdenados.forEach(dia => {
                    // Convertir la fecha a formato "Martes 1 de Mayo"
                    const [anio, mes, diaNum] = dia.fecha.split('-');
                    const fechaObj = new Date(anio, mes - 1, diaNum); // mes - 1 
                    const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                    const diaSemana = diasSemana[fechaObj.getDay()];
                    const diaNumero = fechaObj.getDate();
                    const mesNombre = meses[fechaObj.getMonth()];
                    const fechaFormateada = `${diaSemana} ${diaNumero} de ${mesNombre}`;
                    html += `
                        <li class="d-flex align-items-center mb-2">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="d-block">Ordenes ${dia.cantidad}</small>
                                    <h6 class="fw-normal mb-0"><strong>${fechaFormateada}</strong></h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-2">
                                    <span class="text-body-secondary"><strong>${setCurrency(dia.total)}</strong></span>
                                </div>
                            </div>
                        </li>
                    `;
                });
                $('#dias-ventas-ul').html(html);
            }
        });
    }

    // Eventos de filtros
    $(document).on('click', '#btn_filtrar', function() {
        let anio = $('#anio').val()
        let mes  = $('#mes').val()

        if(anio == '' || mes == ''){
            $('#filter__container').addClass('error')
            showMessage('alert-danger', 'Seleccione año y mes')
            return
        }

        $('#filter__container').removeClass('error')

        // Array de nombres de meses en español
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        // Convertir el número de mes a nombre de mes
        const mesNombre = meses[parseInt(mes, 10) - 1];
        titulo = `${mesNombre} ${anio}`;
        $('#mes__filtrado').html(titulo);

        getSalesByDay(base_url + `/reportes/get-ventas-por-dia?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`);
        getProductSales(base_url + `/reportes/get-productos-vendidos?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`);
        getDashboardData(base_url + `/dashboard/data?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`);
        getGraphicsData(base_url + `/dashboard/data/graphics?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`, titulo);
        getGraphicsVentaData(base_url + `/dashboard/data/graphics-venta?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`, titulo);
        tablePedidos.ajax.url(base_url + `ordenes/get-ordenes-filtro?temporalidad=mes_filtrado&anio=${anio}&mes=${mes}`).load();
        $('#modalFilter').modal('hide');
    });

    // Descargar reporte PDF
    $('#descargar_pdf').on('click', function() {
        $('#productos-vendidos-container').removeClass('mh__400__o_scroll')
        $('#dias-ventas-container').removeClass('mh__400__o_scroll')
        // Selecciona el contenedor principal
        const reporte = document.getElementById('reporte-ventas-container');

        html2canvas(reporte, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jspdf.jsPDF({
                orientation: 'portrait',
                unit: 'pt',
                format: 'a4'
            });

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            // Tamaño de la imagen en px
            const imgWidth = canvas.width;
            const imgHeight = canvas.height;

            // Calcula la altura de la imagen en el PDF
            const ratio = imgWidth / pdfWidth;
            const imgHeightInPdf = imgHeight / ratio;

            let position = 0;

            // Si la imagen es más alta que una página, la divide en varias páginas
            while (position < imgHeightInPdf) {
                pdf.addImage(
                    imgData,
                    'PNG',
                    0,
                    -position,
                    pdfWidth,
                    imgHeightInPdf
                );
                position += pdfHeight;
                if (position < imgHeightInPdf) {
                    pdf.addPage();
                }
            }
            pdf.save('Reporte PDF - ' + titulo + '.pdf');
            $('#productos-vendidos-container').addClass('mh__400__o_scroll')
            $('#dias-ventas-container').addClass('mh__400__o_scroll')
        });
    });

    // Reporte XLS
    var tablePedidos = $('#tabla__reportes__mx').DataTable({
        "ajax": {
            url: base_url + "ordenes/get-ordenes",
            type: 'GET',
            dataSrc: function(resp) {
                return resp.ordenes.map(function(orden) {
                    return {
                        fecha: new Date(orden.fecha_orden).toLocaleString('es-ES', { dateStyle: 'short', timeStyle: 'short' }),
                        orden: `<a href="${base_url}mx/ordenes/${orden.orden}">${orden.orden}</a>`,
                        estatus: orden.estatus_orden,
                        cliente: orden.envio_direccion.first_name + ' ' + orden.envio_direccion.last_name,
                        envio_direccion: orden.direccion_envio_completa,
                        envio: orden.envio_tipo,
                        productos: orden.productos.map(function(producto) {
                            return `${producto.name} (SKU: ${producto.sku}) x ${producto.quantity}\n` +
                                   `${producto.tiene_descuento ? `Desc: ${producto.descuento_aplicado}\n` : ''}`;
                        }).join('-'),
                        descuentos: setCurrency(orden.orden_descuentos),
                        subtotal: setCurrency(orden.orden_subtotal),
                        costo_envio: setCurrency(orden.orden_envio),
                        costo_impuestos: setCurrency(orden.orden_impuestos),
                        costo_orden: setCurrency(orden.orden_total),                       
                    };
                });
            }
        },
        order: [[1, 'desc']],
        columns: [
            { data: 'fecha' },                                  
            { data: 'orden' },                                  
            { data: 'estatus' },                                
            { data: 'cliente' },                                
            { data: 'envio_direccion' },                    
            { data: 'envio' },                                  
            { data: 'productos' },                      
            { data: 'descuentos' },                                    
            { data: 'subtotal' },                               
            { data: 'costo_envio' },                           
            { data: 'costo_impuestos' },                       
            { data: 'costo_orden' },                           
        ],
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
        createdRow: function(row, data, dataIndex) {
            if (data.costos_prod_pendientes == 'Si') {
                $(row).addClass('highlight-row');
            }
        },
    });
    $('#descargar_xls').on('click', function() {
        tablePedidos.button('.buttons-excel').trigger();
    });
});