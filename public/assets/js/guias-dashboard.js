$(document).ready(function() {

    function getDashboardData() {
        let url = base_url + `/gml/data`;
        $.get(url, function(resp){
            if(resp.ok){
                updateDashboardCards(resp);
                showMessage('alert-info', 'Información obtenida');
            }
        });
    }

    function updateDashboardCards(resp) {
        const estatus = [ 'total', 'cancelada', 'creada', 'en_transito', 'entregada', 'recolectada' ];
        estatus.forEach(status => {
            $('#' + status.replace('_', '-')).html(resp.estatus_envios[status]);
        });
    }

    getDashboardData();
});