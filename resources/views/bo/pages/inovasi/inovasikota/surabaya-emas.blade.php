<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm">
        <div class="card-body p-5 p-md-7">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-4 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-3 fw-bolder text-gray-800">Inovasi Surabaya Emas</span>
                </div>
            </div>
            <div style="width: 48px; height: 3px; background-color: #009ef7; border-radius: 2px;" class="mb-3 mb-md-4"></div>
            <p class="text-gray-600 fs-7 fs-md-6 lh-base mb-0">
                Surabaya Emas merupakan komitmen Pemerintah Kota Surabaya dalam membentuk generasi yang berakhlak mulia, sehat, cerdas, dan berdaya saing.Di bidang kesehatan, program Bersama Wujudkan Surabaya Emas (BWSE) dijalankan untuk mencegah dan menurunkan stunting melalui pendampingan gizi, pola asuh, serta pemantauan kesehatan secara berkelanjutan. Secara keseluruhan, Surabaya Emas mencerminkan upaya nyata pemerintah dalam menciptakan warga Surabaya yang unggul, berprestasi, dan siap menghadapi tantangan masa depan.
            </p>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-body p-5 p-md-6">
            <div class="row g-4 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Kecamatan</label>
                    <select id="filter_surabaya_emas_kecamatan" class="form-select form-select-solid fw-semibold" onchange="handleSurabayaEmasKecamatanChange()">
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
                <div class="col-12 col-md-3">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Kelurahan</label>
                    <select id="filter_surabaya_emas_kelurahan" class="form-select form-select-solid fw-semibold">
                        <option value="all" selected>Semua Kelurahan</option>
                        @php
                            $listKel = isset($kelurahan) && count($kelurahan) > 0 
                                ? $kelurahan 
                                : \Illuminate\Support\Facades\DB::table('m_kelurahan')->orderBy('nama_kel', 'asc')->get();
                        @endphp
                        @foreach($listKel as $k)
                            <option value="{{ $k->nama_kel }}">{{ $k->nama_kel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label class="form-label fw-bold text-gray-700 fs-7 mb-2">Tahun</label>
                    <select id="filter_surabaya_emas_tahun" class="form-select form-select-solid fw-semibold">
                        <option value="all" selected>Semua</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="button" class="btn btn-primary fw-bold w-100" onclick="terapkanFilterSurabayaEmas()">
                        Terapkan
                    </button>
                    <button type="button" class="btn btn-dark fw-bold w-100" onclick="resetFilterSurabayaEmas()">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header pt-6">
            <h3 class="card-title w-100 justify-content-center text-uppercase fw-bolder text-gray-800 fs-5 fs-md-4 tracking-wide">
                KECAMATAN KOTA SURABAYA
            </h3>
        </div>
        <div class="card-body pt-0 px-3 px-md-6 pb-6">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="chartSurabayaEmas"></canvas>
            </div>
        </div>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-header pt-5 px-4 px-md-6">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100 gap-3">
                <div class="d-flex align-items-center gap-2">
                    <select id="surabaya_emas_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeSurabayaEmasPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>                
                </div>
                <div class="d-flex align-items-center position-relative">
                    <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                    <input type="text" id="surabaya_emas_search" class="form-control form-control-solid form-control-sm w-150px w-sm-200px" onkeyup="searchSurabayaEmasTable()">
                </div>
            </div>
        </div>
        
        <div class="card-body pt-0 px-4 px-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7 mb-0">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">No ^</th>
                            <th class="min-w-160px">Nama Balita</th>
                            <th class="min-w-110px">Tanggal Lahir</th>
                            <th class="text-center min-w-100px">Jenis Kelamin</th>
                            <th class="min-w-180px">Alamat Domisili</th>
                            <th class="min-w-130px">Kelurahan Domisili</th>
                            <th class="min-w-130px">Kecamatan Domisili</th>
                            <th class="text-center min-w-80px">TPK</th>
                            <th class="text-center min-w-80px">Tahun</th>
                            <th class="text-center min-w-80px">Detail</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_surabaya_emas_body">
                        <tr>
                            <td colspan="10" class="text-center py-6 text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4">
                <div id="surabaya_emas_info_records" class="fs-7 text-gray-600 text-center text-sm-start">
                    Menampilkan 0 sampai 0 dari 0 data
                </div>
                <ul id="surabaya_emas_pagination" class="pagination pagination-sm m-0 justify-content-center"></ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailBalita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-850px">
        <div class="modal-content">
            <div class="modal-header pb-3 border-0">
                <h2 class="fw-bolder fs-4 text-gray-800 mb-0">Detail Balita</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body pt-0 px-6 px-md-8 pb-6">
                <div class="text-center mb-4">
                    <h5 class="fw-bolder text-gray-800 text-uppercase tracking-wide mb-3">DETAIL RIWAYAT TIMBANG BALITA</h5>
                    <div class="d-inline-block text-start fs-7">
                        <div class="row g-2 mb-1">
                            <div class="col-auto text-gray-600 fw-bold w-60px">NIK</div>
                            <div class="col-auto text-gray-800 fw-bold">: <span id="detail_balita_nik">-</span></div>
                        </div>
                        <div class="row g-2">
                            <div class="col-auto text-gray-600 fw-bold w-60px">Nama</div>
                            <div class="col-auto text-gray-800 fw-bold">: <span id="detail_balita_nama">-</span></div>
                        </div>
                    </div>
                </div>

                <div class="card card-flush shadow-none border border-gray-200 mb-5">
                    <div class="card-header border-0 py-3 px-4 rounded-top" style="background-color: #f1f4f9;">
                        <span class="fs-7 fw-bolder text-gray-800 text-uppercase tracking-wide mb-0">
                            PENINGKATAN RATA-RATA PER BULAN
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div style="position: relative; height: 220px; width: 100%;">
                            <canvas id="chartDetailRiwayatBalita"></canvas>
                        </div>
                    </div>
                </div>

                <div class="table-responsive border rounded">
                    <table class="table table-bordered table-row-dashed gy-3 align-middle fs-8 mb-0">
                        <thead class="bg-light-secondary text-gray-700 fw-bold text-center text-uppercase">
                            <tr class="align-middle text-nowrap">
                                <th class="w-40px">NO ^</th>
                                <th class="min-w-100px">TANGGAL TIMBANG</th>
                                <th class="min-w-80px">TINGGI BADAN</th>
                                <th class="min-w-80px">BERAT BADAN</th>
                                <th class="min-w-60px">LILA</th>
                                <th class="min-w-60px">TBU</th>
                                <th class="min-w-60px">BBU</th>
                                <th class="min-w-60px">BBTB</th>
                                <th class="min-w-70px">STATUS GIZI</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_detail_balita_body" class="text-center text-gray-800"></tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap pt-4">
                    <div id="detail_balita_info" class="fs-8 text-gray-600">
                        Showing 1 to 5 of 5 records
                    </div>
                    <ul id="detail_balita_pagination" class="pagination pagination-sm m-0">
                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">&lt;</a></li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="javascript:void(0)">&gt;</a></li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0 px-6 px-md-8 pb-5 justify-content-end">
                <button type="button" class="btn btn-sm btn-secondary text-gray-700 fw-bold px-5" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>