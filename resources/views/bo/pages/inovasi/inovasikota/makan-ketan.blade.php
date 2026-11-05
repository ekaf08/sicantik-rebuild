{{--
    Makan Ketan — Pemanfaatan Pekarangan untuk Ketahanan Pangan
    Dipanggil dari index.blade.php lewat @includeIf('bo.pages.inovasi.inovasikota.makan-ketan')

    Tambah/Edit/Hapus sudah TERSAMBUNG ke database (tabel makan_ketan), termasuk upload foto.
    Supaya ini jalan, pastikan sudah:
    1. Migration tabel makan_ketan sudah dijalankan (php artisan migrate)
    2. Model MakanKetan ada di app/Models/
    3. MakanKetanController ada di app/Http/Controllers/
    4. Route /makan-ketan sudah ditambahkan di routes/web.php
    5. Storage link sudah dibuat (php artisan storage:link) -- WAJIB biar foto bisa tampil
--}}

<style>
    .mk-photo-box {
        border: 1px solid #e4e6ef;
        border-radius: .75rem;
        background: #f8f9fb;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .mk-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .mk-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 2000;
        background: #fff;
        border-radius: .85rem;
        box-shadow: 0 16px 40px -12px rgba(0,0,0,.25);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .75rem;
        min-width: 280px;
        transform: translateX(120%);
        transition: transform .25s ease;
    }
    /* Teks tabel hitam: judul kolom tetap tebal, isi tabel tetap tipis */
    #mk-table thead th { color: #000 !important; }
    #mk-table tbody td { color: #000 !important; }
    .mk-toast.show { transform: translateX(0); }
    /* Kartu data per tahun: hijau pastel senada banner, mengambang, terangkat saat disentuh */
    .card.mk-card-tahun {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: #e3f2d3;
        border: 1px solid #cde4b8;
        border-radius: 1rem;
        box-shadow: 0 1px 2px rgba(44, 74, 30, .06), 0 10px 24px -10px rgba(44, 74, 30, .28);
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
    }
    /* Lingkaran dekor lembut di sudut kanan, seperti pada banner */
    .card.mk-card-tahun::before {
        content: "";
        position: absolute;
        right: -34px; top: -34px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: #d0e7ba;
        opacity: .8;
        transition: background-color .2s ease;
        pointer-events: none;
    }
    .card.mk-card-tahun .card-body { position: relative; z-index: 1; }
    .card.mk-card-tahun:hover {
        transform: translateY(-3px);
        box-shadow: 0 2px 4px rgba(44, 74, 30, .08), 0 18px 32px -12px rgba(44, 74, 30, .36);
    }
    .card.mk-card-aktif {
        background: #cfe6b5;
        border-color: #5fa03a;
        transform: translateY(-3px);
        box-shadow: 0 2px 4px rgba(44, 74, 30, .08), 0 18px 32px -12px rgba(44, 74, 30, .4) !important;
    }
    .card.mk-card-aktif::before { background: #bddb9f; }
    .mk-kartu-label { font-size: .85rem; font-weight: 600; color: #4f6b3c; }
    .mk-kartu-angka { font-size: 2.1rem; font-weight: 700; line-height: 1.1; color: #2c4a1e; margin-top: .5rem; }
    .mk-kartu-ket { font-size: .78rem; color: #5b7a45; margin-top: .15rem; }
    .mk-ikon {
        width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
        background: #fff; color: #3b6d11;
        display: flex; align-items: center; justify-content: center;
    }
    .mk-ikon i { color: #3b6d11; }
    .mk-card-aktif .mk-kartu-label, .mk-card-aktif .mk-kartu-ket { color: #2f5a0d; }
    .mk-card-aktif .mk-kartu-angka { color: #1f3a12; }
    .mk-card-aktif .mk-kartu-ket::after { content: " \00b7  dipilih"; }
    .btn.mk-btn-hijau { background-color: #3b6d11; color: #fff; border: 0; }
    .btn.mk-btn-hijau:hover, .btn.mk-btn-hijau:focus { background-color: #2f5a0d; color: #fff; }
    .btn.mk-btn-hijau i { color: #fff; }
    .mk-toast-icon {
        width: 34px; height: 34px; border-radius: 50%;
        background: #22c55e; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .mk-toast-icon i { color: #fff; font-size: 1.1rem; }
</style>

<input type="hidden" id="mk-csrf-token" value="{{ csrf_token() }}">

<div id="mk-toast" class="mk-toast">
    <div class="mk-toast-icon"><i class="ki-outline ki-check fs-3"></i></div>
    <p class="fw-bold mb-0" id="mk-toast-text">Data berhasil ditambahkan</p>
</div>

<!-- 0. Banner atas Makan Ketan: otomatis naik menggantikan banner hijau "Inovasi Kota" saat submenu ini dipilih -->
<style>
    .mk-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        min-height: 210px;
        padding: 2rem 2.5rem;
        margin-bottom: .5rem;
        border-radius: 1rem;
        background: #ebf3e3;
        box-shadow: 0 6px 18px -8px rgba(47, 74, 34, .25);
    }
    .mk-hero-text {
        position: relative;
        z-index: 2;
        max-width: 52%;
    }
    .mk-hero-label {
        display: block;
        margin-bottom: .5rem;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #6e9a4a;
    }
    .mk-hero-title {
        margin: 0 0 .4rem;
        font-size: 2.1rem;
        font-weight: 800;
        line-height: 1.15;
        color: #2c4a1e;
    }
    .mk-hero-sub {
        margin: 0;
        font-size: .95rem;
        font-weight: 500;
        color: #4f6b3c;
    }
    .mk-hero-art {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 100%;
        width: auto;
        max-width: 55%;
        z-index: 1;
        pointer-events: none;
    }
    @media (max-width: 767.98px) {
        .mk-hero { padding: 1.5rem; min-height: 170px; }
        .mk-hero-title { font-size: 1.6rem; }
        .mk-hero-text { max-width: 100%; }
        .mk-hero-art { opacity: .35; max-width: 75%; }
    }
</style>

<div id="mk-top-banner" class="mk-hero sub-banner-top d-none">
    <div class="mk-hero-text">
        <span class="mk-hero-label">Inovasi Kota</span>
        <h2 class="mk-hero-title">Makan Ketan</h2>
        <p class="mk-hero-sub">Pemanfaatan Pekarangan untuk Ketahanan Pangan</p>
    </div>

    <svg class="mk-hero-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
        <!-- latar: bukit lembut + lingkaran dekor -->
        <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#dbe8cf"/>
        <circle cx="318" cy="22" r="46" fill="#d3e3c4" opacity=".6"/>
        <circle cx="46" cy="176" r="14" fill="#d3e3c4"/>

        <!-- matahari -->
        <circle cx="96" cy="44" r="17" fill="#f2c14e"/>
        <g stroke="#f2c14e" stroke-width="3" stroke-linecap="round">
            <line x1="96" y1="16" x2="96" y2="22"/><line x1="96" y1="66" x2="96" y2="72"/>
            <line x1="68" y1="44" x2="74" y2="44"/><line x1="118" y1="44" x2="124" y2="44"/>
            <line x1="76" y1="24" x2="80" y2="28"/><line x1="112" y1="60" x2="116" y2="64"/>
            <line x1="116" y1="24" x2="112" y2="28"/><line x1="80" y1="60" x2="76" y2="64"/>
        </g>

        <!-- bayangan tanah -->
        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#b9cfa5" opacity=".55"/>

        <!-- pot 1: cabai -->
        <path d="M72 162 L108 162 L102 190 L78 190 Z" fill="#c9703f"/>
        <rect x="70" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
        <line x1="90" y1="158" x2="90" y2="104" stroke="#5a8a3c" stroke-width="4" stroke-linecap="round"/>
        <ellipse cx="78" cy="122" rx="13" ry="6" transform="rotate(-30 78 122)" fill="#6fa047"/>
        <ellipse cx="102" cy="116" rx="13" ry="6" transform="rotate(30 102 116)" fill="#6fa047"/>
        <ellipse cx="80" cy="142" rx="13" ry="6" transform="rotate(-25 80 142)" fill="#5a8a3c"/>
        <ellipse cx="101" cy="138" rx="13" ry="6" transform="rotate(25 101 138)" fill="#5a8a3c"/>
        <ellipse cx="72" cy="136" rx="4" ry="10" transform="rotate(12 72 136)" fill="#d9452f"/>
        <ellipse cx="110" cy="130" rx="4" ry="10" transform="rotate(-12 110 130)" fill="#d9452f"/>
        <ellipse cx="90" cy="108" rx="4" ry="9" fill="#d9452f"/>

        <!-- pot 2: terong -->
        <path d="M132 162 L168 162 L162 190 L138 190 Z" fill="#c9703f"/>
        <rect x="130" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
        <line x1="150" y1="158" x2="150" y2="108" stroke="#5a8a3c" stroke-width="4" stroke-linecap="round"/>
        <ellipse cx="136" cy="124" rx="14" ry="6" transform="rotate(-30 136 124)" fill="#6fa047"/>
        <ellipse cx="164" cy="118" rx="14" ry="6" transform="rotate(30 164 118)" fill="#6fa047"/>
        <ellipse cx="138" cy="144" rx="14" ry="6" transform="rotate(-25 138 144)" fill="#5a8a3c"/>
        <ellipse cx="162" cy="140" rx="14" ry="6" transform="rotate(25 162 140)" fill="#5a8a3c"/>
        <ellipse cx="141" cy="134" rx="6" ry="11" fill="#7b4a9e"/>
        <ellipse cx="160" cy="130" rx="6" ry="11" fill="#7b4a9e"/>

        <!-- pot 3: sawi / kangkung -->
        <path d="M192 162 L228 162 L222 190 L198 190 Z" fill="#c9703f"/>
        <rect x="190" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
        <ellipse cx="200" cy="144" rx="6" ry="17" transform="rotate(-28 200 144)" fill="#5a8a3c"/>
        <ellipse cx="220" cy="144" rx="6" ry="17" transform="rotate(28 220 144)" fill="#5a8a3c"/>
        <ellipse cx="210" cy="140" rx="7" ry="19" fill="#7fb356"/>
        <ellipse cx="205" cy="150" rx="5" ry="13" transform="rotate(-12 205 150)" fill="#6fa047"/>
        <ellipse cx="215" cy="150" rx="5" ry="13" transform="rotate(12 215 150)" fill="#6fa047"/>

        <!-- ibu: kaki, badan, kepala -->
        <rect x="322" y="162" width="8" height="26" rx="3" fill="#d99a73"/>
        <rect x="336" y="162" width="8" height="26" rx="3" fill="#d99a73"/>
        <ellipse cx="326" cy="189" rx="7" ry="3" fill="#3b2a22"/>
        <ellipse cx="340" cy="189" rx="7" ry="3" fill="#3b2a22"/>
        <path d="M313 100 L353 100 L364 166 L302 166 Z" fill="#6b8f4e"/>
        <path d="M313 100 L353 100 L356 128 L310 128 Z" fill="#f2a65a"/>
        <circle cx="333" cy="82" r="15" fill="#f1c9a0"/>
        <path d="M318 80 C318 64 348 64 348 80 C342 72 324 72 318 80 Z" fill="#3b2a22"/>
        <circle cx="333" cy="63" r="7" fill="#3b2a22"/>
        <!-- lengan menyiram + alat siram -->
        <line x1="316" y1="110" x2="282" y2="122" stroke="#f1c9a0" stroke-width="7" stroke-linecap="round"/>
        <rect x="258" y="116" width="26" height="19" rx="4" fill="#4f7fa8"/>
        <path d="M258 122 L238 108" stroke="#4f7fa8" stroke-width="5" stroke-linecap="round"/>
        <path d="M262 116 C262 106 280 106 280 116" stroke="#3d6485" stroke-width="3" fill="none"/>
        <g fill="#8cc7e8">
            <circle cx="234" cy="118" r="2.6"/><circle cx="231" cy="130" r="2.6"/>
            <circle cx="236" cy="140" r="2.6"/><circle cx="228" cy="124" r="2"/>
        </g>

        <!-- keranjang hasil panen -->
        <circle cx="388" cy="162" r="9" fill="#d9452f"/>
        <circle cx="404" cy="164" r="8" fill="#7fb356"/>
        <circle cx="396" cy="156" r="7" fill="#e9a23b"/>
        <path d="M374 168 L418 168 L412 192 L380 192 Z" fill="#c89b5e"/>
        <path d="M376 175 H416 M378 183 H414" stroke="#a97c42" stroke-width="2"/>

        <!-- tunas dekor -->
        <g stroke="#6fa047" stroke-width="2.5" stroke-linecap="round">
            <path d="M32 190 L32 168"/><path d="M32 178 L24 170"/><path d="M32 174 L40 166"/>
        </g>
    </svg>
</div>

<!-- 1. Banner Deskripsi Inovasi -->
<div class="card border-0 shadow-none mb-6" style="background-color: #f0f6ff; border-radius: 16px;">
    <div class="card-body p-6 p-lg-8">
        <h3 class="fw-bold text-gray-900 fs-3 mb-4">
            Inovasi Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan)
        </h3>
        <p class="text-gray-600 fs-6 lh-lg mb-4">
            Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan) merupakan inovasi yang mendorong pemanfaatan pekarangan rumah sebagai sumber ketahanan pangan keluarga. Melalui kegiatan urban farming, warga diajak menanam berbagai jenis tanaman pangan dan sayuran yang mudah dibudidayakan di lingkungan rumah.
        </p>
        <p class="text-gray-600 fs-6 lh-lg mb-0">
            Inovasi ini sejalan dengan program PKK, khususnya tema Aku Hatinya PKK, yang menekankan pentingnya pemanfaatan halaman rumah. Selain membantu memenuhi kebutuhan pangan keluarga, Makan Ketan juga meningkatkan kemandirian, menghemat pengeluaran, dan menumbuhkan kepedulian terhadap lingkungan.
        </p>
    </div>
</div>

<!-- 2. Judul bagian & Tombol Tambah Data -->
<div class="d-flex flex-stack mb-5">
    <div>
        <h3 class="fs-3 fw-bold text-gray-900 mb-1">Data per tahun</h3>
        <span class="text-gray-500 fs-7">Klik kartu untuk menyaring tabel di bawah</span>
    </div>
    <div>
        <button type="button" class="btn mk-btn-hijau fw-bold px-5" id="mk-btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_makan_ketan">
            <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Makan Ketan
        </button>
    </div>
</div>

<!-- 3. Kartu: Total Data per Tahun (angka dihitung otomatis dari data) -->
<div class="row g-4 mb-6">
    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 mk-card-tahun" id="mk-card-2024" onclick="mkFilterTahun('2024')">
            <div class="card-body p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="mk-kartu-label">Tahun 2024</span>
                    <span class="mk-ikon"><i class="ki-outline ki-calendar fs-2"></i></span>
                </div>
                <div class="mk-kartu-angka" id="mk-total-2024">0</div>
                <div class="mk-kartu-ket">data tercatat</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 mk-card-tahun" id="mk-card-2025" onclick="mkFilterTahun('2025')">
            <div class="card-body p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="mk-kartu-label">Tahun 2025</span>
                    <span class="mk-ikon"><i class="ki-outline ki-chart-line-up fs-2"></i></span>
                </div>
                <div class="mk-kartu-angka" id="mk-total-2025">0</div>
                <div class="mk-kartu-ket">data tercatat</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 mk-card-tahun" id="mk-card-2026" onclick="mkFilterTahun('2026')">
            <div class="card-body p-5">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="mk-kartu-label">Tahun 2026</span>
                    <span class="mk-ikon"><i class="ki-outline ki-verify fs-2"></i></span>
                </div>
                <div class="mk-kartu-angka" id="mk-total-2026">0</div>
                <div class="mk-kartu-ket">data tercatat</div>
            </div>
        </div>
    </div>
</div>

<!-- 4. Form Filter & Tabel Data -->
<div class="card card-flush shadow-sm">
    <div class="card-body pt-6">
        <div class="row g-3 mb-5">
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kecamatan</label>
                <select id="mk-filter-kecamatan" class="form-select form-select-solid">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
                <select id="mk-filter-kelurahan" class="form-select form-select-solid" disabled>
                    <option value="">Kelurahan</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label fs-7 fw-bold text-gray-700">Tahun</label>
                <select id="mk-filter-tahun" class="form-select form-select-solid">
                    <option value="">Semua</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-4" id="mk-table">
                <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>NO</th>
                        <th>KECAMATAN</th>
                        <th>KELURAHAN</th>
                        <th>NAMA DASAWISMA</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>JUMLAH RUMAH</th>
                        <th>TAHUN</th>
                        <th>FILE DOKUMENTASI</th>
                        <th>JUARA</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody id="mk-tbody" class="fw-semibold text-gray-600">
                    <tr><td colspan="11" class="text-center text-muted py-5">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH KEGIATAN -->
<div class="modal fade" id="modal_tambah_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Tambah Kegiatan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>

            <div class="modal-body py-6 px-8">
                <form id="mk-form-tambah" enctype="multipart/form-data">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid mk-kecamatan-select" id="mk-add-kecamatan" required></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid mk-kelurahan-select" id="mk-add-kelurahan" required disabled></select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA DASA WISMA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-add-nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUMLAH RUMAH <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control form-control-solid" id="mk-add-jumlah-rumah" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-add-rt" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-add-rw" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="mk-add-tahun" required>
                                <option value="">-- Pilih --</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUARA</label>
                            <input type="text" class="form-control form-control-solid" id="mk-add-juara" placeholder="Contoh: Juara 1">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-gray-700 mb-3">Preview Foto</label>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="mk-photo-box" style="height: 220px;" id="mk-add-preview-1">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mk-photo-box" style="height: 220px;" id="mk-add-preview-2">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-gray-700">Foto 1</label>
                            <input type="file" class="form-control form-control-solid mk-foto-input" id="mk-add-foto1" data-preview="mk-add-preview-1" accept="image/jpg, image/jpeg, image/png">
                            <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-gray-700">Foto 2</label>
                            <input type="file" class="form-control form-control-solid mk-foto-input" id="mk-add-foto2" data-preview="mk-add-preview-2" accept="image/jpg, image/jpeg, image/png">
                            <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-danger fw-bold px-6" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-3 me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success fw-bold px-6">
                            <i class="ki-outline ki-check fs-3 me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOTO SAJA (LINK "LIHAT FOTO") -->
<div class="modal fade" id="modal_foto_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4" id="mk-foto-title">Foto Dokumentasi</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <div class="row g-4">
                    <div class="col-6">
                        <div class="mk-photo-box" style="height: 320px;" id="mk-foto-1">
                            <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mk-photo-box" style="height: 320px;" id="mk-foto-2">
                            <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT INOVASI (TOMBOL PENSIL) -->
<div class="modal fade" id="modal_edit_makan_ketan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Edit Kegiatan Makan Ketan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <form id="mk-form-edit" enctype="multipart/form-data">
                    <input type="hidden" id="mk-edit-id">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid mk-kecamatan-select" id="mk-edit-kecamatan" required></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid mk-kelurahan-select" id="mk-edit-kelurahan" required></select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA DASA WISMA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-edit-nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUMLAH RUMAH <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control form-control-solid" id="mk-edit-jumlah-rumah" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-edit-rt" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RW <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="mk-edit-rw" required>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="mk-edit-tahun" required>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUARA</label>
                            <input type="text" class="form-control form-control-solid" id="mk-edit-juara">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-gray-700 mb-3">Preview / Ubah Foto</label>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="mk-photo-box" style="height: 180px;" id="mk-edit-preview-1">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                                <input type="file" class="form-control form-control-solid mt-2 mk-foto-input" id="mk-edit-foto1" data-preview="mk-edit-preview-1" accept="image/jpg, image/jpeg, image/png">
                                <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                            </div>
                            <div class="col-6">
                                <div class="mk-photo-box" style="height: 180px;" id="mk-edit-preview-2">
                                    <i class="ki-outline ki-picture fs-5x text-gray-300"></i>
                                </div>
                                <input type="file" class="form-control form-control-solid mt-2 mk-foto-input" id="mk-edit-foto2" data-preview="mk-edit-preview-2" accept="image/jpg, image/jpeg, image/png">
                                <span class="text-danger fs-9 mt-1 d-block">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold px-6">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    // ===================== Data Kecamatan -> Kelurahan (diambil dari database: tabel m_kecamatan & m_kelurahan) =====================
    let kelurahanByKecamatan = {};

    function fillKecamatanOptions(select, placeholder) {
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        Object.keys(kelurahanByKecamatan).sort().forEach(function (nama) {
            const opt = document.createElement('option');
            opt.value = nama;
            opt.textContent = nama.toUpperCase();
            select.appendChild(opt);
        });
    }

    function fillKelurahanOptions(select, kecamatan, placeholder, selectedValue) {
        const list = kelurahanByKecamatan[kecamatan] || [];
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        list.forEach(function (nama) {
            const opt = document.createElement('option');
            opt.value = nama;
            opt.textContent = nama.toUpperCase();
            select.appendChild(opt);
        });
        select.disabled = list.length === 0;
        if (selectedValue) select.value = selectedValue;
    }

    function wireCascade(kecSelect, kelSelect, placeholder) {
        fillKecamatanOptions(kecSelect, kecSelect.dataset.placeholder || 'Pilih Kecamatan');
        kecSelect.addEventListener('change', function () {
            fillKelurahanOptions(kelSelect, this.value, placeholder || 'Pilih Kelurahan');
            if (kelSelect.onCascadeChange) kelSelect.onCascadeChange();
        });
    }

    const filterKecamatan = document.getElementById('mk-filter-kecamatan');
    const filterKelurahan = document.getElementById('mk-filter-kelurahan');
    const filterTahun = document.getElementById('mk-filter-tahun');

    function initWilayah() {
        wireCascade(filterKecamatan, filterKelurahan, 'Kelurahan');
        wireCascade(document.getElementById('mk-add-kecamatan'), document.getElementById('mk-add-kelurahan'), 'Kelurahan');
        wireCascade(document.getElementById('mk-edit-kecamatan'), document.getElementById('mk-edit-kelurahan'), 'Kelurahan');
    }

    // ===================== Helper umum =====================
    const csrfToken = document.getElementById('mk-csrf-token').value;
    let allData = [];

    function showToast(message) {
        const toast = document.getElementById('mk-toast');
        document.getElementById('mk-toast-text').textContent = message || 'Data berhasil ditambahkan';
        toast.classList.add('show');
        setTimeout(function () { toast.classList.remove('show'); }, 3000);
    }

    function bsModal(id) {
        return bootstrap.Modal.getOrCreateInstance(document.getElementById(id));
    }

    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function photoBoxHtml(url) {
        return url
            ? '<img src="' + url + '" alt="foto">'
            : '<i class="ki-outline ki-picture fs-5x text-gray-300"></i>';
    }

    // ===================== Load data + render tabel + hitung total =====================
    function loadData() {
        const tbody = document.getElementById('mk-tbody');
        tbody.innerHTML = '<tr><td colspan="11" class="text-center text-muted py-5">Memuat data...</td></tr>';

        fetch('/makan-ketan', { headers: { 'Accept': 'application/json' } })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                allData = data;
                updateTotals(data);
                renderTable();
            })
            .catch(function () {
                tbody.innerHTML = '<tr><td colspan="11" class="text-center text-danger py-5">Gagal memuat data. Pastikan route & tabel sudah siap.</td></tr>';
            });
    }

    function updateTotals(data) {
        const counts = { '2024': 0, '2025': 0, '2026': 0 };
        data.forEach(function (row) {
            if (counts[row.tahun] !== undefined) counts[row.tahun]++;
        });
        document.getElementById('mk-total-2024').textContent = counts['2024'];
        document.getElementById('mk-total-2025').textContent = counts['2025'];
        document.getElementById('mk-total-2026').textContent = counts['2026'];
    }

    function renderTable() {
        const tbody = document.getElementById('mk-tbody');
        const kec = filterKecamatan.value;
        const kel = filterKelurahan.value;
        const tahun = filterTahun.value;
        ['2024', '2025', '2026'].forEach(function (t) {
            document.getElementById('mk-card-' + t).classList.toggle('mk-card-aktif', tahun === t);
        });

        const filtered = allData.filter(function (row) {
            if (kec && row.kecamatan !== kec) return false;
            if (kel && row.kelurahan !== kel) return false;
            if (tahun && String(row.tahun) !== tahun) return false;
            return true;
        });

        if (!filtered.length) {
            tbody.innerHTML = '<tr><td colspan="11" class="text-center text-muted py-5">Belum ada data</td></tr>';
            return;
        }

        tbody.innerHTML = filtered.map(function (row, i) {
            return '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + escapeHtml(row.kecamatan) + '</td>' +
                '<td>' + escapeHtml(row.kelurahan) + '</td>' +
                '<td>' + escapeHtml(row.nama_dasa_wisma) + '</td>' +
                '<td>' + escapeHtml(row.rt || '-') + '</td>' +
                '<td>' + escapeHtml(row.rw || '-') + '</td>' +
                '<td>' + (row.jumlah_rumah ?? '-') + '</td>' +
                '<td><span class="badge badge-light-primary fw-bold">' + escapeHtml(row.tahun) + '</span></td>' +
                '<td>' +
                    '<a href="javascript:void(0)" class="text-primary fw-bold text-hover-primary text-decoration-underline d-inline-flex align-items-center gap-1 mk-btn-foto" data-id="' + row.id + '">' +
                        '<i class="ki-outline ki-file fs-5 text-primary"></i> Lihat Foto' +
                    '</a>' +
                '</td>' +
                '<td>' + (row.juara ? '<span class="badge badge-light-success fw-bold">' + escapeHtml(row.juara) + '</span>' : '-') + '</td>' +
                '<td class="text-end">' +
                    '<button type="button" class="btn btn-sm btn-icon btn-light-warning me-1 mk-btn-edit" data-id="' + row.id + '"><i class="ki-outline ki-pencil fs-5"></i></button>' +
                    '<button type="button" class="btn btn-sm btn-icon btn-light-danger mk-btn-hapus" data-id="' + row.id + '" data-nama="' + escapeHtml(row.nama_dasa_wisma || '') + '"><i class="ki-outline ki-trash fs-5"></i></button>' +
                '</td>' +
            '</tr>';
        }).join('');

        document.querySelectorAll('.mk-btn-foto').forEach(function (btn) {
            btn.addEventListener('click', function () { openFoto(btn.dataset.id); });
        });
        document.querySelectorAll('.mk-btn-edit').forEach(function (btn) {
            btn.addEventListener('click', function () { openEdit(btn.dataset.id); });
        });
        document.querySelectorAll('.mk-btn-hapus').forEach(function (btn) {
            btn.addEventListener('click', function () { hapusData(btn.dataset.id, btn.dataset.nama); });
        });
    }

    // Klik kartu tahun: tabel di bawah hanya menampilkan tahun itu. Klik lagi untuk kembali ke semua tahun.
    window.mkFilterTahun = function (tahun) {
        filterTahun.value = (filterTahun.value === tahun) ? '' : tahun;
        renderTable();
        const kartuTabel = document.getElementById('mk-tbody').closest('.card');
        if (kartuTabel && filterTahun.value) kartuTabel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    filterKecamatan.addEventListener('change', renderTable);
    filterKelurahan.addEventListener('change', renderTable);
    filterTahun.addEventListener('change', renderTable);

    // ===================== Modal khusus foto (tombol "Lihat Foto") =====================
    function openFoto(id) {
        const row = allData.find(function (d) { return String(d.id) === String(id); });
        if (!row) return;

        document.getElementById('mk-foto-title').textContent = 'Foto Dokumentasi - ' + row.nama_dasa_wisma;
        document.getElementById('mk-foto-1').innerHTML = photoBoxHtml(row.foto_1_url);
        document.getElementById('mk-foto-2').innerHTML = photoBoxHtml(row.foto_2_url);

        bsModal('modal_foto_makan_ketan').show();
    }

    // ===================== Edit modal =====================
    function openEdit(id) {
        const row = allData.find(function (d) { return String(d.id) === String(id); });
        if (!row) return;

        document.getElementById('mk-edit-id').value = row.id;
        fillKelurahanOptions(document.getElementById('mk-edit-kelurahan'), row.kecamatan, 'Pilih Kelurahan', row.kelurahan);
        document.getElementById('mk-edit-kecamatan').value = row.kecamatan;
        document.getElementById('mk-edit-nama').value = row.nama_dasa_wisma;
        document.getElementById('mk-edit-jumlah-rumah').value = row.jumlah_rumah || '';
        document.getElementById('mk-edit-rt').value = row.rt || '';
        document.getElementById('mk-edit-rw').value = row.rw || '';
        document.getElementById('mk-edit-tahun').value = row.tahun;
        document.getElementById('mk-edit-juara').value = row.juara || '';
        document.getElementById('mk-edit-preview-1').innerHTML = photoBoxHtml(row.foto_1_url);
        document.getElementById('mk-edit-preview-2').innerHTML = photoBoxHtml(row.foto_2_url);
        document.getElementById('mk-edit-foto1').value = '';
        document.getElementById('mk-edit-foto2').value = '';

        bsModal('modal_edit_makan_ketan').show();
    }

    // ===================== Preview foto saat file dipilih =====================
    document.querySelectorAll('.mk-foto-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const previewBox = document.getElementById(this.dataset.preview);
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                previewBox.innerHTML = '<img src="' + e.target.result + '" alt="preview">';
            };
            reader.readAsDataURL(file);
        });
    });

    // ===================== Submit Tambah =====================
    document.getElementById('mk-form-tambah').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append('kecamatan', document.getElementById('mk-add-kecamatan').value);
        formData.append('kelurahan', document.getElementById('mk-add-kelurahan').value);
        formData.append('nama_dasa_wisma', document.getElementById('mk-add-nama').value);
        formData.append('jumlah_rumah', document.getElementById('mk-add-jumlah-rumah').value);
        formData.append('rt', document.getElementById('mk-add-rt').value);
        formData.append('rw', document.getElementById('mk-add-rw').value);
        formData.append('tahun', document.getElementById('mk-add-tahun').value);
        formData.append('juara', document.getElementById('mk-add-juara').value);

        const foto1 = document.getElementById('mk-add-foto1').files[0];
        const foto2 = document.getElementById('mk-add-foto2').files[0];
        if (foto1) formData.append('foto_1', foto1);
        if (foto2) formData.append('foto_2', foto2);

        fetch('/makan-ketan', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
            .then(function (res) {
                if (!res.ok) return res.json().then(function (err) { throw err; });
                return res.json();
            })
            .then(function (res) {
                bsModal('modal_tambah_makan_ketan').hide();
                document.getElementById('mk-form-tambah').reset();
                document.getElementById('mk-add-preview-1').innerHTML = '<i class="ki-outline ki-picture fs-5x text-gray-300"></i>';
                document.getElementById('mk-add-preview-2').innerHTML = '<i class="ki-outline ki-picture fs-5x text-gray-300"></i>';
                document.getElementById('mk-add-kelurahan').innerHTML = '<option value="">Kelurahan</option>';
                document.getElementById('mk-add-kelurahan').disabled = true;
                showToast(res.message || 'Data berhasil ditambahkan');
                loadData();
            })
            .catch(function (err) {
                alert('Gagal menyimpan data. ' + (err.message || 'Cek kembali isian form.'));
            });
    });

    // ===================== Submit Edit =====================
    document.getElementById('mk-form-edit').addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('mk-edit-id').value;
        const formData = new FormData();
        formData.append('kecamatan', document.getElementById('mk-edit-kecamatan').value);
        formData.append('kelurahan', document.getElementById('mk-edit-kelurahan').value);
        formData.append('nama_dasa_wisma', document.getElementById('mk-edit-nama').value);
        formData.append('jumlah_rumah', document.getElementById('mk-edit-jumlah-rumah').value);
        formData.append('rt', document.getElementById('mk-edit-rt').value);
        formData.append('rw', document.getElementById('mk-edit-rw').value);
        formData.append('tahun', document.getElementById('mk-edit-tahun').value);
        formData.append('juara', document.getElementById('mk-edit-juara').value);

        const foto1 = document.getElementById('mk-edit-foto1').files[0];
        const foto2 = document.getElementById('mk-edit-foto2').files[0];
        if (foto1) formData.append('foto_1', foto1);
        if (foto2) formData.append('foto_2', foto2);

        fetch('/makan-ketan/' + id, {
            method: 'POST', // Laravel baca _method=PUT dari FormData
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData
        })
            .then(function (res) {
                if (!res.ok) return res.json().then(function (err) { throw err; });
                return res.json();
            })
            .then(function (res) {
                bsModal('modal_edit_makan_ketan').hide();
                showToast(res.message || 'Data berhasil diubah');
                loadData();
            })
            .catch(function (err) {
                alert('Gagal menyimpan perubahan. ' + (err.message || 'Cek kembali isian form.'));
            });
    });

    // ===================== Hapus (popup sama seperti Penghargaan) =====================
    function kirimHapus(id, nama) {
        fetch('/makan-ketan/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
            .then(function (res) {
                if (!res.ok) return res.json().then(function (err) { throw err; });
                return res.json();
            })
            .then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: nama + ' berhasil dihapus',
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: 'btn btn-success fw-bold px-6' },
                    buttonsStyling: false
                });
                loadData();
            })
            .catch(function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menghapus data. ' + ((err && err.message) || ''),
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: 'btn btn-danger fw-bold px-6' },
                    buttonsStyling: false
                });
            });
    }

    function hapusData(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin menghapus ' + nama + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger fw-bold px-6 me-2',
                cancelButton: 'btn btn-success fw-bold px-6'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) kirimHapus(id, nama);
        });
    }

    // ===================== Reset modal Tambah tiap dibuka =====================
    document.getElementById('mk-btn-tambah').addEventListener('click', function () {
        document.getElementById('mk-form-tambah').reset();
        document.getElementById('mk-add-kelurahan').innerHTML = '<option value="">Kelurahan</option>';
        document.getElementById('mk-add-kelurahan').disabled = true;
        document.getElementById('mk-add-preview-1').innerHTML = '<i class="ki-outline ki-picture fs-5x text-gray-300"></i>';
        document.getElementById('mk-add-preview-2').innerHTML = '<i class="ki-outline ki-picture fs-5x text-gray-300"></i>';
    });

    // Ambil daftar kecamatan & kelurahan dari database dulu, baru tampilkan data
    fetch('/makan-ketan/wilayah', { headers: { 'Accept': 'application/json' } })
        .then(function (res) { return res.json(); })
        .then(function (data) { kelurahanByKecamatan = data; })
        .catch(function () { alert('Gagal mengambil data kecamatan/kelurahan dari database.'); })
        .finally(function () { initWilayah(); loadData(); });
})();
</script>

{{-- Tukar banner: banner pastel Makan Ketan naik ke posisi banner atas, banner hijau disembunyikan --}}
<script>
(function () {
    var banner = document.getElementById('mk-top-banner');
    if (!banner) return;
    var item = banner.closest('.inovasi-item-view');   // wadah konten Makan Ketan (tampil/sembunyi sesuai dropdown)
    var hijau = document.querySelector('#banner-inovasi-default, .banner-inovasi-kota');   // banner hijau di index.blade.php

    // Pindahkan banner pastel ke posisi banner hijau (tepat di bawahnya)
    if (hijau && item) hijau.insertAdjacentElement('afterend', banner);

    function sync() {
        var tampil = !item || item.offsetParent !== null;
        banner.classList.toggle('d-none', !tampil);
        // Banner hijau tampil hanya jika tidak ada banner submenu yang sedang aktif
        if (hijau) hijau.classList.toggle('d-none', !!document.querySelector('.sub-banner-top:not(.d-none)'));
    }

    if (item) new MutationObserver(sync).observe(item, { attributes: true, attributeFilter: ['class', 'style'] });
    document.addEventListener('change', function (e) {
        if (e.target && (e.target.id === 'select-filter-inovasi' || e.target.id === 'select-filter-pokja')) setTimeout(sync, 0);
    });
    sync();
})();
</script>
