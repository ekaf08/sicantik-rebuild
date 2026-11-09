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
        background-color: #dfe3f5 !important;
        color: #3d4a9c !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        border: none !important;
        padding: 0.35rem 0.85rem !important;
        transition: all 0.2s ease;
    }
    .btn-lihat-peserta:hover {
        background-color: #cbd1ee !important;
        color: #2b3585 !important;
    }
    .chart-container-scroll {
        position: relative;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .chart-inner-wrapper {
        min-width: 820px;
        height: 380px;
        position: relative;
    }
    /* Banner E-learning Puspaga PKK: dipindah ke paling atas halaman oleh skrip di bawah */
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

<!-- Banner E-learning Puspaga PKK (dipindah ke atas halaman oleh skrip di akhir file) -->
<div class="elb d-none" id="elb-top">
    <div class="elb__tx">
        <div class="elb__kecil">Inovasi Kota</div>
        <h2 class="elb__judul">E-learning Puspaga PKK</h2>
        <span class="elb__desk">Pusat Pembelajaran Keluarga (Puspaga) PKK</span>
    </div>
    <div class="elb__art"><svg viewBox="0 0 370 206" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path class="ik-blob" d="M0 206 C8 112 70 66 170 56 C260 48 332 44 370 40 L370 206Z"/><circle class="ik-blob2" cx="248" cy="30" r="46"/><circle class="ik-blob2" cx="14" cy="186" r="14"/><ellipse class="ik-shadow" cx="185" cy="197" rx="158" ry="6.5"/><rect x="24" y="172" width="322" height="8" rx="4" fill="#cdd2e6" /><rect x="30" y="150" width="56" height="22" rx="3" fill="#5a67b5" /><rect x="40" y="160" width="24" height="2.5" rx="1" fill="#fff" opacity=".6"/><rect x="36" y="136" width="46" height="14" rx="3" fill="#e9b43b" /><rect x="44" y="142" width="18" height="2.5" rx="1" fill="#fff" opacity=".6"/><rect x="42" y="122" width="34" height="14" rx="3" fill="#e07a5f" /><rect x="173" y="142" width="16" height="24" rx="0" fill="#2b2f66" /><rect x="148" y="164" width="66" height="8" rx="4" fill="#2b2f66" /><rect x="106" y="48" width="150" height="96" rx="9" fill="#2b2f66" /><rect x="114" y="56" width="134" height="80" rx="4" fill="#fff" /><rect x="122" y="64" width="64" height="46" rx="5" fill="#e07a5f" /><polygon points="146,76 146,98 166,87" fill="#fff" /><rect x="122" y="118" width="64" height="4" rx="2" fill="#dfe3f2" /><rect x="122" y="118" width="26" height="4" rx="2" fill="#5a67b5" /><rect x="196" y="66" width="44" height="8" rx="3" fill="#e4e7f3" /><rect x="196" y="80" width="44" height="8" rx="3" fill="#e4e7f3" /><rect x="196" y="94" width="44" height="8" rx="3" fill="#e4e7f3" /><circle cx="232" cy="114" r="5.5" fill="#e9b43b" /><path d="M154 40 L154 54 Q181 66 208 54 L208 40Z" fill="#232a55" /><polygon points="181,14 234,32 181,50 128,32" fill="#2f3a6b" /><line x1="226" y1="34" x2="226" y2="54" stroke="#e9b43b" stroke-width="2" stroke-linecap="round" /><circle cx="226" cy="57" r="3.2" fill="#e9b43b" /><rect x="282" y="60" width="44" height="26" rx="6" fill="#fff" /><rect x="290" y="68" width="22" height="4" rx="2" fill="#5a67b5" /><rect x="290" y="76" width="14" height="3.5" rx="2" fill="#dfe3f2" /><path d="M306 126 C298 112 298 100 306 90 C314 100 314 112 306 126Z" fill="#5a67b5" /><path d="M306 164 C288 156 284 142 288 132 C300 136 306 148 306 164Z" fill="#e9b43b" /><path d="M306 164 C324 156 328 142 324 132 C312 136 306 148 306 164Z" fill="#e9b43b" /><path d="M306 164 C298 148 298 134 306 120 C314 134 314 148 306 164Z" fill="#5a67b5" /><polygon points="292,160 320,160 316,172 296,172" fill="#e07a5f" /></svg></div>
</div>

<!-- KONTEN INOVASI E-LEARNING PUSPAGA / PAAREDI -->
<div class="d-flex flex-column gap-5 w-100">
    <div class="d-flex flex-column">
        <h3 class="fw-bolder text-gray-900 fs-3 mb-1">SIAP PPAK</h3>
        <span class="text-gray-500 fs-7 fw-semibold">Dashboard Embed E-Learning PAAREDI</span>
    </div>

    <!-- Card Utama: Grafik & Filter Wilayah -->
    <div class="card elearning-card-main">
        <div class="card-body p-5 p-lg-7">

            <!-- Header Card & Filter Kanan Atas -->
            <div class="d-flex flex-column flex-md-row align-items-md-start justify-content-between gap-4 mb-6">
                <div>
                    <h4 class="fw-bolder text-gray-900 fs-4 mb-1">
                        Skor Rata-Rata per Wilayah Peserta E-Learning PAAREDI
                    </h4>
                    <span class="text-gray-500 fs-7 fw-semibold">
                        Menampilkan skor rata-rata e-learning kader PKK per wilayah.
                    </span>
                </div>

                <!-- Dropdown Filter Wilayah Sebelah Kanan Sesuai Gambar 1 -->
                <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto" style="min-width: 300px;">
                    <select id="filter_elearning_kecamatan" class="form-select form-select-solid form-select-sm fw-semibold" onchange="filterWilayahElearning()">
                        <option value="all" selected>Semua Kecamatan</option>
                        <option value="Asem Rowo">Asem Rowo</option>
                        <option value="Benowo">Benowo</option>
                        <option value="Bubutan">Bubutan</option>
                        <option value="Bulak">Bulak</option>
                        <option value="Dukuh Pakis">Dukuh Pakis</option>
                        <option value="Gayungan">Gayungan</option>
                        <option value="Genteng">Genteng</option>
                        <option value="Gubeng">Gubeng</option>
                        <option value="Gunung Anyar">Gunung Anyar</option>
                    </select>

                    <select id="filter_elearning_kelurahan" class="form-select form-select-solid form-select-sm fw-semibold" onchange="filterKelurahanElearning()">
                        <option value="all" selected>Semua Kelurahan</option>
                    </select>
                </div>
            </div>

            <!-- Canvas Grafik Batang Hijau Toska -->
            <div class="chart-container-scroll pb-2">
                <div class="chart-inner-wrapper">
                    <canvas id="chartElearningPaaredi"></canvas>
                </div>
            </div>

            <!-- Footer Timestamp Pembaruan Data -->
            <div class="mt-4 pt-3 border-top border-gray-100">
                <span class="text-muted fs-8 fw-semibold" id="elearning-timestamp">
                    Pembaruan data: Memuat...
                </span>
            </div>

        </div>
    </div>
</div>
</div>

<div class="modal fade" id="modalElearningKelurahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
            <div class="modal-header pb-2 border-0 px-6 pt-6">
                <div>
                    <h4 class="modal-title fw-bolder text-gray-900 fs-4 mb-2">Daftar Kelurahan E-Learning PAAREDI</h4>
                    <span class="badge-kecamatan-info fs-7" id="modal_kecamatan_badge">Genteng</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-6 pb-6 pt-3">
                <!-- Sub Bar: Label Pokja & Tombol Kuning Lembut -->
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
                                <th class="text-end pe-4">Aksi</th>
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

<script>
(function () {
    function mulai() {
        if (document.getElementById('kb-banner')) return; // sudah ditangani index.blade.php
        var baru = document.getElementById('elb-top');
        var kontainer = document.getElementById('content-elearning-puspaga');
        var area = document.getElementById('kt_app_content_container') || document.body;
        var pilihEl = document.getElementById('select-filter-inovasi');
        var sub = document.getElementById('banner-subtitle-inovasi');
        if (!baru || !kontainer) return;
        var titik = sub || pilihEl;
        if (titik && pilihEl) { while (titik.parentElement && !titik.parentElement.contains(pilihEl)) titik = titik.parentElement; }
        if (titik && titik.parentNode) titik.parentNode.insertBefore(baru, titik);

        function sinkron() {
            var tampil = kontainer.offsetParent !== null;
            baru.classList.toggle('d-none', !tampil);
            area.classList.toggle('ik-aktif-elb', tampil);
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
