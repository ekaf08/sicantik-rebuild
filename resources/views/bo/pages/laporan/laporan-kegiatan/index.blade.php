@extends('bo.layout.app')

@section('content')
<style>
    .pkk { --teal:#2fa88f; --teal-dark:#286b83; --teal-deep:#205d73; --ink:#183b49; --muted:#6d8189; --line:#dce9ec; --green:#3fae5f; --purple:#7765d8; --blue:#4a90e2; --toska-cerah:#3FAAB2; --toska-gelap: #2A6B7C; --toska-sedang: #4EA8B0}
    .pkk, .pkk * { box-sizing: border-box; }
    .pkk { color: var(--ink); }

    /* Hero / Header Pelaporan PKK */
    .pkk-hero {
        position:relative; isolation:isolate; display:flex; align-items:center;
        min-height:124px; padding:22px 28px; margin-bottom:0;
        overflow:hidden; border-radius:16px;
        border:1px solid rgba(75,190,190,.16);
        background:linear-gradient(105deg,#e8fbf7 0%,#effcf9 48%,#d8f7f4 100%);
        box-shadow:0 5px 18px rgba(45,157,164,.07);
    }
    .pkk-hero::before {
        content:""; position:absolute; z-index:-1; width:260px; height:260px;
        right:20%; top:-175px; border-radius:50%;
        background:rgba(113,225,218,.13);
    }
    .pkk-hero::after {
        content:""; position:absolute; z-index:-1; width:300px; height:190px;
        right:-70px; bottom:-125px; border-radius:50%;
        background:rgba(76,202,211,.22);
    }
    .pkk-hero-icon {
        width:68px; height:68px; flex:0 0 68px; display:grid; place-items:center;
        margin-right:22px; border-radius:20px;
        color:#078c9a; background:rgba(255,255,255,.68);
        border:1px solid rgba(46,174,184,.18);
        box-shadow:0 5px 14px rgba(31,148,158,.08);
    }
    .pkk-hero-divider { width:2px; height:62px; flex:0 0 2px; margin-right:24px; background:#83d9d7; }
    .pkk-hero-copy { position:relative; z-index:2; min-width:0; }
    .pkk-hero h1 { margin:0 0 7px; font-size:27px; line-height:1.2; font-weight:800; letter-spacing:-.45px; color:#087e91; }
    .pkk-hero p { margin:0; color:#587e89; font-size:14px; line-height:1.5; }
    .pkk-hero-art { position:absolute; z-index:1; right:22px; bottom:-2px; width:230px; height:118px; opacity:.92; pointer-events:none; }
    .pkk-hero-dots { position:absolute; right:22px; top:15px; width:48px; height:34px; opacity:.55;
        background-image:radial-gradient(#fff 2px,transparent 2.5px); background-size:12px 12px; }
    @media (max-width:700px) {
        .pkk-hero { min-height:108px; padding:18px 16px; border-radius:13px; }
        .pkk-hero-icon { width:48px; height:48px; flex-basis:48px; margin-right:12px; border-radius:14px; }
        .pkk-hero-icon svg { width:30px; height:30px; }
        .pkk-hero-divider { height:48px; margin-right:13px; }
        .pkk-hero h1 { font-size:19px; letter-spacing:-.2px; }
        .pkk-hero p { max-width:270px; font-size:12px; }
        .pkk-hero-art { right:-52px; width:150px; opacity:.34; }
        .pkk-hero-dots { right:10px; }
    }

    /* Filter */
    .pkk-filters { display:flex; flex-wrap:wrap; gap:10px; margin:16px 0; }
    .pkk-sel { position:relative; }
    .pkk-sel i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--teal); pointer-events:none; }
    .pkk-filters select { height:42px; padding:0 14px 0 38px; min-width:160px; border:1px solid var(--line); border-radius:9px; background:#fff; color:#46616b; }

    /* Statistik */
    .pkk-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; }
    .pkk-stat { display:flex; gap:14px; align-items:center; padding:18px; border-radius:14px; border:1px solid var(--line); }
    .pkk-stat.s1 { background:#eaf7ef; } .pkk-stat.s2 { background:#f1eefc; }
    .pkk-stat.s3 { background:#e9f2fc; } .pkk-stat.s4 { background:#e6f6f2; }
    .pkk-stat .ic { width:46px; height:46px; border-radius:50%; display:grid; place-items:center; font-size:22px; color:#fff; flex:none; }
    .pkk-stat .ic i { color:#fff; line-height:1; }
    .s1 .ic { background:var(--toska-cerah); } .s2 .ic { background:var(--purple); } .s3 .ic { background:var(--blue); } .s4 .ic { background:var(--teal); }
    .pkk-stat small { color:var(--muted); font-size:12px; display:block; }
    .pkk-stat strong { font-size:26px; line-height:1.2; }
    .pkk-stat .up { font-size:11px; color:var(--green); margin-left:6px; }
    .pkk-stat .down { font-size:11px; color:#d94d6c; margin-left:6px; }

    /* Panel & grafik */

    /* Panel & grafik */
.pkk-panel { background:#fff; border:1px solid var(--line); border-radius:14px; padding:18px; height: 100%; }
.pkk-grid { display:grid; grid-template-columns: 320px 1fr 1fr; gap:14px; margin-top:14px; align-items: stretch; }
.pkk-stat-col { display:flex; flex-direction:column; gap:14px; }
.pkk-stat-col .pkk-stat { flex:1; margin: 0; }   /* dua card sama tinggi, mengisi tinggi baris */   /* dua card sama tinggi, mengisi tinggi baris */
    .pkk-title { font-weight:700; font-size:14px; margin-bottom:14px; display:flex; justify-content:space-between; align-items:center; }
    .pkk-chart { position:relative; height:210px; }
    .pkk-prog { margin:13px 0; }
    .pkk-prog .h { display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px; }
    .pkk-prog .bar { height:8px; background:#edf3f4; border-radius:99px; overflow:hidden; }
    .pkk-prog .bar i { display:block; height:100%; border-radius:99px; background:var(--toska-cerah); }
    .pkk-prog .bar i.mid { background:var(--blue); }

    /* Tabel */
    .pkk-table-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .pkk-table-head h2 { font-size:17px; margin:0; }
    .pkk-btn-main { background:var(--toska-cerah); color:#fff; border:0; border-radius:9px; padding:11px 18px; font-weight:700; }
    .pkk-btn-main:hover { filter:brightness(.95); }
    .pkk-tools { display:flex; flex-wrap:wrap; gap:9px; margin-bottom:14px; }
    .pkk-tools input, .pkk-tools select { height:40px; padding:0 12px; border:1px solid var(--line); border-radius:9px; background:#fff; }
    .pkk-tools .grow { flex:1; min-width:220px; }
    /* Filter: ganti garis hitam saat diklik dengan abu lembut */
    .pkk-tools select, .pkk-tools input, .pkk-filters select {
        outline: none;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .pkk-tools select:hover, .pkk-tools input:hover, .pkk-filters select:hover {
        border-color: #b8c7cc;
    }
    .pkk-tools select:focus, .pkk-tools input:focus, .pkk-filters select:focus,
    .pkk-tools select:focus-visible, .pkk-tools input:focus-visible, .pkk-filters select:focus-visible {
        outline: none;
        border-color: #9db1b8;
        box-shadow: 0 0 0 3px rgba(157, 177, 184, .28);
    }
    .pkk-wrap { overflow-x:auto; }
    .pkk table { width:100%; border-collapse:collapse; font-size:12px; }
    .pkk th { background:#eef7f4; color:#48636d; text-align:left; padding:11px 9px; white-space:nowrap; }
    .pkk td { padding:12px 9px; border-bottom:1px solid #edf2f3; vertical-align:middle; }
    .pkk tr:hover td { background:#fafefd; }
    .pkk .thumb-img { width:64px; height:44px; object-fit:cover; border-radius:6px; display:block; }
    .pkk .abtn { padding:6px 11px; border-radius:7px; font-size:11px; border:1px solid transparent; background:#fff; }
    .pkk .abtn.view { background:var(--toska-cerah); color:#fff; }
    .pkk .abtn.edit { color:var(--green); border-color:#82e795; }
    .pkk .abtn.del  { color:#d94d6c; border-color:#f4c3cf; }
    .pkk .pkk-foot { margin-top:14px; font-size:12px; color:var(--muted); }
    .pkk .pagination { margin:0; }

    /* Preview foto di modal */
    .pkk-prev { width:100%; max-width:260px; background:#fff; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,.15); padding:8px; }
    .pkk-prev img { width:100%; height:190px; object-fit:contain; display:block; }

    @media (max-width:1200px) { .pkk-stats { grid-template-columns:repeat(2,1fr); } .pkk-grid { grid-template-columns:1fr 1fr; } .pkk-grid > :last-child { grid-column:1/-1; } }
    @media (max-width:700px)  { .pkk-stats, .pkk-grid { grid-template-columns:1fr; } }

    /* Efek hover untuk foto thumbnail di tabel */
    .pkk-foto-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
        overflow: hidden;
        border-radius: 6px;
    }
    .pkk-foto-wrapper img {
        display: block;
        transition: filter 0.2s ease;
    }
    .pkk-foto-wrapper .overlay-eye {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 16px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .pkk-foto-wrapper:hover .overlay-eye {
        opacity: 1;
    }
    .pkk-foto-wrapper:hover img {
        filter: brightness(0.8);
    }

        /* Mengubah warna background pagination yang aktif menjadi toska */
    .pagination .page-item.active .page-link {
        background-color: #3FAAB2 !important;
        border-color: #3FAAB2 !important;
        color: #ffffff !important;
    }

    /* Mengubah warna tombol scroll-to-top bawaan Metronic (#kt_scrolltop) */
    #kt_scrolltop {
        background-color: #3FAAB2 !important;
        color: #ffffff !important;
    }
    #kt_scrolltop:hover {
        background-color: #35959c !important;
    }
</style>

<div class="pkk" id="pkk">

    {{-- Hero / Header Pelaporan PKK --}}
    <section class="pkk-hero">
        <div class="pkk-hero-icon" aria-hidden="true">
            <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 5.5H28L37 14.5V31.5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M28 6V15H37" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13 5.5H10.5C8.8 5.5 7.5 6.8 7.5 8.5V38.5C7.5 40.2 8.8 41.5 10.5 41.5H24" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
                <path d="M14 21H27M14 27H23" stroke="#46BFC1" stroke-width="2.6" stroke-linecap="round"/>
                <circle cx="31.5" cy="29.5" r="5.3" fill="#8AE0D7" stroke="#078C9A" stroke-width="2"/>
                <path d="M23.5 40C23.5 35.9 27 33 31.5 33C36 33 39.5 35.9 39.5 40V42H23.5V40Z" fill="#54C9C1" stroke="#078C9A" stroke-width="2" stroke-linejoin="round"/>
                <circle cx="39" cy="32" r="4" fill="#B1EEE4" stroke="#078C9A" stroke-width="1.8"/>
                <path d="M36.5 42V40.5C36.5 38.3 38.1 36.5 40.3 36.5C42.5 36.5 44 38.3 44 40.5V42H36.5Z" fill="#8AE0D7" stroke="#078C9A" stroke-width="1.8" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="pkk-hero-divider" aria-hidden="true"></div>
        <div class="pkk-hero-copy">
            <h1>Pelaporan Kegiatan PKK</h1>
            <p>Bersama dalam data, untuk keluarga yang lebih sejahtera.</p>
        </div>
        <div class="pkk-hero-dots" aria-hidden="true"></div>
        <svg class="pkk-hero-art" viewBox="0 0 250 130" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M74 124V48L126 10L178 48V124" stroke="#50C7C8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M60 52L126 4L192 52" stroke="#50C7C8" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M157 28V13H170V38" fill="#7BDDD9"/>
            <path d="M121 56C114 46 101 51 105 62C108 68 121 76 121 76C121 76 135 68 138 62C142 51 128 46 121 56Z" fill="#8AE3DD" opacity=".85"/>
            <circle cx="104" cy="72" r="11" fill="#75D0E3"/>
            <path d="M87 111V98C87 86 94 81 104 81C114 81 121 86 121 98V124H87V111Z" fill="#70D3E4"/>
            <circle cx="129" cy="65" r="13" fill="#4DBDCB"/>
            <path d="M109 108V92C109 79 117 76 129 76C141 76 149 79 149 92V124H109V108Z" fill="#4DBDCB"/>
            <circle cx="154" cy="73" r="10" fill="#91E1D8"/>
            <path d="M139 108V98C139 87 145 83 154 83C163 83 169 87 169 98V124H139V108Z" fill="#91E1D8"/>
            <path d="M28 125C34 106 43 95 57 89M40 111L30 94M45 103L57 101M196 124C199 104 209 87 223 76M208 99L197 88M213 91L226 91" stroke="#27B9B5" stroke-width="4" stroke-linecap="round"/>
            <path d="M25 125C15 111 12 100 15 88C28 94 35 106 35 119M45 125C44 111 49 101 61 96C65 109 59 119 51 125M202 125C198 110 201 99 211 91C218 103 215 116 209 125M220 111C219 99 225 89 237 85C239 99 232 108 225 113" fill="#6CD7CB" opacity=".9"/>
            <circle cx="205" cy="37" r="4" fill="#7DDDD7"/>
            <circle cx="218" cy="52" r="3" fill="#A2E9E2"/>
        </svg>
    </section>

    {{-- Filter statistik & grafik --}}
    <div class="pkk-filters">
        <div class="pkk-sel"><i class="ki-outline ki-geolocation fs-3"></i>
            <select id="stKec"><option value="">Semua Kecamatan</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-map fs-3"></i>
            <select id="stKel" disabled><option value="">Semua Kelurahan</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-calendar fs-3"></i>
            <select id="stThn">
                <option value="">Semua Tahun</option>
                @for ($y = now()->year; $y >= 2023; $y--)
                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>Tahun {{ $y }}</option>
                @endfor
            </select></div>
        <div class="pkk-sel"><i class="ki-outline ki-calendar-8 fs-3"></i>
            <select id="stBln">
                <option value="">Semua Bulan</option>
                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                    <option value="{{ $index + 1 }}">{{ $bulan }}</option>
                @endforeach
            </select></div>
        <div class="pkk-sel"><i class="ki-outline ki-people fs-3"></i>
            <select id="stPokja">
                <option value="">Semua Pokja</option>
                <option value="1">Pokja 1</option>
                <option value="2">Pokja 2</option>
                <option value="3">Pokja 3</option>
                <option value="4">Pokja 4</option>
                <option value="5">Sekretaris</option>
            </select></div>
    </div>

    {{-- Statistik + Grafik --}}
    <section class="pkk-grid">

        {{-- Kolom 1: 2 Card Statistik Ditumpuk Vertikal --}}
        <div class="pkk-stat-col">
            <div class="pkk-stat s2">
                <div class="ic"><i class="ki-outline ki-calendar-tick fs-2x"></i></div>
                <div>
                    <small id="stBlnLabel">Kegiatan Bulan Ini</small>
                    <strong id="stBlnNilai">0</strong><span id="stBlnPct" class="up"></span>
                    <small>dibanding bulan lalu</small>
                </div>
            </div>

            <div class="pkk-stat s1">
                <div class="ic"><i class="ki-outline ki-calendar-8 fs-2x"></i></div>
                <div>
                    <small>Total Kegiatan</small>
                    <strong id="stTotal">0</strong><span id="stTotalPct" class="up"></span>
                    <small id="stTotalBanding"></small>
                </div>
            </div>
        </div>

        {{-- Kolom 2: Chart per Pokja --}}
        <div class="pkk-panel">
            <div class="pkk-title">Kegiatan per Pokja</div>
            <div class="pkk-chart"><canvas id="chartPokja"></canvas></div>
        </div>

        {{-- Kolom 3: Tren Kegiatan Bulanan --}}
        <div class="pkk-panel">
            <div class="pkk-title">Tren Kegiatan Bulanan</div>
            <div class="pkk-chart"><canvas id="chartTren"></canvas></div>
        </div>

    </section>

    {{-- Tabel (data dari database) --}}
    <section class="pkk-panel" style="margin-top:14px">
        <div class="pkk-table-head">
            <h2>Data Laporan Kegiatan</h2>
        </div>

        <div class="pkk-tools">
            <button type="button" id="btnTambah" class="pkk-btn-main" data-bs-toggle="modal" data-bs-target="#modalTambah">＋ Tambah Laporan Kegiatan</button>
            <input type="text" id="cariLaporan" class="grow" placeholder="Cari kegiatan, tempat, atau nama...">
            <select id="fKec"><option value="">Pilih Kecamatan</option></select>
            <select id="fKel" disabled><option value="">Pilih Kelurahan</option></select>

            <input type="month" id="fBulan">

            <select id="fPokja">
                <option value="">Semua</option>
                <option value="1">Pokja 1</option>
                <option value="2">Pokja 2</option>
                <option value="3">Pokja 3</option>
                <option value="4">Pokja 4</option>
                <option value="5">Sekretaris</option>
            </select>
            <button type="button" id="btnExport" class="pkk-btn-main">Export</button>
        </div>

        <div class="pkk-wrap">
            <table id="tblLaporan">
                <thead>
                    <tr>
                        <th>NO</th><th>Tanggal Kegiatan</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Tempat</th>
                        <th>Deskripsi</th><th>File</th><th>Foto Kegiatan</th><th>Keterangan</th><th>Dibuat Oleh</th><th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

    {{-- Modal: Tambah / Edit --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="#" method="POST" enctype="multipart/form-data" id="formTambah" class="d-flex flex-column overflow-hidden">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title">Tambah Data Kegiatan</h3>
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal" aria-label="Tutup">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </button>
                    </div>

                    <div class="modal-body" style="overflow-y:auto">
                        <div class="mb-6">
                            <label class="form-label required">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal" class="form-control form-control-solid" required>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Pokja</label>
                            <select name="pokja" id="selPokja" class="form-select form-select-solid" required>
                                <option value="">- Pilih Pokja -</option>
                                <option value="1">Pokja 1</option>
                                <option value="2">Pokja 2</option>
                                <option value="3">Pokja 3</option>
                                <option value="4">Pokja 4</option>
                                <option value="5">Sekretaris</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Jenis Kegiatan</label>
                            <select name="kegiatan_id" id="selKegiatan" class="form-select form-select-solid" required>
                                <option value="">- Pilih Kegiatan -</option>
                                @foreach($kegiatan as $k)
                                    <option value="{{ $k->kegiatan_id }}">{{ $k->kegiatan_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Jenis Sub Kegiatan</label>
                            <select name="sub_kegiatan_id" id="selSub" class="form-select form-select-solid" required>
                                <option value="">Pilih Pokja dan Jenis Kegiatan terlebih dahulu</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Tempat Kegiatan</label>
                            <input type="text" name="tempat" class="form-control form-control-solid">
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Jam Kegiatan</label>
                            <input type="time" name="jam" class="form-control form-control-solid">
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Apakah Ada Notulen ?</label>
                            <select name="notulen" id="selNotulen" class="form-select form-select-solid">
                                <option value="">- Pilih Jawaban -</option>
                                <option value="1">Ada</option>
                                <option value="0">Tidak Ada</option>
                            </select>
                        </div>

                        {{-- Muncul hanya kalau notulen = Ada --}}
                        <div id="blkNotulen" class="d-none">
                            <div class="mb-6">
                                <label class="form-label">Nama Notulen</label>
                                <input type="text" name="nama_notulen" id="inpNamaNotulen" class="form-control form-control-solid">
                            </div>
                            <div class="mb-6">
                                <label class="form-label">File Notulen</label>
                                <input type="file" name="file_notulen" class="form-control form-control-solid pkk-file" accept=".jpg,.jpeg,.png,.pdf">
                                <div class="text-danger fs-8 mt-2">File harus di bawah 2MB dan berformat jpg, png, atau pdf.</div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">File Absensi</label>
                            <input type="file" name="file_absensi" class="form-control form-control-solid pkk-file" accept=".jpg,.jpeg,.png, .pdf">
                            <div class="text-danger fs-8 mt-2">File harus di bawah 2MB dan berformat jpg, png, atau pdf.</div>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-solid" rows="5"></textarea>
                        </div>

                        {{-- Preview Foto Kegiatan --}}
                        <div class="mb-6">
                            <label class="form-label">Preview Foto Kegiatan</label>
                            @foreach([1, 2, 3] as $n)
                                <div class="pkk-prev mb-4">
                                    <img id="prev_{{ $n }}" alt="Preview foto {{ $n }}"
                                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'><rect width='200' height='150' fill='white'/><circle cx='70' cy='55' r='14' fill='%23c9c9c9'/><path d='M40 115l35-40 25 28 20-18 40 30z' fill='%23c9c9c9'/></svg>">
                                </div>
                            @endforeach
                        </div>

                        {{-- Upload Foto Kegiatan --}}
                        @foreach([1, 2, 3] as $n)
                            <div class="mb-6">
                                <label class="form-label">Foto Kegiatan {{ $n }}</label>
                                <input type="file" name="foto_{{ $n }}" class="form-control form-control-solid pkk-file pkk-foto" data-target="prev_{{ $n }}" accept=".jpg,.jpeg,.png">
                                <div class="text-danger fs-8 mt-2">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                            </div>
                        @endforeach

                        <div class="mb-2">
                            <label class="form-label">File Undangan</label>
                            <input type="file" name="file_undangan" class="form-control form-control-solid pkk-file" accept=".jpg,.jpeg,.png,.pdf">
                            <div class="text-danger fs-8 mt-2">File harus di bawah 2MB. Dan dilarang upload foto selfie</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Viewer File -->
    <div class="modal fade" id="modalViewFile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Detail File</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal" aria-label="Tutup">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body text-center" style="height: 500px; padding: 0;">
                    <!-- Elemen untuk menampilkan file PDF/Gambar -->
                    <iframe id="iframeViewer" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Viewer Foto (Panjang ke bawah seperti referensi) -->
    <div class="modal fade" id="modalViewFoto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Detail Gambar</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal" aria-label="Tutup">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
                <div class="modal-body text-center p-4">
                    <img id="imgViewer" src="" alt="Detail Foto" style="width: 100%; height: auto; border-radius: 8px; object-fit: contain;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>

function bukaViewerFile(urlFile) {
    var iframe = document.getElementById('iframeViewer');
    iframe.src = urlFile;
    var modalFile = new bootstrap.Modal(document.getElementById('modalViewFile'));
    modalFile.show();
}

// Fungsi khusus untuk membuka modal foto (gambar memanjang ke bawah)
function bukaViewerFoto(urlFoto) {
    var img = document.getElementById('imgViewer');
    img.src = urlFoto;
    var modalFoto = new bootstrap.Modal(document.getElementById('modalViewFoto'));
    modalFoto.show();
}

document.addEventListener('DOMContentLoaded', function () {

    var CSRF      = '{{ csrf_token() }}';
    var STORE_URL = "{{ route('laporan-kegiatan.store') }}";
    var SUB_URL   = "{{ url('laporan-kegiatan/sub') }}";

    var form        = document.getElementById('formTambah');
    var modalEl     = document.getElementById('modalTambah');
    var modal       = bootstrap.Modal.getOrCreateInstance(modalEl);
    var selPokja    = document.getElementById('selPokja');
    var selKegiatan = document.getElementById('selKegiatan');
    var selSub      = document.getElementById('selSub');
    var selNotulen  = document.getElementById('selNotulen');
    var blkNotulen  = document.getElementById('blkNotulen');
    var fKec        = document.getElementById('fKec');
    var fKel        = document.getElementById('fKel');
    var fBulan      = document.getElementById('fBulan');
    var fPokja      = document.getElementById('fPokja');
    var EXPORT_URL  = "{{ route('laporan-kegiatan.export') }}";
    var updateUrl   = null;   // null = mode tambah, berisi URL = mode edit

    /* ---------- Bersihkan iframe saat modal ditutup ---------- */
    document.getElementById('modalViewFile').addEventListener('hidden.bs.modal', function () {
        document.getElementById('iframeViewer').src = '';
    });

    document.getElementById('modalViewFoto').addEventListener('hidden.bs.modal', function () {
    document.getElementById('imgViewer').src = '';
    });

    function notif(msg, type) {
        if (window.Swal) { Swal.fire({ text: msg, icon: type, confirmButtonText: 'OK' }); }
        else { alert(msg); }
    }

    // setara htmlspecialchars: ubah < > & " ' menjadi teks biasa
    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    /* ---------- Notulen: blok nama + file muncul kalau "Ada" ---------- */
    function toggleNotulen() {
        var ada = selNotulen.value === '1';
        blkNotulen.classList.toggle('d-none', !ada);
        document.getElementById('inpNamaNotulen').required = ada;
    }
    selNotulen.addEventListener('change', toggleNotulen);

    /* ---------- Sub kegiatan di FORM mengikuti Pokja + Jenis Kegiatan ---------- */
    function resetSub() {
        selSub.innerHTML = '<option value="">Pilih Pokja dan Jenis Kegiatan terlebih dahulu</option>';
        selSub.disabled = true;
    }

    function loadSub(kegiatanId, pokja, terpilih) {
        if (!kegiatanId || !pokja) { resetSub(); return Promise.resolve(); }
        selSub.disabled = true;
        selSub.innerHTML = '<option value="">- Pilih Sub Kegiatan -</option>';
        return fetch(SUB_URL + '/' + kegiatanId + '?pokja=' + encodeURIComponent(pokja), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (list) {
                if (!list.length) {
                    selSub.innerHTML = '<option value="">Tidak ada sub kegiatan untuk pilihan ini</option>';
                    return;
                }
                list.forEach(function (s) { selSub.add(new Option(s.sub_kegiatan_nama, s.sub_kegiatan_id)); });
                selSub.disabled = false;
                if (terpilih) { selSub.value = terpilih; }
            });
    }
    function refreshSub() { loadSub(selKegiatan.value, selPokja.value); }
    selPokja.addEventListener('change', refreshSub);
    selKegiatan.addEventListener('change', refreshSub);

    /* ---------- Filter wilayah: Kecamatan lalu Kelurahan ---------- */
    var WILAYAH_URL = "{{ url('laporan-kegiatan/wilayah') }}";

    fetch(WILAYAH_URL + '/kecamatan', { headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (list) {
            list.forEach(function (k) { fKec.add(new Option(k.nama_kec, k.id_kec)); });
        });

    fKec.addEventListener('change', function () {
        fKel.innerHTML = '<option value="">Pilih Kelurahan</option>';
        fKel.disabled = true;
        if (this.value) {
            fetch(WILAYAH_URL + '/kelurahan/' + this.value, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (list) {
                    list.forEach(function (k) { fKel.add(new Option(k.nama_kel, k.id_kel)); });
                    fKel.disabled = false;
                });
        }
        tabel.draw();
    });


    /* ---------- Validasi ukuran file 2MB ---------- */
    document.querySelectorAll('.pkk-file').forEach(function (inp) {
        inp.addEventListener('change', function () {
            var f = this.files[0];
            if (!f) { return; }

            // cek ekstensi sesuai atribut accept (accept saja bisa dilewati lewat "All files")
            var boleh = (this.getAttribute('accept') || '').split(',')
                .map(function (x) { return x.trim().toLowerCase(); }).filter(Boolean);
            var ext = '.' + f.name.split('.').pop().toLowerCase();
            if (boleh.length && boleh.indexOf(ext) === -1) {
                alert('Format file tidak diizinkan. Gunakan: ' + boleh.join(', ').replace(/\./g, ''));
                this.value = '';
                if (this.dataset.target) { var im = document.getElementById(this.dataset.target); if (im && defaults[this.dataset.target]) { im.src = defaults[this.dataset.target]; } }
                return;
            }

            if (f.size > 2 * 1024 * 1024) {
                alert('Ukuran file melebihi 2MB.');
                this.value = '';
            }
        });
    });

    /* ---------- Preview foto ---------- */
    var defaults = {};
    document.querySelectorAll('.pkk-foto').forEach(function (inp) {
        var img = document.getElementById(inp.dataset.target);
        if (!img) { return; }
        defaults[inp.dataset.target] = img.src;
        inp.addEventListener('change', function () {
            var f = this.files[0];
            img.src = f ? URL.createObjectURL(f) : defaults[this.dataset.target];
        });
    });

    function resetPreview() {
        Object.keys(defaults).forEach(function (id) { document.getElementById(id).src = defaults[id]; });
    }

    /* ---------- DataTable ---------- */
    var tabel = $('#tblLaporan').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        dom: 't<"pkk-foot d-flex justify-content-between align-items-center"ip>',
        ajax: {
            url: "{{ route('laporan-kegiatan.index') }}",
            data: function (d) {
                d.kecamatan = fKec.value;
                d.kelurahan = fKel.value;
                d.bulan     = fBulan.value;
                d.pokja     = fPokja.value;
            }
        },
        columns: [
            { data: 'DT_RowIndex',     searchable: false },
            { data: 'tanggal_fmt',     searchable: false },
            { data: 'jenis',           searchable: false },
            { data: 'sub',             searchable: false },
            { data: 'tempat',          searchable: false },
            { data: 'deskripsi_short', searchable: false },
            { data: 'jumlah_file',     searchable: false },
            { data: 'foto_thumb',      searchable: false },
            { data: 'keterangan',      searchable: false },
            { data: 'oleh',            searchable: false },
            { data: 'action',          searchable: false }
        ],
        language: {
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty: 'Belum ada data',
            emptyTable: 'Belum ada laporan kegiatan',
            processing: 'Memuat...',
            paginate: { previous: '‹', next: '›' }
        }
    });

    var timer;
    document.getElementById('cariLaporan').addEventListener('keyup', function () {
        var v = this.value;
        clearTimeout(timer);
        timer = setTimeout(function () { tabel.search(v).draw(); }, 350);
    });

    [fKel, fBulan, fPokja].forEach(function (el) {
        el.addEventListener('change', function () { tabel.draw(); });
    });

    // Export mengikuti filter yang sedang aktif
    document.getElementById('btnExport').addEventListener('click', function () {
        var p = new URLSearchParams({
            kecamatan: fKec.value, kelurahan: fKel.value, bulan: fBulan.value,
            pokja: fPokja.value,
            q: document.getElementById('cariLaporan').value
        });
        window.location = EXPORT_URL + '?' + p.toString();
    });

    /* ---------- Batas tanggal: H-7 sampai hari ini ---------- */
    function batasTanggal() {
        var fmt = function (d) {
            var m = d.getMonth() + 1, dd = d.getDate();
            return d.getFullYear() + '-' + (m < 10 ? '0' : '') + m + '-' + (dd < 10 ? '0' : '') + dd;
        };
        var hariIni = new Date();
        var h7 = new Date();
        h7.setDate(h7.getDate() - 7);

        form.tanggal.max = fmt(hariIni);
        form.tanggal.min = fmt(h7);
    }

    /* ---------- Tombol Tambah ---------- */
      document.getElementById('btnTambah').addEventListener('click', function () {
      updateUrl = null;
      modalEl.querySelector('.modal-title').textContent = 'Tambah Data Kegiatan';
      batasTanggal();
      toggleNotulen();
  });

    /* ---------- Isi form untuk Edit ---------- */
    function isiForm(d) {
        form.tanggal.value = d.tanggal;
        form.pokja.value   = d.pokja || '';
        form.kegiatan_id.value = d.kegiatan_id || '';
        form.tempat.value  = d.tempat || '';
        form.jam.value     = d.jam || '';
        form.notulen.value = d.notulen ? '1' : '';
        form.nama_notulen.value = d.nama_notulen || '';
        form.deskripsi.value = d.deskripsi || '';
        toggleNotulen();
        [1, 2, 3].forEach(function (n) {
            if (d['foto_' + n + '_url']) { document.getElementById('prev_' + n).src = d['foto_' + n + '_url']; }
        });
        return loadSub(d.kegiatan_id, d.pokja, d.sub_kegiatan_id);
    }

    /* ---------- Tombol di tabel ---------- */
    document.getElementById('tblLaporan').addEventListener('click', function (e) {
        var b;

        // EDIT
        if ((b = e.target.closest('.btn-edit'))) {
            fetch(b.dataset.show, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.status !== 'success') { return notif(res.message, 'error'); }
                    form.reset();
                    resetPreview();
                    updateUrl = res.update_url;
                    modalEl.querySelector('.modal-title').textContent = 'Edit Data Kegiatan';
                    batasTanggal();
                    isiForm(res.data).then(function () { modal.show(); });
                });
        }

        // LIHAT
        if ((b = e.target.closest('.btn-lihat'))) {
            var row = tabel.row($(b).closest('tr')).data();
            fetch(b.dataset.show, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.status !== 'success') { return notif(res.message, 'error'); }
                    var d = res.data;
                    var html = '<div style="text-align:left;font-size:13px;line-height:1.8">'
                        + '<b>Tanggal:</b> ' + row.tanggal_fmt + ' ' + esc(d.jam) + '<br>'
                        + '<b>Pokja:</b> ' + esc(d.pokja || '-') + '<br>'
                        + '<b>Jenis:</b> ' + row.jenis + ' / ' + row.sub + '<br>'
                        + '<b>Tempat:</b> ' + row.tempat + '<br>'
                        + '<b>Notulen:</b> ' + (d.notulen ? esc(d.nama_notulen || 'Ada') : '-') + '<br>'
                        + '<b>Deskripsi:</b> ' + esc(d.deskripsi || '-') + '<br>';
                    if (d.file_notulen_url)  { html += '<a href="' + esc(d.file_notulen_url) + '" target="_blank">Lihat file notulen</a><br>'; }
                    if (d.file_absensi_url)  { html += '<a href="' + esc(d.file_absensi_url) + '" target="_blank">Lihat file absensi</a><br>'; }
                    if (d.file_undangan_url) { html += '<a href="' + esc(d.file_undangan_url) + '" target="_blank">Lihat file undangan</a><br>'; }
                    [1, 2, 3].forEach(function (n) {
                        if (d['foto_' + n + '_url']) {
                            html += '<img src="' + esc(d['foto_' + n + '_url']) + '" style="width:100%;margin-top:8px;border-radius:6px">';
                        }
                    });
                    html += '</div>';
                    if (window.Swal) { Swal.fire({ title: 'Detail Kegiatan', html: html, confirmButtonText: 'Tutup' }); }
                    else { alert(row.sub + ' - ' + row.tempat); }
                });
        }

        // HAPUS
        if ((b = e.target.closest('.btn-hapus'))) {
            var hapus = function () {
                var fd = new FormData();
                fd.append('_method', 'DELETE');
                fd.append('_token', CSRF);
                fetch(b.dataset.url, { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        notif(res.message, res.status === 'success' ? 'success' : 'error');
                        tabel.ajax.reload(null, false);
                        muatStatistik();
                    });
            };
            if (window.Swal) {
                Swal.fire({ text: 'Hapus laporan ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' })
                    .then(function (r) { if (r.isConfirmed) { hapus(); } });
            } else if (confirm('Hapus laporan ini?')) { hapus(); }
        }
    });

    /* ---------- Simpan (tambah / edit) ---------- */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var fd  = new FormData(form);
        var url = STORE_URL;
        if (updateUrl) { fd.append('_method', 'PUT'); url = updateUrl; }

        var btn = form.querySelector('[type=submit]');
        btn.disabled = true;

        fetch(url, { method: 'POST', body: fd, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } })
            .then(function (r) {
                return r.text().then(function (t) {
                    var j = null;
                    try { j = JSON.parse(t); }
                    catch (err) {
                        var i = t.indexOf('{');
                        if (i > -1) { try { j = JSON.parse(t.substring(i)); } catch (err2) {} }
                    }
                    if (!j) {
                        console.error('Respon server:', t);
                        j = { message: 'Respon server tidak valid: ' + t.substring(0, 300) };
                    }
                    return { ok: r.ok && !!j.status, status: r.status, j: j };
                });
            })
            .then(function (res) {
                btn.disabled = false;
                if (res.ok) {
                modal.hide();
                tabel.ajax.reload(null, false);
                muatStatistik();
                notif(res.j.message, 'success');
                } else if (res.status === 422 && res.j.errors) {
                    notif(Object.values(res.j.errors).flat().join('\n'), 'error');
                } else {
                    notif(res.j.message || 'Terjadi kesalahan di server.', 'error');
                }
            })
            .catch(function (err) {
                btn.disabled = false;
                console.error(err);
                notif('Terjadi kesalahan: ' + err.message, 'error');
            });
    });

    /* ---------- Reset saat modal ditutup ---------- */
    modalEl.addEventListener('hidden.bs.modal', function () {
        form.reset();
        updateUrl = null;
        resetSub();
        resetPreview();
        toggleNotulen();
    });

    /* ---------- Statistik & grafik: mengikuti 5 filter paling atas ---------- */
    var stKec   = document.getElementById('stKec');
    var stKel   = document.getElementById('stKel');
    var stThn   = document.getElementById('stThn');
    var stBln   = document.getElementById('stBln');
    var stPokja = document.getElementById('stPokja');
    var STAT_URL = "{{ route('laporan-kegiatan.statistik') }}";
    var cPokja = null, cTren = null;   // diisi saat grafik dibuat di bawah
    var WARNA_POKJA = ['#3fae5f', '#7765d8', '#4a90e2', '#2fc4b2', '#f6993f'];
    var NAMA_BLN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    fetch(WILAYAH_URL + '/kecamatan', { headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (list) {
            list.forEach(function (k) { stKec.add(new Option(k.nama_kec, k.id_kec)); });
        });

    stKec.addEventListener('change', function () {
        stKel.innerHTML = '<option value="">Semua Kelurahan</option>';
        stKel.disabled = true;
        if (this.value) {
            fetch(WILAYAH_URL + '/kelurahan/' + this.value, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (list) {
                    list.forEach(function (k) { stKel.add(new Option(k.nama_kel, k.id_kel)); });
                    stKel.disabled = false;
                });
        }
        muatStatistik();
    });

    [stKel, stThn, stBln, stPokja].forEach(function (el) {
        el.addEventListener('change', muatStatistik);
    });

    function tampilPersen(id, persen) {
        var el = document.getElementById(id);
        if (persen === null || persen === undefined) { el.className = 'up'; el.textContent = ''; return; }
        var naik = persen >= 0;
        el.className = naik ? 'up' : 'down';
        el.textContent = (naik ? '↑ ' : '↓ ') + Math.abs(persen) + '%';
    }

    function muatStatistik() {
        var p = new URLSearchParams({
            kecamatan: stKec.value, kelurahan: stKel.value,
            tahun: stThn.value, bulan: stBln.value, pokja: stPokja.value
        });

        fetch(STAT_URL + '?' + p.toString(), { cache: 'no-store', headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                document.getElementById('stTotal').textContent = d.total.nilai;
                tampilPersen('stTotalPct', d.total.persen);
                document.getElementById('stTotalBanding').textContent = d.total.banding ? 'dibanding ' + d.total.banding : '';

                document.getElementById('stBlnNilai').textContent = d.bulan_ini.nilai;
                tampilPersen('stBlnPct', d.bulan_ini.persen);
                document.getElementById('stBlnLabel').textContent = 'Kegiatan Bulan ' + NAMA_BLN[d.bulan_ini.bulan - 1] + ' ' + d.bulan_ini.tahun;

                if (cPokja) {
                    cPokja.data.datasets[0].data = d.per_pokja;
                    cPokja.data.datasets[0].backgroundColor = WARNA_POKJA.map(function (w, i) {
                        return (!stPokja.value || stPokja.value == (i + 1)) ? w : '#d5dde0';
                    });
                    cPokja.update();
                }

                if (cTren) {
                    cTren.data.datasets[0].label = String(d.tren.tahun);
                    cTren.data.datasets[0].data  = d.tren.ini;
                    cTren.data.datasets[1].label = String(d.tren.lalu);
                    cTren.data.datasets[1].data  = d.tren.sebelumnya;
                    cTren.update();
                }
            })
            .catch(function (err) { console.error('Statistik gagal dimuat:', err); });
    }

    muatStatistik();

    /* ---------- Grafik (data contoh) ---------- */
    if (typeof Chart === 'undefined') { return; }

    cPokja = new Chart(document.getElementById('chartPokja'), {
        type: 'bar',
        data: {
            labels: ['Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4', 'Sekretaris'],
            datasets: [{ data: [0, 0, 0, 0, 0], backgroundColor: WARNA_POKJA, borderRadius: 6, maxBarThickness: 44 }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef3f4' } }, x: { grid: { display: false } } } }
    });

    cTren = new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { label: '', data: [], borderColor: '#3FAAB2', backgroundColor: 'rgba(63,174,95,.12)', fill: true, tension: .3, pointRadius: 3 },
                { label: '', data: [], borderColor: '#b7a9ec', tension: .3, pointRadius: 3 }
            ]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 8, usePointStyle: true } } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#eef3f4' } }, x: { grid: { display: false } } } }
    });
});
</script>
@endsection
