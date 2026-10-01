<div class="d-flex flex-column gap-5">
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-8">
            <h2 class="fw-bolder text-gray-900 mb-1 fs-2">
                Inovasi SOTH
            </h2>
            <h4 class="text-success fw-bold text-uppercase tracking-wider fs-6 mb-3">
                Sekolah Orang Tua Hebat
            </h4>
            <div class="bg-success rounded-pill mb-4" style="height: 3px; width: 60px;"></div>
            <span class="text-gray-600 fs-6 lh-base mb-0 d-block mt-3">
                Program Sekolah Orang Tua Hebat, Kolaborasi Pemkot Surabaya, BKKBN, dan PKK untuk meningkatkan kualitas pengasuhan anak melalui pendidikan informal, mencegah stunting, membentuk karakter positif, dan memperkuat hubungan keluarga, dengan fokus pada orang tua balita (0-5 tahun) di setiap RW, melalui 14 materi pengasuhan dan gizi. Harapannya dengan adanya program ini, orang tua yang memiliki balita mendapatkan peningkatan kualitas terkait cara, metode, dan pembentukan karakter yang lebih baik. 
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <div class="col-12 col-md-4">
                <label class="form-label fw-bold text-gray-700 fs-7">Kecamatan</label>
                <select id="filter_soth_kecamatan" class="form-select form-select-solid fw-semibold fs-7" onchange="filterSothKecamatan()">
                    <option value="all" selected>SEMUA KECAMATAN</option>
                    <option value="ASEMROWO">ASEMROWO</option>
                    <option value="BENOWO">BENOWO</option>
                    <option value="BUBUTAN">BUBUTAN</option>
                    <option value="BULAK">BULAK</option>
                    <option value="DUKUH PAKIS">DUKUH PAKIS</option>
                    <option value="GAYUNGAN">GAYUNGAN</option>
                    <option value="GENTENG">GENTENG</option>
                    <option value="GUBENG">GUBENG</option>
                    <option value="GUNUNG ANYAR">GUNUNG ANYAR</option>
                    <option value="JAMBANGAN">JAMBANGAN</option>
                    <option value="KARANG PILANG">KARANG PILANG</option>
                    <option value="KENJERAN">KENJERAN</option>
                    <option value="KREMBANGAN">KREMBANGAN</option>
                    <option value="LAKARSANTRI">LAKARSANTRI</option>
                    <option value="MULYOREJO">MULYOREJO</option>
                    <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                    <option value="PAKAL">PAKAL</option>
                    <option value="RUNGKUT">RUNGKUT</option>
                    <option value="SAMBIKEREP">SAMBIKEREP</option>
                    <option value="SAWAHAN">SAWAHAN</option>
                    <option value="SEMAMPIR">SEMAMPIR</option>
                    <option value="SIMOKERTO">SIMOKERTO</option>
                    <option value="SUKOLILO">SUKOLILO</option>
                    <option value="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                    <option value="TAMBAKSARI">TAMBAKSARI</option>
                    <option value="TANDES">TANDES</option>
                    <option value="TEGALSARI">TEGALSARI</option>
                    <option value="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>
                    <option value="WIYUNG">WIYUNG</option>
                    <option value="WONOCOLO">WONOCOLO</option>
                    <option value="WONOKROMO">WONOKROMO</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 pt-5 px-5 bg-transparent">
            <h5 class="card-title align-items-start flex-column mb-0">
                <span class="fw-bolder text-gray-800 fs-6 text-uppercase">NILAI RATA - RATA</span>
            </h5>
        </div>
        <div class="card-body px-5 pb-5 pt-0">
            <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="display:inline-block; width: 14px; height: 14px; background-color: #38bdf8; border-radius: 2px;"></span>
                    <span class="fs-8 fw-semibold text-gray-600">Pretest</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span style="display:inline-block; width: 14px; height: 14px; background-color: #fb7185; border-radius: 2px;"></span>
                    <span class="fs-8 fw-semibold text-gray-600">Posttest</span>
                </div>
            </div>
            <div style="min-height: 350px; width: 100%; position: relative;">
                <canvas id="chartSothNilai"></canvas>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 pt-5 px-5 bg-transparent d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-primary px-3 py-2 fw-bolder fs-7 rounded-2">DATA</span>
                <span class="fw-bolder text-gray-800 fs-6">SOTH</span>
            </div>
            <button type="button" class="btn btn-sm btn-primary fw-bold px-4 py-2 rounded-3" onclick="bukaModalTambahSoth()">
                <i class="ki-duotone ki-plus fs-6 me-1"></i> Input Data
            </button>
        </div>
        <div class="card-body px-5 pb-5 pt-2">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-4 gy-4">
                    <thead>
                        <tr class="fw-bolder fs-7 text-gray-600 text-uppercase bg-light rounded-2 border-0">
                            <th class="text-center min-w-40px">NO</th>
                            <th class="min-w-150px">NAMA</th>
                            <th class="min-w-180px">ALAMAT</th>
                            <th class="text-center min-w-50px">RT</th>
                            <th class="min-w-120px">KELURAHAN</th>
                            <th class="min-w-120px">KECAMATAN</th>
                            <th class="text-center min-w-100px">RATA-RATA PRE</th>
                            <th class="text-center min-w-100px">RATA-RATA POST</th>
                            <th class="text-center min-w-90px">TOTAL PESERTA</th>
                            <th class="text-center min-w-80px">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_soth_body" class="fs-7 fw-semibold text-gray-700">
                        <tr>
                            <td colspan="10" class="text-center py-8 text-gray-400">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center pt-4 border-top border-gray-100 gap-3">
                <div class="d-flex align-items-center gap-3">
                    <select id="soth_page_size" class="form-select form-select-sm form-select-solid w-75px" onchange="changeSothPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span id="soth_info_records" class="text-muted fs-8 fw-semibold">
                        Showing 0 to 0 of 0 records
                    </span>
                </div>
                <ul id="soth_pagination" class="pagination pagination-sm mb-0"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormSoth" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header pb-0 border-0 justify-content-between">
                <h3 class="fw-bold text-gray-900 m-0" id="modalFormSothTitle">Input Data SOTH</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"></i>
                </div>
            </div>
            <div class="modal-body scroll-y px-10 py-8">
                <form id="form_modal_soth" onsubmit="handleFormSothSubmit(event)">
                    <input type="hidden" id="soth_form_id">
                    
                    <div class="mb-4">
                        <label class="required fs-7 fw-bold text-gray-700 mb-2">Nama</label>
                        <input type="text" id="soth_form_nama" class="form-control form-control-solid" placeholder="Nama Lokasi / Tempat Belajar" required>
                    </div>

                    <div class="mb-4">
                        <label class="required fs-7 fw-bold text-gray-700 mb-2">Alamat</label>
                        <input type="text" id="soth_form_alamat" class="form-control form-control-solid" placeholder="Contoh: JL. WISMA TENGGER NO. 10" required>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">RT</label>
                            <input type="text" id="soth_form_rt" class="form-control form-control-solid" placeholder="Contoh: 01" required>
                        </div>
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">Kelurahan</label>
                            <input type="text" id="soth_form_kelurahan" class="form-control form-control-solid" placeholder="Nama Kelurahan" required>
                        </div>
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">Kecamatan</label>
                            <input type="text" id="soth_form_kecamatan" class="form-control form-control-solid" placeholder="Nama Kecamatan" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">Rata-rata Pre</label>
                            <input type="number" step="0.01" id="soth_form_pre" class="form-control form-control-solid" placeholder="0.00" required>
                        </div>
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">Rata-rata Post</label>
                            <input type="number" step="0.01" id="soth_form_post" class="form-control form-control-solid" placeholder="0.00" required>
                        </div>
                        <div class="col-4">
                            <label class="required fs-7 fw-bold text-gray-700 mb-2">Total Peserta</label>
                            <input type="number" id="soth_form_total" class="form-control form-control-solid" placeholder="0" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top border-gray-200">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="btn_submit_soth" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>