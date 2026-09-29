@extends('bo.layout.app')

@section('content')
<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch mb-10">
    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
        <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
            <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Master Menu</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Master</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Menu</li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <button class="btn btn-flex btn-primary h-40px fs-7 fw-bold"
                onclick="addForm(`{{ route('menu.store') }}`, 'TAMBAH MENU BARU')">
                <i class="ki-outline ki-plus fs-2"></i>Menu Baru
            </button>
        </div>
    </div>
</div>

<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                    <input type="text" id="search_menu"
                        class="form-control form-control-solid w-250px ps-12" placeholder="Cari Menu...">
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable" id="kt_table_menu">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-start w-10px pe-2">No</th>
                            <th class="min-w-125px">Nama Menu</th>
                            <th class="min-w-125px">Parent</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-100px">Icon</th>
                            <th class="text-end min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold modal-title">Modal Title</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>

            <form id="form-menu" class="form" action="#" method="POST">
                @csrf
                <input type="hidden" id="form-method" value="POST">

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7 gap-4">
                        <div class="fv-row">
                            <label class="fw-semibold fs-6 mb-2">Pilih Parent Menu</label>
                            <select name="parent_id" id="parent_id" class="form-select form-select-solid">
                                <option value="">Pilih Menu Parent (Opsional)</option>
                            @foreach($parentMenus as $parent)
                                <option value="{{ $parent->id_menu }}">{{ $parent->nama_menu }}</option>
                            @endforeach
                                    
                            </select>
                        </div>

                        <div class="fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Nama Menu</label>
                            <input type="text" name="nama_menu" id="nama_menu" class="form-control form-control-solid" placeholder="Contoh: Laporan Keuangan" required />
                            <div class="invalid-feedback" id="error-nama_menu"></div>
                        </div>

                        <div class="fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Icon</label>
                            <input type="text" name="icon" id="icon" class="form-control form-control-solid" placeholder="Contoh: fas fa-users" required />
                            <div class="invalid-feedback" id="error-icon"></div>
                        </div>

                        <div class="fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Url Menu</label>
                            <input type="text" name="url_menu" id="url_menu" class="form-control form-control-solid" placeholder="Contoh: master/menu" required />
                            <div class="invalid-feedback" id="error-url_menu"></div>
                        </div>

                        <div class="fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Status Menu</label>
                            <select name="status_menu" id="status_menu" class="form-select form-select-solid" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                            </select>
                        </div>

                        <div class="fv-row">
                            <label class="fw-semibold fs-6 mb-2">Urutan Menu</label>
                            <input type="number" name="urutan" id="urutan" class="form-control form-control-solid" value="0" />
                        </div>
                    </div> 
                </div> 

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">
                        <span class="indicator-label">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var table;
    $(document).ready(function() {
        table = $('#kt_table_menu').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('menu.data') }}",
                type: "GET",
                error: function(xhr, error, code) {
                    console.log("DataTables Ajax Error: " + error);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-start' },
                { data: 'nama_menu', name: 'nama_menu' },
                { data: 'parent_name', name: 'parent_name' },
                { data: 'status_badge', name: 'status_menu' },
                { data: 'icon_display', name: 'icon', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end' }
            ],
            drawCallback: function() {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
            }
        });

        $('#search_menu').on('keyup', function() {
            table.search(this.value).draw();
        });

        $('#form-menu').on('submit', function(e) {
            e.preventDefault();
            
            $('.form-control, .form-select').removeClass('is-invalid');$('.invalid-feedback').text('');

            var url = $(this).attr('action');
            var formMethod = $('#form-method').val();
            var formData = new FormData(this);

            if (formMethod === 'PUT') {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#modal-form').modal('hide');
                    table.ajax.reload();

                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#error-' + key).text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            text: "Terjadi kesalahan pada sistem.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }
                }
            });
        });
    });

    function addForm(url, title) {
        $('#modal-form').modal('show');
        $('.modal-title').text(title);$('#form-menu')[0].reset();
        $('#form-menu').attr('action', url);
        $('#form-method').val('POST');

        $('.form-control, .form-select').removeClass('is-invalid');$('.invalid-feedback').text('');
    }

    function editForm(showUrl, updateUrl, title) {
        $('#form-menu')[0].reset();
        $('.form-control, .form-select').removeClass('is-invalid');$('.invalid-feedback').text('');

        $.get(showUrl, function(response) {
            if (response.status === 'success') {
                $('#modal-form').modal('show');
                $('.modal-title').text(title);$('#form-menu').attr('action', updateUrl);
                $('#form-method').val('PUT');

                $('#parent_id').val(response.data.parent_id);
                $('#nama_menu').val(response.data.nama_menu);
                $('#icon').val(response.data.icon);
                $('#url_menu').val(response.data.url_menu);
                $('#status_menu').val(response.data.status_menu);
                $('#urutan').val(response.data.urutan);
            }
        }).fail(function() {
            Swal.fire({ text: "Gagal mengambil data!", icon: "error" });
        });
    }

    function deleteData(url, encryptedId) {
        Swal.fire({
            text: "Apakah kamu yakin ingin menghapus menu ini?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.isConfirmed || result.value) { 
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': encryptedId // ID terenkripsi dikirim aman lewat body data
                    },
                    success: function(response) {
                        if (typeof table !== 'undefined') {
                            table.ajax.reload(null, false); 
                        }
                        Swal.fire({
                            text: response.message || "Menu berhasil dihapus!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({ 
                            text: "Gagal menghapus data!", 
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: { confirmButton: "btn-primary" }
                        });
                    }
                });
            }
        });
    }

</script>
@endsection 