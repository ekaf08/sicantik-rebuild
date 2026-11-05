<style>
    /* Warna Kampung ASI: pastel biru langit, senada dengan banner */
    #content-kampung-asi .card { border: 1px solid #d6e8f2; }
    #content-kampung-asi h3.fw-bolder { color: #1f3f57 !important; }
    #content-kampung-asi .card-header span.fw-bolder { color: #1f3f57 !important; }
    #content-kampung-asi thead { background-color: #e8f3f9 !important; }
    #content-kampung-asi thead th { color: #1f3f57 !important; }
    #content-kampung-asi tbody tr:hover td { background-color: #f3f9fc; }
    #content-kampung-asi .pagination .page-link { color: #2f7aa6; }
    #content-kampung-asi .pagination .page-item.active .page-link { background-color: #3b8fc0; border-color: #3b8fc0; color: #fff; }
    #content-kampung-asi .form-select:focus, #content-kampung-asi .form-control:focus { border-color: #3b8fc0; box-shadow: 0 0 0 3px rgba(59, 143, 192, .15); }
    /* Banner Kampung ASI: dipindah ke paling atas halaman oleh skrip di bawah */
    .kab { position: relative; display: flex; align-items: center; overflow: hidden; min-height: 210px; border-radius: 1rem; background: #e8f3f9; box-shadow: 0 2px 10px rgba(30, 40, 60, 0.06); margin-bottom: .5rem; }
    .kab .ik-blob { fill: #d3e7f2; } .kab .ik-blob2 { fill: #dcecf5; } .kab .ik-shadow { fill: #c5dfee; }
    .kab__tx { position: relative; z-index: 2; padding: 1.5rem 2.25rem; max-width: 62%; }
    .kab__kecil { font-size: .72rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #3b8fc0; margin-bottom: .5rem; }
    .kab__judul { font-size: 2rem; line-height: 1.15; font-weight: 800; color: #163649; margin: 0 0 .5rem; }
    .kab__desk { display: block; font-size: .95rem; font-weight: 500; color: #204f6a; }
    .kab__art { position: absolute; right: 0; bottom: 0; width: 370px; height: 206px; pointer-events: none; z-index: 1; }
    .kab__art svg { width: 100%; height: 100%; display: block; }
    @media (max-width: 991px) { .kab__art { width: 300px; height: 167px; } .kab__tx { max-width: 70%; } }
    @media (max-width: 767px) { .kab__art { display: none; } .kab__tx { max-width: 100%; padding: 1.25rem; } .kab__judul { font-size: 1.5rem; } }
    .ik-sub-aktif .banner-inovasi-kota, [class*="ik-aktif-"] .banner-inovasi-kota { display: none !important; }
</style>

<!-- Banner Kampung ASI (dipindah ke atas halaman oleh skrip di akhir file) -->
<div class="kab d-none" id="kab-top">
    <div class="kab__tx">
        <div class="kab__kecil">Inovasi Kota</div>
        <h2 class="kab__judul">Kampung ASI</h2>
        <span class="kab__desk">Gizi seimbang untuk ibu dan anak</span>
    </div>
    <div class="kab__art"><svg viewBox="0 0 370 206" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path class="ik-blob" d="M0 206 C8 112 70 66 170 56 C260 48 332 44 370 40 L370 206Z"/><circle class="ik-blob2" cx="248" cy="30" r="46"/><circle class="ik-blob2" cx="14" cy="186" r="14"/><ellipse class="ik-shadow" cx="185" cy="197" rx="158" ry="6.5"/><rect x="18" y="176" width="334" height="9" rx="4.5" fill="#c9dde8" /><line x1="40" y1="176" x2="40" y2="130" stroke="#6f9c86" stroke-width="2.2" stroke-linecap="round" /><path d="M40 159.9 C56 157.9 60 145.9 54 137.9 C44 143.9 40 151.9 40 159.9Z" fill="#6f9c86" /><path d="M40 150.7 C24 148.7 20 136.7 26 128.7 C36 134.7 40 142.7 40 150.7Z" fill="#8ab5a0" /><path d="M40 141.5 C56 139.5 60 127.5 54 119.5 C44 125.5 40 133.5 40 141.5Z" fill="#6f9c86" /><path d="M40 130 C32 124 32 114 40 108 C48 114 48 124 40 130Z" fill="#8ab5a0" /><path d="M60 150 H140 A40 26 0 0 1 60 150Z" fill="#f0c987" /><path d="M68 150 C74 124 126 124 132 150Z" fill="#fbf7ee" /><rect x="56" y="146" width="88" height="6" rx="3" fill="#b8863f" /><rect x="174" y="142" width="18" height="34" rx="6" fill="#7fb095" /><circle cx="183" cy="122" r="22" fill="#7fb095" /><circle cx="163" cy="134" r="16" fill="#7fb095" /><circle cx="203" cy="134" r="16" fill="#7fb095" /><circle cx="176" cy="116" r="2.6" fill="#6a9d83" /><circle cx="192" cy="124" r="2.6" fill="#6a9d83" /><circle cx="168" cy="132" r="2.6" fill="#6a9d83" /><circle cx="198" cy="136" r="2.6" fill="#6a9d83" /><circle cx="246" cy="148" r="28" fill="#e07a5f" /><circle cx="236" cy="138" r="6" fill="#fff" opacity=".18"/><path d="M246 122 C246 114 248 108 252 104" fill="none" stroke="#5e4026" stroke-width="3" stroke-linecap="round"/><path d="M250 112 C256 102 268 102 272 108 C266 116 256 116 250 112Z" fill="#7fb095" /><rect x="284" y="118" width="38" height="58" rx="5" fill="#dbe7ef" /><rect x="284" y="128" width="38" height="48" rx="5" fill="#fff" /><rect x="284" y="118" width="38" height="10" rx="4" fill="#cfdde8" /><line x1="306" y1="122" x2="316" y2="94" stroke="#e07a5f" stroke-width="4" stroke-linecap="round" /><ellipse cx="338" cy="170" rx="14" ry="8" fill="#fff" /><circle cx="338" cy="170" r="5.2" fill="#f0b94a" /></svg></div>
</div>

<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm">
        <div class="card-body p-5 p-md-7">
            <h3 class="fs-3 fs-md-2 fw-bolder text-gray-900 mb-1">Inovasi Kampung ASI</h3>
            <div style="width: 48px; height: 3px; background-color: #3b8fc0; border-radius: 2px;" class="mb-3 mb-md-4"></div>
            <p class="text-gray-600 fs-7 fs-md-6 lh-base mb-0">
                Program Kampung ASI merupakan inovasi percepatan pembinaan pemenuhan gizi keluarga berbasis masyarakat guna mendukung pemberian ASI Eksklusif, meningkatkan kualitas pengasuhan serta kesehatan ibu dan anak, mencegah stunting sejak dini, dan memperkuat kepedulian lingkungan keluarga di setiap wilayah. Harapannya dengan adanya program ini, tercipta lingkungan yang ramah dan suportif bagi ibu hamil serta menyusui.
            </p>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header border-bottom border-gray-200 pt-4 px-4 px-md-6 pb-4 bg-white rounded-top">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <span class="fs-7 fs-md-6 fw-bolder text-gray-800 text-uppercase tracking-wide mb-0">
                    NILAI PRESENTASE KAMPUNG ASI
                </span>
                <div class="w-100 w-sm-auto">
                    <select id="filter_kampung_asi_kecamatan_top"
                            class="form-select form-select-sm form-select-solid fw-semibold bg-white border border-gray-300 w-100 w-sm-200px"
                            onchange="filterKampungAsiKecamatanTop()">
                        <option value="all" selected>Pilih Kecamatan</option>
                        <option value="ASEMROWO">ASEMROWO</option>
                        <option value="BENOWO">BENOWO</option>
                        <option value="BUBUTAN">BUBUTAN</option>
                        <option value="BULAK">BULAK</option>
                        <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                        <option value="GAYUNGAN">GAYUNGAN</option>
                        <option value="GENTENG">GENTENG</option>
                        <option value="GUBENG">GUBENG</option>
                        <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                        <option value="JAMBANGAN">JAMBANGAN</option>
                        <option value="KARANG PILANG">KARANG PILANG</option>
                        <option value="KENJERAN">KENJERAN</option>
                        <option value="KREMBANGAN">KREMBANGAN</option>
                        <option value="LAKAR SANTRI">LAKAR SANTRI</option>
                        <option value="MULYOREJO">MULYOREJO</option>
                        <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                        <option value="PAKAL">PAKAL</option>
                        <option value="RUNGKUT">RUNGKUT</option>
                        <option value="SAMBI KEREP">SAMBI KEREP</option>
                        <option value="SAWAHAN">SAWAHAN</option>
                        <option value="SEMAMPIR">SEMAMPIR</option>
                        <option value="SIMOKERTO">SIMOKERTO</option>
                        <option value="SUKOLILO">SUKOLILO</option>
                        <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                        <option value="TAMBAKSARI">TAMBAKSARI</option>
                        <option value="TANDES">TANDES</option>
                        <option value="TEGALSARI">TEGALSARI</option>
                        <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                        <option value="WIYUNG">WIYUNG</option>
                        <option value="WONOCOLO">WONOCOLO</option>
                        <option value="WONOKROMO">WONOKROMO</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-body pt-3 pb-5 px-3 px-md-6">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="chartKampungAsiPersentase"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header pt-5 px-4 px-md-6">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <div></div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center position-relative">
                        <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                        <input type="text" id="kampung_asi_search" class="form-control form-control-solid form-control-sm w-150px w-sm-175px" placeholder="Cari..." onkeyup="searchKampungAsiTable()">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pt-0 px-4 px-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">No</th>
                            <th class="min-w-110px">Kecamatan</th>
                            <th class="min-w-110px">Kelurahan</th>
                            <th class="min-w-150px">Nama Kampung ASI</th>
                            <th class="text-center min-w-90px">Jumlah Kader</th>
                            <th class="text-center min-w-90px">Jumlah Toga</th>
                            <th class="text-center min-w-80px">Ibu Hamil</th>
                            <th class="text-center min-w-90px">Ibu Menyusui</th>
                            <th class="text-center min-w-80px">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_kampung_asi_body">
                        <tr>
                            <td colspan="9" class="text-center py-6 text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="kampung_asi_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeKampungAsiPageSize()">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        </div>
                    <span class="text-gray-300">|</span>
                    <div id="kampung_asi_info_records" class="fs-7 text-gray-600">
                        Menampilkan 0 sampai 0 dari 0 data
                    </div>
                </div>
                <div>
                    <ul id="kampung_asi_pagination" class="pagination pagination-sm m-0 justify-content-center"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.API_ROUTES = window.API_ROUTES || {};
    window.API_ROUTES.kampungAsi      = "{{ route('kampung-asi.data') }}";
    window.API_ROUTES.kampungAsiChart = "{{ route('kampung-asi.chart') }}";
</script>

<script>
// Banner pastel Kampung ASI menggantikan banner hijau saat sub menu ini dibuka
(function () {
    function mulai() {
        if (document.getElementById('kb-banner')) return; // sudah ditangani index.blade.php
        var baru = document.getElementById('kab-top');
        var kontainer = document.getElementById('content-kampung-asi');
        var area = document.getElementById('kt_app_content_container') || document.body;
        var pilihEl = document.getElementById('select-filter-inovasi');
        var sub = document.getElementById('banner-subtitle-inovasi');
        if (!baru || !kontainer) return;
        // tempat banner: tepat sebelum blok banner hijau (atau sebelum blok dropdown)
        var titik = sub || pilihEl;
        if (titik && pilihEl) { while (titik.parentElement && !titik.parentElement.contains(pilihEl)) titik = titik.parentElement; }
        if (titik && titik.parentNode) titik.parentNode.insertBefore(baru, titik);

        function sinkron() {
            var tampil = kontainer.offsetParent !== null;
            baru.classList.toggle('d-none', !tampil);
            area.classList.toggle('ik-aktif-kab', tampil);
        }
        var ob = new MutationObserver(sinkron);
        ob.observe(kontainer, { attributes: true, attributeFilter: ['class', 'style'] });
        if (kontainer.parentElement) ob.observe(kontainer.parentElement, { attributes: true, attributeFilter: ['class', 'style'] });
        if (pilihEl) pilihEl.addEventListener('change', function () { setTimeout(sinkron, 50); });
        sinkron();
    }
    document.addEventListener('DOMContentLoaded', mulai);
})();
</script>
