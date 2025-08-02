let graficoPaqueteria = null;

$(document).ready(function () {
    function cargarGrafico(fechaInicio = '', fechaFin = '') {
        const url = base_url + "reportes/get-gastos-paqueteria" + 
            (fechaInicio && fechaFin ? `?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}` : '');

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (!data.ok) return;
                const ctx = document.getElementById('totalByPaqueteria').getContext('2d');
                // Si el gráfico ya existe, lo destruimos
                if (graficoPaqueteria) {
                    graficoPaqueteria.destroy();
                }
                graficoPaqueteria = new Chart(ctx, {
                    type: 'pie',
                    data: data.paqueterias_graphic,
                    options: {
                        responsive: true,
                    }
                });
            })
            .catch(error => console.error('Error al cargar el gráfico:', error));
    }

    // Ejecutar gráfico al cargar página
    cargarGrafico();

    $(document).on('click', '#btn_filtrar', function() {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();
        var texto = "";

        if (fechaInicio && fechaFin) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                return;
            }
            texto += " del " + fechaInicio + " al " + fechaFin;
        }

        $('#filter__result').html(texto);

        const urlTabla = base_url + "reportes/get-gastos-paqueteria?fecha_inicio=" + fechaInicio + "&fecha_fin=" + fechaFin;
        tablePedidos.ajax.url(urlTabla).load();

        // actualizamos el gráfico
        cargarGrafico(fechaInicio, fechaFin);
        $('#modalFilter').modal('hide');
    });

    var tablePedidos = $('#tabla__ordenes').DataTable({
        "ajax": {
            url: base_url + "reportes/get-gastos-paqueteria",
            type: 'GET',
            dataSrc: function (resp) {
                if (resp.ok) showMessage('alert-info', 'Información obtenida');
                return resp.paqueterias.map(function (paqueteria) {
                    return {
                        id: paqueteria.id,
                        paqueteria: paqueteria.paqueteria,
                        promedio: setCurrency(paqueteria.promedio),
                        ordenes: paqueteria.ordenes,
                        gastos: setCurrency(paqueteria.gastos),
                    };
                });
            }
        },
        pageLength: 50,
        order: [[3, 'desc']],
        columns: [
            { data: 'id' },
            { data: 'paqueteria' },
            { data: 'promedio' },
            { data: 'ordenes' },
            { data: 'gastos' },
        ],
        layout: {
            topStart: {
                buttons: [
                    'excel', 'csv'
                ],
            },
        },
        responsive: true,
        language: { url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json' },
        error: function (xhr, error, code) {
            console.error("Error en DataTables:", error, code, xhr.responseText);
        },
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Helper para limpiar y convertir a número
            let parseNumber = function (i) {
                return typeof i === 'string'
                    ? parseFloat(i.replace(/[\$,]/g, '')) || 0
                    : typeof i === 'number'
                    ? i
                    : 0;
            };

            // Total de órdenes
            let totalOrdenes = api
                .column(3, { page: 'current' }) // índice columna "ordenes"
                .data()
                .reduce((a, b) => parseNumber(a) + parseNumber(b), 0);

            // Total de gastos
            let totalGastos = api
                .column(4, { page: 'current' }) // índice columna "gastos"
                .data()
                .reduce((a, b) => parseNumber(a) + parseNumber(b), 0);

            // Mostrar en el footer
            $(api.column(3).footer()).html(totalOrdenes);
            $(api.column(4).footer()).html(setCurrency(totalGastos));
        },
        paging: false,
        info: false,     
    });
});
