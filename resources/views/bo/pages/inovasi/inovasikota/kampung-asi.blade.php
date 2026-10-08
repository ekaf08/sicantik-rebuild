<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm">
        <div class="card-body p-5 p-md-7">
            <h3 class="fs-3 fs-md-2 fw-bolder text-gray-900 mb-1">Inovasi Kampung ASI</h3>
            <div style="width: 48px; height: 3px; background-color: #009ef7; border-radius: 2px;" class="mb-3 mb-md-4"></div>
            <p class="text-gray-600 fs-7 fs-md-6 lh-base mb-0">
                Program Kampung ASI merupakan inovasi percepatan pembinaan pemenuhan gizi keluarga berbasis masyarakat guna mendukung pemberian ASI Eksklusif, meningkatkan kualitas pengasuhan serta kesehatan ibu dan anak, mencegah stunting sejak dini, dan memperkuat kepedulian lingkungan keluarga di setiap wilayah. Harapannya dengan adanya program ini, tercipta lingkungan yang ramah dan suportif bagi ibu hamil serta menyusui.
            </p>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header border-bottom border-gray-200 pt-4 px-4 px-md-6 pb-4 bg-white rounded-top">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <span class="fs-7 fs-md-6 fw-bolder text-gray-800 text-uppercase tracking-wide mb-0">
                    NILAI PRESENTASE KAMPUNG ASI
                </span>
                <div class="w-100 w-sm-auto">
                    <select id="filter_kampung_asi_kecamatan_top" 
                            class="form-select form-select-sm form-select-solid fw-semibold bg-white border border-gray-300 w-100 w-sm-200px" 
                            onchange="filterKampungAsiKecamatanTop()">
                        <option value="all" selected>Pilih Kecamatan</option>
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
                        <option value="LAKAR SANTRI">LAKAR SANTRI</option>
                        <option value="MULYOREJO">MULYOREJO</option>
                        <option value="PABEAN CANTIAN">PABEAN CANTIAN</option>
                        <option value="PAKAL">PAKAL</option>
                        <option value="RUNGKUT">RUNGKUT</option>
                        <option value="SAMBI KEREP">SAMBI KEREP</option>
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
        
        <div class="card-body pt-3 pb-5 px-3 px-md-6">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="chartKampungAsiPersentase"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header pt-5 px-4 px-md-6">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <div class="d-flex align-items-center gap-2">
                    <select id="kampung_asi_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeKampungAsiPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="fs-7 text-gray-600">data/halaman</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center position-relative">
                        <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                        <input type="text" id="kampung_asi_search" class="form-control form-control-solid form-control-sm w-150px w-sm-175px" onkeyup="searchKampungAsiTable()">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1 text-nowrap" data-bs-toggle="modal" data-bs-target="#modalTambahKampungAsi">
                        <i class="ki-duotone ki-plus fs-4"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body pt-0 px-4 px-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">No ^</th>
                            <th class="min-w-110px">Kecamatan</th>
                            <th class="min-w-110px">Kelurahan</th>
                            <th class="min-w-150px">Nama Kampung ASI</th>
                            <th class="text-center min-w-90px">Jumlah Kader</th>
                            <th class="text-center min-w-90px">Jumlah Toga</th>
                            <th class="text-center min-w-80px">Ibu Hamil</th>
                            <th class="text-center min-w-90px">Ibu Menyusui</th>
                            <th class="text-center min-w-80px">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_kampung_asi_body">
                        <tr>
                            <td colspan="9" class="text-center py-6 text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4">
                <div id="kampung_asi_info_records" class="fs-7 text-gray-600 text-center text-sm-start">
                    Menampilkan 0 sampai 0 dari 0 data
                </div>
                <ul id="kampung_asi_pagination" class="pagination pagination-sm m-0 justify-content-center"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKampungAsi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold fs-4 mb-0">Tambah Data Kampung ASI</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form id="formTambahKampungAsi" onsubmit="submitFormKampungAsi(event)">
                <div class="modal-body py-5 px-lg-8">
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control form-control-sm form-control-solid" placeholder="Nama Kecamatan" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control form-control-sm form-control-solid" placeholder="Nama Kelurahan" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-semibold fs-7 mb-1">Nama Kampung ASI</label>
                        <input type="text" name="nama_kampung_asi" class="form-control form-control-sm form-control-solid">
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-6 col-md-3">
                            <label class="required form-label fw-semibold fs-7 mb-1">Jumlah Kader</label>
                            <input type="number" name="jumlah_kader" class="form-control form-control-sm form-control-solid" min="0" value="0" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="required form-label fw-semibold fs-7 mb-1">Jumlah TOGA</label>
                            <input type="number" name="jumlah_toga" class="form-control form-control-sm form-control-solid" min="0" value="0" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="required form-label fw-semibold fs-7 mb-1">Ibu Hamil</label>
                            <input type="number" name="ibu_hamil" class="form-control form-control-sm form-control-solid" min="0" value="0" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="required form-label fw-semibold fs-7 mb-1">Ibu Menyusui</label>
                            <input type="number" name="ibu_menyusui" class="form-control form-control-sm form-control-solid" min="0" value="0" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="required form-label fw-semibold fs-7 mb-1">Persentase (%)</label>
                        <input type="number" name="persentase" class="form-control form-control-sm form-control-solid" min="0" max="100" placeholder="0 - 100" required>
                    </div>
                </div>
                <div class="modal-footer flex-center py-4">
                    <button type="reset" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanKampungAsi" class="btn btn-primary btn-sm">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress d-none">Menyimpan... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>