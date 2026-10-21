<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.card-tahun { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.card-tahun:hover { transform: translateY(-3px); box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; }
.card-tahun.pmt-aktif { box-shadow: 0 6px 20px rgba(0,0,0,0.18) !important; transform: translateY(-3px); }
.pmt-photo-box {
    border: 1px solid #e4e6ef; border-radius: .75rem; background: #f8f9fb;
    display: flex; align-items: center; justify-content: center; overflow: hidden; height: 150px;
}
.pmt-photo-box img { width: 100%; height: 100%; object-fit: cover; }
</style>

<input type="hidden" id="pmt-csrf-token" value="{{ csrf_token() }}">

<!-- Banner Informasi PMT -->
<div class="card card-flush bg-light-primary border-0 mb-6" style="background-color: #f0f6ff !important;">
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
    <a href="#" class="text-primary fw-bold fs-7 text-hover-underline">Dashboard</a>
</div>

<!-- Total & Filter -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
    <div class="border border-warning rounded-4 px-6 py-3 bg-white d-flex align-items-center justify-content-center">
        <span class="fs-2hx fw-bolder text-warning me-2" id="pmt-total">Total : 0</span>
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

        <button type="button" class="btn btn-primary fw-bold fs-7 px-4" onclick="openTambahPmt()">
            <i class="ki-outline ki-plus fs-3 me-1"></i> Tambah Data PMT
        </button>
    </div>
</div>

<!-- 3 Card Tahun (klik untuk memfilter tabel) -->
<div class="row g-4 mb-6">
    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border border-primary card-tahun" id="pmt-card-2024" onclick="pmtFilterTahun('2024')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder text-primary my-2" id="pmt-count-2024">0</div>
                <span class="text-primary fw-bold fs-7 mb-4">BALITA</span>
                <div class="bg-primary text-white fw-bold py-2 rounded-3 fs-7">2024</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border card-tahun" id="pmt-card-2025" onclick="pmtFilterTahun('2025')" style="border-color: #7239ea !important;">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder my-2" style="color: #7239ea;" id="pmt-count-2025">0</div>
                <span class="fw-bold fs-7 mb-4" style="color: #7239ea;">BALITA</span>
                <div class="text-white fw-bold py-2 rounded-3 fs-7" style="background-color: #7239ea;">2025</div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border border-success card-tahun" id="pmt-card-2026" onclick="pmtFilterTahun('2026')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder text-success my-2" id="pmt-count-2026">0</div>
                <span class="text-success fw-bold fs-7 mb-4">BALITA</span>
                <div class="bg-success text-white fw-bold py-2 rounded-3 fs-7">2026</div>
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
                            <button class="btn btn-primary fw-bold px-6" type="button" id="pmt-cari-nik">Cari</button>
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
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white" style="background-color: #4CAF50 !important; border-color: #4CAF50 !important;">
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
