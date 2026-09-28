@extends('bo.layout.app')

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">

        <!-- Header & Tombol Tambah -->
        <div class="d-flex flex-stack mb-5">
            <div>
                <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Manajemen Role</h2>
                <span class="text-gray-500 fw-semibold fs-6">Kelola daftar tingkatan dan hak akses pengguna aplikasi</span>
            </div>
            <div>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modal_tambah_role">
                    <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Role
                </button>
            </div>
        </div>

        <!-- Alert Notifikasi Sukses -->
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center p-4 mb-5">
                <i class="ki-outline ki-check-circle fs-2x text-success me-3"></i>
                <div class="d-flex flex-column">
                    <span class="fw-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Card Tabel Data Role -->
        <div class="card card-flush shadow-sm">
            <div class="card-body pt-6">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-50px">NO</th>
                                <th>KODE ROLE</th>
                                <th>NAMA ROLE</th>
                                <th>DESKRIPSI HAK AKSES</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse ($roles as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><code class="text-dark fw-bold bg-light px-2 py-1 rounded">{{ $item->kode_role }}</code></td>
                                    <td><span class="text-gray-800 fw-bold">{{ $item->nama_role }}</span></td>
                                    <td>{{ $item->deskripsi ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-light-{{ $item->status == 'aktif' ? 'success' : 'danger' }} fw-bold">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-icon btn-light-warning me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_edit_role_{{ $item->id }}"
                                                title="Edit Role">
                                            <i class="ki-outline ki-pencil fs-5"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-sm btn-icon btn-light-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_hapus_role_{{ $item->id }}"
                                                title="Hapus Role">
                                            <i class="ki-outline ki-trash fs-5"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Edit Role -->
                                <div class="modal fade" id="modal_edit_role_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content rounded-4">
                                            <div class="modal-header border-0 pb-0">
                                                <h3 class="modal-title fw-bold text-gray-900 fs-4">Edit Data Role</h3>
                                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body py-6 px-8">
                                                <form action="{{ route('role.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-4">
                                                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kode Role <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid" name="kode_role" value="{{ $item->kode_role }}" required />
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Nama Role <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-solid" name="nama_role" value="{{ $item->nama_role }}" required />
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Deskripsi</label>
                                                        <textarea class="form-control form-control-solid" name="deskripsi" rows="3">{{ $item->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Status <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-solid" name="status">
                                                            <option value="aktif" {{ $item->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="nonaktif" {{ $item->status == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                                                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning fw-bold text-white">Update Role</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="modal_hapus_role_{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content rounded-4 text-center p-6">
                                            <div class="modal-body">
                                                <i class="ki-outline ki-information-2 fs-5x text-danger mb-4"></i>
                                                <h4 class="fw-bold text-gray-900 mb-2">Hapus Role?</h4>
                                                <p class="text-gray-600 fs-7 mb-6">Apakah kamu yakin ingin menghapus role <strong>{{ $item->nama_role }}</strong>?</p>
                                                <form action="{{ route('role.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <button type="button" class="btn btn-light fw-bold btn-sm" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger fw-bold btn-sm">Ya, Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-5">
                                        Belum ada data role. Klik tombol <strong>Tambah Role</strong> untuk membuat data baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah Role -->
<div class="modal fade" id="modal_tambah_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Tambah Role Baru</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body py-6 px-8">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Kode Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" name="kode_role" placeholder="Contoh: ADM-KOTA" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" name="nama_role" placeholder="Contoh: Admin Kota" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Deskripsi</label>
                        <textarea class="form-control form-control-solid" name="deskripsi" rows="3" placeholder="Deskripsi hak akses..."></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="form-label fs-8 fw-bold text-uppercase text-gray-700">Status <span class="text-danger">*</span></label>
                        <select class="form-select form-select-solid" name="status">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
