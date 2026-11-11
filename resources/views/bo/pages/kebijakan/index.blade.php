@extends('bo.layout.app')

@section('content')

@php
    $canCreate = \App\Support\Access::can('kebijakan', 'create');
    $canUpdate = \App\Support\Access::can('kebijakan', 'update');
    $canDelete = \App\Support\Access::can('kebijakan', 'delete');
@endphp

<style>
    .banner-kebijakan-card {
        background: #0f5847 radial-gradient(#197862 1.5px, transparent 1.5px);
        background-size: 16px 16px;
        min-height: 260px;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    .banner-kebijakan-card .card-body {
        position: relative;
        z-index: 2;
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
        height: 250px;
        width: 250px;
        opacity: 1;
        pointer-events: none;
    }
    @media (max-width: 767px) {
        .banner-silhouette-vector {
            height: 130px;
            width: 130px;
            opacity: 0.3;
        }
    }
    .btn-tambah-sk {
    background: #ffffff !important;
    border: 1px solid #ffffff !important;
    color: #0f5847 !important;
    transition: all 0.25s ease-in-out;
    }
    .btn-tambah-sk:hover {
        background: #f4ead0 !important;
        border-color: #f4ead0 !important;
        color: #0f5847 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        transform: translateY(-1px);
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
        width: auto;
        height: 36px;
        padding: 0 12px;
        gap: 6px;
        background: #0f5847;
        border-color: #0f5847;
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(15, 88, 71, 0.25);
    }
    .btn-action-pdf:hover {
        background: #197862;
        border-color: #197862;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(15, 88, 71, 0.35);
    }
    .btn-action-preview {
        background: #f5f3ff;
        border-color: #ddd6fe;
    }
    .btn-action-preview:hover {
        background: #ede9fe;
        border-color: #c4b5fd;
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
        <div class="card-body p-8 p-md-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center position-relative z-index-2 gap-4">
            <div class="text-white">
                <h1 class="fs-2x fw-bolder text-white mb-2 tracking-wide">Data Lampiran SK</h1>
                <p class="fs-6 text-white text-opacity-80 mb-0">
                    Berikut adalah data lampiran SK yang telah diinputkan.
                </p>
                <div class="d-flex align-items-center mt-5">
                    @if($canCreate)
                    <button type="button" class="btn btn-tambah-sk fw-bold px-5 py-3 rounded-3 shadow-sm d-flex align-items-center gap-2" onclick="bukaModalTambahKebijakan()">
                        <span class="fs-4 lh-1 fw-bold">+</span>
                        <span class="fs-7 fw-bolder text-uppercase">Tambah Lampiran SK</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="banner-silhouette-bg"></div>
        <svg class="banner-silhouette-vector d-none d-md-block" viewBox="0 0 160 170" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="80" cy="85" r="72" fill="#197862" opacity="0.45"/>

            <rect x="44" y="22" width="84" height="116" rx="2" fill="#d3cbb0" transform="rotate(10 86 80)"/>
            <rect x="44" y="22" width="84" height="116" rx="2" fill="#e3dcc5" transform="rotate(5 86 80)"/>

            <g transform="rotate(-5 84 80)">
                <path d="M44 22 H114 L134 42 V144 H44Z" fill="#07382c" opacity="0.35"/>
                <path d="M40 18 H110 L130 38 V140 H40Z" fill="#fbf8ee"/>
                <path d="M110 18 V38 H130Z" fill="#e3dcc5"/>

                <circle cx="52" cy="32" r="5" stroke="#0f5847" stroke-width="1"/>
                <circle cx="52" cy="32" r="1.8" fill="#0f5847"/>
                <rect x="62" y="28" width="40" height="3" rx="1.5" fill="#0f5847"/>
                <rect x="62" y="34" width="28" height="2.4" rx="1.2" fill="#0f5847" opacity="0.45"/>
                <line x1="46" y1="43" x2="124" y2="43" stroke="#0f5847" stroke-width="0.7"/>

                <rect x="57" y="51" width="56" height="5" rx="2.5" fill="#0f5847"/>
                <rect x="64" y="60" width="42" height="2.4" rx="1.2" fill="#0f5847" opacity="0.45"/>

                <g fill="#0f5847" opacity="0.28">
                    <rect x="48" y="74" width="76" height="2.2" rx="1"/>
                    <rect x="48" y="80" width="76" height="2.2" rx="1"/>
                    <rect x="48" y="86" width="68" height="2.2" rx="1"/>
                    <rect x="48" y="92" width="76" height="2.2" rx="1"/>
                    <rect x="48" y="98" width="46" height="2.2" rx="1"/>
                </g>

                <rect x="84" y="104" width="24" height="2.2" rx="1" fill="#0f5847" opacity="0.45"/>
                <path d="M86 116 q4 -8 7 0 t7 0 t7 -3" stroke="#0f5847" stroke-width="1.2" stroke-linecap="round" fill="none"/>
                <rect x="84" y="122" width="34" height="2.4" rx="1.2" fill="#0f5847" opacity="0.6"/>

                <path d="M50 10 v17 a2.6 2.6 0 0 0 5.2 0 v-19 a1.7 1.7 0 0 0 -3.4 0 v15" stroke="#aeb7b3" stroke-width="1.2" stroke-linecap="round"/>

                <g transform="translate(62 118) rotate(-12)" opacity="0.85">
                    <circle r="12" stroke="#1d8e74" stroke-width="1"/>
                    <circle r="9.6" stroke="#1d8e74" stroke-width="1.4" stroke-dasharray="1.2 1.6"/>
                    <circle r="7.2" stroke="#1d8e74" stroke-width="0.6"/>
                    <polygon points="0,-3.6 0.9,-1.1 3.4,-1.1 1.4,0.4 2.1,2.9 0,1.4 -2.1,2.9 -1.4,0.4 -3.4,-1.1 -0.9,-1.1" fill="#1d8e74"/>
                </g>
            </g>

            <path d="M117 135 L110 160 L118 156 L122 164 L125 140Z" fill="#f4ead0"/>
            <path d="M131 135 L138 160 L130 156 L126 164 L123 140Z" fill="#e0cfa3"/>
            <circle cx="124" cy="126" r="16" fill="#d9a441"/>
            <circle cx="124" cy="126" r="11.5" fill="#f2c15c"/>
            <path d="M118 126 l4.5 4.5 l9 -10" stroke="#0f5847" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="card card-flush shadow-sm">
        <div class="card-body p-6">
            <div class="d-flex justify-content-end align-items-center mb-5">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <select id="filter_kebijakan_id_kec" class="form-select form-select-sm compact-select" style="width: 140px;" onchange="handleFilterKecamatanChange()">
                        <option value="all" selected>Pilih Kecamatan</option>
                    </select>

                    <select id="filter_kebijakan_id_kel" class="form-select form-select-sm compact-select" style="width: 140px;" disabled onchange="handleFilterKelurahanChange()">
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
                            <th class="text-center min-w-100px">File</th>
                            <th class="min-w-150px">Keterangan</th>
                            <th class="min-w-110px">Dibuat Oleh</th>
                            <th class="text-center min-w-120px">Action</th>
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
                        <input type="text" id="kebijakan_no_sk" name="no_sk" class="form-control form-control-sm form-control-solid" placeholder="Contoh: 188.45/123/436.7.2/2026" maxlength="23" required>
                    </div>

                    <div class="mb-4">
                        <label class="required form-label fw-semibold fs-7 mb-1">Perihal</label>
                        <input type="text" id="kebijakan_perihal" name="perihal" class="form-control form-control-sm form-control-solid" placeholder="Perihal SK" required>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Kecamatan</label>
                            <select id="kebijakan_id_kec" name="id_kec" class="form-select form-select-sm form-select-solid" required onchange="handleModalKecamatanChange()">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="required form-label fw-semibold fs-7 mb-1">Kelurahan</label>
                            <select id="kebijakan_id_kel" name="id_kel" class="form-select form-select-sm form-select-solid" required disabled>
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
                            <input type="date" id="kebijakan_tgl_selesai" name="tgl_selesai" class="form-control form-control-sm form-control-solid" onchange="handleTanggalSelesaiChange()">
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
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>

                        <h3 class="fw-bolder text-gray-900 fs-4 mb-2">Hapus Lampiran Dokumen SK?</h3>
                        <p class="text-gray-600 fs-7 mb-6">
                            Apakah Anda yakin ingin menghapus data SK ini?
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

        <div class="modal fade" id="modalDetailKebijakan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-650px">
                <div class="modal-content">
                    <div class="modal-header py-4 px-6 border-bottom">
                        <h2 class="fw-bold fs-4 mb-0">Ringkasan Lampiran SK</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-5 px-lg-8" id="detailKebijakanBody"></div>
                    <div class="modal-footer flex-center py-4 border-top">
                        <button type="button" class="btn btn-primary btn-sm fw-semibold px-6 rounded-3" style="background-color: #0f5847; border-color: #0f5847;" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalNotifikasiPesan" tabindex="-1" aria-hidden="true" style="z-index: 2000;">
            <div class="modal-dialog modal-dialog-centered mw-350px">
                <div class="modal-content text-center p-6 border-0 shadow-lg rounded-4">
                    <div class="modal-body p-0">
                        <div id="notifikasiPesanIcon" class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: #d1fae5;"></div>
                        <h4 class="fw-bolder text-gray-900 fs-5 mb-2" id="notifikasiPesanTitle">Sukses</h4>
                        <p class="text-gray-600 fs-7 mb-5" id="notifikasiPesanText" style="white-space: pre-line;">Data berhasil diproses</p>
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

    const PERM_KEBIJAKAN = {
    update: @json($canUpdate),
    delete: @json($canDelete)
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
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="8" y1="13" x2="16" y2="13"/>
            <line x1="8" y1="17" x2="14" y2="17"/>
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

    const svgPreviewIcon = `
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
    `;

    const TIPE_POPUP = {
        success: {
            bg: '#d1fae5',
            svg: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>'
        },
        error: {
            bg: '#fee2e2',
            svg: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
        },
        warning: {
            bg: '#fef3c7',
            svg: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>'
        },
        info: {
            bg: '#dbeafe',
            svg: '<svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>'
        }
    };

    const POLA_NO_SK = /^[0-9A-Za-z.\/\-]+$/;
    const POLA_PERIHAL = /^[\p{L}\p{N} .,\-\/()&:%'"]+$/u;
    const POLA_KETERANGAN = /^[\p{L}\p{N} .,\-\/()&:%'"\r\n]+$/u;
    const POLA_BAHAYA = /(https?|ftp|sftp)\s*:|javascript\s*:|vbscript\s*:|mailto\s*:|www\s*\.|:\s*\/\/|[a-z0-9\-]+\.(com|net|org|xyz|info|biz|top|site|online|link|click|app|dev|go\.id|co\.id|or\.id|web\.id|sch\.id)\b/i;

    function tampilkanPopUpNotifikasi(judul, pesan, tipe = 'success') {
        const cfg = TIPE_POPUP[tipe] || TIPE_POPUP.info;
        const iconEl = document.getElementById('notifikasiPesanIcon');
        const titleEl = document.getElementById('notifikasiPesanTitle');
        const textEl = document.getElementById('notifikasiPesanText');
        const modalEl = document.getElementById('modalNotifikasiPesan');
        if (!modalEl) return;

        if (iconEl) {
            iconEl.style.backgroundColor = cfg.bg;
            iconEl.innerHTML = cfg.svg;
        }
        if (titleEl) titleEl.textContent = judul;
        if (textEl) textEl.textContent = pesan;

        const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        instance.show();
    }

    function bacaJson(res) {
        return res.json().catch(() => null);
    }

    function ambilPesanError(res, data, bawaan) {
        if (res.status === 419) return 'Sesi Anda telah berakhir. Muat ulang halaman lalu coba lagi.';
        if (res.status === 401) return 'Sesi login berakhir. Silakan login kembali.';
        if (res.status === 403) return 'Anda tidak memiliki izin untuk melakukan aksi ini.';
        if (res.status === 413) return 'Ukuran data atau file terlalu besar.';
        if (res.status === 429) return 'Terlalu banyak permintaan. Mohon tunggu sebentar lalu coba lagi.';
        if (data && data.errors) {
            const daftar = Object.values(data.errors).flat();
            if (daftar.length > 0) return daftar.join('\n');
        }
        if (data && data.message) return data.message;
        return bawaan;
    }

    function pesanDariError(err, bawaan) {
        if (err instanceof TypeError) return 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
        return (err && err.message) ? err.message : bawaan;
    }

    function nilaiInput(id) {
        const el = document.getElementById(id);
        return el ? el.value.trim() : '';
    }

    function validasiFormKebijakan() {
        const galat = [];

        const noSk = nilaiInput('kebijakan_no_sk');
        if (!noSk) {
            galat.push('No SK wajib diisi.');
        } else if (noSk.length > 23) {
            galat.push('No SK maksimal 23 karakter.');
        } else if (!POLA_NO_SK.test(noSk) || POLA_BAHAYA.test(noSk)) {
            galat.push('No SK hanya boleh berisi huruf, angka, titik, garis miring, dan tanda hubung.');
        }

        const perihal = nilaiInput('kebijakan_perihal');
        if (!perihal) {
            galat.push('Perihal wajib diisi.');
        } else if (perihal.length > 255) {
            galat.push('Perihal maksimal 255 karakter.');
        } else if (!POLA_PERIHAL.test(perihal)) {
            galat.push('Perihal mengandung karakter yang tidak diizinkan. Hanya huruf, angka, spasi, dan tanda . , - / ( ) & : % \' " yang boleh digunakan.');
        } else if (POLA_BAHAYA.test(perihal)) {
            galat.push('Perihal tidak boleh berisi link atau script.');
        }

        const kec = nilaiInput('kebijakan_id_kec');
        const kel = nilaiInput('kebijakan_id_kel');
        if (!kec) {
            galat.push('Kecamatan wajib dipilih.');
        } else if (!kel) {
            galat.push('Kelurahan wajib dipilih.');
        } else if (Math.floor(parseInt(kel, 10) / 100) !== parseInt(kec, 10)) {
            galat.push('Kelurahan tidak sesuai dengan kecamatan yang dipilih.');
        }

        const tglMulai = nilaiInput('kebijakan_tgl_mulai');
        const tglSelesai = nilaiInput('kebijakan_tgl_selesai');
        if (!tglMulai) {
            galat.push('Tanggal mulai wajib diisi.');
        } else if (tglMulai < '2000-01-01' || tglMulai > '2100-12-31') {
            galat.push('Tanggal mulai harus antara tahun 2000 dan 2100.');
        }
        if (tglMulai && tglSelesai) {
            if (tglSelesai < tglMulai) {
                galat.push('Tanggal selesai tidak boleh kurang dari tanggal mulai.');
            } else if (tglSelesai > '2100-12-31') {
                galat.push('Tanggal selesai tidak boleh melebihi tahun 2100.');
            }
        }

        const keterangan = nilaiInput('kebijakan_keterangan');
        if (keterangan) {
            if (keterangan.length > 1000) {
                galat.push('Keterangan maksimal 1000 karakter.');
            } else if (!POLA_KETERANGAN.test(keterangan)) {
                galat.push('Keterangan mengandung karakter yang tidak diizinkan.');
            } else if (POLA_BAHAYA.test(keterangan)) {
                galat.push('Keterangan tidak boleh berisi link atau script.');
            }
        }

        const inputFile = document.getElementById('kebijakan_file_sk');
        if (inputFile && inputFile.files && inputFile.files[0]) {
            const file = inputFile.files[0];
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            if (!isPdf) {
                galat.push('File SK harus berformat PDF.');
            } else if (file.size > 2 * 1024 * 1024) {
                galat.push('File SK harus di bawah 2MB.');
            }
        }

        return galat;
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
                opt.value = kec.id_kec;
                opt.textContent = kec.nama_kec;
                filterKec.appendChild(opt);
            });
        }

        if (modalKec) {
            modalKec.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kecamatanUnik.forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec.id_kec;
                opt.textContent = kec.nama_kec;
                modalKec.appendChild(opt);
            });
        }
    }

    function inisialisasiDropdownKelurahan(idKec = 'all') {
        const filterKel = document.getElementById('filter_kebijakan_id_kel');
        if (!filterKel) return;

        filterKel.innerHTML = '<option value="all" selected>Pilih Kelurahan</option>';

        if (idKec === 'all' || idKec === '') {
            filterKel.disabled = true;
            return;
        }

        daftarKelurahanSurabaya
            .filter(item => String(item.id_kec) === String(idKec))
            .sort((a, b) => a.nama_kel.localeCompare(b.nama_kel))
            .forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel.id_kel;
                opt.textContent = kel.nama_kel;
                filterKel.appendChild(opt);
            });

        filterKel.disabled = false;
    }

    function inisialisasiModalKelurahan(idKec = '') {
        const modalKel = document.getElementById('kebijakan_id_kel');
        if (!modalKel) return;

        modalKel.innerHTML = '<option value="">Pilih Kelurahan</option>';

        if (!idKec) {
            modalKel.disabled = true;
            return;
        }

        daftarKelurahanSurabaya
            .filter(item => String(item.id_kec) === String(idKec))
            .sort((a, b) => a.nama_kel.localeCompare(b.nama_kel))
            .forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel.id_kel;
                opt.textContent = kel.nama_kel;
                modalKel.appendChild(opt);
            });

        modalKel.disabled = false;
    }

    function handleFilterKecamatanChange() {
        const filterKec = document.getElementById('filter_kebijakan_id_kec');
        const selectedKec = filterKec ? filterKec.value : 'all';

        inisialisasiDropdownKelurahan(selectedKec);
        fetchTableKebijakan(1);
    }

    function handleFilterKelurahanChange() {
        fetchTableKebijakan(1);
    }

    function handleModalKecamatanChange() {
        const modalKec = document.getElementById('kebijakan_id_kec');
        inisialisasiModalKelurahan(modalKec ? modalKec.value : '');
    }

    function sinkronTanggal() {
        const mulai = document.getElementById('kebijakan_tgl_mulai');
        const selesai = document.getElementById('kebijakan_tgl_selesai');
        if (!mulai || !selesai) return;

        if (mulai.value) {
            selesai.min = mulai.value;
        } else {
            selesai.removeAttribute('min');
        }

        if (selesai.value) {
            mulai.max = selesai.value;
        } else {
            mulai.removeAttribute('max');
        }
    }

    function handleTanggalMulaiChange() {
        const mulai = document.getElementById('kebijakan_tgl_mulai');
        const selesai = document.getElementById('kebijakan_tgl_selesai');
        if (mulai && selesai && mulai.value && selesai.value && mulai.value > selesai.value) {
            mulai.value = selesai.value;
            tampilkanPopUpNotifikasi('Peringatan', 'Tanggal mulai tidak boleh melebihi tanggal selesai. Tanggal mulai disesuaikan.', 'warning');
        }
        sinkronTanggal();
    }

    function handleTanggalSelesaiChange() {
        const mulai = document.getElementById('kebijakan_tgl_mulai');
        const selesai = document.getElementById('kebijakan_tgl_selesai');
        if (mulai && selesai && mulai.value && selesai.value && selesai.value < mulai.value) {
            selesai.value = mulai.value;
            tampilkanPopUpNotifikasi('Peringatan', 'Tanggal selesai tidak boleh kurang dari tanggal mulai. Tanggal selesai disesuaikan.', 'warning');
        }
        sinkronTanggal();
    }

    function tampilkanPreviewUpload(url) {
        const box = document.getElementById('file_sk_sebelumnya');
        if (!box) return;

        box.innerHTML = '';

        if (!url) {
            box.classList.add('d-none');
            return;
        }

        const iframe = document.createElement('iframe');
        iframe.src = url;
        iframe.width = '100%';
        iframe.height = '320';
        iframe.style.border = '1px solid #d1d5db';
        iframe.style.borderRadius = '6px';
        box.appendChild(iframe);
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
                tampilkanPopUpNotifikasi(
                    'File Ditolak',
                    !isPdf ? 'File harus berformat PDF.' : 'Ukuran file harus di bawah 2MB.',
                    'warning'
                );
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
        .then(async (res) => {
            const data = await bacaJson(res);
            if (!res.ok) throw new Error(ambilPesanError(res, data, 'Gagal memuat data.'));
            return data;
        })
        .then(data => {
            renderTableKebijakan(data);
        })
        .catch(err => {
            console.error(err);
            renderTableKebijakan({
                total: 0,
                current_page: 1,
                per_page: kebijakanPageSize,
                last_page: 1,
                data: []
            });
            tampilkanPopUpNotifikasi('Gagal Memuat Data', pesanDariError(err, 'Gagal memuat data.'), 'error');
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
            if (row.file_sk) {
                const btnPdf = document.createElement('button');
                btnPdf.type = 'button';
                btnPdf.className = 'btn-action-icon btn-action-pdf shadow-none';
                btnPdf.title = 'Preview Dokumen PDF';
                btnPdf.innerHTML = svgPdfIcon + '<span>PDF</span>';
                btnPdf.addEventListener('click', function() {
                    bukaPreviewPdf(`${ROUTES_KEBIJAKAN.uploadBaseUrl}/${encodeURIComponent(row.file_sk)}`, row.no_sk);
                });
                tdFile.appendChild(btnPdf);
            } else {
                tdFile.innerHTML = '<span class="text-muted fs-8">-</span>';
            }

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

            const btnPreview = document.createElement('button');
            btnPreview.type = 'button';
            btnPreview.className = 'btn-action-icon btn-action-preview';
            btnPreview.title = 'Lihat Ringkasan SK';
            btnPreview.innerHTML = svgPreviewIcon;
            btnPreview.addEventListener('click', function() {
                bukaDetailKebijakan(hash);
            });

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

            actionContainer.appendChild(btnPreview);
            if (PERM_KEBIJAKAN.update) actionContainer.appendChild(btnEdit);
            if (PERM_KEBIJAKAN.delete) actionContainer.appendChild(btnDelete);

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

        sinkronTanggal();
        inisialisasiModalKelurahan('');

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

    function bukaModalEditKebijakan(hash) {
        if (!hash || hash === 'undefined') return;

        const row = mapDataKebijakan.get(hash) || {};

        fetch(`${ROUTES_KEBIJAKAN.show}/${encodeURIComponent(hash)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async (res) => {
            const data = await bacaJson(res);
            if (!res.ok) throw new Error(ambilPesanError(res, data, 'Gagal mengambil data SK.'));
            return data;
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
                tampilkanPopUpNotifikasi('Gagal', pesanDariError(err, 'Gagal mengambil data SK.'), 'error');
            }
        });
    }

    function isiFormModalEdit(hash, data) {
        document.getElementById('kebijakan_hash').value = hash;
        document.getElementById('kebijakan_no_sk').value = data.no_sk || '';
        document.getElementById('kebijakan_perihal').value = data.perihal || '';

        const modalKec = document.getElementById('kebijakan_id_kec');
        if (modalKec) {
            modalKec.value = data.id_kec ? String(data.id_kec) : '';
            inisialisasiModalKelurahan(modalKec.value);
        }

        const modalKel = document.getElementById('kebijakan_id_kel');
        if (modalKel) {
            modalKel.value = data.id_kel ? String(data.id_kel) : '';
        }

        document.getElementById('kebijakan_tgl_mulai').value = normalisasiTanggal(data.tgl_mulai);
        document.getElementById('kebijakan_tgl_selesai').value = normalisasiTanggal(data.tgl_selesai);
        sinkronTanggal();

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
        urlFileSebelumnya = data.file_sk ? `${ROUTES_KEBIJAKAN.uploadBaseUrl}/${encodeURIComponent(data.file_sk)}` : '';
        tampilkanPreviewUpload(urlFileSebelumnya);

        document.getElementById('modalKebijakanTitle').textContent = 'Ubah Lampiran SK';

        const modal = new bootstrap.Modal(document.getElementById('modalKebijakan'));
        modal.show();
    }

    function ambilNamaWilayah(row) {
        const kel = daftarKelurahanSurabaya.find(item => String(item.id_kel) === String(row.id_kel));
        const kec = daftarKelurahanSurabaya.find(item => String(item.id_kec) === String(row.id_kec));
        return {
            namaKec: row.nama_kec || (kec ? kec.nama_kec : ''),
            namaKel: row.nama_kel || (kel ? kel.nama_kel : '')
        };
    }

    function tambahBarisDetail(container, label, isi) {
        const baris = document.createElement('div');
        baris.className = 'row g-2 py-3 border-bottom';

        const kolomLabel = document.createElement('div');
        kolomLabel.className = 'col-12 col-sm-4 fw-semibold fs-7 text-gray-600';
        kolomLabel.textContent = label;

        const kolomIsi = document.createElement('div');
        kolomIsi.className = 'col-12 col-sm-8 fs-7 text-gray-900';
        kolomIsi.style.whiteSpace = 'pre-wrap';
        kolomIsi.style.wordBreak = 'break-word';

        if (isi instanceof Node) {
            kolomIsi.appendChild(isi);
        } else {
            kolomIsi.textContent = isi || '-';
        }

        baris.appendChild(kolomLabel);
        baris.appendChild(kolomIsi);
        container.appendChild(baris);
    }

    function bukaDetailKebijakan(hash) {
        const row = mapDataKebijakan.get(hash);
        if (!row) {
            tampilkanPopUpNotifikasi('Gagal', 'Data SK tidak ditemukan.', 'error');
            return;
        }

        const body = document.getElementById('detailKebijakanBody');
        if (!body) return;
        body.innerHTML = '';

        const wilayah = ambilNamaWilayah(row);
        const teksKec = wilayah.namaKec || '-';
        const teksKel = wilayah.namaKel || '-';

        tambahBarisDetail(body, 'No SK', row.no_sk);
        tambahBarisDetail(body, 'Perihal', row.perihal);
        tambahBarisDetail(body, 'Pokja', row.pokja);
        tambahBarisDetail(body, 'Kecamatan', teksKec);
        tambahBarisDetail(body, 'Kelurahan', teksKel);
        tambahBarisDetail(body, 'Tahun', row.tahun ? String(row.tahun) : '');
        tambahBarisDetail(body, 'Tanggal Mulai', row.tgl_mulai);
        tambahBarisDetail(body, 'Tanggal Selesai', row.tgl_selesai);
        tambahBarisDetail(body, 'Keterangan', row.keterangan);

        if (row.file_sk) {
            const link = document.createElement('a');
            link.href = `${ROUTES_KEBIJAKAN.uploadBaseUrl}/${encodeURIComponent(row.file_sk)}`;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.className = 'btn-action-icon btn-action-pdf';
            link.style.whiteSpace = 'normal';
            link.innerHTML = svgPdfIcon + '<span>Buka PDF</span>';
            tambahBarisDetail(body, 'File SK', link);
        } else {
            tambahBarisDetail(body, 'File SK', '');
        }

                tambahBarisDetail(body, 'Dibuat Oleh', row.created_by);

        const modalEl = document.getElementById('modalDetailKebijakan');
        const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        instance.show();
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

        const galat = validasiFormKebijakan();
        if (galat.length > 0) {
            tampilkanPopUpNotifikasi('Data Belum Valid', galat.join('\n'), 'warning');
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
            const data = await bacaJson(res);
            if (!res.ok) {
                throw new Error(ambilPesanError(res, data, 'Gagal menyimpan data.'));
            }
            return data;
        })
        .then((data) => {
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

            if (data && data.status === 'partial') {
                tampilkanPopUpNotifikasi('Sebagian Berhasil', data.message, 'warning');
            } else if (isUpdate) {
                tampilkanPopUpNotifikasi('Sukses', 'Data terupdate', 'success');
            } else {
                tampilkanPopUpNotifikasi('Sukses', 'Data tersimpan', 'success');
            }

            fetchTableKebijakan(1);
        })
        .catch(err => {
            console.error(err);
            tampilkanPopUpNotifikasi('Gagal Menyimpan', pesanDariError(err, 'Terjadi kesalahan saat menyimpan data.'), 'error');
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
            const data = await bacaJson(res);
            if (!res.ok) {
                throw new Error(ambilPesanError(res, data, 'Gagal menghapus data.'));
            }
            return data;
        })
        .then(() => {
            const modalEl = document.getElementById('modalKonfirmasiHapus');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();

            targetHashHapus = null;
            tampilkanPopUpNotifikasi('Sukses', 'Data telah dihapus', 'success');
            fetchTableKebijakan(kebijakanCurrentPage);
        })
        .catch(err => {
            console.error(err);
            const modalEl = document.getElementById('modalKonfirmasiHapus');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
            tampilkanPopUpNotifikasi('Gagal Menghapus', pesanDariError(err, 'Terjadi kesalahan saat menghapus data.'), 'error');
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
                inisialisasiModalKelurahan('');
                sinkronTanggal();
            });
        }

        const modalNotifEl = document.getElementById('modalNotifikasiPesan');
        if (modalNotifEl) {
            modalNotifEl.addEventListener('hidden.bs.modal', function() {
                if (document.querySelector('.modal.show')) {
                    document.body.classList.add('modal-open');
                }
            });
        }
    });

    window.fetchTableKebijakan = fetchTableKebijakan;
    window.changeKebijakanPageSize = changeKebijakanPageSize;
    window.searchKebijakanTable = searchKebijakanTable;
    window.bukaModalTambahKebijakan = bukaModalTambahKebijakan;
    window.bukaModalEditKebijakan = bukaModalEditKebijakan;
    window.bukaPreviewPdf = bukaPreviewPdf;
    window.bukaDetailKebijakan = bukaDetailKebijakan;
    window.submitFormKebijakan = submitFormKebijakan;
    window.hapusKebijakan = hapusKebijakan;
    window.validasiFilePdf = validasiFilePdf;
    window.handleFilterKecamatanChange = handleFilterKecamatanChange;
    window.handleFilterKelurahanChange = handleFilterKelurahanChange;
    window.handleModalKecamatanChange = handleModalKecamatanChange;
    window.handleTanggalMulaiChange = handleTanggalMulaiChange;
    window.handleTanggalSelesaiChange = handleTanggalSelesaiChange;
    window.tampilkanPopUpNotifikasi = tampilkanPopUpNotifikasi;
</script>
@endsection