<!-- KONTEN INOVASI KEMANGGI (Tampil Bersih di Samping Sidebar Metronic) -->
<div class="d-flex flex-column gap-5">

    <!-- 1. Card Deskripsi Program Kemangi -->
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-8">
            <h2 class="fw-bolder text-gray-900 mb-1 fs-2">
                Inovasi Kemangi
            </h2>
            <h4 class="text-success fw-bold text-uppercase tracking-wider fs-6 mb-3">
                Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri
            </h4>
            <div class="bg-success rounded-pill mb-4" style="height: 3px; width: 60px;"></div>
            <p class="text-gray-600 fs-6 lh-base mb-0">
                Kelas Remaja-orang tua tangguh, kreatif dan mandiri Kota Surabaya (KEMANGI) adalah kelas yang diadakan sebagai upaya untuk meningkatkan pengetahuan dan keterampilan para remaja dalam memberikan edukasi terhadap teman sebaya. Meningkatkan pengetahuan, sikap dan perilaku yang positif dalam pengembangan diri remaja secara mental, fisik, intelektual, spiritual dan sosial serta meningkatkan keterampilan orang tua dalam pengasuhan remaja agar keluarga mampu menghadapi tantangan modern dengan lebih baik.
            </p>
            <span class="text-gray-600 fs-6 lh-base mb-0 d-block mt-3">
                KEMANGGI merupakan inovasi yang dikembangkan oleh Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kota Surabaya. Inovasi ini bertujuan untuk meningkatkan kualitas hidup remaja dan orang tua melalui pendidikan, pelatihan, dan dukungan sosial.
            </span>
        </div>
    </div>

    <!-- 2. Card Filter: Kecamatan & Periode (Sesuai Gambar Tangkapan Layar Anda) -->
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-6">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label for="filter_kecamatan" class="form-label fs-7 fw-bold text-gray-700 text-uppercase tracking-wide mb-2">
                        Kecamatan
                    </label>
                    <select id="filter_kecamatan" class="form-select form-select-solid fw-semibold">
                        <option value="SEMUA KECAMATAN" selected>SEMUA KECAMATAN</option>
                        <option value="Genteng">Genteng</option>
                        <option value="Tegalsari">Tegalsari</option>
                        <option value="Wonokromo">Wonokromo</option>
                        <option value="Gubeng">Gubeng</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="filter_periode" class="form-label fs-7 fw-bold text-gray-700 text-uppercase tracking-wide mb-2">
                        Periode
                    </label>
                    <select id="filter_periode" class="form-select form-select-solid fw-semibold">
                        <option value="2025" selected>2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Card Grafik Nilai Rata-rata Remaja -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header bg-light-subtle py-4 px-5 px-lg-7 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h3 class="card-title fw-bolder text-gray-800 fs-5 text-uppercase m-0">
                NILAI RATA - RATA REMAJA
            </h3>
            <span class="badge badge-light-primary fw-bold fs-7 px-3 py-2">
                Periode: 2025
            </span>
        </div>
        <div class="card-body p-4 p-lg-7">
            <!-- Legend Garis Custom (Biru & Merah) -->
            <div class="d-flex align-items-center justify-content-center gap-5 mb-4 fs-7 fw-semibold text-gray-600">
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #0284c7;"></span>
                    <span>Pretest</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #f43f5e;"></span>
                    <span>Posttest</span>
                </div>
            </div>
            <!-- Canvas Grafik Remaja -->
            <div style="position: relative; width: 100%; height: 320px;">
            <canvas id="chartKemanggiRemaja"></canvas>
        </div>
        </div>
    </div>

    <!-- 4. Card Grafik Nilai Rata-rata Orang Tua -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header bg-light-subtle py-4 px-5 px-lg-7 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h3 class="card-title fw-bolder text-gray-800 fs-5 text-uppercase m-0">
                NILAI RATA - RATA ORANG TUA
            </h3>
            <span class="badge badge-light-primary fw-bold fs-7 px-3 py-2">
                Periode: 2025
            </span>
        </div>
        <div class="card-body p-4 p-lg-7">
            <!-- Legend Garis Custom (Biru & Merah) -->
            <div class="d-flex align-items-center justify-content-center gap-5 mb-4 fs-7 fw-semibold text-gray-600">
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #0284c7;"></span>
                    <span>Pretest</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #f43f5e;"></span>
                    <span>Posttest</span>
                </div>
            </div>
            <!-- Canvas Grafik Orang Tua -->
           <div style="position: relative; width: 100%; height: 320px;">
                <canvas id="chartKemanggiOrangTua"></canvas>
            </div>
        </div>
    </div>

    <!-- 5. Card Tabel Rekapitulasi Nilai & Peserta (CRUD) -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header py-5 px-5 px-lg-7 border-0 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h3 class="card-title fw-bolder text-gray-900 fs-5 m-0">
                Tabel Rekapitulasi Nilai &amp; Peserta
            </h3>
            <button type="button" class="btn btn-success fw-bold fs-7 px-4" onclick="openTambahKemangi()">
                <i class="ki-outline ki-plus fs-3 me-1"></i> Tambah Data
            </button>
        </div>
        <div class="card-body pt-0 px-5 px-lg-7 pb-5">
            <div class="row g-3 mb-5">
                <div class="col-12 col-md-3">
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="kmg-filter-kelompok">
                        <option value="">Semua Kelompok</option>
                        <option value="Remaja">Remaja</option>
                        <option value="Orang Tua">Orang Tua</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="kmg-filter-kecamatan">
                        <option value="">Semua Kecamatan</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="kmg-filter-kelurahan" disabled>
                        <option value="">Semua Kelurahan</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select form-select-solid fs-7 fw-semibold" id="kmg-filter-tahun">
                        <option value="">Semua Tahun</option>
                        @for ($t = 2030; $t >= 2024; $t--)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="d-flex flex-stack mb-4">
                <select class="form-select form-select-solid w-75px fs-7 fw-semibold" id="kmg-table-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <div class="d-flex align-items-center">
                    <label class="fs-7 fw-semibold text-gray-700 me-2">Search:</label>
                    <input type="text" id="kmg-input-search" class="form-control form-control-solid w-200px fs-7" />
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-row-dashed fs-7 gy-4 mb-0" id="kmg-table">
                    <thead class="bg-light fw-bold fs-8 text-uppercase border-bottom border-gray-200">
                        <tr>
                            <th class="ps-5 py-3 text-center" style="width: 50px;">No</th>
                            <th class="py-3">Kelompok</th>
                            <th class="py-3">Kecamatan</th>
                            <th class="py-3">Kelurahan</th>
                            <th class="py-3 text-center">Tahun</th>
                            <th class="py-3 text-center">Rata-rata Nilai Pre</th>
                            <th class="py-3 text-center">Rata-rata Nilai Post</th>
                            <th class="py-3 text-center">Jumlah Peserta</th>
                            <th class="pe-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold" id="kmg-tbody">
                        <tr><td colspan="9" class="text-center py-5 text-gray-500">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between pt-5 gap-3">
                <span class="text-gray-600 fs-8 fw-semibold" id="kmg-info"></span>
                <ul class="pagination pagination-sm m-0" id="kmg-pagination"></ul>
            </div>
        </div>
    </div>

</div>

<style>
    /* Teks tabel hitam: judul kolom tebal, isi tabel tipis */
    #kmg-table thead th { color: #000 !important; }
    #kmg-table tbody td { color: #000 !important; }
</style>

<input type="hidden" id="kmg-csrf-token" value="{{ csrf_token() }}">

<!-- Modal Tambah / Edit Kemangi -->
<div class="modal fade" id="modal_kemangi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3" id="kmg-modal-title">Tambah Data Kemangi</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="kmg-form">
                    <input type="hidden" id="kmg-id" />

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELOMPOK <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="kmg-kelompok" name="kelompok" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                <option value="Remaja">Remaja</option>
                                <option value="Orang Tua">Orang Tua</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="kmg-tahun" name="tahun" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                @for ($t = 2024; $t <= 2030; $t++)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KECAMATAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="kmg-modal-kecamatan" name="kecamatan" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">KELURAHAN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="kmg-modal-kelurahan" name="kelurahan" required disabled>
                                <option value="" selected disabled>Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-4">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RATA-RATA NILAI PRE <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="kmg-pre" name="nilai_pre" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">RATA-RATA NILAI POST <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-solid" id="kmg-post" name="nilai_post" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JUMLAH PESERTA <span class="text-danger">*</span></label>
                            <input type="number" min="0" step="1" class="form-control form-control-solid" id="kmg-peserta" name="jumlah_peserta" required />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4">
                        <button type="button" class="btn btn-danger fw-bold px-6" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-4 me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white">
                            <i class="ki-outline ki-check fs-4 me-1 text-white"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Pastikan SweetAlert2 tersedia (dipakai untuk popup sukses/gagal/konfirmasi)
    if (!window.Swal) { document.write('<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"><\/script>'); }
</script>

<script>
(function () {
    let wilayah = {};
    let semuaData = [];
    let page = 1;

    const csrf = document.getElementById('kmg-csrf-token').value;
    const $ = function (id) { return document.getElementById(id); };
    const KOLOM = 9;

    function esc(v) {
        if (v === null || v === undefined) return '';
        return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function angka(v) { return (Number(v) || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

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
    function modal() { return bootstrap.Modal.getOrCreateInstance($('modal_kemangi')); }

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
        isiKecamatan($('kmg-filter-kecamatan'), 'Semua Kecamatan', false);
        $('kmg-filter-kecamatan').addEventListener('change', function () {
            isiKelurahan($('kmg-filter-kelurahan'), this.value, 'Semua Kelurahan', false);
            page = 1; render();
        });
        $('kmg-filter-kelurahan').addEventListener('change', function () { page = 1; render(); });

        isiKecamatan($('kmg-modal-kecamatan'), 'Pilih Kecamatan', true);
        $('kmg-modal-kecamatan').addEventListener('change', function () {
            isiKelurahan($('kmg-modal-kelurahan'), this.value, 'Pilih Kelurahan', true);
        });
    }

    // ---------- Filter + tabel ----------
    function filtered() {
        const kel = $('kmg-filter-kelompok').value;
        const kec = $('kmg-filter-kecamatan').value;
        const lur = $('kmg-filter-kelurahan').value;
        const thn = $('kmg-filter-tahun').value;
        const q = $('kmg-input-search').value.trim().toLowerCase();

        return semuaData.filter(function (r) {
            if (kel && r.kelompok !== kel) return false;
            if (kec && r.kecamatan !== kec) return false;
            if (lur && r.kelurahan !== lur) return false;
            if (thn && String(r.tahun) !== thn) return false;
            if (q) {
                const teks = [r.kelompok, r.kecamatan, r.kelurahan, r.tahun, r.nilai_pre, r.nilai_post, r.jumlah_peserta].join(' ').toLowerCase();
                if (teks.indexOf(q) === -1) return false;
            }
            return true;
        });
    }

    function render() {
        const rows = filtered();
        const perPage = parseInt($('kmg-table-length').value, 10) || 10;
        const totalPage = Math.max(1, Math.ceil(rows.length / perPage));
        if (page > totalPage) page = totalPage;
        const mulai = (page - 1) * perPage;
        const tampil = rows.slice(mulai, mulai + perPage);

        if (!tampil.length) {
            $('kmg-tbody').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center py-5 text-gray-500">Belum ada data tersedia</td></tr>';
        } else {
            $('kmg-tbody').innerHTML = tampil.map(function (r, i) {
                return '<tr>' +
                    '<td class="ps-5 text-center">' + (mulai + i + 1) + '</td>' +
                    '<td><span class="badge badge-light-primary fw-bold">' + esc(r.kelompok) + '</span></td>' +
                    '<td class="fw-bold">' + esc(r.kecamatan) + '</td>' +
                    '<td>' + esc(r.kelurahan) + '</td>' +
                    '<td class="text-center">' + esc(r.tahun) + '</td>' +
                    '<td class="text-center fw-bold" style="color: #0284c7 !important;">' + angka(r.nilai_pre) + '</td>' +
                    '<td class="text-center fw-bold" style="color: #f43f5e !important;">' + angka(r.nilai_post) + '</td>' +
                    '<td class="text-center">' + esc(r.jumlah_peserta) + '</td>' +
                    '<td class="pe-5 text-center text-nowrap">' +
                        '<button class="btn btn-sm btn-icon btn-light-warning me-1 kmg-btn-edit" data-id="' + esc(r.id) + '" title="Edit"><i class="ki-outline ki-pencil fs-5"></i></button>' +
                        '<button class="btn btn-sm btn-icon btn-light-danger kmg-btn-hapus" data-id="' + esc(r.id) + '" title="Hapus"><i class="ki-outline ki-trash fs-5"></i></button>' +
                    '</td></tr>';
            }).join('');
        }

        $('kmg-info').textContent = rows.length
            ? 'Menampilkan ' + (mulai + 1) + ' - ' + (mulai + tampil.length) + ' dari ' + rows.length + ' data'
            : 'Tidak ada data';

        let pg = '<li class="page-item ' + (page === 1 ? 'disabled' : '') + '"><a class="page-link px-3 kmg-page" href="#" data-page="' + (page - 1) + '">&lsaquo;</a></li>';
        for (let p = 1; p <= totalPage; p++) {
            pg += '<li class="page-item ' + (p === page ? 'active' : '') + '"><a class="page-link px-3 kmg-page" href="#" data-page="' + p + '">' + p + '</a></li>';
        }
        pg += '<li class="page-item ' + (page === totalPage ? 'disabled' : '') + '"><a class="page-link px-3 kmg-page" href="#" data-page="' + (page + 1) + '">&rsaquo;</a></li>';
        $('kmg-pagination').innerHTML = pg;
    }

    function loadData() {
        return api('/kemangi-data')
            .then(function (data) { semuaData = data; render(); })
            .catch(function () {
                $('kmg-tbody').innerHTML = '<tr><td colspan="' + KOLOM + '" class="text-center text-danger py-5">Gagal memuat data. Pastikan migrasi sudah dijalankan dan route sudah ditambahkan.</td></tr>';
            });
    }

    ['kmg-filter-kelompok', 'kmg-filter-tahun', 'kmg-table-length'].forEach(function (id) {
        $(id).addEventListener('change', function () { page = 1; render(); });
    });
    $('kmg-input-search').addEventListener('input', function () { page = 1; render(); });

    $('kmg-pagination').addEventListener('click', function (e) {
        const a = e.target.closest('.kmg-page');
        if (!a) return;
        e.preventDefault();
        const p = parseInt(a.dataset.page, 10);
        if (p >= 1) { page = p; render(); }
    });

    $('kmg-tbody').addEventListener('click', function (e) {
        const edit = e.target.closest('.kmg-btn-edit');
        const hapus = e.target.closest('.kmg-btn-hapus');
        if (edit) bukaEdit(edit.dataset.id);
        if (hapus) konfirmasiHapus(hapus.dataset.id);
    });

    // ---------- Form tambah / edit ----------
    function resetForm() {
        $('kmg-form').reset();
        $('kmg-id').value = '';
        isiKecamatan($('kmg-modal-kecamatan'), 'Pilih Kecamatan', true);
        $('kmg-modal-kelurahan').innerHTML = '<option value="" selected disabled>Pilih Kelurahan</option>';
        $('kmg-modal-kelurahan').disabled = true;
    }

    window.openTambahKemangi = function () {
        resetForm();
        $('kmg-modal-title').textContent = 'Tambah Data Kemangi';
        modal().show();
    };

    function bukaEdit(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        resetForm();
        $('kmg-modal-title').textContent = 'Edit Data Kemangi';
        $('kmg-id').value = r.id;
        $('kmg-kelompok').value = r.kelompok;
        $('kmg-tahun').value = String(r.tahun);
        $('kmg-modal-kecamatan').value = r.kecamatan;
        isiKelurahan($('kmg-modal-kelurahan'), r.kecamatan, 'Pilih Kelurahan', true, r.kelurahan);
        $('kmg-pre').value = r.nilai_pre;
        $('kmg-post').value = r.nilai_post;
        $('kmg-peserta').value = r.jumlah_peserta;
        modal().show();
    }

    $('kmg-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const id = $('kmg-id').value;
        const btn = this.querySelector('button[type=submit]');
        btn.disabled = true;

        const fd = new FormData(this);
        let url = '/kemangi-data';
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

    // ---------- Hapus (popup sama seperti modul lain) ----------
    function konfirmasiHapus(id) {
        const r = semuaData.find(function (d) { return String(d.id) === String(id); });
        if (!r) return;
        const nama = r.kelompok + ' - ' + r.kelurahan + ' (' + r.tahun + ')';

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin menghapus ' + nama + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: { confirmButton: 'btn btn-danger fw-bold px-6 me-2', cancelButton: 'btn btn-success fw-bold px-6', popup: 'rounded-4' },
            buttonsStyling: false
        }).then(function (result) {
            if (!result.isConfirmed) return;
            api('/kemangi-data/' + id, { method: 'DELETE' })
                .then(function (res) { sukses(nama + ' berhasil dihapus'); return loadData(); })
                .catch(function (err) { gagal(err.message); });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        api('/kemangi-data/wilayah')
            .then(function (data) { wilayah = data; })
            .catch(function () { gagal('Gagal mengambil data kecamatan/kelurahan dari database.'); })
            .finally(function () { initWilayah(); loadData(); });
    });
})();
</script>
