$(document).ready(function() {
    $('#dashboard-loading').show();
    $('#dashboard-content').hide();
    // Instancias de gráficos
    const chartInstances = {};

    // Actualiza las tarjetas del dashboard
    function updateDashboardCards(resp) {
        const data = {
            labels : Object.keys(resp.estados_conteo),
            datasets: [{
                label: 'Cantidad por Estado',
                data: Object.values(resp.estados_conteo),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }

        renderChart('totalByEstate', 'bar', data, '', '', true);

        const estatus = [
            'total', 'completed', 'processing', 'failed', 'on_hold', 'refunded', 'cancelled', 'pending', 'totalVenta'
        ];
        estatus.forEach(status => {
            $('#' + status.replace('_', '-')).html(resp.estatus_ordenes[status]);
            $('#' + status.replace('_', '-') + 'Amount').html(setCurrency(resp.total_ordenes[status]));
        });

        $('#paypalAmount').html(setCurrency(resp.pasarelas_monto.ppcp_gateway));
        $('#openpayAmount').html(setCurrency(resp.pasarelas_monto.openpay_cards));
        $('#orden_descuentos').html(setCurrency(resp.costos_y_utilidades.orden_descuentos));
        $('#paqueteria_costos').html(setCurrency(resp.costos_y_utilidades.paqueteria_costos));
        $('#nota_de_credito').html(setCurrency(resp.costos_y_utilidades.nota_de_credito));
        $('#ut_orden_mas_50_prom').html(setCurrency(resp.costos_y_utilidades.ut_orden_mas_50_prom));
        $('#ut_orden_sin_50_prom').html(setCurrency(resp.costos_y_utilidades.ut_orden_sin_50_prom));
        $('#ut_final_orden_sin_50_prom_porcentaje').html(resp.costos_y_utilidades.ut_final_orden_sin_50_prom_porcentaje);
        $('#ut_final_orden_mas_50_prom_porcentaje').html(resp.costos_y_utilidades.ut_final_orden_mas_50_prom_porcentaje);
    }

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

    // Obtiene y actualiza el dashboard
    function getDashboardData(url = '') {
        let urlFinal = base_url + `/dashboard/data`;
        if(url) urlFinal += url;
        return $.get(urlFinal, function(resp){
            if(resp.ok){
                updateDashboardCards(resp);
                showMessage('alert-info', 'Información obtenida');
            }
        });
    }

    // Gráfico por día
    function getGraphicsData(url, title){
        return $.get(url, function(resp){
            if(resp.ok){
                $('#filter__result_graphics').html(title);
                renderChart('totalByDay', 'line', resp.grafica_ordenes_por_dia, title, 'day');
            }
        });
    }
    
    // Gráfico de ventas por día
    function getGraphicsVentaData(url, title){
        return $.get(url, function(resp){
            if(resp.ok){
                $('#filter__result_graphics_venta').html(title);
                renderChart('totalVentasByDay', 'line', resp.grafica_ventas_por_dia, title, 'ventaDay');
            }
        });
    }

    // Gráfico por mes
    function getGraphicsDataMonth(url, title){
        return $.get(url, function(resp){
            if(resp.ok){
                $('#filter__result_graphics__month').html(title);
                renderChart('totalByMonth', 'bar', resp.grafica_ordenes_por_mes, title, 'month');
            }
        });
    }

    // Eventos de filtros
    $(document).on('click', '#btn_filtrar', function() {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin    = $('#fecha_fin').val();
        var estatus     = $('#estatus').val();
        var texto       = estatus ? "Mostrando " + estatus : "";
        if (fechaInicio && fechaFin) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                return;
            }
            texto += " del " + fechaInicio + " al " + fechaFin;
        }
        $('#filter__result').html(texto);
        getDashboardData("?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin + "&estatus=" + estatus);
        $('#modalFilter').modal('hide');
    });

    $(document).on('click', '#btn_limpiar', function() {
        $('#fecha_inicio').val('');
        $('#fecha_fin').val('');
        $('#estatus').val('').trigger('change');
        $('#filter__result').html('');
        getDashboardData();
        $('#modalFilter').modal('hide');
    });

    $('#btn_refresh').on('click', function() {
        $('#btn_filtrar').click();
    });

    // Manejador para los filtros de gráficos
    $(document).on('click', '.graph-filter', function(e) {
        e.preventDefault();
        const type = $(this).data('type');
        const url = base_url + $(this).data('url');
        const title = $(this).data('title');
        if (type === 'month') {
            getGraphicsDataMonth(url, title);
        } else if (type === 'day') {
            getGraphicsData(url, title);
        } else if (type === 'ventaDay') {
            getGraphicsVentaData(url, title);
        }
    });

    $.when(
        getDashboardData(),
        getGraphicsData(base_url + "/dashboard/data/graphics?temporalidad=ultimos_7_dias", 'Últimos 7 días'),
        getGraphicsDataMonth(base_url + "/dashboard/data/graphics-month?anio=2025", '2025'),
        getGraphicsVentaData(base_url + "/dashboard/data/graphics-venta?temporalidad=ultimos_7_dias", 'Últimos 7 días'),
    ).done(function() {
        $('#dashboard-loading').hide();
        $('#dashboard-content').show();
    }); 
});