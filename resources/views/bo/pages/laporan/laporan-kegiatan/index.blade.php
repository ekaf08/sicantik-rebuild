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
    .pkk .thumb-img { width:64px; height:44px; object-fit:cover; border-radius:6px; display:block; }
    .pkk .abtn { padding:6px 11px; border-radius:7px; font-size:11px; border:1px solid transparent; background:#fff; }
    .pkk .abtn.view { background:var(--green); color:#fff; }
    .pkk .abtn.edit { color:#6655bd; border-color:#cfc6f5; }
    .pkk .abtn.del  { color:#d94d6c; border-color:#f4c3cf; }
    .pkk .pkk-foot { margin-top:14px; font-size:12px; color:var(--muted); }
    .pkk .pagination { margin:0; }

    /* Preview foto di modal */
    .pkk-prev { width:100%; max-width:260px; background:#fff; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,.15); padding:8px; }
    .pkk-prev img { width:100%; height:190px; object-fit:contain; display:block; }

    @media (max-width:1200px) { .pkk-stats { grid-template-columns:repeat(2,1fr); } .pkk-grid { grid-template-columns:1fr 1fr; } .pkk-grid > :last-child { grid-column:1/-1; } }
    @media (max-width:700px)  { .pkk-stats, .pkk-grid { grid-template-columns:1fr; } }
</style>

<div class="pkk" id="pkk">

    {{-- Hero --}}
    <section class="pkk-hero">
        <h1>Pelaporan Kegiatan PKK</h1>
        <p>Bersama dalam data, untuk keluarga yang lebih sejahtera</p>
        <p style="color: red;">Saya masih mengerjakan Data Tabel, Sabar ya, Makasih</p>
    </section>

    {{-- Filter (masih contoh) --}}
    <div class="pkk-filters">
        <div class="pkk-sel"><i class="ki-outline ki-geolocation fs-3"></i>
            <select><option>Kota Surabaya</option><option>Kecamatan</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-map fs-3"></i>
            <select><option>Kelurahan</option><option>Wiyung</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-calendar fs-3"></i>
            <select><option>Tahun 2026</option><option>Tahun 2025</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-calendar-8 fs-3"></i>
            <select><option>Bulan September</option><option>Semua Bulan</option></select></div>
        <div class="pkk-sel"><i class="ki-outline ki-people fs-3"></i>
            <select><option>Semua</option><option>Pokja 1</option><option>Pokja 2</option><option>Pokja 3</option><option>Pokja 4</option><option value="5">Sekretaris</option></select></div>
    </div>

    {{-- Statistik (masih contoh) --}}
    <section class="pkk-stats">
        <div class="pkk-stat s1"><div class="ic"><i class="ki-outline ki-calendar-8 fs-2x"></i></div>
            <div><small>Total Kegiatan</small><strong>248</strong><span class="up">↑ 12%</span><small>dibanding bulan lalu</small></div></div>
        <div class="pkk-stat s2"><div class="ic"><i class="ki-outline ki-calendar-tick fs-2x"></i></div>
            <div><small>Kegiatan Bulan Ini</small><strong>87</strong><span class="up">↑ 18%</span><small>dibanding bulan lalu</small></div></div>
        <div class="pkk-stat s3"><div class="ic"><i class="ki-outline ki-people fs-2x"></i></div>
            <div><small>Pokja Aktif</small><strong>4</strong><small>dari 4 Pokja</small></div></div>
        <div class="pkk-stat s4"><div class="ic"><i class="ki-outline ki-geolocation fs-2x"></i></div>
            <div><small>Kelurahan/Kecamatan Terlapor</small><strong>31 / 31</strong><small>100% dari wilayah</small></div></div>
    </section>

    {{-- Grafik (masih contoh) --}}
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

    {{-- Tabel (data dari database) --}}
    <section class="pkk-panel" style="margin-top:14px">
        <div class="pkk-table-head">
            <h2>Data Laporan Kegiatan</h2>
            <button type="button" id="btnTambah" class="pkk-btn-main" data-bs-toggle="modal" data-bs-target="#modalTambah">＋ Tambah Laporan Kegiatan</button>
        </div>

        <div class="pkk-tools">
            <input type="text" id="cariLaporan" class="grow" placeholder="Cari kegiatan, tempat, atau nama...">
            <select id="fJenis">
                <option value="">Jenis Kegiatan: Semua</option>
                @foreach ($kegiatan as $k)
                    <option value="{{ $k->kegiatan_id }}">{{ $k->kegiatan_nama }}</option>
                @endforeach
            </select>
            <select id="fSub">
                <option value="">Kegiatan: Semua</option>
            </select>
            <input type="month" id="fBulan">
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
                                @foreach ($kegiatan as $k)
                                    <option value="{{ $k->kegiatan_id }}">{{ $k->kegiatan_nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="form-label required">Jenis Sub Kegiatan</label>
                            <select name="sub_kegiatan_id" id="selSub" class="form-select form-select-solid" required disabled>
                                <option value="">Pilih Pokja dan Jenis Kegiatan terlebih dahulu</option>
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
                            <select name="notulen" id="selNotulen" class="form-select form-select-solid">
                                <option value="">- Pilih Jawaban -</option>
                                <option value="1">Ada</option>
                                <option value="0">Tidak Ada</option>
                            </select>
                        </div>

                        {{-- Muncul hanya kalau notulen = Ada --}}
                        <div id="blkNotulen" class="d-none">
                            <div class="mb-6">
                                <label class="form-label required">Nama Notulen</label>
                                <input type="text" name="nama_notulen" id="inpNamaNotulen" class="form-control form-control-solid">
                            </div>
                            <div class="mb-6">
                                <label class="form-label">File Notulen</label>
                                <input type="file" name="file_notulen" class="form-control form-control-solid pkk-file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <div class="text-danger fs-8 mt-2">File harus di bawah 2MB.</div>
                            </div>
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
    var fJenis      = document.getElementById('fJenis');
    var fSub        = document.getElementById('fSub');
    var updateUrl   = null;   // null = mode tambah, berisi URL = mode edit

    function notif(msg, type) {
        if (window.Swal) { Swal.fire({ text: msg, icon: type, confirmButtonText: 'OK' }); }
        else { alert(msg); }
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

    /* ---------- Filter "Kegiatan" di atas tabel: selalu aktif ---------- */
    function isiFilterSub(jenisId) {
        fSub.innerHTML = '<option value="">Kegiatan: Semua</option>';
        return fetch(SUB_URL + '/' + (jenisId || 'semua'), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (list) {
                list.forEach(function (s) { fSub.add(new Option(s.sub_kegiatan_nama, s.sub_kegiatan_id)); });
            });
    }
    isiFilterSub('');

    /* ---------- Validasi ukuran file 2MB ---------- */
    document.querySelectorAll('.pkk-file').forEach(function (inp) {
        inp.addEventListener('change', function () {
            if (this.files[0] && this.files[0].size > 2 * 1024 * 1024) {
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
                d.jenis = fJenis.value;
                d.sub   = fSub.value;
                d.bulan = document.getElementById('fBulan').value;
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

    fJenis.addEventListener('change', function () {
        isiFilterSub(this.value).then(function () { tabel.draw(); });
    });
    fSub.addEventListener('change', function () { tabel.draw(); });
    document.getElementById('fBulan').addEventListener('change', function () { tabel.draw(); });

    /* ---------- Tombol Tambah ---------- */
    document.getElementById('btnTambah').addEventListener('click', function () {
        updateUrl = null;
        modalEl.querySelector('.modal-title').textContent = 'Tambah Data Kegiatan';
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
                        + '<b>Tanggal:</b> ' + row.tanggal_fmt + ' ' + (d.jam || '') + '<br>'
                        + '<b>Pokja:</b> ' + (d.pokja || '-') + '<br>'
                        + '<b>Jenis:</b> ' + row.jenis + ' / ' + row.sub + '<br>'
                        + '<b>Tempat:</b> ' + row.tempat + '<br>'
                        + '<b>Notulen:</b> ' + (d.notulen ? (d.nama_notulen || 'Ada') : '-') + '<br>'
                        + '<b>Deskripsi:</b> ' + (d.deskripsi || '-') + '<br>';
                    if (d.file_notulen_url)  { html += '<a href="' + d.file_notulen_url + '" target="_blank">Lihat file notulen</a><br>'; }
                    if (d.file_absensi_url)  { html += '<a href="' + d.file_absensi_url + '" target="_blank">Lihat file absensi</a><br>'; }
                    if (d.file_undangan_url) { html += '<a href="' + d.file_undangan_url + '" target="_blank">Lihat file undangan</a><br>'; }
                    [1, 2, 3].forEach(function (n) {
                        if (d['foto_' + n + '_url']) {
                            html += '<img src="' + d['foto_' + n + '_url'] + '" style="width:100%;margin-top:8px;border-radius:6px">';
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

    /* ---------- Grafik (data contoh) ---------- */
    if (typeof Chart === 'undefined') { return; }

    new Chart(document.getElementById('chartPokja'), {
        type: 'bar',
        data: {
            labels: ['Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4'],
            datasets: [{ data: [62, 48, 36, 22], backgroundColor: ['#3fae5f', '#7765d8', '#4a90e2', '#2fc4b2'], borderRadius: 6, maxBarThickness: 44 }]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#eef3f4' } }, x: { grid: { display: false } } } }
    });

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
