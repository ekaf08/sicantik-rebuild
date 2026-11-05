<!-- Load Library Chart.js & Datalabels Plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<style>
    .card-kpi {
        transition: all 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
    .card-kpi:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .nav-pills-custom .nav-link {
        color: #5e6278;
        background: #f5f8fa;
        border-radius: 8px;
        padding: 8px 18px;
        transition: all 0.2s ease;
    }
    .nav-pills-custom .nav-link.active-hamil {
        background: #e5655d !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(229, 101, 93, 0.3);
    }
    .nav-pills-custom .nav-link.active-kek {
        background: #d4608f !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(212, 96, 143, 0.3);
    }
    .nav-pills-custom .nav-link.active-nifas {
        background: #b57bbf !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(181, 123, 191, 0.3);
    }
    /* Teks tabel hitam: judul kolom tebal, isi tabel tipis */
    #bm-table thead th { color: #000 !important; }
    #bm-table tbody td { color: #000 !important; }

    /* Popup Lihat (riwayat) */
    .bm-hero { background: linear-gradient(135deg, #d4608f 0%, #f3a0bd 100%); color: #fff; border-radius: 16px; padding: 20px 24px; }
    .bm-avatar { width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.22); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.3rem; flex-shrink: 0; }
    .bm-chip { background: rgba(255,255,255,.2); border-radius: 999px; padding: 4px 12px; font-size: .78rem; font-weight: 700; white-space: nowrap; }
    .bm-info-item label { font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: #94a3b8; display: block; margin-bottom: 2px; }
    .bm-info-item span { font-weight: 700; color: #1e293b; font-size: .9rem; }
    .bm-riwayat { border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; }
    .bm-riwayat-head { color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .bm-riwayat-a { background: linear-gradient(135deg, #f08fb0 0%, #d4608f 100%); }
    .bm-riwayat-b { background: linear-gradient(135deg, #8ab5a0 0%, #6f9c86 100%); }
    .bm-mini-table { width: 100%; font-size: .82rem; }
    .bm-mini-table thead th { background: #fbe9f0; color: #5e2b2b; font-weight: 800; text-align: center; padding: 10px 12px; white-space: nowrap; text-transform: uppercase; font-size: .7rem; letter-spacing: .03em; }
    .bm-mini-table tbody td { color: #000; text-align: center; padding: 10px 12px; border-top: 1px dashed #e5e7eb; white-space: nowrap; font-weight: 600; }
    .bm-mini-table tbody tr:hover td { background: #fdf7f9; }

    /* Banner ibu hamil: dipindah ke paling atas halaman oleh skrip di bawah */
    .bmb { position: relative; display: flex; align-items: center; overflow: hidden; min-height: 210px; border-radius: 1rem; background: #faeeea; box-shadow: 0 2px 10px rgba(30, 40, 60, 0.06); margin-bottom: .5rem; }
    .bmb .ik-blob { fill: #f4d9d3; } .bmb .ik-blob2 { fill: #f7e3de; } .bmb .ik-shadow { fill: #ecc9c3; }
    .bmb__tx { position: relative; z-index: 2; padding: 1.5rem 2.25rem; max-width: 62%; }
    .bmb__kecil { font-size: .72rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #d98a8a; margin-bottom: .5rem; }
    .bmb__judul { font-size: 2rem; line-height: 1.15; font-weight: 800; color: #5e2b2b; margin: 0 0 .5rem; }
    .bmb__desk { display: block; font-size: .95rem; font-weight: 500; color: #8a5252; }
    .bmb__art { position: absolute; right: 0; bottom: 0; width: 370px; height: 206px; pointer-events: none; z-index: 1; }
    .bmb__art svg { width: 100%; height: 100%; display: block; }
    @media (max-width: 991px) { .bmb__art { width: 300px; height: 167px; } .bmb__tx { max-width: 70%; } }
    @media (max-width: 767px) { .bmb__art { display: none; } .bmb__tx { max-width: 100%; padding: 1.25rem; } .bmb__judul { font-size: 1.5rem; } }
    .bmb-info { background: #fdf7f9; border: 1px solid #f4e1e8; border-radius: 16px; }
    .bm-btn-lihat { background: #fbe0ea; color: #d4608f; border: none; }
    .bm-btn-lihat:hover { background: #d4608f; color: #fff; }
    .bm-btn-lihat:hover i { color: #fff !important; }
    .bm-pg .page-item.active .page-link { background-color: #d4608f; border-color: #d4608f; color: #fff; }
    .bm-pg .page-link { color: #a8406f; }
</style>

<!-- Banner Pendampingan Ibu Hamil (dipindah ke atas halaman oleh skrip di akhir file) -->
<div class="bmb d-none" id="bmb-top">
    <div class="bmb__tx">
        <div class="bmb__kecil">Inovasi Kota</div>
        <h2 class="bmb__judul">Pendampingan Ibu Hamil dan Ibu Hamil Resti</h2>
        <span class="bmb__desk">Mendampingi ibu hamil agar sehat dan selamat</span>
    </div>
    <div class="bmb__art"><svg viewBox="0 0 370 206" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path class="ik-blob" d="M0 206 C8 112 70 66 170 56 C260 48 332 44 370 40 L370 206Z"/><circle class="ik-blob2" cx="248" cy="30" r="46"/><circle class="ik-blob2" cx="14" cy="186" r="14"/><ellipse class="ik-shadow" cx="185" cy="197" rx="158" ry="6.5"/><line x1="52" y1="190" x2="52" y2="138" stroke="#e0a96a" stroke-width="2.2" stroke-linecap="round" /><path d="M52 171.8 C68 169.8 72 157.8 66 149.8 C56 155.8 52 163.8 52 171.8Z" fill="#e0a96a" /><path d="M52 161.4 C36 159.4 32 147.4 38 139.4 C48 145.4 52 153.4 52 161.4Z" fill="#e9b878" /><path d="M52 151 C68 149 72 137 66 129 C56 135 52 143 52 151Z" fill="#e0a96a" /><path d="M52 138 C44 132 44 122 52 116 C60 122 60 132 52 138Z" fill="#e9b878" /><line x1="334" y1="190" x2="334" y2="120" stroke="#6f9c86" stroke-width="2.2" stroke-linecap="round" /><path d="M334 165.5 C318 163.5 314 151.5 320 143.5 C330 149.5 334 157.5 334 165.5Z" fill="#6f9c86" /><path d="M334 151.5 C350 149.5 354 137.5 348 129.5 C338 135.5 334 143.5 334 151.5Z" fill="#8ab5a0" /><path d="M334 137.5 C318 135.5 314 123.5 320 115.5 C330 121.5 334 129.5 334 137.5Z" fill="#6f9c86" /><path d="M334 120 C326 114 326 104 334 98 C342 104 342 114 334 120Z" fill="#8ab5a0" /><rect x="87" y="149.7" width="7.3" height="40.3" rx="2.2" fill="#46546a" /><rect x="97.7" y="149.7" width="7.3" height="40.3" rx="2.2" fill="#46546a" /><ellipse cx="90.6" cy="188.2" rx="6" ry="2.9" fill="#2a2a2a" /><ellipse cx="101.4" cy="188.2" rx="6" ry="2.9" fill="#2a2a2a" /><line x1="83.7" y1="119.4" x2="74.7" y2="144.1" stroke="#f0c3a0" stroke-width="6" stroke-linecap="round" /><line x1="108.3" y1="119.4" x2="119.5" y2="137.4" stroke="#f0c3a0" stroke-width="6" stroke-linecap="round" /><rect x="82" y="109.4" width="28" height="42.6" rx="10.1" fill="#8fb09c" /><rect x="92.6" y="104.9" width="6.7" height="7.8" rx="0" fill="#f0c3a0" /><circle cx="96" cy="99.3" r="10.3" fill="#f0c3a0" /><path d="M85 99.3 A11 11 0 0 1 107 99.3 Q96 92.6 85 99.3Z" fill="#2d2420" /><path d="M170 96 C160 130 152 164 146 190 L240 190 C234 150 232 120 224 100Z" fill="#d98a8a" /><ellipse cx="222" cy="134" rx="26" ry="32" fill="#d98a8a" /><path d="M166 96 Q196 84 226 96 L224 112 Q196 104 168 112Z" fill="#cf7d7d" /><line x1="176" y1="100" x2="206" y2="136" stroke="#f2c09a" stroke-width="7" stroke-linecap="round" /><line x1="228" y1="112" x2="230" y2="142" stroke="#f2c09a" stroke-width="7" stroke-linecap="round" /><rect x="190" y="184" width="10" height="7" rx="3" fill="#f2c09a" /><rect x="210" y="184" width="10" height="7" rx="3" fill="#f2c09a" /><rect x="192" y="80" width="12" height="12" rx="3" fill="#f2c09a" /><circle cx="198" cy="66" r="17" fill="#f2c09a" /><path d="M181 66 A17 17 0 0 1 215 66 Q198 56 181 66Z" fill="#33261f" /><circle cx="198" cy="46" r="8.5" fill="#33261f" /><path d="M250 79 C232 67 238 52 250 61 C262 52 268 67 250 79Z" fill="#f0b36a" /><path d="M278 102 C266 94 270 84 278 90 C286 84 290 94 278 102Z" fill="#e69a9a" /></svg></div>
</div>

<!-- Penjelasan Inovasi -->
<div class="card card-flush border-0 mb-6 bmb-info">
    <div class="card-body p-6 p-md-7">
        <p class="fs-7 mb-3" style="line-height: 1.7; color:#5e2b2b;">
            Inovasi yang memiliki tujuan untuk mengetahui jumlah dan kondisi ibu hamil secara menyeluruh hingga tingkat kecamatan, kelurahan, RW, dan RT. Data yang dikumpulkan tidak hanya berupa jumlah, tetapi juga informasi detail seperti NIK, nama, alamat lengkap, riwayat kehamilan, serta riwayat kesehatan sejak masa calon pengantin.
        </p>
        <p class="fs-7 mb-0" style="line-height: 1.7; color:#5e2b2b;">
            Dengan data yang lengkap dan terintegrasi, kondisi ibu hamil dapat dipantau secara lebih akurat. Melalui inovasi ini, pemerintah kota dengan PKK dapat menentukan jenis intervensi yang tepat sesuai kebutuhan masing-masing ibu hamil. Harapannya, pelayanan kesehatan menjadi lebih terukur, tepat sasaran, serta mampu menekan risiko komplikasi kehamilan, kematian ibu dan bayi, serta mendukung kelahiran generasi yang sehat.
        </p>
    </div>
</div>

<!-- KPI Metric Cards (dihitung otomatis dari data) -->
<div class="row g-4 mb-6">
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL IBU HAMIL</span>
                    <div class="fs-2hx fw-bolder text-gray-900 mt-1" id="bm-kpi-hamil">0</div>
                    <span class="badge fw-semibold fs-8 mt-2" style="background:#fbe0ea;color:#a8406f;">Data Terdaftar</span>
                </div>
                <div class="w-50px h-50px rounded-circle d-flex align-items-center justify-content-center" style="background:#fbe0ea;">
                    <i class="ki-outline ki-profile-user fs-1" style="color:#d4608f;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">IBU HAMIL RESTI (RISIKO TINGGI)</span>
                    <div class="fs-2hx fw-bolder mt-1" style="color:#e5655d;" id="bm-kpi-resti">0</div>
                    <span class="badge fw-semibold fs-8 mt-2" style="background:#fde3e1;color:#b8433e;">Butuh Pendampingan Extra</span>
                </div>
                <div class="w-50px h-50px rounded-circle d-flex align-items-center justify-content-center" style="background:#fde3e1;">
                    <i class="ki-outline ki-shield-cross fs-1" style="color:#e5655d;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL IBU NIFAS</span>
                    <div class="fs-2hx fw-bolder mt-1" style="color: #b57bbf;" id="bm-kpi-nifas">0</div>
                    <span class="badge fw-semibold fs-8 mt-2" style="background:#f1e2f5;color:#85498f;">Pemantauan Pasca Melahirkan</span>
                </div>
                <div class="w-50px h-50px rounded-circle d-flex align-items-center justify-content-center" style="background-color: #f1e2f5;">
                    <i class="ki-outline ki-heart fs-1" style="color: #b57bbf;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Grafik Pemetaan -->
<div class="card card-flush border-0 shadow-sm rounded-4 mb-6">
    <div class="card-header align-items-center border-0 pt-6 px-6">
        <div>
            <h3 class="card-title fw-bolder text-gray-900 fs-3 m-0">Inovasi Ibu Hamil &amp; Nifas</h3>
            <span class="text-gray-500 fs-8 fw-semibold">Pemetaan sebaran data di Kecamatan Kota Surabaya</span>
        </div>
        <div class="card-toolbar">
            <div class="d-flex flex-wrap align-items-center gap-2 nav-pills-custom">
                <button type="button" class="btn fw-bold fs-7 nav-link active-kek" id="bm-tab-kek" onclick="bmSwitchTab('kek')">
                    <i class="ki-outline ki-element-plus fs-5 me-1"></i> Ibu Hamil KEK
                </button>
                <button type="button" class="btn fw-bold fs-7 nav-link" id="bm-tab-resti" onclick="bmSwitchTab('resti')">
                    <i class="ki-outline ki-shield-cross fs-5 me-1"></i> Ibu Hamil Resti
                </button>
                <button type="button" class="btn fw-bold fs-7 nav-link" id="bm-tab-nifas" onclick="bmSwitchTab('nifas')">
                    <i class="ki-outline ki-heart fs-5 me-1"></i> Ibu Nifas
                </button>
            </div>
        </div>
    </div>

    <div class="card-body pt-2 px-6 pb-6">
        <div class="p-6 rounded-4" style="background-color: #fdf7f9; border: 1px solid #f4e1e8;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8px h-24px rounded-2" id="bm-indicator" style="background-color: #d4608f;"></span>
                    <h5 class="fw-bolder text-gray-800 m-0 fs-5 tracking-wide" id="bm-judul">IBU HAMIL KEK/TIDAK KEK</h5>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select class="form-select form-select-solid form-select-sm w-160px fs-8 fw-bold" id="bm-filter-kecamatan">
                        <option value="">Semua Kecamatan</option>
                    </select>

                    <select class="form-select form-select-solid form-select-sm w-120px fs-8 fw-bold" id="bm-filter-bulan">
                        <option value="">Bulan</option>
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

                    <select class="form-select form-select-solid form-select-sm w-100px fs-8 fw-bold" id="bm-filter-tahun">
                        <option value="">Tahun</option>
                        @for ($t = 2030; $t >= 2024; $t--)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="position-relative w-100" style="min-height: 380px;">
                <canvas id="bm-chart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Section Tabel Data Detail -->
<div class="card card-flush border-0 shadow-sm rounded-4">
    <div class="card-body p-6">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
            <div class="d-flex align-items-center gap-2">
                <select class="form-select form-select-solid w-75px fs-7 fw-bold" id="bm-table-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="d-flex align-items-center ms-auto">
                <label class="fs-7 fw-semibold text-gray-700 me-2">Search:</label>
                <input type="text" id="bm-input-search" class="form-control form-control-solid w-225px fs-7 fw-semibold" />
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-4 gs-4" id="bm-table">
                <thead>
                    <tr class="fw-bolder bg-light-subtle text-uppercase border-bottom">
                        <th class="w-50px text-center">NO</th>
                        <th>NO KK</th>
                        <th>NIK</th>
                        <th>NAMA</th>
                        <th>ALAMAT DOMISILI</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold" id="bm-tbody">
                    <tr><td colspan="6" class="text-center py-5 text-gray-500">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4">
            <span class="text-gray-600 fs-8 fw-semibold" id="bm-info"></span>
            <ul class="pagination pagination-outline bm-pg mb-0" id="bm-pagination"></ul>
        </div>
    </div>
</div>

<!-- Modal Lihat Detail (riwayat ibu) -->
<div class="modal fade" id="modal_detail_bumil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-5 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3" id="bm-detail-judul">Riwayat Ibu Hamil</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-5 px-7" id="bm-detail-isi"></div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const $ = function (id) { return document.getElementById(id); };
    const KOLOM = 6;

    let wilayah = {};
    let semuaData = [];
    let mode = 'kek';          // kek | resti | nifas
    let page = 1;
    let chart = null;
    let pluginTerdaftar = false;

    const TAB = {
        kek:   { judul: 'IBU HAMIL KEK/TIDAK KEK',     warna: '#d4608f', kelas: 'active-kek',   tombol: 'bm-tab-kek' },
        resti: { judul: 'IBU HAMIL RESTI/TIDAK RESTI', warna: '#e5655d', kelas: 'active-hamil', tombol: 'bm-tab-resti' },
        nifas: { judul: 'IBU NIFAS',                   warna: '#b57bbf', kelas: 'active-nifas', tombol: 'bm-tab-nifas' }
    };

    function esc(v) {
        if (v === null || v === undefined) return '';
        return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function norm(v) { return String(v || '').trim().toUpperCase(); }
    function angka(v) { return (Number(v) || 0).toLocaleString('id-ID'); }

    // ---------- Filter dasar (kecamatan, bulan, tahun) ----------
    function lolosFilter(r) {
        const kec = $('bm-filter-kecamatan').value;
        const bln = $('bm-filter-bulan').value;
        const thn = $('bm-filter-tahun').value;
        if (kec && norm(r.kecamatan) !== norm(kec)) return false;
        if (bln || thn) {
            const t = String(r.tanggal || '').substring(0, 10).split('-');
            if (t.length !== 3) return false;
            if (thn && t[0] !== thn) return false;
            if (bln && parseInt(t[1], 10) !== parseInt(bln, 10)) return false;
        }
        return true;
    }

    // ---------- KPI ----------
    function updateKpi() {
        const hamil = semuaData.filter(function (r) { return r.kategori === 'hamil'; });
        $('bm-kpi-hamil').textContent = angka(hamil.length);
        $('bm-kpi-resti').textContent = angka(hamil.filter(function (r) { return r.resti; }).length);
        $('bm-kpi-nifas').textContent = angka(semuaData.filter(function (r) { return r.kategori === 'nifas'; }).length);
    }

    // ---------- Grafik ----------
    function labelGrafik() {
        const kec = $('bm-filter-kecamatan').value;
        if (kec) return { judul: 'Kelurahan di Kecamatan ' + kec, daftar: (wilayah[kec] || []).slice().sort(), kunci: 'kelurahan' };
        return { judul: 'Kecamatan Surabaya', daftar: Object.keys(wilayah).sort(), kunci: 'kecamatan' };
    }

    function hitung(daftar, kunci, saring) {
        return daftar.map(function (nama) {
            return semuaData.filter(function (r) {
                return lolosFilter(r) && saring(r) && norm(r[kunci]) === norm(nama);
            }).length;
        });
    }

    function garis(label, data, warna, putus) {
        return {
            label: label, data: data, borderColor: warna, backgroundColor: 'transparent',
            borderWidth: putus ? 2 : 3, borderDash: putus ? [6, 4] : [], tension: 0.4, fill: false,
            pointStyle: 'circle', pointRadius: 4, pointHoverRadius: 6,
            pointBackgroundColor: '#ffffff', pointBorderColor: warna, pointBorderWidth: 2
        };
    }

    function renderChart() {
        const canvas = $('bm-chart');
        if (!canvas || typeof Chart === 'undefined') return;

        if (!pluginTerdaftar && typeof ChartDataLabels !== 'undefined') {
            Chart.register(ChartDataLabels);
            pluginTerdaftar = true;
        }
        if (chart) chart.destroy();

        const g = labelGrafik();
        let dataset = [];
        if (mode === 'kek') {
            const hamil = function (r) { return r.kategori === 'hamil'; };
            dataset = [
                garis('Ibu Hamil KEK', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.status_kek === 'KEK'; }), '#d4608f', false),
                garis('Ibu Hamil Tidak KEK', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.status_kek !== 'KEK'; }), '#6f9c86', true)
            ];
        } else if (mode === 'resti') {
            const hamil = function (r) { return r.kategori === 'hamil'; };
            dataset = [
                garis('Ibu Hamil Resti', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.resti; }), '#e5655d', false),
                garis('Ibu Hamil Tidak Resti', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && !r.resti; }), '#7f9bb8', true)
            ];
        } else {
            dataset = [garis('Ibu Nifas', hitung(g.daftar, g.kunci, function (r) { return r.kategori === 'nifas'; }), '#b57bbf', false)];
        }

        chart = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: { labels: g.daftar.map(function (n) { return n.toUpperCase(); }), datasets: dataset },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { display: true, text: g.judul, font: { size: 18, weight: 'bold' }, color: '#6b7280' },
                    legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { weight: 'bold' } } },
                    datalabels: {
                        display: function (ctx) { return Number(ctx.dataset.data[ctx.dataIndex]) > 0; },
                        align: 'top', anchor: 'end',
                        backgroundColor: '#ffffff',
                        borderColor: function (ctx) { return ctx.dataset.borderColor; },
                        borderRadius: 4, borderWidth: 1,
                        color: function (ctx) { return ctx.dataset.borderColor; },
                        font: { size: 9, weight: 'bold' },
                        padding: { top: 2, bottom: 2, left: 4, right: 4 }
                    }
                },
                scales: {
                    x: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 9, weight: '600' }, maxRotation: 45, autoSkip: false } },
                    y: { grid: { color: '#f1f5f9' }, beginAtZero: true, suggestedMax: 10, ticks: { precision: 0 } }
                }
            }
        });
    }

    // ---------- Tabel ----------
    function dataTabel() {
        const q = $('bm-input-search').value.trim().toLowerCase();
        return semuaData.filter(function (r) {
            if (mode === 'nifas' ? r.kategori !== 'nifas' : r.kategori !== 'hamil') return false;
            if (mode === 'resti' && !r.resti) return false;
            if (!lolosFilter(r)) return false;
            if (q) {
                const teks = [r.no_kk, r.nik, r.nama, r.alamat, r.kecamatan, r.kelurahan].join(' ').toLowerCase();
                if (teks.indexOf(q) === -1) return false;
            }
            return true;
        });
    }

    function renderTabel() {
        const rows = dataTabel();
        const perPage = parseInt($('bm-table-length').value, 10) || 10;
        const totalPage = Math.max(1, Math.ceil(rows.length / perPage));
        if (page > totalPage) page = totalPage;
        const mulai = (page - 1) * perPage;
        const tampil = rows.slice(mulai, mulai + perPage);

        if (!tampil.length) {
            $('bm-tbody').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center py-5 text-gray-500">Belum ada data tersedia</td></tr>';
        } else {
            $('bm-tbody').innerHTML = tampil.map(function (r, i) {
                return '<tr>' +
                    '<td class="text-center fw-bold">' + (mulai + i + 1) + '</td>' +
                    '<td>' + esc(r.no_kk || '-') + '</td>' +
                    '<td>' + esc(r.nik || '-') + '</td>' +
                    '<td class="fw-bold">' + esc(r.nama) + '</td>' +
                    '<td>' + esc(r.alamat || '-') + '</td>' +
                    '<td class="text-center"><button class="btn btn-sm btn-icon rounded-circle bm-btn-lihat" data-id="' + esc(r.id) + '" title="Lihat"><i class="ki-outline ki-eye fs-5"></i></button></td>' +
                    '</tr>';
            }).join('');
        }

        $('bm-info').textContent = rows.length
            ? 'Menampilkan ' + (mulai + 1) + ' - ' + (mulai + tampil.length) + ' dari ' + rows.length + ' data'
            : 'Tidak ada data';

        let pg = '<li class="page-item ' + (page === 1 ? 'disabled' : '') + '"><a class="page-link bm-page" href="#" data-page="' + (page - 1) + '">Sebelumnya</a></li>';
        for (let p = 1; p <= totalPage; p++) {
            pg += '<li class="page-item ' + (p === page ? 'active' : '') + '"><a class="page-link bm-page" href="#" data-page="' + p + '">' + p + '</a></li>';
        }
        pg += '<li class="page-item ' + (page === totalPage ? 'disabled' : '') + '"><a class="page-link bm-page" href="#" data-page="' + (page + 1) + '">Berikutnya</a></li>';
        $('bm-pagination').innerHTML = pg;
    }

    // ---------- Popup lihat (riwayat ibu) ----------
    function fmtAngka(v, maks) {
        if (v === null || v === undefined || v === '') return null;
        const n = parseFloat(v);
        if (isNaN(n)) return null;
        return n.toLocaleString('id-ID', { maximumFractionDigits: maks === undefined ? 1 : maks });
    }
    function satuan(v, unit, maks) {
        const s = fmtAngka(v, maks);
        return s === null ? '-' : s + ' ' + unit;
    }
    function fmtTgl(v) {
        const p = String(v || '').substring(0, 10).split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : '-';
    }
    function hitungImt(r) {
        if (r.imt !== null && r.imt !== undefined && r.imt !== '') return fmtAngka(r.imt, 2) || '-';
        const bb = parseFloat(r.bb), tb = parseFloat(r.tb);
        if (!bb || !tb) return '-';
        return (bb / Math.pow(tb / 100, 2)).toLocaleString('id-ID', { maximumFractionDigits: 2 });
    }
    function inisial(nama) {
        const p = String(nama || '?').trim().split(/\s+/);
        return ((p[0] || '?').charAt(0) + (p.length > 1 ? p[p.length - 1].charAt(0) : '')).toUpperCase();
    }
    function itemInfo(label, nilai) {
        return '<div class="col-6 col-md-3 bm-info-item mb-3"><label>' + label + '</label><span>' + (nilai || '-') + '</span></div>';
    }
    function tabelMini(kolom, rows, pesanKosong) {
        let h = '<div class="table-responsive"><table class="bm-mini-table"><thead><tr><th>No</th>' +
            kolom.map(function (k) { return '<th>' + k.judul + '</th>'; }).join('') + '</tr></thead><tbody>';
        if (!rows.length) {
            h += '<tr><td colspan="' + (kolom.length + 1) + '" class="text-gray-500 py-5">' + pesanKosong + '</td></tr>';
        } else {
            h += rows.map(function (r, i) {
                return '<tr><td>' + (i + 1) + '.</td>' + kolom.map(function (k) { return '<td>' + k.nilai(r) + '</td>'; }).join('') + '</tr>';
            }).join('');
        }
        return h + '</tbody></table></div>';
    }
    function kartuRiwayat(kelas, ikon, judul, jumlah, isi) {
        return '<div class="bm-riwayat mb-5"><div class="bm-riwayat-head ' + kelas + '">' +
            '<div class="d-flex align-items-center gap-2"><i class="ki-outline ' + ikon + ' fs-2 text-white"></i><span class="fw-bolder fs-5">' + judul + '</span></div>' +
            '<span class="bm-chip">' + jumlah + ' catatan</span></div><div class="p-4">' + isi + '</div></div>';
    }

    const KOLOM_KEHAMILAN = [
        { judul: 'Tanggal',         nilai: function (r) { return esc(fmtTgl(r.tanggal)); } },
        { judul: 'Usia Kehamilan',  nilai: function (r) { return satuan(r.usia_kehamilan, 'minggu', 0); } },
        { judul: 'HB',              nilai: function (r) { return satuan(r.hb, 'g/dL'); } },
        { judul: 'BB',              nilai: function (r) { return satuan(r.bb, 'kg'); } },
        { judul: 'TB',              nilai: function (r) { return satuan(r.tb, 'cm'); } },
        { judul: 'IMT',             nilai: function (r) { return esc(hitungImt(r)); } },
        { judul: 'LILA',            nilai: function (r) { return satuan(r.lila, 'cm'); } },
        { judul: 'Tensi',           nilai: function (r) { return esc(r.tensi ? String(r.tensi).replace('/', ' / ') : '-'); } },
        { judul: 'TFU',             nilai: function (r) { return satuan(r.tfu, 'cm'); } },
        { judul: 'DJJ',             nilai: function (r) { return satuan(r.djj, 'x/menit', 0); } }
    ];
    const KOLOM_CATIN = [
        { judul: 'NIK',               nilai: function (r) { return esc(r.nik || '-'); } },
        { judul: 'Tanggal',           nilai: function (r) { return esc(fmtTgl(r.tanggal)); } },
        { judul: 'Hasil Pemeriksaan', nilai: function (r) { return esc(r.hasil_pemeriksaan || '-'); } },
        { judul: 'BB',                nilai: function (r) { return satuan(r.bb, 'kg'); } },
        { judul: 'TB',                nilai: function (r) { return satuan(r.tb, 'cm'); } },
        { judul: 'LILA',              nilai: function (r) { return satuan(r.lila, 'cm'); } },
        { judul: 'IMT',               nilai: function (r) { return esc(hitungImt(r)); } }
    ];

    function lihat(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        const hamil = r.kategori === 'hamil';
        const nama = String(r.nama || '').toUpperCase();

        $('bm-detail-judul').textContent = (hamil ? 'Riwayat Ibu Hamil ' : 'Riwayat Ibu Nifas ') + nama;

        const chips = [];
        if (hamil) {
            chips.push(r.status_kek === 'KEK' ? 'KEK' : 'Tidak KEK');
            chips.push(r.resti ? 'Resti (Risiko Tinggi)' : 'Risiko Normal');
        } else {
            chips.push('Masa Nifas');
        }

        $('bm-detail-isi').innerHTML =
            '<div class="bm-hero mb-5"><div class="d-flex align-items-center gap-4 flex-wrap">' +
                '<div class="bm-avatar">' + esc(inisial(r.nama)) + '</div>' +
                '<div class="flex-grow-1"><div class="fw-bold fs-7" style="opacity:.85;">NIK ' + esc(r.nik || '-') + ' &nbsp;|&nbsp; No KK ' + esc(r.no_kk || '-') + '</div>' +
                '<div class="d-flex flex-wrap gap-2 mt-2">' + chips.map(function (c) { return '<span class="bm-chip">' + esc(c) + '</span>'; }).join('') + '</div></div>' +
            '</div></div>' +
            '<div class="row mb-2">' +
                itemInfo('Usia', r.usia ? esc(r.usia) + ' Tahun' : '') +
                itemInfo('Kecamatan', esc(r.kecamatan)) +
                itemInfo('Kelurahan', esc(r.kelurahan)) +
                itemInfo('RW / RT', esc((r.rw || '-') + ' / ' + (r.rt || '-'))) +
                '<div class="col-12 bm-info-item mb-3"><label>Alamat Domisili</label><span>' + esc(r.alamat || '-') + '</span></div>' +
            '</div>' +
            '<div id="bm-riwayat-isi"><div class="text-center text-gray-500 py-8"><span class="spinner-border spinner-border-sm me-2"></span>Memuat riwayat...</div></div>';

        bootstrap.Modal.getOrCreateInstance($('modal_detail_bumil')).show();

        ambil('/bumil-data/' + r.id + '/riwayat')
            .then(function (res) {
                const kh = res.kehamilan || [];
                const cp = res.calon_pengantin || [];
                $('bm-riwayat-isi').innerHTML =
                    kartuRiwayat('bm-riwayat-a', 'ki-heart', 'Riwayat Kehamilan Ibu', kh.length, tabelMini(KOLOM_KEHAMILAN, kh, 'Belum ada riwayat kehamilan')) +
                    kartuRiwayat('bm-riwayat-b', 'ki-profile-user', 'Riwayat Calon Pengantin', cp.length, tabelMini(KOLOM_CATIN, cp, 'Belum ada riwayat calon pengantin'));
            })
            .catch(function () {
                $('bm-riwayat-isi').innerHTML = '<div class="text-center text-danger py-6">Gagal memuat riwayat.</div>';
            });
    }

    // ---------- Tab + filter ----------
    function perbaruiSemua() { page = 1; renderChart(); renderTabel(); }

    window.bmSwitchTab = function (m) {
        mode = m;
        Object.keys(TAB).forEach(function (k) {
            $(TAB[k].tombol).className = 'btn fw-bold fs-7 nav-link' + (k === m ? ' ' + TAB[k].kelas : '');
        });
        $('bm-judul').textContent = TAB[m].judul;
        $('bm-indicator').style.backgroundColor = TAB[m].warna;
        perbaruiSemua();
    };

    ['bm-filter-bulan', 'bm-filter-tahun', 'bm-filter-kecamatan'].forEach(function (id) {
        $(id).addEventListener('change', perbaruiSemua);
    });
    $('bm-table-length').addEventListener('change', function () { page = 1; renderTabel(); });
    $('bm-input-search').addEventListener('input', function () { page = 1; renderTabel(); });

    $('bm-pagination').addEventListener('click', function (e) {
        const a = e.target.closest('.bm-page');
        if (!a) return;
        e.preventDefault();
        const p = parseInt(a.dataset.page, 10);
        if (p >= 1) { page = p; renderTabel(); }
    });
    $('bm-tbody').addEventListener('click', function (e) {
        const b = e.target.closest('.bm-btn-lihat');
        if (b) lihat(b.dataset.id);
    });

    // ---------- Ambil data ----------
    function ambil(url) {
        return fetch(url, { headers: { 'Accept': 'application/json' } }).then(function (res) {
            if (!res.ok) throw new Error('Gagal memuat ' + url);
            return res.json();
        });
    }

    function mulaiHalaman() {
        ambil('/bumil-data/wilayah')
            .then(function (data) { wilayah = data; })
            .catch(function () { wilayah = {}; })
            .then(function () {
                const sel = $('bm-filter-kecamatan');
                sel.innerHTML = '<option value="">Semua Kecamatan</option>';
                Object.keys(wilayah).sort().forEach(function (k) { sel.appendChild(new Option(k, k)); });
                return ambil('/bumil-data');
            })
            .then(function (data) { semuaData = data; })
            .catch(function () {
                semuaData = [];
                $('bm-tbody').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center text-danger py-5">Gagal memuat data. Pastikan migrasi sudah dijalankan dan route sudah ditambahkan.</td></tr>';
            })
            .then(function () {
                updateKpi();
                renderChart();
                if (semuaData.length || !$('bm-tbody').textContent.includes('Gagal')) renderTabel();
            });
    }

    document.addEventListener('DOMContentLoaded', function () { setTimeout(mulaiHalaman, 300); });
})();
</script>

<script>
// Ganti banner hijau "INOVASI KOTA" di atas halaman dengan banner pink saat sub menu ini dibuka
(function () {
    function mulai() {
        var pink = document.getElementById('bmb-top');
        var kontainer = document.getElementById('content-pendampingan-bumil');
        var sub = document.getElementById('banner-subtitle-inovasi');
        var asli = (sub && sub.closest('.card')) || document.querySelector('.banner-inovasi-kota');
        if (!pink || !kontainer || !asli) return;
        asli.parentNode.insertBefore(pink, asli);

        function sinkron() {
            var tampil = kontainer.offsetParent !== null;
            pink.classList.toggle('d-none', !tampil);
            asli.style.display = tampil ? 'none' : '';
        }
        var ob = new MutationObserver(sinkron);
        ob.observe(kontainer, { attributes: true, attributeFilter: ['class', 'style'] });
        if (kontainer.parentElement) ob.observe(kontainer.parentElement, { attributes: true, attributeFilter: ['class', 'style'] });
        var pilih = document.getElementById('select-filter-inovasi');
        if (pilih) pilih.addEventListener('change', function () { setTimeout(sinkron, 50); });
        sinkron();
    }
    document.addEventListener('DOMContentLoaded', mulai);
})();
</script>
