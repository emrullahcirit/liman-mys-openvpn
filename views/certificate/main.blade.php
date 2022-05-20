<h2><strong>Yeni Sertifika Oluştur</strong></h2>
<p>VPN Sunucusunu kullanmak isteyen kişiler için bu sayfadan yeni sertifikalar oluşturabilir ve bu sertifikaları
    indirebilirsin.</p>
<p><strong>NOT: Bir sertifikayı yalnızca bir kullanıcı kullanabilir.</strong></p>
<div class="input-group mb-3">
    <input type="text" id="cerfName" class="form-control" placeholder="Yeni sertifika için bir kullanıcı adı"
        aria-label="A name for new certificate" aria-describedby="button-addon2">
    <button class="btn btn-outline-secondary" onclick="createNewCertificate()" type="button"
        id="button-addon2">Oluştur</button>
</div>
<hr>
<div
    style="width:200px;text-align:center;background-color:#C1EB7A; color: #0D953B; padding: 10px; margin-bottom: 10px; border-radius: 8px;">
    Toplam sertifika sayısı: <span><strong id="totalCerf"></strong></span></div>

<div style="display: flex; align-items:center; justify-content: space-between">
    <p><strong>Sertifikalar: </strong></p>

    <button type="button" class="btn btn-primary" onclick="listCertificates()">Yenile</button>
</div>
<div id="tablos" style="display: flex; flex-direction: column; ">
</div>