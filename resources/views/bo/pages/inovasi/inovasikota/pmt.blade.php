<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Kartu tahun: kuning pastel senada banner, mengambang, terangkat saat disentuh */
.card.card-tahun {
    position: relative; overflow: hidden; cursor: pointer;
    background: #fbf1de; border: 1px solid #f1deb0 !important; border-radius: 1rem;
    box-shadow: 0 1px 2px rgba(122, 84, 16, .06), 0 10px 24px -10px rgba(122, 84, 16, .3) !important;
    transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
}
.card.card-tahun::before {
    content: ""; position: absolute; right: -40px; top: -40px; width: 130px; height: 130px;
    border-radius: 50%; background: #f3e3c0; opacity: .8; pointer-events: none; transition: background-color .2s ease;
}
.card.card-tahun .card-body { position: relative; z-index: 1; }
.card.card-tahun:hover { transform: translateY(-3px); box-shadow: 0 2px 4px rgba(122, 84, 16, .08), 0 18px 32px -12px rgba(122, 84, 16, .38) !important; }
.card.card-tahun.pmt-aktif { background: #f7e6bf; border-color: #e8a23b !important; transform: translateY(-3px); box-shadow: 0 2px 4px rgba(122, 84, 16, .08), 0 18px 32px -12px rgba(122, 84, 16, .42) !important; }
.card.card-tahun.pmt-aktif::before { background: #efd69a; }
.pmt-kartu-label { font-size: .75rem; font-weight: 700; letter-spacing: .08em; color: #7d6232; }
.pmt-kartu-angka { font-size: 2.6rem; font-weight: 800; line-height: 1.1; color: #5a3b0e; }
.pmt-kartu-sub { font-size: .85rem; font-weight: 700; color: #b8791a; }
.pmt-kartu-tahun { background: #fff; color: #8a5a0a; font-weight: 700; font-size: .9rem; padding: .5rem 0; border-radius: .75rem; transition: background-color .2s ease, color .2s ease; }
.card-tahun.pmt-aktif .pmt-kartu-tahun { background: #e8a23b; color: #4a2f06; }

/* Tombol utama, tautan, dan total: amber senada banner */
.btn.pmt-btn-amber { background-color: #b8791a; color: #fff; border: 0; }
.btn.pmt-btn-amber:hover, .btn.pmt-btn-amber:focus { background-color: #9f6914; color: #fff; }
.pmt-link { color: #b8791a; }
.pmt-link:hover { color: #9f6914; }
.pmt-total-pill { background: #fbf1de; border: 1px solid #f1deb0; border-radius: 1rem; box-shadow: 0 1px 2px rgba(122, 84, 16, .06), 0 8px 20px -10px rgba(122, 84, 16, .28); }
.pmt-total-pill span { color: #8a5a0a; }

/* Tabel: header & aksi bernuansa amber lembut */
#tabel-pmt thead tr { background: #fbf1de !important; }
#tabel-pmt thead th { color: #5a3b0e !important; border-color: #f1e3c0 !important; }
#tabel-pmt tbody td { border-color: #f4ead0 !important; }
#tabel-pmt tbody tr:hover td { background: #fffaf0; }
#tabel-pmt .btn-light-primary { background-color: #fbf1de !important; color: #b8791a !important; }
#tabel-pmt .btn-light-primary:hover { background-color: #f3e3c0 !important; }
#tabel-pmt .btn-light-primary i, #tabel-pmt .text-primary i { color: #b8791a !important; }
#tabel-pmt .text-primary { color: #b8791a !important; }
#pagination-pmt .page-item.active .page-link { background-color: #b8791a !important; border-color: #b8791a !important; color: #fff !important; }
#pagination-pmt .page-link { color: #7d6232; }
.pmt-photo-box {
    border: 1px solid #e4e6ef; border-radius: .75rem; background: #f8f9fb;
    display: flex; align-items: center; justify-content: center; overflow: hidden; height: 150px;
}
.pmt-photo-box img { width: 100%; height: 100%; object-fit: cover; }
</style>

<input type="hidden" id="pmt-csrf-token" value="{{ csrf_token() }}">

<!-- Banner atas PMT: otomatis naik menggantikan banner hijau "Inovasi Kota" saat submenu ini dipilih -->
<style>
    /* Banner atas PMT: kuning pastel, naik menggantikan banner hijau saat submenu ini dipilih */
    .pmh { position: relative; overflow: hidden; display: flex; align-items: center; min-height: 210px; padding: 2rem 2.5rem; margin-bottom: .5rem; border-radius: 1rem; background: #fbf1de; }
    .pmh-text { position: relative; z-index: 2; max-width: 52%; }
    .pmh-label { display: block; margin-bottom: .5rem; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #e8a23b; }
    .pmh-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #5a3b0e; }
    .pmh-sub { margin: 0; font-size: .95rem; font-weight: 500; color: #7d6232; }
    .pmh-art { position: absolute; right: 0; bottom: 0; height: 100%; width: auto; max-width: 58%; z-index: 1; pointer-events: none; }
    @media (max-width: 767.98px) {
        .pmh { padding: 1.5rem; min-height: 170px; }
        .pmh-title { font-size: 1.6rem; }
        .pmh-text { max-width: 100%; }
        .pmh-art { opacity: .3; max-width: 80%; }
    }
</style>

<div id="pmt-top-banner" class="pmh sub-banner-top d-none">
    <div class="pmh-text">
        <span class="pmh-label">Inovasi Kota</span>
        <h2 class="pmh-title">PMT</h2>
        <p class="pmh-sub">Pemberian Makanan Tambahan</p>
    </div>

    <svg class="pmh-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#f3e3c0"/>
        <circle cx="318" cy="22" r="46" fill="#edd8aa" opacity=".6"/>
        <circle cx="46" cy="176" r="14" fill="#edd8aa"/>
        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>
                                <rect x="166" y="158" width="262" height="9" rx="4" fill="#8a6648"/>
                                <rect x="176" y="167" width="242" height="20" rx="8" fill="#7b563c"/>
                                <circle cx="196" cy="148" r="11" fill="#e0b878"/>
                                <circle cx="215" cy="148" r="11" fill="#e0b878"/>
                                <circle cx="205" cy="135" r="11" fill="#e8c78d"/>
                                <path d="M250 150 C250 126 292 126 292 150 L292 158 L250 158 Z" fill="#8aae92"/>
                                <circle cx="271" cy="108" r="18" fill="#f3cca8"/>
                                <path d="M253 104 C253 88 289 88 289 104 C282 97 260 97 253 104 Z" fill="#3b2a22"/>
                                <circle cx="271" cy="86" r="7" fill="#3b2a22"/>
                                <path d="M290 142 L316 126" stroke="#f3cca8" stroke-width="6" stroke-linecap="round"/>
                                <path d="M316 126 L326 112" stroke="#b8bcc6" stroke-width="3" stroke-linecap="round"/>
                                <path d="M300 158 H348 C348 172 340 178 324 178 C308 178 300 172 300 158 Z" fill="#fff"/>
                                <path d="M298 158 H350" stroke="#e8a23b" stroke-width="4" stroke-linecap="round"/>
                                <rect x="374" y="132" width="26" height="26" fill="#fff"/>
                                <path d="M374 132 L387 118 L400 132 Z" fill="#a8c0ae"/>
                                <rect x="374" y="142" width="26" height="6" fill="#a8c0ae"/>
                                <path d="M394 120 L402 104" stroke="#e8a23b" stroke-width="3.5" stroke-linecap="round"/>
                                <path d="M410 150 C420 146 430 152 432 160 C424 158 416 158 410 150 Z" fill="#d9695a"/>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M142 188 L142 160"/><path d="M142 174 L133 164"/><path d="M142 168 L151 158"/></g>
                            </svg>
</div>

<!-- Banner Informasi PMT -->
<div class="card card-flush border-0 mb-6" style="background-color: #fdf6e6 !important;">
    <div class="card-body p-6">
        <h4 class="fw-bold text-gray-900 mb-2">Inovasi PMT (Pemberian Makanan Tambahan)</h4>
        <p class="text-gray-600 fs-7 mb-0" style="line-height: 1.6;">
            Memiliki tujuan utama untuk meningkatkan status gizi balita dan ibu hamil, terutama yang kekurangan gizi, untuk mencegah dan mengatasi stunting serta gizi buruk, sekaligus memberikan edukasi kepada orang tua tentang pentingnya gizi seimbang, meningkatkan kehadiran di posyandu, dan mendorong penggunaan pangan lokal bergizi. PMT membantu memastikan anak mendapat energi dan nutrisi yang cukup agar tumbuh optimal dan berat badannya naik sesuai kurva pertumbuhan.
        </p>
    </div>
</div>

<!-- Header PMT & Dashboard Link -->
<div class="d-flex flex-stack mb-5">
    <h3 class="fw-bold text-gray-900 m-0">PMT (Pemberian Makanan Tambahan)</h3>
    <a href="#" class="pmt-link fw-bold fs-7 text-hover-underline">Dashboard</a>
</div>

<!-- Total & Filter -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
    <div class="pmt-total-pill px-6 py-3 d-flex align-items-center justify-content-center">
        <span class="fs-2hx fw-bolder me-2" id="pmt-total">Total : 0</span>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">
        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="pmt-filter-kecamatan">
            <option value="">Semua Kecamatan</option>
        </select>

        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="pmt-filter-kelurahan" disabled>
            <option value="">Semua Kelurahan</option>
        </select>

        <select class="form-select form-select-solid w-125px fs-7 fw-semibold" id="pmt-filter-tahun">
            <option value="">Semua Tahun</option>
            @for ($t = 2030; $t >= 2024; $t--)
                <option value="{{ $t }}">{{ $t }}</option>
            @endfor
        </select>

        <select class="form-select form-select-solid w-150px fs-7 fw-semibold" id="pmt-filter-putaran">
            <option value="">Semua Putaran</option>
            @for ($i = 1; $i <= 7; $i++)
                <option value="Putaran {{ $i }}">Putaran {{ $i }}</option>
            @endfor
        </select>

        <button type="button" class="btn pmt-btn-amber fw-bold fs-7 px-4" onclick="openTambahPmt()">
            <i class="ki-outline ki-plus fs-3 me-1"></i> Tambah Data PMT
        </button>
    </div>
</div>

<!-- 3 Card Tahun (klik untuk memfilter tabel) -->
<div class="row g-4 mb-6">
    <div class="col-md-4">
        <div class="card h-100 cursor-pointer card-tahun" id="pmt-card-2024" onclick="pmtFilterTahun('2024')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="pmt-kartu-label">TOTAL</span>
                <div class="pmt-kartu-angka my-2" id="pmt-count-2024">0</div>
                <span class="pmt-kartu-sub mb-4">BALITA</span>
                <div class="pmt-kartu-tahun">2024</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 cursor-pointer card-tahun" id="pmt-card-2025" onclick="pmtFilterTahun('2025')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="pmt-kartu-label">TOTAL</span>
                <div class="pmt-kartu-angka my-2" id="pmt-count-2025">0</div>
                <span class="pmt-kartu-sub mb-4">BALITA</span>
                <div class="pmt-kartu-tahun">2025</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 cursor-pointer card-tahun" id="pmt-card-2026" onclick="pmtFilterTahun('2026')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="pmt-kartu-label">TOTAL</span>
                <div class="pmt-kartu-angka my-2" id="pmt-count-2026">0</div>
                <span class="pmt-kartu-sub mb-4">BALITA</span>
                <div class="pmt-kartu-tahun">2026</div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card card-flush shadow-sm">
    <div class="card-body pt-6">
        <div class="d-flex flex-stack mb-5">
            <div class="d-flex align-items-center gap-2">
                <select class="form-select form-select-solid w-75px fs-7 fw-semibold" id="pmt-table-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="d-flex align-items-center position-relative">
                <label class="fs-7 fw-semibold text-gray-700 me-2">Search:</label>
                <input type="text" id="pmt-input-search" class="form-control form-control-solid w-200px fs-7" placeholder="" />
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle table-bordered fs-7 gy-3 gs-4" id="tabel-pmt">
                <thead>
                    <tr class="fw-bold text-gray-800 bg-light text-uppercase">
                        <th class="w-50px text-center">NO</th>
                        <th>NIK</th>
                        <th>NAMA BALITA</th>
                        <th>TANGGAL LAHIR</th>
                        <th>USIA</th>
                        <th>JENIS KELAMIN</th>
                        <th>ALAMAT</th>
                        <th>NAMA ORANG TUA</th>
                        <th>PUTARAN</th>
                        <th>TAHUN</th>
                        <th>KELURAHAN</th>
                        <th>KECAMATAN</th>
                        <th class="text-center">FOTO</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-700" id="tbody-pmt">
                    <tr><td colspan="14" class="text-center py-5 text-gray-500">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-4">
            <span class="text-gray-600 fs-8 fw-semibold" id="info-pmt"></span>
            <ul class="pagination pagination-outline mb-0" id="pagination-pmt"></ul>
        </div>
    </div>
</div>

<!-- Modal Tambah / Edit PMT -->
<div class="modal fade" id="modal_tambah_pmt" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3" id="pmt-modal-title">Tambah PMT</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-tambah-pmt" enctype="multipart/form-data">
                    <input type="hidden" id="pmt-id" />

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NIK <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-solid" id="pmt-nik" name="nik" maxlength="16" inputmode="numeric" placeholder="16 digit NIK" required />
                            <button class="btn pmt-btn-amber fw-bold px-6" type="button" id="pmt-cari-nik">Cari</button>
                        </div>
                        <div class="form-text fs-9">Tombol Cari mengisi otomatis data balita yang NIK-nya sudah pernah tercatat di PMT.</div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA BALITA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="pmt-nama" name="nama_balita" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-solid" id="pmt-tgl" name="tanggal_lahir" required />
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">USIA</label>
                            <input type="text" class="form-control form-control-solid" id="pmt-usia" placeholder="Terisi otomatis dari tanggal lahir" readonly />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="pmt-jk" name="jenis_kelamin" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">ALAMAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="pmt-alamat" name="alamat" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA ORANG TUA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" id="pmt-ortu" name="nama_orang_tua" required />
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kecamatan" id="pmt-modal-kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="kelurahan" id="pmt-modal-kelurahan" required disabled>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="pmt-tahun" name="tahun" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                @for ($t = 2024; $t <= 2030; $t++)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">PUTARAN KE <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="pmt-putaran" name="putaran" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="Putaran {{ $i }}">Putaran {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-4">
                            <div class="pmt-photo-box" id="pmt-preview"><i class="ki-outline ki-picture fs-3x text-gray-300"></i></div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Foto 1 <span class="text-danger" id="pmt-foto-wajib">*</span></label>
                            <input type="file" class="form-control form-control-solid" id="pmt-foto" name="foto" accept="image/jpg, image/jpeg, image/png" />
                            <div class="form-text text-danger fs-8 mt-1">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4">
                        <button type="button" class="btn btn-danger fw-bold px-6" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-4 me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn pmt-btn-amber fw-bold px-6 text-white">
                            <i class="ki-outline ki-check fs-4 me-1 text-white"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL LIHAT FOTO (POPUP) -->
<div class="modal fade" id="modal_foto_pmt" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4" id="pmt-foto-title">Foto Dokumentasi</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <div class="pmt-photo-box" style="height: 420px;" id="pmt-foto-box"></div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    let wilayah = {};
    let semuaData = [];
    let page = 1;

    const csrf = document.getElementById('pmt-csrf-token').value;
    const $ = function (id) { return document.getElementById(id); };
    const EMPTY_IMG = '<i class="ki-outline ki-picture fs-3x text-gray-300"></i>';
    const KOLOM = 14;

    function esc(v) {
        if (v === null || v === undefined) return '';
        return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function api(url, options) {
        options = options || {};
        options.headers = Object.assign({ 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }, options.headers || {});
        return fetch(url, options).then(function (res) {
            return res.json().catch(function () { return {}; }).then(function (body) {
                if (!res.ok) {
                    let msg = body.message || 'Terjadi kesalahan.';
                    if (body.errors) msg = Object.values(body.errors)[0][0];
                    throw new Error(msg);
                }
                return body;
            });
        });
    }

    function sukses(teks) {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: teks, showConfirmButton: false, timer: 2000, customClass: { popup: 'rounded-4' } });
    }
    function gagal(teks) {
        Swal.fire({ icon: 'error', title: 'Gagal', text: teks, customClass: { popup: 'rounded-4' } });
    }
    function modal() { return bootstrap.Modal.getOrCreateInstance($('modal_tambah_pmt')); }

    // ---------- Usia dari tanggal lahir ----------
    function hitungUsia(tgl) {
        if (!tgl) return '';
        const lahir = new Date(String(tgl).substring(0, 10) + 'T00:00:00');
        if (isNaN(lahir.getTime())) return '';
        const now = new Date();
        let bulan = (now.getFullYear() - lahir.getFullYear()) * 12 + (now.getMonth() - lahir.getMonth());
        if (now.getDate() < lahir.getDate()) bulan--;
        if (bulan < 0) return '';
        return bulan + ' Bulan';
    }
    function formatTanggal(tgl) {
        if (!tgl) return '';
        const p = String(tgl).substring(0, 10).split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : tgl;
    }

    // ---------- Wilayah ----------
    function isiKecamatan(select, placeholder, disabledPlaceholder) {
        select.innerHTML = '<option value=""' + (disabledPlaceholder ? ' selected disabled' : '') + '>' + placeholder + '</option>';
        Object.keys(wilayah).sort().forEach(function (k) { select.appendChild(new Option(k, k)); });
    }
    function isiKelurahan(select, kec, placeholder, disabledPlaceholder, terpilih) {
        select.innerHTML = '<option value=""' + (disabledPlaceholder ? ' selected disabled' : '') + '>' + placeholder + '</option>';
        const list = wilayah[kec] || [];
        list.forEach(function (k) { select.appendChild(new Option(k, k)); });
        select.disabled = list.length === 0;
        if (terpilih) select.value = terpilih;
    }

    function initWilayah() {
        isiKecamatan($('pmt-filter-kecamatan'), 'Semua Kecamatan', false);
        $('pmt-filter-kecamatan').addEventListener('change', function () {
            isiKelurahan($('pmt-filter-kelurahan'), this.value, 'Semua Kelurahan', false);
            page = 1; render();
        });
        $('pmt-filter-kelurahan').addEventListener('change', function () { page = 1; render(); });

        isiKecamatan($('pmt-modal-kecamatan'), 'Pilih Kecamatan', true);
        $('pmt-modal-kecamatan').addEventListener('change', function () {
            isiKelurahan($('pmt-modal-kelurahan'), this.value, 'Pilih Kelurahan', true);
        });
    }

    // ---------- Filter, total, tabel ----------
    function filtered() {
        const kec = $('pmt-filter-kecamatan').value;
        const kel = $('pmt-filter-kelurahan').value;
        const thn = $('pmt-filter-tahun').value;
        const put = $('pmt-filter-putaran').value;
        const q = $('pmt-input-search').value.trim().toLowerCase();

        return semuaData.filter(function (r) {
            if (kec && r.kecamatan !== kec) return false;
            if (kel && r.kelurahan !== kel) return false;
            if (thn && String(r.tahun) !== thn) return false;
            if (put && r.putaran !== put) return false;
            if (q) {
                const teks = [r.nik, r.nama_balita, r.alamat, r.nama_orang_tua, r.kecamatan, r.kelurahan, r.putaran, r.tahun, r.jenis_kelamin].join(' ').toLowerCase();
                if (teks.indexOf(q) === -1) return false;
            }
            return true;
        });
    }

    function updateKartuTahun() {
        ['2024', '2025', '2026'].forEach(function (t) {
            const jml = semuaData.filter(function (r) { return String(r.tahun) === t; }).length;
            $('pmt-count-' + t).textContent = jml;
            $('pmt-card-' + t).classList.toggle('pmt-aktif', $('pmt-filter-tahun').value === t);
        });
    }

    function render() {
        const rows = filtered();
        const perPage = parseInt($('pmt-table-length').value, 10) || 10;
        const totalPage = Math.max(1, Math.ceil(rows.length / perPage));
        if (page > totalPage) page = totalPage;
        const mulai = (page - 1) * perPage;
        const tampil = rows.slice(mulai, mulai + perPage);

        $('pmt-total').textContent = 'Total : ' + rows.length;
        updateKartuTahun();

        if (!tampil.length) {
            $('tbody-pmt').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center py-5 text-gray-500">Belum ada data tersedia</td></tr>';
        } else {
            $('tbody-pmt').innerHTML = tampil.map(function (r, i) {
                const foto = r.foto_url
                    ? '<a href="javascript:void(0)" class="text-primary fw-bold text-hover-primary text-decoration-underline d-inline-flex align-items-center gap-1 pmt-btn-foto" data-id="' + r.id + '"><i class="ki-outline ki-file fs-5 text-primary"></i> Lihat Foto</a>'
                    : '<span class="text-muted fs-8">-</span>';
                const aksi =
                    '<button class="btn btn-sm btn-icon btn-light-primary rounded-circle me-1 pmt-btn-edit" data-id="' + r.id + '" title="Edit"><i class="ki-outline ki-pencil fs-5"></i></button>' +
                    '<button class="btn btn-sm btn-icon btn-light-danger rounded-circle pmt-btn-hapus" data-id="' + r.id + '" title="Hapus"><i class="ki-outline ki-trash fs-5"></i></button>';

                return '<tr><td class="text-center">' + (mulai + i + 1) + '</td>' +
                    '<td>' + esc(r.nik) + '</td>' +
                    '<td class="fw-bold text-gray-800">' + esc(r.nama_balita) + '</td>' +
                    '<td>' + esc(formatTanggal(r.tanggal_lahir)) + '</td>' +
                    '<td>' + esc(hitungUsia(r.tanggal_lahir)) + '</td>' +
                    '<td>' + esc(r.jenis_kelamin) + '</td>' +
                    '<td>' + esc(r.alamat) + '</td>' +
                    '<td>' + esc(r.nama_orang_tua) + '</td>' +
                    '<td>' + esc(r.putaran) + '</td>' +
                    '<td>' + esc(r.tahun) + '</td>' +
                    '<td>' + esc(r.kelurahan) + '</td>' +
                    '<td>' + esc(r.kecamatan) + '</td>' +
                    '<td class="text-center">' + foto + '</td>' +
                    '<td class="text-center text-nowrap">' + aksi + '</td></tr>';
            }).join('');
        }

        $('info-pmt').textContent = rows.length
            ? 'Menampilkan ' + (mulai + 1) + ' - ' + (mulai + tampil.length) + ' dari ' + rows.length + ' data'
            : 'Tidak ada data';

        let pg = '<li class="page-item ' + (page === 1 ? 'disabled' : '') + '"><a class="page-link pmt-page" href="#" data-page="' + (page - 1) + '">Sebelumnya</a></li>';
        for (let p = 1; p <= totalPage; p++) {
            pg += '<li class="page-item ' + (p === page ? 'active' : '') + '"><a class="page-link pmt-page" href="#" data-page="' + p + '">' + p + '</a></li>';
        }
        pg += '<li class="page-item ' + (page === totalPage ? 'disabled' : '') + '"><a class="page-link pmt-page" href="#" data-page="' + (page + 1) + '">Berikutnya</a></li>';
        $('pagination-pmt').innerHTML = pg;
    }

    function loadData() {
        return api('/pmt-data')
            .then(function (data) { semuaData = data; render(); })
            .catch(function () {
                $('tbody-pmt').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center text-danger py-5">Gagal memuat data. Pastikan migration sudah dijalankan dan route sudah ditambahkan.</td></tr>';
            });
    }

    // klik kartu tahun: pilih tahun itu; klik lagi untuk kembali ke semua tahun
    window.pmtFilterTahun = function (tahun) {
        const sel = $('pmt-filter-tahun');
        sel.value = (sel.value === tahun) ? '' : tahun;
        page = 1; render();
    };

    $('pmt-filter-tahun').addEventListener('change', function () { page = 1; render(); });
    $('pmt-filter-putaran').addEventListener('change', function () { page = 1; render(); });
    $('pmt-table-length').addEventListener('change', function () { page = 1; render(); });
    $('pmt-input-search').addEventListener('input', function () { page = 1; render(); });

    $('pagination-pmt').addEventListener('click', function (e) {
        const a = e.target.closest('.pmt-page');
        if (!a) return;
        e.preventDefault();
        const p = parseInt(a.dataset.page, 10);
        if (p >= 1) { page = p; render(); }
    });

    $('tbody-pmt').addEventListener('click', function (e) {
        const edit = e.target.closest('.pmt-btn-edit');
        const hapus = e.target.closest('.pmt-btn-hapus');
        const foto = e.target.closest('.pmt-btn-foto');
        if (foto) bukaFoto(foto.dataset.id);
        if (edit) bukaEdit(edit.dataset.id);
        if (hapus) konfirmasiHapus(hapus.dataset.id);
    });

    // ---------- Form ----------
    // Popup "Lihat Foto" (tidak lagi membuka jendela baru)
    function bukaFoto(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        $('pmt-foto-title').textContent = 'Foto Dokumentasi - ' + (r.nama_balita || '');
        $('pmt-foto-box').innerHTML = r.foto_url ? '<img src="' + esc(r.foto_url) + '" alt="foto">' : EMPTY_IMG;
        bootstrap.Modal.getOrCreateInstance($('modal_foto_pmt')).show();
    }

    function resetForm() {
        $('form-tambah-pmt').reset();
        $('pmt-id').value = '';
        $('pmt-usia').value = '';
        $('pmt-preview').innerHTML = EMPTY_IMG;
        isiKecamatan($('pmt-modal-kecamatan'), 'Pilih Kecamatan', true);
        $('pmt-modal-kelurahan').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
        $('pmt-modal-kelurahan').disabled = true;
    }

    window.openTambahPmt = function () {
        resetForm();
        $('pmt-modal-title').textContent = 'Tambah PMT';
        $('pmt-foto-wajib').classList.remove('d-none');
        $('pmt-tgl').max = new Date().toISOString().substring(0, 10);
        modal().show();
    };

    function bukaEdit(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        resetForm();
        $('pmt-modal-title').textContent = 'Edit PMT';
        $('pmt-foto-wajib').classList.add('d-none');
        $('pmt-tgl').max = new Date().toISOString().substring(0, 10);
        $('pmt-id').value = r.id;
        $('pmt-nik').value = r.nik || '';
        $('pmt-nama').value = r.nama_balita || '';
        $('pmt-tgl').value = String(r.tanggal_lahir || '').substring(0, 10);
        $('pmt-usia').value = hitungUsia(r.tanggal_lahir);
        $('pmt-jk').value = r.jenis_kelamin || '';
        $('pmt-alamat').value = r.alamat || '';
        $('pmt-ortu').value = r.nama_orang_tua || '';
        $('pmt-modal-kecamatan').value = r.kecamatan;
        isiKelurahan($('pmt-modal-kelurahan'), r.kecamatan, 'Pilih Kelurahan', true, r.kelurahan);
        $('pmt-tahun').value = String(r.tahun);
        $('pmt-putaran').value = r.putaran;
        $('pmt-preview').innerHTML = r.foto_url ? '<img src="' + esc(r.foto_url) + '" alt="foto">' : EMPTY_IMG;
        modal().show();
    }

    $('pmt-tgl').addEventListener('change', function () { $('pmt-usia').value = hitungUsia(this.value); });

    $('pmt-foto').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) { $('pmt-preview').innerHTML = '<img src="' + e.target.result + '" alt="preview">'; };
        reader.readAsDataURL(file);
    });

    // Cari NIK: isi otomatis dari data PMT yang sudah pernah tercatat
    $('pmt-cari-nik').addEventListener('click', function () {
        const nik = $('pmt-nik').value.trim();
        if (nik.length !== 16) { gagal('NIK harus 16 digit.'); return; }
        const r = semuaData.find(function (d) { return d.nik === nik; });
        if (!r) {
            Swal.fire({ icon: 'info', title: 'NIK belum tercatat', text: 'Silakan isi data balita secara manual.', customClass: { popup: 'rounded-4' } });
            return;
        }
        $('pmt-nama').value = r.nama_balita || '';
        $('pmt-tgl').value = String(r.tanggal_lahir || '').substring(0, 10);
        $('pmt-usia').value = hitungUsia(r.tanggal_lahir);
        $('pmt-jk').value = r.jenis_kelamin || '';
        $('pmt-alamat').value = r.alamat || '';
        $('pmt-ortu').value = r.nama_orang_tua || '';
        $('pmt-modal-kecamatan').value = r.kecamatan;
        isiKelurahan($('pmt-modal-kelurahan'), r.kecamatan, 'Pilih Kelurahan', true, r.kelurahan);
    });

    $('form-tambah-pmt').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = $('pmt-id').value;

        if (!id && !$('pmt-foto').files.length) { gagal('Foto wajib diisi.'); return; }

        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;

        const fd = new FormData(this);
        let url = '/pmt-data';
        if (id) { url += '/' + id; }

        api(url, { method: 'POST', body: fd })
            .then(function (res) {
                modal().hide();
                sukses(res.message || (id ? 'Data berhasil diubah' : 'Data berhasil ditambahkan'));
                return loadData();
            })
            .catch(function (err) { gagal(err.message); })
            .finally(function () { btn.disabled = false; });
    });

    function konfirmasiHapus(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah anda yakin untuk menghapus data ' + r.nama_balita + ' ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: { confirmButton: 'btn btn-success fw-bold px-6 me-2', cancelButton: 'btn btn-danger fw-bold px-6', popup: 'rounded-4' },
            buttonsStyling: false
        }).then(function (result) {
            if (!result.isConfirmed) return;
            api('/pmt-data/' + id, { method: 'DELETE' })
                .then(function (res) { sukses(res.message || 'Data berhasil dihapus'); return loadData(); })
                .catch(function (err) { gagal(err.message); });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        api('/pmt-data/wilayah')
            .then(function (data) { wilayah = data; })
            .catch(function () { gagal('Gagal mengambil data kecamatan/kelurahan dari database.'); })
            .finally(function () { initWilayah(); loadData(); });
    });
})();
</script>

{{-- Tukar banner: banner pastel PMT naik ke posisi banner atas, banner hijau disembunyikan --}}
<script>
(function () {
    var banner = document.getElementById('pmt-top-banner');
    if (!banner) return;
    var item = banner.closest('.inovasi-item-view') || document.getElementById('content-pmt');   // wadah konten PMT (tampil/sembunyi sesuai dropdown)

    // Cari banner hijau "Inovasi Kota" di index.blade.php (tidak bergantung pada nama class tertentu)
    function cariBannerHijau() {
        var el = document.querySelector('#banner-inovasi-default, .banner-inovasi-kota');
        if (el) return el;
        var sub = document.getElementById('banner-subtitle-inovasi');
        var pilih = document.getElementById('select-filter-inovasi');
        if (!sub || !pilih) return null;
        el = sub;
        while (el.parentElement && !el.parentElement.contains(pilih)) el = el.parentElement;
        return el;
    }
    var hijau = cariBannerHijau();

    if (hijau && item) hijau.insertAdjacentElement('afterend', banner);   // naik ke posisi banner atas

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
