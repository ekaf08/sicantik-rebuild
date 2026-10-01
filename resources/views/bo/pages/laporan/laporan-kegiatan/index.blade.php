@extends('bo.layout.app')

@section('content')
<style>
    .pkk { --teal:#2fa88f; --teal-dark:#286b83; --teal-deep:#205d73; --ink:#183b49; --muted:#6d8189; --line:#dce9ec; --green:#3fae5f; --purple:#7765d8; --blue:#4a90e2; }
    .pkk, .pkk * { box-sizing: border-box; }
    .pkk { color: var(--ink); }

    /* Hero */
    .pkk-hero { position:relative; overflow:hidden; border-radius:16px; padding:26px 30px; min-height:112px;
        background:linear-gradient(100deg,#dff3e6,#eaf7f1 55%,#d3ece7); }
    .pkk-hero h1 { margin:0 0 6px; font-size:28px; font-weight:800; color:var(--teal-deep); }
    .pkk-hero p { margin:0; color:#54737c; font-size:14px; }
    .pkk-hero .art { position:absolute; right:24px; top:-18px; font-size:120px; opacity:.16; color:var(--teal-dark); line-height:1; }

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
    .s1 .ic { background:var(--green); } .s2 .ic { background:var(--purple); } .s3 .ic { background:var(--blue); } .s4 .ic { background:var(--teal); }
    .pkk-stat small { color:var(--muted); font-size:12px; display:block; }
    .pkk-stat strong { font-size:26px; line-height:1.2; }
    .pkk-stat .up { font-size:11px; color:var(--green); margin-left:6px; }

    /* Panel & grafik */
    .pkk-panel { background:#fff; border:1px solid var(--line); border-radius:14px; padding:18px; }
    .pkk-grid { display:grid; grid-template-columns:1fr 1.3fr 1fr; gap:14px; margin-top:14px; }
    .pkk-title { font-weight:700; font-size:14px; margin-bottom:14px; display:flex; justify-content:space-between; align-items:center; }
    .pkk-chart { position:relative; height:210px; }
    .pkk-prog { margin:13px 0; }
    .pkk-prog .h { display:flex; justify-content:space-between; font-size:12px; margin-bottom:5px; }
    .pkk-prog .bar { height:8px; background:#edf3f4; border-radius:99px; overflow:hidden; }
    .pkk-prog .bar i { display:block; height:100%; border-radius:99px; background:var(--green); }
    .pkk-prog .bar i.mid { background:var(--blue); }

    /* Tabel */
    .pkk-table-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .pkk-table-head h2 { font-size:17px; margin:0; }
    .pkk-btn-main { background:var(--green); color:#fff; border:0; border-radius:9px; padding:11px 18px; font-weight:700; }
    .pkk-btn-main:hover { filter:brightness(.95); }
    .pkk-tools { display:flex; flex-wrap:wrap; gap:9px; margin-bottom:14px; }
    .pkk-tools input, .pkk-tools select { height:40px; padding:0 12px; border:1px solid var(--line); border-radius:9px; background:#fff; }
    .pkk-tools .grow { flex:1; min-width:220px; }
    .pkk-wrap { overflow-x:auto; }
    .pkk table { width:100%; border-collapse:collapse; font-size:12px; }
    .pkk th { background:#eef7f4; color:#48636d; text-align:left; padding:11px 9px; white-space:nowrap; }
    .pkk td { padding:12px 9px; border-bottom:1px solid #edf2f3; vertical-align:middle; }
    .pkk tr:hover td { background:#fafefd; }
    .pkk .thumb { width:44px; height:36px; border-radius:6px; background:linear-gradient(135deg,#bfe3d4,#8fc2d4); display:block; }
    .pkk .abtn { padding:6px 11px; border-radius:7px; font-size:11px; border:1px solid transparent; background:#fff; }
    .pkk .abtn.view { background:var(--green); color:#fff; }
    .pkk .abtn.edit { color:#6655bd; border-color:#cfc6f5; }
    .pkk .abtn.del  { color:#d94d6c; border-color:#f4c3cf; }
    .pkk-foot { display:flex; justify-content:space-between; align-items:center; margin-top:14px; font-size:12px; color:var(--muted); flex-wrap:wrap; gap:8px; }
    .pkk-page { display:flex; gap:6px; }
    .pkk-page button { width:30px; height:30px; border-radius:7px; border:1px solid var(--line); background:#fff; }
    .pkk-page button.on { background:var(--green); color:#fff; border-color:var(--green); }

    /* Drawer tambah laporan */
    .pkk-overlay { position:fixed; inset:0; background:rgba(15,40,50,.35); opacity:0; pointer-events:none; transition:opacity .2s; z-index:1090; }
    .pkk-drawer { position:fixed; top:0; right:0; bottom:0; width:400px; max-width:100%; background:#fff; padding:24px; overflow:auto;
        transform:translateX(100%); transition:transform .25s; z-index:1100; box-shadow:-10px 0 35px rgba(25,73,88,.16); }
    .pkk-open .pkk-overlay { opacity:1; pointer-events:auto; }
    .pkk-open .pkk-drawer { transform:none; }
    .pkk-drawer h2 { font-size:18px; margin:0; }
    .pkk-drawer .sub { font-size:12px; color:var(--muted); margin:5px 0 20px; }
    .pkk-field { margin-bottom:14px; }
    .pkk-field label { display:block; font-size:12px; font-weight:700; margin-bottom:6px; }
    .pkk-field input[type=text], .pkk-field input[type=date], .pkk-field select, .pkk-field textarea {
        width:100%; padding:10px 11px; border:1px solid var(--line); border-radius:9px; background:#fff; }
    .pkk-field textarea { height:95px; resize:vertical; }
    .pkk-field .req { color:#e55; }
    .pkk-upload { display:block; border:1.5px dashed #b9d4d9; border-radius:10px; padding:20px; text-align:center; color:var(--muted); font-size:12px; cursor:pointer; }
    .pkk-upload input { display:none; }
    .pkk-notice { background:#eaf8f5; color:#31766c; padding:12px; border-radius:9px; font-size:11px; line-height:1.5; margin:16px 0; }
    .pkk-save { width:100%; background:var(--green); color:#fff; border:0; padding:12px; border-radius:9px; font-weight:700; }
    .pkk-cancel { width:100%; background:#fff; color:var(--teal-dark); border:1px solid var(--teal); padding:11px; border-radius:9px; margin-top:9px; }

    .pkk-prev { width:100%; max-width:260px; background:#fff; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,.15); padding:8px; }
    .pkk-prev img { width:100%; height:190px; object-fit:contain; display:block; }
    .pkk-prev { width:100%; max-width:260px; background:#fff; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,.15); padding:8px; }
    .pkk-prev img { width:100%; height:190px; object-fit:contain; display:block; }

    @media (max-width:1200px) { .pkk-stats { grid-template-columns:repeat(2,1fr); } .pkk-grid { grid-template-columns:1fr 1fr; } .pkk-grid > :last-child { grid-column:1/-1; } }
    @media (max-width:700px)  { .pkk-stats, .pkk-grid { grid-template-columns:1fr; } }

</style>

<div class="pkk" id="pkk">

    {{-- Hero --}}
    <section class="pkk-hero">
        <div class="art">⌂</div>
        <h1>Pelaporan Kegiatan PKK</h1>
        <p>Bersama dalam data, untuk keluarga yang lebih sejahtera</p>
    </section>

    {{-- Filter --}}
    <div class="pkk-filters">
        <div class="pkk-sel">
            <i class="ki-outline ki-geolocation fs-3"></i>
            <select><option>Kota Surabaya</option><option>Kecamatan</option></select>
        </div>
        <div class="pkk-sel">
            <i class="ki-outline ki-map fs-3"></i>
            <select><option>Kelurahan</option><option>Wiyung</option></select>
        </div>
        <div class="pkk-sel">
            <i class="ki-outline ki-calendar fs-3"></i>
            <select><option>Tahun 2026</option><option>Tahun 2025</option></select>
        </div>
        <div class="pkk-sel">
            <i class="ki-outline ki-calendar-8 fs-3"></i>
            <select><option>Bulan September</option><option>Semua Bulan</option></select>
        </div>
        <div class="pkk-sel">
            <i class="ki-outline ki-people fs-3"></i>
            <select><option>Pokja Semua</option><option>Pokja 1</option><option>Pokja 2</option><option>Pokja 3</option><option>Pokja 4</option></select>
        </div>
    </div>

    {{-- Statistik --}}
    <section class="pkk-stats">
        <div class="pkk-stat s1"><div class="ic">▣</div><div><small>Total Kegiatan</small><strong>248</strong><span class="up">↑ 12%</span><small>dibanding bulan lalu</small></div></div>
        <div class="pkk-stat s2"><div class="ic">◷</div><div><small>Kegiatan Bulan Ini</small><strong>87</strong><span class="up">↑ 18%</span><small>dibanding bulan lalu</small></div></div>
        <div class="pkk-stat s3"><div class="ic">♟</div><div><small>Pokja Aktif</small><strong>4</strong><small>dari 4 Pokja</small></div></div>
        <div class="pkk-stat s4"><div class="ic">⌖</div><div><small>Kelurahan/Kecamatan Terlapor</small><strong>31 / 31</strong><small>100% dari wilayah</small></div></div>
    </section>

    {{-- Grafik --}}
    <section class="pkk-grid">
        <div class="pkk-panel">
            <div class="pkk-title">Kegiatan per Pokja</div>
            <div class="pkk-chart"><canvas id="chartPokja"></canvas></div>
        </div>
        <div class="pkk-panel">
            <div class="pkk-title">Tren Kegiatan Bulanan</div>
            <div class="pkk-chart"><canvas id="chartTren"></canvas></div>
        </div>
        <div class="pkk-panel">
            <div class="pkk-title">
                Status Pelaporan per Wilayah
                <select style="font-size:11px;border:1px solid var(--line);border-radius:6px;padding:3px 6px"><option>Kecamatan</option><option>Kelurahan</option></select>
            </div>
            @foreach ([['Asemrowo',100,'5/5'],['Benowo',100,'4/4'],['Tandes',92,'11/12'],['Sukomanunggal',78,'7/9'],['Wiyung',61,'5/8']] as [$nama,$persen,$ket])
                <div class="pkk-prog">
                    <div class="h"><span>{{ $nama }}</span><span><b>{{ $persen }}%</b> <span class="text-muted">{{ $ket }}</span></span></div>
                    <div class="bar"><i class="{{ $persen < 80 ? 'mid' : '' }}" style="width:{{ $persen }}%"></i></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Tabel --}}
    <section class="pkk-panel" style="margin-top:14px">
        <div class="pkk-table-head">
            <h2>Data Laporan Kegiatan</h2>
            <button type="button" class="pkk-btn-main" data-bs-toggle="modal" data-bs-target="#modalTambah">＋ Tambah Laporan Kegiatan</button>
        </div>

        <div class="pkk-tools">
            <input type="text" class="grow" placeholder="Cari kegiatan, tempat, atau nama...">
            <select><option>Jenis Kegiatan: Semua</option><option>Sosialisasi</option><option>Pelatihan</option><option>Penyuluhan</option><option>Kunjungan</option></select>
            <select><option>Kegiatan: Semua</option></select>
            <input type="month" value="2026-09">
        </div>

        <div class="pkk-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No</th><th>Tanggal</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Tempat</th>
                        <th>Deskripsi</th><th>File</th><th>Foto</th><th>Dibuat Oleh</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data contoh. Ganti dengan @foreach ($laporan as $row) kalau sudah ada data dari database --}}
                    @foreach ([
                        ['2026-09-23','Sosialisasi','KEMANGI (Kelas Remaja)','Graha UNESA','Pendampingan kegiatan kelas remaja dan orang tua yang tanggap, kreatif dan mandiri.','1 file','Pokja 1','Kota Surabaya'],
                        ['2026-09-19','Sosialisasi','KEMANGI (Kelas Remaja)','Kecamatan Asemrowo','Narasumber Kemangi untuk kelas remaja dan orang tua yang tanggap.','1 file','Pokja 1','Kota Surabaya'],
                        ['2026-09-17','Pelatihan','Pelatihan Pengelolaan UP2K','Kelurahan Tambak Wedi','Peningkatan kapasitas pengelola UP2K PKK untuk ekonomi keluarga.','2 file','Pokja 2','Kecamatan Asemrowo'],
                        ['2026-09-15','Penyuluhan','PHBS','Kelurahan Tandes','Penyuluhan perilaku hidup bersih dan sehat (PHBS).','1 file','Pokja 3','Kelurahan Tandes'],
                        ['2026-09-12','Kunjungan','Kegiatan Posyandu','Kelurahan Made','Monitoring dan evaluasi kegiatan posyandu.','-','Pokja 4','Kelurahan Made'],
                    ] as $i => $r)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $r[0] }}</td>
                            <td>{{ $r[1] }}</td>
                            <td>{{ $r[2] }}</td>
                            <td>{{ $r[3] }}</td>
                            <td style="max-width:240px">{{ $r[4] }}</td>
                            <td>{{ $r[5] }}</td>
                            <td><span class="thumb"></span></td>
                            <td><b>{{ $r[6] }}</b><br><span class="text-muted">{{ $r[7] }}</span></td>
                            <td style="white-space:nowrap">
                                <button class="abtn view">Lihat</button>
                                <button class="abtn edit">Edit</button>
                                <button class="abtn del">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pkk-foot">
            <span>Menampilkan 1 - 5 dari 248 data</span>
            <div class="pkk-page">
                <button class="on">1</button><button>2</button><button>3</button><button>4</button><button>5</button><button>›</button>
            </div>
        </div>
    </section>

    {{-- Modal: Tambah Data Kegiatan --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                {{-- Ganti action="#" dengan route simpan kalau sudah dibuat --}}
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
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan" class="form-select form-select-solid" required>
                                <option value="">- Pilih Kegiatan -</option>
                                <option>Sosialisasi</option>
                                <option>Pelatihan</option>
                                <option>Penyuluhan</option>
                                <option>Kunjungan</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Jenis Sub Kegiatan</label>
                            <select name="sub_kegiatan" id="selSub" class="form-select form-select-solid" required disabled>
                                <option value="">Pilih Pokja terlebih dahulu</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Tempat Kegiatan</label>
                            <input type="text" name="tempat" class="form-control form-control-solid" required>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Jam Kegiatan</label>
                            <input type="time" name="jam" class="form-control form-control-solid" required>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Apakah Ada Notulen ?</label>
                            <select name="notulen" class="form-select form-select-solid">
                                <option value="">- Pilih Jawaban -</option>
                                <option value="1">Ada</option>
                                <option value="0">Tidak Ada</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">File Absensi</label>
                            <input type="file" name="file_absensi" class="form-control form-control-solid pkk-file" accept=".jpg,.jpeg,.pdf">
                            <div class="text-danger fs-8 mt-2">File harus di bawah 2MB dan berformat jpg atau pdf.</div>
                        </div>

                        <div class="mb-6">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-solid" rows="5"></textarea>
                        </div>

                        {{-- Preview Foto Kegiatan --}}
                        <div class="mb-6">
                            <label class="form-label">Preview Foto Kegiatan</label>
                            @foreach ([1, 2, 3] as $n)
                                <div class="pkk-prev mb-4">
                                    <img id="prev_{{ $n }}" alt="Preview foto {{ $n }}"
                                        src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='150' viewBox='0 0 200 150'><rect width='200' height='150' fill='white'/><circle cx='70' cy='55' r='14' fill='%23c9c9c9'/><path d='M40 115l35-40 25 28 20-18 40 30z' fill='%23c9c9c9'/></svg>">
                                </div>
                            @endforeach
                        </div>

                        {{-- Upload Foto Kegiatan --}}

                        @foreach ([1, 2, 3] as $n)
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
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Drawer
    // Sub kegiatan bergantung pada Pokja (data contoh, nanti bisa diambil via AJAX)
var subData = {
    '1': ['KEMANGI', 'Penghayatan dan Pengamalan Pancasila'],
    '2': ['UP2K', 'Pelatihan Kerja'],
    '3': ['PHBS', 'Pangan dan Gizi'],
    '4': ['Posyandu', 'Kesehatan Lingkungan']
};
var selPokja = document.getElementById('selPokja');
var selSub = document.getElementById('selSub');
selPokja.addEventListener('change', function () {
    var list = subData[this.value] || [];
    selSub.innerHTML = '';
    if (!list.length) {
        selSub.innerHTML = '<option value="">Pilih Pokja terlebih dahulu</option>';
        selSub.disabled = true;
        return;
    }
    selSub.innerHTML = '<option value="">- Pilih Sub Kegiatan -</option>' +
        list.map(function (s) { return '<option>' + s + '</option>'; }).join('');
    selSub.disabled = false;
});

// Validasi ukuran file maksimal 2MB
document.querySelectorAll('.pkk-file').forEach(function (inp) {
    inp.addEventListener('change', function () {
        if (this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
            alert('Ukuran file melebihi 2MB.');
            this.value = '';
        }
    });
});

    // Preview foto: tiap input punya kotak preview sendiri
        var defaults = {};
        document.querySelectorAll('.pkk-foto').forEach(function (inp) {
            var img = document.getElementById(inp.dataset.target);
            if (!img) return;
            defaults[inp.dataset.target] = img.src;
            inp.addEventListener('change', function () {
                var f = this.files[0];
                img.src = f ? URL.createObjectURL(f) : defaults[this.dataset.target];
            });
        });

    // Reset form saat modal ditutup
    document.getElementById('modalTambah').addEventListener('hidden.bs.modal', function () {
        document.getElementById('formTambah').reset();
        selSub.innerHTML = '<option value="">Pilih Pokja terlebih dahulu</option>';
        selSub.disabled = true;
        document.querySelectorAll('.pkk-foto').forEach(function (inp) {
            var img = document.getElementById(inp.dataset.target);
            if (img) img.src = defaults[inp.dataset.target];
        });
    });

    if (typeof Chart === 'undefined') return;

    // Kegiatan per Pokja (ganti data dari controller: json($dataPokja))
    new Chart(document.getElementById('chartPokja'), {
        type: 'bar',
        data: {
            labels: ['Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4'],
            datasets: [{ data: [62, 48, 36, 22], backgroundColor: ['#3fae5f', '#7765d8', '#4a90e2', '#2fc4b2'], borderRadius: 6, maxBarThickness: 44 }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#eef3f4' } }, x: { grid: { display: false } } } }
    });

    // Tren bulanan 2026 vs 2025 (ganti data dari controller)
    new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { label: '2026', data: [28,38,34,42,36,46,44,52,62,null,null,null], borderColor: '#3fae5f', backgroundColor: 'rgba(63,174,95,.12)', fill: true, tension: .3, pointRadius: 3 },
                { label: '2025', data: [20,24,22,28,26,30,28,34,36,40,42,46], borderColor: '#b7a9ec', tension: .3, pointRadius: 3 }
            ]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 8, usePointStyle: true } } }, scales: { y: { beginAtZero: true, grid: { color: '#eef3f4' } }, x: { grid: { display: false } } } }
    });
});
</script>
@endsection