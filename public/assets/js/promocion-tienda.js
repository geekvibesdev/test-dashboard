$(document).ready(function() {
    new DataTable('.dt_table', {
        responsive: true,
        order: [[0, 'desc']],
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
    });
});