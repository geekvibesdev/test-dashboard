$(document).ready(function() {
    const qrScanner = new Html5Qrcode("reader");
    const config    = { fps: 10, qrbox: 250 };

    const UID_REGEX = /^gml_/;

    qrScanner.start({ facingMode: "environment" }, config, (decodedText, decodedResult) => {
        if (UID_REGEX.test(decodedText)) {
            getGuiaByUid(decodedText);
            qrScanner.stop()
        } else {
            document.getElementById("result").innerText = "QR inválido";
        }
    },(errorMessage) => { }
    ).catch(err => {
        console.error("Error iniciando escáner:", err);
    });

    function getGuiaByUid(uid){
        $.get(base_url + 'gml/guias/uid/' + uid , function(resp){
            if(resp.ok){
                let { guia } = resp;
                $('#qrResult').hide();
                $('#qrResultSuccess').show();
                $('#successGuia').html(guia.guia);
                $('#successGuiaBtnDetail').attr('href', base_url + 'gml/guias/guia/' + guia.guia);
                $('#successGuiaBtnAction').attr('guia', guia.guia);
            }else{
                $('#qrResult').hide();
                $('#qrResultFailed').show();
            }
        });
    }
    
    $('#successGuiaBtnAction').on('click', function(){
        let guia = $(this).attr('guia')
        $(this).attr('disabled', 'disabled')
        $.post( base_url + 'gml/operador/scanner/trayecto', { [csrfName]: csrfHash, guia, }, function(resp){
            if(resp.ok){
                $('#qrResultSuccess').hide();
                $('#qrResultFailedAction').hide();
                $('#qrResultSuccessAction').show();
            }else{
                $('#qrResultSuccess').hide();
                $('#qrResultSuccessAction').hide();
                $('#qrResultFailedActionError').html(resp.message);
                $('#qrResultFailedAction').show();
            }
        });
    });
});