@extends('bo.layout.app')

@section('content')
<style>
    #view-inovasi-dashboard, 
    #view-inovasi-input,
    #modal-form-inovasi {
        color: #111827 !important;
    }

    #view-inovasi-dashboard h2,
    #view-inovasi-dashboard h3,
    #view-inovasi-dashboard h5,
    #view-inovasi-input h3,
    .card-title h2 {
        color: #0f172a !important;
        font-weight: 800 !important;
    }

    #innovation-table-body td,
    #innovation-table-body td span,
    #innovation-table-body td div {
        color: #111827 !important;
        font-weight: 600 !important;
    }

    .table thead th {
        color: #0f172a !important;
        font-weight: 800 !important;
    }

    .form-label, 
    label,
    .form-select,
    .form-control {
        color: #111827 !important;
        font-weight: 600 !important;
    }

    .text-secondary,
    .text-muted,
    .small {
        color: #334155 !important;
    }

    /* Tab Switcher */
    .btn-tab-toggle {
        padding: 6px 18px;
        font-size: 0.825rem;
        font-weight: 700;
        border-radius: 8px;
        border: none;
        transition: all 0.2s;
    }
    .btn-tab-toggle.active {
        background-color: #00b159 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(0, 177, 89, 0.25);
    }
    .btn-tab-toggle:not(.active) {
        background-color: transparent;
        color: #0f172a !important;
    }

    /* Card Banner Nuansa Tosca Elegan Sesuai Gambar */
.banner-inovasi-tosca {
    background: linear-gradient(135deg, #0b5e57 0%, #0d6e66 50%, #084943 100%) !important;
    position: relative;
    overflow: hidden;
    border-radius: 1.25rem !important;
    border: none !important;
    box-shadow: 0 10px 25px -5px rgba(11, 94, 87, 0.35);
}

/* Pola Grid Titik-titik Halus (Dot Pattern) */
.banner-inovasi-tosca::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1.2px, transparent 1.2px);
    background-size: 22px 22px;
    pointer-events: none;
    z-index: 1;
}

/* Siluet Grafis Kota & Gedung di Sudut Kanan Bawah */
.banner-siluet-kanan {
    position: absolute;
    right: -10px;
    bottom: -5px;
    height: 100%;
    max-height: 160px;
    opacity: 0.35;
    pointer-events: none;
    z-index: 1;
}

/* Gaya Tombol Tab Kotak Rounded Sesuai Gambar */
.btn-tab-pill-tosca {
    min-width: 170px;
    padding: 10px 18px;
    border-radius: 1rem;
    transition: all 0.25s ease;
    cursor: pointer;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    text-decoration: none;
}

/* Tab Saat Aktif (Warna Putih Solid) */
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
    color: #4a6b67 !important;
}
.btn-tab-pill-tosca.active .tab-icon-sign {
    color: #0d6e66 !important;
}

/* Tab Saat Tidak Aktif (Kaca Transparan Tosca) */
.btn-tab-pill-tosca:not(.active) {
    background-color: rgba(255, 255, 255, 0.12) !important;
    border: 1px solid rgba(255, 255, 255, 0.22) !important;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
.btn-tab-pill-tosca:not(.active):hover {
    background-color: rgba(255, 255, 255, 0.18) !important;
}
.btn-tab-pill-tosca:not(.active) .tab-title-text {
    color: #ffffff !important;
    font-weight: 800 !important;
}
.btn-tab-pill-tosca:not(.active) .tab-sub-text {
    color: #bbf7d0 !important;
}
.btn-tab-pill-tosca:not(.active) .tab-icon-sign {
    color: rgba(255, 255, 255, 0.8) !important;
}
/* Tombol Tab saat Aktif & Tidak Aktif */
.btn-tab-tosca {
    padding: 7px 20px;
    font-size: 0.84rem;
    font-weight: 700;
    border-radius: 9px;
    border: none;
    transition: all 0.25s ease;
    cursor: pointer;
}

.btn-tab-tosca.active {
    background-color: #ffffff !important;
    color: #0f766e !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-tab-tosca:not(.active) {
    background-color: transparent;
    color: #e6fffa !important;
}

.btn-tab-tosca:not(.active):hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.12);
}

    /* Tombol Aksi Pill */
    .btn-action-edit {
        border: 1px solid #fde047 !important;
        background-color: #fefce8 !important;
        color: #854d0e !important;
        padding: 4px 14px;
        border-radius: 50rem;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-action-edit:hover {
        background-color: #fef08a !important;
        color: #713f12 !important;
    }
    .btn-action-delete {
        border: 1px solid #fecdd3 !important;
        background-color: #fff1f2 !important;
        color: #be123c !important;
        padding: 4px 14px;
        border-radius: 50rem;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-action-delete:hover {
        background-color: #ffe4e6 !important;
        color: #9f1239 !important;
    }

    .img-table-thumb {
        width: 50px;
        height: 38px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid #cbd5e1;
    }
    .badge-pokja-1 { background-color: #f3e8ff; color: #6b21a8 !important; border: 1px solid #d8b4fe; }
    .badge-pokja-2 { background-color: #eff6ff; color: #1e40af !important; border: 1px solid #93c5fd; }
    .badge-pokja-3 { background-color: #ecfdf5; color: #065f46 !important; border: 1px solid #6ee7b7; }
    .badge-pokja-4 { background-color: #f0f9ff; color: #075985 !important; border: 1px solid #7dd3fc; }
    .badge-sekretaris { background-color: #f0fdf4; color: #166534 !important; border: 1px solid #86efac; }
</style>

<div class="d-flex flex-column gap-4 w-100 p-2 p-md-3">

    <!-- 1. Header Card Inovasi Global dengan Switcher Tab -->
   <!-- Banner Header Inovasi Global Nuansa Tosca Sesuai Gambar -->
<div class="card banner-inovasi-tosca mb-4">
    
    <!-- Grafis Siluet Landmark Kota & Gunung di Pojok Kanan Bawah -->
    <svg class="banner-siluet-kanan" viewBox="0 0 450 160" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M280 160 L310 50 L315 50 L345 160 Z" fill="#2dd4bf" />
        <path d="M312 25 L314 25 L314 50 L312 50 Z" fill="#2dd4bf" />
        <path d="M340 160 L340 110 L355 110 L355 160 Z" fill="#14b8a6" />
        <path d="M358 160 L358 90 L378 90 L378 160 Z" fill="#0d9488" />
        <path d="M382 160 L382 120 L400 120 L400 160 Z" fill="#14b8a6" />
        <path d="M360 160 C390 120 420 100 460 90 L460 160 Z" fill="#0f766e" />
        <path d="M390 160 C410 135 435 115 460 110 L460 160 Z" fill="#115e59" />
    </svg>

    <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-4 position-relative" style="z-index: 2;">
        
        <!-- Judul & Subtitle Tetap Sesuai Aslinya -->
        <div>
            <h2 class="fw-bolder text-white mb-2 text-uppercase tracking-wide" style="font-size: 1.85rem; letter-spacing: 0.5px;">
                Inovasi Global
            </h2>
        </div>

        <!-- Tombol Pilihan Tab Sesuai Tampilan di Gambar -->
        <div class="d-flex flex-wrap gap-3">
            
            <!-- Tab Dashboard -->
            <button type="button" class="btn-tab-pill-tosca active" id="btn-tab-dashboard" onclick="switchInovasiTab('dashboard')">
                <div>
                    <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Dashboard</span>
                    <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Ringkasan & Distribusi</span>
                </div>
            </button>

            <!-- Tab Input Inovasi -->
            <button type="button" class="btn-tab-pill-tosca" id="btn-tab-input" onclick="switchInovasiTab('input')">
                <div>
                    <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Input Inovasi</span>
                    <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Input Inovasi</span>
                </div>
                </button>

        </div>

    </div>
</div>

    <!-- ========================================================= -->
    <!-- VIEW 1: TAB DASHBOARD (RINGKASAN & STATISTIK SAJA)        -->
    <!-- ========================================================= -->
    <div id="view-inovasi-dashboard" class="d-flex flex-column gap-4">
        
        <!-- Filter Ringkas Dashboard -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">Kecamatan</label>
                        <select class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option>Semua kecamatan</option>
                            <option>Gubeng</option>
                            <option>Wonokromo</option>
                            <option>Rungkut</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">Kelurahan</label>
                        <select class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option>Pilih kelurahan</option>
                            <option>Mojo</option>
                            <option>Darmo</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">Periode</label>
                        <select class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option selected>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5 Kartu Statistik Angka Polos -->
        <div class="row g-3">
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1">27</h2>
                        <span class="text-secondary small fw-semibold d-block mb-3">Sekretaris</span>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1">24</h2>
                        <span class="text-secondary small fw-semibold d-block mb-3">Pokja 1</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1">24</h2>
                        <span class="text-secondary small fw-semibold d-block mb-3">Pokja 2</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1">32</h2>
                        <span class="text-secondary small fw-semibold d-block mb-3">Pokja 3</span>
                        <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-xl">
                <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold text-dark mb-1">40</h2>
                        <span class="text-secondary small fw-semibold d-block mb-3">Pokja 4</span>
                        <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill small fw-bold">Inovasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Bar Distribusi Inovasi -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="fw-bold text-dark mb-0">Distribusi Inovasi per Pokja</h5>
                    <span class="badge bg-light text-secondary border px-3 py-2 fw-bold">Total: 147 Inovasi</span>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center">
                        <span class="text-secondary fw-bold small text-start" style="width: 100px;">Pokja 4</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" style="width: 30px;">40</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary fw-bold small text-start" style="width: 100px;">Pokja 3</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" style="width: 30px;">32</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary fw-bold small text-start" style="width: 100px;">Sekretaris</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 67%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" style="width: 30px;">27</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary fw-bold small text-start" style="width: 100px;">Pokja 1</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 60%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" style="width: 30px;">24</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary fw-bold small text-start" style="width: 100px;">Pokja 2</span>
                        <div class="progress flex-grow-1 mx-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 60%"></div>
                        </div>
                        <span class="text-dark fw-bold small text-end" style="width: 30px;">24</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================================= -->
    <!-- VIEW 2: TAB INPUT INOVASI (TABEL DATA & FORM)             -->
    <!-- ========================================================= -->
    <div id="view-inovasi-input" class="d-none d-flex flex-column gap-4">
        
        <!-- Filter Data Inovasi Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-filter text-success"></i>
                        <span class="text-dark fw-bold small text-uppercase tracking-wider">FILTER DATA INOVASI</span>
                    </div>
                    <button type="button" onclick="resetTableFilters()" class="btn btn-sm btn-link text-secondary text-decoration-none p-0 small fw-bold">
                        <i class="fa-solid fa-rotate-right me-1"></i> Reset Filter
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">KECAMATAN</label>
                        <select id="filter-tbl-kecamatan" onchange="renderInnovationTable()" class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option value="">SEMUA KECAMATAN</option>
                            <option value="Gubeng">Gubeng</option>
                            <option value="Wonokromo">Wonokromo</option>
                            <option value="Rungkut">Rungkut</option>
                            <option value="Tegalsari">Tegalsari</option>
                            <option value="Genteng">Genteng</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">KELURAHAN</label>
                        <select id="filter-tbl-kelurahan" onchange="renderInnovationTable()" class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option value="">Pilih Kelurahan</option>
                            <option value="Mojo">Mojo</option>
                            <option value="Darmo">Darmo</option>
                            <option value="Kali Rungkut">Kali Rungkut</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-1">PERIODE TAHUN</label>
                        <select id="filter-tbl-periode" onchange="renderInnovationTable()" class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                            <option value="">Semua Periode</option>
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Datatable Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <!-- Controls Row -->
                <div class="row g-3 align-items-center justify-content-between mb-4">
                    <div class="col-12 col-sm-auto d-flex align-items-center gap-2">
                        <span class="small fw-semibold text-secondary">Show</span>
                        <select id="entries-per-page" onchange="renderInnovationTable()" class="form-select form-select-sm w-auto bg-light border-light-subtle fw-bold">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="small fw-semibold text-secondary">entries</span>
                    </div>

                    <div class="col-12 col-sm-auto d-flex flex-column flex-sm-row gap-2 flex-grow-1 justify-content-sm-end">
                        <!-- Tombol Tambah Data (Ikon kecil dihapus, menyisakan teks '+ Tambah Data') -->
                        <button type="button" class="btn btn-sm btn-success px-4 py-2 fw-bold rounded-3 d-flex align-items-center justify-content-center shadow-sm text-nowrap" onclick="openModalInovasi()">
                            <span>+ Tambah Data</span>
                        </button>
                        
                        <div class="input-group input-group-sm" style="min-width: 220px; max-width: 100%;">
                            <span class="input-group-text bg-light border-light-subtle"><i class="fa-solid fa-magnifying-glass text-secondary"></i></span>
                            <input type="text" id="search-inovasi-input" onkeyup="renderInnovationTable()" class="form-control bg-light border-light-subtle small" placeholder="Search..." />
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.825rem;">
                        <thead class="table-light text-secondary text-uppercase fw-bold" style="font-size: 0.75rem;">
                            <tr>
                                <th class="text-center py-3" style="width: 50px;">NO</th>
                                <th class="py-3">TANGGAL ENTRY</th>
                                <th class="py-3" style="min-width: 180px;">NAMA INOVASI</th>
                                <th class="py-3" style="min-width: 220px;">DESKRIPSI INOVASI</th>
                                <th class="text-center py-3">FILE</th>
                                <th class="text-center py-3">FOTO INOVASI</th>
                                <th class="text-center py-3">PERIODE</th>
                                <th class="text-center py-3">KETERANGAN</th>
                                <th class="py-3">DIBUAT OLEH</th>
                                <th class="text-center py-3" style="min-width: 160px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="innovation-table-body" class="fw-medium text-dark">
                            <!-- Injected by JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-4 mt-2 border-top">
                    <span class="text-secondary small fw-semibold" id="table-info-label">
                        Menampilkan 1 - 5 dari 5 data
                    </span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item active"><a class="page-link bg-success border-success" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- ========================================================= -->
<!-- MODAL FORM TAMBAH / EDIT INOVASI                          -->
<!-- ========================================================= -->
<div class="modal fade" id="modal-form-inovasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 560px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            
            <div class="modal-header px-4 py-3 border-bottom bg-light">
                <h6 class="modal-title fw-bold text-dark" id="modal-form-title">Tambah Data Inovasi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-submit-inovasi" onsubmit="handleInovasiSubmit(event)">
                <input type="hidden" id="entry-index-id" value="-1">

                <div class="modal-body p-4 d-flex flex-column gap-3" style="font-size: 0.825rem;">
                    
                    <!-- Row: Tanggal Entry (Datepicker Manual) & Pokja -->
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark mb-1">Tanggal Entry <span class="text-danger">*</span></label>
                            <input type="date" id="form-input-tanggal" required class="form-control bg-light border-light-subtle rounded-3 small fw-bold text-dark cursor-pointer" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark mb-1">Pokja <span class="text-danger">*</span></label>
                            <select id="form-input-pokja" required class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                                <option value="">- Pilih Pokja -</option>
                                <option value="Sekretaris">Sekretaris</option>
                                <option value="POKJA 1">POKJA 1</option>
                                <option value="POKJA 2">POKJA 2</option>
                                <option value="POKJA 3" selected>POKJA 3</option>
                                <option value="POKJA 4">POKJA 4</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row: Nama Kecamatan & Dibuat Oleh (Input Isian Manual) -->
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark mb-1">Nama Kecamatan <span class="text-danger">*</span></label>
                            <select id="form-input-kecamatan" required class="form-select bg-light border-light-subtle rounded-3 small fw-semibold">
                                <option value="">- Pilih Kecamatan -</option>
                                <option value="Gubeng" selected>Gubeng</option>
                                <option value="Wonokromo">Wonokromo</option>
                                <option value="Rungkut">Rungkut</option>
                                <option value="Tegalsari">Tegalsari</option>
                                <option value="Genteng">Genteng</option>
                                <option value="Tambaksari">Tambaksari</option>
                                <option value="Sukolilo">Sukolilo</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-bold text-dark mb-1">Dibuat Oleh <span class="text-danger">*</span></label>
                            <input type="text" id="form-input-dibuat" required placeholder="Masukkan nama pembuat / kader" class="form-control bg-light border-light-subtle rounded-3 small fw-bold text-dark" />
                        </div>
                    </div>

                    <!-- Nama Inovasi -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">Nama Inovasi <span class="text-danger">*</span></label>
                        <input type="text" id="form-input-nama" required class="form-control bg-light border-light-subtle rounded-3 small" placeholder="Contoh: SARING (SAMPAH KERING)" />
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="form-input-deskripsi" rows="3" required class="form-control bg-light border-light-subtle rounded-3 small" placeholder="Tulis deskripsi ringkas inovasi..."></textarea>
                    </div>

                    <!-- Preview Foto 2 Slot -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">Preview Foto</label>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <div id="preview-slot-1" class="border border-2 border-dashed border-secondary-subtle rounded-3 d-flex align-items-center justify-center bg-light overflow-hidden" style="height: 95px;">
                                    <span class="text-secondary small">Preview Foto 1</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="preview-slot-2" class="border border-2 border-dashed border-secondary-subtle rounded-3 d-flex align-items-center justify-center bg-light overflow-hidden" style="height: 95px;">
                                    <span class="text-secondary small">Preview Foto 2</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Foto 1 -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">Foto 1</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="file-foto-1" accept="image/*" class="d-none" onchange="previewUploadImage(this, 1)">
                            <button type="button" onclick="document.getElementById('file-foto-1').click()" class="btn btn-sm btn-light border fw-bold small">Choose File</button>
                            <span id="label-foto-1" class="text-secondary small text-truncate">No file chosen</span>
                        </div>
                        <span class="text-danger fw-semibold d-block mt-1" style="font-size: 0.7rem;">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                    </div>

                    <!-- Upload Foto 2 -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">Foto 2</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="file-foto-2" accept="image/*" class="d-none" onchange="previewUploadImage(this, 2)">
                            <button type="button" onclick="document.getElementById('file-foto-2').click()" class="btn btn-sm btn-light border fw-bold small">Choose File</button>
                            <span id="label-foto-2" class="text-secondary small text-truncate">No file chosen</span>
                        </div>
                        <span class="text-danger fw-semibold d-block mt-1" style="font-size: 0.7rem;">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                    </div>

                    <!-- Upload File Inovasi -->
                    <div>
                        <label class="form-label fw-bold text-dark mb-1">File Inovasi (Proposal / Juknis)</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="file-dokumen" accept=".pdf,.doc,.docx" class="d-none" onchange="document.getElementById('label-dokumen').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                            <button type="button" onclick="document.getElementById('file-dokumen').click()" class="btn btn-sm btn-light border fw-bold small">Choose File</button>
                            <span id="label-dokumen" class="text-secondary small text-truncate">No file chosen</span>
                        </div>
                        <span class="text-danger fw-semibold d-block mt-1" style="font-size: 0.7rem;">File harus di bawah 2MB dan berformat pdf, png atau jpeg.</span>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 bg-light border-top">
                    <button type="button" class="btn btn-sm btn-light-danger text-danger bg-danger-subtle border-0 fw-bold px-3 py-2 rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-success fw-bold px-4 py-2 rounded-3 shadow-sm" id="btn-save-inovasi">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL LIGHTBOX FOTO -->
<div class="modal fade" id="modal-lightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
            <div class="modal-header py-2 px-3 bg-light border-bottom">
                <h6 class="modal-title fw-bold small text-dark" id="lightbox-caption">Foto Inovasi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <img id="lightbox-img-source" src="" class="img-fluid w-100" style="max-height: 420px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
    // 1. BUAT DEFAULT DATA KOSONG (tidak ada data apa-apa saat awal dibuka)
    let inovasiData = [];

    let currentFoto1 = '';
    let currentFoto2 = '';

    // 2. Helper format tanggal
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
        if (parts.length === 3 && parts[2].length === 4) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    // 3. Switch Tab Dashboard vs Input Inovasi
    function switchInovasiTab(type) {
    const viewDash = document.getElementById('view-inovasi-dashboard');
    const viewInp = document.getElementById('view-inovasi-input');
    const btnDash = document.getElementById('btn-tab-dashboard');
    const btnInp = document.getElementById('btn-tab-input');

    if (!viewDash || !viewInp) return;

    if (type === 'dashboard') {
        viewDash.classList.remove('d-none');
        viewInp.classList.add('d-none');
        if (btnDash) btnDash.classList.add('active');
        if (btnInp) btnInp.classList.remove('active');
    } else {
        viewDash.classList.add('d-none');
        viewInp.classList.remove('d-none');
        if (btnDash) btnDash.classList.remove('active');
        if (btnInp) btnInp.classList.add('active');
        renderInnovationTable();
    }
}

    // 4. Render Tabel Otomatis
    function renderInnovationTable() {
        const tbody = document.getElementById('innovation-table-body');
        if (!tbody) return;

        const q = (document.getElementById('search-inovasi-input')?.value || '').toLowerCase();
        const kec = document.getElementById('filter-tbl-kecamatan')?.value || '';
        const periode = document.getElementById('filter-tbl-periode')?.value || '';
        const limit = parseInt(document.getElementById('entries-per-page')?.value || '10');

        const filtered = inovasiData.filter(item => {
            const matchQ = (item.nama || '').toLowerCase().includes(q) || 
                           (item.deskripsi || '').toLowerCase().includes(q) || 
                           (item.dibuatOleh || '').toLowerCase().includes(q);
            const matchKec = !kec || (item.kecamatan || '').toLowerCase().includes(kec.toLowerCase());
            const matchPeriode = !periode || item.periode === periode;
            return matchQ && matchKec && matchPeriode;
        });

        tbody.innerHTML = '';

        // TAMPILAN JIKA MASIH KOSONG
        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                            <span class="text-dark fw-bold fs-6">Belum ada data inovasi</span>
                            <span class="text-secondary small">Klik tombol <strong>+ Tambah Data</strong> untuk memasukkan data baru.</span>
                        </div>
                    </td>
                </tr>`;
            const infoEl = document.getElementById('table-info-label');
            if (infoEl) infoEl.innerText = 'Menampilkan 0 data';
            return;
        }

        // TAMPILAN KETIKA SUDAH ADA DATA YANG DI-INPUT
        filtered.slice(0, limit).forEach((item, index) => {
            let badgeClass = 'badge-pokja-3';
            if (item.keterangan.includes('1')) badgeClass = 'badge-pokja-1';
            if (item.keterangan.includes('2')) badgeClass = 'badge-pokja-2';
            if (item.keterangan.includes('4')) badgeClass = 'badge-pokja-4';
            if (item.keterangan === 'Sekretaris') badgeClass = 'badge-sekretaris';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center fw-bold text-secondary">${index + 1}</td>
                <td class="text-nowrap text-dark fw-bold">${item.tanggal}</td>
                <td>
                    <span class="text-dark fw-bold d-block">${item.nama}</span>
                    <span class="text-secondary small">Kec. ${item.kecamatan}</span>
                </td>
                <td class="text-secondary small" style="max-width: 250px;">${item.deskripsi}</td>
                <td class="text-center text-nowrap">
                    <button type="button" onclick="alert('Mengunduh file: ${item.file}')" class="btn btn-sm btn-outline-danger py-1 px-2 fw-semibold" style="font-size: 0.75rem;">
                        📄 ${(item.file || '').replace('.pdf', '')}
                    </button>
                </td>
                <td class="text-center">
                    <img src="${item.foto}" class="img-table-thumb shadow-sm" alt="Foto Inovasi" onclick="openLightbox('${item.foto}', '${item.nama}')">
                </td>
                <td class="text-center fw-bold text-dark">${item.periode}</td>
                <td class="text-center text-nowrap">
                    <span class="badge ${badgeClass} px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.72rem;">${item.keterangan}</span>
                </td>
                <td class="text-nowrap text-dark fw-bold small">${item.dibuatOleh}</td>
                <td class="text-center text-nowrap">
                    <div class="d-inline-flex gap-2">
                        <button type="button" onclick="editInovasi(${index})" class="btn-action-edit">
                            ✏ Edit
                        </button>
                        <button type="button" onclick="deleteInovasi(${index})" class="btn-action-delete">
                            🗑 Hapus
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        const infoEl = document.getElementById('table-info-label');
        if (infoEl) {
            infoEl.innerText = `Menampilkan 1 - ${Math.min(filtered.length, limit)} dari ${filtered.length} data`;
        }
    }

    function resetTableFilters() {
        const fKec = document.getElementById('filter-tbl-kecamatan');
        const fKel = document.getElementById('filter-tbl-kelurahan');
        const fPer = document.getElementById('filter-tbl-periode');
        const fSearch = document.getElementById('search-inovasi-input');

        if (fKec) fKec.value = '';
        if (fKel) fKel.value = '';
        if (fPer) fPer.value = '2026';
        if (fSearch) fSearch.value = '';
        renderInnovationTable();
    }

    // 5. Buka Modal Tambah Data / Edit
    function openModalInovasi(editIdx = -1) {
        const modalEl = document.getElementById('modal-form-inovasi');
        if (!modalEl) return;

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        document.getElementById('entry-index-id').value = editIdx;

        if (editIdx >= 0) {
            document.getElementById('modal-form-title').innerText = 'Edit Data Inovasi';
            const item = inovasiData[editIdx];
            document.getElementById('form-input-tanggal').value = toInputDateFormat(item.tanggal);
            document.getElementById('form-input-pokja').value = item.keterangan;
            document.getElementById('form-input-kecamatan').value = item.kecamatan;
            document.getElementById('form-input-dibuat').value = item.dibuatOleh;
            document.getElementById('form-input-nama').value = item.nama;
            document.getElementById('form-input-deskripsi').value = item.deskripsi;
            
            document.getElementById('preview-slot-1').innerHTML = `<img src="${item.foto}" class="w-100 h-100 object-fit-cover rounded-2">`;
            document.getElementById('preview-slot-2').innerHTML = `<span class="text-secondary small">Preview Foto 2</span>`;
            document.getElementById('label-foto-1').innerText = 'foto-terlampir.jpg';
            document.getElementById('label-dokumen').innerText = item.file;
        } else {
            document.getElementById('modal-form-title').innerText = 'Tambah Data Inovasi';
            document.getElementById('form-submit-inovasi').reset();
            document.getElementById('form-input-tanggal').value = '';
            document.getElementById('form-input-dibuat').value = '';
            document.getElementById('preview-slot-1').innerHTML = `<span class="text-secondary small">Preview Foto 1</span>`;
            document.getElementById('preview-slot-2').innerHTML = `<span class="text-secondary small">Preview Foto 2</span>`;
            document.getElementById('label-foto-1').innerText = 'No file chosen';
            document.getElementById('label-foto-2').innerText = 'No file chosen';
            document.getElementById('label-dokumen').innerText = 'No file chosen';
        }

        modal.show();
    }

    function previewUploadImage(input, slot) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById(`label-foto-${slot}`).innerText = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                if (slot === 1) currentFoto1 = e.target.result;
                if (slot === 2) currentFoto2 = e.target.result;
                document.getElementById(`preview-slot-${slot}`).innerHTML = `<img src="${e.target.result}" class="w-100 h-100 object-fit-cover rounded-2">`;
            }
            reader.readAsDataURL(file);
        }
    }

    // 6. PROSES SIMPAN: Data baru langsung otomatis muncul di tabel
    function handleInovasiSubmit(e) {
        e.preventDefault();
        const editIdx = parseInt(document.getElementById('entry-index-id').value);
        const rawTanggal = document.getElementById('form-input-tanggal').value;
        const tanggal = toDisplayDateFormat(rawTanggal);
        const pokja = document.getElementById('form-input-pokja').value;
        const kecamatan = document.getElementById('form-input-kecamatan').value;
        const dibuatOleh = document.getElementById('form-input-dibuat').value.trim();
        const nama = document.getElementById('form-input-nama').value.trim();
        const deskripsi = document.getElementById('form-input-deskripsi').value.trim();

        const docInput = document.getElementById('file-dokumen');
        const fileName = docInput.files[0] ? docInput.files[0].name : (editIdx >= 0 ? inovasiData[editIdx].file : 'proposal-inovasi.pdf');
        const fotoFinal = currentFoto1 || (editIdx >= 0 ? inovasiData[editIdx].foto : 'https://placehold.co/100x80/e2e8f0/475569?text=Foto');

        if (editIdx >= 0) {
            inovasiData[editIdx].tanggal = tanggal;
            inovasiData[editIdx].keterangan = pokja;
            inovasiData[editIdx].kecamatan = kecamatan;
            inovasiData[editIdx].dibuatOleh = dibuatOleh;
            inovasiData[editIdx].nama = nama;
            inovasiData[editIdx].deskripsi = deskripsi;
            inovasiData[editIdx].file = fileName;
            inovasiData[editIdx].foto = fotoFinal;
        } else {
            // Memasukkan data baru ke baris pertama tabel
            inovasiData.unshift({
                id: Date.now(),
                tanggal: tanggal,
                nama: nama,
                kecamatan: kecamatan,
                deskripsi: deskripsi,
                file: fileName,
                foto: fotoFinal,
                periode: '2026',
                keterangan: pokja,
                dibuatOleh: dibuatOleh
            });
        }

        // Tutup modal popup
        const modalEl = document.getElementById('modal-form-inovasi');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        // Render ulang: baris baru langsung tampil di tabel!
        renderInnovationTable();

        currentFoto1 = '';
        currentFoto2 = '';
    }

    function editInovasi(index) {
        openModalInovasi(index);
    }

    function deleteInovasi(index) {
        if (confirm(`Yakin ingin menghapus inovasi "${inovasiData[index].nama}"?`)) {
            inovasiData.splice(index, 1);
            renderInnovationTable();
        }
    }

    function openLightbox(src, title) {
        const img = document.getElementById('lightbox-img-source');
        const cap = document.getElementById('lightbox-caption');
        if (img) img.src = src;
        if (cap) cap.innerText = title;
        
        const modalEl = document.getElementById('modal-lightbox');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderInnovationTable();
    });
</script>
@endsection