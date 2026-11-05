{{-- ===== DATA DUMMY: angka peserta dibuat otomatis oleh script di bagian bawah file ini (bukan dari database). Hapus bagian 'DATA DUMMY' di <script> kalau data asli sudah tersedia. ===== --}}
<!-- Load Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Banner atas Selantang: biru pastel, naik menggantikan banner hijau saat submenu ini dipilih */
    .sln-hero { position: relative; overflow: hidden; display: flex; align-items: center; min-height: 210px; padding: 2rem 2.5rem; margin-bottom: .5rem; border-radius: 1rem; background: #eaf1f5; }
    .sln-hero-text { position: relative; z-index: 2; max-width: 52%; }
    .sln-hero-label { display: block; margin-bottom: .5rem; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #5b8db0; }
    .sln-hero-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #24394a; }
    .sln-hero-sub { margin: 0; font-size: .95rem; font-weight: 500; color: #4a6070; }
    .sln-hero-art { position: absolute; right: 0; bottom: 0; height: 100%; width: auto; max-width: 58%; z-index: 1; pointer-events: none; }
    @media (max-width: 767.98px) {
        .sln-hero { padding: 1.5rem; min-height: 170px; }
        .sln-hero-title { font-size: 1.6rem; }
        .sln-hero-text { max-width: 100%; }
        .sln-hero-art { opacity: .3; max-width: 80%; }
    }

    /* Kartu: putih mengambang dengan bayangan biru lembut */
    .card-selantang {
        border-radius: 16px !important;
        border: 1px solid #e3ecf1 !important;
        box-shadow: 0 1px 2px rgba(36, 57, 74, .05), 0 10px 24px -12px rgba(36, 57, 74, .22) !important;
        transition: transform .25s ease, box-shadow .25s ease;
        overflow: hidden;
    }
    .card-selantang:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(36, 57, 74, .06), 0 16px 30px -14px rgba(36, 57, 74, .3) !important;
    }
    /* Header kartu: pita biru pastel, bukan gradasi teal */
    .header-card-green {
        background: #eaf1f5 !important;
        color: #24394a !important;
        border-bottom: 1px solid #d6e4ec !important;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }
    .header-card-green .card-title, .header-card-green .card-title i { color: #24394a !important; }
    .btn-selantang-green { background-color: #3f6f93 !important; border-color: #3f6f93 !important; color: #ffffff !important; }
    .btn-selantang-green:hover { background-color: #335a78 !important; border-color: #335a78 !important; }

    /* Strip info dashboard & periode */
    .sln-info { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; padding: 1.25rem 1.5rem; background: #fff; border: 1px solid #e3ecf1; border-radius: 1rem; box-shadow: 0 1px 2px rgba(36, 57, 74, .05), 0 10px 24px -12px rgba(36, 57, 74, .2); }
    .sln-info-ikon { width: 52px; height: 52px; border-radius: 50%; background: #eaf1f5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .sln-info-ikon i { color: #4a7a9c; }
    .sln-info-kecil { display: block; font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #5b8db0; }
    .sln-info-judul { margin: .1rem 0 .15rem; font-size: 1.25rem; font-weight: 800; color: #24394a; }
    .sln-info-desc { font-size: .85rem; font-weight: 500; color: #4a6070; }
    .sln-periode { background: #eaf1f5; border-radius: .85rem; padding: .6rem 1rem; }
    .sln-periode label { display: block; margin: 0 0 .15rem; font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #5b8db0; }
    .sln-periode div { display: flex; align-items: center; gap: .4rem; font-size: .9rem; font-weight: 800; color: #24394a; }
    .sln-periode i { color: #4a7a9c; }

    /* Kartu metrik atas & insight: pastel dengan ikon di lingkaran putih */
    .sln-metrik { border-radius: 16px !important; }
    .sln-m-biru  { background: #eaf1f5 !important; border-color: #d6e4ec !important; }
    .sln-m-krem  { background: #fbf1de !important; border-color: #f1deb0 !important; }
    .sln-m-sage  { background: #ebf3e3 !important; border-color: #d3e4c3 !important; }
    .sln-m-rose  { background: #fbede8 !important; border-color: #f1d3ca !important; }
    .sln-ikon { width: 50px; height: 50px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .sln-insight { border: 1px solid transparent; border-radius: 1rem; }
    .sln-insight.sln-m-biru { border-color: #d6e4ec; } .sln-insight.sln-m-sage { border-color: #d3e4c3; }
    .sln-insight.sln-m-rose { border-color: #f1d3ca; } .sln-insight.sln-m-krem { border-color: #f1deb0; }

    /* Tabel ringkasan: header biru lembut; warna status dibuat senada (hijau sage, kuning, biru, terakota) */
    #adl-tbody .bg-success, #iadl-tbody .bg-success { background-color: #6bb38a !important; }
    #adl-tbody .bg-warning, #iadl-tbody .bg-warning { background-color: #e8a23b !important; }
    #adl-tbody .bg-info,    #iadl-tbody .bg-info    { background-color: #5b8db0 !important; }
    #adl-tbody .bg-danger,  #iadl-tbody .bg-danger  { background-color: #d2603f !important; }
    #adl-tbody .bg-dark,    #iadl-tbody .bg-dark    { background-color: #6b5b53 !important; }
    #adl-tbody .text-success, #iadl-tbody .text-success { color: #3f8a63 !important; }
    #adl-tbody .text-warning, #iadl-tbody .text-warning { color: #b8791a !important; }
    #adl-tbody .text-info,    #iadl-tbody .text-info    { color: #3f6f93 !important; }
    #adl-tbody .text-danger,  #iadl-tbody .text-danger  { color: #c2512f !important; }
    #adl-tbody .text-dark,    #iadl-tbody .text-dark    { color: #4a3f39 !important; }
    .card-selantang thead tr { background: #f3f7f9 !important; }
</style>

<!-- Banner atas Selantang: otomatis naik menggantikan banner hijau "Inovasi Kota" saat submenu ini dipilih -->
<div id="sln-top-banner" class="sln-hero sub-banner-top d-none">
    <div class="sln-hero-text">
        <span class="sln-hero-label">Inovasi Kota</span>
        <h2 class="sln-hero-title">Selantang</h2>
        <p class="sln-hero-sub">Sekolah Lansia Tangguh</p>
    </div>

    <svg class="sln-hero-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#d6e4ec"/>
        <circle cx="318" cy="22" r="46" fill="#c8dae5" opacity=".6"/>
        <circle cx="46" cy="176" r="14" fill="#c8dae5"/>
        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>
                                <rect x="260" y="170" width="7" height="16" rx="3" fill="#d9a07a"/>
                                <rect x="272" y="170" width="7" height="16" rx="3" fill="#d9a07a"/>
                                <path d="M254 144 H286 L296 172 H244 Z" fill="#b5667a"/>
                                <rect x="257" y="108" width="26" height="38" rx="7" fill="#e9b840"/>
                                <circle cx="270" cy="94" r="12" fill="#e0a98a"/>
                                <path d="M257 92 C257 76 283 76 283 92 C278 85 262 85 257 92 Z" fill="#e5e5ec"/>
                                <circle cx="270" cy="75" r="7" fill="#e5e5ec"/>
                                <path d="M282 120 L314 132" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M0 0 C-6 -8 -18 -2 0 12 C18 -2 6 -8 0 0Z" transform="translate(308 100) scale(.9)" fill="#e9b840"/>
                                <rect x="340" y="148" width="8" height="38" rx="3" fill="#3b4458"/>
                                <rect x="352" y="148" width="8" height="38" rx="3" fill="#3b4458"/>
                                <rect x="337" y="104" width="26" height="46" rx="7" fill="#5b8db0"/>
                                <circle cx="350" cy="90" r="12" fill="#d9a07a"/>
                                <path d="M338 94 C336 82 346 76 350 78 C354 76 364 82 362 94 C360 86 340 86 338 94 Z" fill="#cfcfd8"/>
                                <path d="M337 120 L322 130" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M363 120 L384 134" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M386 138 L386 188" stroke="#7b563c" stroke-width="4.5" stroke-linecap="round"/>
                                <path d="M386 138 C386 128 400 128 400 138" stroke="#7b563c" stroke-width="4.5" stroke-linecap="round"/>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M180 188 L180 156"/><path d="M180 172 L171 162"/><path d="M180 166 L189 156"/></g>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M420 188 L420 164"/><path d="M420 176 L412 168"/></g>
                            </svg>
</div>

<!-- Info dashboard & periode data -->
<div class="sln-info mb-6">
    <div class="d-flex align-items-center gap-4">
        <div class="sln-info-ikon"><i class="ki-outline ki-teacher fs-1"></i></div>
        <div>
            <span class="sln-info-kecil">Pemerintah Kota Surabaya — DP3APPKB</span>
            <h3 class="sln-info-judul">Dashboard Kegiatan Selantang</h3>
            <span class="sln-info-desc">Sekolah Lansia Tangguh — Ringkasan Data Peserta &amp; Hasil Assesment</span>
        </div>
    </div>
    <div class="sln-periode">
        <label>Periode Data</label>
        <div><i class="ki-outline ki-calendar fs-6"></i><span id="label-periode-aktif">Tahun 2026</span></div>
    </div>
</div>

<!-- Card Filter Data -->
<div class="card card-selantang mb-6">
    <div class="card-header header-card-green px-6 py-4">
        <h5 class="card-title fw-bolder text-white m-0 fs-6 d-flex align-items-center gap-2">
            <i class="ki-outline ki-filter fs-4 text-white"></i> FILTER DATA PESERTA SELANTANG
        </h5>
    </div>
    <div class="card-body p-6">
        <form id="form-filter-selantang" onsubmit="applyFilterSelantang(event)">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kecamatan</label>
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="filter-kecamatan-selantang" onchange="loadKelurahanSelantang(this.value)">
                        <option value="">Semua Kecamatan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kelurahan</label>
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="filter-kelurahan-selantang">
                        <option value="">Semua Kelurahan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Jenis Kelamin</label>
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="filter-jk-selantang">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="L">Laki - Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row g-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Bulan</label>
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="filter-bulan-selantang">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Tahun</label>
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="filter-tahun-selantang">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-selantang-green fw-bold fs-7 w-100 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="ki-outline ki-magnifier fs-4 text-white"></i> Tampilkan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Grid Ringkasan Metric Atas -->
<div class="row g-4 mb-6">
    <!-- Total Peserta Card -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang sln-metrik sln-m-biru h-100 p-5">
            <span class="fs-8 fw-bold text-gray-500 text-uppercase tracking-wider">TOTAL PESERTA</span>
            <div class="d-flex align-items-center justify-content-between mt-3">
                <div class="sln-ikon">
                    <i class="ki-outline ki-people fs-2x" style="color: #4a7a9c;"></i>
                </div>
                <div class="text-end">
                    <div class="fs-3hx fw-bolder text-gray-900" id="val-total-peserta">0</div>
                    <span class="fs-8 fw-bold text-gray-500">Orang Lansia Tangguh</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Gender Card -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang sln-metrik sln-m-krem h-100 p-5">
            <span class="fs-8 fw-bold text-gray-500 text-uppercase tracking-wider mb-3">RASIO JENIS KELAMIN</span>
            <div class="d-flex align-items-center justify-content-around">
                <div class="text-center">
                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">LAKI - LAKI</span>
                    <div class="fs-2x fw-bolder my-1" style="color: #3f6f93;" id="val-jk-l">380</div>
                    <span class="badge fw-bold fs-8" style="background-color: #d6e4ec; color: #24394a;" id="pct-jk-l">30.4%</span>
                </div>
                <div class="vr h-40px bg-gray-200"></div>
                <div class="text-center">
                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">PEREMPUAN</span>
                    <div class="fs-2x fw-bolder my-1" style="color: #c25d6e;" id="val-jk-p">870</div>
                    <span class="badge fw-bold fs-8" style="background-color: #f4d9de; color: #8a3a48;" id="pct-jk-p">69.6%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Coverage Kelurahan Card -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang sln-metrik sln-m-sage h-100 p-5">
            <span class="fs-8 fw-bold text-gray-500 text-uppercase tracking-wider">SEBARAN KELURAHAN</span>
            <div class="d-flex align-items-center justify-content-between mt-3">
                <div class="sln-ikon">
                    <i class="ki-outline ki-geolocation fs-2x" style="color: #4f7a35;"></i>
                </div>
                <div class="text-end">
                    <div class="fs-3hx fw-bolder" style="color: #2c4a1e;" id="val-kelurahan">0</div>
                    <span class="fs-8 fw-bold text-gray-500">Kelurahan Terjangkau</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Grafik Visual Assesment (Jenis Kelamin, ADL, & IADL) -->
<div class="row g-4 mb-6">
    <!-- Chart Jenis Kelamin -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang h-100">
            <div class="card-header header-card-green px-5 py-3">
                <h6 class="card-title fw-bolder text-white fs-7 m-0"><i class="ki-outline ki-chart-pie-simple fs-5 me-1"></i> PROPORSI JENIS KELAMIN</h6>
            </div>
            <div class="card-body p-5 d-flex align-items-center justify-content-center">
                <div style="height: 220px; width: 100%;">
                    <canvas id="chartGenderSelantang"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kategori ADL -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang h-100">
            <div class="card-header header-card-green px-5 py-3">
                <h6 class="card-title fw-bolder text-white fs-7 m-0"><i class="ki-outline ki-user-tick fs-5 me-1"></i> KATEGORI ADL (ACTIVITY OF DAILY LIVING)</h6>
            </div>
            <div class="card-body p-5 d-flex align-items-center justify-content-center">
                <div style="height: 220px; width: 100%;">
                    <canvas id="chartAdlSelantang"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kategori IADL -->
    <div class="col-12 col-md-4">
        <div class="card card-selantang h-100">
            <div class="card-header header-card-green px-5 py-3">
                <h6 class="card-title fw-bolder text-white fs-7 m-0"><i class="ki-outline ki-row fs-5 me-1"></i> KATEGORI IADL (INSTRUMENTAL ADL)</h6>
            </div>
            <div class="card-body p-5 d-flex align-items-center justify-content-center">
                <div style="height: 220px; width: 100%;">
                    <canvas id="chartIadlSelantang"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Tabel Ringkasan ADL & IADL -->
<div class="row g-4 mb-6">
    <!-- Tabel Ringkasan ADL -->
    <div class="col-12 col-md-6">
        <div class="card card-selantang h-100">
            <div class="card-header header-card-green px-5 py-3">
                <h6 class="card-title fw-bolder text-white fs-7 m-0">RINGKASAN SKOR ADL</h6>
            </div>
            <div class="card-body p-5">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-3">
                        <thead>
                            <tr class="fw-bolder text-gray-700 bg-light text-uppercase">
                                <th>KATEGORI ADL</th>
                                <th class="text-center">JUMLAH</th>
                                <th class="text-end">PERSENTASE</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="adl-tbody"></tbody>
                        <tfoot>
                            <tr class="fw-bolder text-gray-900 bg-light-subtle border-top">
                                <td>TOTAL</td>
                                <td class="text-center" id="adl-total">0</td>
                                <td class="text-end" id="adl-total-pct">0%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Ringkasan IADL -->
    <div class="col-12 col-md-6">
        <div class="card card-selantang h-100">
            <div class="card-header header-card-green px-5 py-3">
                <h6 class="card-title fw-bolder text-white fs-7 m-0">RINGKASAN SKOR IADL</h6>
            </div>
            <div class="card-body p-5">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-7 gy-3">
                        <thead>
                            <tr class="fw-bolder text-gray-700 bg-light text-uppercase">
                                <th>KATEGORI IADL</th>
                                <th class="text-center">JUMLAH</th>
                                <th class="text-end">PERSENTASE</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600" id="iadl-tbody"></tbody>
                        <tfoot>
                            <tr class="fw-bolder text-gray-900 bg-light-subtle border-top">
                                <td>TOTAL</td>
                                <td class="text-center" id="iadl-total">0</td>
                                <td class="text-end" id="iadl-total-pct">0%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Ringkasan Insight Utama -->
<div class="card card-selantang mb-6">
    <div class="card-header header-card-green px-6 py-4">
        <h5 class="card-title fw-bolder text-white m-0 fs-6 d-flex align-items-center gap-2">
            <i class="ki-outline ki-bulb fs-4 text-white"></i> RINGKASAN INSIGHT KELOMPOK LANSIA
        </h5>
    </div>
    <div class="card-body p-6">
        <div class="row g-4">
            <div class="col-12 col-md-3">
                <div class="p-5 sln-insight sln-m-biru text-center h-100 d-flex flex-column justify-content-center">
                    <span class="fs-8 fw-bold text-gray-600 text-uppercase">DOMINASI KATEGORI ADL</span>
                    <div class="fs-2hx fw-bolder my-2" style="color: #3f6f93;" id="ins-adl-pct">0%</div>
                    <span class="fs-8 fw-semibold text-gray-700" id="ins-adl-txt">-</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-5 sln-insight sln-m-sage text-center h-100 d-flex flex-column justify-content-center">
                    <span class="fs-8 fw-bold text-gray-600 text-uppercase">DOMINASI KATEGORI IADL</span>
                    <div class="fs-2hx fw-bolder my-2" style="color: #3f6f26;" id="ins-iadl-pct">0%</div>
                    <span class="fs-8 fw-semibold text-gray-700" id="ins-iadl-txt">-</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-5 sln-insight sln-m-rose text-center h-100 d-flex flex-column justify-content-center">
                    <span class="fs-8 fw-bold text-gray-600 text-uppercase">DOMINASI GENDER</span>
                    <div class="fs-2hx fw-bolder my-2" style="color: #c25d6e;" id="ins-gender-pct">0%</div>
                    <span class="fs-8 fw-semibold text-gray-700" id="ins-gender-txt">-</span>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="p-5 sln-insight sln-m-krem text-center h-100 d-flex flex-column justify-content-center">
                    <span class="fs-8 fw-bold text-gray-600 text-uppercase">TOTAL LANSIA TERDATA</span>
                    <div class="fs-2hx fw-bolder my-2" style="color: #8a5a0a;" id="ins-total">0</div>
                    <span class="fs-8 fw-semibold text-gray-700">Total Peserta Kegiatan SELANTANG</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const dataWilayahSurabayaSelantang = {
    "ASEM ROWO": ["ASEM ROWO", "GENTING KALIANAK", "TAMBAK SARIOSO"],
    "BENOWO": ["KANDANGAN", "ROMOKALISARI", "SEMEMI", "TAMBAK OSO WILANGUN"],
    "BUBUTAN": ["ALUN-ALUN CONTONG", "BUBUTAN", "GUNDIH", "JEPARA", "TEMBOK DUKUH"],
    "BULAK": ["BULAK", "KEDUNG COWEK", "KENJERAN", "SUKOLILO BARU"],
    "DUKUH PAKIS": ["DUKUH KUPANG", "DUKUH PAKIS", "GUNUNG SARI", "PRADAH KALIKENDAL"],
    "GAYUNGAN": ["DUKUH MENANGGAL", "GAYUNGAN", "KETINTANG", "MENANGGAL"],
    "GENTENG": ["EMBONG KALIASIN", "GENTENG", "KAPASARI", "KETABANG", "PENELEH"],
    "GUBENG": ["AIRLANGGA", "BARATAJAYA", "GUBENG", "KERTAJAYA", "MOJO", "PUCANG SEWU"],
    "GUNUNG ANYAR": ["GUNUNG ANYAR", "GUNUNG ANYAR TAMBAK", "RUNGKUT MENANGGAL", "RUNGKUT TENGAH"],
    "JAMBANGAN": ["JAMBANGAN", "KARAH", "KEBONSARI", "PAGESANGAN"],
    "KARANG PILANG": ["KARANG PILANG", "KEBRAON", "KEDURUS", "WARU GUNUNG"],
    "KENJERAN": ["BULAK BANTENG", "SIDOTOPO WETAN", "TAMBAK WEDI", "TANAH KALI KEDINDING"],
    "KREMBANGAN": ["DUPAK", "KEMAYORAN", "KREMBANGAN SELATAN", "MOROKREMBANGAN", "PERAK BARAT"],
    "LAKARSANTRI": ["BANGKINGAN", "JERUK", "LAKARSANTRI", "LIDAH KULON", "LIDAH WETAN", "SUMURWELUT"],
    "MULYOREJO": ["DUKUH SUTOREJO", "KALIJUDAN", "KALISARI", "KEJAWAAN PUTIH TAMBAK", "MANYAR SABRANGAN", "MULYOREJO"],
    "PABEAN CANTIAN": ["BONGKARAN", "KREMBANGAN UTARA", "NYAMPLUNGAN", "TANJUNG PERAK"],
    "PAKAL": ["BABAT JERAWAT", "BENOWO", "PAKAL", "SUMBER REJO"],
    "RUNGKUT": ["KALIRUNGKUT", "KEDUNG BARUK", "MEDOKAN AYU", "PENJARINGANSARI", "RUNGKUT KIDUL", "WONOREJO"],
    "SAMBIKEREP": ["BERINGIN", "LONTAR", "MADE", "SAMBIKEREP"],
    "SAWAHAN": ["BANYU URIP", "KUPANG KRAJAN", "PAKIS", "PETEMON", "PUTAT JAYA", "SAWAHAN"],
    "SEMAMPIR": ["AMPEL", "PEGIRIAN", "SIDOTOPO", "UJUNG", "WONOKUSUMO"],
    "SIMOKERTO": ["KAPASAN", "SIDODADI", "SIMOKERTO", "SIMOLAWANG", "TAMBAKREJO"],
    "SUKOLILO": ["GEBANG PUTIH", "KEPUTIH", "KLAMPIS NGASEM", "MEDOKAN SEMAMPIR", "MENUR PUMPUNGAN", "NGINDEN JANGKUNGAN", "SEMOLOWARU"],
    "SUKOMANUNGGAL": ["PUTAT GEDE", "SIMOMULYO", "SIMOMULYO BARU", "SONOKWIJENAN", "SUKOMANUNGGAL", "TANJUNGSARI"],
    "TAMBAKSARI": ["DUKUH SETRO", "GADING", "KAPASMADYA BARU", "PACARKELING", "PACARKEMBANG", "PLOSO", "RANGKAH", "TAMBAKSARI"],
    "TANDES": ["BALONGSARI", "BANJAR SUGIHAN", "KARANG POH", "MANUKAN KULON", "MANUKAN WETAN", "TANDES"],
    "TEGALSARI": ["DR. SOETOMO", "KEDUNGDORO", "KEPUTRAN", "TEGALSARI", "WONOREJO"],
    "TENGGILIS MEJOYO": ["KENDANGSARI", "KUTISARI", "PANJANG JIWO", "TENGGILIS MEJOYO"],
    "WIYUNG": ["BABATAN", "BALAS KLUMPRIK", "JAJAR TUNGGAL", "WIYUNG"],
    "WONOCOLO": ["BENDUL MERISI", "JEMUR WONOSARI", "MARGOREJO", "SIDOSERMO", "SIWALANKERTO"],
    "WONOKROMO": ["DARMO", "JAGIR", "NGAGEL", "NGAGEL REJO", "SAWUNGGALING", "WONOKROMO"]
};

// =====================================================================
// DATA DUMMY — peserta SELANTANG dibuat otomatis (angka tetap sama setiap
// halaman dibuka). Hapus bagian ini dan ganti dengan data asli bila sudah ada.
// =====================================================================
function mulberry32(a) {
    return function () {
        a |= 0; a = a + 0x6D2B79F5 | 0;
        let t = Math.imul(a ^ a >>> 15, 1 | a);
        t = t + Math.imul(t ^ t >>> 7, 61 | t) ^ t;
        return ((t ^ t >>> 14) >>> 0) / 4294967296;
    };
}

const ADL_KAT = [
    { nama: 'Mandiri',                label: '20 : MANDIRI',                  bullet: 'bg-success', teks: 'text-success', warna: '#6bb38a', cocok: function (s) { return s >= 20; } },
    { nama: 'Ketergantungan Ringan',  label: '12 - 19 : KETERGANTUNGAN RINGAN',  bullet: 'bg-warning', teks: 'text-warning', warna: '#e8a23b', cocok: function (s) { return s >= 12 && s <= 19; } },
    { nama: 'Ketergantungan Sedang',  label: '9 - 11 : KETERGANTUNGAN SEDANG',   bullet: 'bg-info',    teks: 'text-info',    warna: '#5b8db0', cocok: function (s) { return s >= 9 && s <= 11; } },
    { nama: 'Ketergantungan Berat',   label: '5 - 8 : KETERGANTUNGAN BERAT',     bullet: 'bg-danger',  teks: 'text-danger',  warna: '#d2603f', cocok: function (s) { return s >= 5 && s <= 8; } },
    { nama: 'Ketergantungan Total',   label: '0 - 4 : KETERGANTUNGAN TOTAL',     bullet: 'bg-dark',    teks: 'text-dark',    warna: '#6b5b53', cocok: function (s) { return s <= 4; } }
];
const IADL_KAT = [
    { nama: 'Mandiri / Tak Perlu Bantuan',   label: '9 - 16 : MANDIRI / TAK PERLU BANTUAN', bullet: 'bg-success', teks: 'text-success', warna: '#6bb38a', cocok: function (s) { return s >= 9; } },
    { nama: 'Perlu Bantuan',                 label: '1 - 8 : PERLU BANTUAN',                bullet: 'bg-warning', teks: 'text-warning', warna: '#e8a23b', cocok: function (s) { return s >= 1 && s <= 8; } },
    { nama: 'Tidak Dapat Melakukan Apa-apa', label: '0 : TIDAK DAPAT MELAKUKAN APA-APA',    bullet: 'bg-danger',  teks: 'text-danger',  warna: '#d2603f', cocok: function (s) { return s === 0; } }
];

const pesertaDummy = (function () {
    const rnd = mulberry32(20261028);
    const tahunDummy = [2024, 2025, 2026];
    const hasil = [];

    function skorAdl() {
        const r = rnd();
        if (r < 0.62) return 20;
        if (r < 0.84) return 12 + Math.floor(rnd() * 8);
        if (r < 0.93) return 9 + Math.floor(rnd() * 3);
        if (r < 0.98) return 5 + Math.floor(rnd() * 4);
        return Math.floor(rnd() * 5);
    }
    function skorIadl() {
        const r = rnd();
        if (r < 0.74) return 9 + Math.floor(rnd() * 8);
        if (r < 0.96) return 1 + Math.floor(rnd() * 8);
        return 0;
    }

    // Setiap kelurahan punya peserta di SETIAP bulan dan tahun (minimal 1 laki-laki
    // dan 1 perempuan), jadi filter apa pun tidak pernah menghasilkan angka 0.
    Object.keys(dataWilayahSurabayaSelantang).forEach(function (kec) {
        dataWilayahSurabayaSelantang[kec].forEach(function (kel) {
            tahunDummy.forEach(function (thn) {
                for (let bln = 1; bln <= 12; bln++) {
                    const tambahan = Math.floor(rnd() * 5);          // 0 - 4 peserta tambahan
                    for (let i = 0; i < 2 + tambahan; i++) {
                        hasil.push({
                            tahun: String(thn),
                            bulan: bln,
                            kecamatan: kec,
                            kelurahan: kel,
                            jk: i === 0 ? 'L' : (i === 1 ? 'P' : (rnd() < 0.12 ? 'L' : 'P')),
                            adl: skorAdl(),
                            iadl: skorIadl()
                        });
                    }
                }
            });
        });
    });
    return hasil;
})();
// ===================== AKHIR DATA DUMMY =====================

let chartGender = null;
let chartAdl = null;
let chartIadl = null;

const $id = function (id) { return document.getElementById(id); };
const fmt = function (n) { return Number(n).toLocaleString('id-ID'); };
function persen(n, total) {
    if (!total) return '0%';
    return (n / total * 100).toLocaleString('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + '%';
}

function initDropdownKecamatanSelantang() {
    const kecSelect = $id('filter-kecamatan-selantang');
    if (kecSelect) {
        kecSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
        Object.keys(dataWilayahSurabayaSelantang).forEach(function (kec) {
            kecSelect.appendChild(new Option(kec, kec));
        });
    }
}

function loadKelurahanSelantang(kec) {
    const kelSelect = $id('filter-kelurahan-selantang');
    if (!kelSelect) return;
    kelSelect.innerHTML = '<option value="">Semua Kelurahan</option>';
    if (kec && dataWilayahSurabayaSelantang[kec]) {
        dataWilayahSurabayaSelantang[kec].forEach(function (kel) {
            kelSelect.appendChild(new Option(kel, kel));
        });
    }
}

function dataTersaring() {
    const kec = $id('filter-kecamatan-selantang').value;
    const kel = $id('filter-kelurahan-selantang').value;
    const jk = $id('filter-jk-selantang').value;
    const bln = $id('filter-bulan-selantang').value;
    const thn = $id('filter-tahun-selantang').value;
    return pesertaDummy.filter(function (p) {
        if (kec && p.kecamatan !== kec) return false;
        if (kel && p.kelurahan !== kel) return false;
        if (jk && p.jk !== jk) return false;
        if (bln && p.bulan !== parseInt(bln, 10)) return false;
        if (thn && p.tahun !== thn) return false;
        return true;
    });
}

function hitungKategori(daftar, kategori, kunci) {
    return kategori.map(function (k) {
        return daftar.filter(function (p) { return k.cocok(p[kunci]); }).length;
    });
}

function isiTabel(prefix, kategori, jumlah, total) {
    $id(prefix + '-tbody').innerHTML = kategori.map(function (k, i) {
        return '<tr>' +
            '<td><span class="bullet bullet-vertical ' + k.bullet + ' h-15px me-2"></span>' + k.label + '</td>' +
            '<td class="text-center fw-bold text-gray-900">' + fmt(jumlah[i]) + '</td>' +
            '<td class="text-end fw-bold ' + k.teks + '">' + persen(jumlah[i], total) + '</td>' +
            '</tr>';
    }).join('');
    $id(prefix + '-total').textContent = fmt(total);
    $id(prefix + '-total-pct').textContent = total ? '100%' : '0%';
}

function isiInsight(idPct, idTxt, kategori, jumlah, total, awalan) {
    if (!total) {
        $id(idPct).textContent = '0%';
        $id(idTxt).textContent = 'Belum ada data untuk filter ini';
        return;
    }
    let maks = 0;
    jumlah.forEach(function (n, i) { if (n > jumlah[maks]) maks = i; });
    $id(idPct).textContent = persen(jumlah[maks], total);
    $id(idTxt).textContent = 'Mayoritas Peserta ' + awalan + ' ' + kategori[maks].nama;
}

function buatChart(lama, canvasId, tipe, label, data, warna, legend) {
    const el = $id(canvasId);
    if (!el) return null;
    if (lama) lama.destroy();
    return new Chart(el, {
        type: tipe,
        data: { labels: label, datasets: [{ data: data, backgroundColor: warna, borderWidth: 2 }] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: legend ? { position: 'bottom' } : { display: false } }
        }
    });
}

function renderSelantang() {
    const daftar = dataTersaring();
    const total = daftar.length;
    const l = daftar.filter(function (p) { return p.jk === 'L'; }).length;
    const p = total - l;
    const kelurahan = new Set(daftar.map(function (x) { return x.kecamatan + '|' + x.kelurahan; })).size;

    $id('val-total-peserta').textContent = fmt(total);
    $id('val-jk-l').textContent = fmt(l);
    $id('val-jk-p').textContent = fmt(p);
    $id('pct-jk-l').textContent = persen(l, total);
    $id('pct-jk-p').textContent = persen(p, total);
    $id('val-kelurahan').textContent = fmt(kelurahan);

    const adl = hitungKategori(daftar, ADL_KAT, 'adl');
    const iadl = hitungKategori(daftar, IADL_KAT, 'iadl');
    isiTabel('adl', ADL_KAT, adl, total);
    isiTabel('iadl', IADL_KAT, iadl, total);

    isiInsight('ins-adl-pct', 'ins-adl-txt', ADL_KAT, adl, total, 'Kategori ADL');
    isiInsight('ins-iadl-pct', 'ins-iadl-txt', IADL_KAT, iadl, total, 'Kategori IADL');
    if (total) {
        const dominanPerempuan = p >= l;
        $id('ins-gender-pct').textContent = persen(dominanPerempuan ? p : l, total);
        $id('ins-gender-txt').textContent = 'Peserta Didominasi Oleh ' + (dominanPerempuan ? 'Perempuan' : 'Laki-Laki');
    } else {
        $id('ins-gender-pct').textContent = '0%';
        $id('ins-gender-txt').textContent = 'Belum ada data untuk filter ini';
    }
    $id('ins-total').textContent = fmt(total);

    if (typeof Chart !== 'undefined') {
        chartGender = buatChart(chartGender, 'chartGenderSelantang', 'doughnut', ['Laki-Laki', 'Perempuan'], [l, p], ['#5b8db0', '#d98080'], true);
        chartAdl = buatChart(chartAdl, 'chartAdlSelantang', 'pie', ADL_KAT.map(function (k) { return k.nama; }), adl, ADL_KAT.map(function (k) { return k.warna; }), false);
        chartIadl = buatChart(chartIadl, 'chartIadlSelantang', 'doughnut', IADL_KAT.map(function (k) { return k.nama; }), iadl, IADL_KAT.map(function (k) { return k.warna; }), false);
    }
}

function applyFilterSelantang(e) {
    e.preventDefault();
    const thn = $id('filter-tahun-selantang').value;
    const bln = $id('filter-bulan-selantang');
    const namaBulan = bln.value ? bln.options[bln.selectedIndex].text + ' ' : '';
    $id('label-periode-aktif').textContent = (namaBulan ? namaBulan : 'Tahun ') + thn;
    renderSelantang();
}

document.addEventListener('DOMContentLoaded', function () {
    initDropdownKecamatanSelantang();
    setTimeout(renderSelantang, 300);
});

</script>

{{-- Tukar banner: banner pastel Selantang naik ke posisi banner atas, banner hijau disembunyikan --}}
<script>
(function () {
    var banner = document.getElementById('sln-top-banner');
    if (!banner) return;
    var item = banner.closest('.inovasi-item-view') || document.getElementById('content-selantang');   // wadah konten Selantang (tampil/sembunyi sesuai dropdown)

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

    if (hijau && item) hijau.insertAdjacentElement('afterend', banner);   // naik ke posisi banner atas

    function sync() {
        var tampil = !item || item.offsetParent !== null;
        banner.classList.toggle('d-none', !tampil);
        // Banner hijau tampil hanya jika tidak ada banner submenu yang sedang aktif
        if (hijau) hijau.classList.toggle('d-none', !!document.querySelector('.sub-banner-top:not(.d-none)'));
    }

    if (item) new MutationObserver(sync).observe(item, { attributes: true, attributeFilter: ['class', 'style'] });
    document.addEventListener('change', function (e) {
        if (e.target && (e.target.id === 'select-filter-inovasi' || e.target.id === 'select-filter-pokja')) setTimeout(sync, 0);
    });
    sync();
})();
</script>
