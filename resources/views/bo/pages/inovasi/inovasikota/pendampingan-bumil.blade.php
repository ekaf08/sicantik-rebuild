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
        background: #f64e60 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(246, 78, 96, 0.3);
    }
    .nav-pills-custom .nav-link.active-kek {
        background: #8b5cf6 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }
    .nav-pills-custom .nav-link.active-nifas {
        background: #e83e8c !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(232, 62, 140, 0.3);
    }
    /* Teks tabel hitam: judul kolom tebal, isi tabel tipis */
    #bm-table thead th { color: #000 !important; }
    #bm-table tbody td { color: #000 !important; }

    /* Popup Lihat (riwayat) */
    .bm-hero { background: linear-gradient(135deg, #6d28d9 0%, #ec4899 100%); color: #fff; border-radius: 16px; padding: 20px 24px; }
    .bm-avatar { width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.22); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.3rem; flex-shrink: 0; }
    .bm-chip { background: rgba(255,255,255,.2); border-radius: 999px; padding: 4px 12px; font-size: .78rem; font-weight: 700; white-space: nowrap; }
    .bm-info-item label { font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: #94a3b8; display: block; margin-bottom: 2px; }
    .bm-info-item span { font-weight: 700; color: #1e293b; font-size: .9rem; }
    .bm-riwayat { border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; }
    .bm-riwayat-head { color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .bm-riwayat-a { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); }
    .bm-riwayat-b { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
    .bm-mini-table { width: 100%; font-size: .82rem; }
    .bm-mini-table thead th { background: #f1f5f9; color: #000; font-weight: 800; text-align: center; padding: 10px 12px; white-space: nowrap; text-transform: uppercase; font-size: .7rem; letter-spacing: .03em; }
    .bm-mini-table tbody td { color: #000; text-align: center; padding: 10px 12px; border-top: 1px dashed #e5e7eb; white-space: nowrap; font-weight: 600; }
    .bm-mini-table tbody tr:hover td { background: #f8fafc; }
</style>

<!-- Banner Informasi Inovasi dengan Style Gradasi Modern -->
<div class="card card-flush border-0 mb-6" style="background-color: #f0f6ff !important; border-radius: 16px;">
    <div class="card-body p-6 p-md-7">
        <h4 class="fw-bolder text-gray-900 mb-3 fs-3">Inovasi Pendampingan Ibu Hamil & Ibu Hamil Resti</h4>
        <p class="text-gray-700 fs-7 mb-3" style="line-height: 1.7;">
            Inovasi yang memiliki tujuan untuk mengetahui jumlah dan kondisi ibu hamil secara menyeluruh hingga tingkat kecamatan, kelurahan, RW, dan RT. Data yang dikumpulkan tidak hanya berupa jumlah, tetapi juga informasi detail seperti NIK, nama, alamat lengkap, riwayat kehamilan, serta riwayat kesehatan sejak masa calon pengantin.
        </p>
        <p class="text-gray-700 fs-7 mb-0" style="line-height: 1.7;">
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
                    <span class="badge badge-light-primary fw-semibold fs-8 mt-2">Data Terdaftar</span>
                </div>
                <div class="w-50px h-50px rounded-circle bg-light-primary d-flex align-items-center justify-content-center">
                    <i class="ki-outline ki-profile-user fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">IBU HAMIL RESTI (RISIKO TINGGI)</span>
                    <div class="fs-2hx fw-bolder text-danger mt-1" id="bm-kpi-resti">0</div>
                    <span class="badge badge-light-danger fw-semibold fs-8 mt-2">Butuh Pendampingan Extra</span>
                </div>
                <div class="w-50px h-50px rounded-circle bg-light-danger d-flex align-items-center justify-content-center">
                    <i class="ki-outline ki-shield-cross fs-1 text-danger"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL IBU NIFAS</span>
                    <div class="fs-2hx fw-bolder mt-1" style="color: #e83e8c;" id="bm-kpi-nifas">0</div>
                    <span class="badge badge-light-warning fw-semibold fs-8 mt-2">Pemantauan Pasca Melahirkan</span>
                </div>
                <div class="w-50px h-50px rounded-circle d-flex align-items-center justify-content-center" style="background-color: #fde6f2;">
                    <i class="ki-outline ki-heart fs-1" style="color: #e83e8c;"></i>
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
        <div class="p-6 rounded-4" style="background-color: #f8fafc; border: 1px solid #edf2f7;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8px h-24px rounded-2" id="bm-indicator" style="background-color: #8b5cf6;"></span>
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
            <ul class="pagination pagination-outline mb-0" id="bm-pagination"></ul>
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
        kek:   { judul: 'IBU HAMIL KEK/TIDAK KEK',     warna: '#8b5cf6', kelas: 'active-kek',   tombol: 'bm-tab-kek' },
        resti: { judul: 'IBU HAMIL RESTI/TIDAK RESTI', warna: '#f64e60', kelas: 'active-hamil', tombol: 'bm-tab-resti' },
        nifas: { judul: 'IBU NIFAS',                   warna: '#e83e8c', kelas: 'active-nifas', tombol: 'bm-tab-nifas' }
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
                garis('Ibu Hamil KEK', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.status_kek === 'KEK'; }), '#8b5cf6', false),
                garis('Ibu Hamil Tidak KEK', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.status_kek !== 'KEK'; }), '#2ec4b6', true)
            ];
        } else if (mode === 'resti') {
            const hamil = function (r) { return r.kategori === 'hamil'; };
            dataset = [
                garis('Ibu Hamil Resti', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && r.resti; }), '#f64e60', false),
                garis('Ibu Hamil Tidak Resti', hitung(g.daftar, g.kunci, function (r) { return hamil(r) && !r.resti; }), '#3b82f6', true)
            ];
        } else {
            dataset = [garis('Ibu Nifas', hitung(g.daftar, g.kunci, function (r) { return r.kategori === 'nifas'; }), '#e83e8c', false)];
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
                    '<td class="text-center"><button class="btn btn-sm btn-icon btn-light-primary rounded-circle bm-btn-lihat" data-id="' + esc(r.id) + '" title="Lihat"><i class="ki-outline ki-eye fs-5"></i></button></td>' +
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
