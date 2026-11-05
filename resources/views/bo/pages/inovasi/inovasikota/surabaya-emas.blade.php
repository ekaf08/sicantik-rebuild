<!-- Banner atas Surabaya Emas: otomatis naik menggantikan banner hijau "Inovasi Kota" saat submenu ini dipilih -->
<style>
    /* Banner atas Surabaya Emas: naik menggantikan banner hijau saat submenu ini dipilih */
    .se-hero { position: relative; overflow: hidden; display: flex; align-items: center; min-height: 210px; padding: 2rem 2.5rem; margin-bottom: .5rem; border-radius: 1rem; background: #edf0f8; }
    .se-hero-text { position: relative; z-index: 2; max-width: 52%; }
    .se-hero-label { display: block; margin-bottom: .5rem; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #2f4a9a; }
    .se-hero-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #1e2a5a; }
    .se-hero-sub { margin: 0; font-size: .95rem; font-weight: 500; color: #4a5580; }
    .se-hero-art { position: absolute; right: 0; bottom: 0; height: 100%; width: auto; max-width: 58%; z-index: 1; pointer-events: none; }
    @media (max-width: 767.98px) {
        .se-hero { padding: 1.5rem; min-height: 170px; }
        .se-hero-title { font-size: 1.6rem; }
        .se-hero-text { max-width: 100%; }
        .se-hero-art { opacity: .3; max-width: 80%; }
    }

    /* Kartu Surabaya Emas: mengambang dengan bayangan indigo lembut */
    .se-card { border: 1px solid #e3e7f3 !important; border-radius: 1rem !important; box-shadow: 0 1px 2px rgba(30, 42, 90, .05), 0 10px 24px -12px rgba(30, 42, 90, .22) !important; }
    .se-card .card-title { color: #1e2a5a !important; }
    .btn.se-btn-indigo { background-color: #2f4a9a; color: #fff; border: 0; }
    .btn.se-btn-indigo:hover, .btn.se-btn-indigo:focus { background-color: #263d82; color: #fff; }
    .btn.se-btn-reset { background-color: #edf0f8; color: #2f4a9a; border: 0; }
    .btn.se-btn-reset:hover, .btn.se-btn-reset:focus { background-color: #dde2f1; color: #1e2a5a; }
    .se-card thead th, #modalDetailBalita thead th { background-color: #edf0f8 !important; color: #1e2a5a !important; }
    .se-card tbody tr:hover td, #modalDetailBalita tbody tr:hover td { background-color: #f8f9fd; }
    .se-card .btn-light-primary, #modalDetailBalita .btn-light-primary { background-color: #edf0f8 !important; color: #2f4a9a !important; }
    .se-card .btn-light-primary i, #modalDetailBalita .btn-light-primary i { color: #2f4a9a !important; }
    .se-card .pagination .page-link, #modalDetailBalita .pagination .page-link { color: #4a5580; }
    .se-card .pagination .page-item.active .page-link, #modalDetailBalita .pagination .page-item.active .page-link { background-color: #2f4a9a !important; border-color: #2f4a9a !important; color: #fff !important; }
</style>

<div id="se-top-banner" class="se-hero sub-banner-top d-none">
    <div class="se-hero-text">
        <span class="se-hero-label">Inovasi Kota</span>
        <h2 class="se-hero-title">Surabaya Emas</h2>
        <p class="se-hero-sub">Generasi emas Kota Surabaya</p>
    </div>

    <svg class="se-hero-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#dde2f1"/>
        <circle cx="318" cy="22" r="46" fill="#d0d7ec" opacity=".6"/>
        <circle cx="46" cy="176" r="14" fill="#d0d7ec"/>
        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>
                                <polygon points="340,44 343.8,54.7 355.2,55.1 346.2,62 349.4,72.9 340,66.5 330.6,72.9 333.8,62 324.8,55.1 336.2,54.7" fill="#d4a62a"/>
                                <rect x="372" y="178" width="56" height="9" rx="2" fill="#c0951f"/>
                                <rect x="380" y="169" width="40" height="9" rx="2" fill="#d4a62a"/>
                                <path d="M388 169 C390 132 394 98 400 76 C406 98 410 132 412 169 Z" fill="#d4a62a"/>
                                <path d="M400 80 V166 M394 100 V166 M406 100 V166" stroke="#b8891a" stroke-width="1.5"/>
                                <path d="M400 76 V60" stroke="#c0951f" stroke-width="2.5" stroke-linecap="round"/>
                                <circle cx="400" cy="57" r="3.5" fill="#d4a62a"/>
                                <rect x="207" y="152" width="7" height="28" rx="3" fill="#e0a98a"/>
                                <rect x="217" y="152" width="7" height="28" rx="3" fill="#e0a98a"/>
                                <path d="M203 116 H227 L232 154 H198 Z" fill="#d98595"/>
                                <circle cx="215" cy="104" r="10" fill="#f1c9a0"/>
                                <path d="M205 102 C205 92 225 92 225 102 C221 98 209 98 205 102 Z" fill="#3b2a22"/>
                                <circle cx="203" cy="100" r="4" fill="#3b2a22"/>
                                <circle cx="227" cy="100" r="4" fill="#3b2a22"/>
                                <rect x="249" y="144" width="8" height="36" rx="3" fill="#3b4458"/>
                                <rect x="261" y="144" width="8" height="36" rx="3" fill="#3b4458"/>
                                <rect x="246" y="114" width="26" height="32" rx="5" fill="#2f4a9a"/>
                                <circle cx="259" cy="102" r="10" fill="#f1c9a0"/>
                                <path d="M249 100 C249 90 269 90 269 100 C265 96 253 96 249 100 Z" fill="#3b2a22"/>
                                <rect x="292" y="154" width="8" height="26" rx="3" fill="#e0a98a"/>
                                <rect x="304" y="154" width="8" height="26" rx="3" fill="#e0a98a"/>
                                <path d="M289 118 H315 L320 156 H284 Z" fill="#e9b840"/>
                                <circle cx="302" cy="100" r="14" fill="#8070b8"/>
                                <circle cx="302" cy="103" r="8.5" fill="#f1c9a0"/>
                                <path d="M227 130 L248 132 M270 132 L290 132" stroke="#f1c9a0" stroke-width="5" stroke-linecap="round"/>
                                <g stroke="#6f86c4" stroke-width="2.5" stroke-linecap="round"><path d="M162 188 L162 160"/><path d="M162 174 L153 164"/><path d="M162 168 L171 158"/></g>
                            </svg>
</div>

<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm se-card">
        <div class="card-body p-5 p-md-7">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-4 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-3 fw-bolder text-gray-800">Inovasi Surabaya Emas</span>
                </div>
            </div>
            <div style="width: 48px; height: 3px; background-color: #d4a62a; border-radius: 2px;" class="mb-3 mb-md-4"></div>
            <p class="text-gray-600 fs-7 fs-md-6 lh-base mb-0">
                Surabaya Emas merupakan komitmen Pemerintah Kota Surabaya dalam membentuk generasi yang berakhlak mulia, sehat, cerdas, dan berdaya saing. Di bidang kesehatan, program Bersama Wujudkan Surabaya Emas (BWSE) dijalankan untuk mencegah dan menurunkan stunting melalui pendampingan gizi, pola asuh, serta pemantauan kesehatan secara berkelanjutan. Secara keseluruhan, Surabaya Emas mencerminkan upaya nyata pemerintah dalam menciptakan warga Surabaya yang unggul, berprestasi, dan siap menghadapi tantangan masa depan.
            </p>
        </div>
    </div>

    <div class="card card-flush shadow-sm se-card">
        <div class="card-body p-5 p-md-6">
            <div class="row g-4 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Kecamatan</label>
                    <select id="filter_surabaya_emas_kecamatan" class="form-select form-select-solid fw-semibold" onchange="handleSurabayaEmasKecamatanChange()">
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
                <div class="col-12 col-md-3">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Kelurahan</label>
                    <select id="filter_surabaya_emas_kelurahan" class="form-select form-select-solid fw-semibold">
                        <option value="all" selected>Semua Kelurahan</option>
                        @php
                            $listKel = isset($kelurahan) && count($kelurahan) > 0
                                ? $kelurahan
                                : \Illuminate\Support\Facades\DB::table('m_kelurahan')->orderBy('nama_kel', 'asc')->get();
                        @endphp
                        @foreach($listKel as $k)
                            <option value="{{ $k->nama_kel }}">{{ $k->nama_kel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Tahun</label>
                    <select id="filter_surabaya_emas_tahun" class="form-select form-select-solid fw-semibold">
                        <option value="all" selected>Semua</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="button" class="btn se-btn-indigo fw-bold w-100" onclick="terapkanFilterSurabayaEmas()">
                        Terapkan
                    </button>
                    <button type="button" class="btn se-btn-reset fw-bold w-100" onclick="resetFilterSurabayaEmas()">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm se-card">
        <div class="card-header pt-6">
            <h3 class="card-title w-100 justify-content-center text-uppercase fw-bolder text-gray-800 fs-5 fs-md-4 tracking-wide">
                KECAMATAN KOTA SURABAYA
            </h3>
        </div>
        <div class="card-body pt-0 px-3 px-md-6 pb-6">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="chartSurabayaEmas"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm se-card">
        <div class="card-header pt-5 px-4 px-md-6">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <div class="d-flex align-items-center gap-2">
                    <select id="surabaya_emas_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeSurabayaEmasPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="d-flex align-items-center position-relative">
                    <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                    <input type="text" id="surabaya_emas_search" class="form-control form-control-solid form-control-sm w-150px w-sm-200px" onkeyup="searchSurabayaEmasTable()">
                </div>
            </div>
        </div>

        <div class="card-body pt-0 px-4 px-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7 mb-0">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">No ^</th>
                            <th class="min-w-160px">Nama Balita</th>
                            <th class="min-w-110px">Tanggal Lahir</th>
                            <th class="text-center min-w-100px">Jenis Kelamin</th>
                            <th class="min-w-180px">Alamat Domisili</th>
                            <th class="min-w-130px">Kelurahan Domisili</th>
                            <th class="min-w-130px">Kecamatan Domisili</th>
                            <th class="text-center min-w-80px">TPK</th>
                            <th class="text-center min-w-80px">Tahun</th>
                            <th class="text-center min-w-80px">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_surabaya_emas_body">
                        <tr>
                            <td colspan="10" class="text-center py-6 text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4">
                <div id="surabaya_emas_info_records" class="fs-7 text-gray-600 text-center text-sm-start">
                    Menampilkan 0 sampai 0 dari 0 data
                </div>
                <ul id="surabaya_emas_pagination" class="pagination pagination-sm m-0 justify-content-center"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailBalita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom py-3 px-6 px-md-8 justify-content-between align-items-center">
            <button type="button"
            class="btn btn-icon btn-sm btn-color-gray-500 btn-active-color-danger btn-active-light-danger rounded-circle w-32px h-32px transition-all"
            data-bs-dismiss="modal"
            aria-label="Close"
            style="transition: all 0.2s ease-in-out;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>
            <div class="modal-body px-6 px-md-8 py-5">
                <div class="text-center mb-4">
                    <h5 class="fw-bolder text-gray-800 text-uppercase tracking-wide mb-3">DETAIL RIWAYAT TIMBANG BALITA</h5>
                    <div class="d-inline-block text-start fs-7">
                        <div class="row g-2 mb-1">
                            <div class="col-auto text-gray-600 fw-bold w-60px">NIK</div>
                            <div class="col-auto text-gray-800 fw-bold">: <span id="detail_balita_nik">-</span></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-auto text-gray-600 fw-bold w-60px">Nama</div>
                            <div class="col-auto text-gray-800 fw-bold">: <span id="detail_balita_nama">-</span></div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush shadow-none border border-gray-200 mb-5">
                    <div class="card-header border-0 py-3 px-4 rounded-top" style="background-color: #f1f4f9;">
                        <span class="fs-7 fw-bolder text-gray-800 text-uppercase tracking-wide mb-0">
                            PENINGKATAN RATA-RATA PER BULAN
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div style="position: relative; height: 320px; width: 100%;">
                            <canvas id="chartDetailRiwayatBalita"></canvas>
                        </div>
                    </div>
                </div>

                <div class="table-responsive border rounded">
                    <table class="table table-bordered table-row-dashed gy-3 align-middle fs-8 mb-0">
                        <thead class="bg-light-secondary text-gray-700 fw-bold text-center text-uppercase">
                            <tr class="align-middle text-nowrap">
                                <th class="w-40px">NO ^</th>
                                <th class="min-w-100px">TANGGAL TIMBANG</th>
                                <th class="min-w-80px">TINGGI BADAN</th>
                                <th class="min-w-80px">BERAT BADAN</th>
                                <th class="min-w-60px">LILA</th>
                                <th class="min-w-60px">TBU</th>
                                <th class="min-w-60px">BBU</th>
                                <th class="min-w-60px">BBTB</th>
                                <th class="min-w-70px">STATUS GIZI</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_detail_balita_body" class="text-center text-gray-800">
                            <tr>
                                <td colspan="9" class="text-center py-6 text-gray-400">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap pt-4">
                    <div id="detail_balita_info" class="fs-8 text-gray-600">
                        Showing 0 to 0 of 0 records
                    </div>
                    <ul id="detail_balita_pagination" class="pagination pagination-sm m-0"></ul>
                </div>
            </div>

            <div class="modal-footer border-top pt-3 px-6 px-md-8 pb-4 justify-content-end">
                <button type="button" class="btn btn-sm btn-secondary text-gray-700 fw-bold px-5" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
        window.API_ROUTES = {
            surabayaEmas: "{{ route('surabaya.emas.data') }}",
            surabayaEmasChart: "{{ route('surabaya.emas.chart') }}",
            surabayaEmasDetail: "{{ url('/surabaya-emas/detail') }}"
        };
</script>

{{-- Tukar banner: banner pastel Surabaya Emas naik ke posisi banner atas, banner hijau disembunyikan --}}
<script>
(function () {
    var banner = document.getElementById('se-top-banner');
    if (!banner) return;
    var item = banner.closest('.inovasi-item-view') || document.getElementById('content-surabaya-emas');   // wadah konten Surabaya Emas (tampil/sembunyi sesuai dropdown)
    if (!item) return;   // wadah tidak ditemukan: banner tetap tersembunyi agar tidak muncul di submenu lain

    // Cari banner hijau "Inovasi Kota" di index.blade.php (tidak bergantung pada nama class tertentu)
    function cariBannerHijau() {
        var el = document.querySelector('#banner-inovasi-default, .banner-inovasi-kota');
        if (el) return el;
        var sub = document.getElementById('banner-subtitle-inovasi');
        var pilih = document.getElementById('select-filter-inovasi');
        if (!sub || !pilih) return null;
        el = sub;
        while (el.parentElement && !el.parentElement.contains(pilih)) el = el.parentElement;
        return el;
    }
    var hijau = cariBannerHijau();

    if (hijau) hijau.insertAdjacentElement('afterend', banner);   // naik ke posisi banner atas

    function sync() {
        var tampil = item.offsetParent !== null;
        banner.classList.toggle('d-none', !tampil);
        // Banner hijau tampil hanya jika tidak ada banner submenu yang sedang aktif
        if (hijau) hijau.classList.toggle('d-none', !!document.querySelector('.sub-banner-top:not(.d-none)'));
    }

    new MutationObserver(sync).observe(item, { attributes: true, attributeFilter: ['class', 'style'] });
    document.addEventListener('change', function (e) {
        if (e.target && (e.target.id === 'select-filter-inovasi' || e.target.id === 'select-filter-pokja')) setTimeout(sync, 0);
    });
    sync();
})();
</script>
