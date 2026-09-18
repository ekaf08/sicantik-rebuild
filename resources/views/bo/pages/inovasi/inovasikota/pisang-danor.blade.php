<!-- 1. Hero Card: Deskripsi Inovasi Pisang Danor -->
<div class="card card-flush mb-6 border-0 shadow-sm" style="background-color: #f0f8ff; border-radius: 16px;">
    <div class="card-body p-6 p-lg-8">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
            <div class="max-w-3xl">
                <h2 class="fs-2hx fw-bold text-gray-900 mb-3">
                    Inovasi Pisang Danor <br>
                    <span class="fs-4 text-gray-600 fw-semibold">(Pilah Sampah Anorganik dan Organik)</span>
                </h2>
                <p class="text-gray-700 fs-6 lh-lg mb-3">
                    Pisang Danor merupakan inovasi yang bertujuan untuk mendorong pemilahan sampah organik dan anorganik sejak dari sumbernya. Melalui pemilahan ini, jumlah dan tonase sampah dapat dimonitor dengan lebih baik, sehingga pengelolaan sampah menjadi lebih terarah dan terukur.
                </p>
                <p class="text-gray-700 fs-6 lh-lg mb-0">
                    Sampah organik yang terkumpul dapat diolah menjadi kompos, maggot, atau produk bermanfaat lainnya, sedangkan sampah anorganik dapat didaur ulang menjadi bahan bernilai ekonomi. Dengan adanya inovasi Pisang Danor, diharapkan kesadaran masyarakat terhadap pengelolaan sampah meningkat dan lingkungan menjadi lebih bersih serta berkelanjutan.
                </p>
            </div>
            <!-- Tombol Tambah Data -->
            <div class="text-nowrap align-self-start align-self-md-center">
                <button type="button" class="btn btn-success fw-bold px-5 py-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modal_tambah_pisang_danor">
                    <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Data Danor
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Interactive Category Hub: Pelatihan & Kategori Sampah -->
<div class="card card-flush shadow-sm mb-6">
    <div class="card-header border-0 pt-6">
        <div class="card-title flex-column">
            <h3 class="fw-bold text-gray-900 fs-3">Pelatihan & Pemilahan Inovasi</h3>
            <span class="text-gray-500 fs-7 fw-semibold">Pilih kategori pengelolaan sampah untuk melihat detail pelatihan</span>
        </div>
        <!-- Tab Navigation versi Metronic UI -->
        <div class="card-toolbar">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bold">
                <li class="nav-item">
                    <a class="nav-link text-active-primary active py-3" data-bs-toggle="tab" href="#tab_pisang_danor">PISANG DANOR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-3" data-bs-toggle="tab" href="#tab_si_basam">SI BASAM</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body pt-4">
        <div class="tab-content" id="myTabContent">
            <!-- Tab Pisang Danor -->
            <div class="tab-pane fade show active" id="tab_pisang_danor" role="tabpanel">
                <div class="row g-4">
                    <!-- Card Anorganik -->
                    <div class="col-12 col-md-6">
        <div class="card border border-primary border-dashed h-100 p-5 bg-light-primary rounded-4">
            <div class="d-flex align-items-center mb-4">
                <!-- Lingkaran Gambar Anorganik -->
                <div class="symbol symbol-50px symbol-circle me-3 overflow-hidden border border-2 border-primary">
                    <img src="{{ asset('assets/media/svg/illustrations/easy/2.svg') }}" alt="Anorganik" class="w-100 h-100 object-fit-cover" />
                </div>
                <div>
                    <h4 class="fw-bold text-primary mb-0 fs-3">ANORGANIK</h4>
                    <span class="text-gray-600 fs-8">Daur ulang & bahan non-alami</span>
                </div>
            </div>
            <p class="text-gray-700 fs-6 mb-0">
                Pelatihan pengolahan bahan non-alami seperti plastik, botol bekas, kaleng, & limbah keras menjadi produk kreatif bernilai ekonomi.
            </p>
        </div>
    </div>

    <!-- Card Organik -->
    <div class="col-12 col-md-6">
        <div class="card border border-success border-dashed h-100 p-5 bg-light-success rounded-4">
            <div class="d-flex align-items-center mb-4">
                <!-- Lingkaran Gambar Organik -->
                <div class="symbol symbol-50px symbol-circle me-3 overflow-hidden border border-2 border-success">
                    <img src="{{ asset('assets/media/svg/illustrations/easy/1.svg') }}" alt="Organik" class="w-100 h-100 object-fit-cover" />
                </div>
                <div>
                    <h4 class="fw-bold text-success mb-0 fs-3">ORGANIK</h4>
                    <span class="text-gray-600 fs-8">Pengomposan & bahan alami</span>
                </div>
            </div>
            <p class="text-gray-700 fs-6 mb-0">
                Pelatihan pemanfaatan bahan alami seperti sisa tanaman, makanan, & limbah organik menjadi pupuk kompos serta budidaya maggot.
            </p>
        </div>
    </div>
</div>

            <!-- Tab SI BASAM -->
<div class="tab-pane fade" id="tab_si_basam" role="tabpanel">

    <!-- Filter Khusus SI BASAM -->
    <div class="row g-3 mb-6 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label fs-7 fw-bold text-gray-700">Kecamatan</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kecamatan">
                <option value="">- Pilih Kecamatan -</option>
                <option value="wonocolo">WONOCOLO</option>
                <option value="wonokromo">WONOKROMO</option>
                <option value="gubeng">GUBENG</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
            <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kelurahan">
                <option value="">-- Pilih Kelurahan --</option>
                <option value="ketintang">KETINTANG</option>
                <option value="darmo">DARMO</option>
            </select>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
            <button type="button" class="btn btn-primary fw-bold flex-grow-1">
                <i class="ki-outline ki-filter fs-4 me-1"></i> Filter
            </button>
            <button type="button" class="btn btn-light fw-bold">Reset</button>
        </div>
    </div>

    <!-- Grid Metric Cards (Si Basam Widgets) -->
    <div class="row g-4 mb-4">

        <!-- 1. Card Status Pilah Sampah -->
        <div class="col-12 col-md-6">
            <div class="card card-flush h-100 border border-primary border-dashed bg-light-primary rounded-4">
                <div class="card-header pt-4 pb-0 border-0">
                    <h4 class="card-title fw-bold text-primary fs-4">
                        <i class="ki-outline ki-arrows-loop fs-2 me-2 text-primary"></i> PILAH SAMPAH
                    </h4>
                </div>
                <div class="card-body pt-2">
                    <div class="row text-center g-2">
                        <div class="col-6">
                            <div class="bg-body rounded-3 p-4 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">SUDAH PILAH</span>
                                <span class="fs-1 fw-bolder text-success d-block">784.664</span>
                                <span class="badge badge-light-success fs-9 fw-semibold mt-1">Jiwa / KK</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-body rounded-3 p-4 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">BELUM PILAH</span>
                                <span class="fs-1 fw-bolder text-danger d-block">1.671.665</span>
                                <span class="badge badge-light-danger fs-9 fw-semibold mt-1">Jiwa / KK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Card Bank Sampah -->
        <div class="col-12 col-md-6">
            <div class="card card-flush h-100 border border-success border-dashed bg-light-success rounded-4">
                <div class="card-header pt-4 pb-0 border-0">
                    <h4 class="card-title fw-bold text-success fs-4">
                        <i class="ki-outline ki-bank fs-2 me-2 text-success"></i> BANK SAMPAH
                    </h4>
                </div>
                <div class="card-body pt-2">
                    <div class="row text-center g-2">
                        <div class="col-6">
                            <div class="bg-body rounded-3 p-4 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">SUDAH ADA</span>
                                <span class="fs-1 fw-bolder text-success d-block">953</span>
                                <span class="badge badge-light-success fs-9 fw-semibold mt-1">Unit Aktif</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-body rounded-3 p-4 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">BELUM ADA</span>
                                <span class="fs-1 fw-bolder text-gray-400 d-block">0</span>
                                <span class="badge badge-light-secondary fs-9 fw-semibold mt-1">Nihil</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <!-- 3. Card Tonase Anorganic -->
        <div class="col-12 col-md-4">
            <div class="card card-flush h-100 border border-warning border-dashed bg-light-warning rounded-4">
                <div class="card-body p-5 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="fw-bold fs-5 text-warning-emphasis">TONASE AN-ORGANIK</span>
                        <div class="symbol symbol-40px symbol-circle bg-warning">
                            <span class="symbol-label">
                                <i class="ki-outline ki-box text-white fs-2"></i>
                            </span>
                        </div>
                    </div>
                    <div class="text-center py-2">
                        <span class="fs-2hx fw-bolder text-gray-900 d-block">1.283.514</span>
                        <span class="badge badge-warning text-white fw-bold fs-8 px-3 py-1 mt-1">Kilogram (Kg)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Card Paving & Biopori -->
        <div class="col-12 col-md-8">
            <div class="card card-flush h-100 border border-danger border-dashed bg-light-danger rounded-4">
                <div class="card-header pt-4 pb-0 border-0">
                    <h4 class="card-title fw-bold text-danger fs-4">
                        <i class="ki-outline ki-element-plus fs-2 me-2 text-danger"></i> PAVING & KONDISI BIOPORI
                    </h4>
                </div>
                <div class="card-body pt-2">
                    <div class="row text-center g-2">
                        <div class="col-4">
                            <div class="bg-body rounded-3 p-3 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">JUMLAH PAVING</span>
                                <span class="fs-2 fw-bolder text-gray-900 d-block">843</span>
                                <span class="text-gray-400 fs-9">Titik / Area</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-body rounded-3 p-3 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">SUDAH BIOPORI</span>
                                <span class="fs-2 fw-bolder text-success d-block">843</span>
                                <span class="text-success fs-9">Terpasang</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-body rounded-3 p-3 border border-light">
                                <span class="fs-8 fw-bold text-gray-500 text-uppercase d-block mb-1">BELUM BIOPORI</span>
                                <span class="fs-2 fw-bolder text-danger d-block">0</span>
                                <span class="text-gray-400 fs-9">Nihil</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
        </div>
    </div>
</div>

<!-- 3. Filter & Table Data Section -->
<div class="card card-flush shadow-sm">
    <div class="card-header pt-6">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold fs-4 text-gray-800">Data Pemilahan Sampah</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-7">Saring data pemilahan berdasarkan wilayah kecamatan dan kelurahan</span>
        </h3>
    </div>
    <div class="card-body pt-2">
        <!-- Filter Row -->
        <div class="row g-3 mb-5">
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kecamatan</label>
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kecamatan">
                    <option value="">Pilih Kecamatan</option>
                    <option value="wonocolo">WONOCOLO</option>
                    <option value="wonokromo">WONOKROMO</option>
                    <option value="gubeng">GUBENG</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
                <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kelurahan">
                    <option value="">Pilih Kelurahan</option>
                    <option value="ketintang">KETINTANG</option>
                    <option value="darmo">DARMO</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kategori Sampah</label>
                <select class="form-select form-select-solid">
                    <option value="">Semua Kategori</option>
                    <option value="organik">Organik</option>
                    <option value="anorganik">Anorganik</option>
                </select>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>No</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Kategori</th>
                        <th>Tonase (Kg)</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    <tr>
                        <td>1</td>
                        <td>Wonocolo</td>
                        <td>Ketintang</td>
                        <td><span class="badge badge-light-success fw-bold">ORGANIK</span></td>
                        <td>45 Kg</td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-icon btn-light-primary me-1"><i class="ki-outline ki-eye fs-5"></i></button>
                            <button class="btn btn-sm btn-icon btn-light-warning"><i class="ki-outline ki-pencil fs-5"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
