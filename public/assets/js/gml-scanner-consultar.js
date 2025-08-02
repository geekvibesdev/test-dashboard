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
                let url = base_url + 'gml/guias/guia/' + guia.guia
                window.location = url
            }else{
                $('#qrResult').hide();
                $('#qrResultFailed').show();
            }
        });
    }
});