<script>
    $('#checkAlert').hide();

    function createCerfPage() {
        checkVpnService();
        listCertificates();
    }

    function checkVpnService() {
        request(API('openvpn_check'), new FormData(), function(response) {
            let output = JSON.parse(response).message;
            $('#checkAlert').hide();

        }, function(response) {
            let error = JSON.parse(response).message;
            $('#checkAlert').show();
        })
    }

    function removeVpnService() {
        startRmLog()
        request(API('openvpn_remove'), new FormData(), function(response) {
            let output = JSON.parse(response).message;
            $('#checkAlert').hide();

        }, function(response) {
            let error = JSON.parse(response).message;
            $('#checkAlert').show();
        })
    }

    function startLog() {
        document.getElementById('logger').innerHTML = "";
        let start = 0;
        let repater = setInterval(function() {
            request(API('openvpn_logger'), new FormData(), function(response) {
                let output = JSON.parse(response).message;
                let splittedData = output.split('\n')
                for (let i = start; i < splittedData.length; i++) {
                    document.getElementById('logger').innerHTML += splittedData[i] + '<br>';
                }
                start = splittedData.length - 1;
                var objDiv = document.getElementById("logger");
                objDiv.scrollTop = objDiv.scrollHeight;
                if (output.includes('Finished!')) {
                    showSwal("Yükleme başarıyla tamamlandı.", "info", 2500);
                    clearInterval(repater);
                }
            }, function(response) {
                let error = JSON.parse(response).message;
            })
        }, 1000);
    }

    function startRmLog() {
        document.getElementById('logger').innerHTML = "";
        let start = 0;
        let repater = setInterval(function() {
            request(API('openvpn_rmlogger'), new FormData(), function(response) {
                let output = JSON.parse(response).message;
                let splittedData = output.split('\n')
                for (let i = start; i < splittedData.length; i++) {
                    document.getElementById('logger').innerHTML += splittedData[i] + '<br>';
                }
                start = splittedData.length - 1;
                var objDiv = document.getElementById("logger");
                objDiv.scrollTop = objDiv.scrollHeight;
                if (output.includes('OpenVPN removed!')) {
                    showSwal("Eklenti başarıyla kaldırıldı.", "info", 2500);
                    clearInterval(repater);
                }
            }, function(response) {
                let error = JSON.parse(response).message;
            })
        }, 1000);
    }

    function installVpnService() {
        startLog();
        request(API('openvpn_install'), new FormData(), function(response) {
            let output = JSON.parse(response).message;
            $('#checkAlert').hide();
        }, function(response) {
            let error = JSON.parse(response).message;
            $('#checkAlert').show();
        })
    }

    function createNewCertificate() {
        let data = new FormData();
        data.append('cerfName', document.getElementById('cerfName').value);
        request(API('openvpn_create'), data, function(response) {
            let output = JSON.parse(response).message;
            document.getElementById('cerfName').value = ""
        }, function(response) {
            let error = JSON.parse(response).message;
            document.getElementById('cerfName').value = ""

        })
    }

    function listCertificates() {
        document.getElementById('tablos').innerHTML = ""

        request(API('openvpn_cerf_list'), new FormData(), function(response) {
            let output = JSON.parse(response).message;
            let splittedData = output.split("\r\n");
            document.getElementById('totalCerf').innerHTML = splittedData.length
            for (let i = 0; i < splittedData.length; i++) {
                document.getElementById('tablos').innerHTML +=
                    "<div style='padding:12px;margin:8px;background-color:#f1f3ff; color: #0A1551; display:flex; justify-content: space-between; border-radius:8px; align-items:center;'><span><strong>" +
                    splittedData[i] +
                    "</strong></span><a style='padding:6px 12px; background-color:rgb(255, 224, 167); color: rgb(214, 139, 0); font-weight:bold;border-radius: 8px; border: 1px solid orange;' id='" +
                    splittedData[i] + "' download='" + splittedData[i] + "' >İndir</a></div>"
                let data = new FormData();
                data.append('cerfName', splittedData[i]);
                request(API('openvpn_cerf_get'), data, function(response) {
                    let output = JSON.parse(response).message;
                    var element = document.getElementById(splittedData[i]);
                    element.setAttribute('href',
                        'data:text/plain, ' +
                        encodeURIComponent(output))
                }, function(response) {
                    let error = JSON.parse(response).message;

                })
            }

        }, function(response) {
            let error = JSON.parse(response).message;

        })
    }
</script>