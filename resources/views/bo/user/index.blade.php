@extends('bo.layout.app')
@section('content')
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch mb-10">
        <!--begin::Toolbar wrapper-->
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">User</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Master</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">User</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                {{-- <a href="#"
                    class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold"
                    data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Add User</a> --}}
                <button class="btn btn-flex btn-primary h-40px fs-7 fw-bold" d
                    onclick="addForm(`{{ route('user.store') }}`, 'TAMBAH USER' )"><i
                        class="ki-outline ki-plus fs-2"></i>Tambah User</button>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar wrapper-->
    </div>

    <div id="kt_app_content_container" class="app-container container-fluid"
        data-select2-id="select2-data-kt_app_content_container">
        <!--begin::Products-->
        <div class="card card-flush" data-select2-id="select2-data-134-0nq7">
            <!--begin::Card header-->
            <div class="card-header align-items-center py-5 gap-2 gap-md-5" data-select2-id="select2-data-133-kdmc">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                        <input type="text" id="searchUser" class="form-control form-control-solid w-250px ps-12" placeholder="Cari User...">
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div id="kt_ecommerce_sales_table_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable" id="kt_table_user">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="text-start w-10px pe-2">No</th>
                                    <th class="min-w-150px">Nama</th>
                                    <th class="min-w-125px">Username</th>
                                    <th class="min-w-150px">Kecamatan</th>
                                    <th class="min-w-150px">Kelurahan</th>
                                    <th class="min-w-100px">Role</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                {{-- Diisi otomatis oleh DataTables via AJAX server-side --}}
                            </tbody>
                        </table>
                    </div>

                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>

    <div class="modal fade" id="kt_modal_add_users" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form_user" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title">TAMBAH USER</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Nama</label>
                            <input type="text" name="name" class="form-control form-control-solid" placeholder="Masukkan nama">
                        </div>
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Username</label>
                            <input type="text" name="username" class="form-control form-control-solid" placeholder="Masukkan username">
                        </div>
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid" placeholder="Masukkan email">
                        </div>
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Password</label>
                            <input type="password" name="password" class="form-control form-control-solid" placeholder="Masukkan password">
                        </div>
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Role</label>
                            <select name="role_id" class="form-select form-select-solid">
                                <option value="">Pilih Role</option>
                                @foreach($role as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
@endsection

@section('js')
    <script src="{{ asset('assets/js/custom/pages/master/users.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#kt_table_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-start'
                    },
                    {
                        data: 'name',
                        name: 'users.name'
                    },
                    {
                        data: 'username',
                        name: 'users.username'
                    },
                    {
                        data: 'nama_kec',
                        name: 'kec.nama_kec'
                    },
                    {
                        data: 'nama_kel',
                        name: 'kel.nama_kel'
                    },
                    {
                        data: 'role',
                        name: 'roles.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                drawCallback: function() {
                    KTMenu.createInstances();
                }
            });

            $('#searchUser').on('keyup', function () {
                table.search(this.value).draw();
            });

            // === handle submit form modal ===
            // === handle submit form modal ===
$('#form_user').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(res) {
            if (res.status) {
                $('#kt_modal_add_users').modal('hide');
                table.draw();
                Swal.fire('Berhasil!', res.message, 'success');
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var msg = Object.values(errors).map(e => e[0]).join('<br>');
                Swal.fire({
                    title: 'Gagal',
                    html: msg,
                    icon: 'error'
                });
            } else {
                Swal.fire('Error', 'Terjadi kesalahan server', 'error');
            }
        }
    });
});
        });

        $(document).on('click', '.btn-edit', function() {
    var id = $(this).data('id');
    
    var url = "{{ route('user.show', ':id') }}".replace(':id', id);
    var updateUrl = "{{ route('user.update', ':id') }}".replace(':id', id);

    $('#kt_modal_add_users').modal('show');
    $('#kt_modal_add_users .modal-title').text('EDIT USER');
    $('#form_user')[0].reset();
    
    $('#form_user').attr('action', updateUrl); 
    
    if($('#form_user input[name=_method]').length === 0) {
        $('#form_user').prepend('<input type="hidden" name="_method" value="PUT">');
    }

    $.get(url)
        .done(function(response) {
            $('#form_user input[name=name]').val(response.name);
            $('#form_user input[name=username]').val(response.username);
            $('#form_user input[name=email]').val(response.email);
            $('#form_user select[name=role_id]').val(response.role_id).trigger('change');
            $('#form_user select[name=id_kec]').val(response.id_kec).trigger('change');
            $('#form_user select[name=id_kel]').val(response.id_kel).trigger('change');
            $('#form_user input[name=password]').val('');
        })
        .fail(function() {
            alert('Gagal mengambil data user.');
        });
});

        // Ketika tombol Delete diklik
        $(document).on('click', '.btn-delete', function() {
    var id = $(this).data('id');
    var url = "{{ url('master/user') }}/" + id;

    Swal.fire({
        title: 'Yakin mau hapus?',
        text: "User ini akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'DELETE'
                },
                success: function(res) {
                    $('#kt_table_user').DataTable().ajax.reload(null, false);
                    Swal.fire('Berhasil!', res.message, 'success');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire('Gagal', 'Gagal menghapus data user.', 'error');
                }
            });
        }
    });
});
    </script>
   
@endsection