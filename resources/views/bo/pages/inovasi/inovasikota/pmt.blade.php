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

<!-- Section Total & Filter Dropdown + Button Tambah -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
    <!-- Total Badge -->
    <div class="border border-warning rounded-4 px-6 py-3 bg-white d-flex align-items-center justify-content-center">
        <span class="fs-2hx fw-bolder text-warning me-2">Total : 1520</span>
    </div>

    <!-- Dropdown Filters & Button -->
    <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">
        <!-- Filter Kecamatan -->
        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kecamatan" onchange="loadKelurahanSurabaya(this.value, 'filter-kelurahan')">
            <option value="">Semua Kecamatan</option>
        </select>

        <!-- Filter Kelurahan Otomatis -->
        <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kelurahan">
            <option value="">Pilih Kelurahan</option>
        </select>

        <select class="form-select form-select-solid w-125px fs-7 fw-semibold" id="filter-tahun-select" onchange="pilihTahunDariSelect(this.value)">
            <option value="2026">2026</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
        </select>

        <select class="form-select form-select-solid w-150px fs-7 fw-semibold" id="filter-puskesmas">
            <option value="">Pilih Putaran</option>
            <option value="Putaran 1">Putaran 1</option>
            <option value="Putaran 2">Putaran 2</option>
            <option value="Putaran 3">Putaran 3</option>
            <option value="Putaran 4">Putaran 4</option>
            <option value="Putaran 5">Putaran 5</option>
            <option value="Putaran 6">Putaran 6</option>
            <option value="Putaran 7">Putaran 7</option>
        </select>
    

        <!-- Tombol Tambah Data PMT memanggil Modal -->
        <button type="button" class="btn btn-primary fw-bold fs-7 px-4" data-bs-toggle="modal" data-bs-target="#modal_tambah_pmt">
            <i class="ki-outline ki-plus fs-3 me-1"></i> Tambah Data PMT
        </button>
    </div>
</div>

<!-- 3 Card Tahun (Klik untuk memfilter tabel di bawah) -->
<div class="row g-4 mb-6">
    <!-- Card 2024 -->
    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border border-primary card-tahun" id="card-2024" onclick="filterTahun('2024')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder text-primary my-2">220</div>
                <span class="text-primary fw-bold fs-7 mb-4">BALITA</span>
                <div class="bg-primary text-white fw-bold py-2 rounded-3 fs-7">2024</div>
            </div>
        </div>
    </div>

    <!-- Card 2025 -->
    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border card-tahun" id="card-2025" onclick="filterTahun('2025')" style="border-color: #7239ea !important;">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder my-2" style="color: #7239ea;">332</div>
                <span class="fw-bold fs-7 mb-4" style="color: #7239ea;">BALITA</span>
                <div class="text-white fw-bold py-2 rounded-3 fs-7" style="background-color: #7239ea;">2025</div>
            </div>
        </div>
    </div>

    <!-- Card 2026 -->
    <div class="col-md-4">
        <div class="card h-100 cursor-pointer shadow-sm border border-success card-tahun" id="card-2026" onclick="filterTahun('2026')">
            <div class="card-body p-6 text-center d-flex flex-column justify-content-between">
                <span class="text-gray-500 fw-bold fs-8 text-uppercase tracking-wider">TOTAL</span>
                <div class="fs-3hx fw-bolder text-success my-2">968</div>
                <span class="text-success fw-bold fs-7 mb-4">BALITA</span>
                <div class="bg-success text-white fw-bold py-2 rounded-3 fs-7">2026</div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Section -->
<div class="card card-flush shadow-sm">
    <div class="card-body pt-6">
        <!-- Controls: Length & Search -->
        <div class="d-flex flex-stack mb-5">
            <div class="d-flex align-items-center gap-2">
                <select class="form-select form-select-solid w-75px fs-7 fw-semibold" id="table-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="d-flex align-items-center position-relative">
                <label class="fs-7 fw-semibold text-gray-700 me-2">Search:</label>
                <input type="text" id="input-search" class="form-control form-control-solid w-200px fs-7" placeholder="" />
            </div>
        </div>

        <!-- Tabel Data Balita -->
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
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-700">
                    <!-- Data Tahun 2024 -->
                    <tr data-tahun="2024">
                        <td class="text-center">1</td>
                        <td>3578012304200001</td>
                        <td>Ahmad Fauzi</td>
                        <td>12/04/2022</td>
                        <td>24 Bulan</td>
                        <td>Laki-laki</td>
                        <td>Jl. Embong Malang No. 12</td>
                        <td>Budi Santoso</td>
                        <td>Putaran 1</td>
                        <td>2024</td>
                        <td>Embong Kaliasin</td>
                        <td>Genteng</td>
                    </tr>
                    <tr data-tahun="2024">
                        <td class="text-center">2</td>
                        <td>3578012304200002</td>
                        <td>Anisa Rahma</td>
                        <td>18/05/2022</td>
                        <td>23 Bulan</td>
                        <td>Perempuan</td>
                        <td>Jl. Blauran No. 4</td>
                        <td>Siti Aminah</td>
                        <td>Putaran 1</td>
                        <td>2024</td>
                        <td>Genteng</td>
                        <td>Genteng</td>
                    </tr>

                    <!-- Data Tahun 2025 -->
                    <tr data-tahun="2025" class="d-none">
                        <td class="text-center">1</td>
                        <td>3578012508210002</td>
                        <td>Siti Aisyah</td>
                        <td>05/08/2023</td>
                        <td>18 Bulan</td>
                        <td>Perempuan</td>
                        <td>Jl. Kedungdoro No. 45</td>
                        <td>Rahmat Hidayat</td>
                        <td>Putaran 2</td>
                        <td>2025</td>
                        <td>Kedungdoro</td>
                        <td>Tegalsari</td>
                    </tr>

                    <!-- Data Tahun 2026 -->
                    <tr data-tahun="2026" class="d-none">
                        <td class="text-center">1</td>
                        <td>3578011001240003</td>
                        <td>Rizky Pratama</td>
                        <td>10/01/2024</td>
                        <td>12 Bulan</td>
                        <td>Laki-laki</td>
                        <td>Jl. Kombes Pol M Duryat No. 8</td>
                        <td>Eko Prasetyo</td>
                        <td>Putaran 1</td>
                        <td>2026</td>
                        <td>Tegalsari</td>
                        <td>Tegalsari</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah PMT -->
<div class="modal fade" id="modal_tambah_pmt" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Tambah PMT</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form id="form-tambah-pmt" onsubmit="simpanDataPmt(event)">
                    <!-- Row NIK + Cari -->
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NIK <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-solid" name="nik" placeholder="" required />
                            <button class="btn btn-primary fw-bold px-6" type="button">Cari</button>
                        </div>
                    </div>

                    <!-- Row Nama & Tgl Lahir -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA BALITA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="nama_balita" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" required />
                        </div>
                    </div>

                    <!-- Row Usia & Jenis Kelamin -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">USIA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="usia" placeholder="" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="jenis_kelamin" required>
                                <option value="" selected disabled></option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row Alamat & Orang Tua -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">ALAMAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="alamat" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">NAMA ORANG TUA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="nama_orang_tua" required />
                        </div>
                    </div>

                    <!-- Row Kec & Kel di Modal -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <select class="form-select form-select-solid" name="kecamatan" id="modal-kecamatan" onchange="loadKelurahanSurabaya(this.value, 'modal-kelurahan')" required>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-select form-select-solid" name="kelurahan" id="modal-kelurahan" required>
                                <option value="" selected disabled>Kelurahan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row Tahun & Putaran -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">TAHUN <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="tahun" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">PUTARAN KE <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="putaran" required />
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="mb-6">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Foto 1 <span class="text-danger">*</span></label>
                        <input type="file" class="form-control form-control-solid" name="foto" required />
                        <div class="form-text text-danger fs-8 mt-1">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                    </div>

                    <!-- Tombol Action -->
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

<!-- Load SweetAlert2 JS untuk Notifikasi Popup Centang Hijau -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.card-tahun {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-tahun:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
}
</style>

<script>
// Master Data Kecamatan & Kelurahan Surabaya
const dataWilayahSurabaya = {
    "ASEMROWO": ["ASEM ROWO", "GENTING KALIANAK", "TAMBAK SARIOSO"],
    "BENOWO": ["KANDANGAN", "ROMOKALISARI", "SEMEMI", "TAMBAK OSO WILANGUN"],
    "BUBUTAN": ["ALUN-ALUN CONTONG", "BUBUTAN", "GUNDIH", "JEPARA", "TEMBOK DUKUH"],
    "BULAK": ["BULAK", "KEDUNG COWEK", "KENJERAN", "SUKOLILO BARU"],
    "DUKUH PAKIS": ["DUKUH KUPANG", "DUKUH PAKIS", "GUNUNG SARI", "PRADAH KALIKENDAL"],
    "GAYUNGAN": ["DUKUH MENANGGAL", "GAYUNGAN", "KETINTANG", "MENANGGAL"],
    "GENTENG": ["EMBONG KALIASIN", "GENTENG", "KAPASARI", "KETABANG", "PENELEH"],
    "GUBENG": ["AIRLANGGA", "BARATAJAYA", "GUBENG", "KERTAJAYA", "MOJO", "PUCANG SEWU"],
    "GUNUNG ANYAR": ["GUNUNG ANYAR", "GUNUNG ANYAR TAMBAK", "RUNGKUT MENANGGAL", "RUNGKUT TENGAH"],
    "JAMBANGAN": ["JAMBANGAN", "KARAH", "KEBONSARI", "PAGESANGAN"],
    "KARANG PILANG": ["KARANG PILANG", "KEBRAON", "KEDURUS", "WARU GUNUNG"],
    "KENJERAN": ["BULAK BANTENG", "SIDOTOPO WETAN", "TAMBAK WEDI", "TANAH KALI KEDINDING"],
    "KREMBANGAN": ["DUPAK", "KEMAYORAN", "KREMBANGAN SELATAN", "MOROKREMBANGAN", "PERAK BARAT"],
    "LAKAR SANTRI": ["BANGKINGAN", "JERUK", "LAKARSANTRI", "LIDAH KULON", "LIDAH WETAN", "SUMURWELUT"],
    "MULYOREJO": ["DUKUH SUTOREJO", "KALIJUDAN", "KALISARI", "KEJAWAAN PUTIH TAMBAK", "MANYAR SABRANGAN", "MULYOREJO"],
    "PABEAN CANTIAN": ["BONGKARAN", "KREMBANGAN UTARA", "NYAMPLUNGAN", "TANJUNG PERAK"],
    "PAKAL": ["BABAT JERAWAT", "BENOWO", "PAKAL", "SUMBER REJO"],
    "RUNGKUT": ["KALIRUNGKUT", "KEDUNG BARUK", "MEDOKAN AYU", "PENJARINGANSARI", "RUNGKUT KIDUL", "WONOREJO"],
    "SAMBI KEREP": ["BERINGIN", "LONTAR", "MADE", "SAMBIKEREP"],
    "SAWAHAN": ["BANYU URIP", "KUPANG KRAJAN", "PAKIS", "PETEMON", "PUTAT JAYA", "SAWAHAN"],
    "SEMAMPIR": ["AMPEL", "PEGIRIAN", "SIDOTOPO", "UJUNG", "WONOKUSUMO"],
    "SIMOKERTO": ["KAPASAN", "SIDODADI", "SIMOKERTO", "SIMOLAWANG", "TAMBAKREJO"],
    "SUKOLILO": ["GEBANG PUTIH", "KEPUTIH", "KLAMPIS NGASEM", "MEDOKAN SEMAMPIR", "MENUR PUMPUNGAN", "NGINDEN JANGKUNGAN", "SEMOLOWARU"],
    "SUKOMANUNGGAL": ["PUTAT GEDE", "SIMOMULYO", "SIMOMULYO BARU", "SONOKWIJENAN", "SUKOMANUNGGAL", "TANJUNGSARI"],
    "TAMBAKSARI": ["DUKUH SETRO", "GADING", "KAPASMADYA BARU", "PACARKELING", "PACARKEMBANG", "PLOSO", "RANGKAH", "TAMBAKSARI"],
    "TANDES": ["BALONGSARI", "BANJAR SUGIHAN", "KARANG POH", "MANUKAN KULON", "MANUKAN WETAN", "TANDES"],
    "TEGALSARI": ["DR. SOETOMO", "KEDUNGDORO", "KEPUTRAN", "TEGALSARI", "WONOREJO"],
    "TENGGILIS MEJOYO": ["KENDANGSARI", "KUTISARI", "PANJANG JIWO", "TENGGILIS MEJOYO"],
    "WIYUNG": ["BABATAN", "BALAS KLUMPRIK", "JAJAR TUNGGAL", "WIYUNG"],
    "WONOCOLO": ["BENDUL MERISI", "JEMUR WONOSARI", "MARGOREJO", "SIDOSERMO", "SIWALANKERTO"],
    "WONOKROMO": ["DARMO", "JAGIR", "NGAGEL", "NGAGEL REJO", "SAWUNGGALING", "WONOKROMO"]
};

// Populate Semua Kecamatan saat Halaman Pertama Dimuat
function initDropdownKecamatan() {
    const listKecamatan = Object.keys(dataWilayahSurabaya);
    const filterKecSelect = document.getElementById('filter-kecamatan');
    const modalKecSelect = document.getElementById('modal-kecamatan');

    listKecamatan.forEach(kec => {
        let opt1 = document.createElement('option');
        opt1.value = kec;
        opt1.textContent = kec;
        filterKecSelect.appendChild(opt1);

        let opt2 = document.createElement('option');
        opt2.value = kec;
        opt2.textContent = kec;
        modalKecSelect.appendChild(opt2);
    });
}

// Fungsi Otomatis Mengisi Kelurahan Saat Kecamatan Dipilih
function loadKelurahanSurabaya(selectedKecamatan, targetKelurahanId) {
    const kelurahanSelect = document.getElementById(targetKelurahanId);
    if (!kelurahanSelect) return;

    kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

    if (selectedKecamatan && dataWilayahSurabaya[selectedKecamatan]) {
        const listKelurahan = dataWilayahSurabaya[selectedKecamatan];
        listKelurahan.forEach(kel => {
            let option = document.createElement('option');
            option.value = kel;
            option.textContent = kel;
            kelurahanSelect.appendChild(option);
        });
    }
}

function filterTahun(tahun) {
    var selectTahun = document.getElementById('filter-tahun-select');
    if (selectTahun) {
        selectTahun.value = tahun;
    }

    var rows = document.querySelectorAll('#tabel-pmt tbody tr');
    rows.forEach(function(row) {
        if (row.getAttribute('data-tahun') === tahun) {
            row.classList.remove('d-none');
        } else {
            row.classList.add('d-none');
        }
    });
}

function pilihTahunDariSelect(tahun) {
    filterTahun(tahun);
}

function simpanDataPmt(event) {
    event.preventDefault(); // Mencegah reload bawaan form

    // 1. Sembunyikan Modal Tambah
    var modalElement = document.getElementById('modal_tambah_pmt');
    var modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }

    // 2. Tampilkan Pop-up Centang Hijau Sukses
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil ditambahkan',
        showConfirmButton: false,
        timer: 2000,
        customClass: {
            popup: 'rounded-4'
        }
    });

    // 3. Reset form
    document.getElementById('form-tambah-pmt').reset();
}

document.addEventListener('DOMContentLoaded', function() {
    initDropdownKecamatan();
    filterTahun('2024');
});
</script>
