@extends('bo.layout.app')

@section('content')
<style>
    .banner-kebijakan-card {
        background: #0f5847 radial-gradient(#197862 1.5px, transparent 1.5px);
        background-size: 16px 16px;
        min-height: 180px;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    .banner-silhouette-bg {
        position: absolute;
        right: 0;
        bottom: 0;
        top: 0;
        width: 320px;
        background: radial-gradient(circle at right bottom, rgba(29, 142, 116, 0.45) 0%, transparent 70%);
        pointer-events: none;
    }
    .banner-silhouette-vector {
        position: absolute;
        right: 25px;
        bottom: -10px;
        height: 190px;
        opacity: 0.28;
        pointer-events: none;
    }
    .btn-tambah-sk {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: #ffffff;
        transition: all 0.25s ease-in-out;
    }
    .btn-tambah-sk:hover {
        background: #ffffff !important;
        color: #0f5847 !important;
        border-color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    .compact-select {
        height: 32px !important;
        padding-top: 3px !important;
        padding-bottom: 3px !important;
        font-size: 12px !important;
        border-color: #d1d5db !important;
        background-color: #ffffff !important;
    }
    .page-item.active .page-link {
        background-color: #0f5847 !important;
        border-color: #0f5847 !important;
        color: #ffffff !important;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        background: #f8f9fa;
        cursor: pointer;
    }
    .btn-action-pdf {
        background: #d1f2e4;
        border-color: #bbf7d0;
    }
    .btn-action-pdf:hover {
        background: #bbf7d0;
        border-color: #86efac;
        transform: translateY(-1px);
    }
    .btn-action-edit {
        background: #eff6ff;
        border-color: #bfdbfe;
    }
    .btn-action-edit:hover {
        background: #dbeafe;
        border-color: #93c5fd;
        transform: translateY(-1px);
    }
    .btn-action-delete {
        background: #fff1f2;
        border-color: #fecdd3;
    }
    .btn-action-delete:hover {
        background: #ffe4e6;
        border-color: #fda4af;
        transform: translateY(-1px);
    }
    .suggestion-item:hover {
        background-color: #f1f5f9;
    }
</style>

<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm banner-kebijakan-card border-0">
        <div class="card-body p-6 p-md-8 d-flex flex-column flex-md-row justify-content-between align-items-md-center position-relative z-index-2 gap-4">
            <div class="text-white">
                <h1 class="fs-2x fw-bolder text-white mb-2 tracking-wide">KEBIJAKAN</h1>
                <p class="fs-6 text-white text-opacity-80 mb-0">
                    Berikut adalah data kebijakan yang telah diinputkan
                </p>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-tambah-sk fw-bold px-5 py-3 rounded-3 shadow-sm d-flex align-items-center gap-2" onclick="bukaModalTambahKebijakan()">
                    <span class="fs-4 lh-1 fw-bold">+</span>
                    <span class="fs-7 fw-bolder text-uppercase">Tambah SK</span>
                </button>
            </div>
        </div>
        <div class="banner-silhouette-bg"></div>
        <svg class="banner-silhouette-vector d-none d-md-block" viewBox="0 0 100 100" fill="#ffffff">
            <polygon points="50,0 54,40 60,40 60,100 40,100 40,40 46,40"/>
            <polygon points="15,45 25,45 25,100 15,100"/>
            <polygon points="75,35 88,35 88,100 75,100"/>
        </svg>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-body p-6">
            <div class="d-flex justify-content-end align-items-center mb-5">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <select id="filter_kebijakan_id_kec" class="form-select form-select-sm compact-select" style="width: 140px;" onchange="handleFilterKecamatanChange()">
                        <option value="all" selected>Pilih Kecamatan</option>
                    </select>
                    <div class="position-relative" style="width: 175px;">
                        <input type="text" 
                               id="input_filter_kelurahan" 
                               class="form-control form-control-sm compact-select pe-6" 
                               placeholder="Cari Kelurahan..." 
                               autocomplete="off"
                               onkeyup="handleKelurahanSearchInput(this.value)">
                        
                        <button type="button" 
                                id="btn_clear_kelurahan" 
                                class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y me-1 d-none text-gray-500 hover-text-danger" 
                                style="width: 20px; height: 20px; border: none; background: transparent;" 
                                onclick="resetFilterKelurahan()" 
                                title="Reset">
                            ✕
                        </button>

                        <div id="kelurahan_suggestions" 
                             class="position-absolute bg-white border border-gray-300 rounded-2 shadow-sm w-100 mt-1 d-none" 
                             style="max-height: 220px; overflow-y: auto; z-index: 1050; font-size: 12px;">
                        </div>
                    </div>
                    <select id="filter_kebijakan_tahun" class="form-select form-select-sm compact-select" style="width: 110px;" onchange="fetchTableKebijakan(1)">
                        <option value="all" selected>Semua Tahun</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>

                    <select id="filter_kebijakan_pokja" class="form-select form-select-sm compact-select" style="width: 120px;" onchange="fetchTableKebijakan(1)">
                        <option value="all" selected>Semua Pokja</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Pokja 1">Pokja 1</option>
                        <option value="Pokja 2">Pokja 2</option>
                        <option value="Pokja 3">Pokja 3</option>
                        <option value="Pokja 4">Pokja 4</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-7 text-gray-700">Show</span>
                    <select id="kebijakan_page_size" class="form-select form-select-solid form-select-sm w-70px" onchange="changeKebijakanPageSize()">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <span class="fs-7 fw-bold text-gray-700 me-2 text-nowrap">Search:</span>
                    <input type="text" id="kebijakan_search" class="form-control form-control-solid form-control-sm w-150px w-sm-200px" placeholder="Cari nomor SK / perihal..." onkeyup="searchKebijakanTable()">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-row-dashed gy-3 align-middle fs-7 mb-0">
                    <thead class="bg-light-secondary text-gray-700 fw-bold">
                        <tr class="align-middle text-nowrap">
                            <th class="text-center min-w-40px">NO ^</th>
                            <th class="min-w-150px">No SK</th>
                            <th class="min-w-180px">Perihal</th>
                            <th class="min-w-100px">Pokja</th>
                            <th class="text-center min-w-90px">Tgl Mulai</th>
                            <th class="text-center min-w-90px">Tgl Selesai</th>
                            <th class="text-center min-w-60px">File</th>
                            <th class="min-w-150px">Keterangan</th>
                            <th class="min-w-110px">Dibuat Oleh</th>
                            <th class="text-center min-w-90px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tabel_kebijakan_body">
                        <tr>
                            <td colspan="10" class="text-center py-6 text-gray-500">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 pt-4">
                <div id="kebijakan_info_records" class="fs-7 text-gray-600 text-center text-sm-start">
                    Showing 0 to 0 of 0 records
                </div>
                <ul id="kebijakan_pagination" class="pagination pagination-sm m-0 justify-content-center justify-content-sm-end"></ul>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalKebijakan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header py-4 px-6 border-bottom">
                <h2 class="fw-bold fs-4 mb-0" id="modalKebijakanTitle">Tambah Lampiran SK</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formKebijakan" onsubmit="submitFormKebijakan(event)">
                @csrf
                <input type="hidden" id="kebijakan_id" name="id">
                <div class="modal-body py-5 px-lg-8">
                    <div class="mb-4">
                        <label class="required form-label fw-semibold fs-7 mb-1">No SK</label>
                        <input type="text" id="kebijakan_no_sk" name="no_sk" class="form-control form-control-sm form-control-solid" placeholder="Contoh: 188.45/123/436.7.2/2026" required>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-semibold fs-7 mb-1">Perihal</label>
                        <input type="text" id="kebijakan_perihal" name="perihal" class="form-control form-control-sm form-control-solid" placeholder="Perihal SK" required>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Tanggal Mulai</label>
                            <input type="date" id="kebijakan_tgl_mulai" name="tgl_mulai" class="form-control form-control-sm form-control-solid" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Tanggal Selesai</label>
                            <input type="date" id="kebijakan_tgl_selesai" name="tgl_selesai" class="form-control form-control-sm form-control-solid">
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Tahun</label>
                            <input type="number" id="kebijakan_tahun" name="tahun" class="form-control form-control-sm form-control-solid" placeholder="Otomatis dari tanggal mulai">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Pokja</label>
                            <select id="kebijakan_pokja" name="pokja" class="form-select form-select-sm form-select-solid">
                                <option value="">Pilih Pokja</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="Pokja 1">Pokja 1</option>
                                <option value="Pokja 2">Pokja 2</option>
                                <option value="Pokja 3">Pokja 3</option>
                                <option value="Pokja 4">Pokja 4</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-7 mb-1">File SK (Wajib PDF Asli, Maks. 2MB)</label>
                        <input type="file" id="kebijakan_file_sk" name="file_sk" class="form-control form-control-sm form-control-solid" accept="application/pdf" onchange="validasiFilePdf(this)">
                        <div id="file_error_msg" class="text-danger fs-8 mt-1 d-none">File wajib format .PDF dan ukuran maksimal 2MB.</div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold fs-7 mb-1">Keterangan</label>
                        <textarea id="kebijakan_keterangan" name="keterangan" rows="3" class="form-control form-control-sm form-control-solid" placeholder="Keterangan isi SK..."></textarea>
                    </div>
                </div>
                <div class="modal-footer flex-center py-4 border-top">
                    <button type="reset" class="btn btn-light btn-sm me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btnSimpanKebijakan" class="btn btn-primary btn-sm px-6" style="min-width: 120px;">
                        <span id="btnSimpanSpinner" class="spinner-border spinner-border-sm align-middle me-2 d-none" role="status"></span>
                        <span id="btnSimpanText">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewPdf" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px" style="height: 90vh;">
        <div class="modal-content h-100">
            <div class="modal-header py-3 px-6 border-bottom">
                <h3 class="fw-bold fs-5 mb-0" id="modalPreviewTitle">Preview Dokumen SK</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 h-100">
                <iframe id="iframePreviewPdf" src="" width="100%" height="100%" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    const ROUTES_KEBIJAKAN = {
        data: "{{ route('kebijakan.data') }}",
        store: "{{ route('kebijakan.store') }}",
        show: "{{ url('kebijakan-show') }}",
        update: "{{ url('kebijakan-update') }}",
        destroy: "{{ url('kebijakan-destroy') }}",
        csrfToken: "{{ csrf_token() }}",
        uploadBaseUrl: "{{ asset('uploads/file-surat-keputusan') }}"
    };

    const dataWilayahSurabaya = {
        '1': { nama: 'ASEMROWO', kelurahan: { '101': 'Asem Rowo', '102': 'Genting Kalianak', '103': 'Tambak Sarioso' } },
        '2': { nama: 'BENOWO', kelurahan: { '201': 'Kandangan', '202': 'Romokalisari', '203': 'Sememi', '204': 'Tambak Osowilangon' } },
        '3': { nama: 'BUBUTAN', kelurahan: { '301': 'Alun-Alun Contong', '302': 'Bubutan', '303': 'Gundih', '304': 'Jepara', '305': 'Tembok Dukuh' } },
        '4': { nama: 'BULAK', kelurahan: { '401': 'Bulak', '402': 'Kedung Cowek', '403': 'Kenjeran', '404': 'Sukolilo Baru' } },
        '5': { nama: 'DUKUH PAKIS', kelurahan: { '501': 'Dukuh Kupang', '502': 'Dukuh Pakis', '503': 'Gunung Sari', '504': 'Pradah Kalikendal' } },
        '6': { nama: 'GAYUNGAN', kelurahan: { '601': 'Dukuh Menanggal', '602': 'Gayungan', '603': 'Ketintang', '604': 'Menanggal' } },
        '7': { nama: 'GENTENG', kelurahan: { '701': 'Embong Kaliasin', '702': 'Genteng', '703': 'Kapasari', '704': 'Ketabang', '705': 'Peneleh' } },
        '8': { nama: 'GUBENG', kelurahan: { '801': 'Airlangga', '802': 'Baratajaya', '803': 'Gubeng', '804': 'Kertajaya', '805': 'Mojo', '806': 'Pucang Sewu' } },
        '9': { nama: 'GUNUNG ANYAR', kelurahan: { '901': 'Gunung Anyar', '902': 'Gunung Anyar Tambak', '903': 'Rungkut Menanggal', '904': 'Rungkut Tengah' } },
        '10': { nama: 'JAMBANGAN', kelurahan: { '1001': 'Jambangan', '1002': 'Karah', '1003': 'Kebonsari', '1004': 'Pagesangan' } },
        '11': { nama: 'KARANG PILANG', kelurahan: { '1101': 'Karang Pilang', '1102': 'Kebraon', '1103': 'Kedurus', '1104': 'Warugunung' } },
        '12': { nama: 'KENJERAN', kelurahan: { '1201': 'Bulak Banteng', '1202': 'Tambak Wedi', '1203': 'Tanah Kali Kedinding', '1204': 'Sidotopo Wetan' } },
        '13': { nama: 'KREMBANGAN', kelurahan: { '1301': 'Dupak', '1302': 'Kemayoran', '1303': 'Krembangan Selatan', '1304': 'Morokrembangan', '1305': 'Perak Barat' } },
        '14': { nama: 'LAKARSANTRI', kelurahan: { '1401': 'Bangkingan', '1402': 'Jeruk', '1403': 'Lakarsantri', '1404': 'Lidah Kulon', '1405': 'Lidah Wetan', '1406': 'Sumur Welut' } },
        '15': { nama: 'MULYOREJO', kelurahan: { '1501': 'Dukuh Sutorejo', '1502': 'Kalijudan', '1503': 'Kalisari', '1504': 'Kejawan Putih Tambak', '1505': 'Manyar Sabrangan', '1506': 'Mulyorejo' } },
        '16': { nama: 'PABEAN CANTIKAN', kelurahan: { '1601': 'Bongkaran', '1602': 'Krembangan Utara', '1603': 'Nyamplungan', '1604': 'Perak Timur', '1605': 'Perak Utara' } },
        '17': { nama: 'PAKAL', kelurahan: { '1701': 'Babat Jerawat', '1702': 'Benowo', '1703': 'Pakal', '1704': 'Sumberejo' } },
        '18': { nama: 'RUNGKUT', kelurahan: { '1801': 'Kali Rungkut', '1802': 'Kedung Baruk', '1803': 'Medokan Ayu', '1804': 'Penjaringansari', '1805': 'Rungkut Kidul', '1806': 'Wonorejo' } },
        '19': { nama: 'SAMBIKEREP', kelurahan: { '1901': 'Bringin', '1902': 'Made', '1903': 'Lontar', '1904': 'Sambikerep' } },
        '20': { nama: 'SAWAHAN', kelurahan: { '2001': 'Banyu Urip', '2002': 'Kupang Krajan', '2003': 'Pakis', '2004': 'Petemon', '2005': 'Putat Jaya', '2006': 'Sawahan' } },
        '21': { nama: 'SEMAMPIR', kelurahan: { '2101': 'Ampel', '2102': 'Pegirian', '2103': 'Sidotopo', '2104': 'Ujung', '2105': 'Wonokusumo' } },
        '22': { nama: 'SIMOKERTO', kelurahan: { '2201': 'Kapasan', '2202': 'Sidodadi', '2203': 'Simokerto', '2204': 'Simolawang', '2205': 'Tambakrejo' } },
        '23': { nama: 'SUKOLILO', kelurahan: { '2301': 'Gebang Putih', '2302': 'Keputih', '2303': 'Klampis Ngasem', '2304': 'Medokan Semampir', '2305': 'Menur Pumpungan', '2306': 'Nginden Jangkungan', '2307': 'Semolowaru' } },
        '24': { nama: 'SUKOMANUNGGAL', kelurahan: { '2401': 'Putat Gede', '2402': 'Simomulyo', '2403': 'Simomulyo Baru', '2404': 'Sukomanunggal', '2405': 'Sonokwijenan', '2406': 'Tanjungsari' } },
        '25': { nama: 'TAMBAKSARI', kelurahan: { '2501': 'Dukuh Setro', '2502': 'Gading', '2503': 'Kapasmadya Baru', '2504': 'Pacar Kembang', '2505': 'Pacar Keling', '2506': 'Ploso', '2507': 'Rangkah', '2508': 'Tambaksari' } },
        '26': { nama: 'TANDES', kelurahan: { '2601': 'Balongsari', '2602': 'Banjar Sugihan', '2603': 'Karang Poh', '2604': 'Manukan Kulon', '2605': 'Manukan Wetan', '2606': 'Tandes' } },
        '27': { nama: 'TEGALSARI', kelurahan: { '2701': 'Dr. Soetomo', '2702': 'Kedungdoro', '2703': 'Keputran', '2704': 'Tegalsari', '2705': 'Wonorejo' } },
        '28': { nama: 'TENGGILIS MEJOYO', kelurahan: { '2801': 'Kendangsari', '2802': 'Kutisari', '2803': 'Panjang Jiwo', '2804': 'Prapen', '2805': 'Tenggilis Mejoyo' } },
        '29': { nama: 'WIYUNG', kelurahan: { '2901': 'Babatan', '2902': 'Balasklumprik', '2903': 'Jajar Tunggal', '2904': 'Wiyung' } },
        '30': { nama: 'WONOCOLO', kelurahan: { '3001': 'Bendul Merisi', '3002': 'Jemur Wonosari', '3003': 'Margorejo', '3004': 'Sidosermo', '3005': 'Siwalankerto' } },
        '31': { nama: 'WONOKROMO', kelurahan: { '3101': 'Darmo', '3102': 'Jagir', '3103': 'Ngagel', '3104': 'Ngagelrejo', '3105': 'Sawunggaling', '3106': 'Wonokromo' } }
    };

    const daftarKelurahanSurabaya = [];
    Object.keys(dataWilayahSurabaya).forEach(idKec => {
        const kec = dataWilayahSurabaya[idKec];
        Object.keys(kec.kelurahan).forEach(idKel => {
            daftarKelurahanSurabaya.push({
                id_kel: idKel,
                id_kec: idKec,
                nama_kel: kec.kelurahan[idKel],
                nama_kec: kec.nama
            });
        });
    });

    let kebijakanCurrentPage = 1;
    let kebijakanPageSize = 10;
    let kebijakanTotalPages = 1;
    let kebijakanSearchQuery = '';
    let kebijakanSearchTimer = null;
    let filterKelurahanAktif = '';
    let isWilayahValid = true;

    const svgPdfIcon = `
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1f6345" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <path d="M9.5 16.5c-1.5 0-2-.8-2-1.5 0-1.2 1.8-1.5 3.5-1.5s2.5.8 2.5 1.8c0 1.2-1.2 1.2-2.5 1.2-1.5 0-3-1-3-3 0-1.8 1.2-3.5 2.5-3.5 1 0 1.5.8 1.5 1.5 0 2.2-2.5 4.5-4 5"/>
        </svg>
    `;
    const svgEditIcon = `
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
        </svg>
    `;
    const svgDeleteIcon = `
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    `;

    function inisialisasiDropdownKecamatan() {
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        if (!filterKec) return;
        Object.keys(dataWilayahSurabaya).forEach(idKec => {
            const opt = document.createElement('option');
            opt.value = idKec;
            opt.textContent = dataWilayahSurabaya[idKec].nama;
            filterKec.appendChild(opt);
        });
    }

    function handleFilterKecamatanChange() {
        const idKec = document.getElementById('filter_kebijakan_id_kec')?.value;
        const inputKel = document.getElementById('input_filter_kelurahan');
        const box = document.getElementById('kelurahan_suggestions');

        if (inputKel) inputKel.value = '';
        if (box) box.classList.add('d-none');
        filterKelurahanAktif = '';
        isWilayahValid = true;

        fetchTableKebijakan(1);
    }

    function handleKelurahanSearchInput(query) {
        const box = document.getElementById('kelurahan_suggestions');
        const clearBtn = document.getElementById('btn_clear_kelurahan');
        const idKecTerpilih = document.getElementById('filter_kebijakan_id_kec')?.value || 'all';
        const cleanQuery = query.trim().toLowerCase();

        if (!cleanQuery) {
            box.classList.add('d-none');
            clearBtn.classList.add('d-none');
            filterKelurahanAktif = '';
            isWilayahValid = true;
            fetchTableKebijakan(1);
            return;
        }

        clearBtn.classList.remove('d-none');
        let dataset = daftarKelurahanSurabaya;
        if (idKecTerpilih !== 'all') {
            dataset = dataset.filter(item => item.id_kec === idKecTerpilih);
        }

        const matches = dataset.filter(item => 
            item.nama_kel.toLowerCase().includes(cleanQuery) || 
            item.nama_kec.toLowerCase().includes(cleanQuery)
        );

        box.innerHTML = '';

        if (matches.length === 0) {
            box.innerHTML = `<div class="p-3 text-danger fw-semibold text-center fs-8">Wilayah tidak ditemukan</div>`;
            box.classList.remove('d-none');
            isWilayahValid = false;
            filterKelurahanAktif = cleanQuery;
            fetchTableKebijakan(1);
            return;
        }

        isWilayahValid = true;
        filterKelurahanAktif = cleanQuery;

        matches.slice(0, 8).forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'suggestion-item px-3 py-2 border-bottom text-gray-700 cursor-pointer d-flex justify-content-between align-items-center';
            itemDiv.style.cursor = 'pointer';
            itemDiv.innerHTML = `
                <span class="fw-bold">${item.nama_kel}</span>
                <span class="text-muted fs-8">Kec. ${item.nama_kec}</span>
            `;
            
            itemDiv.addEventListener('mousedown', function() {
                pilihKelurahanDariRekomendasi(item);
            });
            box.appendChild(itemDiv);
        });

        box.classList.remove('d-none');
        fetchTableKebijakan(1);
    }

    function pilihKelurahanDariRekomendasi(item) {
        const input = document.getElementById('input_filter_kelurahan');
        const box = document.getElementById('kelurahan_suggestions');
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        
        input.value = item.nama_kel;
        filterKelurahanAktif = item.nama_kel;
        isWilayahValid = true;
        box.classList.add('d-none');

        if (filterKec && item.id_kec) {
            filterKec.value = item.id_kec;
        }

        fetchTableKebijakan(1);
    }

    function resetFilterKelurahan() {
        const input = document.getElementById('input_filter_kelurahan');
        const box = document.getElementById('kelurahan_suggestions');
        const clearBtn = document.getElementById('btn_clear_kelurahan');

        input.value = '';
        filterKelurahanAktif = '';
        isWilayahValid = true;
        box.classList.add('d-none');
        clearBtn.classList.add('d-none');

        fetchTableKebijakan(1);
    }

    document.addEventListener('click', function(e) {
        const input = document.getElementById('input_filter_kelurahan');
        const box = document.getElementById('kelurahan_suggestions');
        if (input && box && !input.contains(e.target) && !box.contains(e.target)) {
            box.classList.add('d-none');
        }
    });

    function validasiFilePdf(input) {
        const errorEl = document.getElementById('file_error_msg');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            const isUnder5MB = file.size <= 5 * 1024 * 1024;

            if (!isPdf || !isUnder5MB) {
                errorEl.classList.remove('d-none');
                input.value = '';
            } else {
                errorEl.classList.add('d-none');
            }
        }
    }

    function fetchTableKebijakan(page = 1) {
        if (!isWilayahValid) {
            renderTableKebijakan({
                total: 0,
                current_page: 1,
                per_page: kebijakanPageSize,
                last_page: 1,
                data: []
            });
            return;
        }

        kebijakanCurrentPage = page;
        const tbody = document.getElementById('tabel_kebijakan_body');
        if (!tbody) return;

        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

        const idKec = document.getElementById('filter_kebijakan_id_kec')?.value || 'all';
        const tahun = document.getElementById('filter_kebijakan_tahun')?.value || 'all';
        const pokja = document.getElementById('filter_kebijakan_pokja')?.value || 'all';

        const params = new URLSearchParams({
            page: page,
            limit: kebijakanPageSize,
            id_kec: idKec,
            tahun: tahun,
            pokja: pokja,
            kelurahan: filterKelurahanAktif,
            search: kebijakanSearchQuery
        });

        fetch(`${ROUTES_KEBIJAKAN.data}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(data => {
            renderTableKebijakan(data);
        })
        .catch(() => {
            renderTableKebijakan({
                total: 0,
                current_page: 1,
                per_page: kebijakanPageSize,
                last_page: 1,
                data: []
            });
        });
    }

    function renderTableKebijakan(res) {
        const tbody = document.getElementById('tabel_kebijakan_body');
        const infoRecords = document.getElementById('kebijakan_info_records');
        if (!tbody) return;

        tbody.innerHTML = '';
        const total = res.total || 0;
        const currentPage = res.current_page || 1;
        const perPage = res.per_page || kebijakanPageSize;
        kebijakanTotalPages = Math.max(1, res.last_page || Math.ceil(total / perPage) || 1);

        if (!res.data || res.data.length === 0 || total === 0) {
            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
            if (infoRecords) infoRecords.textContent = 'Showing 0 to 0 of 0 records';
            renderPaginationKebijakan(1, 1);
            return;
        }

        res.data.forEach((row, idx) => {
            const no = (currentPage - 1) * perPage + (idx + 1);
            const fileBtn = row.file_sk 
                ? `<button type="button" class="btn-action-icon btn-action-pdf shadow-none" onclick="bukaPreviewPdf('${ROUTES_KEBIJAKAN.uploadBaseUrl}/${row.file_sk}', '${row.no_sk}')" title="Preview Dokumen PDF">
                    ${svgPdfIcon}
                   </button>` 
                : `<span class="text-muted fs-8">-</span>`;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center text-gray-600">${no}</td>
                <td class="fw-bold text-gray-800">${row.no_sk || '-'}</td>
                <td class="text-gray-800">${row.perihal || '-'}</td>
                <td class="text-gray-800 fw-semibold">${row.pokja || '-'}</td>
                <td class="text-center text-gray-700">${row.tgl_mulai || '-'}</td>
                <td class="text-center text-gray-700">${row.tgl_selesai || '-'}</td>
                <td class="text-center">${fileBtn}</td>
                <td class="text-gray-700">${row.keterangan || '-'}</td>
                <td class="text-gray-700">${row.created_by || '-'}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-1">
                        <button type="button" class="btn-action-icon btn-action-edit" title="Edit SK" onclick="bukaModalEditKebijakan(${row.id})">
                            ${svgEditIcon}
                        </button>
                        <button type="button" class="btn-action-icon btn-action-delete" title="Hapus SK" onclick="hapusKebijakan(${row.id})">
                            ${svgDeleteIcon}
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        const start = (currentPage - 1) * perPage + 1;
        const end = Math.min(currentPage * perPage, total);
        if (infoRecords) {
            infoRecords.textContent = `Showing ${start} to ${end} of ${total} records`;
        }

        renderPaginationKebijakan(currentPage, kebijakanTotalPages);
    }

    function renderPaginationKebijakan(currentPage, totalPages) {
        const el = document.getElementById('kebijakan_pagination');
        if (!el) return;
        el.innerHTML = '';

        const safeTotalPages = Math.max(1, totalPages || 1);
        const safeCurrentPage = Math.max(1, currentPage || 1);

        const prevLi = document.createElement('li');
        prevLi.className = `page-item previous ${safeCurrentPage <= 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&lt;</a>`;
        if (safeCurrentPage > 1) {
            prevLi.addEventListener('click', () => fetchTableKebijakan(safeCurrentPage - 1));
        }
        el.appendChild(prevLi);

        let startPage = Math.max(1, safeCurrentPage - 2);
        let endPage = Math.min(safeTotalPages, safeCurrentPage + 2);

        if (startPage > 1) {
            const firstLi = document.createElement('li');
            firstLi.className = 'page-item';
            firstLi.innerHTML = `<a class="page-link" href="javascript:void(0)">1</a>`;
            firstLi.addEventListener('click', () => fetchTableKebijakan(1));
            el.appendChild(firstLi);

            if (startPage > 2) {
                const dotsLi = document.createElement('li');
                dotsLi.className = 'page-item disabled';
                dotsLi.innerHTML = `<span class="page-link">...</span>`;
                el.appendChild(dotsLi);
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            const li = document.createElement('li');
            li.className = `page-item ${p === safeCurrentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
            if (p !== safeCurrentPage && safeTotalPages > 1) {
                li.addEventListener('click', () => fetchTableKebijakan(p));
            }
            el.appendChild(li);
        }

        if (endPage < safeTotalPages) {
            if (endPage < safeTotalPages - 1) {
                const dotsLi = document.createElement('li');
                dotsLi.className = 'page-item disabled';
                dotsLi.innerHTML = `<span class="page-link">...</span>`;
                el.appendChild(dotsLi);
            }

            const lastLi = document.createElement('li');
            lastLi.className = 'page-item';
            lastLi.innerHTML = `<a class="page-link" href="javascript:void(0)">${safeTotalPages}</a>`;
            lastLi.addEventListener('click', () => fetchTableKebijakan(safeTotalPages));
            el.appendChild(lastLi);
        }

        const nextLi = document.createElement('li');
        nextLi.className = `page-item next ${safeCurrentPage >= safeTotalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&gt;</a>`;
        if (safeCurrentPage < safeTotalPages) {
            nextLi.addEventListener('click', () => fetchTableKebijakan(safeCurrentPage + 1));
        }
        el.appendChild(nextLi);
    }

    function changeKebijakanPageSize() {
        const sizeSelect = document.getElementById('kebijakan_page_size');
        if (sizeSelect) {
            kebijakanPageSize = parseInt(sizeSelect.value, 10);
        }
        fetchTableKebijakan(1);
    }

    function searchKebijakanTable() {
        clearTimeout(kebijakanSearchTimer);
        kebijakanSearchTimer = setTimeout(() => {
            const input = document.getElementById('kebijakan_search');
            kebijakanSearchQuery = input ? input.value.trim() : '';
            fetchTableKebijakan(1);
        }, 350);
    }

    function bukaModalTambahKebijakan() {
        document.getElementById('formKebijakan').reset();
        document.getElementById('kebijakan_id').value = '';
        document.getElementById('modalKebijakanTitle').textContent = 'Tambah Lampiran SK';
        document.getElementById('file_error_msg').classList.add('d-none');
        const modal = new bootstrap.Modal(document.getElementById('modalKebijakan'));
        modal.show();
    }

    function bukaModalEditKebijakan(id) {
        document.getElementById('file_error_msg').classList.add('d-none');
        fetch(`${ROUTES_KEBIJAKAN.show}/${id}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('kebijakan_id').value = data.id;
            document.getElementById('kebijakan_no_sk').value = data.no_sk;
            document.getElementById('kebijakan_perihal').value = data.perihal;
            document.getElementById('kebijakan_tgl_mulai').value = data.tgl_mulai;
            document.getElementById('kebijakan_tgl_selesai').value = data.tgl_selesai || '';
            document.getElementById('kebijakan_tahun').value = data.tahun || '';
            document.getElementById('kebijakan_pokja').value = data.pokja || '';
            document.getElementById('kebijakan_keterangan').value = data.keterangan || '';
            document.getElementById('modalKebijakanTitle').textContent = 'Ubah Lampiran SK';

            const modal = new bootstrap.Modal(document.getElementById('modalKebijakan'));
            modal.show();
        })
        .catch(err => {
            console.error(err);
            alert('Gagal mengambil data SK.');
        });
    }

    function bukaPreviewPdf(url, noSk) {
        const titleEl = document.getElementById('modalPreviewTitle');
        const iframe = document.getElementById('iframePreviewPdf');
        titleEl.textContent = `Preview Dokumen: ${noSk}`;
        iframe.src = url;
        const modal = new bootstrap.Modal(document.getElementById('modalPreviewPdf'));
        modal.show();
    }

    function submitFormKebijakan(e) {
        e.preventDefault();
        const form = e.target;
        const id = document.getElementById('kebijakan_id').value;
        const btn = document.getElementById('btnSimpanKebijakan');
        const spinner = document.getElementById('btnSimpanSpinner');
        const btnText = document.getElementById('btnSimpanText');

        spinner.classList.remove('d-none');
        btnText.textContent = 'Menyimpan...';
        btn.disabled = true;

        const formData = new FormData(form);
        const postUrl = id ? `${ROUTES_KEBIJAKAN.update}/${id}` : ROUTES_KEBIJAKAN.store;

        fetch(postUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': ROUTES_KEBIJAKAN.csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) {
                const errorMsg = data.message || Object.values(data.errors || {}).flat().join('\n') || 'Gagal menyimpan data';
                throw new Error(errorMsg);
            }
            return data;
        })
        .then(() => {
            const modalEl = document.getElementById('modalKebijakan');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            
            const filterTahun = document.getElementById('filter_kebijakan_tahun');
            if (filterTahun) filterTahun.value = 'all';
            
            fetchTableKebijakan(1);
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menyimpan data.');
        })
        .finally(() => {
            spinner.classList.add('d-none');
            btnText.textContent = 'Simpan';
            btn.disabled = false;
        });
    }

    function hapusKebijakan(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus data SK ini?')) return;

        fetch(`${ROUTES_KEBIJAKAN.destroy}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ROUTES_KEBIJAKAN.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _token: ROUTES_KEBIJAKAN.csrfToken,
                _method: 'DELETE'
            })
        })
        .then(async (res) => {
            if (!res.ok) {
                const errData = await res.json();
                throw new Error(errData.message || 'Gagal menghapus data.');
            }
            return res.json();
        })
        .then(() => {
            fetchTableKebijakan(kebijakanCurrentPage);
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menghapus data.');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        inisialisasiDropdownKecamatan();
        fetchTableKebijakan(1);
    });

    window.fetchTableKebijakan = fetchTableKebijakan;
    window.changeKebijakanPageSize = changeKebijakanPageSize;
    window.searchKebijakanTable = searchKebijakanTable;
    window.bukaModalTambahKebijakan = bukaModalTambahKebijakan;
    window.bukaModalEditKebijakan = bukaModalEditKebijakan;
    window.bukaPreviewPdf = bukaPreviewPdf;
    window.submitFormKebijakan = submitFormKebijakan;
    window.hapusKebijakan = hapusKebijakan;
    window.validasiFilePdf = validasiFilePdf;
    window.handleFilterKecamatanChange = handleFilterKecamatanChange;
    window.handleKelurahanSearchInput = handleKelurahanSearchInput;
    window.resetFilterKelurahan = resetFilterKelurahan;
</script>
@endsection