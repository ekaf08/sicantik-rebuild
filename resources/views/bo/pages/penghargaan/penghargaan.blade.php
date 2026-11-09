@extends('bo.layout.app')

@section('content')
    @php
        // Peta wilayah dari database: { id_kecamatan: { nama, kel: [ {id, nama} ] } }
        $wil = [];
        // Kalau controller tidak mengirim data wilayah (atau kosong), ambil langsung dari database
        if (empty($kecamatan) || count($kecamatan) === 0) {
            try { $kecamatan = \Illuminate\Support\Facades\DB::table('m_kecamatan')->whereNull('deleted_at')->orderBy('nama_kec')->get(); } catch (\Throwable $e) { $kecamatan = []; }
        }
        if (empty($kelurahan) || count($kelurahan) === 0) {
            try { $kelurahan = \Illuminate\Support\Facades\DB::table('m_kelurahan')->orderBy('nama_kel')->get(); } catch (\Throwable $e) { $kelurahan = []; }
        }
        foreach (($kecamatan ?? []) as $k) {
            if (!empty($k->deleted_at ?? null)) { continue; }
            $kid = $k->id_kec ?? ($k->id_kecamatan ?? ($k->id ?? null));
            if ($kid === null) { continue; }
            // Nama kecamatan: coba nama kolom yang umum, kalau tidak ada ambil kolom teks pertama yang bukan id/kode
            $nm = $k->nama_kec ?? ($k->nama_kecamatan ?? ($k->nama ?? ($k->kecamatan ?? ($k->nm_kec ?? ($k->nama_kcm ?? null)))));
            if ($nm === null || $nm === '') {
                foreach (get_object_vars($k) as $kol => $val) {
                    if (is_string($val) && trim($val) !== '' && !is_numeric($val)
                        && !preg_match('/(^id|_id$|^no_|^kd_|^kode|_at$|^created|^updated|^deleted)/i', $kol)) { $nm = $val; break; }
                }
            }
            $wil[$kid] = ['nama' => (string) ($nm ?? ('Kecamatan ' . $kid)), 'kel' => []];
        }
        foreach (($kelurahan ?? []) as $l) {
            $kid = $l->no_kec ?? ($l->id_kec ?? ($l->kecamatan_id ?? ($l->id_kecamatan ?? null)));
            if ($kid !== null && isset($wil[$kid])) {
                $wil[$kid]['kel'][] = [
                    'id'   => $l->id_kel ?? ($l->id_kelurahan ?? ($l->id ?? '')),
                    'nama' => $l->nama_kel ?? ($l->nama_kelurahan ?? ($l->nama ?? '')),
                ];
            }
        }
        // Urut nama untuk pilihan dropdown yang dirender langsung oleh server
        $wilUrut = $wil;
        uasort($wilUrut, function ($x, $y) { return strcmp((string) $x['nama'], (string) $y['nama']); });
    @endphp
    <!-- SweetAlert2 untuk pop-up notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* Styling Tabel Grid Komprehensif */
    #kt_table_penghargaan {
        border-collapse: collapse !important;
        border: 1px solid #f1f3f5 !important;
    }

    /* Header Tabel: Background Abu-abu Soft & Teks Hitam Tebal */
    #kt_table_penghargaan thead th {
        background-color: #f8f9fa !important;
        color: #181c32 !important;
        font-weight: 700 !important;
        border: 1px solid #e9ecef !important;
        padding: 12px 16px !important;
    }

    /* Isi Tabel: Border Tipis Halus di Setiap Sel (Horizontal & Vertikal) */
    #kt_table_penghargaan tbody td {
        color: #212529 !important;
        border: 1px solid #f1f3f5 !important;
        padding: 12px 16px !important;
    }

    /* Tombol & header modal bernuansa Sunset Orange Ceria & Semangat */
    .btn-emas { background-color: #ff6b4a; color: #ffffff !important; border: 0; box-shadow: 0 4px 12px rgba(255, 107, 74, 0.25); }
    .btn-emas:hover, .btn-emas:focus { background-color: #e05334; color: #ffffff !important; }
    .btn-emas i { color: #ffffff !important; }
    /* Pop-up tambah/edit: netral (putih) */
    .modal-header-emas { background-color: #ffffff; border-bottom: 1px solid #eff2f5; }
    .modal-header-emas h2 { color: #181c32; }
    /* Hijau lembut untuk isi tabel dan tombol simpan di pop-up */
    .pg-hijau { background-color: #e6f7ec !important; color: #1f9d55 !important; border: 0; }
    .pg-hijau i { color: #1f9d55 !important; }
    .pg-hijau:hover { background-color: #d3f0de !important; color: #187a43 !important; }
    .btn-simpan-hijau { background-color: #22c55e; color: #fff !important; border: 0; }
    .btn-simpan-hijau:hover, .btn-simpan-hijau:focus { background-color: #1aa84f; color: #fff !important; }
    /* Pratinjau dokumen Word di pop-up */
    #docx_container { max-height: 78vh; overflow: auto; background: #f1f3f5; padding: 12px; }
    #docx_container .docx-wrapper { background: transparent !important; padding: 0 !important; }
</style>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">

                <!-- Banner Penghargaan (Sunset Coral Ceria & Semangat) -->
                <style>
                    .pg-hero {
                        position: relative;
                        overflow: hidden;
                        display: flex;
                        align-items: center;
                        min-height: 210px;
                        padding: 2rem 2.5rem;
                        margin-bottom: 1.75rem;
                        border-radius: 1rem;
                        background: linear-gradient(135deg, #fff3ee 0%, #ffe5dc 100%);
                        border: 1px solid #ffd8cc;
                    }
                    .pg-hero-text { position: relative; z-index: 2; max-width: 52%; }
                    .pg-hero-label {
                        display: block; margin-bottom: .5rem;
                        font-size: .75rem; font-weight: 800; letter-spacing: .14em;
                        text-transform: uppercase; color: #ff522b;
                    }
                    .pg-hero-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #2d1810; }
                    .pg-hero-sub { margin: 0; font-size: .95rem; font-weight: 600; color: #7a4f43; }
                    .pg-hero-art {
                        position: absolute; right: 0; bottom: 0;
                        height: 100%; width: auto; max-width: 58%;
                        z-index: 1; pointer-events: none;
                    }
                    @media (max-width: 767.98px) {
                        .pg-hero { padding: 1.5rem; min-height: 170px; }
                        .pg-hero-title { font-size: 1.6rem; }
                        .pg-hero-text { max-width: 100%; }
                        .pg-hero-art { opacity: .3; max-width: 80%; }
                    }
                </style>

                <div class="pg-hero">
                    <div class="pg-hero-text">
                        <span class="pg-hero-label">Surabaya</span>
                        <h2 class="pg-hero-title">Penghargaan</h2>
                        <p class="pg-hero-sub">Data Penghargaan Kota Surabaya</p>
                    </div>

                    <svg class="pg-hero-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                        <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#ffd8cc"/>
                        <circle cx="318" cy="22" r="46" fill="#ffbca8" opacity=".6"/>
                        <circle cx="46" cy="176" r="14" fill="#ffbca8"/>
                        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>

                        <!-- konfeti ceria -->
                        <circle cx="170" cy="58" r="4" fill="#ff522b"/>
                        <circle cx="292" cy="50" r="4" fill="#20c997"/>
                        <rect x="320" y="74" width="7" height="7" rx="1.5" transform="rotate(25 323 77)" fill="#ffb703"/>
                        <rect x="150" y="92" width="6" height="6" rx="1.5" transform="rotate(-20 153 95)" fill="#00b4d8"/>
                        <circle cx="266" cy="70" r="3.5" fill="#ffb703"/>
                        <polygon points="300,100 302.4,106 308.8,106.3 303.8,110.2 305.6,116.4 300,112.8 294.4,116.4 296.2,110.2 291.2,106.3 297.6,106" fill="#ffc300"/>

                        <!-- podium ceria -->
                        <rect x="140" y="158" width="60" height="28" rx="3" fill="#ff8566"/>
                        <rect x="200" y="140" width="60" height="46" rx="3" fill="#ff522b"/>
                        <rect x="260" y="164" width="60" height="22" rx="3" fill="#ffa38c"/>
                        <g fill="#fff" font-family="Arial, sans-serif" font-weight="800" text-anchor="middle">
                            <text x="230" y="172" font-size="22">1</text>
                            <text x="170" y="180" font-size="16">2</text>
                            <text x="290" y="181" font-size="14">3</text>
                        </g>

                        <!-- piala berkilau -->
                        <rect x="215" y="132" width="30" height="8" rx="2" fill="#fb8500"/>
                        <rect x="225" y="120" width="10" height="14" fill="#ffb703"/>
                        <path d="M204 78 H256 C256 108 246 120 230 120 C214 120 204 108 204 78 Z" fill="#ffc300"/>
                        <path d="M204 84 C188 84 188 106 208 108" stroke="#ffb703" stroke-width="5" stroke-linecap="round"/>
                        <path d="M256 84 C272 84 272 106 252 108" stroke="#ffb703" stroke-width="5" stroke-linecap="round"/>
                        <path d="M213 86 C213 100 217 108 222 112" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity=".6"/>
                        <polygon points="230,83 232.2,89 238.6,89.2 233.5,93.1 235.3,99.3 230,95.7 224.7,99.3 226.5,93.1 221.4,89.2 227.8,89" fill="#fff" opacity=".95"/>

                        <!-- medali ceria -->
                        <path d="M96 52 L118 52 L136 98 L114 98 Z" fill="#ff522b"/>
                        <path d="M140 52 L118 52 L100 98 L122 98 Z" fill="#e03e1b"/>
                        <circle cx="118" cy="116" r="20" fill="#ffc300"/>
                        <circle cx="118" cy="116" r="13" stroke="#fff" stroke-width="2" opacity=".7"/>
                        <polygon points="118,107 120,113 126.4,113.2 121.3,117.1 123.2,123.3 118,119.7 112.8,123.3 114.7,117.1 109.6,113.2 116,113" fill="#fff"/>

                        <!-- sertifikat -->
                        <g transform="rotate(6 371 140)">
                            <rect x="340" y="98" width="62" height="82" rx="4" fill="#fff"/>
                            <rect x="350" y="112" width="42" height="5" rx="2.5" fill="#ff522b"/>
                            <rect x="350" y="126" width="42" height="4" rx="2" fill="#ffe3dc"/>
                            <rect x="350" y="136" width="34" height="4" rx="2" fill="#ffe3dc"/>
                            <rect x="350" y="146" width="38" height="4" rx="2" fill="#ffe3dc"/>
                            <path d="M364 168 L360 182 L367 178 L374 182 L370 168 Z" fill="#ffb703"/>
                            <circle cx="367" cy="162" r="10" fill="#ffb703"/>
                            <circle cx="367" cy="162" r="5" stroke="#fff" stroke-width="1.5" opacity=".8"/>
                        </g>

                        <!-- tanaman ceria -->
                        <g stroke="#20c997" stroke-width="2.5" stroke-linecap="round"><path d="M70 188 L70 160"/><path d="M70 174 L61 164"/><path d="M70 168 L79 158"/></g>
                    </svg>
                </div>

                <!-- Card Utama -->
                <div class="card card-flush">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title flex-column">
                            <h2 class="fw-bold mb-1">Data Penghargaan</h2>
                            <span class="text-muted fs-7">Daftar capaian dan dokumentasi penghargaan Kota Surabaya</span>
                        </div>

                        <!-- Toolbar Filter & Button Tambah -->
                        <div class="card-toolbar gap-3">
                            <!-- Filter Kecamatan -->
                            <select id="filter_kecamatan" class="form-select form-select-solid w-175px" onchange="isiKel(document.getElementById('filter_kelurahan'), this.value, 'Semua Kelurahan'); terapkanFilter();">
                                <option value="">Semua Kecamatan</option>
                                @foreach ($wilUrut as $kidOpt => $wOpt)
                                    <option value="{{ $kidOpt }}">{{ $wOpt['nama'] }}</option>
                                @endforeach
                            </select>

                            <!-- Filter Kelurahan -->
                            <select id="filter_kelurahan" class="form-select form-select-solid w-175px" disabled>
                                <option value="">Semua Kelurahan</option>
                            </select>

                            <!-- Filter Tahun -->
                            <select id="filter_tahun" class="form-select form-select-solid w-125px">
                                <option value="">Semua Tahun</option>
                                @for ($t = 2030; $t >= 2020; $t--)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>

                            <!-- Tombol Tambah Penghargaan (Sunset Coral Ceria) -->
                            <button type="button" class="btn btn-emas fw-bold px-6"
                                data-bs-toggle="modal" data-bs-target="#modal_tambah_penghargaan">
                                <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Penghargaan
                            </button>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <!-- Input Search Real-time -->
                        <div class="d-flex align-items-center position-relative my-5">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5 text-gray-500"></i>
                            <input type="text" id="search_penghargaan"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search..." />
                        </div>

                        <!-- Tabel Data Penghargaan -->
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_penghargaan">
                                <thead>
                                    <tr class="text-start text-gray-900 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-50px">NO</th>
                                        <th>NAMA PENGHARGAAN</th>
                                        <th>DESKRIPSI PENGHARGAAN</th>
                                        <th>KATEGORI PENGHARGAAN</th>
                                        <th>TAHUN</th>
                                        <th>FOTO</th>
                                        <th>FILE</th>
                                        <th>DIBUAT OLEH</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-900">
                                    @if (isset($penghargaan) && count($penghargaan) > 0)
                                        @foreach ($penghargaan as $index =>$item)
                                            <tr data-kec="{{ $item->kecamatan_id ?? '' }}" data-kel="{{ $item->kelurahan_id ?? '' }}" data-tahun="{{ $item->tahun }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td class="fw-bold text-gray-800">{{ $item->nama_penghargaan }}</td>
                                                <td>{{ $item->deskripsi_penghargaan }}</td>
                                                <td><span
                                                        class="badge fw-bold fs-8 pg-hijau">{{ $item->kategori_penghargaan }}</span>
                                                </td>
                                                <td>{{ $item->tahun }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm fw-bold px-3 pg-hijau"
                                                        onclick="previewFoto('{{ asset('storage/' . $item->foto) }}')">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat Foto
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm fw-bold px-3 pg-hijau"
                                                        onclick="previewFile('{{ asset('storage/' . $item->file) }}')">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat File
                                                    </button>
                                                </td>
                                                <td>{{ $item->created_by ?? 'Admin' }}</td>
                                                <td class="text-end">
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-primary btn-sm me-1"
                                                        onclick="editPenghargaan({{ json_encode(array_merge($item->toArray(), ['id' => \App\Support\IdCipher::encode($item->id)])) }})">
                                                        <i class="ki-outline ki-pencil fs-2"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-light-danger btn-sm"
                                                        data-id="{{ \App\Support\IdCipher::encode($item->id) }}" data-nama="{{ $item->nama_penghargaan }}"
                                                        onclick="hapusPenghargaan(this.dataset.id, this.dataset.nama)">
                                                        <i class="ki-outline ki-trash fs-2"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-10 fs-6">Belum ada data
                                                penghargaan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Penghargaan -->
    <div class="modal fade" id="modal_tambah_penghargaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-emas">
                    <h2 class="fw-bold mb-0">Tambah Data Penghargaan</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('penghargaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-8 px-lg-10">
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Nama Penghargaan</label>
                            <input type="text" class="form-control form-control-solid" name="nama_penghargaan"
                                placeholder="Masukkan nama penghargaan" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Deskripsi Penghargaan</label>
                            <textarea class="form-control form-control-solid" rows="3" name="deskripsi_penghargaan"
                                placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kategori Penghargaan</label>
                                <input type="text" class="form-control form-control-solid" name="kategori_penghargaan"
                                    placeholder="Pemerintahan / Inovasi" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                                <input type="text" class="form-control form-control-solid" name="tahun"
                                    placeholder="2026" maxlength="4" required />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kecamatan</label>
                                <select class="form-select form-select-solid" id="add_kecamatan_id" name="kecamatan_id" required onchange="isiKel(document.getElementById('add_kelurahan_id'), this.value, 'Pilih Kelurahan')">
                                    <option value="">Pilih Kecamatan</option>
                                @foreach ($wilUrut as $kidOpt => $wOpt)
                                    <option value="{{ $kidOpt }}">{{ $wOpt['nama'] }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kelurahan</label>
                                <select class="form-select form-select-solid" id="add_kelurahan_id" name="kelurahan_id" required disabled>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Upload Foto (JPG/PNG, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="foto"
                                accept=".jpg,.jpeg,.png" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Upload File Dokumen (PDF/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file"
                                accept=".pdf,.docx" required />
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-simpan-hijau fw-bold px-8">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Penghargaan -->
    <div class="modal fade" id="modal_edit_penghargaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-emas">
                    <h2 class="fw-bold mb-0">Edit Data Penghargaan</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit_penghargaan" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-8 px-lg-10">
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Nama Penghargaan</label>
                            <input type="text" class="form-control form-control-solid" id="edit_nama_penghargaan" name="nama_penghargaan" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Deskripsi Penghargaan</label>
                            <textarea class="form-control form-control-solid" rows="3" id="edit_deskripsi_penghargaan" name="deskripsi_penghargaan" required></textarea>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kategori Penghargaan</label>
                                <input type="text" class="form-control form-control-solid" id="edit_kategori_penghargaan" name="kategori_penghargaan" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                                <input type="text" class="form-control form-control-solid" id="edit_tahun" name="tahun" maxlength="4" required />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kecamatan</label>
                                <select class="form-select form-select-solid" id="edit_kecamatan_id" name="kecamatan_id" onchange="isiKel(document.getElementById('edit_kelurahan_id'), this.value, 'Pilih Kelurahan')">
                                    <option value="">Pilih Kecamatan</option>
                                @foreach ($wilUrut as $kidOpt => $wOpt)
                                    <option value="{{ $kidOpt }}">{{ $wOpt['nama'] }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kelurahan</label>
                                <select class="form-select form-select-solid" id="edit_kelurahan_id" name="kelurahan_id"  disabled>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="fs-6 fw-semibold mb-2">Ganti Foto (Opsional, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="foto" accept=".jpg,.jpeg,.png" />
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                        <div class="mb-5">
                            <label class="fs-6 fw-semibold mb-2">Ganti File Dokumen (PDF/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file" accept=".pdf,.docx" />
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-simpan-hijau fw-bold px-8">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Foto -->
    <div class="modal fade" id="modal_preview_foto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Preview Foto Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <img id="img_preview" src="" class="img-fluid rounded shadow-sm" alt="Foto Penghargaan" />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview File Dokumen (PDF, DOC, DOCX) -->
    <div class="modal fade" id="modal_preview_file" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0 py-2 px-3 justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="file_preview_frame" src="" title="Preview File"
                        style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Hidden Delete -->
    <form id="form_delete_penghargaan" action="" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <script>
    // 1. Fungsi Edit Data
    function editPenghargaan(data) {
        $('#form_edit_penghargaan').attr('action', `/penghargaan/update/${data.id}`);
        $('#edit_nama_penghargaan').val(data.nama_penghargaan);
        $('#edit_deskripsi_penghargaan').val(data.deskripsi_penghargaan);
        $('#edit_kategori_penghargaan').val(data.kategori_penghargaan);
        $('#edit_tahun').val(data.tahun);
        $('#edit_kecamatan_id').val(data.kecamatan_id || '');
        isiKel(document.getElementById('edit_kelurahan_id'), data.kecamatan_id, 'Pilih Kelurahan', data.kelurahan_id);

        $('#modal_edit_penghargaan').modal('show');
    }

    // 2. Wilayah (kecamatan -> kelurahan) dari database
    var WILAYAH = @json($wil, JSON_FORCE_OBJECT);

    function urutNama(ids) {
        return ids.sort(function (x, y) { return String(WILAYAH[x].nama).localeCompare(String(WILAYAH[y].nama)); });
    }
    function isiKec(select, placeholder) {
        if (select.options.length > 1) return;   // sudah diisi oleh server
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        urutNama(Object.keys(WILAYAH)).forEach(function (id) { select.appendChild(new Option(WILAYAH[id].nama, id)); });
    }
    function isiKel(select, kecId, placeholder, terpilih) {
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        var list = (kecId && WILAYAH[kecId]) ? Object.values(WILAYAH[kecId].kel) : [];
        list.sort(function (x, y) { return String(x.nama).localeCompare(String(y.nama)); })
            .forEach(function (k) { select.appendChild(new Option(k.nama, k.id)); });
        select.disabled = list.length === 0;
        if (terpilih) select.value = terpilih;
    }

    // 2b. Filter tabel (Kecamatan, Kelurahan, Tahun) + pencarian
    var tabelPenghargaan = null;

    function cocokFilter(tr) {
        var kec = document.getElementById('filter_kecamatan').value;
        var kel = document.getElementById('filter_kelurahan').value;
        var thn = document.getElementById('filter_tahun').value;
        if (kec && tr.dataset.kec !== kec) return false;
        if (kel && tr.dataset.kel !== kel) return false;
        if (thn && tr.dataset.tahun !== thn) return false;
        return true;
    }
    function terapkanFilter() {
        if (tabelPenghargaan) { tabelPenghargaan.draw(); return; }
        var q = document.getElementById('search_penghargaan').value.toLowerCase();
        document.querySelectorAll('#kt_table_penghargaan tbody tr').forEach(function (tr) {
            var tampil = cocokFilter(tr) && tr.textContent.toLowerCase().indexOf(q) !== -1;
            tr.style.display = tampil ? '' : 'none';
        });
    }

    // 3. Pop-Up Preview Foto (Mendukung JPG, PNG, dll)
    function previewFoto(url) {
        if (!url || url.includes('/storage/')) {
            var cleanUrl = url.trim();
            if (cleanUrl.endsWith('/storage/') || cleanUrl.endsWith('/storage')) {
                tampilPopup({ icon: 'warning', title: 'Foto Tidak Ada', text: 'File foto belum diunggah atau tidak ditemukan.' });
                return;
            }
        }
        $('#img_preview').attr('src', url);
        $('#modal_preview_foto').modal('show');
    }

    // 3b. Pop-Up Preview File: PDF dan Word tampil langsung di dalam pop-up
    function muatSkrip(src) {
        return new Promise(function (ok, gagal) {
            var sudah = document.querySelector('script[data-lib="' + src + '"]');
            if (sudah) { ok(); return; }
            var el = document.createElement('script');
            el.src = src; el.dataset.lib = src;
            el.onload = ok; el.onerror = gagal;
            document.head.appendChild(el);
        });
    }
    function kartuUnduh(url, pesan) {
        return '<div class="d-flex flex-column align-items-center justify-content-center p-10 text-center" style="min-height: 50vh;">' +
            '<div class="symbol symbol-100px mb-5"><span class="symbol-label" style="background-color: #e6f7ec;">' +
            '<i class="ki-outline ki-file-down fs-5x" style="color: #1f9d55;"></i></span></div>' +
            '<h3 class="fw-bold text-gray-900 mb-2">Dokumen tidak bisa ditampilkan</h3>' +
            '<p class="text-gray-600 mb-6 fs-6" style="max-width: 420px;">' + pesan + '</p>' +
            '<a href="' + url + '" download class="btn btn-simpan-hijau fw-bold px-8 py-3"><i class="ki-outline ki-download fs-3 me-2 text-white"></i> Download File</a>' +
            '</div>';
    }
    function previewFile(url) {
        if (!url || url.includes('/storage/')) {
            var cleanUrl = url.trim();
            if (cleanUrl.endsWith('/storage/') || cleanUrl.endsWith('/storage')) {
                tampilPopup({ icon: 'warning', title: 'File Tidak Ada', text: 'Dokumen file belum diunggah atau tidak ditemukan.' });
                return;
            }
        }

        var ext = url.split('?')[0].split('.').pop().toLowerCase();
        var $modalBody = $('#modal_preview_file .modal-body');

        if (ext === 'pdf') {
            $modalBody.html('<iframe id="file_preview_frame" src="' + url + '" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>');
        } else if (ext === 'docx') {
            $modalBody.html('<div id="docx_container"><div class="text-center text-gray-600 py-10"><span class="spinner-border spinner-border-sm me-2"></span>Memuat dokumen...</div></div>');
            Promise.all([
                muatSkrip('https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js')
            ]).then(function () {
                return muatSkrip('https://cdn.jsdelivr.net/npm/docx-preview@0.3.3/dist/docx-preview.min.js');
            }).then(function () {
                return fetch(url).then(function (r) { if (!r.ok) throw new Error('gagal'); return r.blob(); });
            }).then(function (blob) {
                var box = document.getElementById('docx_container');
                box.innerHTML = '';
                return docx.renderAsync(blob, box, null, { inWrapper: true, ignoreWidth: false });
            }).catch(function () {
                $modalBody.html(kartuUnduh(url, 'Silakan unduh dokumen untuk melihat isinya.'));
            });
        } else {
            // .doc lama tidak bisa dirender di browser
            var host = window.location.hostname;
            var lokal = host === 'localhost' || host === '127.0.0.1' || host.startsWith('10.') || host.startsWith('192.168.') || host.endsWith('.test') || host.endsWith('.local');
            if (lokal) {
                $modalBody.html(kartuUnduh(url, 'File berformat .doc (Word lama) hanya bisa dibuka setelah diunduh.'));
            } else {
                var officeUrl = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url);
                $modalBody.html('<iframe id="file_preview_frame" src="' + officeUrl + '" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>');
            }
        }

        $('#modal_preview_file').modal('show');
    }

    // 4. Pop-up Konfirmasi & Proses Hapus
    function hapusPenghargaan(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin menghapus ${nama}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger fw-bold px-6 me-2',
                cancelButton: 'btn btn-success fw-bold px-6'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('form_delete_penghargaan');
                form.action = `/penghargaan/delete/${id}`;
                form.submit();
            }
        });
    }

    // 5. Pop-up notifikasi (SweetAlert2)
    function tampilPopup(opsi) {
        if (typeof Swal === 'undefined') { alert(opsi.text || opsi.title); return null; }
        return Swal.fire(Object.assign({
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'btn fw-bold px-6 ' + (opsi.icon === 'error' ? 'btn-danger' : 'btn-success')
            }
        }, opsi));
    }

    // Dijalankan setelah DOM & jQuery siap
    document.addEventListener('DOMContentLoaded', function () {

        // Reset konten iframe modal saat modal file ditutup
        $('#modal_preview_file').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('<iframe id="file_preview_frame" src="" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>');
        });

        @if (session('success_store'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Berhasil menambahkan data' });
        @endif

        @if (session('success_update') || session('success'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Data berhasil diedit', iconColor: '#22c55e' });
        @endif

        @if (session('success_delete'))
            tampilPopup({ icon: 'success', title: 'Berhasil Dihapus', text: @json(session('success_delete')) });
        @endif

        @if ($errors->any())
            tampilPopup({ icon: 'error', title: 'Gagal Simpan Data', html: @json(implode('<br>', array_map('e', $errors->all()))) });
        @endif

        @if (session('error'))
            tampilPopup({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
        @endif

        // Edit data dikirim tanpa pindah halaman, lalu pop-up berhasil ditampilkan langsung
        $('#form_edit_penghargaan').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var tombol = form.querySelector('button[type=submit]');
            tombol.disabled = true;
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (body) { return { ok: res.ok, body: body }; });
            }).then(function (hasil) {
                tombol.disabled = false;
                if (hasil.ok) {
                    $('#modal_edit_penghargaan').modal('hide');
                    var p = tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Data berhasil diedit', iconColor: '#22c55e' });
                    if (p && p.then) { p.then(function () { location.reload(); }); } else { location.reload(); }
                } else {
                    var pesan = hasil.body.message || 'Gagal menyimpan perubahan.';
                    if (hasil.body.errors) { pesan = Object.values(hasil.body.errors)[0][0]; }
                    tampilPopup({ icon: 'error', title: 'Gagal Simpan Data', text: pesan });
                }
            }).catch(function () {
                tombol.disabled = false;
                tampilPopup({ icon: 'error', title: 'Gagal', text: 'Tidak bisa terhubung ke server.' });
            });
        });

        // Batas ukuran file 2MB (server juga memeriksa)
        document.querySelectorAll('#modal_tambah_penghargaan input[type=file], #modal_edit_penghargaan input[type=file]').forEach(function (inp) {
            inp.addEventListener('change', function () {
                var f = this.files[0];
                if (f && f.size > 2 * 1024 * 1024) {
                    this.value = '';
                    tampilPopup({ icon: 'error', title: 'File Terlalu Besar', text: 'Ukuran file maksimal 2MB.' });
                }
            });
        });

        // Isi dropdown wilayah
        isiKec(document.getElementById('filter_kecamatan'), 'Semua Kecamatan');
        isiKec(document.getElementById('add_kecamatan_id'), 'Pilih Kecamatan');
        isiKec(document.getElementById('edit_kecamatan_id'), 'Pilih Kecamatan');

        $('#filter_kecamatan').on('change', function () {
            isiKel(document.getElementById('filter_kelurahan'), this.value, 'Semua Kelurahan');
            terapkanFilter();
        });
        $('#filter_kelurahan, #filter_tahun').on('change', terapkanFilter);

        $('#add_kecamatan_id').on('change', function () {
            isiKel(document.getElementById('add_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });
        $('#edit_kecamatan_id').on('change', function () {
            isiKel(document.getElementById('edit_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });

        // Tabel + pencarian DataTables
        try {
            var punyaData = $('#kt_table_penghargaan tbody tr td[colspan]').length === 0;
            if ($.fn.DataTable && punyaData) {
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (settings.nTable.id !== 'kt_table_penghargaan') return true;
                    return cocokFilter(settings.aoData[dataIndex].nTr);
                });
                tabelPenghargaan = $('#kt_table_penghargaan').DataTable({ "info": false, 'order': [], 'pageLength': 10 });
                $('#search_penghargaan').on('keyup', function () { tabelPenghargaan.search(this.value).draw(); });
            } else {
                $('#search_penghargaan').on('input', terapkanFilter);
            }
        } catch (e) { console.error(e); }
    });
</script>
@endsection
