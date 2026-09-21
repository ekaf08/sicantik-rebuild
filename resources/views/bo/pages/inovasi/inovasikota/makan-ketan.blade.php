<!-- 1. Banner Deskripsi Inovasi (Kotak Biru Muda) -->
<div class="card border-0 shadow-none mb-6" style="background-color: #f0f6ff; border-radius: 16px;">
    <div class="card-body p-6 p-lg-8">
        <h3 class="fw-bold text-gray-900 fs-3 mb-4">
            Inovasi Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan)
        </h3>
        <p class="text-gray-600 fs-6 lh-lg mb-4">
            Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan) merupakan inovasi yang mendorong pemanfaatan pekarangan rumah sebagai sumber ketahanan pangan keluarga. Melalui kegiatan urban farming, warga diajak menanam berbagai jenis tanaman pangan dan sayuran yang mudah dibudidayakan di lingkungan rumah.
        </p>
        <p class="text-gray-600 fs-6 lh-lg mb-0">
            Inovasi ini sejalan dengan program PKK, khususnya tema Aku Hatinya PKK, yang menekankan pentingnya pemanfaatan halaman rumah. Selain membantu memenuhi kebutuhan pangan keluarga, Makan Ketan juga meningkatkan kemandirian, menghemat pengeluaran, dan menumbuhkan kepedulian terhadap lingkungan.
        </p>
    </div>
</div>

<!-- 2. Header & Tombol Tambah Data -->
<div class="d-flex flex-stack mb-5">
    <div>
        <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Makan Ketan</h2>
    </div>
    <div>
        <!-- Tombol Tambah Makan Ketan Warna Hijau -->
        <button type="button" class="btn btn-success fw-bold px-5" data-bs-toggle="modal" data-bs-target="#modal_tambah_makan_ketan">
            <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Makan Ketan
        </button>
    </div>
</div>

<!-- 3. Stat Cards: Total Data per Tahun (2024, 2025, 2026) -->
<div class="row g-4 mb-6">
    <!-- Tahun 2024 -->
    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4 border-primary">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold text-gray-900">0</span>
                </div>
                <div class="symbol symbol-45px symbol-circle bg-light-primary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-calendar text-primary fs-1"></i>
                    </span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 bg-light-primary text-center">
                <span class="fs-8 fw-bold text-primary">MAKAN KETAN 2024</span>
            </div>
        </div>
    </div>

    <!-- Tahun 2025 -->
    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4" style="border-color: #7239ea !important;">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold" style="color: #7239ea;">31</span>
                </div>
                <div class="symbol symbol-45px symbol-circle" style="background-color: #f8f5ff;">
                    <span class="symbol-label">
                        <i class="ki-outline ki-chart-line-up fs-1" style="color: #7239ea;"></i>
                    </span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 text-center" style="background-color: #f8f5ff;">
                <span class="fs-8 fw-bold" style="color: #7239ea;">MAKAN KETAN 2025</span>
            </div>
        </div>
    </div>

    <!-- Tahun 2026 -->
    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4 border-success">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold text-success">0</span>
                </div>
                <div class="symbol symbol-45px symbol-circle bg-light-success">
                    <span class="symbol-label">
                        <i class="ki-outline ki-verify text-success fs-1"></i>
                    </span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 bg-light-success text-center">
                <span class="fs-8 fw-bold text-success">MAKAN KETAN 2026</span>
            </div>
        </div>
    </div>
</div>

<!-- 4. Form Filter & Tabel Data -->
<div class="card card-flush shadow-sm">
    <div class="card-body pt-6">
        <!-- Form Filter Horizontal -->
        <div class="row g-3 mb-5">
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kecamatan</label>
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kecamatan">
                    <option value="">Pilih Kecamatan</option>
                    <option value="asemrowo">ASEMROWO</option>
                    <option value="benowo">BENOWO</option>
                    <option value="bubutan">BUBUTAN</option>
                    <option value="bulak">BULAK</option>
                    <option value="dukuh pakis">DUKUH PAKIS</option>
                    <option value="gayungan">GAYUNGAN</option>
                    <option value="genteng">GENTENG</option>
                    <option value="gubeng">GUBENG</option>
                    <option value="gunung anyar">GUNUNG ANYAR</option>
                    <option value="jambangan">JAMBANGAN</option>
                    <option value="karang pilang">KARANG PILANG</option>
                    <option value="kenjeran">KENJERAN</option>
                    <option value="kota surabaya">KOTA SURABAYA</option>
                    <option value="krembangan">KREMBANGAN</option>
                    <option value="lakar santri">LAKAR SANTRI</option>
                    <option value="mulyorejo">MULYOREJO</option>
                    <option value="pabean cantian">PABEAN CANTIAN</option>
                    <option value="pakal">PAKAL</option>
                    <option value="rungkut">RUNGKUT</option>
                    <option value="sambi kerep">SAMBI KEREP</option>
                    <option value="sawahan">SAWAHAN</option>
                    <option value="semampir">SEMAMPIR</option>
                    <option value="simokerto">SIMOKERTO</option>
                    <option value="sukolilo">SUKOLILO</option>
                    <option value="sukomanunggal">SUKOMANUNGGAL</option>
                    <option value="tambaksari">TAMBAKSARI</option>
                    <option value="tandes">TANDES</option>
                    <option value="tegalsari">TEGALSARI</option>
                    <option value="tenggilis mejoyo">TENGGILIS MEJOYO</option>
                    <option value="wiyung">WIYUNG</option>
                    <option value="wonocolo">WONOCOLO</option>
                    <option value="wonokromo">WONOKROMO</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kelurahan">
                    <option value="">Kelurahan</option>
                    <option value="asemrowo">ASEMROWO</option>
                    <option value="darmo">Darmo</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Status Filter</label>
                <select class="form-select form-select-solid">
                    <option value="semua">Semua</option>
                    <option value="aktif">Aktif</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Tahun</th>
                        <th>Detail Program</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    <tr>
                        <td>1</td>
                        <td>Wonocolo</td>
                        <td>Ketintang</td>
                        <td><span class="badge badge-light-primary fw-bold">2025</span></td>
                        <td>Pemanfaatan Pekarangan RT 03</td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-icon btn-light-primary me-1" data-bs-toggle="modal" data-bs-target="#modal_detail_makan_ketan">
                                <i class="ki-outline ki-eye fs-5"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-icon btn-light-warning" data-bs-toggle="modal" data-bs-target="#modal_edit_makan_ketan">
                                <i class="ki-outline ki-pencil fs-5"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- MODAL FORM TAMBAH KEGIATAN                 -->
<!-- ========================================== -->
<div class="modal fade" id="modal_tambah_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Tambah Kegiatan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>

            <div class="modal-body py-6 px-8">
                <form id="form_tambah_makan_ketan" action="#" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal_tambah_makan_ketan" data-placeholder="Pilih Kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                <option value="wonocolo">WONOCOLO</option>
                                <option value="wonokromo">WONOKROMO</option>
                                <option value="gubeng">GUBENG</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal_tambah_makan_ketan" data-placeholder="Kelurahan">
                                <option value="">Kelurahan</option>
                                <option value="ketintang">KETINTANG</option>
                                <option value="darmo">DARMO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA DASA WISMA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="nama_dasa_wisma" placeholder="" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUMLAH RUMAH <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-solid" name="jumlah_rumah" placeholder="" />
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="rt" placeholder="" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="rw" placeholder="" />
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="tahun">
                                <option value="">-- Pilih --</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-gray-700 mb-3">Preview Foto</label>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="border rounded-3 p-8 text-center bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded-3 p-8 text-center bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-gray-700">Foto 1</label>
                            <input type="file" class="form-control form-control-solid" name="foto_1" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-gray-700">Foto 2</label>
                            <input type="file" class="form-control form-control-solid" name="foto_2" accept="image/jpg, image/jpeg, image/png" />
                            <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-danger fw-bold px-6" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-3 me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success fw-bold px-6">
                            <i class="ki-outline ki-check fs-3 me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL DETAIL INOVASI (TOMBOL MATA)        -->
<!-- ========================================== -->
<div class="modal fade" id="modal_detail_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Detail Kegiatan Makan Ketan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-gray-600 fs-7 d-block">Kecamatan:</label>
                        <span class="fw-bolder text-gray-800 fs-6">Wonocolo</span>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-gray-600 fs-7 d-block">Kelurahan:</label>
                        <span class="fw-bolder text-gray-800 fs-6">Ketintang</span>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold text-gray-600 fs-7 d-block">Detail Program:</label>
                        <span class="fw-bolder text-gray-800 fs-6">Pemanfaatan Pekarangan RT 03</span>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-gray-600 fs-7 d-block">Tahun:</label>
                        <span class="badge badge-light-primary fw-bold">2025</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL EDIT INOVASI (TOMBOL PENSIL)         -->
<!-- ========================================== -->
<div class="modal fade" id="modal_edit_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Edit Kegiatan Makan Ketan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <form id="form_edit_makan_ketan" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kecamatan">
                                <option value="wonocolo" selected>WONOCOLO</option>
                                <option value="wonokromo">WONOKROMO</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kelurahan">
                                <option value="ketintang" selected>KETINTANG</option>
                                <option value="darmo">DARMO</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold px-6">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
