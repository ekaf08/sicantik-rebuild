@extends('bo.layout.app')

@section('content')
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch mb-10">
        <!--begin::Toolbar wrapper-->
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Permission</h1>
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
                    <li class="breadcrumb-item text-muted">Permission</li>
                </ul>
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button class="btn btn-flex btn-primary h-40px fs-7 fw-bold"
                    onclick="addForm(`{{ route('permission.store') }}`, 'TAMBAH PERMISSION')">
                    <i class="ki-outline ki-plus fs-2"></i>Tambah Permission
                </button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>

    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                        <input type="text" id="search_permission"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Permission...">
                    </div>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    {{-- ID Tabel disamakan dengan JavaScript (kt_table_permission) --}}
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable" id="kt_table_permission">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="text-start w-10px pe-2">No</th>
                                <th class="min-w-150px">Nama Permission</th>
                                <th class="min-w-125px">Guard Name</th> {{-- Kolom disamakan dengan JS --}}
                                <th class="text-end min-w-100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            {{-- Diisi otomatis via DataTables AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Card body-->
        </div>
    </div>

    <!--begin::Modal - Add/Edit Permission-->
    <div class="modal fade" id="modal-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold modal-title">Modal Title</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                
                <form id="form-permission" class="form" action="#" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">

                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <div class="d-flex flex-column scroll-y me-n7 pe-7">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Nama Permission</label>
                                <input type="text" name="name" id="permission_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Contoh: user.index, post.create" />
                                <div class="invalid-feedback" id="error-name"></div>
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
    <!--end::Modal-->
@endsection

@section('js')
    <script>
        var table;

        $(document).ready(function() {
            // Inisialisasi DataTables
            table = $('#kt_table_permission').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('permission.data') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-start' },
                    { data: 'name', name: 'name' },
                    { data: 'guard_name', name: 'guard_name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end' }
                ],
                drawCallback: function() {
                    if (typeof KTMenu !== 'undefined') {
                        KTMenu.createInstances();
                    }
                }
            });

            // Live Search Input
            $('#search_permission').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Submit Form (Tambah & Edit via AJAX)
            $('#form-permission').on('submit', function(e) {
                e.preventDefault();
                
                $('#permission_name').removeClass('is-invalid');
                $('#error-name').text('');

                var url = $(this).attr('action');
                var formData = $(this).serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
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
                            if (errors.name) {
                                $('#permission_name').addClass('is-invalid');
                                $('#error-name').text(errors.name[0]);
                            }
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
            $('.modal-title').text(title);$('#form-permission')[0].reset();
            $('#form-permission').attr('action', url);
            $('#form-method').val('POST');

            $('#permission_name').removeClass('is-invalid');
            $('#error-name').text('');
        }

        function editForm(showUrl, updateUrl, title) {
            $('#form-permission')[0].reset();
            $('#permission_name').removeClass('is-invalid');
            $('#error-name').text('');

            $.get(showUrl, function(response) {
                if (response.status === 'success') {
                    $('#modal-form').modal('show');
                    $('.modal-title').text(title);$('#form-permission').attr('action', updateUrl);
                    $('#form-method').val('PUT');

                    $('#permission_name').val(response.data.name);
                }
            }).fail(function() {
                Swal.fire({ text: "Gagal mengambil data!", icon: "error" });
            });
        }

        function deleteData(url) {
            Swal.fire({
                text: "Apakah kamu yakin ingin menghapus permission ini?",
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
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: { confirmButton: "btn btn-primary" }
                            });
                        },
                        error: function() {
                            Swal.fire({ text: "Gagal menghapus data!", icon: "error" });
                        }
                    });
                }
            });
        }
    </script>
@endsection