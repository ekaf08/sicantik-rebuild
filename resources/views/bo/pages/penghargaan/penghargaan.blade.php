@extends('bo.layout.app')

@section('content')
    @php
        // Peta wilayah dari database: { id_kecamatan: { nama, kel: [ {id, nama} ] } }
        $wil = [];
        foreach (($kecamatan ?? []) as $k) {
            if (!empty($k->deleted_at ?? null)) { continue; }
            $kid = $k->id_kec ?? ($k->id_kecamatan ?? ($k->id ?? null));
            if ($kid === null) { continue; }
            $wil[$kid] = ['nama' => $k->nama_kec ?? ($k->nama_kecamatan ?? ($k->nama ?? '')), 'kel' => []];
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
    @endphp
    <!-- SweetAlert2 untuk pop-up notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* Styling Tabel Grid Komprehensif (Sesuai Referensi Gambar) */
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

    /* Tombol & header modal bernuansa emas */
    .btn-emas { background-color: #e2b24a; color: #5a4310 !important; border: 0; }
    .btn-emas:hover, .btn-emas:focus { background-color: #d9a63a; color: #5a4310 !important; }
    .btn-emas i { color: #5a4310 !important; }
    .modal-header-emas { background-color: #f3e3b8; border-bottom: 0; }
    .modal-header-emas h2 { color: #5a4310; }
</style>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">

                <!-- Banner Penghargaan (pastel emas) -->
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
                        background: #fbf1d9;
                    }
                    .pg-hero-text { position: relative; z-index: 2; max-width: 52%; }
                    .pg-hero-label {
                        display: block; margin-bottom: .5rem;
                        font-size: .72rem; font-weight: 700; letter-spacing: .14em;
                        text-transform: uppercase; color: #c99a2e;
                    }
                    .pg-hero-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #5a4310; }
                    .pg-hero-sub { margin: 0; font-size: .95rem; font-weight: 500; color: #7d6a3a; }
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
                        <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#f3e3b8"/>
                        <circle cx="318" cy="22" r="46" fill="#edd9a0" opacity=".6"/>
                        <circle cx="46" cy="176" r="14" fill="#edd9a0"/>
                        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>

                        <!-- konfeti -->
                        <circle cx="170" cy="58" r="3.5" fill="#e9a0a0"/>
                        <circle cx="292" cy="50" r="3.5" fill="#7fa58f"/>
                        <rect x="320" y="74" width="7" height="7" rx="1.5" transform="rotate(25 323 77)" fill="#e8b83f"/>
                        <rect x="150" y="92" width="6" height="6" rx="1.5" transform="rotate(-20 153 95)" fill="#7fa58f"/>
                        <circle cx="266" cy="70" r="3" fill="#e8b83f"/>
                        <polygon points="300,100 302.4,106 308.8,106.3 303.8,110.2 305.6,116.4 300,112.8 294.4,116.4 296.2,110.2 291.2,106.3 297.6,106" fill="#f2c14e"/>

                        <!-- podium -->
                        <rect x="140" y="158" width="60" height="28" rx="3" fill="#ebcb80"/>
                        <rect x="200" y="140" width="60" height="46" rx="3" fill="#e2b24a"/>
                        <rect x="260" y="164" width="60" height="22" rx="3" fill="#efd596"/>
                        <g fill="#fff" font-family="Georgia, 'Times New Roman', serif" font-weight="700" text-anchor="middle">
                            <text x="230" y="172" font-size="22">1</text>
                            <text x="170" y="180" font-size="16">2</text>
                            <text x="290" y="181" font-size="14">3</text>
                        </g>

                        <!-- piala -->
                        <rect x="215" y="132" width="30" height="8" rx="2" fill="#c8922a"/>
                        <rect x="225" y="120" width="10" height="14" fill="#d9a53a"/>
                        <path d="M204 78 H256 C256 108 246 120 230 120 C214 120 204 108 204 78 Z" fill="#e8b83f"/>
                        <path d="M204 84 C188 84 188 106 208 108" stroke="#d9a53a" stroke-width="5" stroke-linecap="round"/>
                        <path d="M256 84 C272 84 272 106 252 108" stroke="#d9a53a" stroke-width="5" stroke-linecap="round"/>
                        <path d="M213 86 C213 100 217 108 222 112" stroke="#fff" stroke-width="3" stroke-linecap="round" opacity=".5"/>
                        <polygon points="230,83 232.2,89 238.6,89.2 233.5,93.1 235.3,99.3 230,95.7 224.7,99.3 226.5,93.1 221.4,89.2 227.8,89" fill="#fff" opacity=".92"/>

                        <!-- medali -->
                        <path d="M96 52 L118 52 L136 98 L114 98 Z" fill="#7fa58f"/>
                        <path d="M140 52 L118 52 L100 98 L122 98 Z" fill="#6e9988"/>
                        <circle cx="118" cy="116" r="20" fill="#e8b83f"/>
                        <circle cx="118" cy="116" r="13" stroke="#fff" stroke-width="2" opacity=".6"/>
                        <polygon points="118,107 120,113 126.4,113.2 121.3,117.1 123.2,123.3 118,119.7 112.8,123.3 114.7,117.1 109.6,113.2 116,113" fill="#fff" opacity=".9"/>

                        <!-- sertifikat -->
                        <g transform="rotate(6 371 140)">
                            <rect x="340" y="98" width="62" height="82" rx="4" fill="#fff"/>
                            <rect x="350" y="112" width="42" height="5" rx="2.5" fill="#e8b83f"/>
                            <rect x="350" y="126" width="42" height="4" rx="2" fill="#e8dfc4"/>
                            <rect x="350" y="136" width="34" height="4" rx="2" fill="#e8dfc4"/>
                            <rect x="350" y="146" width="38" height="4" rx="2" fill="#e8dfc4"/>
                            <path d="M364 168 L360 182 L367 178 L374 182 L370 168 Z" fill="#d98585"/>
                            <circle cx="367" cy="162" r="10" fill="#d98585"/>
                            <circle cx="367" cy="162" r="5" stroke="#fff" stroke-width="1.5" opacity=".7"/>
                        </g>

                        <!-- tunas dekor -->
                        <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M70 188 L70 160"/><path d="M70 174 L61 164"/><path d="M70 168 L79 158"/></g>
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
                            <select id="filter_kecamatan" class="form-select form-select-solid w-175px">
                                <option value="">Semua Kecamatan</option>
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

                            <!-- Tombol Tambah Penghargaan (emas) -->
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
                                                        class="badge badge-light-success fw-bold fs-8">{{ $item->kategori_penghargaan }}</span>
                                                </td>
                                                <td>{{ $item->tahun }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-light-success fw-bold px-3"
                                                        onclick="previewFoto('{{ asset('storage/' . $item->foto) }}')">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat Foto
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-light-success fw-bold px-3"
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
                                                        onclick="hapusPenghargaan('{{ \App\Support\IdCipher::encode($item->id) }}', '{{ $item->nama_penghargaan }}')">
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
                                <select class="form-select form-select-solid" id="add_kecamatan_id" name="kecamatan_id" required>
                                    <option value="">Pilih Kecamatan</option>
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
                            <label class="required fs-6 fw-semibold mb-2">Upload File Dokumen (PDF/DOC/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file"
                                accept=".pdf,.doc,.docx" required />
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-emas fw-bold px-8">Simpan</button>
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
                                <select class="form-select form-select-solid" id="edit_kecamatan_id" name="kecamatan_id" >
                                    <option value="">Pilih Kecamatan</option>
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
                            <label class="fs-6 fw-semibold mb-2">Ganti File Dokumen (PDF/DOC/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file" accept=".pdf,.doc,.docx" />
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-emas fw-bold px-8">Update Data</button>
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

        var modalEdit = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_edit_penghargaan'));
        modalEdit.show();
    }

    // 2. Wilayah (kecamatan -> kelurahan) dari database
    var WILAYAH = @json($wil, JSON_FORCE_OBJECT);

    function urutNama(ids) {
        return ids.sort(function (x, y) { return String(WILAYAH[x].nama).localeCompare(String(WILAYAH[y].nama)); });
    }
    function isiKec(select, placeholder) {
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

    // 3. Preview Foto
    function previewFoto(url) {
        $('#img_preview').attr('src', url);
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_preview_foto'));
        modal.show();
    }

    // 3b. Preview File Dokumen (PDF, DOC, DOCX) yang aman untuk LAN & Production
    function previewFile(url) {
    var ext = url.split('?')[0].split('.').pop().toLowerCase();
    var modalBody = document.getElementById('file_preview_frame').parentNode;

    // 1. Jika file PDF -> langsung render di iframe pop-up modal
    if (ext === 'pdf') {
        modalBody.innerHTML = '<iframe id="file_preview_frame" src="' + url + '" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>';
    }
    // 2. Jika file Word (DOC / DOCX)
    else {
        var host = window.location.hostname;
        // Cek apakah diakses dari localhost atau IP LAN Kominfo (10.x.x.x / 192.168.x.x)
        var isLocalOrIntranet = host === 'localhost' ||
                                host === '127.0.0.1' ||
                                host.startsWith('10.') ||
                                host.startsWith('192.168.') ||
                                host.endsWith('.test') ||
                                host.endsWith('.local');

        if (isLocalOrIntranet) {
            // Di Jaringan LAN / Localhost: Tampilkan kartu info rapi + tombol unduh/buka langsung di modal
            modalBody.innerHTML =
                '<div class="d-flex flex-column align-items-center justify-content-center p-10 text-center" style="height: 60vh;">' +
                    '<div class="symbol symbol-100px mb-5">' +
                        '<span class="symbol-label bg-light-primary">' +
                            '<i class="ki-outline ki-file-down text-primary fs-5x"></i>' +
                        '</span>' +
                    '</div>' +
                    '<h3 class="fw-bold text-gray-900 mb-2">Dokumen Word (.doc / .docx)</h3>' +
                    '<p class="text-gray-600 mb-6 fs-6 max-w-400px">' +
                        'Karena sedang diakses via jaringan LAN/Lokal, preview instan Word dibatasi.<br>Silakan unduh atau buka dokumen untuk melihat isinya.' +
                    '</p>' +
                    '<a href="' + url + '" download class="btn btn-primary fw-bold px-8 py-3 me-2">' +
                        '<i class="ki-outline ki-download fs-3 me-2"></i> Download File' +
                    '</a>' +
                    '<a href="' + url + '" target="_blank" class="btn btn-light-primary fw-bold px-8 py-3">' +
                        '<i class="ki-outline ki-exit-right-corner fs-3 me-2"></i> Buka di Tab Baru' +
                    '</a>' +
                '</div>';
        } else {
            // Di Server Online (Publik): Render otomatis via Office Viewer Resmi
            var officeUrl = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url);
            modalBody.innerHTML = '<iframe id="file_preview_frame" src="' + officeUrl + '" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>';
        }
    }

    bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_preview_file')).show();
}

// Reset iframe/modal saat ditutup
document.getElementById('modal_preview_file').addEventListener('hidden.bs.modal', function () {
    document.getElementById('file_preview_frame').parentNode.innerHTML = '<iframe id="file_preview_frame" src="" title="Preview File" style="width: 100%; height: 78vh; border: 0; display: block;"></iframe>';
});

    // Kosongkan PDF/Doc saat pop up ditutup supaya tidak terus dimuat di belakang
    document.getElementById('modal_preview_file').addEventListener('hidden.bs.modal', function () {
        document.getElementById('file_preview_frame').src = '';
    });

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

    // 5. Pop-up notifikasi (hijau = berhasil, merah = gagal)
    function tampilPopup(opsi) {
        if (typeof Swal === 'undefined') { alert(opsi.text || opsi.title); return; }
        Swal.fire(Object.assign({
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'btn fw-bold px-6 ' + (opsi.icon === 'error' ? 'btn-danger' : 'btn-success')
            }
        }, opsi));
    }

    // Dijalankan setelah SEMUA script halaman (jQuery, DataTables, SweetAlert) selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {

        @if (session('success_store'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Berhasil menambahkan data' });
        @endif

        @if (session('success_update') || session('success'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Edit data telah berhasil' });
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

        // Isi dropdown wilayah
        isiKec(document.getElementById('filter_kecamatan'), 'Semua Kecamatan');
        isiKec(document.getElementById('add_kecamatan_id'), 'Pilih Kecamatan');
        isiKec(document.getElementById('edit_kecamatan_id'), 'Pilih Kecamatan');

        document.getElementById('filter_kecamatan').addEventListener('change', function () {
            isiKel(document.getElementById('filter_kelurahan'), this.value, 'Semua Kelurahan');
            terapkanFilter();
        });
        document.getElementById('filter_kelurahan').addEventListener('change', terapkanFilter);
        document.getElementById('filter_tahun').addEventListener('change', terapkanFilter);

        document.getElementById('add_kecamatan_id').addEventListener('change', function () {
            isiKel(document.getElementById('add_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });
        document.getElementById('edit_kecamatan_id').addEventListener('change', function () {
            isiKel(document.getElementById('edit_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });

        // Tabel + pencarian
        try {
            var punyaData = document.querySelectorAll('#kt_table_penghargaan tbody tr td[colspan]').length === 0;
            if (window.jQuery && $.fn.DataTable && punyaData) {
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (settings.nTable.id !== 'kt_table_penghargaan') return true;
                    return cocokFilter(settings.aoData[dataIndex].nTr);
                });
                tabelPenghargaan = $('#kt_table_penghargaan').DataTable({ "info": false, 'order': [], 'pageLength': 10 });
                $('#search_penghargaan').on('keyup', function () { tabelPenghargaan.search(this.value).draw(); });
            } else {
                document.getElementById('search_penghargaan').addEventListener('input', terapkanFilter);
            }
        } catch (e) { console.error(e); }
    });
</script>
@endsection
