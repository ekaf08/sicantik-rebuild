<!-- Load Library SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Card Kategori Pisang Danor */
    .card-kategori-danor {
        border-radius: 16px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        user-select: none;
    }
    .card-kategori-danor:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .card-anorganik.active-kategori {
        border: 2px solid #3b82f6 !important;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25) !important;
        transform: translateY(-2px);
    }
    .card-organik.active-kategori {
        border: 2px solid #22c55e !important;
        box-shadow: 0 8px 24px rgba(34, 197, 94, 0.25) !important;
        transform: translateY(-2px);
    }
    .header-anorganik {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
    }
    .header-organik {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
    }

    /* Style Si Basam */
    .basam-card {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        overflow: hidden;
        background: #fff;
    }
    .basam-header-pilah {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    }
    .basam-header-bank {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .basam-header-tonase {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .basam-header-paving {
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
    }
    .basam-clickable {
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: background-color 0.2s ease, transform 0.15s ease;
    }
    .basam-clickable:hover {
        background-color: rgba(13, 148, 136, 0.08);
        transform: scale(1.02);
    }

    /* Preview foto & checkbox organik */
    .pd-photo-box {
        border: 1px solid #e4e6ef; border-radius: .75rem; background: #f8f9fb;
        display: flex; align-items: center; justify-content: center; overflow: hidden; height: 150px;
    }
    .pd-photo-box img { width: 100%; height: 100%; object-fit: cover; }
    .pd-checkbox-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: .5rem .75rem; }
    .pd-checkbox-item { display: flex; align-items: center; gap: .5rem; font-size: .85rem; font-weight: 600; color: #4b5675; cursor: pointer; }
</style>

<!-- Banner Deskripsi Inovasi Pisang Danor -->
<div class="card card-flush border-0 mb-6" style="background-color: #f0f6ff !important; border-radius: 16px;">
    <div class="card-body p-6 p-md-7">
        <h4 class="fw-bolder text-gray-900 mb-3 fs-3">Inovasi Pisang Danor (Pilah Sampah Anorganik dan Organik)</h4>
        <p class="text-gray-700 fs-7 mb-3" style="line-height: 1.7;">
            Pisang Danor merupakan inovasi yang bertujuan untuk mendorong pemilahan sampah organik dan anorganik sejak dari sumbernya. Melalui pemilahan ini, jumlah dan tonase sampah dapat dimonitor dengan lebih baik, sehingga pengelolaan sampah menjadi lebih terarah dan terukur.
        </p>
        <p class="text-gray-700 fs-7 mb-0" style="line-height: 1.7;">
            Sampah organik yang terkumpul dapat diolah menjadi kompos, maggot, atau produk bermanfaat lainnya, sedangkan sampah anorganik dapat didaur ulang menjadi bahan bernilai ekonomi. Dengan adanya inovasi Pisang Danor, diharapkan kesadaran masyarakat terhadap pengelolaan sampah meningkat dan lingkungan menjadi lebih bersih serta berkelanjutan.
        </p>
    </div>
</div>

<!-- Section Utama Header Navigation -->
<div class="card card-flush border-0 shadow-sm rounded-4 mb-6">
    <div class="card-header align-items-center border-0 pt-6 px-6">
        <h3 class="card-title fw-bolder text-gray-900 fs-3 m-0" id="main-section-title">Pelatihan Inovasi Pisang Danor (Pilah Sampah Anorganik dan Organik)</h3>
        <div class="card-toolbar">
            <ul class="nav nav-pills nav-line-tabs border-0 fs-7 fw-bold">
                <li class="nav-item">
                    <a class="nav-link active px-4 py-2 cursor-pointer" id="tab-btn-danor" onclick="switchMainTabDanor('danor')">PISANG DANOR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-4 py-2 cursor-pointer text-gray-500" id="tab-btn-basam" onclick="switchMainTabDanor('basam')">SI BASAM</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-body p-6">

        <!-- ================================================================= -->
        <!-- TAB 1: PISANG DANOR (ANORGANIK & ORGANIK) -->
        <!-- ================================================================= -->
        <div id="view-section-pisang-danor">
            <!-- Grid 2 Kartu Interaktif: Anorganik & Organik -->
            <div class="row g-4 justify-content-center mb-6">
                <!-- Kartu ANORGANIK (Biru) -->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card card-kategori-danor card-anorganik active-kategori overflow-hidden h-100 border" id="card-btn-anorganik" onclick="pilihKategoriDanor('anorganik')">
                        <div class="header-anorganik text-white text-center py-4 px-3">
                            <h4 class="fw-bolder text-white m-0 fs-3 tracking-wide">ANORGANIK</h4>
                        </div>
                        <div class="card-body p-5 text-center d-flex align-items-center justify-content-center" style="background-color: #f8fafc;">
                            <p class="text-gray-700 fw-semibold fs-7 mb-0" style="line-height: 1.6;">
                                Pelatihan pengolahan bahan non-alami seperti plastik & limbah keras
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Kartu ORGANIK (Hijau) -->
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card card-kategori-danor card-organik overflow-hidden h-100 border" id="card-btn-organik" onclick="pilihKategoriDanor('organik')">
                        <div class="header-organik text-white text-center py-4 px-3">
                            <h4 class="fw-bolder text-white m-0 fs-3 tracking-wide">ORGANIK</h4>
                        </div>
                        <div class="card-body p-5 text-center d-flex align-items-center justify-content-center" style="background-color: #f8fafc;">
                            <p class="text-gray-700 fw-semibold fs-7 mb-0" style="line-height: 1.6;">
                                Pelatihan pemanfaatan bahan alami seperti tanaman & limbah organik
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tabel Data (Anorganik / Organik) -->
            <div class="border-top pt-6">
                <input type="hidden" id="pd-csrf-token" value="{{ csrf_token() }}">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
                    <div>
                        <h3 class="fw-bolder text-gray-900 fs-3 m-0" id="title-tabel-danor">Data Pisang BSI (Anorganik)</h3>
                        <span class="text-gray-500 fs-8 fw-semibold" id="subtitle-tabel-danor">Menampilkan daftar data pengolahan sampah anorganik</span>
                    </div>

                    <button type="button" class="btn fw-bold fs-7 px-5 text-white rounded-3 shadow-sm" style="background-color: #22c55e !important;" onclick="openTambahDanor()">
                        <i class="ki-outline ki-plus fs-3 text-white me-1"></i> Tambah Data
                    </button>
                </div>

                <!-- Filter -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7 fw-semibold">Tampilkan</span>
                        <select class="form-select form-select-solid w-75px fs-7 fw-bold" id="pagesize-danor">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">
                        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kecamatan-danor">
                            <option value="">Semua Kecamatan</option>
                        </select>

                        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kelurahan-danor" disabled>
                            <option value="">Semua Kelurahan</option>
                        </select>

                        <div class="d-flex align-items-center position-relative">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3 text-gray-500"></i>
                            <input type="text" id="search-danor" class="form-control form-control-solid ps-10 w-200px fs-7 fw-semibold" placeholder="Cari..." />
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed table-bordered fs-7 gy-3 gs-4">
                        <thead id="thead-danor"></thead>
                        <tbody class="fw-semibold text-gray-700" id="tbody-danor">
                            <tr><td class="text-center py-5 text-gray-500">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4">
                    <span class="text-gray-600 fs-8 fw-semibold" id="info-danor"></span>
                    <ul class="pagination pagination-outline mb-0" id="pagination-danor"></ul>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- TAB 2: SI BASAM -->
        <!-- ================================================================= -->
        <div id="view-section-si-basam" class="d-none">
            <div class="row g-3 align-items-end mb-5">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold fs-7">Kecamatan</label>
                    <select id="basam-kecamatan" class="form-select form-select-solid">
                        <option value="" selected>- Pilih Kecamatan -</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold fs-7">Kelurahan</label>
                    <select id="basam-kelurahan" class="form-select form-select-solid" disabled>
                        <option value="" selected>-- Pilih Kelurahan --</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-primary w-100 fw-bold" style="background-color: #0d9488 !important; border-color: #0d9488 !important;" onclick="basamFilterDanor()">Filter</button>
                </div>
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-light w-100 fw-semibold" onclick="basamResetDanor()">Reset</button>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="basam-card h-100 shadow-sm">
                        <div class="basam-header-pilah text-white text-center py-3">
                            <h5 class="fw-bolder text-white m-0 tracking-wider">PILAH</h5>
                        </div>
                        <div class="card-body p-5">
                            <div class="row text-center align-items-center">
                                <div class="col-6 border-end basam-clickable" onclick="openEmptyPopUp('Data Pilah Sampah - SUDAH', 'Rincian data warga/wilayah yang SUDAH melakukan pemilahan sampah')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">SUDAH</span>
                                    <div class="fs-2hx fw-bolder my-1" style="color: #10b981;" id="basam-pilah-sudah-tonase">0</div>
                                    <span class="fs-1 fw-bolder text-success" id="basam-pilah-sudah-count">0</span>
                                </div>
                                <div class="col-6 basam-clickable" onclick="openEmptyPopUp('Data Pilah Sampah - BELUM', 'Rincian data warga/wilayah yang BELUM melakukan pemilahan sampah')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM</span>
                                    <div class="fs-2hx fw-bolder text-danger my-1" id="basam-pilah-belum-tonase">0</div>
                                    <span class="fs-1 fw-bolder text-danger" id="basam-pilah-belum-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="basam-card h-100 shadow-sm">
                        <div class="basam-header-bank text-white text-center py-3">
                            <h5 class="fw-bolder text-white m-0 tracking-wider">BANK SAMPAH</h5>
                        </div>
                        <div class="card-body p-5">
                            <div class="row text-center align-items-center">
                                <div class="col-6 border-end basam-clickable" onclick="openEmptyPopUp('Data Bank Sampah - SUDAH ADA', 'Rincian lokasi & daftar Bank Sampah yang SUDAH ADA')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">SUDAH ADA</span>
                                    <div class="fs-2hx fw-bolder my-2" style="color: #10b981;" id="basam-bank-ada">0</div>
                                </div>
                                <div class="col-6 basam-clickable" onclick="openEmptyPopUp('Data Bank Sampah - BELUM ADA', 'Rincian wilayah/RT/RW yang BELUM ADA Bank Sampah')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM ADA</span>
                                    <div class="fs-2hx fw-bolder text-danger my-2" id="basam-bank-belum">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="basam-card h-100 shadow-sm basam-clickable" onclick="openEmptyPopUp('Data Tonase An-Organik', 'Rincian akumulasi tonase sampah anorganik (Kg)')">
                        <div class="basam-header-tonase text-white text-center py-3">
                            <h5 class="fw-bolder text-white m-0 tracking-wider">TONASE AN-ORGANIK</h5>
                        </div>
                        <div class="card-body p-5 text-center">
                            <div class="fs-2hx fw-bolder text-gray-900 mt-1" id="basam-tonase-anorganik">0</div>
                            <span class="fs-8 fw-bold text-gray-500 text-uppercase">Kg</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="basam-card h-100 shadow-sm">
                        <div class="basam-header-paving text-white text-center py-3">
                            <h5 class="fw-bolder text-white m-0 tracking-wider">PAVING</h5>
                        </div>
                        <div class="card-body p-5">
                            <div class="row text-center align-items-center">
                                <div class="col-4 border-end basam-clickable" onclick="openEmptyPopUp('Data Paving - JUMLAH', 'Rincian total titik paving')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">JUMLAH</span>
                                    <div class="fs-2hx fw-bolder text-gray-900 mt-1" id="basam-paving-total">0</div>
                                </div>
                                <div class="col-4 border-end basam-clickable" onclick="openEmptyPopUp('Data Paving - SUDAH BIOPORI', 'Rincian titik paving yang SUDAH memiliki biopori')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">SUDAH BIOPORI</span>
                                    <div class="fs-2hx fw-bolder my-1" style="color: #10b981;" id="basam-paving-sudah">0</div>
                                </div>
                                <div class="col-4 basam-clickable" onclick="openEmptyPopUp('Data Paving - BELUM BIOPORI', 'Rincian titik paving yang BELUM memiliki biopori')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM BIOPORI</span>
                                    <div class="fs-2hx fw-bolder text-danger mt-1" id="basam-paving-belum">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================= -->
<!-- MODAL TAMBAH DATA ANORGANIK (Pisang BSI) -->
<!-- ================================================================= -->
<div class="modal fade" id="modal_tambah_danor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Tambah Data Pisang BSI (Anorganik)</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-tambah-danor" enctype="multipart/form-data">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA BSI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="nama_bsi" placeholder="Masukkan Nama BSI" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">METODE PENGOLAHAN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="metode_pengolahan" placeholder="misal: Kompos / Daur Ulang Plastik" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">ALAMAT BSI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" name="alamat_bsi" placeholder="Masukkan Alamat Lengkap BSI" required />
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kecamatan" id="modal-kecamatan-danor" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kelurahan" id="modal-kelurahan-danor" required disabled>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="rw" placeholder="01" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="rt" placeholder="02" required />
                        </div>
                    </div>

                    <div class="row g-4 mb-2">
                        <div class="col-6"><div class="pd-photo-box" id="pd-add-preview-1"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                        <div class="col-6"><div class="pd-photo-box" id="pd-add-preview-2"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 1</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" name="upload_file_1" data-preview="pd-add-preview-1" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 2</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" name="upload_file_2" data-preview="pd-add-preview-2" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white" style="background-color: #22c55e !important;">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================= -->
<!-- MODAL EDIT DATA ANORGANIK (Pisang BSI) -->
<!-- ================================================================= -->
<div class="modal fade" id="modal_edit_danor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Edit Data Pisang BSI (Anorganik)</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-edit-danor" enctype="multipart/form-data">
                    <input type="hidden" id="edit-id-danor" />

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA BSI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="edit-nama-bsi" name="nama_bsi" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">METODE PENGOLAHAN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="edit-metode-pengolahan" name="metode_pengolahan" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">ALAMAT BSI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" id="edit-alamat-bsi" name="alamat_bsi" required />
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="edit-kecamatan-danor" name="kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="edit-kelurahan-danor" name="kelurahan" required>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="edit-rw" name="rw" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="edit-rt" name="rt" required />
                        </div>
                    </div>

                    <div class="row g-4 mb-2">
                        <div class="col-6"><div class="pd-photo-box" id="pd-edit-preview-1"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                        <div class="col-6"><div class="pd-photo-box" id="pd-edit-preview-2"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 1 (Opsional)</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" id="edit-file-1" name="upload_file_1" data-preview="pd-edit-preview-1" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 2 (Opsional)</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" id="edit-file-2" name="upload_file_2" data-preview="pd-edit-preview-2" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold px-6">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================= -->
<!-- MODAL TAMBAH / EDIT DATA ORGANIK -->
<!-- ================================================================= -->
<div class="modal fade" id="modal_organik_danor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3" id="po-title">Tambah Data Pisang Organik</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-organik-danor" enctype="multipart/form-data">
                    <input type="hidden" id="po-id" />

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="po-kecamatan" name="kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="po-kelurahan" name="kelurahan" required disabled>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW</label>
                            <input type="text" class="form-control form-control-solid" id="po-rw" name="rw" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT</label>
                            <input type="text" class="form-control form-control-solid" id="po-rt" name="rt" />
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Jumlah Tonase (Kg) <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="po-tonase" name="jumlah_tonase" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Tonase Residu (Kg) <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="po-residu" name="tonase_residu" required />
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Sampah Terolah Anorganik (Kg)</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="po-terolah-anorganik" name="sampah_terolah_anorganik" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Sampah Terolah Organik (Kg)</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="po-terolah-organik" name="sampah_terolah_organik" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700 mb-2">Metode Pengolahan Sampah</label>
                        <div class="pd-checkbox-grid">
                            @foreach(['KOMPOSTING','BIOPORI','MAGGOT','BANK SAMPAH','DAUR ULANG','TPS3R','ECOBRICK','INSINERATOR','RDF','PIROLISIS','GASIFIKASI','LANDFILL','CO PROCESSING','LAINNYA'] as $metode)
                                <label class="pd-checkbox-item">
                                    <input type="checkbox" class="form-check-input po-metode" value="{{ $metode }}">
                                    {{ $metode }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- BOX PREVIEW FOTO ORGANIK -->
                    <div class="row g-4 mb-2">
                        <div class="col-6"><div class="pd-photo-box" id="po-preview-1"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                        <div class="col-6"><div class="pd-photo-box" id="po-preview-2"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div></div>
                    </div>

                    <!-- INPUT UPLOAD FOTO ORGANIK -->
                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 1</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" id="po-file-1" name="upload_file_1" data-preview="po-preview-1" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 2</label>
                            <input type="file" class="form-control form-control-solid pd-foto-input" id="po-file-2" name="upload_file_2" data-preview="po-preview-2" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">Maksimal 2MB (jpg, png, jpeg).</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white" style="background-color: #22c55e !important;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-Up Kosong Universal -->
<div class="modal fade" id="modalPopUpKosong" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-bottom py-4 px-6">
                <div>
                    <h3 id="popup-title" class="modal-title fw-bolder text-gray-900 fs-4">Judul Pop Up</h3>
                    <p id="popup-subtitle" class="text-muted fs-8 mb-0">Subjudul keterangan pop up</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8 text-center">
                <div class="py-10 border border-dashed border-gray-300 rounded-4 bg-light-subtle">
                    <i class="ki-outline ki-folder-down fs-3x text-gray-400 mb-3"></i>
                    <h5 class="fw-bold text-gray-700 mb-1">Belum Ada Data Tersedia</h5>
                    <p class="text-gray-500 fs-8 mb-0">Konten detail untuk kategori ini akan ditampilkan di sini.</p>
                </div>
            </div>
            <div class="modal-footer border-top py-3 px-6">
                <button type="button" class="btn btn-light fs-7 fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    let wilayah = {};
    let kategori = 'anorganik';
    let dataBsi = [];
    let dataOrganik = [];
    let page = 1;

    const csrf = document.getElementById('pd-csrf-token').value;
    const $ = function (id) { return document.getElementById(id); };
    const EMPTY_IMG = '<i class="ki-outline ki-picture fs-3x text-gray-300"></i>';

    function esc(v) {
        if (v === null || v === undefined) return '';
        return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function num(v) { return Number(v) || 0; }
    function fmt(v) { return num(v).toLocaleString('id-ID', { maximumFractionDigits: 2 }); }

    function api(url, options) {
        options = options || {};
        options.headers = Object.assign({ 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }, options.headers || {});
        return fetch(url, options).then(function (res) {
            return res.json().catch(function () { return {}; }).then(function (body) {
                if (!res.ok) {
                    let msg = body.message || 'Terjadi kesalahan.';
                    if (body.errors) msg = Object.values(body.errors)[0][0];
                    throw new Error(msg);
                }
                return body;
            });
        });
    }

    function sukses(teks) {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: teks, showConfirmButton: false, timer: 2000, customClass: { popup: 'rounded-4' } });
    }
    function gagal(teks) {
        Swal.fire({ icon: 'error', title: 'Gagal', text: teks, customClass: { popup: 'rounded-4' } });
    }
    function modal(id) { return bootstrap.Modal.getOrCreateInstance($(id)); }

    function isiKecamatan(select, placeholder, disabledPlaceholder) {
        select.innerHTML = '<option value=""' + (disabledPlaceholder ? ' selected disabled' : '') + '>' + placeholder + '</option>';
        Object.keys(wilayah).sort().forEach(function (k) { select.appendChild(new Option(k, k)); });
    }
    function isiKelurahan(select, kec, placeholder, disabledPlaceholder, terpilih) {
        select.innerHTML = '<option value=""' + (disabledPlaceholder ? ' selected disabled' : '') + '>' + placeholder + '</option>';
        const list = wilayah[kec] || [];
        list.forEach(function (k) { select.appendChild(new Option(k, k)); });
        select.disabled = list.length === 0;
        if (terpilih) select.value = terpilih;
    }

    function initWilayah() {
        // Dropdown Filter Tabel Utama
        isiKecamatan($('filter-kecamatan-danor'), 'Semua Kecamatan', false);
        $('filter-kecamatan-danor').addEventListener('change', function () {
            isiKelurahan($('filter-kelurahan-danor'), this.value, 'Semua Kelurahan', false);
            page = 1; render();
        });
        $('filter-kelurahan-danor').addEventListener('change', function () { page = 1; render(); });

        // Modal Tambah Anorganik
        isiKecamatan($('modal-kecamatan-danor'), 'Pilih Kecamatan', true);
        $('modal-kecamatan-danor').addEventListener('change', function () {
            isiKelurahan($('modal-kelurahan-danor'), this.value, 'Pilih Kelurahan', true);
        });

        // Modal Edit Anorganik
        isiKecamatan($('edit-kecamatan-danor'), 'Pilih Kecamatan', true);
        $('edit-kecamatan-danor').addEventListener('change', function () {
            isiKelurahan($('edit-kelurahan-danor'), this.value, 'Pilih Kelurahan', true);
        });

        // Modal Organik (Tambah & Edit)
        isiKecamatan($('po-kecamatan'), 'Pilih Kecamatan', true);
        $('po-kecamatan').addEventListener('change', function () {
            isiKelurahan($('po-kelurahan'), this.value, 'Pilih Kelurahan', true);
        });

        // Dropdown SI BASAM
        isiKecamatan($('basam-kecamatan'), '- Pilih Kecamatan -', false);
        $('basam-kecamatan').addEventListener('change', function () {
            isiKelurahan($('basam-kelurahan'), this.value, '-- Pilih Kelurahan --', false);
            hitungSiBasam();
        });
        $('basam-kelurahan').addEventListener('change', function () { hitungSiBasam(); });
    }

    function hitungSiBasam() {
        const kec = $('basam-kecamatan').value;
        const kel = $('basam-kelurahan').value;

        const fOrganik = dataOrganik.filter(function(r) {
            if (kec && r.kecamatan !== kec) return false;
            if (kel && r.kelurahan !== kel) return false;
            return true;
        });

        const fBsi = dataBsi.filter(function(r) {
            if (kec && r.kecamatan !== kec) return false;
            if (kel && r.kelurahan !== kel) return false;
            return true;
        });

        let tonaseAnorganik = 0;
        fOrganik.forEach(function(r) { tonaseAnorganik += num(r.sampah_terolah_anorganik); });

        // Angka di bawah ini belum punya sumber data asli, jadi ditampilkan "-" (bukan angka karangan)
        ['basam-pilah-sudah-tonase','basam-pilah-sudah-count','basam-pilah-belum-tonase','basam-pilah-belum-count',
         'basam-bank-belum','basam-paving-total','basam-paving-sudah','basam-paving-belum'].forEach(function(id) {
            $(id).textContent = '-';
        });

        $('basam-bank-ada').textContent = fBsi.length;
        $('basam-tonase-anorganik').textContent = fmt(tonaseAnorganik);
    }

    function loadAll() {
        return Promise.all([api('/pisang-danor/bsi'), api('/pisang-danor/organik')])
            .then(function (hasil) {
                dataBsi = hasil[0];
                dataOrganik = hasil[1];
                render();
                hitungSiBasam();
            })
            .catch(function () {
                $('tbody-danor').innerHTML = '<tr><td class="text-center text-danger py-5">Gagal memuat data.</td></tr>';
            });
    }

    window.pilihKategoriDanor = function (jenis) {
        kategori = jenis;
        $('card-btn-anorganik').classList.toggle('active-kategori', jenis === 'anorganik');
        $('card-btn-organik').classList.toggle('active-kategori', jenis === 'organik');

        if (jenis === 'anorganik') {
            $('title-tabel-danor').textContent = 'Data Pisang BSI (Anorganik)';
            $('subtitle-tabel-danor').textContent = 'Menampilkan daftar data pengolahan sampah anorganik';
        } else {
            $('title-tabel-danor').textContent = 'Data Pisang Organik';
            $('subtitle-tabel-danor').textContent = 'Menampilkan daftar data pengolahan sampah organik (kompos, maggot, dll)';
        }
        page = 1;
        render();
    };

    function filtered() {
        const kec = $('filter-kecamatan-danor').value;
        const kel = $('filter-kelurahan-danor').value;
        const q = $('search-danor').value.trim().toLowerCase();
        const sumber = kategori === 'anorganik' ? dataBsi : dataOrganik;

        return sumber.filter(function (r) {
            if (kec && r.kecamatan !== kec) return false;
            if (kel && r.kelurahan !== kel) return false;
            if (q) {
                const teks = Object.values(r).join(' ').toLowerCase();
                if (teks.indexOf(q) === -1) return false;
            }
            return true;
        });
    }

    function render() {
        const thead = $('thead-danor');
        const tbody = $('tbody-danor');
        const rows = filtered();
        const perPage = parseInt($('pagesize-danor').value, 10) || 10;
        const totalPage = Math.max(1, Math.ceil(rows.length / perPage));
        if (page > totalPage) page = totalPage;
        const mulai = (page - 1) * perPage;
        const tampil = rows.slice(mulai, mulai + perPage);

        let kolom = 11;
        if (kategori === 'anorganik') {
            thead.innerHTML = '<tr class="fw-bolder text-gray-800 bg-light text-uppercase">' +
                '<th class="w-50px text-center">NO</th><th>NAMA BSI</th><th>ALAMAT BSI</th><th>METODE PENGOLAHAN</th>' +
                '<th>KECAMATAN</th><th>KELURAHAN</th><th class="text-center">RW</th><th class="text-center">RT</th>' +
                '<th class="text-center">LIHAT FOTO</th><th class="text-center">AKSI</th></tr>';
            kolom = 10;
        } else {
            thead.innerHTML = '<tr class="fw-bolder text-gray-800 bg-light text-uppercase">' +
                '<th class="w-50px text-center">NO</th><th>KECAMATAN</th><th>KELURAHAN</th><th class="text-center">RW</th><th class="text-center">RT</th>' +
                '<th class="text-end">JUMLAH TONASE</th><th class="text-end">JUMLAH SAMPAH TEROLAH</th><th class="text-end">JUMLAH TONASE RESIDU</th>' +
                '<th class="text-center">JUMLAH METODE PENGOLAHAN</th><th class="text-center">LIHAT FOTO</th><th class="text-center">AKSI</th></tr>';
            kolom = 11;
        }

        if (!tampil.length) {
            tbody.innerHTML = '<tr><td colspan="' + kolom + '" class="text-center py-5 text-gray-500">Belum ada data tersedia</td></tr>';
        } else {
            tbody.innerHTML = tampil.map(function (r, i) {
                const no = mulai + i + 1;
                const aksi = '<td class="text-center">' +
                    '<button class="btn btn-sm btn-icon btn-light-primary rounded-circle me-1 pd-btn-edit" data-id="' + r.id + '" title="Edit"><i class="ki-outline ki-pencil fs-5"></i></button>' +
                    '<button class="btn btn-sm btn-icon btn-light-danger rounded-circle pd-btn-hapus" data-id="' + r.id + '" title="Hapus"><i class="ki-outline ki-trash fs-5"></i></button></td>';

                // Tombol Lihat Foto
                let btnFoto = '<span class="text-muted fs-8">-</span>';
                if (r.upload_file_1_url || r.upload_file_2_url) {
                    btnFoto = '<div class="d-flex justify-content-center gap-1">';
                    if (r.upload_file_1_url) {
                        btnFoto += '<a href="' + esc(r.upload_file_1_url) + '" target="_blank" class="btn btn-sm btn-icon btn-light-info" title="Lihat Foto 1"><i class="ki-outline ki-eye fs-5"></i></a>';
                    }
                    if (r.upload_file_2_url) {
                        btnFoto += '<a href="' + esc(r.upload_file_2_url) + '" target="_blank" class="btn btn-sm btn-icon btn-light-success" title="Lihat Foto 2"><i class="ki-outline ki-eye fs-5"></i></a>';
                    }
                    btnFoto += '</div>';
                }

                if (kategori === 'anorganik') {
                    return '<tr><td class="text-center fw-bold">' + no + '</td>' +
                        '<td class="fw-bold text-gray-800">' + esc(r.nama_bsi) + '</td>' +
                        '<td>' + esc(r.alamat_bsi) + '</td>' +
                        '<td><span class="badge badge-light-primary fw-bold px-3 py-2">' + esc(r.metode_pengolahan) + '</span></td>' +
                        '<td>' + esc(r.kecamatan) + '</td><td>' + esc(r.kelurahan) + '</td>' +
                        '<td class="text-center">' + esc(r.rw) + '</td><td class="text-center">' + esc(r.rt) + '</td>' +
                        '<td class="text-center">' + btnFoto + '</td>' + aksi + '</tr>';
                }

                const terolah = num(r.sampah_terolah_anorganik) + num(r.sampah_terolah_organik);
                const jmlMetode = Array.isArray(r.metode_pengolahan) ? r.metode_pengolahan.length : 0;
                return '<tr><td class="text-center fw-bold">' + no + '</td>' +
                    '<td>' + esc(r.kecamatan) + '</td><td>' + esc(r.kelurahan) + '</td>' +
                    '<td class="text-center">' + esc(r.rw) + '</td><td class="text-center">' + esc(r.rt) + '</td>' +
                    '<td class="text-end">' + fmt(r.jumlah_tonase) + '</td>' +
                    '<td class="text-end">' + fmt(terolah) + '</td>' +
                    '<td class="text-end">' + fmt(r.tonase_residu) + '</td>' +
                    '<td class="text-center"><span class="badge badge-light-success fw-bold px-3 py-2">' + jmlMetode + '</span></td>' +
                    '<td class="text-center">' + btnFoto + '</td>' + aksi + '</tr>';
            }).join('');
        }

        $('info-danor').textContent = rows.length
            ? 'Menampilkan ' + (mulai + 1) + ' - ' + (mulai + tampil.length) + ' dari ' + rows.length + ' data'
            : 'Tidak ada data';

        let pg = '';
        pg += '<li class="page-item ' + (page === 1 ? 'disabled' : '') + '"><a class="page-link pd-page" href="#" data-page="' + (page - 1) + '">Sebelumnya</a></li>';
        for (let p = 1; p <= totalPage; p++) {
            pg += '<li class="page-item ' + (p === page ? 'active' : '') + '"><a class="page-link pd-page" href="#" data-page="' + p + '">' + p + '</a></li>';
        }
        pg += '<li class="page-item ' + (page === totalPage ? 'disabled' : '') + '"><a class="page-link pd-page" href="#" data-page="' + (page + 1) + '">Berikutnya</a></li>';
        $('pagination-danor').innerHTML = pg;
    }

    $('pagesize-danor').addEventListener('change', function () { page = 1; render(); });
    $('search-danor').addEventListener('input', function () { page = 1; render(); });

    $('tbody-danor').addEventListener('click', function (e) {
        const edit = e.target.closest('.pd-btn-edit');
        const hapus = e.target.closest('.pd-btn-hapus');
        if (edit) bukaEdit(edit.dataset.id);
        if (hapus) konfirmasiHapus(hapus.dataset.id);
    });
    $('pagination-danor').addEventListener('click', function (e) {
        const a = e.target.closest('.pd-page');
        if (!a) return;
        e.preventDefault();
        const p = parseInt(a.dataset.page, 10);
        if (p >= 1) { page = p; render(); }
    });

    document.querySelectorAll('.pd-foto-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const box = $(this.dataset.preview);
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) { box.innerHTML = '<img src="' + e.target.result + '" alt="preview">'; };
            reader.readAsDataURL(file);
        });
    });
    function fotoHtml(url) { return url ? '<img src="' + esc(url) + '" alt="foto">' : EMPTY_IMG; }

    window.openTambahDanor = function () {
        if (kategori === 'anorganik') {
            $('form-tambah-danor').reset();
            isiKecamatan($('modal-kecamatan-danor'), 'Pilih Kecamatan', true);
            $('modal-kelurahan-danor').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
            $('modal-kelurahan-danor').disabled = true;
            $('pd-add-preview-1').innerHTML = EMPTY_IMG;
            $('pd-add-preview-2').innerHTML = EMPTY_IMG;
            modal('modal_tambah_danor').show();
        } else {
            resetFormOrganik();
            $('po-title').textContent = 'Tambah Data Pisang Organik';
            isiKecamatan($('po-kecamatan'), 'Pilih Kecamatan', true);
            modal('modal_organik_danor').show();
        }
    };

    $('form-tambah-danor').addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;

        api('/pisang-danor/bsi', { method: 'POST', body: new FormData(this) })
            .then(function (res) {
                modal('modal_tambah_danor').hide();
                sukses(res.message || 'Data berhasil ditambahkan');
                return loadAll();
            })
            .catch(function (err) { gagal(err.message); })
            .finally(function () { btn.disabled = false; });
    });

    function bukaEdit(id) {
        if (kategori === 'anorganik') {
            const r = dataBsi.find(function (d) { return String(d.id) === String(id); });
            if (!r) return;
            $('edit-id-danor').value = r.id;
            $('edit-nama-bsi').value = r.nama_bsi || '';
            $('edit-metode-pengolahan').value = r.metode_pengolahan || '';
            $('edit-alamat-bsi').value = r.alamat_bsi || '';
            $('edit-rw').value = r.rw || '';
            $('edit-rt').value = r.rt || '';
            isiKecamatan($('edit-kecamatan-danor'), 'Pilih Kecamatan', true);
            $('edit-kecamatan-danor').value = r.kecamatan;
            isiKelurahan($('edit-kelurahan-danor'), r.kecamatan, 'Pilih Kelurahan', true, r.kelurahan);
            $('edit-file-1').value = '';
            $('edit-file-2').value = '';
            $('pd-edit-preview-1').innerHTML = fotoHtml(r.upload_file_1_url);
            $('pd-edit-preview-2').innerHTML = fotoHtml(r.upload_file_2_url);
            modal('modal_edit_danor').show();
        } else {
            const r = dataOrganik.find(function (d) { return String(d.id) === String(id); });
            if (!r) return;
            resetFormOrganik();
            $('po-title').textContent = 'Edit Data Pisang Organik';
            $('po-id').value = r.id;
            isiKecamatan($('po-kecamatan'), 'Pilih Kecamatan', true);
            $('po-kecamatan').value = r.kecamatan;
            isiKelurahan($('po-kelurahan'), r.kecamatan, 'Pilih Kelurahan', true, r.kelurahan);
            $('po-rw').value = r.rw || '';
            $('po-rt').value = r.rt || '';
            $('po-tonase').value = r.jumlah_tonase;
            $('po-residu').value = r.tonase_residu;
            $('po-terolah-anorganik').value = r.sampah_terolah_anorganik === null ? '' : r.sampah_terolah_anorganik;
            $('po-terolah-organik').value = r.sampah_terolah_organik === null ? '' : r.sampah_terolah_organik;
            const dipilih = Array.isArray(r.metode_pengolahan) ? r.metode_pengolahan : [];
            document.querySelectorAll('.po-metode').forEach(function (cb) { cb.checked = dipilih.indexOf(cb.value) !== -1; });

            $('po-file-1').value = '';
            $('po-file-2').value = '';
            $('po-preview-1').innerHTML = fotoHtml(r.upload_file_1_url);
            $('po-preview-2').innerHTML = fotoHtml(r.upload_file_2_url);

            modal('modal_organik_danor').show();
        }
    }

    $('form-edit-danor').addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;

        const fd = new FormData(this);
        fd.append('_method', 'PUT');

        api('/pisang-danor/bsi/' + $('edit-id-danor').value, { method: 'POST', body: fd })
            .then(function (res) {
                modal('modal_edit_danor').hide();
                sukses(res.message || 'Data berhasil diubah');
                return loadAll();
            })
            .catch(function (err) { gagal(err.message); })
            .finally(function () { btn.disabled = false; });
    });

    function resetFormOrganik() {
        $('form-organik-danor').reset();
        $('po-id').value = '';
        isiKecamatan($('po-kecamatan'), 'Pilih Kecamatan', true);
        $('po-kelurahan').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
        $('po-kelurahan').disabled = true;
        document.querySelectorAll('.po-metode').forEach(function (cb) { cb.checked = false; });
        $('po-preview-1').innerHTML = EMPTY_IMG;
        $('po-preview-2').innerHTML = EMPTY_IMG;
    }

    $('form-organik-danor').addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;

        const id = $('po-id').value;
        const fd = new FormData(this);
        document.querySelectorAll('.po-metode:checked').forEach(function (cb) { fd.append('metode_pengolahan[]', cb.value); });

        let url = '/pisang-danor/organik';
        if (id) { url += '/' + id; fd.append('_method', 'PUT'); }

        api(url, { method: 'POST', body: fd })
            .then(function (res) {
                modal('modal_organik_danor').hide();
                sukses(res.message || (id ? 'Data berhasil diubah' : 'Data berhasil ditambahkan'));
                return loadAll();
            })
            .catch(function (err) { gagal(err.message); })
            .finally(function () { btn.disabled = false; });
    });

    function konfirmasiHapus(id) {
        const r = (kategori === 'anorganik' ? dataBsi : dataOrganik).find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        const nama = kategori === 'anorganik' ? r.nama_bsi : (r.kelurahan + ' RW ' + (r.rw || '-') + ' RT ' + (r.rt || '-'));

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah anda yakin untuk menghapus ' + nama + ' ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: { confirmButton: 'btn btn-success fw-bold px-6 me-2', cancelButton: 'btn btn-danger fw-bold px-6', popup: 'rounded-4' },
            buttonsStyling: false
        }).then(function (result) {
            if (!result.isConfirmed) return;
            const url = (kategori === 'anorganik' ? '/pisang-danor/bsi/' : '/pisang-danor/organik/') + id;
            api(url, { method: 'DELETE' })
                .then(function (res) { sukses(res.message || 'Data berhasil dihapus'); return loadAll(); })
                .catch(function (err) { gagal(err.message); });
        });
    }

    window.basamFilterDanor = function () {
        hitungSiBasam();
        Swal.fire({
            icon: 'success',
            title: 'Filter Terpasang',
            text: 'Data monitoring SI BASAM telah diperbarui berdasarkan lokasi pilihan.',
            timer: 1500,
            showConfirmButton: false,
            customClass: { popup: 'rounded-4' }
        });
    };

    window.basamResetDanor = function () {
        $('basam-kecamatan').value = '';
        isiKelurahan($('basam-kelurahan'), '', '-- Pilih Kelurahan --', false);
        $('basam-kelurahan').disabled = true;
        hitungSiBasam();
    };

    window.openEmptyPopUp = function (title, subtitle) {
        $('popup-title').textContent = title;
        $('popup-subtitle').textContent = subtitle;
        modal('modalPopUpKosong').show();
    };

    window.switchMainTabDanor = function (tab) {
        const sectionDanor = $('view-section-pisang-danor');
        const sectionBasam = $('view-section-si-basam');
        const btnDanor = $('tab-btn-danor');
        const btnBasam = $('tab-btn-basam');
        const mainTitle = $('main-section-title');

        if (tab === 'danor') {
            sectionDanor.classList.remove('d-none');
            sectionBasam.classList.add('d-none');
            btnDanor.classList.add('active');
            btnBasam.classList.remove('active');
            if (mainTitle) mainTitle.textContent = 'Pelatihan Inovasi Pisang Danor (Pilah Sampah Anorganik dan Organik)';
        } else {
            sectionBasam.classList.remove('d-none');
            sectionDanor.classList.add('d-none');
            btnBasam.classList.add('active');
            btnDanor.classList.remove('active');
            if (mainTitle) mainTitle.textContent = 'Data Monitoring SI BASAM';
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        api('/pisang-danor/wilayah')
            .then(function (data) { wilayah = data; })
            .catch(function () { gagal('Gagal mengambil data kecamatan/kelurahan dari database.'); })
            .finally(function () { initWilayah(); loadAll(); });
    });
})();
</script>
