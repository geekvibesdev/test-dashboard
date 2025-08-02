$(document).ready(function() {
    var qrScanner       = new Html5Qrcode("reader");
    var config          = { fps: 10, qrbox: 250 };
    var canvas          = document.getElementById('signature-pad');
    var signaturePad    = new SignaturePad(canvas);
    var UID_REGEX       = /^gml_/;
    var firma

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
                $('#successGuiaBtnActionSign').attr('guia', guia.guia);
            }else{
                $('#qrResult').hide();
                $('#qrResultFailed').show();
            }
        });
    }

    $('#successGuiaBtnActionSign').on('click', function(){
        $('#modalSignature').modal('show')
    });

    function successGuiaAction(){
        let guia = $('#successGuiaBtnActionSign').attr('guia')
        $('#successGuiaBtnActionSign').attr('disabled', 'disabled')
        $('#saveAndComplete').attr('disabled', 'disabled')

        $.post( base_url + 'gml/operador/scanner/entregar', { [csrfName]: csrfHash, guia, firma }, function(resp){
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
    }
    
    $(document).on('click', '#clearSignatureBtn', function(){
        signaturePad.clear();
    })

    $(document).on('click', '#saveSignatureBtn', function(){
        console.log('ok')
        if (signaturePad.isEmpty()) {
            alert("Por favor, realiza una firma.");
            return;
        }
        $('#modalSignature').modal('hide')
        firma = signaturePad.toDataURL(); // base64 PNG
        successGuiaAction()
    })

});