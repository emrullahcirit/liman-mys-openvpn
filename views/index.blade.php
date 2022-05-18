
<h2 class="text-bold">{{ __("OpenVPN") }}</h2>
<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link active" href="#installation" data-toggle="tab">
            <i class="fas fa-server"></i> {{ __("Kurulum") }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" onclick="createCerfPage()" href="#createCertificate" data-toggle="tab">
            <i class="fas fa-info"></i> {{ __("Yeni Sertifika") }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" onclick="checkVpnService()" href="#listClients" data-toggle="tab">
            <i class="fa-solid fa-users"></i> {{ __("Aktif Kullanıcılar") }}
        </a>
    </li>
</ul>

<div class="tab-content">
    <div id="installation" class="tab-pane active">
        <h2><strong>OpenVPN Kurulum</strong></h2>
        <p>VPN sunucunu bu sayfa yardımıyla <strong>tek tuşla</strong> ve <strong>hızlıca</strong> yükleyip, kaldırabilirsin. </p>
        
        <button type="button" class="btn btn-primary" onclick="installVpnService()">OpenVPN'i Yükle</button>
        <button type="button" class="btn btn-danger" onclick="removeVpnService()">OpenVPN'i Kaldır.</button>
        <hr>
        <p>Log:</p>
        <div id="logger" style="background: black; color: lime; padding: 10px; max-height:300px; overflow-y: scroll;">

        </div>
    </div>

    <div id="createCertificate" class="tab-pane">
        <h2><strong>Yeni Sertifika Oluştur</strong></h2>
        <p>VPN Sunucusunu kullanmak isteyen kişiler için bu sayfadan yeni sertifikalar oluşturabilir ve bu sertifikaları indirebilirsin.</p>
        <p><strong>NOT: Bir sertifikayı yalnızca bir kullanıcı kullanabilir.</strong></p>
        <div class="input-group mb-3">
            <input type="text" id="cerfName" class="form-control" placeholder="Yeni sertifika için bir kullanıcı adı" aria-label="A name for new certificate" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" onclick="createNewCertificate()" type="button" id="button-addon2">Oluştur</button>
        </div>
        <hr>
            <div style="width:200px;text-align:center;background-color:#C1EB7A; color: #0D953B; padding: 10px; margin-bottom: 10px; border-radius: 8px;">Toplam sertifika sayısı: <span><strong id="totalCerf"></strong></span></div>

        <div style="display: flex; align-items:center; justify-content: space-between">
            <p><strong>Sertifikalar: </strong></p>
            
            <button type="button" class="btn btn-primary" onclick="listCertificates()">Yenile</button>
        </div>
        <div id="tablos" style="display: flex; flex-direction: column; ">
        </div>
    </div>

    <div id="listClients" class="tab-pane">
        <h2><strong>Aktif Kullanıcılar:</strong></h2>
        <p>VPN Sunucunuza bağlı aktif kullancılarınız IP'lerini ve son erişim zamanını aşağıdan görüntüleyebilirsiniz.</p>
        <div style="width:180px;background-color:#C1EB7A; color: #0D953B; padding: 10px; margin-bottom: 10px; border-radius: 8px;">Toplam aktif kullanıcı: <span><strong>3</strong></span></div>
        <div id="tabloss" style="display: flex; flex-direction: column; ">
            <div style="display: flex;justify-content: space-between; align-items:center; padding: 10px; background-color: #f1f3ff; color: #343A67; border-radius: 8px; "><span>Client IP: </span><span>Aktif Sertifika</span><span>Son Erişme Zamanı</span></div>
            <div style="display: flex;justify-content: space-between; align-items:center; padding: 10px; background-color: #f1f3ff; color: #343A67; border-radius: 8px; margin-top:10px; "><span><strong>192.168.34x.xxx</strong></span><span style="margin-left: -10%; color: #63C1FF; font-weight:bold;">Trio.ovpn</span><span>17.05.2022 - 12:03</span></div>
            <div style="display: flex;justify-content: space-between; align-items:center; padding: 10px; background-color: #f1f3ff; color: #343A67; border-radius: 8px; margin-top:10px;"><span><strong>192.168.35x.xxx</strong></span><span style="margin-left: -10%; color: #63C1FF; font-weight:bold;">Altay.ovpn</span><span>17.05.2022 - 14:06</span></div>
            <div style="display: flex;justify-content: space-between; align-items:center; padding: 10px; background-color: #f1f3ff; color: #343A67; border-radius: 8px; margin-top:10px;"><span><strong>192.168.36x.xxx</strong></span><span style="margin-left: -10%; color: #63C1FF; font-weight:bold;">Emrullahh.ovpn</span><span>17.05.2022 - 19:32</span></div>
            
        </div>
    </div>
    
    <div id="checkAlert" class="alert alert-danger hidden mt-4">Öncelikle kurulum sayfasından eklentiyi kurmalısın!</div>

</div>


<script>
        
    
        $('#checkAlert').hide();
        
        function createCerfPage(){
            checkVpnService();
            listCertificates();
        }

        function checkVpnService(){
        request(API('openvpn_check'), new FormData(), function (response) {
            let output = JSON.parse(response).message;
            $('#checkAlert').hide();

        }, function(response){
            let error = JSON.parse(response).message;
            $('#checkAlert').show();
        })
        }
        
        function removeVpnService(){
            startRmLog()
            request(API('openvpn_remove'), new FormData(), function (response) {
                let output = JSON.parse(response).message;
                $('#checkAlert').hide();

            }, function(response){
                let error = JSON.parse(response).message;
                $('#checkAlert').show();
            })
        }
        
        function startLog(){
            document.getElementById('logger').innerHTML = "";
            let start = 0;
            let repater = setInterval(function(){
                request(API('openvpn_logger'), new FormData(), function (response) {
                    let output = JSON.parse(response).message;
                    let splittedData = output.split('\n')
                    for(let i = start; i < splittedData.length; i++){
                        document.getElementById('logger').innerHTML += splittedData[i] + '<br>';
                    }
                    start = splittedData.length -1;
                    var objDiv = document.getElementById("logger");
                    objDiv.scrollTop = objDiv.scrollHeight;
                    if(output.includes('Finished!')){
                        showSwal("Yükleme başarıyla tamamlandı.", "info", 2500);
                        clearInterval(repater);
                    } 
                }, function(response){
                    let error = JSON.parse(response).message;
                })
            }, 1000);
        }
        function startRmLog(){
            document.getElementById('logger').innerHTML = "";
            let start = 0;
            let repater = setInterval(function(){
                request(API('openvpn_rmlogger'), new FormData(), function (response) {
                    let output = JSON.parse(response).message;
                    let splittedData = output.split('\n')
                    for(let i = start; i < splittedData.length; i++){
                        document.getElementById('logger').innerHTML += splittedData[i] + '<br>';
                    }
                    start = splittedData.length -1;
                    var objDiv = document.getElementById("logger");
                    objDiv.scrollTop = objDiv.scrollHeight;
                    if(output.includes('OpenVPN removed!')){
                        showSwal("Eklenti başarıyla kaldırıldı.", "info", 2500);
                        clearInterval(repater);
                    }
                }, function(response){
                    let error = JSON.parse(response).message;
                })
            }, 1000);
        }

        function installVpnService(){
            startLog();
            request(API('openvpn_install'), new FormData(), function (response) {
                let output = JSON.parse(response).message;
                $('#checkAlert').hide();
            }, function(response){
                let error = JSON.parse(response).message;
                $('#checkAlert').show();
            })
        }
        
        function createNewCertificate(){
            let data = new FormData();
            data.append('cerfName', document.getElementById('cerfName').value);
            request(API('openvpn_create'), data, function (response) {
            let output = JSON.parse(response).message;
            document.getElementById('cerfName').value = ""
        }, function(response){
            let error = JSON.parse(response).message;
            document.getElementById('cerfName').value = ""

        })
        }
        function listCertificates(){
                document.getElementById('tablos').innerHTML = "" 

            request(API('openvpn_cerf_list'), new FormData(), function (response) {
            let output = JSON.parse(response).message;
            let splittedData = output.split("\r\n");
            document.getElementById('totalCerf').innerHTML = splittedData.length
            for(let i = 0; i < splittedData.length; i++){
                document.getElementById('tablos').innerHTML += "<div style='padding:12px;margin:8px;background-color:#f1f3ff; color: #0A1551; display:flex; justify-content: space-between; border-radius:8px; align-items:center;'><span><strong>"+splittedData[i]+"</strong></span><a style='padding:6px 12px; background-color:rgb(255, 224, 167); color: rgb(214, 139, 0); font-weight:bold;border-radius: 8px; border: 1px solid orange;' id='"+splittedData[i]+"' download='"+splittedData[i]+"' >İndir</a></div>"
                let data = new FormData();
                data.append('cerfName', splittedData[i]);
                request(API('openvpn_cerf_get'), data, function (response) {
                let output = JSON.parse(response).message;
                var element = document.getElementById(splittedData[i]);
                    element.setAttribute('href', 
                    'data:text/plain, '
                    + encodeURIComponent(output))
                }, function(response){
                    let error = JSON.parse(response).message;

                })
            }
            
        }, function(response){
            let error = JSON.parse(response).message;

        })
        }
</script>