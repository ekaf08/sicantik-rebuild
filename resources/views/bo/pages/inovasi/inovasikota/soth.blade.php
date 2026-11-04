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
                Program Sekolah Orang Tua Hebat, Kolaborasi Pemkot Surabaya, BKKBN, dan PKK untuk meningkatkan kualitas pengasuhan anak melalui pendidikan informal, mencegah stunting, membentuk karakter positif, dan memperkuat hubungan keluarga, dengan fokus pada orang tua balita (0-5 tahun) di setiap RW, melalui 14 materi pengasuhan dan gizi.
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">
            <div class="row g-4 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="form-label fw-bold text-gray-700 fs-7">Kecamatan</label>
                    <select id="filter_soth_kecamatan" class="form-select form-select-solid fw-semibold fs-7" onchange="handleSothKecamatanChange()">
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

                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold text-gray-700 fs-7">Kelurahan</label>
                    <select id="filter_soth_kelurahan" class="form-select form-select-solid fw-semibold fs-7" onchange="terapkanFilterSoth()">
                        <option value="all" selected>SEMUA KELURAHAN</option>
                        
                        {{-- ASEMROWO --}}
                        <option value="ASEMROWO" data-kecamatan="ASEMROWO">ASEMROWO</option>
                        <option value="GENTING KALIANAK" data-kecamatan="ASEMROWO">GENTING KALIANAK</option>
                        <option value="TAMBAK SARIOSO" data-kecamatan="ASEMROWO">TAMBAK SARIOSO</option>

                        {{-- BENOWO --}}
                        <option value="KANDANGAN" data-kecamatan="BENOWO">KANDANGAN</option>
                        <option value="ROMOKALISARI" data-kecamatan="BENOWO">ROMOKALISARI</option>
                        <option value="SEMIEMI" data-kecamatan="BENOWO">SEMIEMI</option>
                        <option value="TAMBAK OSOWILANGON" data-kecamatan="BENOWO">TAMBAK OSOWILANGON</option>

                        {{-- BUBUTAN --}}
                        <option value="ALUN-ALUN CONTONG" data-kecamatan="BUBUTAN">ALUN-ALUN CONTONG</option>
                        <option value="BUBUTAN" data-kecamatan="BUBUTAN">BUBUTAN</option>
                        <option value="GUNDIH" data-kecamatan="BUBUTAN">GUNDIH</option>
                        <option value="JEPARA" data-kecamatan="BUBUTAN">JEPARA</option>
                        <option value="TEMBOK DUKUH" data-kecamatan="BUBUTAN">TEMBOK DUKUH</option>

                        {{-- BULAK --}}
                        <option value="BULAK" data-kecamatan="BULAK">BULAK</option>
                        <option value="KEDUNG COWEK" data-kecamatan="BULAK">KEDUNG COWEK</option>
                        <option value="KENJERAN" data-kecamatan="BULAK">KENJERAN</option>
                        <option value="SUKOLILO BARU" data-kecamatan="BULAK">SUKOLILO BARU</option>

                        {{-- DUKUH PAKIS --}}
                        <option value="DUKUH KUPANG" data-kecamatan="DUKUH PAKIS">DUKUH KUPANG</option>
                        <option value="DUKUH PAKIS" data-kecamatan="DUKUH PAKIS">DUKUH PAKIS</option>
                        <option value="GUNUNG SARI" data-kecamatan="DUKUH PAKIS">GUNUNG SARI</option>
                        <option value="PRADAH KALIKENDAL" data-kecamatan="DUKUH PAKIS">PRADAH KALIKENDAL</option>

                        {{-- GAYUNGAN --}}
                        <option value="DUKUH MENANGGAL" data-kecamatan="GAYUNGAN">DUKUH MENANGGAL</option>
                        <option value="GAYUNGAN" data-kecamatan="GAYUNGAN">GAYUNGAN</option>
                        <option value="KETINTANG" data-kecamatan="GAYUNGAN">KETINTANG</option>
                        <option value="MENANGGAL" data-kecamatan="GAYUNGAN">MENANGGAL</option>

                        {{-- GENTENG --}}
                        <option value="EMBONG KALIASIN" data-kecamatan="GENTENG">EMBONG KALIASIN</option>
                        <option value="GENTENG" data-kecamatan="GENTENG">GENTENG</option>
                        <option value="KAPASARI" data-kecamatan="GENTENG">KAPASARI</option>
                        <option value="KETABANG" data-kecamatan="GENTENG">KETABANG</option>
                        <option value="PENELEH" data-kecamatan="GENTENG">PENELEH</option>

                        {{-- GUBENG --}}
                        <option value="AIRLANGGA" data-kecamatan="GUBENG">AIRLANGGA</option>
                        <option value="BARATA JAYA" data-kecamatan="GUBENG">BARATA JAYA</option>
                        <option value="GUBENG" data-kecamatan="GUBENG">GUBENG</option>
                        <option value="KERTAJAYA" data-kecamatan="GUBENG">KERTAJAYA</option>
                        <option value="MOJO" data-kecamatan="GUBENG">MOJO</option>

                        {{-- GUNUNG ANYAR --}}
                        <option value="GUNUNG ANYAR" data-kecamatan="GUNUNG ANYAR">GUNUNG ANYAR</option>
                        <option value="GUNUNG ANYAR TAMBAK" data-kecamatan="GUNUNG ANYAR">GUNUNG ANYAR TAMBAK</option>
                        <option value="RUNGKUT MENANGGAL" data-kecamatan="GUNUNG ANYAR">RUNGKUT MENANGGAL</option>
                        <option value="RUNGKUT TENGAH" data-kecamatan="GUNUNG ANYAR">RUNGKUT TENGAH</option>

                        {{-- JAMBANGAN --}}
                        <option value="JAMBANGAN" data-kecamatan="JAMBANGAN">JAMBANGAN</option>
                        <option value="KARAH" data-kecamatan="JAMBANGAN">KARAH</option>
                        <option value="KEBONSARI" data-kecamatan="JAMBANGAN">KEBONSARI</option>
                        <option value="PAGESANGAN" data-kecamatan="JAMBANGAN">PAGESANGAN</option>

                        {{-- KARANG PILANG --}}
                        <option value="KARANG PILANG" data-kecamatan="KARANG PILANG">KARANG PILANG</option>
                        <option value="KEDURUS" data-kecamatan="KARANG PILANG">KEDURUS</option>
                        <option value="KRAKSAAN" data-kecamatan="KARANG PILANG">KRAKSAAN</option>
                        <option value="WARUGUNUNG" data-kecamatan="KARANG PILANG">WARUGUNUNG</option>

                        {{-- KENJERAN --}}
                        <option value="BULAK BANTENG" data-kecamatan="KENJERAN">BULAK BANTENG</option>
                        <option value="TAMBAK WEDI" data-kecamatan="KENJERAN">TAMBAK WEDI</option>
                        <option value="TANAH KALI KEDINDING" data-kecamatan="KENJERAN">TANAH KALI KEDINDING</option>
                        <option value="SIDOTOPO WETAN" data-kecamatan="KENJERAN">SIDOTOPO WETAN</option>

                        {{-- KREMBANGAN --}}
                        <option value="DUPAK" data-kecamatan="KREMBANGAN">DUPAK</option>
                        <option value="KEMAYORAN" data-kecamatan="KREMBANGAN">KEMAYORAN</option>
                        <option value="KREMBANGAN SELATAN" data-kecamatan="KREMBANGAN">KREMBANGAN SELATAN</option>
                        <option value="MOROKREMBANGAN" data-kecamatan="KREMBANGAN">MOROKREMBANGAN</option>
                        <option value="PERAK BARAT" data-kecamatan="KREMBANGAN">PERAK BARAT</option>

                        {{-- LAKARSANTRI --}}
                        <option value="BANGKINGAN" data-kecamatan="LAKARSANTRI">BANGKINGAN</option>
                        <option value="JERUK" data-kecamatan="LAKARSANTRI">JERUK</option>
                        <option value="LAKARSANTRI" data-kecamatan="LAKARSANTRI">LAKARSANTRI</option>
                        <option value="LIDAH KULON" data-kecamatan="LAKARSANTRI">LIDAH KULON</option>
                        <option value="LIDAH WETAN" data-kecamatan="LAKARSANTRI">LIDAH WETAN</option>
                        <option value="SUMUR WELUT" data-kecamatan="LAKARSANTRI">SUMUR WELUT</option>

                        {{-- MULYOREJO --}}
                        <option value="DUKUH SUTOREJO" data-kecamatan="MULYOREJO">DUKUH SUTOREJO</option>
                        <option value="KALICARI" data-kecamatan="MULYOREJO">KALICARI</option>
                        <option value="KALISARI" data-kecamatan="MULYOREJO">KALISARI</option>
                        <option value="KEJAWAN PUTIH TAMBAK" data-kecamatan="MULYOREJO">KEJAWAN PUTIH TAMBAK</option>
                        <option value="MANYAR SABRANGAN" data-kecamatan="MULYOREJO">MANYAR SABRANGAN</option>
                        <option value="MULYOREJO" data-kecamatan="MULYOREJO">MULYOREJO</option>

                        {{-- PABEAN CANTIAN --}}
                        <option value="BONGKARAN" data-kecamatan="PABEAN CANTIAN">BONGKARAN</option>
                        <option value="CREMBO" data-kecamatan="PABEAN CANTIAN">CREMBO</option>
                        <option value="NYAMPLUNGAN" data-kecamatan="PABEAN CANTIAN">NYAMPLUNGAN</option>
                        <option value="PERAK TIMUR" data-kecamatan="PABEAN CANTIAN">PERAK TIMUR</option>
                        <option value="PERAK UTARA" data-kecamatan="PABEAN CANTIAN">PERAK UTARA</option>

                        {{-- PAKAL --}}
                        <option value="BABAT JERAWAT" data-kecamatan="PAKAL">BABAT JERAWAT</option>
                        <option value="BENOWO" data-kecamatan="PAKAL">BENOWO</option>
                        <option value="PAKAL" data-kecamatan="PAKAL">PAKAL</option>
                        <option value="SUMBEREJO" data-kecamatan="PAKAL">SUMBEREJO</option>

                        {{-- RUNGKUT --}}
                        <option value="KALIRUNGKUT" data-kecamatan="RUNGKUT">KALIRUNGKUT</option>
                        <option value="KEDUNG BARUK" data-kecamatan="RUNGKUT">KEDUNG BARUK</option>
                        <option value="MEDOKAN AYU" data-kecamatan="RUNGKUT">MEDOKAN AYU</option>
                        <option value="PENJARINGANSARI" data-kecamatan="RUNGKUT">PENJARINGANSARI</option>
                        <option value="RUNGKUT KIDUL" data-kecamatan="RUNGKUT">RUNGKUT KIDUL</option>
                        <option value="WONOREJO" data-kecamatan="RUNGKUT">WONOREJO</option>

                        {{-- SAMBIKEREP --}}
                        <option value="BRINGIN" data-kecamatan="SAMBIKEREP">BRINGIN</option>
                        <option value="LONTAR" data-kecamatan="SAMBIKEREP">LONTAR</option>
                        <option value="MADE" data-kecamatan="SAMBIKEREP">MADE</option>
                        <option value="SAMBIKEREP" data-kecamatan="SAMBIKEREP">SAMBIKEREP</option>

                        {{-- SAWAHAN --}}
                        <option value="BANYU URIP" data-kecamatan="SAWAHAN">BANYU URIP</option>
                        <option value="KUPANG KRAJAN" data-kecamatan="SAWAHAN">KUPANG KRAJAN</option>
                        <option value="PETEMON" data-kecamatan="SAWAHAN">PETEMON</option>
                        <option value="PUTAT JAYA" data-kecamatan="SAWAHAN">PUTAT JAYA</option>
                        <option value="SAWAHAN" data-kecamatan="SAWAHAN">SAWAHAN</option>
                        <option value="TEMBOK DUKUH" data-kecamatan="SAWAHAN">TEMBOK DUKUH</option>

                        {{-- SEMAMPIR --}}
                        <option value="AMPEL" data-kecamatan="SEMAMPIR">AMPEL</option>
                        <option value="PEGIRIAN" data-kecamatan="SEMAMPIR">PEGIRIAN</option>
                        <option value="SIDOTOPO" data-kecamatan="SEMAMPIR">SIDOTOPO</option>
                        <option value="UJUNG" data-kecamatan="SEMAMPIR">UJUNG</option>
                        <option value="WONOKUSUMO" data-kecamatan="SEMAMPIR">WONOKUSUMO</option>

                        {{-- SIMOKERTO --}}
                        <option value="KAPASAN" data-kecamatan="SIMOKERTO">KAPASAN</option>
                        <option value="SIDODADI" data-kecamatan="SIMOKERTO">SIDODADI</option>
                        <option value="SIMOKERTO" data-kecamatan="SIMOKERTO">SIMOKERTO</option>
                        <option value="SIMOLAWANG" data-kecamatan="SIMOKERTO">SIMOLAWANG</option>
                        <option value="TAMBAKREJO" data-kecamatan="SIMOKERTO">TAMBAKREJO</option>

                        {{-- SUKOLILO --}}
                        <option value="GEBANG PUTIH" data-kecamatan="SUKOLILO">GEBANG PUTIH</option>
                        <option value="KEPUTIH" data-kecamatan="SUKOLILO">KEPUTIH</option>
                        <option value="KLAMPIS NGASEM" data-kecamatan="SUKOLILO">KLAMPIS NGASEM</option>
                        <option value="MEDOKAN SEMAMPIR" data-kecamatan="SUKOLILO">MEDOKAN SEMAMPIR</option>
                        <option value="MENUR PUMPUNGAN" data-kecamatan="SUKOLILO">MENUR PUMPUNGAN</option>
                        <option value="NGINDEN JANGKUNGAN" data-kecamatan="SUKOLILO">NGINDEN JANGKUNGAN</option>
                        <option value="SEMOLOWARU" data-kecamatan="SUKOLILO">SEMOLOWARU</option>

                        {{-- SUKOMANUNGGAL --}}
                        <option value="PATEMON" data-kecamatan="SUKOMANUNGGAL">PATEMON</option>
                        <option value="SIMOMULYO" data-kecamatan="SUKOMANUNGGAL">SIMOMULYO</option>
                        <option value="SIMOMULYO BARU" data-kecamatan="SUKOMANUNGGAL">SIMOMULYO BARU</option>
                        <option value="SONOKWIJENAN" data-kecamatan="SUKOMANUNGGAL">SONOKWIJENAN</option>
                        <option value="SUKOMANUNGGAL" data-kecamatan="SUKOMANUNGGAL">SUKOMANUNGGAL</option>
                        <option value="TANJUNGSARI" data-kecamatan="SUKOMANUNGGAL">TANJUNGSARI</option>

                        {{-- TAMBAKSARI --}}
                        <option value="DUKUH SETRO" data-kecamatan="TAMBAKSARI">DUKUH SETRO</option>
                        <option value="GADING" data-kecamatan="TAMBAKSARI">GADING</option>
                        <option value="KAPASMADYA BARU" data-kecamatan="TAMBAKSARI">KAPASMADYA BARU</option>
                        <option value="PACARKELING" data-kecamatan="TAMBAKSARI">PACARKELING</option>
                        <option value="PACARKEMBANG" data-kecamatan="TAMBAKSARI">PACARKEMBANG</option>
                        <option value="PLOSO" data-kecamatan="TAMBAKSARI">PLOSO</option>
                        <option value="RANGKAH" data-kecamatan="TAMBAKSARI">RANGKAH</option>
                        <option value="TAMBAKSARI" data-kecamatan="TAMBAKSARI">TAMBAKSARI</option>

                        {{-- TANDES --}}
                        <option value="BALONGSARI" data-kecamatan="TANDES">BALONGSARI</option>
                        <option value="BANJAR SUGIHAN" data-kecamatan="TANDES">BANJAR SUGIHAN</option>
                        <option value="KARANG POH" data-kecamatan="TANDES">KARANG POH</option>
                        <option value="MANUKAN KULON" data-kecamatan="TANDES">MANUKAN KULON</option>
                        <option value="MANUKAN WETAN" data-kecamatan="TANDES">MANUKAN WETAN</option>
                        <option value="TANDES" data-kecamatan="TANDES">TANDES</option>

                        {{-- TEGALSARI --}}
                        <option value="DR. SOETOMO" data-kecamatan="TEGALSARI">DR. SOETOMO</option>
                        <option value="KEDUNGDORO" data-kecamatan="TEGALSARI">KEDUNGDORO</option>
                        <option value="KEPUTRAN" data-kecamatan="TEGALSARI">KEPUTRAN</option>
                        <option value="TEGALSARI" data-kecamatan="TEGALSARI">TEGALSARI</option>
                        <option value="WONOREJO" data-kecamatan="TEGALSARI">WONOREJO</option>

                        {{-- TENGGILIS MEJOYO --}}
                        <option value="KENDANGSARI" data-kecamatan="TENGGILIS MEJOYO">KENDANGSARI</option>
                        <option value="KUTISARI" data-kecamatan="TENGGILIS MEJOYO">KUTISARI</option>
                        <option value="PANJANG JIWO" data-kecamatan="TENGGILIS MEJOYO">PANJANG JIWO</option>
                        <option value="PRAPEN" data-kecamatan="TENGGILIS MEJOYO">PRAPEN</option>
                        <option value="TENGGILIS MEJOYO" data-kecamatan="TENGGILIS MEJOYO">TENGGILIS MEJOYO</option>

                        {{-- WIYUNG --}}
                        <option value="BABATAN" data-kecamatan="WIYUNG">BABATAN</option>
                        <option value="BALASKLUMPRIK" data-kecamatan="WIYUNG">BALASKLUMPRIK</option>
                        <option value="JAJAR TUNGGAL" data-kecamatan="WIYUNG">JAJAR TUNGGAL</option>
                        <option value="WIYUNG" data-kecamatan="WIYUNG">WIYUNG</option>

                        {{-- WONOCOLO --}}
                        <option value="BENDUL MERISI" data-kecamatan="WONOCOLO">BENDUL MERISI</option>
                        <option value="JEMUR WONOSARI" data-kecamatan="WONOCOLO">JEMUR WONOSARI</option>
                        <option value="MARGOREJO" data-kecamatan="WONOCOLO">MARGOREJO</option>
                        <option value="SIDOSERMO" data-kecamatan="WONOCOLO">SIDOSERMO</option>
                        <option value="SIWALANKERTO" data-kecamatan="WONOCOLO">SIWALANKERTO</option>

                        {{-- WONOKROMO --}}
                        <option value="DARMO" data-kecamatan="WONOKROMO">DARMO</option>
                        <option value="JAGIR" data-kecamatan="WONOKROMO">JAGIR</option>
                        <option value="NGAGEL" data-kecamatan="WONOKROMO">NGAGEL</option>
                        <option value="NGAGELREJO" data-kecamatan="WONOKROMO">NGAGELREJO</option>
                        <option value="SAWUNGGALING" data-kecamatan="WONOKROMO">SAWUNGGALING</option>
                        <option value="WONOKROMO" data-kecamatan="WONOKROMO">WONOKROMO</option>
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label fw-bold text-gray-700 fs-7">Periode / Tahun</label>
                    <select id="filter_soth_tahun" class="form-select form-select-solid fw-semibold fs-7" onchange="terapkanFilterSoth()">
                        <option value="all" selected>SEMUA TAHUN</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
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
        <div class="card-header border-0 pt-5 px-5 bg-transparent d-flex flex-wrap justify-content-between align-items-center gap-3">
           <div class="d-flex align-items-center">
                <span class="badge badge-success px-4 py-2 fw-bolder fs-7 rounded-2 text-white">
                    DATA SOTH
                </span>
            </div>

            <div class="position-relative w-100 w-md-250px">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3 top-50 translate-middle-y text-gray-500"></i>
                <input type="text" id="soth_search_input" class="form-control form-control-solid ps-10 fs-7" placeholder="Cari nama / alamat..." autocomplete="off">
            </div>
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
                            <th class="text-center min-w-50px">RW</th>
                            <th class="min-w-120px">KELURAHAN</th>
                            <th class="min-w-120px">KECAMATAN</th>
                            <th class="text-center min-w-100px">RATA-RATA PRE</th>
                            <th class="text-center min-w-100px">RATA-RATA POST</th>
                            <th class="text-center min-w-90px">TOTAL PESERTA</th>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/pages/soth.js') }}"></script>