@extends('bo.layout.app')

@section('content')
<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Banner Header Penghargaan -->
<div class="card border-0 shadow-sm rounded-4 mb-6 overflow-hidden" style="background-color: #0d6e5a !important;">
    <div class="card-body p-8 p-lg-10 position-relative d-flex align-items-center justify-content-between">
        <!-- Teks Banner -->
        <div class="text-white z-index-2">
            <h1 class="fw-bolder text-white fs-2hx mb-2 text-uppercase tracking-wide">PENGHARGAAN</h1>
            <p class="fs-6 fw-semibold text-white-50 m-0">Data Penghargaan</p>
        </div>

        <!-- Hiasan Ornamen Gedung -->
        <div class="position-absolute end-0 bottom-0 top-0 d-none d-md-flex align-items-end pe-6 opacity-25 pointer-events-none" style="max-height: 100%;">
            <svg width="220" height="110" viewBox="0 0 220 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M160 110V20L170 0L180 20V110H160Z" fill="#ffffff" />
                <path d="M185 110V45H200V110H185Z" fill="#ffffff" />
                <path d="M205 110V60H218V110H205Z" fill="#ffffff" />
                <path d="M140 110C140 80 110 50 70 50C30 50 0 80 0 110H140Z" fill="#ffffff" />
            </svg>
        </div>
    </div>
</div>

<!-- Card Utama Data Penghargaan -->
<div class="card card-flush border-0 shadow-sm rounded-4 mb-6">
    <div class="card-header align-items-center border-0 pt-6 px-6">
        <div>
            <h3 class="card-title fw-bolder text-gray-900 fs-3 m-0">Data Penghargaan</h3>
            <span class="text-gray-500 fs-8 fw-semibold">Daftar capaian dan dokumentasi penghargaan Kota Surabaya</span>
        </div>

        <!-- Filter Wilayah & Tahun Atas -->
        <div class="card-toolbar d-flex flex-wrap align-items-center gap-3">
            <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kecamatan">
                <option value="KOTA SURABAYA" selected>KOTA SURABAYA</option>
            </select>

            <select class="form-select form-select-solid w-175px fs-7 fw-semibold" id="filter-kelurahan">
                <option value="" selected>Pilih Kelurahan</option>
            </select>

            <select class="form-select form-select-solid w-100px fs-7 fw-semibold" id="filter-tahun">
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>

            <button type="button" class="btn btn-primary fw-bold fs-7 px-5 rounded-3" style="background-color: #0d9488 !important; border-color: #0d9488 !important;" data-bs-toggle="modal" data-bs-target="#modal_tambah_penghargaan">
                <i class="ki-outline ki-plus fs-3 text-white me-1"></i> Tambah Penghargaan
            </button>
        </div>
    </div>

    <div class="card-body p-6">
        <!-- Controls Show Entries & Search -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-6">
            <div class="d-flex align-items-center gap-2">
                <span class="text-gray-600 fs-7 fw-semibold">Show</span>
                <select class="form-select form-select-solid w-75px fs-7 fw-bold">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="d-flex align-items-center position-relative ms-auto">
                <span class="text-gray-600 fs-7 fw-semibold me-2">Search:</span>
                <input type="text" class="form-control form-control-solid w-200px fs-7 fw-semibold" placeholder="" />
            </div>
        </div>

        <!-- Tabel Data Penghargaan -->
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-7 gy-4 gs-4">
                <thead>
                    <tr class="fw-bolder text-gray-700 bg-light-subtle text-uppercase border-bottom">
                        <th class="w-50px text-center">NO</th>
                        <th>NAMA PENGHARGAAN</th>
                        <th>DESKRIPSI PENGHARGAAN</th>
                        <th>KATEGORI PENGHARGAAN</th>
                        <th class="text-center">TAHUN</th>
                        <th class="text-center">FOTO</th>
                        <th class="text-center">FILE</th>
                        <th>DIBUAT OLEH</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600" id="tbody-penghargaan">
                    @forelse($penghargaans as $index =>$item)
                    <tr>
                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold text-gray-800">{{ $item->nama_penghargaan }}</td>
                        <td>{{ $item->deskripsi_penghargaan }}</td>
                        <td><span class="badge badge-light-success fw-bold px-3 py-2 text-success">{{ $item->kategori_penghargaan }}</span></td>
                        <td class="text-center">{{ $item->tahun }}</td>
                        <td class="text-center">
                            @if($item->foto)
                                <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="badge badge-light-primary fw-bold text-decoration-none">
                                    <i class="ki-outline ki-picture fs-5 text-primary me-1"></i> Lihat Foto
                                </a>
                            @else
                                <span class="badge badge-light-secondary">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->file)
                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="badge badge-light-info fw-bold text-decoration-none">
                                    <i class="ki-outline ki-file-down fs-5 text-info me-1"></i> Download
                                </a>
                            @else
                                <span class="badge badge-light-secondary">-</span>
                            @endif
                        </td>
                        <td>{{ $item->created_by }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-light-success rounded-circle me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $item->id }}">
                                <i class="ki-outline ki-pencil fs-5 text-success"></i>
                            </button>
                            <form action="{{ route('penghargaan.destroy', $item->id) }}" method="POST" class="d-inline" id="form-delete-{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger rounded-circle" title="Hapus" onclick="hapusPenghargaan('{{ $item->id }}', '{{$item->nama_penghargaan }}')">
                                    <i class="ki-outline ki-trash fs-5 text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <!-- Tampilan Sampel/Dummy jika Database Belum Ada -->
                    <tr>
                        <td class="text-center fw-bold">1</td>
                        <td class="fw-bold text-gray-800">Penghargaan SPBE Terbaik</td>
                        <td>Inovasi Digitalisasi Pelayanan Publik Terintegrasi</td>
                        <td><span class="badge badge-light-success fw-bold px-3 py-2 text-success">Pemerintahan</span></td>
                        <td class="text-center">2026</td>
                        <td class="text-center">
                            <span class="badge badge-light-primary fw-bold cursor-pointer"><i class="ki-outline ki-picture fs-5 text-primary me-1"></i> Lihat Foto</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="badge badge-light-info fw-bold text-decoration-none"><i class="ki-outline ki-file-down fs-5 text-info me-1"></i> Download</a>
                        </td>
                        <td>Admin Kominfo</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-light-success rounded-circle me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#modal_edit_dummy">
                                <i class="ki-outline ki-pencil fs-5 text-success"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-light-danger rounded-circle" title="Hapus" onclick="hapusPenghargaan('dummy', 'Penghargaan SPBE Terbaik')">
                                <i class="ki-outline ki-trash fs-5 text-danger"></i>
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Penghargaan -->
<div class="modal fade" id="modal_tambah_penghargaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Tambah Data Penghargaan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form action="{{ route('penghargaan.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return simpanPenghargaan(event)">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Nama Penghargaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" name="nama_penghargaan" placeholder="Masukkan Nama Penghargaan" required />
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Deskripsi Penghargaan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-solid" name="deskripsi_penghargaan" rows="3" placeholder="Masukkan Deskripsi Ringkas" required></textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kategori Penghargaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="kategori_penghargaan" placeholder="misal: Pemerintahan / Kesehatan" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="tahun" required>
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload Foto <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-solid" name="foto" id="tambah_foto" accept=".jpg,.jpeg,.png" required />
                            <div class="form-text fs-8 text-danger mt-1 fw-semibold">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File / Dokumen <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-solid" name="file" id="tambah_file" accept=".jpg,.jpeg,.png" required />
                            <div class="form-text fs-8 text-danger mt-1 fw-semibold">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white" style="background-color: #22c55e !important;">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Dummy (Sementara Sebelum Ada DB) -->
<div class="modal fade" id="modal_edit_dummy" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0 pt-6 px-7">
                <h3 class="modal-title fw-bolder text-gray-900 fs-3">Edit Data Penghargaan</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-7">
                <form onsubmit="return updatePenghargaan(event, 'dummy')">
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Nama Penghargaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" name="nama_penghargaan" value="Penghargaan SPBE Terbaik" required />
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Deskripsi Penghargaan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-solid" name="deskripsi_penghargaan" rows="3" required>Inovasi Digitalisasi Pelayanan Publik Terintegrasi</textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kategori Penghargaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid" name="kategori_penghargaan" value="Pemerintahan" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Tahun <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" name="tahun" required>
                                <option value="2026" selected>2026</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-6">
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload Foto (Opsional jika diubah)</label>
                            <input type="file" class="form-control form-control-solid" name="foto" id="edit_foto_dummy" accept=".jpg,.jpeg,.png" />
                            <div class="form-text fs-8 text-danger mt-1 fw-semibold">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Upload File / Dokumen (Opsional jika diubah)</label>
                            <input type="file" class="form-control form-control-solid" name="file" id="edit_file_dummy" accept=".jpg,.jpeg,.png" />
                            <div class="form-text fs-8 text-danger mt-1 fw-semibold">File harus di bawah 2MB dan berformat jpg, png atau jpeg.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light-danger fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success fw-bold px-6 text-white" style="background-color: #22c55e !important;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function validasiFile(inputElement, fieldLabel) {
    if (!inputElement || !inputElement.files[0]) return true;
    const file = inputElement.files[0];

    const maxSizeInBytes = 2 * 1024 * 1024; // 2MB
    const allowedExtensions = ['jpg', 'jpeg', 'png'];
    const fileName = file.name;
    const fileExtension = fileName.split('.').pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        Swal.fire({
            icon: 'error',
            title: 'Format File Ditolak!',
            text: `${fieldLabel} harus berformat jpg, png, atau jpeg.`,
            customClass: { popup: 'rounded-4' }
        });
        inputElement.value = '';
        return false;
    }

    if (file.size > maxSizeInBytes) {
        Swal.fire({
            icon: 'error',
            title: 'Ukuran File Terlalu Besar!',
            text: `${fieldLabel} tidak boleh lebih dari 2MB.`,
            customClass: { popup: 'rounded-4' }
        });
        inputElement.value = '';
        return false;
    }

    return true;
}

function simpanPenghargaan(e) {
    const inputFoto = document.getElementById('tambah_foto');
    const inputFile = document.getElementById('tambah_file');

    if (!validasiFile(inputFoto, 'Foto') || !validasiFile(inputFile, 'File Dokumen')) {
        e.preventDefault();
        return false;
    }

    return true;
}

function updatePenghargaan(e, id) {
    const inputFoto = document.getElementById(`edit_foto_${id}`);
    const inputFile = document.getElementById(`edit_file_${id}`);

    if (!validasiFile(inputFoto, 'Foto') || !validasiFile(inputFile, 'File Dokumen')) {
        e.preventDefault();
        return false;
    }

    // Jika mode dummy/statis
    if (id === 'dummy') {
        e.preventDefault();
        const modalEl = document.getElementById('modal_edit_dummy');
        if (modalEl) {
            bootstrap.Modal.getOrCreateInstance(modalEl).hide();
        }
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil diperbarui',
            showConfirmButton: false,
            timer: 2000,
            customClass: { popup: 'rounded-4' }
        });
        return false;
    }

    return true;
}

function hapusPenghargaan(id, nama) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah anda yakin untuk menghapus ${nama} ini?`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Yakin',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger fw-bold px-6 me-2',
            cancelButton: 'btn btn-light fw-bold px-6',
            popup: 'rounded-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            const formDelete = document.getElementById(`form-delete-${id}`);
            if (formDelete) {
                formDelete.submit();
            } else {
                // Mode Dummy/Statis
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil dihapus',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: { popup: 'rounded-4' }
                });
            }
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2000,
        customClass: { popup: 'rounded-4' }
    });
</script>
@endif
@endsection
