@extends('bo.layout.app')

@section('content')
<style>
    .pagination {
        margin-bottom: 0;
    }
    .pagination .page-item .page-link {
        border-radius: 6px;
        margin: 0 2px;
        color: #6c757d;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
        font-weight: bold;
    }
    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        color: #212529;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Master Menu</h2>
        <button type="button" class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
            <i class="fas fa-plus me-2"></i> Menu Baru
        </button>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Tabel Utama -->
    <div class="card shadow-sm border-0 p-4 rounded-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-3">
            <div class="fs-6 text-secondary">
                Show 
                <select class="form-select form-select-sm d-inline-block w-auto">
                    <option>10</option>
                </select> entries
            </div>
            <form action="{{ route('menu.index') }}" method="GET" class="w-100 w-md-auto">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" placeholder="Cari menu..." onchange="this.form.submit()">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle fs-6">
                <thead class="table-light text-uppercase fs-7">
                    <tr>
                        <th class="py-3">No.</th>
                        <th class="py-3">Nama Menu</th>
                        <th class="py-3">Parent</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Icon</th>
                        <th class="py-3 text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $index => $item)
                    <tr>
                        <td class="fw-semibold">{{ $menus->firstItem() + $index }}</td>
                        <td>{{ $item->nama_menu }}</td>
                        <td>{{ $item->parent ? $item->parent->nama_menu : '-' }}</td>
                        <td>
                            <span class="badge {{ $item->status_menu == 'Aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                {{ $item->status_menu }}
                            </span>
                        </td>
                        <td><i class="{{ $item->icon }} fs-5"></i> <span class="ms-1 text-muted">{{ $item->icon }}</span></td>
                        <td class="text-end pe-3">
                            <div class="d-flex justify-content-end align-items-center gap-3">
                                <button type="button" class="btn btn-link text-primary p-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="#menuModal"
                                    onclick="setupEditModal(this)"
                                    data-id="{{ $item->id_menu }}"
                                    data-nama="{{ $item->nama_menu }}"
                                    data-parent="{{ $item->parent_id }}"
                                    data-icon="{{ $item->icon }}"
                                    data-url="{{ $item->url_menu }}"
                                    data-status_menu="{{ $item->status_menu }}"
                                    data-urutan="{{ $item->urutan }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-link text-danger p-0 text-decoration-none fs-6 fw-bold" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    onclick="document.getElementById('deleteForm').action = '{{ route('menu.destroy', $item->id_menu) }}'">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-5 fs-5">Belum ada data menu.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

        <!-- Bagian Bawah Footer (Pagination & Info) Sejajar Sesuai Referensi -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
            <div class="text-muted fs-6">
                Showing <span class="fw-bold text-dark">{{ $menus->firstItem() ?? 0 }}</span> to <span class="fw-bold text-dark">{{ $menus->lastItem() ?? 0 }}</span> of <span class="fw-bold text-dark">{{ $menus->total() }}</span> records
            </div>
            <div class="pagination-container fs-6">
                {{ $menus->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL FORM (TAMBAH & EDIT) ================= -->
<div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h3 class="fw-bold text-dark" id="modalTitle">Form Menu</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <form id="menuForm" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 fw-bold fs-6">Pilih Parent Menu :</label>
                        <div class="col-sm-9">
                            <select name="parent_id" id="parent_id" class="form-select form-select-lg fs-6">
                                <option value="">Pilih Menu Parent (Opsional)</option>
                                @foreach($parentMenus as $parent)
                                    <option value="{{ $parent->id_menu }}">{{ $parent->nama_menu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 fw-bold fs-6">Nama Menu : <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" id="nama_menu" name="nama_menu" class="form-control form-select-lg fs-6" placeholder="Contoh: Laporan Keuangan" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 fw-bold fs-6">Icon : <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" id="icon" name="icon" class="form-control form-select-lg fs-6" placeholder="contoh: fas fa-users" required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <label class="col-sm-3 fw-bold fs-6">Url Menu : <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" id="url_menu" name="url_menu" class="form-control form-select-lg fs-6" placeholder="Otomatis terisi..." required>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                    <label class="col-sm-3 fw-bold fs-6">Status Menu : <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="status_menu" id="status_menu" class="form-select form-select-lg fs-6" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Non Aktif">Non Aktif</option>
                        </select>
                    </div>
                </div>

                    <div class="row mb-4 align-items-center">
                        <label class="col-sm-3 fw-bold fs-6">Urutan Menu :</label>
                        <div class="col-sm-4">
                            <input type="number" id="urutan" name="urutan" class="form-control form-select-lg fs-6" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-5 py-2 fw-bold">
                            <i class="fas fa-save me-2"></i> SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 rounded-4 shadow">
            <h4 class="fw-bold mb-2 text-danger"><i class="fas fa-exclamation-triangle"></i> Apa Anda Yakin?</h4>
            <p class="text-muted mb-4 fs-6">Data menu ini akan dihapus dari sistem.</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 py-2 fw-bold">Ya, Hapus!</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pages/general/menu/menu.js') }}"></script>
@endpush