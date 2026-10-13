@extends('bo.layout.app')

@section('content')
<style>
    #view-inovasi-dashboard, 
    #view-inovasi-input,
    #modal-form-inovasi,
    #modal-confirm-delete,
    #modal-preview-media {
        color: #0f172a !important;
        font-family: inherit;
    }

    .banner-inovasi-tosca {
        background: linear-gradient(135deg, #0b5e57 0%, #0d6e66 50%, #084943 100%) !important;
        position: relative;
        overflow: hidden;
        border-radius: 1.25rem !important;
        border: none !important;
        box-shadow: 0 10px 25px -5px rgba(11, 94, 87, 0.35);
        min-height: 220px;
        display: flex;
        align-items: center;
    }

    .banner-inovasi-tosca::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1.2px, transparent 1.2px);
        background-size: 22px 22px;
        pointer-events: none !important;
        z-index: 1;
    }

    .banner-siluet-kanan {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 100%;
        max-height: 195px;
        opacity: 0.55;
        pointer-events: none !important;
        z-index: 1 !important;
    }

    .banner-inovasi-tosca h2 {
        color: #ffffff !important;
    }
    .banner-inovasi-tosca span.fw-semibold {
        color: #e6fffa !important;
    }

    .btn-tab-pill-tosca {
        min-width: 170px;
        padding: 10px 18px;
        border-radius: 1rem;
        transition: all 0.25s ease;
        cursor: pointer !important;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        text-decoration: none;
        border: none;
        outline: none;
        position: relative !important;
        z-index: 9999 !important;
        pointer-events: auto !important;
    }

    .btn-tab-pill-tosca.active {
        background-color: #ffffff !important;
        border: 1px solid #ffffff !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
    }
    .btn-tab-pill-tosca.active .tab-title-text {
        color: #0d4e48 !important;
        font-weight: 800 !important;
    }
    .btn-tab-pill-tosca.active .tab-sub-text {
        color: #334155 !important;
    }

    .btn-tab-pill-tosca:not(.active) {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        backdrop-filter: blur(4px);
    }
    .btn-tab-pill-tosca:not(.active) .tab-title-text {
        color: #ffffff !important;
        font-weight: 800 !important;
    }
    .btn-tab-pill-tosca:not(.active) .tab-sub-text {
        color: #a7f3d0 !important;
    }

    .stat-card-title {
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 0.85rem !important;
    }

    .table-custom-wrapper {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .table-custom thead th {
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 0.85rem;
        padding: 16px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        background: #f8fafc !important;
    }

    .table-custom tbody td {
        padding: 16px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        border-bottom: 1px solid #f1f5f9;
        color: #0f172a !important;
    }

    /* Filter Select Kotak Soft Gambar 1 */
    .filter-select-compact {
        width: auto !important;
        display: inline-block !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.65rem !important;
        padding: 7px 34px 7px 14px !important;
        font-size: 0.82rem !important;
        color: #334155 !important;
        font-weight: 600;
        background-color: #ffffff !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        cursor: pointer;
    }
    .filter-select-compact:focus {
        border-color: #0d9488 !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12) !important;
    }

    /* Search Input Gambar 1 */
    .dt-search-input {
        width: 190px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.55rem !important;
        padding: 6px 12px !important;
        font-size: 0.84rem !important;
        background-color: #f8fafc !important;
        color: #0f172a !important;
        outline: none;
        transition: all 0.2s ease;
    }
    .dt-search-input:focus {
        background-color: #ffffff !important;
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12) !important;
    }

    .modal-content-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        background-color: #ffffff !important;
    }

    .form-control-modern {
        border: 1.5px solid #cbd5e1;
        border-radius: 0.55rem;
        padding: 8px 12px;
        font-size: 0.85rem;
        background-color: #ffffff !important;
        color: #0f172a !important;
        transition: all 0.2s ease;
    }
    .form-control-modern:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        outline: none;
    }

    .upload-card-box {
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 10px;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        text-align: center;
        position: relative;
    }
    .upload-card-box:hover {
        border-color: #0d9488;
        background-color: #f0fdfa;
    }

    .preview-img-container {
        width: 100%;
        height: 100px;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .preview-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-table-thumb {
        width: 44px;
        height: 38px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        transition: transform 0.2s;
        cursor: pointer;
    }
    .img-table-thumb:hover {
        transform: scale(1.08);
    }

    /* Soft Icon Buttons Gambar 2 */
    .btn-icon-square-edit {
        width: 36px;
        height: 36px;
        background-color: #eff6ff !important;
        border: 1px solid #dbeafe !important;
        color: #2563eb !important;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-icon-square-edit:hover {
        background-color: #dbeafe !important;
        transform: translateY(-1px);
    }

    .btn-icon-square-delete {
        width: 36px;
        height: 36px;
        background-color: #fff1f2 !important;
        border: 1px solid #ffe4e6 !important;
        color: #f43f5e !important;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-icon-square-delete:hover {
        background-color: #ffe4e6 !important;
        transform: translateY(-1px);
    }

    .modal-delete-icon-box {
        width: 68px;
        height: 68px;
        background-color: #ffe4e6;
        color: #e11d48;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.85rem;
        box-shadow: 0 0 0 8px #fff1f2;
    }

    .modal-delete-desc {
        color: #334155 !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        line-height: 1.5;
    }

    #table-pagination-list {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    #table-pagination-list .page-link {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1;
        border-radius: 6px !important;
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        padding: 0 !important;
        cursor: pointer;
    }

    #table-pagination-list .page-item.active .page-link {
        color: #ffffff !important;
        background-color: #0d9488 !important;
        border-color: #0d9488 !important;
    }

    .toast-container-custom {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 10000;
    }

    .tab-view-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }
</style>

<div class="d-flex flex-column gap-4 w-100 p-2 p-md-3">

    <!-- BANNER DASHBOARD -->
    <div class="card banner-inovasi-tosca mb-4">
        <svg class="banner-siluet-kanan" viewBox="0 0 450 180" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M280 180 L310 40 L315 40 L345 180 Z" fill="#2dd4bf" />
            <path d="M312 15 L314 15 L314 40 L312 40 Z" fill="#2dd4bf" />
            <path d="M340 180 L340 100 L355 100 L355 180 Z" fill="#14b8a6" />
            <path d="M358 180 L358 80 L378 80 L378 180 Z" fill="#0d9488" />
            <path d="M382 180 L382 110 L400 110 L400 180 Z" fill="#14b8a6" />
            <path d="M360 180 C390 110 420 90 460 80 L460 180 Z" fill="#0f766e" />
            <path d="M390 180 C410 130 435 110 460 105 L460 180 Z" fill="#115e59" />
        </svg>

        <div class="card-body py-5 px-4 px-md-5 d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-4 position-relative w-100" style="z-index: 10;">
            <div>
                <h2 class="fw-bolder mb-1 text-uppercase tracking-wide" style="font-size: 2.1rem; letter-spacing: 0.5px;">
                    Inovasi Global
                </h2>
                <span class="fw-semibold" style="font-size: 0.95rem;">
                   Berikut adalah Inovasi PKK yang telah diinputkan 
                </span>
            </div>

            <div class="d-flex flex-wrap gap-3" style="position: relative; z-index: 9999;">
                <button type="button" class="btn-tab-pill-tosca active" id="btn-tab-dashboard">
                    <div>
                        <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Dashboard</span>
                        <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Ringkasan & Distribusi</span>
                    </div>
                </button>

                <button type="button" class="btn-tab-pill-tosca" id="btn-tab-input">
                    <div>
                        <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Input Inovasi</span>
                        <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Daftar & Kelola</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div id="view-inovasi-dashboard" class="tab-view-container">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Kecamatan</label>
                        <select id="dash-filter-kecamatan" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua kecamatan</option>
                            @if(isset($kecamatan) && is_iterable($kecamatan))
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->id_kec }}">{{ $kec->nama_kec }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Kelurahan</label>
                        <select id="dash-filter-kelurahan" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua kelurahan</option>
                            @if(isset($kelurahan) && is_iterable($kelurahan))
                                @foreach($kelurahan as $kel)
                                    <option value="{{ $kel->id_kel }}">{{ $kel->nama_kel }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Periode</label>
                        <select id="dash-filter-periode" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua Periode</option>
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1" id="stat-count-sekretaris">0</h2>
                        <span class="stat-card-title d-block mb-3">Sekretaris</span>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1" id="stat-count-pokja1">0</h2>
                        <span class="stat-card-title d-block mb-3">Pokja 1</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1" id="stat-count-pokja2">0</h2>
                        <span class="stat-card-title d-block mb-3">Pokja 2</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1" id="stat-count-pokja3">0</h2>
                        <span class="stat-card-title d-block mb-3">Pokja 3</span>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1" id="stat-count-pokja4">0</h2>
                        <span class="stat-card-title d-block mb-3">Pokja 4</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="fw-bold text-dark mb-0">Distribusi Inovasi per Pokja</h5>
                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold" id="stat-total-badge">Total: 0 Inovasi</span>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center">
                        <span class="text-dark fw-bold small text-start" style="width: 100px;">Pokja 4</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" id="bar-pokja4" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" id="val-pokja4" style="width: 30px;">0</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-dark fw-bold small text-start" style="width: 100px;">Pokja 3</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-success" id="bar-pokja3" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" id="val-pokja3" style="width: 30px;">0</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-dark fw-bold small text-start" style="width: 100px;">Sekretaris</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-success" id="bar-sekretaris" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" id="val-sekretaris" style="width: 30px;">0</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-dark fw-bold small text-start" style="width: 100px;">Pokja 1</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" id="bar-pokja1" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" id="val-pokja1" style="width: 30px;">0</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-dark fw-bold small text-start" style="width: 100px;">Pokja 2</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" id="bar-pokja2" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" id="val-pokja2" style="width: 30px;">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="view-inovasi-input" class="tab-view-container" style="display: none;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <div class="d-flex flex-wrap justify-content-end align-items-center mb-4 gap-2">
                    <select id="table-filter-kecamatan" class="form-select filter-select-compact text-uppercase">
                        <option value="Semua">SEMUA KECAMATAN</option>
                        @if(isset($kecamatan) && is_iterable($kecamatan))
                            @foreach($kecamatan as $kec)
                                <option value="{{ $kec->id_kec }}">{{ strtoupper($kec->nama_kec) }}</option>
                            @endforeach
                        @endif
                    </select>

                    <select id="table-filter-kelurahan" class="form-select filter-select-compact">
                        <option value="Semua">Pilih Kelurahan</option>
                        @if(isset($kelurahan) && is_iterable($kelurahan))
                            @foreach($kelurahan as $kel)
                                <option value="{{ $kel->id_kel }}">{{ $kel->nama_kel }}</option>
                            @endforeach
                        @endif
                    </select>

                    <select id="table-filter-periode" class="form-select filter-select-compact">
                        <option value="Semua">Semua</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-dark fw-semibold" style="font-size: 0.9rem;">Show</span>
                        <select id="entries-per-page" class="form-select filter-select-compact py-1 px-2" style="padding-right: 28px !important;">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <button type="button" id="btn-tambah-data-modal" class="btn btn-sm btn-success px-3 py-2 fw-bold rounded-3 shadow-sm me-2 text-white">
                            <i class="fa-solid fa-plus me-1 text-white"></i> Tambah Inovasi
                        </button>
                        <span class="text-dark fw-semibold" style="font-size: 0.9rem;">Search:</span>
                        <input type="text" id="search-inovasi-input" class="dt-search-input" placeholder="" autocomplete="off" />
                    </div>
                </div>

                <!-- TABEL DATA INOVASI -->
                <div class="table-custom-wrapper">
                    <div class="table-responsive mb-0">
                        <table class="table table-custom align-middle mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">No <i class="fa-solid fa-angle-up text-secondary ms-1" style="font-size: 0.7rem;"></i></th>
                                    <th>Tanggal<br>Entry</th>
                                    <th>Nama Inovasi</th>
                                    <th>Deskripsi<br>Inovasi</th>
                                    <th class="text-center">File</th>
                                    <th class="text-center">Foto<br>Inovasi</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Keterangan</th>
                                    <th>Dibuat<br>Oleh</th>
                                    <th class="text-center" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="innovation-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINASI -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-4 mt-1 border-top">
                    <span class="text-dark small fw-semibold" id="table-info-label">
                        Showing 0 to 0 of 0 entries
                    </span>
                    <nav aria-label="Navigasi Halaman">
                        <ul class="pagination pagination-sm mb-0" id="table-pagination-list">
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-form-inovasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
        <div class="modal-content modal-content-modern">
            <div class="modal-header border-bottom px-4 py-3 bg-white">
                <h6 class="modal-title fw-bold text-dark fs-5 mb-0" id="modal-form-title">Tambah Data Inovasi</h6>
                <button type="button" class="btn-close" id="btn-close-modal" aria-label="Close"></button>
            </div>

            <form id="form-submit-inovasi" class="p-4 d-flex flex-column gap-3 bg-white">
                @csrf
                <input type="hidden" id="entry-index-id" name="id" value="-1">

                <div id="modal-alert-box" class="alert alert-danger py-2 px-3 small rounded-3 d-none align-items-center gap-2" role="alert">
                    <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    <span id="modal-alert-msg" class="text-danger fw-bold">Mohon lengkapi semua kolom wajib!</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Tanggal Entry <span class="text-danger">*</span></label>
                        <input type="date" id="form-input-tanggal" name="tanggal_entry" class="form-control-modern w-100 fw-bold text-dark cursor-pointer" required />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Pokja <span class="text-danger">*</span></label>
                        <select id="form-input-pokja" name="pokja" class="form-control-modern w-100 fw-semibold text-dark" required>
                            <option value="">-- Pilih Pokja --</option>
                            <option value="Sekretaris">Sekretaris</option>
                            <option value="POKJA 1">POKJA 1</option>
                            <option value="POKJA 2">POKJA 2</option>
                            <option value="POKJA 3" selected>POKJA 3</option>
                            <option value="POKJA 4">POKJA 4</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Kecamatan <span class="text-danger">*</span></label>
                        <select id="form-input-kecamatan" name="id_kec" class="form-control-modern w-100 fw-semibold text-dark" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @if(isset($kecamatan) && is_iterable($kecamatan))
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->id_kec }}">{{ $kec->nama_kec }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Dibuat Oleh <span class="text-danger">*</span></label>
                        <input type="text" id="form-input-dibuat" name="dibuat_oleh" placeholder="Nama kader / pengurus" class="form-control-modern w-100 text-dark" required />
                    </div>
                </div>

                <div>
                    <label class="form-label small fw-bold text-dark mb-1">Nama Inovasi <span class="text-danger">*</span></label>
                    <input type="text" id="form-input-nama" name="nama_inovasi" placeholder="Contoh: PJ IT" class="form-control-modern w-100 text-dark" required />
                </div>

                <div>
                    <label class="form-label small fw-bold text-dark mb-1">Deskripsi Inovasi <span class="text-danger">*</span></label>
                    <textarea id="form-input-deskripsi" name="deskripsi_inovasi" rows="2" placeholder="Deskripsi inovasi" class="form-control-modern w-100 text-dark" required></textarea>
                </div>

                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-dark mb-0"><i class="fa-solid fa-images text-secondary me-1"></i> Lampiran Foto</span>
                        <span class="badge bg-danger-subtle text-danger small fw-bold" style="font-size: 0.68rem;">Maks. 2 MB</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="upload-card-box">
                                <div class="preview-img-container mb-2" id="box-preview-1">
                                    <span class="small fw-semibold text-secondary" id="text-preview-1"><i class="fa-regular fa-image fa-2x d-block mb-1 text-secondary"></i>Foto 1</span>
                                    <img src="" id="img-preview-1" class="d-none" alt="Preview Foto 1">
                                </div>
                                <input type="file" id="file-foto-1" name="foto_1" accept="image/*" class="d-none">
                                <button type="button" id="btn-pilih-foto-1" class="btn btn-sm btn-white border shadow-xs fw-bold small w-100 py-1 text-dark">
                                    <i class="fa-solid fa-cloud-arrow-up text-secondary me-1"></i> Upload 1
                                </button>
                                <span id="label-foto-1" class="small text-truncate d-block mt-1 fw-medium text-secondary" style="font-size: 0.75rem;">Belum ada foto</span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="upload-card-box">
                                <div class="preview-img-container mb-2" id="box-preview-2">
                                    <span class="small fw-semibold text-secondary" id="text-preview-2"><i class="fa-regular fa-image fa-2x d-block mb-1 text-secondary"></i>Foto 2</span>
                                    <img src="" id="img-preview-2" class="d-none" alt="Preview Foto 2">
                                </div>
                                <input type="file" id="file-foto-2" name="foto_2" accept="image/*" class="d-none">
                                <button type="button" id="btn-pilih-foto-2" class="btn btn-sm btn-white border shadow-xs fw-bold small w-100 py-1 text-dark">
                                    <i class="fa-solid fa-cloud-arrow-up text-secondary me-1"></i> Upload 2
                                </button>
                                <span id="label-foto-2" class="small text-truncate d-block mt-1 fw-medium text-secondary" style="font-size: 0.75rem;">Belum ada foto</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-dark mb-0"><i class="fa-solid fa-file-pdf text-danger me-1"></i> Dokumen Proposal / Juknis</span>
                        <span class="badge bg-danger-subtle text-danger small fw-bold" style="font-size: 0.68rem;">PDF (Maks. 3 MB)</span>
                    </div>

                    <div class="flex-column gap-2 d-flex">
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="file-dokumen-pdf" name="file_dokumen" accept="application/pdf" class="d-none">
                            <button type="button" id="btn-pilih-dokumen" class="btn btn-sm btn-white border shadow-xs fw-bold small text-dark">
                                <i class="fa-solid fa-file-pdf text-danger me-1"></i> Pilih Berkas PDF
                            </button>
                            <span id="label-dokumen-pdf" class="text-dark small text-truncate fw-semibold" style="max-width: 250px;">Belum ada PDF dipilih</span>
                        </div>

                        <div id="pdf-preview-box" class="d-none">
                            <div class="d-inline-flex align-items-center gap-2 p-2 rounded-3 bg-danger-subtle text-danger small fw-semibold">
                                <i class="fa-solid fa-file-pdf fa-lg"></i>
                                <span id="pdf-preview-name" class="text-truncate text-danger" style="max-width: 260px;">file.pdf</span>
                                <span id="pdf-preview-size" class="text-danger small"></span>
                                <button type="button" id="btn-remove-pdf" class="btn-close ms-2" style="font-size: 0.6rem;"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                    <button type="button" id="btn-batal-modal" class="btn btn-light text-dark fw-bold px-4 rounded-3 small">
                        Batal
                    </button>
                    <button type="button" id="btn-submit-modal" class="btn btn-success text-white fw-bold px-4 rounded-3 shadow-sm small">
                        Simpan Inovasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content modal-content-modern p-4 text-center bg-white">
            <div class="modal-delete-icon-box">
                <i class="fa-solid fa-trash-can"></i>
            </div>

            <h5 class="fw-bold text-dark mb-2 fs-5">Hapus Data Inovasi?</h5>
            
            <p class="modal-delete-desc mb-4">
                Apakah Anda yakin ingin menghapus <strong id="delete-item-title" class="text-danger fw-bold">"SOTH"</strong>? 
            </p>

            <input type="hidden" id="delete-target-id" value="">

            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-light text-dark fw-bold px-4 rounded-3 small" id="btn-cancel-delete">
                    Batal
                </button>
                <button type="button" class="btn-danger btn text-white fw-bold px-4 rounded-3 shadow-sm small" id="btn-execute-delete">
                    <i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PREVIEW MEDIA -->
<div class="modal fade" id="modal-preview-media" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-modern bg-white">
            <div class="modal-header border-bottom px-4 py-3">
                <h6 class="modal-title fw-bold text-dark fs-6" id="preview-media-title">Preview Berkas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center" id="preview-media-body" style="min-height: 480px; display: flex; align-items: center; justify-content: center;">
            </div>
        </div>
    </div>
</div>

<div class="toast-container-custom">
    <div id="live-toast-alert" class="toast align-items-center text-white bg-dark border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 py-3 px-3">
                <i id="toast-icon" class="fa-solid fa-circle-check text-success fs-5"></i>
                <span id="toast-message" class="small fw-semibold text-white">Data berhasil diproses!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const BASE_ASSET_URL = "{{ url('/') }}";
    let inovasiData = [];
    let currentFoto1 = '';
    let currentFoto2 = '';
    let currentPdfUrl = '';
    let currentPdfName = '';
    let currentPage = 1;
    let searchDebounceTimer = null;

    const MAX_FILE_SIZE_BYTES = 2 * 1024 * 1024;

    function notifyToast(message, isSuccess = true) {
        const toastEl = document.getElementById('live-toast-alert');
        const msgEl = document.getElementById('toast-message');
        const iconEl = document.getElementById('toast-icon');

        if (!toastEl) return;

        msgEl.innerText = message;
        if (isSuccess) {
            iconEl.className = 'fa-solid fa-circle-check text-success fs-5';
        } else {
            iconEl.className = 'fa-solid fa-triangle-exclamation text-danger fs-5';
        }

        if (window.bootstrap && window.bootstrap.Toast) {
            const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
            toast.show();
        } else {
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 3500);
        }
    }

    function formatAssetUrl(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('blob:') || path.startsWith('data:')) {
            return path;
        }
        const cleanPath = path.startsWith('/') ? path : '/' + path;
        return BASE_ASSET_URL + cleanPath;
    }

    function openPreviewModal(type, url, title) {
        const body = document.getElementById('preview-media-body');
        const titleEl = document.getElementById('preview-media-title');
        titleEl.innerText = title || 'Preview Berkas';
        body.innerHTML = '';

        if (type === 'pdf') {
            body.innerHTML = `<iframe src="${url}" style="width: 100%; height: 500px; border: none; border-radius: 8px;"></iframe>`;
        } else {
            body.innerHTML = `<img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 500px; object-fit: contain;">`;
        }

        const modalEl = document.getElementById('modal-preview-media');
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    function fetchDataFromServer() {
        const tbody = document.getElementById('innovation-table-body');
        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-teal mb-2" role="status"></div>
                        <div class="text-muted small fw-semibold">Memuat data dari server...</div>
                    </td>
                </tr>
            `;
        }

        const url = "{{ route('inovasi.global.getData') ?? url('/inovasi/global/get-data') }}";

        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
                inovasiData = res.data.map(item => ({
                    id: item.id,
                    tanggal: item.tanggal_entry || '',
                    nama: item.nama_inovasi || '',
                    kecamatan: item.nama_kec || item.id_kec || '-',
                    kelurahan: item.nama_kel || item.id_kel || '-',
                    id_kec: item.id_kec,
                    id_kel: item.id_kel,
                    deskripsi: item.deskripsi_inovasi || '',
                    file: item.file_dokumen ? item.file_dokumen.split('/').pop() : '',
                    pdfUrl: formatAssetUrl(item.file_dokumen),
                    foto1: formatAssetUrl(item.foto_1),
                    foto2: formatAssetUrl(item.foto_2),
                    periode: item.periode || '2026',
                    keterangan: item.keterangan || (item.pokja ? item.pokja + ' - Kota Surabaya' : '-'),
                    dibuatOleh: item.creator_name || item.dibuat_oleh || 'Kader PKK',
                    pokja: item.pokja || 'POKJA 3'
                }));
            } else {
                inovasiData = [];
            }
            updateDashboardCounters();
            renderCustomTable();
        })
        .catch(err => {
            console.error(err);
            inovasiData = [];
            renderCustomTable();
        });
    }

    function toDisplayDateFormat(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3 && parts[0].length === 4) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    function toInputDateFormat(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3 && parts[0].length === 2) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    function updateDashboardCounters() {
        const selKec = (document.getElementById('dash-filter-kecamatan')?.value || 'Semua').toLowerCase();
        const selKel = (document.getElementById('dash-filter-kelurahan')?.value || 'Semua').toLowerCase();
        const selPeriode = (document.getElementById('dash-filter-periode')?.value || 'Semua').toLowerCase();

        let counts = { sekretaris: 0, pokja1: 0, pokja2: 0, pokja3: 0, pokja4: 0 };

        inovasiData.forEach(item => {
            const itemKec = (item.id_kec || item.kecamatan || '').toString().toLowerCase();
            const itemKel = (item.id_kel || item.kelurahan || '').toString().toLowerCase();
            const itemPeriode = (item.periode || '').toString().toLowerCase();

            const matchKec = (selKec === 'semua' || itemKec === selKec);
            const matchKel = (selKel === 'semua' || itemKel === selKel);
            const matchPeriode = (selPeriode === 'semua' || itemPeriode === selPeriode);

            if (matchKec && matchKel && matchPeriode) {
                const pokja = (item.pokja || '').toUpperCase();
                if (pokja.includes('SEKRETARIS')) counts.sekretaris++;
                else if (pokja.includes('1')) counts.pokja1++;
                else if (pokja.includes('2')) counts.pokja2++;
                else if (pokja.includes('3')) counts.pokja3++;
                else if (pokja.includes('4')) counts.pokja4++;
            }
        });

        const total = counts.sekretaris + counts.pokja1 + counts.pokja2 + counts.pokja3 + counts.pokja4;

        const setElText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val;
        };

        setElText('stat-count-sekretaris', counts.sekretaris);
        setElText('stat-count-pokja1', counts.pokja1);
        setElText('stat-count-pokja2', counts.pokja2);
        setElText('stat-count-pokja3', counts.pokja3);
        setElText('stat-count-pokja4', counts.pokja4);
        setElText('stat-total-badge', `Total: ${total} Inovasi`);

        const getPercent = (val) => (total > 0 ? (val / total) * 100 : 0);

        const setBar = (barId, valId, val) => {
            const bar = document.getElementById(barId);
            const text = document.getElementById(valId);
            if (bar) bar.style.width = getPercent(val) + '%';
            if (text) text.innerText = val;
        };

        setBar('bar-pokja4', 'val-pokja4', counts.pokja4);
        setBar('bar-pokja3', 'val-pokja3', counts.pokja3);
        setBar('bar-sekretaris', 'val-sekretaris', counts.sekretaris);
        setBar('bar-pokja1', 'val-pokja1', counts.pokja1);
        setBar('bar-pokja2', 'val-pokja2', counts.pokja2);
    }

    function renderCustomTable(resetPage = false) {
        const tbody = document.getElementById('innovation-table-body');
        if (!tbody) return;

        if (resetPage) currentPage = 1;

        const searchInput = document.getElementById('search-inovasi-input');
        const q = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const limit = parseInt(document.getElementById('entries-per-page')?.value || '10');

        const filterKec = (document.getElementById('table-filter-kecamatan')?.value || 'Semua').toLowerCase();
        const filterKel = (document.getElementById('table-filter-kelurahan')?.value || 'Semua').toLowerCase();
        const filterPeriode = (document.getElementById('table-filter-periode')?.value || 'Semua').toLowerCase();

        const filtered = inovasiData.filter(item => {
            const namaVal   = (item.nama || item.nama_inovasi || '').toString().toLowerCase();
            const deskVal   = (item.deskripsi || item.deskripsi_inovasi || '').toString().toLowerCase();
            const ketVal    = (item.keterangan || '').toString().toLowerCase();
            const userVal   = (item.dibuatOleh || item.dibuat_oleh || item.creator_name || '').toString().toLowerCase();
            const kecVal    = (item.kecamatan || item.nama_kec || '').toString().toLowerCase();
            const kelVal    = (item.kelurahan || item.nama_kel || '').toString().toLowerCase();
            const periodeVal = (item.periode || '').toString().toLowerCase();
            const idKecVal  = (item.id_kec || '').toString().toLowerCase();
            const idKelVal  = (item.id_kel || '').toString().toLowerCase();

            // Match Pencarian (Multi-field)
            const matchSearch = (q === '') || 
                                namaVal.includes(q) || 
                                deskVal.includes(q) || 
                                ketVal.includes(q) || 
                                userVal.includes(q) ||
                                kecVal.includes(q) ||
                                kelVal.includes(q) ||
                                periodeVal.includes(q);

            // Match Dropdown Filter
            const matchKec = (filterKec === 'semua') || (idKecVal === filterKec) || (kecVal === filterKec);
            const matchKel = (filterKel === 'semua') || (idKelVal === filterKel) || (kelVal === filterKel);
            const matchPeriode = (filterPeriode === 'semua') || (periodeVal === filterPeriode);

            return matchSearch && matchKec && matchKel && matchPeriode;
        });

        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / limit));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * limit;
        const rows = filtered.slice(start, start + limit);

        if (rows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <i class="fa-solid fa-folder-open text-muted fs-3 d-block mb-2"></i>
                        Belum ada data inovasi yang sesuai.
                    </td>
                </tr>`;
            document.getElementById('table-info-label').innerText = 'Showing 0 to 0 of 0 entries';
            renderPagination(0);
            return;
        }

        tbody.innerHTML = rows.map((item, idx) => {
            const pdfBtn = (item.pdfUrl && item.pdfUrl !== '#')
                ? `<button type="button" onclick="openPreviewModal('pdf', '${item.pdfUrl}', 'Dokumen: ${item.nama}')" class="btn btn-sm btn-outline-danger py-1 px-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" style="font-size: 0.72rem;">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                   </button>`
                : `<span class="text-muted small">-</span>`;

            const fotoThumb1 = item.foto1 
                ? `<a href="javascript:void(0)" onclick="openPreviewModal('img', '${item.foto1}', 'Foto 1 - ${item.nama}')" class="d-inline-block me-1">
                    <img src="${item.foto1}" class="img-table-thumb shadow-xs" alt="Foto 1" title="Lihat Foto 1">
                   </a>` 
                : '';
            const fotoThumb2 = item.foto2 
                ? `<a href="javascript:void(0)" onclick="openPreviewModal('img', '${item.foto2}', 'Foto 2 - ${item.nama}')" class="d-inline-block">
                    <img src="${item.foto2}" class="img-table-thumb shadow-xs" alt="Foto 2" title="Lihat Foto 2">
                   </a>` 
                : '';

            return `
                <tr>
                    <td class="text-center fw-bold text-dark">${start + idx + 1}</td>
                    <td class="fw-bold text-dark">${item.tanggal}</td>
                    <td class="fw-bold text-dark">${item.nama}</td>
                    <td class="text-dark small" style="max-width: 250px; white-space: normal;">${item.deskripsi}</td>
                    <td class="text-center">${pdfBtn}</td>
                    <td class="text-center">
                        ${fotoThumb1}${fotoThumb2}
                        ${(!item.foto1 && !item.foto2) ? '<span class="text-muted small">-</span>' : ''}
                    </td>
                    <td class="text-center fw-bold text-dark">${item.periode}</td>
                    <td class="text-center text-dark fw-semibold">${item.keterangan}</td>
                    <td class="fw-semibold text-dark">${item.dibuatOleh}</td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                            <button type="button" class="btn-icon-square-edit btn-edit-item" data-id="${item.id}" title="Edit Data">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </button>
                            <button type="button" class="btn-icon-square-delete btn-delete-item" data-id="${item.id}" title="Hapus Data">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        const from = total ? start + 1 : 0;
        const to = Math.min(start + limit, total);
        document.getElementById('table-info-label').innerText = `Showing ${from} to ${to} of ${total} entries`;
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const ul = document.getElementById('table-pagination-list');
        if (!ul) return;

        const pages = Math.max(2, totalPages || 2);

        let html = `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" data-page="${currentPage - 1}">&lt;</a>
            </li>
        `;

        for (let p = 1; p <= pages; p++) {
            const active = (p === currentPage);
            html += `
                <li class="page-item ${active ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" data-page="${p}">${p}</a>
                </li>
            `;
        }

        html += `
            <li class="page-item ${currentPage >= pages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" data-page="${currentPage + 1}">&gt;</a>
            </li>
        `;

        ul.innerHTML = html;
    }

    function showModalInovasi() {
        const modalEl = document.getElementById('modal-form-inovasi');
        if (!modalEl) return;
        document.getElementById('modal-alert-box').classList.add('d-none');
        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }

    function hideModalInovasi() {
        const modalEl = document.getElementById('modal-form-inovasi');
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        } else if (window.jQuery) {
            $(modalEl).modal('hide');
        }
    }

    function showModalDelete(id, nama) {
        document.getElementById('delete-target-id').value = id;
        document.getElementById('delete-item-title').innerText = `"${nama}"`;
        const modalEl = document.getElementById('modal-confirm-delete');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }

    function hideModalDelete() {
        const modalEl = document.getElementById('modal-confirm-delete');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        } else if (window.jQuery) {
            $(modalEl).modal('hide');
        }
    }

    function setPreviewBox(num, src) {
        const img = document.getElementById(`img-preview-${num}`);
        const text = document.getElementById(`text-preview-${num}`);
        if (src) {
            img.src = src;
            img.classList.remove('d-none');
            text.classList.add('d-none');
        } else {
            img.src = '';
            img.classList.add('d-none');
            text.classList.remove('d-none');
        }
    }

    function setPreviewPdf(name, sizeStr) {
        const box = document.getElementById('pdf-preview-box');
        const nameEl = document.getElementById('pdf-preview-name');
        const sizeEl = document.getElementById('pdf-preview-size');
        const label = document.getElementById('label-dokumen-pdf');

        if (name) {
            nameEl.innerText = name;
            sizeEl.innerText = sizeStr ? `(${sizeStr})` : '';
            box.classList.remove('d-none');
            label.innerText = name;
        } else {
            nameEl.innerText = '';
            sizeEl.innerText = '';
            box.classList.add('d-none');
            label.innerText = 'Belum ada PDF dipilih';
        }
    }

    function openModalTambah() {
        document.getElementById('form-submit-inovasi').reset();
        document.getElementById('entry-index-id').value = '-1';
        document.getElementById('modal-form-title').innerText = 'Tambah Data Inovasi';
        document.getElementById('label-foto-1').innerText = 'Belum ada foto';
        document.getElementById('label-foto-2').innerText = 'Belum ada foto';
        document.getElementById('form-input-tanggal').value = new Date().toISOString().split('T')[0];
        currentFoto1 = '';
        currentFoto2 = '';
        currentPdfUrl = '';
        currentPdfName = '';
        setPreviewBox(1, '');
        setPreviewBox(2, '');
        setPreviewPdf('', '');
        showModalInovasi();
    }

    function openModalEdit(id) {
        const item = inovasiData.find(d => d.id == id);
        if (!item) return;

        document.getElementById('entry-index-id').value = item.id;
        document.getElementById('modal-form-title').innerText = 'Edit Data Inovasi';
        document.getElementById('form-input-tanggal').value = toInputDateFormat(item.tanggal);
        document.getElementById('form-input-pokja').value = item.pokja || 'POKJA 3';
        document.getElementById('form-input-kecamatan').value = item.id_kec || item.kecamatan;
        document.getElementById('form-input-dibuat').value = item.dibuatOleh;
        document.getElementById('form-input-nama').value = item.nama;
        document.getElementById('form-input-deskripsi').value = item.deskripsi;
        
        currentFoto1 = item.foto1 || '';
        currentFoto2 = item.foto2 || '';
        setPreviewBox(1, currentFoto1);
        setPreviewBox(2, currentFoto2);
        document.getElementById('label-foto-1').innerText = currentFoto1 ? 'Foto 1 tersimpan' : 'Belum ada foto';
        document.getElementById('label-foto-2').innerText = currentFoto2 ? 'Foto 2 tersimpan' : 'Belum ada foto';

        currentPdfUrl = item.pdfUrl || '';
        currentPdfName = item.file || '';
        if (currentPdfName) {
            setPreviewPdf(currentPdfName, 'Tersimpan');
        } else {
            setPreviewPdf('', '');
        }

        showModalInovasi();
    }

    function switchTab(tab) {
        const viewDash = document.getElementById('view-inovasi-dashboard');
        const viewInp = document.getElementById('view-inovasi-input');
        const btnDash = document.getElementById('btn-tab-dashboard');
        const btnInp = document.getElementById('btn-tab-input');

        if (!viewDash || !viewInp) return;

        if (tab === 'dashboard') {
            viewDash.style.setProperty('display', 'flex', 'important');
            viewInp.style.setProperty('display', 'none', 'important');
            btnDash?.classList.add('active');
            btnInp?.classList.remove('active');
            updateDashboardCounters();
        } else {
            viewDash.style.setProperty('display', 'none', 'important');
            viewInp.style.setProperty('display', 'flex', 'important');
            btnInp?.classList.add('active');
            btnDash?.classList.remove('active');
            renderCustomTable(true);
        }
    }

    function handleSimpanInovasi() {
        const alertBox = document.getElementById('modal-alert-box');
        const alertMsg = document.getElementById('modal-alert-msg');
        alertBox.classList.add('d-none');

        const formElement = document.getElementById('form-submit-inovasi');
        const formData = new FormData(formElement);

        const btnSubmit = document.getElementById('btn-submit-modal');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';

        const storeUrl = "{{ route('inovasi.global.store') ?? url('/inovasi/global/store') }}";

        fetch(storeUrl, {
            method: 'POST',
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.json())
        .then(res => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Simpan Inovasi';

            if (res.status === 'success') {
                notifyToast(res.message || 'Data inovasi berhasil disimpan!');
                hideModalInovasi();
                fetchDataFromServer();
            } else {
                alertMsg.innerText = res.message || 'Terjadi kesalahan saat menyimpan data.';
                alertBox.classList.remove('d-none');
            }
        })
        .catch(err => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Simpan Inovasi';
            alertMsg.innerText = 'Gagal terhubung ke server database.';
            alertBox.classList.remove('d-none');
        });
    }

    function handleHapusInovasi() {
    const id = document.getElementById('delete-target-id').value;
    const btnDelete = document.getElementById('btn-execute-delete');

    if (!id || id === '-1') return;

    btnDelete.disabled = true;
    btnDelete.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menghapus...';

    const baseDeleteRoute = "{{ route('inovasi.global.destroy', ['id' => ':id']) }}";
    const deleteUrl = baseDeleteRoute.replace(':id', id);

    fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP status ${res.status}`);
        }
        return res.json();
    })
    .then(res => {
        btnDelete.disabled = false;
        btnDelete.innerHTML = '<i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus';
        hideModalDelete();

        if (res.status === 'success') {
            notifyToast(res.message || 'Data berhasil dihapus.');
            fetchDataFromServer();
        } else {
            notifyToast(res.message || 'Gagal menghapus data.', false);
        }
    })
    .catch(err => {
        btnDelete.disabled = false;
        btnDelete.innerHTML = '<i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus';
        hideModalDelete();
        console.error('Error delete:', err);
        notifyToast('Terjadi kesalahan atau rute hapus tidak ditemukan (404).', false);
    });
}
    document.addEventListener('click', function (e) {
        if (e.target.closest('#btn-tab-dashboard')) {
            e.preventDefault();
            switchTab('dashboard');
        } else if (e.target.closest('#btn-tab-input')) {
            e.preventDefault();
            switchTab('input');
        } else if (e.target.closest('#btn-tambah-data-modal')) {
            e.preventDefault();
            openModalTambah();
        } else if (e.target.closest('#btn-close-modal') || e.target.closest('#btn-batal-modal')) {
            e.preventDefault();
            hideModalInovasi();
        } else if (e.target.closest('#btn-submit-modal')) {
            e.preventDefault();
            handleSimpanInovasi();
        } else if (e.target.closest('#btn-pilih-foto-1')) {
            e.preventDefault();
            document.getElementById('file-foto-1').click();
        } else if (e.target.closest('#btn-pilih-foto-2')) {
            e.preventDefault();
            document.getElementById('file-foto-2').click();
        } else if (e.target.closest('#btn-pilih-dokumen')) {
            e.preventDefault();
            document.getElementById('file-dokumen-pdf').click();
        } else if (e.target.closest('#btn-remove-pdf')) {
            e.preventDefault();
            document.getElementById('file-dokumen-pdf').value = '';
            currentPdfUrl = '';
            currentPdfName = '';
            setPreviewPdf('', '');
        } else if (e.target.closest('.btn-edit-item')) {
            e.preventDefault();
            openModalEdit(e.target.closest('.btn-edit-item').getAttribute('data-id'));
        } else if (e.target.closest('.btn-delete-item')) {
            e.preventDefault();
            const id = e.target.closest('.btn-delete-item').getAttribute('data-id');
            const item = inovasiData.find(d => d.id == id);
            if (item) {
                showModalDelete(id, item.nama);
            }
        } else if (e.target.closest('#btn-cancel-delete')) {
            e.preventDefault();
            hideModalDelete();
        } else if (e.target.closest('#btn-execute-delete')) {
            e.preventDefault();
            handleHapusInovasi();
        } else if (e.target.closest('#table-pagination-list a[data-page]')) {
            e.preventDefault();
            const page = parseInt(e.target.closest('a[data-page]').getAttribute('data-page'));
            if (page && page !== currentPage) {
                currentPage = page;
                renderCustomTable();
            }
        }
    });

    document.addEventListener('change', function (e) {
        const allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (e.target.id === 'file-foto-1') {
            const file = e.target.files[0];
            if (file) {
                if (!allowedImageTypes.includes(file.type)) {
                    notifyToast('Format Foto 1 tidak sesuai! Gunakan JPG, PNG, atau WEBP.', false);
                    e.target.value = '';
                    setPreviewBox(1, '');
                    document.getElementById('label-foto-1').innerText = 'Belum ada foto';
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran Foto 1 melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewBox(1, '');
                    document.getElementById('label-foto-1').innerText = 'Belum ada foto';
                    return;
                }
                document.getElementById('label-foto-1').innerText = file.name;
                const reader = new FileReader();
                reader.onload = (evt) => setPreviewBox(1, evt.target.result);
                reader.readAsDataURL(file);
            }
        } 
        
        else if (e.target.id === 'file-foto-2') {
            const file = e.target.files[0];
            if (file) {
                if (!allowedImageTypes.includes(file.type)) {
                    notifyToast('Format Foto 2 tidak sesuai! Gunakan JPG, PNG, atau WEBP.', false);
                    e.target.value = '';
                    setPreviewBox(2, '');
                    document.getElementById('label-foto-2').innerText = 'Belum ada foto';
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran Foto 2 melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewBox(2, '');
                    document.getElementById('label-foto-2').innerText = 'Belum ada foto';
                    return;
                }
                document.getElementById('label-foto-2').innerText = file.name;
                const reader = new FileReader();
                reader.onload = (evt) => setPreviewBox(2, evt.target.result);
                reader.readAsDataURL(file);
            }
        } 
        
        else if (e.target.id === 'file-dokumen-pdf') {
            const file = e.target.files[0];
            if (file) {
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    notifyToast('Format berkas harus berupa dokumen .PDF!', false);
                    e.target.value = '';
                    setPreviewPdf('', '');
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran dokumen PDF melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewPdf('', '');
                    return;
                }
                const sizeKb = Math.round(file.size / 1024) + ' KB';
                currentPdfName = file.name;
                currentPdfUrl = URL.createObjectURL(file);
                setPreviewPdf(file.name, sizeKb);
            }
        }
            });

    document.addEventListener('input', function (e) {
        if (e.target.id === 'search-inovasi-input') {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                renderCustomTable(true);
            }, 250);
        }
    });

    document.addEventListener('keyup', function (e) {
        if (e.target.id === 'search-inovasi-input') {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                renderCustomTable(true);
            }, 250);
        }
    });

    fetchDataFromServer();
</script>
@endsection