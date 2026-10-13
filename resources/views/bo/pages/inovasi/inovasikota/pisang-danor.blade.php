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

            <!-- Tabel Data Pisang BSI -->
            <div class="border-top pt-6">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
                    <div>
                        <h3 class="fw-bolder text-gray-900 fs-3 m-0" id="title-tabel-danor">Data Pisang BSI (Anorganik)</h3>
                        <span class="text-gray-500 fs-8 fw-semibold" id="subtitle-tabel-danor">Menampilkan daftar data pengolahan sampah anorganik</span>
                    </div>

                    <button type="button" class="btn fw-bold fs-7 px-5 text-white rounded-3 shadow-sm" style="background-color: #22c55e !important;" data-bs-toggle="modal" data-bs-target="#modal_tambah_danor">
                        <i class="ki-outline ki-plus fs-3 text-white me-1"></i> Tambah Data
                    </button>
                </div>

                <!-- Filter Dropdown -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7 fw-semibold">Tampilkan</span>
                        <select class="form-select form-select-solid w-75px fs-7 fw-bold">
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">
                        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kecamatan-danor" onchange="loadKelurahanDanor(this.value)">
                            <option value="">Semua Kecamatan</option>
                        </select>

                        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kelurahan-danor">
                            <option value="">Pilih Kelurahan</option>
                        </select>

                        <div class="d-flex align-items-center position-relative">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3 text-gray-500"></i>
                            <input type="text" class="form-control form-control-solid ps-10 w-200px fs-7 fw-semibold" placeholder="Cari..." />
                        </div>
                    </div>
                </div>

                <!-- Tabel Data BSI -->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed table-bordered fs-7 gy-3 gs-4">
                        <thead>
                            <tr class="fw-bolder text-gray-800 bg-light text-uppercase">
                                <th class="w-50px text-center">NO</th>
                                <th>NAMA BSI</th>
                                <th>ALAMAT BSI</th>
                                <th>METODE PENGOLAHAN</th>
                                <th>KECAMATAN</th>
                                <th>KELURAHAN</th>
                                <th class="text-center">RW</th>
                                <th class="text-center">RT</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-700" id="tbody-danor">
                            <!-- Content generated dynamically -->
                        </tbody>
                    </table>
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
                        <option value="wonokromo">Wonokromo</option>
                        <option value="gubeng">Gubeng</option>
                        <option value="sukolilo">Sukolilo</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold fs-7">Kelurahan</label>
                    <select id="basam-kelurahan" class="form-select form-select-solid">
                        <option value="" selected>-- Pilih Kelurahan --</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-primary w-100 fw-bold" style="background-color: #0d9488 !important; border-color: #0d9488 !important;">Filter</button>
                </div>
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-light w-100 fw-semibold">Reset</button>
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
                                    <div class="fs-2hx fw-bolder my-1" style="color: #10b981;">784.66</div>
                                    <span class="fs-1 fw-bolder text-success">4</span>
                                </div>
                                <div class="col-6 basam-clickable" onclick="openEmptyPopUp('Data Pilah Sampah - BELUM', 'Rincian data warga/wilayah yang BELUM melakukan pemilahan sampah')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM</span>
                                    <div class="fs-2hx fw-bolder text-danger my-1">1.671.6</div>
                                    <span class="fs-1 fw-bolder text-danger">65</span>
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
                                    <div class="fs-2hx fw-bolder my-2" style="color: #10b981;">1.040</div>
                                </div>
                                <div class="col-6 basam-clickable" onclick="openEmptyPopUp('Data Bank Sampah - BELUM ADA', 'Rincian wilayah/RT/RW yang BELUM ADA Bank Sampah')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM ADA</span>
                                    <div class="fs-2hx fw-bolder text-danger my-2">0</div>
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
                            <div class="fs-2hx fw-bolder text-gray-900 mt-1">1.307.566</div>
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
                                    <div class="fs-2hx fw-bolder text-gray-900 mt-1">843</div>
                                </div>
                                <div class="col-4 border-end basam-clickable" onclick="openEmptyPopUp('Data Paving - SUDAH BIOPORI', 'Rincian titik paving yang SUDAH memiliki biopori')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">SUDAH BIOPORI</span>
                                    <div class="fs-2hx fw-bolder my-1" style="color: #10b981;">843</div>
                                </div>
                                <div class="col-4 basam-clickable" onclick="openEmptyPopUp('Data Paving - BELUM BIOPORI', 'Rincian titik paving yang BELUM memiliki biopori')">
                                    <span class="fs-8 fw-bold text-gray-500 text-uppercase">BELUM BIOPORI</span>
                                    <div class="fs-2hx fw-bolder text-danger mt-1">0</div>
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
<!-- MODAL TAMBAH DATA PISANG DANOR -->
<!-- ================================================================= -->
<div class="modal fade" id="modal_tambah_danor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Tambah Data Pisang Danor</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-tambah-danor" enctype="multipart/form-data" onsubmit="simpanDataDanor(event)">
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
                            <select class="form-select form-select-solid" name="kecamatan" id="modal-kecamatan-danor" onchange="loadKelurahanModalDanor(this.value)" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kelurahan" id="modal-kelurahan-danor" required>
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

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-solid" name="upload_file_1" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 2 <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-solid" name="upload_file_2" required />
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
<!-- MODAL EDIT DATA PISANG DANOR -->
<!-- ================================================================= -->
<div class="modal fade" id="modal_edit_danor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Edit Data Pisang Danor</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-edit-danor" enctype="multipart/form-data" onsubmit="simpanEditDanor(event)">
                    <input type="hidden" id="edit-id-danor" name="id" />

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
                            <select class="form-select form-select-solid" id="edit-kecamatan-danor" name="kecamatan" onchange="loadKelurahanEditDanor(this.value)" required>
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

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File (Opsional)</label>
                            <input type="file" class="form-control form-control-solid" name="upload_file_1" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File 2 (Opsional)</label>
                            <input type="file" class="form-control form-control-solid" name="upload_file_2" />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold px-6">Simpan Changes</button>
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

<!-- Script Logic & Event Listeners -->
<script>
const dataWilayahSurabayaDanor = {
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

let kategoriDanorAktif = 'anorganik';

// Dummy Data untuk Anorganik & Organik
let listDataAnorganik = [
    { id: 1, nama_bsi: "BSI Bank Sampah Melati", alamat: "Jl. Embong Malang No. 22", metode: "Daur Ulang Plastik & Kerajinan", kecamatan: "GENTENG", kelurahan: "EMBONG KALIASIN", rw: "03", rt: "05" },
    { id: 2, nama_bsi: "BSI Bersinar Tegalsari", alamat: "Jl. Kedungdoro No. 104", metode: "Pencacahan Plastik Keras", kecamatan: "TEGALSARI", kelurahan: "KEDUNGDORO", rw: "01", rt: "02" }
];

let listDataOrganik = [
    { id: 1, nama_bsi: "Rumah Kompos Jambangan", alamat: "Jl. Jambangan No. 45", metode: "Pengomposan Takakura & Maggot BSF", kecamatan: "JAMBANGAN", kelurahan: "JAMBANGAN", rw: "02", rt: "04" },
    { id: 2, nama_bsi: "BSI Organik Hijau Rungkut", alamat: "Jl. Kalirungkut No. 12", metode: "Budidaya Maggot & Eco Enzyme", kecamatan: "RUNGKUT", kelurahan: "KALIRUNGKUT", rw: "05", rt: "01" }
];

function initDropdownDanor() {
    const kecFilter = document.getElementById('filter-kecamatan-danor');
    const kecModalTambah = document.getElementById('modal-kecamatan-danor');
    const kecModalEdit = document.getElementById('edit-kecamatan-danor');
    const listKec = Object.keys(dataWilayahSurabayaDanor);

    if (kecFilter) {
        kecFilter.innerHTML = '<option value="">Semua Kecamatan</option>';
        listKec.forEach(k => kecFilter.appendChild(new Option(k, k)));
    }
    if (kecModalTambah) {
        kecModalTambah.innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
        listKec.forEach(k => kecModalTambah.appendChild(new Option(k, k)));
    }
    if (kecModalEdit) {
        kecModalEdit.innerHTML = '<option value="" selected disabled>Pilih Kecamatan</option>';
        listKec.forEach(k => kecModalEdit.appendChild(new Option(k, k)));
    }
}

function loadKelurahanDanor(kec) {
    const kelSelect = document.getElementById('filter-kelurahan-danor');
    if (!kelSelect) return;
    kelSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
    if (kec && dataWilayahSurabayaDanor[kec]) {
        dataWilayahSurabayaDanor[kec].forEach(k => kelSelect.appendChild(new Option(k, k)));
    }
}

function loadKelurahanModalDanor(kec) {
    const kelSelect = document.getElementById('modal-kelurahan-danor');
    if (!kelSelect) return;
    kelSelect.innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
    if (kec && dataWilayahSurabayaDanor[kec]) {
        dataWilayahSurabayaDanor[kec].forEach(k => kelSelect.appendChild(new Option(k, k)));
    }
}

function loadKelurahanEditDanor(kec) {
    const kelSelect = document.getElementById('edit-kelurahan-danor');
    if (!kelSelect) return;
    kelSelect.innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
    if (kec && dataWilayahSurabayaDanor[kec]) {
        dataWilayahSurabayaDanor[kec].forEach(k => kelSelect.appendChild(new Option(k, k)));
    }
}

function pilihKategoriDanor(jenis) {
    kategoriDanorAktif = jenis;

    const btnAnorganik = document.getElementById('card-btn-anorganik');
    const btnOrganik = document.getElementById('card-btn-organik');
    const titleTabel = document.getElementById('title-tabel-danor');
    const subtitleTabel = document.getElementById('subtitle-tabel-danor');

    if (jenis === 'anorganik') {
        btnAnorganik.classList.add('active-kategori');
        btnOrganik.classList.remove('active-kategori');
        if (titleTabel) titleTabel.textContent = 'Data Pisang BSI (Anorganik)';
        if (subtitleTabel) subtitleTabel.textContent = 'Menampilkan daftar data pengolahan sampah anorganik';
    } else {
        btnOrganik.classList.add('active-kategori');
        btnAnorganik.classList.remove('active-kategori');
        if (titleTabel) titleTabel.textContent = 'Data Pisang BSI (Organik)';
        if (subtitleTabel) subtitleTabel.textContent = 'Menampilkan daftar data pengolahan sampah organik (kompos, maggot, dll)';
    }

    renderTabelDanor();
}

function renderTabelDanor() {
    const tbody = document.getElementById('tbody-danor');
    if (!tbody) return;

    const dataset = (kategoriDanorAktif === 'anorganik') ? listDataAnorganik : listDataOrganik;

    if (dataset.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-5 text-gray-500">Belum ada data tersedia</td></tr>`;
        return;
    }

    tbody.innerHTML = dataset.map((item, index) => {
        const badgeColor = (kategoriDanorAktif === 'anorganik') ? 'badge-light-primary' : 'badge-light-success';
        return `
            <tr>
                <td class="text-center fw-bold">${index + 1}</td>
                <td class="fw-bold text-gray-800">${item.nama_bsi}</td>
                <td>${item.alamat}</td>
                <td><span class="badge ${badgeColor} fw-bold px-3 py-2">${item.metode}</span></td>
                <td>${item.kecamatan}</td>
                <td>${item.kelurahan}</td>
                <td class="text-center">${item.rw}</td>
                <td class="text-center">${item.rt}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-icon btn-light-primary rounded-circle me-1" title="Edit" onclick="openModalEditDanor(${item.id})">
                        <i class="ki-outline ki-pencil fs-5"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-light-danger rounded-circle" title="Hapus" onclick="hapusDataDanor(${item.id}, '${item.nama_bsi}')">
                        <i class="ki-outline ki-trash fs-5"></i>
                    </button>
                </td>
            </tr>
        `;
    }).join('');
}

// SIMPAN TAMBAH DATA (Pop-up: Data berhasil ditambahkan)
function simpanDataDanor(e) {
    e.preventDefault();
    const modalEl = document.getElementById('modal_tambah_danor');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }

    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil ditambahkan',
        showConfirmButton: false,
        timer: 2000,
        customClass: { popup: 'rounded-4' }
    });

    document.getElementById('form-tambah-danor').reset();
}

// BUKA MODAL EDIT DATA
function openModalEditDanor(id) {
    const dataset = (kategoriDanorAktif === 'anorganik') ? listDataAnorganik : listDataOrganik;
    const item = dataset.find(d => d.id === id);

    if (!item) return;

    document.getElementById('edit-id-danor').value = item.id;
    document.getElementById('edit-nama-bsi').value = item.nama_bsi;
    document.getElementById('edit-metode-pengolahan').value = item.metode;
    document.getElementById('edit-alamat-bsi').value = item.alamat;
    document.getElementById('edit-rw').value = item.rw;
    document.getElementById('edit-rt').value = item.rt;

    const kecEditSelect = document.getElementById('edit-kecamatan-danor');
    kecEditSelect.value = item.kecamatan;
    loadKelurahanEditDanor(item.kecamatan);

    setTimeout(() => {
        document.getElementById('edit-kelurahan-danor').value = item.kelurahan;
    }, 100);

    const modalEditEl = document.getElementById('modal_edit_danor');
    bootstrap.Modal.getOrCreateInstance(modalEditEl).show();
}

// SIMPAN EDIT DATA (Pop-up: Data berhasil diubah)
function simpanEditDanor(e) {
    e.preventDefault();

    const id = parseInt(document.getElementById('edit-id-danor').value);
    const dataset = (kategoriDanorAktif === 'anorganik') ? listDataAnorganik : listDataOrganik;
    const item = dataset.find(d => d.id === id);

    if (item) {
        item.nama_bsi = document.getElementById('edit-nama-bsi').value;
        item.metode = document.getElementById('edit-metode-pengolahan').value;
        item.alamat = document.getElementById('edit-alamat-bsi').value;
        item.kecamatan = document.getElementById('edit-kecamatan-danor').value;
        item.kelurahan = document.getElementById('edit-kelurahan-danor').value;
        item.rw = document.getElementById('edit-rw').value;
        item.rt = document.getElementById('edit-rt').value;
    }

    const modalEditEl = document.getElementById('modal_edit_danor');
    bootstrap.Modal.getOrCreateInstance(modalEditEl).hide();

    renderTabelDanor();

    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil diubah',
        showConfirmButton: false,
        timer: 2000,
        customClass: { popup: 'rounded-4' }
    });
}

// HAPUS DATA DENGAN KONFIRMASI (Pop-up Yakin/Batal & Data berhasil dihapus)
function hapusDataDanor(id, namaBsi) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah anda yakin untuk menghapus ${namaBsi} ini?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yakin',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-success fw-bold px-6 me-2',
            cancelButton: 'btn btn-danger fw-bold px-6',
            popup: 'rounded-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            if (kategoriDanorAktif === 'anorganik') {
                listDataAnorganik = listDataAnorganik.filter(item => item.id !== id);
            } else {
                listDataOrganik = listDataOrganik.filter(item => item.id !== id);
            }

            renderTabelDanor();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil dihapus',
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'rounded-4' }
            });
        }
    });
}

function openEmptyPopUp(title, subtitle) {
    document.getElementById('popup-title').textContent = title;
    document.getElementById('popup-subtitle').textContent = subtitle;

    const modalEl = document.getElementById('modalPopUpKosong');
    if (modalEl && typeof bootstrap !== 'undefined') {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function switchMainTabDanor(tab) {
    const sectionDanor = document.getElementById('view-section-pisang-danor');
    const sectionBasam = document.getElementById('view-section-si-basam');
    const btnDanor = document.getElementById('tab-btn-danor');
    const btnBasam = document.getElementById('tab-btn-basam');
    const mainTitle = document.getElementById('main-section-title');

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
}

document.addEventListener('DOMContentLoaded', function() {
    initDropdownDanor();
    renderTabelDanor();
});
</script>
