@extends('bo.layout.app')

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">

        <!-- Header Halaman -->
        <div class="d-flex flex-stack mb-5">
            <div>
                <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Master Role</h2>
                <span class="text-gray-500 fw-semibold fs-6">Daftar hak akses/role dari database</span>
            </div>
            <!-- Tombol Pemicu Pop-up Modal -->
            <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_add_role">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah
            </button>
        </div>

        <!-- Card Tabel Data Roles -->
        <div class="card card-flush shadow-sm">
            <div class="card-body pt-6">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-50px">NO</th>
                                <th>NAME</th>
                                <th>GUARD NAME</th>
                                <th>CREATED AT</th>
                                <th>UPDATED AT</th>
                                <th class="text-end">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse ($roles as $key => $item)
                                <tr>
                                    <!-- Menyesuaikan nomor urut halaman pagination -->
                                    <td>{{ $roles->firstItem() + $key }}</td>
                                    <td><span class="badge badge-light-primary fw-bold fs-7">{{ $item->name }}</span></td>
                                    <td><span class="badge badge-light-info fw-bold fs-7">{{ $item->guard_name }}</span></td>
                                    <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-light-primary btn-edit-role me-2"
                                            data-id="{{ $item->id }}">
                                            <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                                            Edit
                                        </button>

                                        <form action="{{ route('role.destroy', $item->id) }}" method="POST" class="d-inline form-delete-role"
                                            data-name="{{ $item->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger">
                                                <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-5">
                                        Belum ada data di tabel roles Navicat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- ================= PAGINATION ================= -->
                <div class="d-flex flex-stack flex-wrap pt-6">
                    <div class="fs-6 fw-semibold text-gray-700">
                        Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} records
                    </div>

                    <div>
                        {{ $roles->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                <!-- ============================================================== -->

            </div>
        </div>

    </div>
</div>

<!-- POP-UP MODAL TAMBAH ROLE -->
<div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Role</h2>
                <div class="btn btn-icon btn-sm btn-active-color-danger" data-bs-dismiss="modal">
                    <span class="fs-1 text-danger fw-bold lh-1">&times;</span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form action="{{ route('role.store') }}" method="POST">
                    @csrf

                    <!-- Nama Role -->
                    <div class="mb-8">
                        <label class="form-label fw-bold required">Nama Role</label>
                        <input type="text" name="name" class="form-control form-control-solid" placeholder="Masukkan nama role..." required />
                    </div>

                    <!-- Permission -->
                    <div class="mb-8">
                        <label class="form-label fw-bold required">Permission</label>
                        <input type="text" class="form-control mb-4" placeholder="Cari ..." />
                        <div class="row g-3">
                            @forelse($permissions as $perm)
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" />
                                        <label class="form-check-label text-gray-700 fw-semibold" for="perm_{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-gray-500 fs-7">Belum ada data permission.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Menu By Role (Dynamic dari Database Navicat m_menu) -->
                    <div class="mb-10">
                        <label class="form-label fw-bold required">Menu By Role</label>
                        <input type="text" class="form-control mb-4" placeholder="Cari ..." />
                        <div class="row g-3" style="max-height: 250px; overflow-y: auto;">
                            @forelse($menus as $menu)
                                @php
                                    // Mengakomodasi kolom ID dan Nama Menu di Navicat
                                    $menuId = $menu->id_menu ?? $menu->id;
                                    $menuName = $menu->nama_menu ?? $menu->name ?? $menu->title;
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="menus[]" value="{{ $menuId }}" id="menu_{{ $menuId }}" />
                                        <label class="form-check-label text-gray-700 fw-semibold" for="menu_{{ $menuId }}">
                                            {{ $menuName }}
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-gray-500 fs-7">Data menu tidak ditemukan di database.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-warning text-white me-3" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success fw-bold">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- POP-UP MODAL EDIT ROLE -->
<div class="modal fade" id="kt_modal_edit_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Edit Role</h2>
                <div class="btn btn-icon btn-sm btn-active-color-danger" data-bs-dismiss="modal">
                    <span class="fs-1 text-danger fw-bold lh-1">&times;</span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="form-edit-role" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Role -->
                    <div class="mb-8">
                        <label class="form-label fw-bold required">Nama Role</label>
                        <input type="text" name="name" id="edit_name" class="form-control form-control-solid" placeholder="Masukkan nama role..." required />
                    </div>

                    <!-- Permission -->
                    <div class="mb-8">
                        <label class="form-label fw-bold required">Permission</label>
                        <input type="text" class="form-control mb-4" placeholder="Cari ..." />
                        <div class="row g-3">
                            @forelse($permissions as $perm)
                                <div class="col-md-6">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input edit-permission-checkbox" type="checkbox"
                                            name="permissions[]" value="{{ $perm->id }}" id="edit_perm_{{ $perm->id }}" />
                                        <label class="form-check-label text-gray-700 fw-semibold" for="edit_perm_{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-gray-500 fs-7">Belum ada data permission.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Menu By Role -->
                    <div class="mb-10">
                        <label class="form-label fw-bold required">Menu By Role</label>
                        <input type="text" class="form-control mb-4" placeholder="Cari ..." />
                        <div class="row g-3" style="max-height: 250px; overflow-y: auto;">
                            @forelse($menus as $menu)
                                @php
                                    $menuId = $menu->id_menu ?? $menu->id;
                                    $menuName = $menu->nama_menu ?? $menu->name ?? $menu->title;
                                @endphp
                                <div class="col-md-4">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input edit-menu-checkbox" type="checkbox"
                                            name="menus[]" value="{{ $menuId }}" id="edit_menu_{{ $menuId }}" />
                                        <label class="form-check-label text-gray-700 fw-semibold" for="edit_menu_{{ $menuId }}">
                                            {{ $menuName }}
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-gray-500 fs-7">Data menu tidak ditemukan di database.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-warning text-white me-3" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-success fw-bold">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editUrlTemplate = "{{ route('role.edit', ':id') }}";
    const updateUrlTemplate = "{{ route('role.update', ':id') }}";

    document.querySelectorAll('.btn-edit-role').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            // Reset dulu semua checkbox sebelum diisi ulang
            document.querySelectorAll('.edit-menu-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.edit-permission-checkbox').forEach(cb => cb.checked = false);

            fetch(editUrlTemplate.replace(':id', id))
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data');
                    return res.json();
                })
                .then(data => {
                    document.getElementById('edit_name').value = data.name;

                    document.querySelectorAll('.edit-menu-checkbox').forEach(cb => {
                        cb.checked = data.selected_menus.includes(parseInt(cb.value));
                    });

                    document.querySelectorAll('.edit-permission-checkbox').forEach(cb => {
                        cb.checked = data.selected_permissions.includes(parseInt(cb.value));
                    });

                    document.getElementById('form-edit-role').action = updateUrlTemplate.replace(':id', id);

                    new bootstrap.Modal(document.getElementById('kt_modal_edit_role')).show();
                })
                .catch(() => {
                    alert('Gagal mengambil data role.');
                });
        });
    });

    document.querySelectorAll('.form-delete-role').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const name = this.dataset.name;

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hapus role ini?',
                    text: `Role "${name}" akan dihapus dan tidak bisa dikembalikan.`,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#7e8299',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                if (confirm(`Yakin ingin menghapus role "${name}"?`)) {
                    form.submit();
                }
            }
        });
    });

    // Notifikasi sukses (centang hijau) setelah Tambah / Edit / Hapus berhasil
    @if(session('success'))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Perubahan berhasil disimpan',
                confirmButtonText: 'OK',
                confirmButtonColor: '#009ef7',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn btn-primary' }
            });
        } else {
            alert('Perubahan berhasil disimpan');
        }
    @endif

    @if(session('error'))
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error')),
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33',
                buttonsStyling: false,
                customClass: { confirmButton: 'btn btn-danger' }
            });
        } else {
            alert(@json(session('error')));
        }
    @endif
});
</script>
@endsection
