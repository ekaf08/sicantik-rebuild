@extends('bo.layout.app')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">

                <!-- Banner Header Hijau Tema SiCantik -->
                <div class="card mb-7 border-0 position-relative overflow-hidden"
                    style="background-color: #0d5c3a; border-radius: 12px;">
                    <div
                        class="card-body p-8 text-white d-flex align-items-center justify-content-between position-relative z-index-1">
                        <div>
                            <h1 class="text-white fw-bolder fs-2hx mb-2" style="letter-spacing: 0.5px;">PENGHARGAAN</h1>
                            <p class="fs-6 text-white opacity-80 mb-0">Data Penghargaan Kota Surabaya</p>
                        </div>
                    </div>
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
                            <select id="filter_kecamatan" class="form-select form-select-solid w-175px"
                                onchange="loadKelurahan(this.value)">
                                <option value="">Pilih Kecamatan</option>
                                @if (isset($kecamatan))
                                    @foreach ($kecamatan as $kec)
                                        <option value="{{ $kec->id_kec ?? ($kec->id_kecamatan ?? ($kec->id ?? '')) }}">
                                            {{ $kec->nama_kecamatan ?? ($kec->nama_kec ?? ($kec->nama ?? '')) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <!-- Filter Kelurahan (Dinamis AJAX) -->
                            <select id="filter_kelurahan" class="form-select form-select-solid w-175px">
                                <option value="">Pilih Kelurahan</option>
                            </select>

                            <!-- Filter Tahun (Manual Statis agar tidak error loop) -->
                            <select id="filter_tahun" class="form-select form-select-solid w-125px">
                                <option value="">Tahun</option>
                                <option value="2026">2026</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>

                            <!-- Tombol Tambah Penghargaan Hijau Tema -->
                            <button type="button" class="btn fw-bold text-white px-6" style="background-color: #0d5c3a;"
                                data-bs-toggle="modal" data-bs-target="#modal_tambah_penghargaan">
                                <i class="ki-outline ki-plus fs-2 text-white me-1"></i> Tambah Penghargaan
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
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
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
                                <tbody class="fw-semibold text-gray-600">
                                    @if (isset($penghargaan) && count($penghargaan) > 0)
                                        @foreach ($penghargaan as $index =>$item)
                                            <tr>
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
                                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                        class="btn btn-sm btn-light-success fw-bold px-3">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat File
                                                    </a>
                                                </td>
                                                <td>{{ $item->created_by ?? 'Admin' }}</td>
                                                <td class="text-end">
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-primary btn-sm me-1"
                                                        onclick="editPenghargaan({{ json_encode($item) }})">
                                                        <i class="ki-outline ki-pencil fs-2"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-light-danger btn-sm"
                                                        onclick="hapusPenghargaan('{{ $item->id }}', '{{$item->nama_penghargaan }}')">
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
                <div class="modal-header" style="background-color: #0d5c3a;">
                    <h2 class="fw-bold text-white mb-0">Tambah Data Penghargaan</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
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
                        <button type="submit" class="btn fw-bold text-white px-8"
                            style="background-color: #0d5c3a;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Penghargaan -->
    <div class="modal fade" id="modal_edit_penghargaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0d5c3a;">
                    <h2 class="fw-bold text-white mb-0">Edit Data Penghargaan</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button type="submit" class="btn fw-bold text-white px-8" style="background-color: #0d5c3a;">Update Data</button>
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

        var modalEdit = new bootstrap.Modal(document.getElementById('modal_edit_penghargaan'));
        modalEdit.show();
    }

    // 2. Load Kelurahan Dinamis
    function loadKelurahan(kecamatanId) {
        let $kelurahan =$('#filter_kelurahan');
        $kelurahan.html('<option value="">Memuat Kelurahan...</option>');

        if (!kecamatanId) {
            $kelurahan.html('<option value="">Pilih Kelurahan</option>');
            return;
        }

        fetch(`/get-kelurahan/${kecamatanId}`)
            .then(res => res.json())
            .then(data => {
                let html = '<option value="">Pilih Kelurahan</option>';
                if (data && data.length > 0) {
                    data.forEach(item => {
                        let id = item.id_kel ?? item.id_kelurahan ?? item.id ?? '';
                        let nama = item.nama_kelurahan ?? item.nama_kel ?? item.nama ?? '';
                        html += `<option value="${id}">${nama}</option>`;
                    });
                } else {
                    html = '<option value="">Tidak ada kelurahan</option>';
                }
                $kelurahan.html(html);
            })
            .catch(err => {
                console.error('Error:', err);
                $kelurahan.html('<option value="">Pilih Kelurahan</option>');
            });
    }

    // 3. Preview Foto
    function previewFoto(url) {
        $('#img_preview').attr('src', url);
        var modal = new bootstrap.Modal(document.getElementById('modal_preview_foto'));
        modal.show();
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

                sessionStorage.setItem('flash_delete_success', `${nama} berhasil dihapus`);
                form.submit();
            }
        });
    }

    // 5. Inisialisasi DataTables & Pop-Up SweetAlert
    $(document).ready(function() {
        var table = $('#kt_table_penghargaan').DataTable({
            "info": false,
            'order': [],
            'pageLength': 10
        });

        $('#search_penghargaan').on('keyup', function() {
            table.search(this.value).draw();
        });

        // --- Cek Notifikasi Setelah Delete (Merah) ---
        let deleteMsg = sessionStorage.getItem('flash_delete_success');
        if (deleteMsg) {
            Swal.fire({
                icon: 'error',
                title: 'Berhasil Dihapus',
                text: deleteMsg,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger fw-bold px-6'
                },
                buttonsStyling: false
            });
            sessionStorage.removeItem('flash_delete_success');
        }

        // --- Pop-Up Tambah Data Berhasil (Centang Hijau) ---
        @if(session('success_store'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Berhasil menambahkan data',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-success fw-bold px-6'
                },
                buttonsStyling: false
            });
        @endif

        // --- Pop-Up Edit Data Berhasil (Centang Hijau) ---
        @if(session('success_update') || session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Edit data telah berhasil',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-success fw-bold px-6'
                },
                buttonsStyling: false
            });
        @endif

        // --- Pop-Up Error Validasi / Database ---
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Simpan Data',
                html: '{!! implode("<br>", $errors->all()) !!}',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger fw-bold px-6'
                },
                buttonsStyling: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session("error") }}',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger fw-bold px-6'
                },
                buttonsStyling: false
            });
        @endif
    });
</script>
@endsection
