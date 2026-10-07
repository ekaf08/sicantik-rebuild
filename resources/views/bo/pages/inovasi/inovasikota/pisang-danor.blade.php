
<style>
    .pd-banner {
        background: linear-gradient(135deg, #0d6e66 0%, #0b5e57 100%);
        border-radius: 1rem;
        padding: 1.75rem 1.5rem;
        color: #fff;
    }
    .pd-stat-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 0.85rem;
        padding: 1.1rem;
        cursor: pointer;
        transition: border-color .15s ease, transform .15s ease;
        text-align: left;
        width: 100%;
    }
    .pd-stat-card:hover {
        border-color: #0d9488;
        transform: translateY(-2px);
    }
    .pd-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div id="pisang-danor-root">

    {{-- Header --}}
    <div class="pd-banner mb-5">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <p class="mb-1 text-uppercase" style="font-size: .75rem; letter-spacing: .04em; color: #a7f3e0;">
                    Pokja 3 &middot; Inovasi Kota
                </p>
                <h2 class="text-white mb-1">Pisang Danor</h2>
                <p class="mb-0" style="color: #d1fae5; font-size: .9rem;">
                    Pelatihan Inovasi Pilah Sampah Anorganik dan Organik
                </p>
            </div>
        </div>
    </div>

    {{-- Filter: Kecamatan -> Kelurahan berjenjang --}}
    <div class="row g-3 align-items-end mb-3">
        <div class="col-12 col-md-4">
            <label class="form-label fw-bold fs-7">Kecamatan</label>
            <select id="pd-kecamatan" class="form-select form-select-solid">
                <option value="" selected>- Pilih Kecamatan -</option>
                <option value="wonokromo">Wonokromo</option>
                <option value="gubeng">Gubeng</option>
                <option value="sukolilo">Sukolilo</option>
                <option value="tegalsari">Tegalsari</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label fw-bold fs-7">Kelurahan</label>
            <select id="pd-kelurahan" class="form-select form-select-solid" disabled>
                <option value="" selected>-- Pilih Kelurahan --</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <button id="pd-reset" type="button" class="btn btn-light w-100">Reset</button>
        </div>
        <div class="col-6 col-md-2">
            <button id="pd-filter" type="button" class="btn btn-teal w-100" style="background:#0d9488;color:#fff;">Filter</button>
        </div>
    </div>

    <p class="text-muted fs-8 mb-4">
        <i class="ki-outline ki-information-5 fs-7 me-1"></i>
        Klik salah satu angka di bawah untuk melihat rincian per kelurahan
    </p>

    {{-- Kartu statistik: bisa diklik --}}
    <div class="row g-4 mb-4">

        <div class="col-12 col-md-5">
            <button type="button" class="pd-stat-card d-flex align-items-center gap-4"
                    data-bs-toggle="modal" data-bs-target="#pdModalDetail" data-pd-key="pilah">
                <svg width="76" height="76" viewBox="0 0 76 76" class="flex-shrink-0">
                    <circle cx="38" cy="38" r="30" fill="none" stroke="#e9ecef" stroke-width="10" />
                    <circle cx="38" cy="38" r="30" fill="none" stroke="#0d9488" stroke-width="10"
                            stroke-dasharray="188.5" stroke-dashoffset="128.2"
                            stroke-linecap="round" transform="rotate(-90 38 38)" />
                    <text x="38" y="43" text-anchor="middle" font-size="16" font-weight="700" fill="#1e293b">32%</text>
                </svg>
                <div>
                    <p class="text-muted mb-1 fs-8">Pilah</p>
                    <p class="mb-1 fs-7"><span class="fw-bold" style="color:#0d9488;">784.664</span> sudah</p>
                    <p class="mb-0 fs-7 text-danger">1.671.665 belum</p>
                </div>
            </button>
        </div>

        <div class="col-6 col-md-3">
            <button type="button" class="pd-stat-card"
                    data-bs-toggle="modal" data-bs-target="#pdModalDetail" data-pd-key="bank">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="pd-icon-box" style="background:rgba(13,148,136,.12);">
                        <i class="ki-outline ki-recycle fs-4" style="color:#0d9488;"></i>
                    </div>
                    <span class="text-muted fs-8">Bank Sampah</span>
                </div>
                <p class="fs-2 fw-bold mb-1" style="color:#0d9488;">1.036</p>
                <p class="fs-8 text-muted mb-0">0 belum ada</p>
            </button>
        </div>

        <div class="col-6 col-md-4">
            <button type="button" class="pd-stat-card"
                    data-bs-toggle="modal" data-bs-target="#pdModalDetail" data-pd-key="tonase">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="pd-icon-box" style="background:rgba(217,119,6,.12);">
                        <i class="ki-outline ki-weight fs-4" style="color:#d97706;"></i>
                    </div>
                    <span class="text-muted fs-8">Tonase An-organik</span>
                </div>
                <p class="fs-2 fw-bold mb-0">1.298.156 <span class="fs-8 text-muted fw-normal">Kg</span></p>
            </button>
        </div>

        <div class="col-12">
            <button type="button" class="pd-stat-card"
                    data-bs-toggle="modal" data-bs-target="#pdModalDetail" data-pd-key="paving">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="pd-icon-box" style="background:rgba(219,39,119,.1);">
                            <i class="ki-outline ki-road fs-4" style="color:#db2777;"></i>
                        </div>
                        <span class="fw-bold fs-7">Paving</span>
                    </div>
                    <span class="text-success fs-8">100% biopori</span>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <p class="fs-4 fw-bold mb-0">843 <span class="fs-8 text-muted fw-normal">total</span></p>
                    <div class="flex-grow-1 bg-light rounded-pill" style="height:8px;">
                        <div class="rounded-pill" style="height:8px;width:100%;background:#db2777;"></div>
                    </div>
                    <p class="fs-7 text-success mb-0 text-nowrap">843 sudah</p>
                </div>
            </button>
        </div>

    </div>

</div>

{{-- Modal detail: isinya diisi JS sesuai kartu yang diklik --}}
<div class="modal fade" id="pdModalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h3 id="pdModalTitle" class="modal-title">Rincian</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="pdModalSub" class="text-muted fs-7 mb-4"></p>
                <div class="table-responsive">
                    <table class="table table-row-dashed align-middle">
                        <thead id="pdModalHead"></thead>
                        <tbody id="pdModalBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const kecSelect = document.getElementById('pd-kecamatan');
    const kelSelect = document.getElementById('pd-kelurahan');
    const resetBtn = document.getElementById('pd-reset');
    const modalEl = document.getElementById('pdModalDetail');
    const modalTitle = document.getElementById('pdModalTitle');
    const modalSub = document.getElementById('pdModalSub');
    const modalHead = document.getElementById('pdModalHead');
    const modalBody = document.getElementById('pdModalBody');

    // Hentikan script jika elemen tidak ditemukan, supaya tidak error dan
    // tidak mengganggu script lain di halaman
    if (!kecSelect || !kelSelect || !resetBtn || !modalEl) return;

    // Pindahkan modal ke <body> agar tidak tertimpa backdrop / tersembunyi oleh
    // wrapper induk (d-none, overflow, atau z-index dari layout)
    document.body.appendChild(modalEl);

    // Data kecamatan -> daftar kelurahan (ganti dengan data asli dari backend)
    const kelurahanByKecamatan = {
        wonokromo: ['Ketintang', 'Jagir', 'Wonokromo', 'Sawunggaling'],
        gubeng: ['Airlangga', 'Gubeng', 'Mojo', 'Pucang Sewu'],
        sukolilo: ['Keputih', 'Gebang Putih', 'Klampis Ngasem', 'Medokan Semampir'],
        tegalsari: ['Kedungdoro', 'Tegalsari', 'Wonorejo', 'Keputran']
    };

    kecSelect.addEventListener('change', function () {
        const list = kelurahanByKecamatan[this.value] || [];
        kelSelect.innerHTML = '<option value="" selected>-- Pilih Kelurahan --</option>';
        list.forEach(function (nama) {
            const opt = document.createElement('option');
            opt.value = nama.toLowerCase();
            opt.textContent = nama;
            kelSelect.appendChild(opt);
        });
        kelSelect.disabled = list.length === 0;
    });

    resetBtn.addEventListener('click', function () {
        kecSelect.value = '';
        kelSelect.innerHTML = '<option value="" selected>-- Pilih Kelurahan --</option>';
        kelSelect.disabled = true;
    });

    // Data detail per kartu (ganti dengan data asli dari backend)
    const detail = {
        pilah: {
            title: 'Pilah &mdash; per kelurahan',
            sub: '784.664 sudah dipilah dari total 2.456.329',
            cols: ['Kelurahan', 'Sudah', 'Belum'],
            rows: [
                ['Ketintang', '210.340', '98.120'],
                ['Airlangga', '188.904', '412.655'],
                ['Keputih', '201.110', '540.220'],
                ['Kedungdoro', '184.310', '620.670']
            ]
        },
        bank: {
            title: 'Bank Sampah &mdash; per kelurahan',
            sub: '1.036 unit bank sampah aktif',
            cols: ['Kelurahan', 'Jumlah Unit'],
            rows: [
                ['Ketintang', '312'],
                ['Airlangga', '278'],
                ['Keputih', '245'],
                ['Kedungdoro', '201']
            ]
        },
        tonase: {
            title: 'Tonase An-organik &mdash; per bulan',
            sub: '1.298.156 Kg terkumpul tahun ini',
            cols: ['Bulan', 'Tonase'],
            rows: [
                ['Juli', '98.200 Kg'],
                ['Agustus', '112.450 Kg'],
                ['September', '105.900 Kg'],
                ['Oktober', '41.300 Kg']
            ]
        },
        paving: {
            title: 'Paving &mdash; status biopori',
            sub: '843 titik paving, semua sudah biopori',
            cols: ['Kelurahan', 'Jumlah', 'Sudah Biopori'],
            rows: [
                ['Ketintang', '220', '220'],
                ['Airlangga', '198', '198'],
                ['Keputih', '215', '215'],
                ['Kedungdoro', '210', '210']
            ]
        }
    };

    // Batasi pencarian kartu hanya di dalam #pisang-danor-root
    const root = document.getElementById('pisang-danor-root');
    root.querySelectorAll('[data-pd-key]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const d = detail[this.dataset.pdKey];
            if (!d) return;

            modalTitle.innerHTML = d.title;
            modalSub.textContent = d.sub;
            modalHead.innerHTML = '<tr>' + d.cols.map(function (c) {
                return '<th class="text-muted fs-8">' + c + '</th>';
            }).join('') + '</tr>';
            modalBody.innerHTML = d.rows.map(function (r) {
                return '<tr>' + r.map(function (v) { return '<td class="fs-7">' + v + '</td>'; }).join('') + '</tr>';
            }).join('');
        });
    });
})();
</script>
