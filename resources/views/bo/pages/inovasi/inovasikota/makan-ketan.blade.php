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
    .mk-card-tahun { cursor: pointer; transition: box-shadow .2s ease, transform .15s ease; }
    .mk-card-tahun:hover { transform: translateY(-2px); }
    .mk-card-aktif { box-shadow: 0 0 0 3px rgba(0,0,0,.18), 0 10px 24px -8px rgba(0,0,0,.25) !important; transform: translateY(-2px); }
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

<!-- 2. Header & Tombol Tambah Data -->
<div class="d-flex flex-stack mb-5">
    <div>
        <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Makan Ketan</h2>
    </div>
    <div>
        <button type="button" class="btn btn-success fw-bold px-5" id="mk-btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_makan_ketan">
            <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Makan Ketan
        </button>
    </div>
</div>

<!-- 3. Stat Cards: Total Data per Tahun (dihitung otomatis dari data) -->
<div class="row g-4 mb-6">
    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4 border-primary mk-card-tahun" id="mk-card-2024" onclick="mkFilterTahun('2024')">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold text-gray-900" id="mk-total-2024">0</span>
                </div>
                <div class="symbol symbol-45px symbol-circle bg-light-primary">
                    <span class="symbol-label"><i class="ki-outline ki-calendar text-primary fs-1"></i></span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 bg-light-primary text-center">
                <span class="fs-8 fw-bold text-primary">MAKAN KETAN 2024</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4 mk-card-tahun" id="mk-card-2025" onclick="mkFilterTahun('2025')" style="border-color: #7239ea !important;">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold" style="color: #7239ea;" id="mk-total-2025">0</span>
                </div>
                <div class="symbol symbol-45px symbol-circle" style="background-color: #f8f5ff;">
                    <span class="symbol-label"><i class="ki-outline ki-chart-line-up fs-1" style="color: #7239ea;"></i></span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 text-center" style="background-color: #f8f5ff;">
                <span class="fs-8 fw-bold" style="color: #7239ea;">MAKAN KETAN 2025</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-flush h-100 shadow-sm border-start border-4 border-success mk-card-tahun" id="mk-card-2026" onclick="mkFilterTahun('2026')">
            <div class="card-body p-5 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-gray-500 fw-semibold fs-7 d-block mb-1">TOTAL DATA</span>
                    <span class="fs-2hx fw-bold text-success" id="mk-total-2026">0</span>
                </div>
                <div class="symbol symbol-45px symbol-circle bg-light-success">
                    <span class="symbol-label"><i class="ki-outline ki-verify text-success fs-1"></i></span>
                </div>
            </div>
            <div class="card-footer py-2 px-5 bg-light-success text-center">
                <span class="fs-8 fw-bold text-success">MAKAN KETAN 2026</span>
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
