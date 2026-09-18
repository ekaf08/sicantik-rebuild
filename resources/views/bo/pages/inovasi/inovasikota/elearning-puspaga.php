<!-- STYLE KHUSUS E-LEARNING PAAREDI (SESUAI GAMBAR 1 - 5) -->
<style>
    .elearning-card-main {
        background: #ffffff;
        border-radius: 1rem !important;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    }
    .badge-kecamatan-info {
        background-color: #e0f2fe !important;
        color: #0284c7 !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
    }
    .badge-kelurahan-success {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        padding: 0.35rem 0.75rem !important;
    }
    .btn-peserta-kecamatan {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        border: none !important;
        padding: 0.45rem 1rem !important;
        transition: all 0.2s ease;
    }
    .btn-peserta-kecamatan:hover {
        background-color: #fde68a !important;
        color: #92400e !important;
    }
    .btn-lihat-peserta {
        background-color: #e0f2fe !important;
        color: #0284c7 !important;
        font-weight: 700 !important;
        border-radius: 0.5rem !important;
        border: none !important;
        padding: 0.35rem 0.85rem !important;
        transition: all 0.2s ease;
    }
    .btn-lihat-peserta:hover {
        background-color: #bae6fd !important;
        color: #0369a1 !important;
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
</style>

<!-- KONTEN INOVASI E-LEARNING PUSPAGA / PAAREDI -->
<div class="d-flex flex-column gap-5 w-100">

    <!-- Sub-header SIAP PPAK -->
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

<div class="modal fade" id="modalElearningKelurahan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            
            <div class="modal-header pb-2 border-0 px-6 pt-6">
                <div>
                    <h4 class="modal-title fw-bolder text-gray-900 fs-4 mb-2">Daftar Kelurahan E-Learning PAAREDI</h4>
                    <span class="badge-kecamatan-info fs-7" id="modal_kecamatan_badge">
                        Genteng
                    </span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-6 pb-6 pt-3">
                <!-- Sub Bar: Label Pokja & Tombol Kuning Lembut -->
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 p-3 rounded-3 mb-4" style="background-color: #f8fafc;">
                    <span class="text-gray-700 fw-bold fs-7">Pokja 1 Kecamatan</span>
                    <button type="button" class="btn-peserta-kecamatan fs-7 shadow-sm" onclick="bukaModalPesertaKecamatan()">
                        Lihat Peserta Kecamatan
                    </button>
                </div>

                <!-- Tabel Kelurahan -->
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
                        <tbody id="tabel_daftar_kelurahan_body" class="fw-semibold text-gray-700">
                            <!-- Diinjeksi dinamis via JS -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL LEVEL 2: DETAIL PESERTA (GAMBAR 4 & 5) -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalElearningPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            
            <div class="modal-header pb-2 border-0 px-6 pt-6">
                <div>
                    <h4 class="modal-title fw-bolder text-gray-900 fs-4 mb-2">Detail Peserta E-Learning PAAREDI</h4>
                    <div class="d-flex align-items-center gap-2" id="modal_peserta_badges">
                        <span class="badge-kecamatan-info fs-7" id="badge_peserta_kecamatan">
                            Genteng
                        </span>
                        <span class="badge-kelurahan-success fs-7 d-none" id="badge_peserta_kelurahan">
                            Embong Kaliasin
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-6 pb-6 pt-3">
                <!-- Tabel Peserta -->
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
                            <!-- State default kosong -->
                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400 fw-semibold fs-6">
                                    Belum ada data
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Modal Peserta: Total Data & Tombol Tutup -->
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