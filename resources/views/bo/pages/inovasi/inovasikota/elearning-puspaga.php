<style>
    .elearning-card-main {
        background: #ffffff;
        border-radius: 1rem !important;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    }
    .badge-kecamatan-info {
        background-color: #e4e7f6 !important;
        color: #4a56a6 !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
    }
    .badge-kelurahan-success {
        background-color: #fbe4dc !important;
        color: #b8543c !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
    }
    .btn-peserta-kecamatan {
        background-color: #fbf0d0 !important;
        color: #8a6212 !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        border: none !important;
        padding: 0.45rem 1rem !important;
        transition: all 0.2s ease;
    }
    .btn-peserta-kecamatan:hover {
        background-color: #f6e3a8 !important;
        color: #6e4a0a !important;
    }
    .btn-lihat-peserta {
        background-color: #eef6ff !important;
        color: #1b84ff !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        border: none !important;
        padding: 0.45rem 1.15rem !important;
        transition: all 0.2s ease;
    }
    .btn-lihat-peserta:hover {
        background-color: #dbeafe !important;
        color: #056ee9 !important;
    }
    .badge-skor-kelurahan {
        background-color: #eef6ff !important;
        color: #1b84ff !important;
        font-weight: 700 !important;
        border-radius: 0.45rem !important;
        padding: 0.35rem 0.75rem !important;
        display: inline-block;
        min-width: 48px;
    }
   .chart-container-scroll {
        position: relative;
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 8px;
    }
    .chart-container-scroll::-webkit-scrollbar {
        height: 8px;
    }
    .chart-container-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .chart-container-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .chart-container-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .chart-inner-wrapper {
        min-width: 100%;
        height: 380px;
        position: relative;
    }
    .elb { position: relative; display: flex; align-items: center; overflow: hidden; min-height: 210px; border-radius: 1rem; background: #eef0f8; box-shadow: 0 2px 10px rgba(30, 40, 60, 0.06); margin-bottom: .5rem; }
    .elb .ik-blob { fill: #dce0f0; } .elb .ik-blob2 { fill: #e4e6f3; } .elb .ik-shadow { fill: #d0d5eb; }
    .elb__tx { position: relative; z-index: 2; padding: 1.5rem 2.25rem; max-width: 62%; }
    .elb__kecil { font-size: .72rem; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; color: #5a67b5; margin-bottom: .5rem; }
    .elb__judul { font-size: 2rem; line-height: 1.15; font-weight: 800; color: #222745; margin: 0 0 .5rem; }
    .elb__desk { display: block; font-size: .95rem; font-weight: 500; color: #323964; }
    .elb__art { position: absolute; right: 0; bottom: 0; width: 370px; height: 206px; pointer-events: none; z-index: 1; }
    .elb__art svg { width: 100%; height: 100%; display: block; }
    @media (max-width: 991px) { .elb__art { width: 300px; height: 167px; } .elb__tx { max-width: 70%; } }
    @media (max-width: 767px) { .elb__art { display: none; } .elb__tx { max-width: 100%; padding: 1.25rem; } .elb__judul { font-size: 1.5rem; } }
    .ik-sub-aktif .banner-inovasi-kota, [class*="ik-aktif-"] .banner-inovasi-kota { display: none !important; }
</style>

<div class="elb d-none" id="elb-top">
    <div class="elb__tx">
        <div class="elb__kecil">Inovasi Kota</div>
        <h2 class="elb__judul">E-learning Puspaga PKK</h2>
        <span class="elb__desk">Pusat Pembelajaran Keluarga (Puspaga) PKK</span>
    </div>
    <div class="elb__art"><svg viewBox="0 0 370 206" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path class="ik-blob" d="M0 206 C8 112 70 66 170 56 C260 48 332 44 370 40 L370 206Z"/><circle class="ik-blob2" cx="248" cy="30" r="46"/><circle class="ik-blob2" cx="14" cy="186" r="14"/><ellipse class="ik-shadow" cx="185" cy="197" rx="158" ry="6.5"/><rect x="24" y="172" width="322" height="8" rx="4" fill="#cdd2e6" /><rect x="30" y="150" width="56" height="22" rx="3" fill="#5a67b5" /><rect x="40" y="160" width="24" height="2.5" rx="1" fill="#fff" opacity=".6"/><rect x="36" y="136" width="46" height="14" rx="3" fill="#e9b43b" /><rect x="44" y="142" width="18" height="2.5" rx="1" fill="#fff" opacity=".6"/><rect x="42" y="122" width="34" height="14" rx="3" fill="#e07a5f" /><rect x="173" y="142" width="16" height="24" rx="0" fill="#2b2f66" /><rect x="148" y="164" width="66" height="8" rx="4" fill="#2b2f66" /><rect x="106" y="48" width="150" height="96" rx="9" fill="#2b2f66" /><rect x="114" y="56" width="134" height="80" rx="4" fill="#fff" /><rect x="122" y="64" width="64" height="46" rx="5" fill="#e07a5f" /><polygon points="146,76 146,98 166,87" fill="#fff" /><rect x="122" y="118" width="64" height="4" rx="2" fill="#dfe3f2" /><rect x="122" y="118" width="26" height="4" rx="2" fill="#5a67b5" /><rect x="196" y="66" width="44" height="8" rx="3" fill="#e4e7f3" /><rect x="196" y="80" width="44" height="8" rx="3" fill="#e4e7f3" /><rect x="196" y="94" width="44" height="8" rx="3" fill="#e4e7f3" /><circle cx="232" cy="114" r="5.5" fill="#e9b43b" /><path d="M154 40 L154 54 Q181 66 208 54 L208 40Z" fill="#232a55" /><polygon points="181,14 234,32 181,50 128,32" fill="#2f3a6b" /><line x1="226" y1="34" x2="226" y2="54" stroke="#e9b43b" stroke-width="2" stroke-linecap="round" /><circle cx="226" cy="57" r="3.2" fill="#e9b43b" /><rect x="282" y="60" width="44" height="26" rx="6" fill="#fff" /><rect x="290" y="68" width="22" height="4" rx="2" fill="#5a67b5" /><rect x="290" y="76" width="14" height="3.5" rx="2" fill="#dfe3f2" /><path d="M306 126 C298 112 298 100 306 90 C314 100 314 112 306 126Z" fill="#5a67b5" /><path d="M306 164 C288 156 284 142 288 132 C300 136 306 148 306 164Z" fill="#e9b43b" /><path d="M306 164 C324 156 328 142 324 132 C312 136 306 148 306 164Z" fill="#e9b43b" /><path d="M306 164 C298 148 298 134 306 120 C314 134 314 148 306 164Z" fill="#5a67b5" /><polygon points="292,160 320,160 316,172 296,172" fill="#e07a5f" /></svg></div>
</div>

<div class="d-flex flex-column gap-5 w-100">
    <div class="d-flex flex-column">
        <h3 class="fw-bolder text-gray-900 fs-3 mb-1">SIAP PPAK</h3>
        <span class="text-gray-500 fs-7 fw-semibold">Dashboard Embed E-Learning PAAREDI</span>
    </div>

    <div class="card elearning-card-main">
        <div class="card-body p-5 p-lg-7">
            <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-4 mb-6">
                <div>
                    <h4 class="fw-bolder text-gray-900 fs-4 mb-1">
                        Skor Rata-Rata per Wilayah Peserta E-Learning PAAREDI
                    </h4>
                    <span class="text-gray-500 fs-7 fw-semibold">
                        Menampilkan skor rata-rata e-learning kader PKK per wilayah.
                    </span>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto" style="min-width: 300px;">
                    <select id="filter_elearning_kecamatan" class="form-select form-select-solid form-select-sm fw-semibold" onchange="filterWilayahElearning()">
                        <option value="all" selected>Semua Kecamatan</option>
                        <option value="ASEMROWO">Asemrowo</option>
                        <option value="BENOWO">Benowo</option>
                        <option value="BUBUTAN">Bubutan</option>
                        <option value="BULAK">Bulak</option>
                        <option value="DUKUH PAKIS">Dukuh Pakis</option>
                        <option value="GAYUNGAN">Gayungan</option>
                        <option value="GENTENG">Genteng</option>
                        <option value="GUBENG">Gubeng</option>
                        <option value="GUNUNG ANYAR">Gunung Anyar</option>
                        <option value="JAMBANGAN">Jambangan</option>
                        <option value="KARANG PILANG">Karang Pilang</option>
                        <option value="KENJERAN">Kenjeran</option>
                        <option value="KREMBANGAN">Krembangan</option>
                        <option value="LAKAR SANTRI">Lakar Santri</option>
                        <option value="MULYOREJO">Mulyorejo</option>
                        <option value="PABEAN CANTIAN">Pabean Cantian</option>
                        <option value="PAKAL">Pakal</option>
                        <option value="RUNGKUT">Rungkut</option>
                        <option value="SAMBI KEREP">Sambi Kerep</option>
                        <option value="SAWAHAN">Sawahan</option>
                        <option value="SEMAMPIR">Semampir</option>
                        <option value="SIMOKERTO">Simokerto</option>
                        <option value="SUKOLILO">Sukolilo</option>
                        <option value="SUKOMANUNGGAL">Sukomanunggal</option>
                        <option value="TAMBAKSARI">Tambaksari</option>
                        <option value="TANDES">Tandes</option>
                        <option value="TEGALSARI">Tegalsari</option>
                        <option value="TENGGILIS MEJOYO">Tenggilis Mejoyo</option>
                        <option value="WIYUNG">Wiyung</option>
                        <option value="WONOCOLO">Wonocolo</option>
                        <option value="WONOKROMO">Wonokromo</option>
                    </select>

                    <select id="filter_elearning_kelurahan" class="form-select form-select-solid form-select-sm fw-semibold" onchange="filterKelurahanElearning()">
                        <option value="all" selected>Semua Kelurahan</option>
                    </select>
                </div>
            </div>

            <div class="chart-container-scroll pb-2">
                <div class="chart-inner-wrapper">
                    <canvas id="chartElearningPaaredi"></canvas>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-gray-100">
                <span class="text-muted fs-8 fw-semibold" id="elearning-timestamp">
                    Pembaruan data: Memuat...
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalElearningKelurahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header pb-2 border-0 px-6 pt-6">
                <div>
                    <h4 class="modal-title fw-bolder text-gray-900 fs-4 mb-2">Daftar Kelurahan E-Learning PAAREDI</h4>
                    <span class="badge-kecamatan-info fs-7" id="modal_kecamatan_badge">Genteng</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-6 pb-6 pt-3">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 p-3 rounded-3 mb-4" style="background-color: #f4f5fb;">
                    <span class="text-gray-700 fw-bold fs-7">Pokja 1 Kecamatan</span>
                    <button type="button" class="btn-peserta-kecamatan fs-7 shadow-sm" onclick="bukaModalPesertaKecamatan()">
                        Lihat Peserta Kecamatan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-row-dashed table-hover align-middle gs-4 gy-3 my-0 fs-7">
                        <thead class="bg-light-subtle text-gray-600 fw-bold fs-8 text-uppercase border-bottom border-gray-200">
                            <tr>
                                <th class="w-40px text-center">No</th>
                                <th>Kelurahan</th>
                                <th class="text-center">Skor Rata-rata</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_daftar_kelurahan_body" class="fw-semibold text-gray-700"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalElearningPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header pb-2 border-0 px-6 pt-6">
                <div>
                    <h4 class="modal-title fw-bolder text-gray-900 fs-4 mb-2">Detail Peserta E-Learning PAAREDI</h4>
                    <div class="d-flex align-items-center gap-2" id="modal_peserta_badges">
                        <span class="badge-kecamatan-info fs-7" id="badge_peserta_kecamatan">Genteng</span>
                        <span class="badge-kelurahan-success fs-7 d-none" id="badge_peserta_kelurahan">Embong Kaliasin</span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-6 pb-6 pt-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle gs-4 gy-3 my-0 fs-7">
                        <thead class="bg-light-subtle text-gray-600 fw-bold fs-8 text-uppercase border-bottom border-gray-200">
                            <tr>
                                <th class="w-40px text-center">No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Materi</th>
                                <th class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_detail_peserta_body">
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400 fw-semibold fs-6">Belum ada data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between pt-5 mt-4 border-top border-gray-100">
                    <span class="text-gray-700 fw-bold fs-7" id="label_total_peserta">Total: 0 data</span>
                    <button type="button" class="btn btn-sm btn-light fw-bold rounded-2 px-5 text-gray-700 border" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script id="data-elearning-json" type="application/json">@json($elearningData ?? [])</script>

<script>
(function () {
    if (typeof window.Chart === 'undefined' && !document.getElementById('cdn-chartjs-elearning')) {
        var s = document.createElement('script');
        s.id = 'cdn-chartjs-elearning';
        s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js';
        s.onload = function () {
            if (typeof window.initElearningPuspaga === 'function') {
                window.initElearningPuspaga();
            }
        };
        document.head.appendChild(s);
    }
})();

const masterWilayahElearning = {
    'ASEMROWO': ['ASEMROWO', 'GENTING KALIANAK', 'TAMBAK SARIOSO'],
    'BENOWO': ['KANDANGAN', 'ROMOKALISARI', 'SEMEMI', 'TAMBAK OSOWILANGUN'],
    'BUBUTAN': ['ALUN-ALUN CONTONG', 'BUBUTAN', 'GUNDIH', 'JEPARA', 'TEMBOK DUKUH'],
    'BULAK': ['BULAK', 'KEDUNG COWEK', 'KENJERAN', 'SUKOLILO BARU'],
    'DUKUH PAKIS': ['DUKUH KUPANG', 'DUKUH PAKIS', 'GUNUNG SARI', 'PRADAHKALIKENDAL'],
    'GAYUNGAN': ['DUKUH MENANGGAL', 'GAYUNGAN', 'KETINTANG', 'MENANGGAL'],
    'GENTENG': ['EMBONG KALIASIN', 'GENTENG', 'KAPASARI', 'KETABANG', 'PENELEH'],
    'GUBENG': ['AIRLANGGA', 'BARATAJAYA', 'GUBENG', 'KERTAJAYA', 'MOJO', 'PUCANG SEWU'],
    'GUNUNG ANYAR': ['GUNUNG ANYAR', 'GUNUNG ANYAR TAMBAK', 'RUNGKUT MENANGGAL', 'RUNGKUT TENGAH'],
    'JAMBANGAN': ['JAMBANGAN', 'KARAH', 'KEBONSARI', 'PAGESANGAN'],
    'KARANG PILANG': ['KARANG PILANG', 'KEBRAON', 'KEDURUS', 'WARUGUNUNG'],
    'KENJERAN': ['BULAK BANTENG', 'SIDOTOPO WETAN', 'TAMBAK WEDI', 'TANAH KALI KEDINDING'],
    'KREMBANGAN': ['DUPAK', 'KEMAYORAN', 'KREMBANGAN SELATAN', 'MOROKREMBANGAN', 'PERAK BARAT'],
    'LAKAR SANTRI': ['BANGKINGAN', 'JERUK', 'LAKAR SANTRI', 'LIDAH KULON', 'LIDAH WETAN', 'SUMUR WELUT'],
    'MULYOREJO': ['DUKUH SUTOREJO', 'KALIJUDAN', 'KALISARI', 'KEJAWAN PUTIH TAMBAK', 'MANYAR SABRANGAN', 'MULYOREJO'],
    'PABEAN CANTIAN': ['BONGKARAN', 'KREMBANGAN UTARA', 'NYAMPLUNGAN', 'PERAK TIMUR', 'PERAK UTARA'],
    'PAKAL': ['BABAT JERAWAT', 'BENOWO', 'PAKAL', 'SUMBER REJO'],
    'RUNGKUT': ['KALI RUNGKUT', 'KEDUNG BARUK', 'MEDOKAN AYU', 'PENJARINGAN SARI', 'RUNGKUT KIDUL', 'WONOREJO'],
    'SAMBI KEREP': ['BRINGIN', 'LONTAR', 'MADE', 'SAMBIKEREP'],
    'SAWAHAN': ['BANYU URIP', 'KUPANG KRAJAN', 'PAKIS', 'PATEMON', 'PETEMON', 'PUTAT JAYA', 'SAWAHAN'],
    'SEMAMPIR': ['AMPEL', 'PEGIRIAN', 'SIDOTOPO', 'UJUNG', 'WONOKUSUMO'],
    'SIMOKERTO': ['KAPASAN', 'SIDODADI', 'SIMOKERTO', 'SIMOLAWANG', 'TAMBAKREJO'],
    'SUKOLILO': ['GEBANG PUTIH', 'KEPUTIH', 'KLAMPIS NGASEM', 'MEDOKAN SEMAMPIR', 'MENUR PUMPUNGAN', 'NGINDEN JANGKUNGAN', 'SEMOLOWARU'],
    'SUKOMANUNGGAL': ['PUTAT GEDE', 'SIMOMULYO', 'SIMOMULYO BARU', 'SONOKWIJENAN', 'SUKOMANUNGGAL', 'TANJUNGSARI'],
    'TAMBAKSARI': ['DUKUH SETRO', 'GADING', 'KAPASMADYA BARU', 'PACAR KELING', 'PACAR KEMBANG', 'PLOSO', 'RANGKAH', 'TAMBAKSARI'],
    'TANDES': ['BALONGSARI', 'BANJAR SUGIHAN', 'KARANGPOH', 'MANUKAN KULON', 'MANUKAN WETAN', 'TANDES'],
    'TEGALSARI': ['DR. SOETOMO', 'KEDUNGDORO', 'KEPUTRAN', 'TEGALSARI', 'WONOREJO'],
    'TENGGILIS MEJOYO': ['KENDANGSARI', 'KUTISARI', 'PANJANG JIWO', 'TENGGILIS MEJOYO'],
    'WIYUNG': ['BABATAN', 'BALAS KLUMPRIK', 'JAJAR TUNGGAL', 'WIYUNG'],
    'WONOCOLO': ['BENDUL MERISI', 'JEMUR WONOSARI', 'MARGOREJO', 'SIDOSERMO', 'SIWALANKERTO'],
    'WONOKROMO': ['DARMO', 'JAGIR', 'NGAGEL', 'NGAGELREJO', 'SAWUNGGALING', 'WONOKROMO']
};

let dbDummyElearning = [];
try {
    const rawJsonEl = document.getElementById('data-elearning-json');
    if (rawJsonEl && rawJsonEl.textContent.trim()) {
        dbDummyElearning = JSON.parse(rawJsonEl.textContent.trim());
    }
} catch (e) {
    dbDummyElearning = [];
}

if (!Array.isArray(dbDummyElearning) || dbDummyElearning.length === 0) {
    const materiFallback = [
        'Pola Asuh Anak dan Remaja di Era Digital (PAAREDI)',
        'Pencegahan Kekerasan Dalam Rumah Tangga (PKDRT)',
        'Pencegahan Perkawinan Anak & Stunting Keluarga',
        'Ketahanan Keluarga & Komunikasi Efektif Orang Tua',
        'Perlindungan Anak Terpadu Berbasis Masyarakat (PATBM)'
    ];
    const namaFallback = [
        'Siti Aminah', 'Sri Wahyuni', 'Nurul Hidayah', 'Endang Sulastri', 'Rina Marlina',
        'Dewi Sartika', 'Tri Rahayu', 'Yuni Astuti', 'Ratna Sari', 'Lilik Suryani'
    ];
    const skorPreset = [91.25, 85, 91.74, 94.38, 90, 94.42, 88.5, 92];
    dbDummyElearning = [];
    Object.entries(masterWilayahElearning).forEach(([kec, kelList], kecIdx) => {
        kelList.forEach((kel, kelIdx) => {
            const baseSkor = skorPreset[(kecIdx + kelIdx) % skorPreset.length];
            for (let i = 0; i < 4; i++) {
                dbDummyElearning.push({
                    kecamatan: kec,
                    kelurahan: kel,
                    nama_peserta: namaFallback[(kecIdx + kelIdx + i) % namaFallback.length],
                    nik: `3578${String(kecIdx + 10).padStart(2, '0')}450885${1000 + ((kecIdx * 31 + kelIdx * 7 + i) % 8999)}`,
                    materi: materiFallback[(kecIdx + i) % materiFallback.length],
                    skor: baseSkor
                });
            }
        });
    });
}

let chartElearningInstance = null;
let activeModalKecamatan = '';

function formatTitleCase(str) {
    return (str || '').toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}

function initElearningPuspaga() {
    updateTimestampElearning();
    renderGrafikElearning();
}

function updateTimestampElearning() {
    const el = document.getElementById('elearning-timestamp');
    if (!el) return;
    const now = new Date();
    const formatted = now.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    el.textContent = `Pembaruan data: ${formatted} WIB`;
}

function filterWilayahElearning() {
    const kecSelect = document.getElementById('filter_elearning_kecamatan');
    const kelSelect = document.getElementById('filter_elearning_kelurahan');
    const selectedKec = kecSelect ? kecSelect.value : 'all';

    if (kelSelect) {
        kelSelect.innerHTML = '<option value="all" selected>Semua Kelurahan</option>';
        if (selectedKec !== 'all' && masterWilayahElearning[selectedKec]) {
            masterWilayahElearning[selectedKec].forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = formatTitleCase(kel);
                kelSelect.appendChild(opt);
            });
        }
    }

    renderGrafikElearning();
}

function filterKelurahanElearning() {
    renderGrafikElearning();
}

function renderGrafikElearning() {
    const canvas = document.getElementById('chartElearningPaaredi');
    if (!canvas) return;
    if (typeof window.Chart === 'undefined') {
        setTimeout(renderGrafikElearning, 250);
        return;
    }

    const selectedKec = document.getElementById('filter_elearning_kecamatan')?.value || 'all';
    const selectedKel = document.getElementById('filter_elearning_kelurahan')?.value || 'all';

    let labels = [];
    let values = [];
    let levelWilayah = 'kecamatan';

    const cleanName = (str) => (str || '').toString().toUpperCase().trim();

    if (selectedKec === 'all') {
        levelWilayah = 'kecamatan';
        labels = Object.keys(masterWilayahElearning);
        values = labels.map(kec => {
            const rows = dbDummyElearning.filter(r => cleanName(r.kecamatan) === cleanName(kec));
            if (!rows.length) return 0;
            const avg = rows.reduce((sum, r) => sum + parseFloat(r.skor || 0), 0) / rows.length;
            return parseFloat(avg.toFixed(2));
        });
    } else if (selectedKel === 'all') {
        levelWilayah = 'kelurahan';
        labels = masterWilayahElearning[selectedKec] || [];
        values = labels.map(kel => {
            const rows = dbDummyElearning.filter(r => cleanName(r.kecamatan) === cleanName(selectedKec) && cleanName(r.kelurahan) === cleanName(kel));
            if (!rows.length) return 0;
            const avg = rows.reduce((sum, r) => sum + parseFloat(r.skor || 0), 0) / rows.length;
            return parseFloat(avg.toFixed(2));
        });
    } else {
        levelWilayah = 'kelurahan';
        labels = [selectedKel];
        const rows = dbDummyElearning.filter(r => cleanName(r.kecamatan) === cleanName(selectedKec) && cleanName(r.kelurahan) === cleanName(selectedKel));
        const avg = rows.length ? rows.reduce((sum, r) => sum + parseFloat(r.skor || 0), 0) / rows.length : 0;
        values = [parseFloat(avg.toFixed(2))];
    }

    const wrapper = canvas.parentElement;
    if (wrapper) {
        const dynamicWidth = Math.max(labels.length * 72, 600);
        wrapper.style.width = `${dynamicWidth}px`;
    }

    if (typeof Chart.getChart === 'function') {
        const prev = Chart.getChart(canvas);
        if (prev) prev.destroy();
    }
    if (chartElearningInstance) {
        try { chartElearningInstance.destroy(); } catch (e) {}
        chartElearningInstance = null;
    }

    const barValueLabelPlugin = {
        id: 'barValueLabelPlugin',
        afterDatasetsDraw(chart) {
            const { ctx, data } = chart;
            ctx.save();
            ctx.font = 'bold 11px Inter, sans-serif';
            ctx.fillStyle = '#334155';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';

            const meta = chart.getDatasetMeta(0);
            meta.data.forEach((bar, index) => {
                const rawVal = data.datasets[0].data[index];
                if (rawVal !== null && rawVal !== undefined && rawVal > 0) {
                    const formattedVal = Number.isInteger(rawVal) ? rawVal.toString() : parseFloat(rawVal.toFixed(2)).toString();
                    ctx.fillText(formattedVal, bar.x, bar.y - 6);
                }
            });
            ctx.restore();
        }
    };

    const ctx = canvas.getContext('2d');
    chartElearningInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(formatTitleCase),
            datasets: [{
                label: 'Skor Rata-Rata',
                data: values,
                backgroundColor: '#10b981',
                hoverBackgroundColor: '#059669',
                borderRadius: 0,
                barThickness: 32,
                maxBarThickness: 40
            }]
        },
        plugins: [barValueLabelPlugin],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            layout: {
                padding: {
                    top: 24,
                    right: 16
                }
            },
            onClick: (event, elements) => {
                if (!elements.length) return;
                const idx = elements[0].index;
                const clickedRawLabel = labels[idx];
                if (levelWilayah === 'kecamatan') {
                    bukaModalKelurahanElearning(clickedRawLabel);
                } else {
                    bukaModalPesertaKelurahan(selectedKec, clickedRawLabel);
                }
            },
            onHover: (event, elements) => {
                if (event.native && event.native.target) {
                    event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => ` Skor Rata-rata: ${ctx.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        color: '#64748b',
                        font: { size: 11 }
                    },
                    grid: { color: '#e2e8f0' }
                },
                x: {
                    ticks: {
                        color: '#475569',
                        font: { size: 11, weight: '600' },
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0
                    },
                    grid: {
                        display: true,
                        color: '#f1f5f9'
                    }
                }
            }
        }
    });
}

function bukaModalKelurahanElearning(kecamatan) {
    activeModalKecamatan = kecamatan;
    const badge = document.getElementById('modal_kecamatan_badge');
    const tbody = document.getElementById('tabel_daftar_kelurahan_body');
    if (badge) badge.textContent = formatTitleCase(kecamatan);
    if (!tbody) return;

    const cleanName = (str) => (str || '').toString().toUpperCase().trim();
    const kelList = masterWilayahElearning[cleanName(kecamatan)] || [];
    tbody.innerHTML = '';

    kelList.forEach((kel, idx) => {
        const pesertaKel = dbDummyElearning.filter(r => cleanName(r.kecamatan) === cleanName(kecamatan) && cleanName(r.kelurahan) === cleanName(kel));
        const rawAvg = pesertaKel.length
            ? pesertaKel.reduce((sum, r) => sum + parseFloat(r.skor || 0), 0) / pesertaKel.length
            : 0;
        const avgSkor = rawAvg === 0 ? '0' : (Number.isInteger(rawAvg) ? rawAvg.toString() : parseFloat(rawAvg.toFixed(2)).toString());

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-600">${idx + 1}</td>
            <td class="fw-bold text-gray-800">${formatTitleCase(kel)}</td>
            <td class="text-center">
                <span class="badge-skor-kelurahan">${avgSkor}</span>
            </td>
            <td class="text-center">
                <button type="button" class="btn-lihat-peserta fs-8" onclick="bukaModalPesertaKelurahan('${kecamatan}', '${kel}')">
                    Lihat Peserta
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const modalEl = document.getElementById('modalElearningKelurahan');
    if (modalEl && typeof bootstrap !== 'undefined') {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function bukaModalPesertaKecamatan() {
    if (!activeModalKecamatan) return;
    tampilkanModalPeserta(activeModalKecamatan, null);
}

function bukaModalPesertaKelurahan(kecamatan, kelurahan) {
    tampilkanModalPeserta(kecamatan, kelurahan);
}

function tampilkanModalPeserta(kecamatan, kelurahan) {
    const badgeKec = document.getElementById('badge_peserta_kecamatan');
    const badgeKel = document.getElementById('badge_peserta_kelurahan');
    const tbody = document.getElementById('tabel_detail_peserta_body');
    const totalLabel = document.getElementById('label_total_peserta');

    if (badgeKec) badgeKec.textContent = formatTitleCase(kecamatan);
    if (badgeKel) {
        if (kelurahan) {
            badgeKel.textContent = formatTitleCase(kelurahan);
            badgeKel.classList.remove('d-none');
        } else {
            badgeKel.classList.add('d-none');
        }
    }

    const cleanName = (str) => (str || '').toString().toUpperCase().trim();
    const filteredPeserta = dbDummyElearning.filter(r => {
        if (kelurahan) return cleanName(r.kecamatan) === cleanName(kecamatan) && cleanName(r.kelurahan) === cleanName(kelurahan);
        return cleanName(r.kecamatan) === cleanName(kecamatan);
    });

    if (tbody) {
        tbody.innerHTML = '';
        if (filteredPeserta.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center py-10 text-gray-400 fw-semibold">Belum ada data</td></tr>';
        } else {
            filteredPeserta.forEach((p, idx) => {
                const skorVal = parseFloat(p.skor || 0);
                const skorText = Number.isInteger(skorVal) ? skorVal.toString() : parseFloat(skorVal.toFixed(2)).toString();
                const tr = document.createElement('tr');
                tr.setAttribute('data-id', p.hash || '');
                tr.innerHTML = `
                    <td class="text-center text-gray-600">${idx + 1}</td>
                    <td class="fw-bold text-gray-800">${p.nama_peserta}</td>
                    <td class="text-gray-600">${p.nik}</td>
                    <td class="text-gray-700">${p.materi}</td>
                    <td class="text-center">
                        <span class="badge badge-light-primary fw-bolder px-3 py-2">${skorText}</span>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    }

    if (totalLabel) {
        totalLabel.textContent = `Total: ${filteredPeserta.length} data`;
    }

    const modalEl = document.getElementById('modalElearningPeserta');
    if (modalEl && typeof bootstrap !== 'undefined') {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

window.initElearningPuspaga = initElearningPuspaga;
window.filterWilayahElearning = filterWilayahElearning;
window.filterKelurahanElearning = filterKelurahanElearning;
window.bukaModalKelurahanElearning = bukaModalKelurahanElearning;
window.bukaModalPesertaKecamatan = bukaModalPesertaKecamatan;
window.bukaModalPesertaKelurahan = bukaModalPesertaKelurahan;

(function () {
    let lastVisibleState = false;

    function cekDanSinkron() {
        const canvas = document.getElementById('chartElearningPaaredi');
        const baru = document.getElementById('elb-top');
        const kontainer = document.getElementById('content-elearning-puspaga') || (canvas ? canvas.closest('.d-none, [id^="content-"]') : null);
        const area = document.getElementById('kt_app_content_container') || document.body;
        const pilihEl = document.getElementById('select-filter-inovasi');
        const sub = document.getElementById('banner-subtitle-inovasi');

        if (!document.getElementById('kb-banner') && baru && kontainer) {
            let titik = sub || pilihEl;
            if (titik && pilihEl) {
                while (titik.parentElement && !titik.parentElement.contains(pilihEl)) {
                    titik = titik.parentElement;
                }
            }
            if (titik && titik.parentNode && baru.parentNode !== titik.parentNode) {
                titik.parentNode.insertBefore(baru, titik);
            }
        }

        const isVisible = canvas ? canvas.offsetParent !== null : false;
        if (baru) {
            baru.classList.toggle('d-none', !isVisible);
        }
        area.classList.toggle('ik-aktif-elb', isVisible);

        if (isVisible && !lastVisibleState) {
            lastVisibleState = true;
            requestAnimationFrame(() => {
                initElearningPuspaga();
            });
        } else if (!isVisible) {
            lastVisibleState = false;
        }
    }

    setInterval(cekDanSinkron, 300);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', cekDanSinkron);
    } else {
        cekDanSinkron();
    }
})();
</script>