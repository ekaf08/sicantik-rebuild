<div class="d-flex flex-column gap-5">
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-8">
            <h2 class="fw-bolder text-gray-900 mb-1 fs-2">
                Inovasi Kampung ASI
            </h2>
            <h4 class="text-primary fw-bold text-uppercase tracking-wider fs-6 mb-3">
                Pemberian Air Susu Ibu Eksklusif
            </h4>
            <div class="bg-primary rounded-pill mb-4" style="height: 3px; width: 60px;"></div>
            <span class="text-gray-600 fs-6 lh-base mb-0 d-block mt-3">
                Inovasi Kampung ASI merupakan program pemberdayaan masyarakat dan peningkatan capaian ASI eksklusif di tingkat kelurahan dan kecamatan, dengan pemantauan terpadu jumlah kader, toga, ibu hamil, serta ibu menyusui.
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <div class="col-12 col-md-4">
                <label class="form-label fw-bold text-gray-700 fs-7">Kecamatan</label>
                <select id="filter_kampung_asi_kecamatan_top" class="form-select form-select-solid fw-semibold fs-7" onchange="filterKampungAsiKecamatanTop()">
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

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header border-0 pt-5 px-5 bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <span class="fw-bolder text-gray-800 fs-6 text-uppercase">NILAI PRESENTASE KAMPUNG ASI</span>
            </h5>
            <div class="w-200px">
                <select id="filter_kampung_asi_kecamatan_chart" class="form-select form-select-sm form-select-solid fw-semibold" onchange="filterKampungAsiChart()">
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
        <div class="card-body px-5 pb-5 pt-0">
            <div class="text-center mb-2">
                <span class="fs-6 fw-bolder text-gray-800 text-uppercase tracking-wide">KECAMATAN KOTA SURABAYA</span>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                <span style="display:inline-block; width: 24px; height: 10px; border: 2px dashed #38bdf8; background-color: rgba(56, 189, 248, 0.15); border-radius: 2px;"></span>
                <span class="fs-8 fw-semibold text-gray-600">Presentase Kampung ASI</span>
            </div>
            <div style="height: 350px; width: 100%; position: relative;">
                <canvas id="chartKampungAsiPersentase"></canvas>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body px-5 pb-5 pt-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div class="d-flex align-items-center gap-2">
                    <select id="kampung_asi_page_size" class="form-select form-select-sm form-select-solid w-75px" onchange="changeKampungAsiPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label class="fs-7 fw-semibold text-gray-600 mb-0">Search:</label>
                    <input type="text" id="kampung_asi_search" class="form-control form-control-sm form-control-solid w-200px" placeholder="" onkeyup="searchKampungAsiTable()">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-200 align-middle gs-4 gy-4">
                    <thead>
                        <tr class="fw-bolder fs-7 text-gray-600 text-uppercase bg-light rounded-2 border-0">
                            <th class="text-center min-w-50px">No <i class="ki-duotone ki-arrow-up fs-8"></i></th>
                            <th class="min-w-140px">Kecamatan</th>
                            <th class="min-w-140px">Kelurahan</th>
                            <th class="min-w-180px">Nama Kampung ASI</th>
                            <th class="text-center min-w-110px">Jumlah Kader</th>
                            <th class="text-center min-w-110px">Jumlah Toga</th>
                            <th class="text-center min-w-100px">Ibu Hamil</th>
                            <th class="text-center min-w-110px">Ibu Menyusui</th>
                            <th class="text-center min-w-100px">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_kampung_asi_body" class="fs-7 fw-semibold text-gray-700">
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-400">Belum ada data</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center pt-4 border-top border-gray-100 gap-3">
                <span id="kampung_asi_info_records" class="text-muted fs-8 fw-semibold">
                    Menampilkan 0 sampai 0 dari 0 data
                </span>
                <ul id="kampung_asi_pagination" class="pagination pagination-sm mb-0"></ul>
            </div>
        </div>
    </div>
</div>