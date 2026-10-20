@extends('bo.layout.app')

@section('content')
<style>
    .banner-kebijakan-card {
        background: #0f5847 radial-gradient(#197862 1.5px, transparent 1.5px);
        background-size: 16px 16px;
        min-height: 180px;
        position: relative;
        overflow: hidden;
        border-radius: 12px;a
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
        cursor: pointer !important;
        pointer-events: auto !important;
    }
    .btn-action-icon svg {
        pointer-events: none;
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
</style>

<div class="d-flex flex-column gap-5 w-100">
    <div class="card card-flush shadow-sm banner-kebijakan-card border-0">
        <div class="card-body p-6 p-md-8 d-flex flex-column flex-md-row justify-content-between align-items-md-center position-relative z-index-2 gap-4">
            <div class="text-white">
                <h1 class="fs-2x fw-bolder text-white mb-2 tracking-wide">Data Lampiran SK</h1>
                <p class="fs-6 text-white text-opacity-80 mb-0">
                    Berikut adalah data lampiran SK yang telah diinputkan.
                </p>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-tambah-sk fw-bold px-5 py-3 rounded-3 shadow-sm d-flex align-items-center gap-2" onclick="bukaModalTambahKebijakan()">
                    <span class="fs-4 lh-1 fw-bold">+</span>
                    <span class="fs-7 fw-bolder text-uppercase">Tambah Lampiran SK</span>
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

                    <select id="filter_kebijakan_id_kel" class="form-select form-select-sm compact-select" style="width: 140px;" onchange="handleFilterKelurahanChange()">
                        <option value="all" selected>Pilih Kelurahan</option>
                    </select>

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
                <input type="hidden" id="kebijakan_hash" name="hash" value="">
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
                            <label class="required form-label fw-semibold fs-7 mb-1">Kecamatan</label>
                            <select id="kebijakan_id_kec" name="id_kec" class="form-select form-select-sm form-select-solid" onchange="handleModalKecamatanChange()">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Kelurahan</label>
                            <select id="kebijakan_id_kel" name="id_kel" class="form-select form-select-sm form-select-solid" onchange="handleModalKelurahanChange()">
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Tanggal Mulai</label>
                            <input type="date" id="kebijakan_tgl_mulai" name="tgl_mulai" class="form-control form-control-sm form-control-solid" required onchange="handleTanggalMulaiChange()">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold fs-7 mb-1">Tanggal Selesai</label>
                            <input type="date" id="kebijakan_tgl_selesai" name="tgl_selesai" class="form-control form-control-sm form-control-solid">
                        </div>
                    </div>

                    <div class="mb-4">
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

                    <div class="mb-4">
                        <label class="form-label fw-semibold fs-7 mb-1">File SK</label>
                        <input type="file" id="kebijakan_file_sk" name="file_sk" class="form-control form-control-sm form-control-solid" accept="application/pdf" onchange="validasiFilePdf(this)">
                        <div class="text-danger fs-8 mt-1">File harus di bawah 2MB dan berformat pdf.</div>
                        <div id="file_sk_sebelumnya" class="fs-8 text-primary mt-1 d-none"></div>
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

<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-400px">
        <div class="modal-content text-center p-6 border-0 shadow-lg rounded-4">
            <div class="modal-body p-0">
                <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background-color: #fee2e2;">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>

                <h3 class="fw-bolder text-gray-900 fs-4 mb-2">Hapus Lmapiran Dokumen SK?</h3>
                <p class="text-gray-600 fs-7 mb-6">
                    Apakah Anda yakin ingin menghapus data SK ini?.
                </p>

                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light btn-sm fw-semibold px-5 rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="btnKonfirmasiHapus" class="btn btn-danger btn-sm fw-semibold px-5 rounded-3 d-flex align-items-center justify-content-center" style="min-width: 100px;">
                        <span id="btnHapusSpinner" class="spinner-border spinner-border-sm align-middle me-2 d-none" role="status"></span>
                        <span id="btnHapusText">Ya, Hapus</span>
                    </button>
                </div>
            </div>
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

<div class="modal fade" id="modalNotifikasiPesan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-350px">
        <div class="modal-content text-center p-6 border-0 shadow-lg rounded-4">
            <div class="modal-body p-0">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: #d1fae5;">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h4 class="fw-bolder text-gray-900 fs-5 mb-2" id="notifikasiPesanTitle">Sukses</h4>
                <p class="text-gray-600 fs-7 mb-5" id="notifikasiPesanText">Data berhasil diproses</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary btn-sm fw-semibold px-6 rounded-3" style="background-color: #0f5847; border-color: #0f5847;" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROUTES_KEBIJAKAN = {
        data: "{{ route('kebijakan.data') }}",
        store: "{{ route('kebijakan.store') }}",
        show: "{{ url('/kebijakan/show') }}",
        update: "{{ url('/kebijakan/update') }}",
        destroy: "{{ url('/kebijakan/destroy') }}",
        csrfToken: "{{ csrf_token() }}",
        uploadBaseUrl: "{{ asset('uploads/file-surat-keputusan') }}"
    };

    const daftarKelurahanSurabaya = [
        { id_kel: '101', id_kec: '1', nama_kel: 'Asem Rowo', nama_kec: 'ASEMROWO' },
        { id_kel: '102', id_kec: '1', nama_kel: 'Genting Kalianak', nama_kec: 'ASEMROWO' },
        { id_kel: '103', id_kec: '1', nama_kel: 'Tambak Sarioso', nama_kec: 'ASEMROWO' },
        { id_kel: '201', id_kec: '2', nama_kel: 'Kandangan', nama_kec: 'BENOWO' },
        { id_kel: '202', id_kec: '2', nama_kel: 'Romokalisari', nama_kec: 'BENOWO' },
        { id_kel: '203', id_kec: '2', nama_kel: 'Sememi', nama_kec: 'BENOWO' },
        { id_kel: '204', id_kec: '2', nama_kel: 'Tambak Osowilangon', nama_kec: 'BENOWO' },
        { id_kel: '301', id_kec: '3', nama_kel: 'Alun-Alun Contong', nama_kec: 'BUBUTAN' },
        { id_kel: '302', id_kec: '3', nama_kel: 'Bubutan', nama_kec: 'BUBUTAN' },
        { id_kel: '303', id_kec: '3', nama_kel: 'Gundih', nama_kec: 'BUBUTAN' },
        { id_kel: '304', id_kec: '3', nama_kel: 'Jepara', nama_kec: 'BUBUTAN' },
        { id_kel: '305', id_kec: '3', nama_kel: 'Tembok Dukuh', nama_kec: 'BUBUTAN' },
        { id_kel: '401', id_kec: '4', nama_kel: 'Bulak', nama_kec: 'BULAK' },
        { id_kel: '402', id_kec: '4', nama_kel: 'Kedung Cowek', nama_kec: 'BULAK' },
        { id_kel: '403', id_kec: '4', nama_kel: 'Kenjeran', nama_kec: 'BULAK' },
        { id_kel: '404', id_kec: '4', nama_kel: 'Sukolilo Baru', nama_kec: 'BULAK' },
        { id_kel: '501', id_kec: '5', nama_kel: 'Dukuh Kupang', nama_kec: 'DUKUH PAKIS' },
        { id_kel: '502', id_kec: '5', nama_kel: 'Dukuh Pakis', nama_kec: 'DUKUH PAKIS' },
        { id_kel: '503', id_kec: '5', nama_kel: 'Gunung Sari', nama_kec: 'DUKUH PAKIS' },
        { id_kel: '504', id_kec: '5', nama_kel: 'Pradah Kalikendal', nama_kec: 'DUKUH PAKIS' },
        { id_kel: '601', id_kec: '6', nama_kel: 'Dukuh Menanggal', nama_kec: 'GAYUNGAN' },
        { id_kel: '602', id_kec: '6', nama_kel: 'Gayungan', nama_kec: 'GAYUNGAN' },
        { id_kel: '603', id_kec: '6', nama_kel: 'Ketintang', nama_kec: 'GAYUNGAN' },
        { id_kel: '604', id_kec: '6', nama_kel: 'Menanggal', nama_kec: 'GAYUNGAN' },
        { id_kel: '701', id_kec: '7', nama_kel: 'Embong Kaliasin', nama_kec: 'GENTENG' },
        { id_kel: '702', id_kec: '7', nama_kel: 'Genteng', nama_kec: 'GENTENG' },
        { id_kel: '703', id_kec: '7', nama_kel: 'Kapasari', nama_kec: 'GENTENG' },
        { id_kel: '704', id_kec: '7', nama_kel: 'Ketabang', nama_kec: 'GENTENG' },
        { id_kel: '705', id_kec: '7', nama_kel: 'Peneleh', nama_kec: 'GENTENG' },
        { id_kel: '801', id_kec: '8', nama_kel: 'Airlangga', nama_kec: 'GUBENG' },
        { id_kel: '802', id_kec: '8', nama_kel: 'Baratajaya', nama_kec: 'GUBENG' },
        { id_kel: '803', id_kec: '8', nama_kel: 'Gubeng', nama_kec: 'GUBENG' },
        { id_kel: '804', id_kec: '8', nama_kel: 'Kertajaya', nama_kec: 'GUBENG' },
        { id_kel: '805', id_kec: '8', nama_kel: 'Mojo', nama_kec: 'GUBENG' },
        { id_kel: '806', id_kec: '8', nama_kel: 'Pucang Sewu', nama_kec: 'GUBENG' },
        { id_kel: '901', id_kec: '9', nama_kel: 'Gunung Anyar', nama_kec: 'GUNUNG ANYAR' },
        { id_kel: '902', id_kec: '9', nama_kel: 'Gunung Anyar Tambak', nama_kec: 'GUNUNG ANYAR' },
        { id_kel: '903', id_kec: '9', nama_kel: 'Rungkut Menanggal', nama_kec: 'GUNUNG ANYAR' },
        { id_kel: '904', id_kec: '9', nama_kel: 'Rungkut Tengah', nama_kec: 'GUNUNG ANYAR' },
        { id_kel: '1001', id_kec: '10', nama_kel: 'Jambangan', nama_kec: 'JAMBANGAN' },
        { id_kel: '1002', id_kec: '10', nama_kel: 'Karah', nama_kec: 'JAMBANGAN' },
        { id_kel: '1003', id_kec: '10', nama_kel: 'Kebonsari', nama_kec: 'JAMBANGAN' },
        { id_kel: '1004', id_kec: '10', nama_kel: 'Pagesangan', nama_kec: 'JAMBANGAN' },
        { id_kel: '1101', id_kec: '11', nama_kel: 'Karang Pilang', nama_kec: 'KARANG PILANG' },
        { id_kel: '1102', id_kec: '11', nama_kel: 'Kebraon', nama_kec: 'KARANG PILANG' },
        { id_kel: '1103', id_kec: '11', nama_kel: 'Kedurus', nama_kec: 'KARANG PILANG' },
        { id_kel: '1104', id_kec: '11', nama_kel: 'Warugunung', nama_kec: 'KARANG PILANG' },
        { id_kel: '1201', id_kec: '12', nama_kel: 'Bulak Banteng', nama_kec: 'KENJERAN' },
        { id_kel: '1202', id_kec: '12', nama_kel: 'Tambak Wedi', nama_kec: 'KENJERAN' },
        { id_kel: '1203', id_kec: '12', nama_kel: 'Tanah Kali Kedinding', nama_kec: 'KENJERAN' },
        { id_kel: '1204', id_kec: '12', nama_kel: 'Sidotopo Wetan', nama_kec: 'KENJERAN' },
        { id_kel: '1301', id_kec: '13', nama_kel: 'Dupak', nama_kec: 'KREMBANGAN' },
        { id_kel: '1302', id_kec: '13', nama_kel: 'Kemayoran', nama_kec: 'KREMBANGAN' },
        { id_kel: '1303', id_kec: '13', nama_kel: 'Krembangan Selatan', nama_kec: 'KREMBANGAN' },
        { id_kel: '1304', id_kec: '13', nama_kel: 'Morokrembangan', nama_kec: 'KREMBANGAN' },
        { id_kel: '1305', id_kec: '13', nama_kel: 'Perak Barat', nama_kec: 'KREMBANGAN' },
        { id_kel: '1401', id_kec: '14', nama_kel: 'Bangkingan', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1402', id_kec: '14', nama_kel: 'Jeruk', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1403', id_kec: '14', nama_kel: 'Lakarsantri', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1404', id_kec: '14', nama_kel: 'Lidah Kulon', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1405', id_kec: '14', nama_kel: 'Lidah Wetan', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1406', id_kec: '14', nama_kel: 'Sumur Welut', nama_kec: 'LAKARSANTRI' },
        { id_kel: '1501', id_kec: '15', nama_kel: 'Dukuh Sutorejo', nama_kec: 'MULYOREJO' },
        { id_kel: '1502', id_kec: '15', nama_kel: 'Kalijudan', nama_kec: 'MULYOREJO' },
        { id_kel: '1503', id_kec: '15', nama_kel: 'Kalisari', nama_kec: 'MULYOREJO' },
        { id_kel: '1504', id_kec: '15', nama_kel: 'Kejawan Putih Tambak', nama_kec: 'MULYOREJO' },
        { id_kel: '1505', id_kec: '15', nama_kel: 'Manyar Sabrangan', nama_kec: 'MULYOREJO' },
        { id_kel: '1506', id_kec: '15', nama_kel: 'Mulyorejo', nama_kec: 'MULYOREJO' },
        { id_kel: '1601', id_kec: '16', nama_kel: 'Bongkaran', nama_kec: 'PABEAN CANTIKAN' },
        { id_kel: '1602', id_kec: '16', nama_kel: 'Krembangan Utara', nama_kec: 'PABEAN CANTIKAN' },
        { id_kel: '1603', id_kec: '16', nama_kel: 'Nyamplungan', nama_kec: 'PABEAN CANTIKAN' },
        { id_kel: '1604', id_kec: '16', nama_kel: 'Perak Timur', nama_kec: 'PABEAN CANTIKAN' },
        { id_kel: '1605', id_kec: '16', nama_kel: 'Perak Utara', nama_kec: 'PABEAN CANTIKAN' },
        { id_kel: '1701', id_kec: '17', nama_kel: 'Babat Jerawat', nama_kec: 'PAKAL' },
        { id_kel: '1702', id_kec: '17', nama_kel: 'Benowo', nama_kec: 'PAKAL' },
        { id_kel: '1703', id_kec: '17', nama_kel: 'Pakal', nama_kec: 'PAKAL' },
        { id_kel: '1704', id_kec: '17', nama_kel: 'Sumberejo', nama_kec: 'PAKAL' },
        { id_kel: '1801', id_kec: '18', nama_kel: 'Kali Rungkut', nama_kec: 'RUNGKUT' },
        { id_kel: '1802', id_kec: '18', nama_kel: 'Kedung Baruk', nama_kec: 'RUNGKUT' },
        { id_kel: '1803', id_kec: '18', nama_kel: 'Medokan Ayu', nama_kec: 'RUNGKUT' },
        { id_kel: '1804', id_kec: '18', nama_kel: 'Penjaringansari', nama_kec: 'RUNGKUT' },
        { id_kel: '1805', id_kec: '18', nama_kel: 'Rungkut Kidul', nama_kec: 'RUNGKUT' },
        { id_kel: '1806', id_kec: '18', nama_kel: 'Wonorejo', nama_kec: 'RUNGKUT' },
        { id_kel: '1901', id_kec: '19', nama_kel: 'Bringin', nama_kec: 'SAMBIKEREP' },
        { id_kel: '1902', id_kec: '19', nama_kel: 'Made', nama_kec: 'SAMBIKEREP' },
        { id_kel: '1903', id_kec: '19', nama_kel: 'Lontar', nama_kec: 'SAMBIKEREP' },
        { id_kel: '1904', id_kec: '19', nama_kel: 'Sambikerep', nama_kec: 'SAMBIKEREP' },
        { id_kel: '2001', id_kec: '20', nama_kel: 'Banyu Urip', nama_kec: 'SAWAHAN' },
        { id_kel: '2002', id_kec: '20', nama_kel: 'Kupang Krajan', nama_kec: 'SAWAHAN' },
        { id_kel: '2003', id_kec: '20', nama_kel: 'Pakis', nama_kec: 'SAWAHAN' },
        { id_kel: '2004', id_kec: '20', nama_kel: 'Petemon', nama_kec: 'SAWAHAN' },
        { id_kel: '2005', id_kec: '20', nama_kel: 'Putat Jaya', nama_kec: 'SAWAHAN' },
        { id_kel: '2006', id_kec: '20', nama_kel: 'Sawahan', nama_kec: 'SAWAHAN' },
        { id_kel: '2101', id_kec: '21', nama_kel: 'Ampel', nama_kec: 'SEMAMPIR' },
        { id_kel: '2102', id_kec: '21', nama_kel: 'Pegirian', nama_kec: 'SEMAMPIR' },
        { id_kel: '2103', id_kec: '21', nama_kel: 'Sidotopo', nama_kec: 'SEMAMPIR' },
        { id_kel: '2104', id_kec: '21', nama_kel: 'Ujung', nama_kec: 'SEMAMPIR' },
        { id_kel: '2105', id_kec: '21', nama_kel: 'Wonokusumo', nama_kec: 'SEMAMPIR' },
        { id_kel: '2201', id_kec: '22', nama_kel: 'Kapasan', nama_kec: 'SIMOKERTO' },
        { id_kel: '2202', id_kec: '22', nama_kel: 'Sidodadi', nama_kec: 'SIMOKERTO' },
        { id_kel: '2203', id_kec: '22', nama_kel: 'Simokerto', nama_kec: 'SIMOKERTO' },
        { id_kel: '2204', id_kec: '22', nama_kel: 'Simolawang', nama_kec: 'SIMOKERTO' },
        { id_kel: '2205', id_kec: '22', nama_kel: 'Tambakrejo', nama_kec: 'SIMOKERTO' },
        { id_kel: '2301', id_kec: '23', nama_kel: 'Gebang Putih', nama_kec: 'SUKOLILO' },
        { id_kel: '2302', id_kec: '23', nama_kel: 'Keputih', nama_kec: 'SUKOLILO' },
        { id_kel: '2303', id_kec: '23', nama_kel: 'Klampis Ngasem', nama_kec: 'SUKOLILO' },
        { id_kel: '2304', id_kec: '23', nama_kel: 'Medokan Semampir', nama_kec: 'SUKOLILO' },
        { id_kel: '2305', id_kec: '23', nama_kel: 'Menur Pumpungan', nama_kec: 'SUKOLILO' },
        { id_kel: '2306', id_kec: '23', nama_kel: 'Nginden Jangkungan', nama_kec: 'SUKOLILO' },
        { id_kel: '2307', id_kec: '23', nama_kel: 'Semolowaru', nama_kec: 'SUKOLILO' },
        { id_kel: '2401', id_kec: '24', nama_kel: 'Putat Gede', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2402', id_kec: '24', nama_kel: 'Simomulyo', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2403', id_kec: '24', nama_kel: 'Simomulyo Baru', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2404', id_kec: '24', nama_kel: 'Sukomanunggal', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2405', id_kec: '24', nama_kel: 'Sonokwijenan', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2406', id_kec: '24', nama_kel: 'Tanjungsari', nama_kec: 'SUKOMANUNGGAL' },
        { id_kel: '2501', id_kec: '25', nama_kel: 'Dukuh Setro', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2502', id_kec: '25', nama_kel: 'Gading', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2503', id_kec: '25', nama_kel: 'Kapasmadya Baru', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2504', id_kec: '25', nama_kel: 'Pacar Kembang', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2505', id_kec: '25', nama_kel: 'Pacar Keling', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2506', id_kec: '25', nama_kel: 'Ploso', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2507', id_kec: '25', nama_kel: 'Rangkah', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2508', id_kec: '25', nama_kel: 'Tambaksari', nama_kec: 'TAMBAKSARI' },
        { id_kel: '2601', id_kec: '26', nama_kel: 'Balongsari', nama_kec: 'TANDES' },
        { id_kel: '2602', id_kec: '26', nama_kel: 'Banjar Sugihan', nama_kec: 'TANDES' },
        { id_kel: '2603', id_kec: '26', nama_kel: 'Karang Poh', nama_kec: 'TANDES' },
        { id_kel: '2604', id_kec: '26', nama_kel: 'Manukan Kulon', nama_kec: 'TANDES' },
        { id_kel: '2605', id_kec: '26', nama_kel: 'Manukan Wetan', nama_kec: 'TANDES' },
        { id_kel: '2606', id_kec: '26', nama_kel: 'Tandes', nama_kec: 'TANDES' },
        { id_kel: '2701', id_kec: '27', nama_kel: 'Dr. Soetomo', nama_kec: 'TEGALSARI' },
        { id_kel: '2702', id_kec: '27', nama_kel: 'Kedungdoro', nama_kec: 'TEGALSARI' },
        { id_kel: '2703', id_kec: '27', nama_kel: 'Keputran', nama_kec: 'TEGALSARI' },
        { id_kel: '2704', id_kec: '27', nama_kel: 'Tegalsari', nama_kec: 'TEGALSARI' },
        { id_kel: '2705', id_kec: '27', nama_kel: 'Wonorejo', nama_kec: 'TEGALSARI' },
        { id_kel: '2801', id_kec: '28', nama_kel: 'Kendangsari', nama_kec: 'TENGGILIS MEJOYO' },
        { id_kel: '2802', id_kec: '28', nama_kel: 'Kutisari', nama_kec: 'TENGGILIS MEJOYO' },
        { id_kel: '2803', id_kec: '28', nama_kel: 'Panjang Jiwo', nama_kec: 'TENGGILIS MEJOYO' },
        { id_kel: '2804', id_kec: '28', nama_kel: 'Prapen', nama_kec: 'TENGGILIS MEJOYO' },
        { id_kel: '2805', id_kec: '28', nama_kel: 'Tenggilis Mejoyo', nama_kec: 'TENGGILIS MEJOYO' },
        { id_kel: '2901', id_kec: '29', nama_kel: 'Babatan', nama_kec: 'WIYUNG' },
        { id_kel: '2902', id_kec: '29', nama_kel: 'Balasklumprik', nama_kec: 'WIYUNG' },
        { id_kel: '2903', id_kec: '29', nama_kel: 'Jajar Tunggal', nama_kec: 'WIYUNG' },
        { id_kel: '2904', id_kec: '29', nama_kel: 'Wiyung', nama_kec: 'WIYUNG' },
        { id_kel: '3001', id_kec: '30', nama_kel: 'Bendul Merisi', nama_kec: 'WONOCOLO' },
        { id_kel: '3002', id_kec: '30', nama_kel: 'Jemur Wonosari', nama_kec: 'WONOCOLO' },
        { id_kel: '3003', id_kec: '30', nama_kel: 'Margorejo', nama_kec: 'WONOCOLO' },
        { id_kel: '3004', id_kec: '30', nama_kel: 'Sidosermo', nama_kec: 'WONOCOLO' },
        { id_kel: '3005', id_kec: '30', nama_kel: 'Siwalankerto', nama_kec: 'WONOCOLO' },
        { id_kel: '3101', id_kec: '31', nama_kel: 'Darmo', nama_kec: 'WONOKROMO' },
        { id_kel: '3102', id_kec: '31', nama_kel: 'Jagir', nama_kec: 'WONOKROMO' },
        { id_kel: '3103', id_kec: '31', nama_kel: 'Ngagel', nama_kec: 'WONOKROMO' },
        { id_kel: '3104', id_kec: '31', nama_kel: 'Ngagelrejo', nama_kec: 'WONOKROMO' },
        { id_kel: '3105', id_kec: '31', nama_kel: 'Sawunggaling', nama_kec: 'WONOKROMO' },
        { id_kel: '3106', id_kec: '31', nama_kel: 'Wonokromo', nama_kec: 'WONOKROMO' }
    ];

    let kebijakanCurrentPage = 1;
    let kebijakanPageSize = 10;
    let kebijakanTotalPages = 1;
    let kebijakanSearchQuery = '';
    let kebijakanSearchTimer = null;
    let mapDataKebijakan = new Map();
    let targetHashHapus = null;
    let urlFileSebelumnya = '';
    let urlPreviewBaru = null;

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

    function tampilkanPopUpNotifikasi(judul, pesan) {
        const titleEl = document.getElementById('notifikasiPesanTitle');
        const textEl = document.getElementById('notifikasiPesanText');
        if (titleEl) titleEl.textContent = judul;
        if (textEl) textEl.textContent = pesan;

        const modalEl = document.getElementById('modalNotifikasiPesan');
        if (modalEl) {
            const notifModal = new bootstrap.Modal(modalEl);
            notifModal.show();
        }
    }

    function inisialisasiDropdownKecamatan() {
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        const modalKec = document.getElementById('kebijakan_id_kec');

        const kecamatanUnik = [];
        const mapKec = new Map();

        daftarKelurahanSurabaya.forEach(item => {
            if (!mapKec.has(item.id_kec)) {
                mapKec.set(item.id_kec, true);
                kecamatanUnik.push({
                    id_kec: item.id_kec,
                    nama_kec: item.nama_kec
                });
            }
        });

        kecamatanUnik.sort((a, b) => a.nama_kec.localeCompare(b.nama_kec));

        if (filterKec) {
            filterKec.innerHTML = '<option value="all" selected>Pilih Kecamatan</option>';
            kecamatanUnik.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec.nama_kec;
                opt.setAttribute('data-id-kec', kec.id_kec);
                opt.textContent = kec.nama_kec;
                filterKec.appendChild(opt);
            });
        }

        if (modalKec) {
            modalKec.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kecamatanUnik.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec.nama_kec;
                opt.setAttribute('data-id-kec', kec.id_kec);
                opt.textContent = kec.nama_kec;
                modalKec.appendChild(opt);
            });
        }
    }

    function inisialisasiDropdownKelurahan(idKec = 'all') {
    const filterKel = document.getElementById('filter_kebijakan_id_kel');
    if (!filterKel) return;

    filterKel.innerHTML = '<option value="all" selected>Pilih Kelurahan</option>';

    let dataFiltered = daftarKelurahanSurabaya;
    
    if (idKec !== 'all' && idKec !== '') {
        dataFiltered = daftarKelurahanSurabaya.filter(item => 
            String(item.id_kec) === String(idKec) || 
            item.nama_kec.toUpperCase() === String(idKec).toUpperCase()
        );
    }

    dataFiltered.sort((a, b) => a.nama_kel.localeCompare(b.nama_kel));

    dataFiltered.forEach(kel => {
        const opt = document.createElement('option');
        opt.value = kel.nama_kel; 
        opt.setAttribute('data-id-kel', kel.id_kel);
        opt.textContent = kel.nama_kel;
        filterKel.appendChild(opt);
    });
}

    function inisialisasiModalKelurahan(idKec = '', namaKec = '') {
        const modalKel = document.getElementById('kebijakan_id_kel');
        if (!modalKel) return;

        modalKel.innerHTML = '<option value="">Pilih Kelurahan</option>';

        let dataFiltered = daftarKelurahanSurabaya;
        if (idKec) {
            dataFiltered = daftarKelurahanSurabaya.filter(item => String(item.id_kec) === String(idKec));
        } else if (namaKec) {
            dataFiltered = daftarKelurahanSurabaya.filter(item => item.nama_kec.toUpperCase() === namaKec.toUpperCase());
        }

        dataFiltered.sort((a, b) => a.nama_kel.localeCompare(b.nama_kel));

        dataFiltered.forEach(kel => {
            const opt = document.createElement('option');
            opt.value = kel.nama_kel;
            opt.setAttribute('data-id-kec', kel.id_kec);
            opt.setAttribute('data-nama-kec', kel.nama_kec);
            opt.textContent = kel.nama_kel;
            modalKel.appendChild(opt);
        });
    }

    function handleFilterKecamatanChange() {
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        const selectedKec = filterKec ? filterKec.value : 'all';

        inisialisasiDropdownKelurahan(selectedKec);
        fetchTableKebijakan(1);
    }

    function handleFilterKelurahanChange() {
        const filterKel = document.getElementById('filter_kebijakan_id_kel');
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        const selectedKel = filterKel ? filterKel.value : 'all';

        if (selectedKel !== 'all') {
            const foundKel = daftarKelurahanSurabaya.find(item => item.nama_kel.toLowerCase() === selectedKel.toLowerCase());
            if (foundKel && filterKec && (filterKec.value === 'all' || filterKec.value.toUpperCase() !== foundKel.nama_kec.toUpperCase())) {
                filterKec.value = foundKel.nama_kec;
                inisialisasiDropdownKelurahan(foundKel.nama_kec);
                if (filterKel) filterKel.value = foundKel.nama_kel;
            }
        }

        fetchTableKebijakan(1);
    }

    function handleModalKecamatanChange() {
        const modalKec = document.getElementById('kebijakan_id_kec');
        const selectedOpt = modalKec ? modalKec.options[modalKec.selectedIndex] : null;
        const idKec = selectedOpt ? selectedOpt.getAttribute('data-id-kec') : '';
        const namaKec = modalKec ? modalKec.value : '';

        inisialisasiModalKelurahan(idKec, namaKec);
    }

    function handleModalKelurahanChange() {
        const modalKec = document.getElementById('kebijakan_id_kec');
        const modalKel = document.getElementById('kebijakan_id_kel');
        const selectedOpt = modalKel ? modalKel.options[modalKel.selectedIndex] : null;
        const namaKec = selectedOpt ? selectedOpt.getAttribute('data-nama-kec') : '';

        if (namaKec && modalKec) {
            modalKec.value = namaKec;
        }
    }

    function handleTanggalMulaiChange() {
        const tglMulai = document.getElementById('kebijakan_tgl_mulai')?.value;
        const tglSelesaiInput = document.getElementById('kebijakan_tgl_selesai');
        if (tglMulai && tglSelesaiInput) {
            tglSelesaiInput.min = tglMulai;
            if (tglSelesaiInput.value && tglSelesaiInput.value < tglMulai) {
                tglSelesaiInput.value = tglMulai;
            }
        }
    }

    function tampilkanPreviewUpload(url) {
        const box = document.getElementById('file_sk_sebelumnya');
        if (!box) return;

        if (!url) {
            box.innerHTML = '';
            box.classList.add('d-none');
            return;
        }

        box.innerHTML = `<iframe src="${url}" width="100%" height="320" style="border: 1px solid #d1d5db; border-radius: 6px;"></iframe>`;
        box.classList.remove('d-none');
    }

    function bersihkanPreviewBaru() {
        if (urlPreviewBaru) {
            URL.revokeObjectURL(urlPreviewBaru);
            urlPreviewBaru = null;
        }
    }

    function validasiFilePdf(input) {
        bersihkanPreviewBaru();

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            const isUnder2MB = file.size <= 2 * 1024 * 1024;

            if (!isPdf || !isUnder2MB) {
                input.value = '';
                tampilkanPreviewUpload(urlFileSebelumnya);
                return;
            }

            urlPreviewBaru = URL.createObjectURL(file);
            tampilkanPreviewUpload(urlPreviewBaru);
            return;
        }

        tampilkanPreviewUpload(urlFileSebelumnya);
    }

    function fetchTableKebijakan(page = 1) {
    kebijakanCurrentPage = page;
    const tbody = document.getElementById('tabel_kebijakan_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const idKec = document.getElementById('filter_kebijakan_id_kec')?.value || 'all';
    const idKel = document.getElementById('filter_kebijakan_id_kel')?.value || 'all';
    const tahun = document.getElementById('filter_kebijakan_tahun')?.value || 'all';
    const pokja = document.getElementById('filter_kebijakan_pokja')?.value || 'all';

    const params = new URLSearchParams({
        page: page,
        limit: kebijakanPageSize,
        tahun: tahun,
        pokja: pokja,
        id_kec: idKec,
        id_kel: idKel,
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
        mapDataKebijakan.clear();

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
            const hash = row.hash;
            mapDataKebijakan.set(hash, row);

            const no = (currentPage - 1) * perPage + (idx + 1);
            const fileBtn = row.file_sk 
                ? `<button type="button" class="btn-action-icon btn-action-pdf shadow-none" onclick="bukaPreviewPdf('${ROUTES_KEBIJAKAN.uploadBaseUrl}/${row.file_sk}', '${row.no_sk}')" title="Preview Dokumen PDF">
                    ${svgPdfIcon}
                   </button>` 
                : `<span class="text-muted fs-8">-</span>`;

            const tr = document.createElement('tr');
            
            const tdNo = document.createElement('td');
            tdNo.className = 'text-center text-gray-600';
            tdNo.textContent = no;

            const tdNoSk = document.createElement('td');
            tdNoSk.className = 'fw-bold text-gray-800';
            tdNoSk.textContent = row.no_sk || '-';

            const tdPerihal = document.createElement('td');
            tdPerihal.className = 'text-gray-800';
            tdPerihal.textContent = row.perihal || '-';

            const tdPokja = document.createElement('td');
            tdPokja.className = 'text-gray-800 fw-semibold';
            tdPokja.textContent = row.pokja || '-';

            const tdTglMulai = document.createElement('td');
            tdTglMulai.className = 'text-center text-gray-700';
            tdTglMulai.textContent = row.tgl_mulai || '-';

            const tdTglSelesai = document.createElement('td');
            tdTglSelesai.className = 'text-center text-gray-700';
            tdTglSelesai.textContent = row.tgl_selesai || '-';

            const tdFile = document.createElement('td');
            tdFile.className = 'text-center';
            tdFile.innerHTML = fileBtn;

            const tdKeterangan = document.createElement('td');
            tdKeterangan.className = 'text-gray-700';
            tdKeterangan.textContent = row.keterangan || '-';

            const tdCreatedBy = document.createElement('td');
            tdCreatedBy.className = 'text-gray-700';
            tdCreatedBy.textContent = row.created_by || '-';

            const tdAction = document.createElement('td');
            tdAction.className = 'text-center';

            const actionContainer = document.createElement('div');
            actionContainer.className = 'd-flex justify-content-center align-items-center gap-1';

            const btnEdit = document.createElement('button');
            btnEdit.type = 'button';
            btnEdit.className = 'btn-action-icon btn-action-edit';
            btnEdit.title = 'Edit SK';
            btnEdit.innerHTML = svgEditIcon;
            btnEdit.addEventListener('click', function() {
                bukaModalEditKebijakan(hash);
            });

            const btnDelete = document.createElement('button');
            btnDelete.type = 'button';
            btnDelete.className = 'btn-action-icon btn-action-delete';
            btnDelete.title = 'Hapus SK';
            btnDelete.innerHTML = svgDeleteIcon;
            btnDelete.addEventListener('click', function() {
                hapusKebijakan(hash);
            });

            actionContainer.appendChild(btnEdit);
            actionContainer.appendChild(btnDelete);
            tdAction.appendChild(actionContainer);

            tr.appendChild(tdNo);
            tr.appendChild(tdNoSk);
            tr.appendChild(tdPerihal);
            tr.appendChild(tdPokja);
            tr.appendChild(tdTglMulai);
            tr.appendChild(tdTglSelesai);
            tr.appendChild(tdFile);
            tr.appendChild(tdKeterangan);
            tr.appendChild(tdCreatedBy);
            tr.appendChild(tdAction);

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
        document.getElementById('kebijakan_hash').value = '';
        document.getElementById('modalKebijakanTitle').textContent = 'Tambah Lampiran SK';

        bersihkanPreviewBaru();
        urlFileSebelumnya = '';
        tampilkanPreviewUpload('');

        const tglSelesaiInput = document.getElementById('kebijakan_tgl_selesai');
        if (tglSelesaiInput) tglSelesaiInput.removeAttribute('min');

        inisialisasiModalKelurahan('', '');
        const modal = new bootstrap.Modal(document.getElementById('modalKebijakan'));
        modal.show();
    }

    function normalisasiTanggal(val) {
        if (!val) return '';
        const s = String(val).trim();

        let m = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
        if (m) return `${m[1]}-${m[2]}-${m[3]}`;

        m = s.match(/^(\d{2})[-\/](\d{2})[-\/](\d{4})/);
        if (m) return `${m[3]}-${m[2]}-${m[1]}`;

        const d = new Date(s);
        if (!isNaN(d.getTime())) {
            const y = d.getFullYear();
            const mo = String(d.getMonth() + 1).padStart(2, '0');
            const da = String(d.getDate()).padStart(2, '0');
            return `${y}-${mo}-${da}`;
        }

        return '';
    }

    function escapeRegex(teks) {
        return String(teks).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function gabungDataSk(row, detail) {
        const hasil = Object.assign({}, row);
        Object.keys(detail || {}).forEach(key => {
            const v = detail[key];
            if (v !== null && v !== undefined && v !== '') {
                hasil[key] = v;
            }
        });
        return hasil;
    }

    function cariWilayahSk(data) {
        const kecRaw = String(data.kecamatan ?? data.nama_kecamatan ?? data.nama_kec ?? data.id_kec ?? '').trim();
        const kelRaw = String(data.kelurahan ?? data.nama_kelurahan ?? data.nama_kel ?? data.id_kel ?? '').trim();

        let kecamatan = '';
        let kelurahan = '';

        if (kecRaw) {
            const foundKec = daftarKelurahanSurabaya.find(item =>
                String(item.id_kec) === kecRaw || item.nama_kec.toLowerCase() === kecRaw.toLowerCase()
            );
            if (foundKec) kecamatan = foundKec.nama_kec;
        }

        if (kelRaw) {
            const foundKel = daftarKelurahanSurabaya.find(item =>
                (String(item.id_kel) === kelRaw || item.nama_kel.toLowerCase() === kelRaw.toLowerCase()) &&
                (!kecamatan || item.nama_kec === kecamatan)
            );
            if (foundKel) {
                kelurahan = foundKel.nama_kel;
                kecamatan = foundKel.nama_kec;
            }
        }

        const teksGabungan = (data.perihal || '') + ' ' + (data.keterangan || '');

        if (!kelurahan) {
            const kandidat = kecamatan
                ? daftarKelurahanSurabaya.filter(item => item.nama_kec === kecamatan)
                : daftarKelurahanSurabaya;
            for (let i = 0; i < kandidat.length; i++) {
                const pattern = new RegExp('\\b' + escapeRegex(kandidat[i].nama_kel) + '\\b', 'i');
                if (pattern.test(teksGabungan)) {
                    kelurahan = kandidat[i].nama_kel;
                    kecamatan = kandidat[i].nama_kec;
                    break;
                }
            }
        }

        if (!kecamatan) {
            for (let i = 0; i < daftarKelurahanSurabaya.length; i++) {
                const pattern = new RegExp('\\b' + escapeRegex(daftarKelurahanSurabaya[i].nama_kec) + '\\b', 'i');
                if (pattern.test(teksGabungan)) {
                    kecamatan = daftarKelurahanSurabaya[i].nama_kec;
                    break;
                }
            }
        }

        return { kecamatan, kelurahan };
    }

    function bukaModalEditKebijakan(hash) {
        if (!hash || hash === 'undefined') return;

        const row = mapDataKebijakan.get(hash) || {};

        fetch(`${ROUTES_KEBIJAKAN.show}/${encodeURIComponent(hash)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            return res.json();
        })
        .then(json => {
            const detail = json && json.data && typeof json.data === 'object' && !Array.isArray(json.data) ? json.data : json;
            isiFormModalEdit(hash, gabungDataSk(row, detail));
        })
        .catch(err => {
            console.error(err);
            if (Object.keys(row).length > 0) {
                isiFormModalEdit(hash, row);
            } else {
                alert('Gagal mengambil data SK.');
            }
        });
    }

    function isiFormModalEdit(hash, data) {
        document.getElementById('kebijakan_hash').value = hash;
        document.getElementById('kebijakan_no_sk').value = data.no_sk || '';
        document.getElementById('kebijakan_perihal').value = data.perihal || '';

        const wilayah = cariWilayahSk(data);

        const modalKec = document.getElementById('kebijakan_id_kec');
        if (modalKec) {
            modalKec.value = wilayah.kecamatan;
            const selectedOpt = modalKec.options[modalKec.selectedIndex];
            const idKec = selectedOpt ? selectedOpt.getAttribute('data-id-kec') : '';
            inisialisasiModalKelurahan(idKec, wilayah.kecamatan);
        }

        const modalKel = document.getElementById('kebijakan_id_kel');
        if (modalKel) {
            modalKel.value = wilayah.kelurahan;
        }

        const tglMulaiVal = normalisasiTanggal(data.tgl_mulai);
        document.getElementById('kebijakan_tgl_mulai').value = tglMulaiVal;

        const tglSelesaiInput = document.getElementById('kebijakan_tgl_selesai');
        if (tglSelesaiInput) {
            if (tglMulaiVal) {
                tglSelesaiInput.min = tglMulaiVal;
            } else {
                tglSelesaiInput.removeAttribute('min');
            }
            tglSelesaiInput.value = normalisasiTanggal(data.tgl_selesai);
        }

        const modalPokja = document.getElementById('kebijakan_pokja');
        if (modalPokja) {
            const pokjaVal = String(data.pokja || '').trim();
            const opsiPokja = Array.from(modalPokja.options).find(o => o.value.toLowerCase() === pokjaVal.toLowerCase());
            modalPokja.value = opsiPokja ? opsiPokja.value : '';
        }

        document.getElementById('kebijakan_keterangan').value = data.keterangan || '';

        const inputFile = document.getElementById('kebijakan_file_sk');
        if (inputFile) inputFile.value = '';

        bersihkanPreviewBaru();
        urlFileSebelumnya = data.file_sk ? `${ROUTES_KEBIJAKAN.uploadBaseUrl}/${data.file_sk}` : '';
        tampilkanPreviewUpload(urlFileSebelumnya);

        document.getElementById('modalKebijakanTitle').textContent = 'Ubah Lampiran SK';

        const modal = new bootstrap.Modal(document.getElementById('modalKebijakan'));
        modal.show();
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
        
        const hashInput = document.getElementById('kebijakan_hash');
        const hash = hashInput && hashInput.value ? hashInput.value.trim() : '';

        const btn = document.getElementById('btnSimpanKebijakan');
        const spinner = document.getElementById('btnSimpanSpinner');
        const btnText = document.getElementById('btnSimpanText');

        const inputKec = document.getElementById('kebijakan_id_kec')?.value || '';
        const inputKel = document.getElementById('kebijakan_id_kel')?.value || '';
        const tglMulai = document.getElementById('kebijakan_tgl_mulai')?.value || '';
        const tglSelesai = document.getElementById('kebijakan_tgl_selesai')?.value || '';

        if (tglMulai && tglSelesai && tglSelesai < tglMulai) {
            alert('Tanggal selesai tidak boleh kurang dari tanggal mulai.');
            return;
        }

        spinner.classList.remove('d-none');
        btnText.textContent = 'Menyimpan...';
        btn.disabled = true;

        const formData = new FormData(form);
        const isUpdate = Boolean(hash && hash !== 'undefined');
        const postUrl = isUpdate 
            ? `${ROUTES_KEBIJAKAN.update}/${encodeURIComponent(hash)}` 
            : ROUTES_KEBIJAKAN.store;

        fetch(postUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': ROUTES_KEBIJAKAN.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
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

            const filterPokja = document.getElementById('filter_kebijakan_pokja');
            if (filterPokja) filterPokja.value = 'all';

            const filterKec = document.getElementById('filter_kebijakan_id_kec');
            if (filterKec) filterKec.value = 'all';

            const filterKel = document.getElementById('filter_kebijakan_id_kel');
            if (filterKel) {
                inisialisasiDropdownKelurahan('all');
                filterKel.value = 'all';
            }

            const searchInput = document.getElementById('kebijakan_search');
            if (searchInput) searchInput.value = '';
            kebijakanSearchQuery = '';
            
            if (isUpdate) {
                tampilkanPopUpNotifikasi('Sukses', 'Data terupdate');
            } else {
                tampilkanPopUpNotifikasi('Sukses', 'Data tersimpan');
            }

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

    function hapusKebijakan(hash) {
        if (!hash || hash === 'undefined') return;
        targetHashHapus = hash;

        const modalEl = document.getElementById('modalKonfirmasiHapus');
        const modalHapus = new bootstrap.Modal(modalEl);
        modalHapus.show();
    }

    document.getElementById('btnKonfirmasiHapus')?.addEventListener('click', function() {
        if (!targetHashHapus) return;

        const btn = document.getElementById('btnKonfirmasiHapus');
        const spinner = document.getElementById('btnHapusSpinner');
        const btnText = document.getElementById('btnHapusText');

        btn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Menghapus...';

        fetch(`${ROUTES_KEBIJAKAN.destroy}/${encodeURIComponent(targetHashHapus)}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ROUTES_KEBIJAKAN.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
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
            const modalEl = document.getElementById('modalKonfirmasiHapus');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            
            targetHashHapus = null;
            tampilkanPopUpNotifikasi('Sukses', 'Data telah dihapus');
            fetchTableKebijakan(kebijakanCurrentPage);
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menghapus data.');
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = 'Ya, Hapus';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        inisialisasiDropdownKecamatan();
        inisialisasiDropdownKelurahan('all');
        fetchTableKebijakan(1);

        const modalKebijakanEl = document.getElementById('modalKebijakan');
        if (modalKebijakanEl) {
            modalKebijakanEl.addEventListener('hidden.bs.modal', function() {
                bersihkanPreviewBaru();
                urlFileSebelumnya = '';
                tampilkanPreviewUpload('');
            });
        }
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
    window.handleFilterKelurahanChange = handleFilterKelurahanChange;
    window.handleModalKecamatanChange = handleModalKecamatanChange;
    window.handleModalKelurahanChange = handleModalKelurahanChange;
    window.handleTanggalMulaiChange = handleTanggalMulaiChange;
    window.tampilkanPopUpNotifikasi = tampilkanPopUpNotifikasi;
</script>
@endsection