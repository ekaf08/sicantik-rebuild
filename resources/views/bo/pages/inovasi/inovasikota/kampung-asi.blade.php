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
                <div></div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center position-relative">
                        <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                        <input type="text" id="kampung_asi_search" class="form-control form-control-solid form-control-sm w-150px w-sm-175px" placeholder="Cari..." onkeyup="searchKampungAsiTable()">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pt-0 px-4 px-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">No</th>
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
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <select id="kampung_asi_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeKampungAsiPageSize()">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        </div>
                    <span class="text-gray-300">|</span>
                    <div id="kampung_asi_info_records" class="fs-7 text-gray-600">
                        Menampilkan 0 sampai 0 dari 0 data
                    </div>
                </div>
                <div>
                    <ul id="kampung_asi_pagination" class="pagination pagination-sm m-0 justify-content-center"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
