<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pelaporan Kegiatan PKK</title>
<style>
:root{
  --teal:#5abfbd;
  --teal-dark:#286b83;
  --teal-deep:#205d73;
  --teal-soft:#eaf8f7;
  --blue-soft:#edf5f8;
  --ink:#183b49;
  --muted:#6d8189;
  --line:#dce9ec;
  --bg:#f5f9f9;
  --white:#fff;
  --green:#49aa72;
  --purple:#7765d8;
  --danger:#ee5b78;
  --shadow:0 8px 28px rgba(35,91,108,.08);
}
*{box-sizing:border-box}
body{
  margin:0;
  font-family:Inter,Segoe UI,Arial,sans-serif;
  color:var(--ink);
  background:var(--bg);
}
button,input,select,textarea{font:inherit}
button{cursor:pointer;border:0}
.app{display:flex;min-height:100vh}
.sidebar{
  width:235px;background:#fff;border-right:1px solid var(--line);
  padding:25px 15px;position:fixed;top:0;bottom:0;left:0;
}
.brand{display:flex;gap:11px;align-items:center;padding:4px 10px 30px}
.logo{
  width:42px;height:42px;border-radius:14px;background:var(--teal);
  display:grid;place-items:center;color:white;font-size:22px;font-weight:800;
}
.brand b{font-size:18px}.brand span{display:block;color:var(--muted);font-size:11px;margin-top:3px}
.nav a{
  display:flex;align-items:center;gap:13px;padding:13px 14px;margin:5px 0;
  border-radius:10px;color:#315966;text-decoration:none;font-size:14px;
}
.nav a.active{background:#dff4ee;color:#176c69;font-weight:700;border-left:4px solid var(--teal)}
.nav .ico{width:20px;text-align:center}
.side-bottom{position:absolute;bottom:25px;left:24px;right:24px;color:var(--teal-dark);font-size:13px;line-height:1.5}

.main{margin-left:235px;width:calc(100% - 235px);padding:20px 25px 35px}
.topbar{height:48px;display:flex;justify-content:flex-end;align-items:center;gap:15px}
.profile{display:flex;align-items:center;gap:9px;font-size:13px}
.avatar{width:35px;height:35px;border-radius:50%;background:var(--teal-soft);display:grid;place-items:center}
.hero{
  position:relative;overflow:hidden;border-radius:18px;padding:25px 30px;
  min-height:118px;background:linear-gradient(100deg,#e2f4ee,#eef8f7 55%,#d8eeee);
  box-shadow:var(--shadow)
}
.hero h1{margin:0 0 7px;font-size:28px;color:var(--teal-deep)}
.hero p{margin:0;color:#54737c;font-size:14px}
.hero-art{position:absolute;right:-10px;top:-30px;font-size:130px;opacity:.18;color:var(--teal-dark)}
.filters{display:flex;gap:10px;margin:16px 0}
select,.search,input,textarea{
  border:1px solid var(--line);background:#fff;border-radius:9px;color:#46616b;
  outline:none;
}
.filters select{height:42px;padding:0 13px;min-width:145px}
.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.card{
  background:#fff;border:1px solid var(--line);border-radius:13px;padding:17px;
  box-shadow:var(--shadow)
}
.stat{display:flex;gap:12px;align-items:center}
.stat-icon{width:43px;height:43px;border-radius:12px;background:var(--teal-soft);display:grid;place-items:center;color:var(--teal-dark);font-size:20px}
.stat small{color:var(--muted);font-size:12px}.stat strong{display:block;font-size:25px;margin-top:3px}.up{font-size:11px;color:var(--green)}
.grid{display:grid;grid-template-columns:1fr 1.2fr 1fr;gap:14px;margin-top:14px}
.chart-card{height:260px}.card-title{font-weight:700;font-size:14px;margin-bottom:16px}
.bars{height:180px;display:flex;align-items:end;justify-content:space-around;gap:14px;border-bottom:1px solid var(--line);padding:0 10px}
.bar-wrap{text-align:center;flex:1}.bar{margin:auto;width:42px;border-radius:7px 7px 0 0;background:linear-gradient(var(--teal),#77d0c9)}.bar2{background:linear-gradient(#78aeca,#4d839e)}.bar-label{font-size:11px;color:var(--muted);margin-top:7px}
.linechart{height:180px;position:relative;border-left:1px solid var(--line);border-bottom:1px solid var(--line);background:repeating-linear-gradient(to bottom,transparent 0,transparent 44px,#edf3f4 45px)}
.line{position:absolute;left:8%;right:5%;top:55px;height:90px;border-bottom:3px solid var(--teal);transform:skewY(-13deg)}
.line:after{content:"";position:absolute;right:0;bottom:-6px;width:10px;height:10px;border-radius:50%;background:var(--teal-dark)}
.progress-row{margin:15px 0}.progress-head{display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px}.progress{height:8px;background:#edf3f4;border-radius:99px;overflow:hidden}.progress i{display:block;height:100%;background:var(--teal);border-radius:99px}
.table-card{margin-top:14px;background:#fff;border:1px solid var(--line);border-radius:14px;padding:17px;box-shadow:var(--shadow)}
.table-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}.table-head h2{font-size:17px;margin:0}
.primary{background:var(--teal-dark);color:#fff;border-radius:8px;padding:11px 15px;font-weight:700}
.table-tools{display:flex;gap:9px;margin-bottom:12px}.search{height:38px;flex:1;padding:0 12px}
.table-wrap{overflow:auto}table{width:100%;border-collapse:collapse;font-size:12px}th{background:#eff8f7;color:#48636d;text-align:left;padding:11px 9px;white-space:nowrap}td{padding:12px 9px;border-bottom:1px solid #edf2f3;vertical-align:top}tr:hover td{background:#fbfefe}
.badge{display:inline-block;padding:5px 8px;border-radius:99px;background:#e6f6f2;color:#24766d;font-size:11px}
.actions{display:flex;gap:5px}.btn{padding:7px 9px;border-radius:7px;font-size:11px}.view{background:#e9f6f2;color:#267d68}.edit{background:#f0edff;color:#6655bd}.del{background:#fff0f3;color:#d94d6c}

.drawer{
  position:fixed;right:0;top:0;bottom:0;width:390px;background:#fff;
  box-shadow:-10px 0 35px rgba(25,73,88,.16);padding:22px;overflow:auto
}
.drawer h2{font-size:18px;margin:0}.drawer .sub{font-size:12px;color:var(--muted);margin:5px 0 20px}
.field{margin-bottom:14px}.field label{display:block;font-size:12px;font-weight:700;margin-bottom:7px}.field input,.field select,.field textarea{width:100%;padding:10px 11px}.field textarea{height:95px;resize:vertical}
.upload{border:1.5px dashed #b9d4d9;border-radius:10px;padding:25px;text-align:center;color:var(--muted);font-size:12px}.upload b{display:block;font-size:25px;color:var(--teal-dark);margin-bottom:5px}
.notice{background:#eaf8f5;color:#31766c;padding:12px;border-radius:9px;font-size:11px;line-height:1.5;margin:17px 0}
.save{width:100%;background:var(--teal-dark);color:#fff;padding:12px;border-radius:9px;font-weight:700}.cancel{width:100%;background:#fff;color:var(--teal-dark);border:1px solid var(--teal);padding:11px;border-radius:9px;margin-top:9px}
.close{position:absolute;right:18px;top:18px;color:var(--muted);background:none;font-size:20px}

@media(max-width:1200px){.drawer{width:350px}.cards{grid-template-columns:repeat(2,1fr)}.grid{grid-template-columns:1fr 1fr}.grid .chart-card:last-child{grid-column:1/-1}}
@media(max-width:800px){.sidebar{width:65px}.brand div,.brand span,.nav a span,.side-bottom{display:none}.brand{padding:4px 5px 30px}.nav a{justify-content:center}.main{margin-left:65px;width:calc(100% - 65px);padding:15px}.drawer{position:relative;width:100%;margin:15px 0;box-shadow:none}.app{display:block}.cards,.grid{grid-template-columns:1fr}.topbar{justify-content:flex-start}}
</style>
</head>
<body>
<div class="app">
  <aside class="sidebar">
    <div class="brand"><div class="logo">✿</div><div><b>PKK</b><span>Bersama Membangun<br> Keluarga Sejahtera</span></div></div>
    <nav class="nav">
      <a class="active" href="#"><span class="ico">⌂</span><span>Dashboard</span></a>
      <a href="#"><span class="ico">▤</span><span>Laporan Kegiatan</span></a>
      <a href="#"><span class="ico">▥</span><span>Master Data</span></a>
      <a href="#"><span class="ico">◫</span><span>Rekapitulasi</span></a>
      <a href="#"><span class="ico">⚙</span><span>Pengaturan</span></a>
    </nav>
    <div class="side-bottom">PKK Berdaya<br><b>Keluarga Sejahtera</b> ♡</div>
  </aside>

  <main class="main">
    <div class="topbar"><div class="profile"><div class="avatar">♙</div><div><b>Ketua PKK Kota</b><br><small>Scope: Kota Surabaya</small></div>⌄</div></div>

    <section class="hero">
      <div class="hero-art">⌁</div>
      <h1>Pelaporan Kegiatan PKK</h1>
      <p>Bersama dalam data, untuk keluarga yang lebih sejahtera</p>
    </section>

    <div class="filters">
      <select><option>Kota Surabaya</option><option>Kecamatan</option><option>Kelurahan</option></select>
      <select><option>Tahun 2026</option></select>
      <select><option>Bulan September</option><option>Semua Bulan</option></select>
      <select><option>Pokja — Semua</option><option>Pokja 1</option><option>Pokja 2</option><option>Pokja 3</option><option>Pokja 4</option></select>
    </div>

    <section class="cards">
      <div class="card stat"><div class="stat-icon">▣</div><div><small>Total Kegiatan</small><strong>248</strong><span class="up">↑ 12% dibanding bulan lalu</span></div></div>
      <div class="card stat"><div class="stat-icon">◷</div><div><small>Kegiatan Bulan Ini</small><strong>87</strong><span class="up">↑ 18% dibanding bulan lalu</span></div></div>
      <div class="card stat"><div class="stat-icon">♟</div><div><small>Pokja Aktif</small><strong>4</strong><span class="up">4 dari 4 Pokja</span></div></div>
      <div class="card stat"><div class="stat-icon">⌖</div><div><small>Wilayah Terlapor</small><strong>31 / 31</strong><span class="up">100% wilayah</span></div></div>
    </section>

    <section class="grid">
      <div class="card chart-card"><div class="card-title">Kegiatan per Pokja</div><div class="bars">
        <div class="bar-wrap"><div class="bar" style="height:140px"></div><div class="bar-label">Pokja 1<br><b>62</b></div></div>
        <div class="bar-wrap"><div class="bar bar2" style="height:108px"></div><div class="bar-label">Pokja 2<br><b>48</b></div></div>
        <div class="bar-wrap"><div class="bar" style="height:82px"></div><div class="bar-label">Pokja 3<br><b>36</b></div></div>
        <div class="bar-wrap"><div class="bar bar2" style="height:52px"></div><div class="bar-label">Pokja 4<br><b>22</b></div></div>
      </div></div>

      <div class="card chart-card"><div class="card-title">Tren Kegiatan Bulanan</div><div class="linechart"><div class="line"></div></div></div>

      <div class="card chart-card"><div class="card-title">Status Pelaporan per Wilayah</div>
        <div class="progress-row"><div class="progress-head"><span>Wonokromo</span><b>100%</b></div><div class="progress"><i style="width:100%"></i></div></div>
        <div class="progress-row"><div class="progress-head"><span>Asemrowo</span><b>100%</b></div><div class="progress"><i style="width:100%"></i></div></div>
        <div class="progress-row"><div class="progress-head"><span>Tandes</span><b>92%</b></div><div class="progress"><i style="width:92%"></i></div></div>
        <div class="progress-row"><div class="progress-head"><span>Wiyung</span><b>61%</b></div><div class="progress"><i style="width:61%"></i></div></div>
      </div>
    </section>

    <section class="table-card">
      <div class="table-head"><h2>▣ &nbsp; Data Laporan Kegiatan</h2><button class="primary" onclick="document.querySelector('.drawer').scrollIntoView({behavior:'smooth'})">＋ Tambah Laporan Kegiatan</button></div>
      <div class="table-tools"><input class="search" placeholder="⌕  Cari kegiatan, tempat, atau nama..."><select><option>Jenis Kegiatan — Semua</option></select><select><option>Kegiatan — Semua</option></select><input class="search" style="max-width:145px" value="Sep 2026"></div>
      <div class="table-wrap"><table>
        <thead><tr><th>No</th><th>Tanggal</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Tempat</th><th>Deskripsi</th><th>File</th><th>Dibuat Oleh</th><th>Action</th></tr></thead>
        <tbody>
          <tr><td>1</td><td>23-09-2026</td><td><span class="badge">Sosialisasi</span></td><td>KEMANGI<br>(Kelas Remaja...)</td><td>Graha UNESA</td><td>Pendampingan kegiatan kelas remaja dan orang tua...</td><td>▧ 1 file</td><td>Pokja 1<br>Kota Surabaya</td><td><div class="actions"><button class="btn view">Lihat</button><button class="btn edit">Edit</button><button class="btn del">Hapus</button></div></td></tr>
          <tr><td>2</td><td>19-09-2026</td><td><span class="badge">Sosialisasi</span></td><td>KEMANGI</td><td>Kec. Asemrowo</td><td>Narasumber Kemangi untuk kelas remaja dan orang tua...</td><td>▧ 1 file</td><td>Pokja 1<br>Kec. Asemrowo</td><td><div class="actions"><button class="btn view">Lihat</button><button class="btn edit">Edit</button><button class="btn del">Hapus</button></div></td></tr>
          <tr><td>3</td><td>17-09-2026</td><td><span class="badge">Pelatihan</span></td><td>Pelatihan Pengelolaan UP2K</td><td>Kel. Tambak Wedi</td><td>Peningkatan kapasitas pengelola UP2K PKK...</td><td>▧ 2 file</td><td>Pokja 2</td><td><div class="actions"><button class="btn view">Lihat</button><button class="btn edit">Edit</button><button class="btn del">Hapus</button></div></td></tr>
          <tr><td>4</td><td>15-09-2026</td><td><span class="badge">Penyuluhan</span></td><td>PHBS</td><td>Kel. Tandes</td><td>Penyuluhan perilaku hidup bersih dan sehat.</td><td>▧ 1 file</td><td>Pokja 3</td><td><div class="actions"><button class="btn view">Lihat</button><button class="btn edit">Edit</button><button class="btn del">Hapus</button></div></td></tr>
        </tbody>
      </table></div>
    </section>
  </main>

  <aside class="drawer">
    <button class="close">×</button>
    <h2>＋ Tambah Laporan Kegiatan</h2>
    <div class="sub">Isi data kegiatan dengan lengkap dan benar.</div>

    <div class="field"><label>Tanggal Kegiatan <b style="color:#e55">*</b></label><input type="date" value="2026-09-23"></div>
    <div class="field"><label>Jenis Kegiatan <b style="color:#e55">*</b></label><select><option>Pilih jenis kegiatan</option><option>Sosialisasi</option><option>Pelatihan</option><option>Penyuluhan</option><option>Kunjungan</option></select></div>
    <div class="field"><label>Kegiatan <b style="color:#e55">*</b></label><select><option>Pilih kegiatan</option><option>KEMANGI</option><option>UP2K</option><option>PHBS</option><option>Posyandu</option></select></div>
    <div class="field"><label>Tempat <b style="color:#e55">*</b></label><input placeholder="Contoh: Aula Kecamatan Asemrowo"></div>
    <div class="field"><label>Deskripsi <b style="color:#e55">*</b></label><textarea placeholder="Jelaskan kegiatan secara singkat dan jelas..."></textarea></div>
    <div class="field"><label>File <span style="font-weight:400;color:#899ba1">(opsional)</span></label><div class="upload"><b>⇧</b>Klik untuk mengunggah file<br><small>PDF, DOC, DOCX (maks. 10 MB)</small></div></div>
    <div class="field"><label>Foto <span style="font-weight:400;color:#899ba1">(opsional)</span></label><div class="upload"><b>▧</b>Klik untuk mengunggah foto<br><small>JPG, PNG (maks. 5 MB)</small></div></div>
    <div class="notice">ⓘ Laporan dapat ditambahkan dari hari H sampai dengan H+7 (7 hari setelah tanggal kegiatan).</div>
    <button class="save">▣ &nbsp; Simpan Laporan</button>
    <button class="cancel">Batal</button>
  </aside>
</div>
</body>
</html>