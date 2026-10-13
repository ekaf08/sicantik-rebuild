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
    .nav-pills-custom .nav-link.active-nifas {
        background: #e83e8c !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(232, 62, 140, 0.3);
    }
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

<!-- KPI Metric Cards (Statistik Ringkas) -->
<div class="row g-4 mb-6">
    <div class="col-12 col-sm-6 col-xl-4">
        <div class="card card-flush h-100 card-kpi bg-white p-5 rounded-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL IBU HAMIL</span>
                    <div class="fs-2hx fw-bolder text-gray-900 mt-1" id="kpi-total-hamil">4.280</div>
                    <span class="badge badge-light-primary fw-semibold fs-8 mt-2">Data Terverifikasi</span>
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
                    <div class="fs-2hx fw-bolder text-danger mt-1" id="kpi-total-resti">1.428</div>
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
                    <div class="fs-2hx fw-bolder mt-1" style="color: #e83e8c;" id="kpi-total-nifas">1.825</div>
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
            <h3 class="card-title fw-bolder text-gray-900 fs-3 m-0">Inovasi Ibu Hamil & Nifas</h3>
            <span class="text-gray-500 fs-8 fw-semibold">Pemetaan sebaran data di 31 Kecamatan Kota Surabaya</span>
        </div>
        <div class="card-toolbar">
            <div class="d-flex align-items-center gap-2 nav-pills-custom">
                <button type="button" class="btn fw-bold fs-7 nav-link active-hamil" id="tab-btn-hamil" onclick="switchTabBumil('hamil')">
                    <i class="ki-outline ki-element-plus fs-5 me-1"></i> Ibu Hamil
                </button>
                <button type="button" class="btn fw-bold fs-7 nav-link" id="tab-btn-nifas" onclick="switchTabBumil('nifas')">
                    <i class="ki-outline ki-heart fs-5 me-1"></i> Ibu Nifas
                </button>
            </div>
        </div>
    </div>

    <div class="card-body pt-2 px-6 pb-6">
        <div class="p-6 rounded-4" style="background-color: #f8fafc; border: 1px solid #edf2f7;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8px h-24px rounded-2" id="indicator-bar" style="background-color: #f64e60;"></span>
                    <h5 class="fw-bolder text-gray-800 m-0 fs-5 tracking-wide" id="title-grafik-bumil">IBU HAMIL RESTI</h5>
                </div>

                <!-- Dropdown Filter Grafik -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select class="form-select form-select-solid form-select-sm w-160px fs-8 fw-bold" id="filter-kecamatan-chart-bumil" onchange="updateChartBumil()">
                        <option value="">Semua Kecamatan</option>
                    </select>

                    <select class="form-select form-select-solid form-select-sm w-120px fs-8 fw-bold" id="filter-bulan-bumil" onchange="updateChartBumil()">
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

                    <select class="form-select form-select-solid form-select-sm w-100px fs-8 fw-bold" id="filter-tahun-chart-bumil" onchange="updateChartBumil()">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>

            <!-- Canvas Tempat Grafik Chart.js -->
            <div class="position-relative w-100" style="min-height: 380px;">
                <canvas id="chartIbuHamilResti"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Section Tabel Data Detail -->
<div class="card card-flush border-0 shadow-sm rounded-4">
    <div class="card-body p-6">
        <!-- Controls Filter Tabel & Search -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
            <div class="d-flex align-items-center gap-2">
                <span class="text-gray-600 fs-7 fw-semibold">Tampilkan</span>
                <select class="form-select form-select-solid w-75px fs-7 fw-bold">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="d-flex align-items-center position-relative ms-auto">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3 text-gray-500"></i>
                <input type="text" class="form-control form-control-solid ps-10 w-225px fs-7 fw-semibold" placeholder="Cari data NIK / Nama..." />
            </div>
        </div>

        <!-- Tabel Data Dinamis -->
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-4 gs-4">
                <thead>
                    <tr class="fw-bolder text-gray-700 bg-light-subtle text-uppercase border-bottom">
                        <th class="w-50px text-center">NO</th>
                        <th id="th-col-1">NIK</th>
                        <th id="th-col-2">NAMA LENGKAP</th>
                        <th id="th-col-3">USIA</th>
                        <th id="th-col-4">ALAMAT DOMISILI</th>
                        <th id="th-col-5">STATUS RISIKO</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600" id="tb-tabel-bumil">
                    <!-- Dynamic Rows via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const dataWilayahSurabayaBumil = {
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

// Data Grafik Semua Nilai Diubah Jadi 0
const dataHamilValues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
const dataNifasValues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

let activeTabMode = 'hamil';
let myChartBumil = null;

function initDropdownsBumil() {
    const kecList = Object.keys(dataWilayahSurabayaBumil);
    const chartKec = document.getElementById('filter-kecamatan-chart-bumil');
    if (chartKec) {
        chartKec.innerHTML = '<option value="">Semua Kecamatan</option>';
        kecList.forEach(kec => chartKec.appendChild(new Option(kec, kec)));
    }
}

function renderChartBumil() {
    const canvas = document.getElementById('chartIbuHamilResti');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');

    if (typeof ChartDataLabels !== 'undefined') {
        Chart.register(ChartDataLabels);
    }

    if (myChartBumil) myChartBumil.destroy();

    const isHamil = activeTabMode === 'hamil';
    const mainColor = isHamil ? '#f64e60' : '#e83e8c';
    const labelText = isHamil ? 'Ibu Hamil Resiko Tinggi' : 'Ibu Nifas';
    const currentValues = isHamil ? dataHamilValues : dataNifasValues;

    // Custom SVG Point Icon Kotak Pink Presisi
    const iconSvg = `data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><rect width="10" height="10" fill="${encodeURIComponent(mainColor)}" rx="2" stroke="%23ffffff" stroke-width="1.5"/></svg>`;
    const pointIcon = new Image(10, 10);
    pointIcon.src = iconSvg;

    myChartBumil = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Object.keys(dataWilayahSurabayaBumil),
            datasets: [{
                label: labelText,
                data: currentValues,
                borderColor: mainColor,
                backgroundColor: 'transparent',
                borderWidth: 2,
                borderDash: [5, 5],

                pointStyle: pointIcon,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: mainColor,
                pointBorderWidth: 2,

                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top', labels: { usePointStyle: true, font: { weight: 'bold' } } },
                datalabels: {
                    align: 'top',
                    anchor: 'end',
                    backgroundColor: '#ffffff',
                    borderColor: mainColor,
                    borderRadius: 4,
                    borderWidth: 1,
                    color: mainColor,
                    font: { size: 9, weight: 'bold' },
                    padding: { top: 2, bottom: 2, left: 4, right: 4 },
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 9, weight: '600' }, maxRotation: 45 }
                },
                y: {
                    grid: { color: '#f1f5f9' },
                    min: 0,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
}

function renderTableBumil() {
    const th1 = document.getElementById('th-col-1');
    const th2 = document.getElementById('th-col-2');
    const th3 = document.getElementById('th-col-3');
    const th4 = document.getElementById('th-col-4');
    const th5 = document.getElementById('th-col-5');
    const tbContainer = document.getElementById('tb-tabel-bumil');
    if (!tbContainer) return;

    if (activeTabMode === 'hamil') {
        th1.textContent = 'NIK';
        th2.textContent = 'NAMA IBU HAMIL';
        th3.textContent = 'USIA';
        th4.textContent = 'ALAMAT DOMISILI';
        th5.textContent = 'STATUS RISIKO';

        tbContainer.innerHTML = `
            <tr>
                <td class="text-center fw-bold">1</td>
                <td class="fw-bold text-gray-800">3578015502980001</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-30px symbol-circle me-2 bg-light-danger d-flex align-items-center justify-content-center text-danger fw-bold fs-8">SM</div>
                        <span class="fw-bold text-gray-800">Siti Maryam</span>
                    </div>
                </td>
                <td>28 Tahun</td>
                <td>Jl. Embong Malang No. 15, Genteng</td>
                <td><span class="badge badge-light-danger fw-bold px-3 py-2">Resti (Risiko Tinggi)</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-icon btn-light-primary rounded-circle"><i class="ki-outline ki-eye fs-5"></i></button>
                </td>
            </tr>
            <tr>
                <td class="text-center fw-bold">2</td>
                <td class="fw-bold text-gray-800">3578016211950003</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-30px symbol-circle me-2 bg-light-success d-flex align-items-center justify-content-center text-success fw-bold fs-8">DL</div>
                        <span class="fw-bold text-gray-800">Dewi Lestari</span>
                    </div>
                </td>
                <td>31 Tahun</td>
                <td>Jl. Kedungdoro No. 88, Tegalsari</td>
                <td><span class="badge badge-light-success fw-bold px-3 py-2">Normal</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-icon btn-light-primary rounded-circle"><i class="ki-outline ki-eye fs-5"></i></button>
                </td>
            </tr>
        `;
    } else { // Mode Ibu Nifas
        th1.textContent = 'NO KK';
        th2.textContent = 'NIK';
        th3.textContent = 'NAMA IBU NIFAS';
        th4.textContent = 'ALAMAT DOMISILI';
        th5.textContent = 'STATUS NIFAS';

        tbContainer.innerHTML = `
            <tr>
                <td class="text-center fw-bold">1</td>
                <td class="fw-bold text-gray-800">3578011204100005</td>
                <td class="fw-bold text-gray-800">3578014506990002</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-30px symbol-circle me-2 d-flex align-items-center justify-content-center fw-bold fs-8" style="background-color: #fde6f2; color: #e83e8c;">AR</div>
                        <span class="fw-bold text-gray-800">Anisa Rahmawati</span>
                    </div>
                </td>
                <td>Jl. Kedungdoro No. 42, Sawahan</td>
                <td><span class="badge badge-light-warning fw-bold px-3 py-2">Masa Nifas (Hari ke-14)</span></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-icon btn-light-primary rounded-circle"><i class="ki-outline ki-eye fs-5"></i></button>
                </td>
            </tr>
        `;
    }
}

function switchTabBumil(mode) {
    activeTabMode = mode;

    const btnHamil = document.getElementById('tab-btn-hamil');
    const btnNifas = document.getElementById('tab-btn-nifas');
    const title = document.getElementById('title-grafik-bumil');
    const indicator = document.getElementById('indicator-bar');

    if (mode === 'hamil') {
        btnHamil.className = 'btn fw-bold fs-7 nav-link active-hamil';
        btnNifas.className = 'btn fw-bold fs-7 nav-link';
        if (title) title.textContent = 'IBU HAMIL RESTI';
        if (indicator) indicator.style.backgroundColor = '#f64e60';
    } else {
        btnNifas.className = 'btn fw-bold fs-7 nav-link active-nifas';
        btnHamil.className = 'btn fw-bold fs-7 nav-link';
        if (title) title.textContent = 'IBU NIFAS';
        if (indicator) indicator.style.backgroundColor = '#e83e8c';
    }

    renderChartBumil();
    renderTableBumil();
}

function updateChartBumil() {
    if (myChartBumil) myChartBumil.update();
}

document.addEventListener('DOMContentLoaded', function() {
    initDropdownsBumil();
    renderTableBumil();
    setTimeout(renderChartBumil, 300);
});
</script>
