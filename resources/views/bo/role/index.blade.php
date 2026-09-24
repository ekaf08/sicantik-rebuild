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
                                <th>ID</th>
                                <th>NAME</th>
                                <th>GUARD NAME</th>
                                <th>CREATED AT</th>
                                <th>UPDATED AT</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse ($roles as $key => $item)
                                <tr>
                                    <!-- Menyesuaikan nomor urut halaman pagination -->
                                    <td>{{ $roles->firstItem() + $key }}</td>
                                    <td><code class="text-dark fw-bold bg-light px-2 py-1 rounded">{{ $item->id }}</code></td>
                                    <td><span class="badge badge-light-primary fw-bold fs-7">{{ $item->name }}</span></td>
                                    <td><span class="badge badge-light-info fw-bold fs-7">{{ $item->guard_name }}</span></td>
                                    <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d H:i') : '-' }}</td>
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
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"></i>
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
@endsectionlalu
