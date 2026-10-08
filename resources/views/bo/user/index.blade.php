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
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <div class="text-muted fs-7 mt-1">Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol (contoh: Pkk@2026!).</div>
                        </div>
                        <!-- Pilih Kecamatan -->
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Kecamatan</label>
                            <select name="id_kec" id="id_kec" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_add_users">
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->id_kec }}">{{ $kec->nama_kec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilih Kelurahan -->
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Kelurahan</label>
                            <select name="id_kel" id="id_kel" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_add_users">
                                <option value="">Pilih Kecamatan dulu</option>
                            </select>
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

    <div class="modal fade" id="kt_modal_reset_password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form_reset_password" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="modal-title">RESET PASSWORD</h2>
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="ki-outline ki-cross fs-1"></i>
                        </div>
                    </div>
                    <div class="modal-body py-10 px-lg-17">
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Password Baru</label>
                            <input type="password" name="password" id="reset_password_input" class="form-control form-control-solid" placeholder="Masukkan password baru" minlength="8">
                            <div class="text-muted fs-7 mt-1">Minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.</div>
                        </div>
                        <div class="mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-solid" placeholder="Ulangi password baru" minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kt_modal_view_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg text-gray-700">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">DETAIL USER</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">

                    <div class="row mb-7">
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Nama</label>
                            <div id="view_name" class="fs-6"></div>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Username</label>
                            <div id="view_username" class="fs-6"></div>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Email</label>
                            <div id="view_email" class="fs-6"></div>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Role</label>
                            <div id="view_role" class="fs-6"></div>
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Kecamatan</label>
                            <div id="view_kecamatan" class="fs-6"></div>
                        </div>
                        <div class="col-6">
                            <label class="fw-bold text-muted fs-7">Kelurahan</label>
                            <div id="view_kelurahan" class="fs-6"></div>
                        </div>
                    </div>

                    <div class="separator my-7"></div>

                    <div class="mb-7">
                        <label class="fw-bold text-muted fs-7 mb-3">Menu yang diakses (via Role)</label>
                        <div id="view_menus" class="d-flex flex-wrap gap-2"></div>
                    </div>

                    <div class="mb-7">
                        <label class="fw-bold text-muted fs-7 mb-3">Permission khusus (via Role)</label>
                        <div id="view_permissions" class="d-flex flex-wrap gap-2"></div>
                    </div>

                </div>
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
        
@endsection

@section('js')
    <script>

        function addForm(url, title) {
            $('#kt_modal_add_users .modal-title').text(title);
            $('#form_user')[0].reset();
            $('#form_user').attr('action', url);
            $('#form_user input[name=_method]').remove();
            $('#id_kec').val('').trigger('change');
            $('#id_kel').empty().append('<option value="">Pilih Kecamatan dulu</option>').trigger('change');
            $('#kt_modal_add_users').modal('show');
        }

        $(document).ready(function() {

            var cacheKel = {};   // daftar kelurahan per kecamatan, supaya pemanggilan kedua langsung muncul

            // Muat kelurahan sesuai kecamatan. Mengembalikan promise supaya bisa disambung (gantian).
            function muatKelurahan(idKec, idKelTerpilih) {
                var $kel = $('#id_kel');

                if (!idKec) {
                    $kel.empty().append('<option value="">Pilih Kecamatan dulu</option>').trigger('change.select2');
                    return $.Deferred().resolve().promise();
                }

                var isi = function (list) {
                    if ($('#id_kec').val() != idKec) { return; }   // kecamatan sudah diganti selagi menunggu
                    $kel.empty().append('<option value="">Pilih Kelurahan</option>');
                    $.each(list, function (i, kel) {
                        $kel.append($('<option>').val(kel.id_kel).text(kel.nama_kel));
                    });
                    $kel.val(idKelTerpilih || '').trigger('change.select2');
                };

                if (cacheKel[idKec]) {
                    isi(cacheKel[idKec]);
                    return $.Deferred().resolve().promise();
                }

                $kel.empty().append('<option value="">Memuat...</option>').trigger('change.select2');

                return $.get("{{ url('get-kelurahan') }}/" + idKec)
                    .done(function (list) { cacheKel[idKec] = list; isi(list); })
                    .fail(function () {
                        $kel.empty().append('<option value="">Gagal memuat kelurahan</option>').trigger('change.select2');
                    });
            }
            var table = $('#kt_table_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                    type: "GET"
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-start' },
                    { data: 'name', name: 'users.name' },
                    { data: 'username', name: 'users.username' },
                    { data: 'nama_kec', name: 'kec.nama_kec' },
                    { data: 'nama_kel', name: 'kel.nama_kel' },
                    { data: 'role', name: 'roles.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end' }
                ],
                drawCallback: function() {
                    KTMenu.createInstances();
                }
            });

            $('#searchUser').on('keyup', function () {
                table.search(this.value).draw();
            });

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
                            table.ajax.reload(null, false);
                            Swal.fire('Berhasil!', res.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var msg = Object.values(errors).map(e => e[0]).join('<br>');
                            Swal.fire({ title: 'Gagal', html: msg, icon: 'error' });
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    }
                });
            });

            // === kecamatan berubah -> load kelurahan ===
            // === kecamatan berubah -> load kelurahan ===
            $('#id_kec').on('change', function() {
                muatKelurahan($(this).val());
            });

            // === edit modal ===
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');

                var url = "{{ route('user.show', ':id') }}".replace(':id', id);
                var updateUrl = "{{ route('user.update', ':id') }}".replace(':id', id);

                $('#kt_modal_add_users .modal-title').text('EDIT USER');
                $('#form_user')[0].reset();

                $('#form_user').attr('action', updateUrl);

                if ($('#form_user input[name=_method]').length === 0) {
                    $('#form_user').prepend('<input type="hidden" name="_method" value="PUT">');
                }

                $.get(url)
                    .done(function(response) {
                        $('#form_user input[name=name]').val(response.name);
                        $('#form_user input[name=username]').val(response.username);
                        $('#form_user input[name=email]').val(response.email);
                        $('#form_user select[name=role_id]').val(response.role_id).trigger('change');
                        $('#form_user input[name=password]').val('');

                        $('#id_kec').val(response.id_kec).trigger('change.select2');

                        muatKelurahan(response.id_kec, response.id_kel).always(function () {
                            $('#kt_modal_add_users').modal('show');
                        });

                    })
                    .fail(function() {
                        Swal.fire('Gagal', 'Gagal mengambil data user.', 'error');
                    });
            });

            // === tombol Delete diklik ===
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

            // === tombol Reset Password diklik -> buka modal ===
            $(document).on('click', '.btn-reset', function() {
                var id = $(this).data('id');
                var url = "{{ url('master/user') }}/" + id + "/reset-password";

                $('#form_reset_password')[0].reset();
                $('#form_reset_password').attr('action', url);
                $('#kt_modal_reset_password').modal('show');
            });

            // === submit form reset password ===
            $('#form_reset_password').on('submit', function(e) {
                e.preventDefault();

                var newPassword = $('#reset_password_input').val();
                var confirmPassword = $('input[name=password_confirmation]').val();

                if (newPassword !== confirmPassword) {
                    Swal.fire('Gagal', 'Password dan konfirmasi tidak sama.', 'error');
                    return;
                }

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.status) {
                            $('#kt_modal_reset_password').modal('hide');
                            Swal.fire('Berhasil!', res.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var msg = Object.values(errors).map(e => e[0]).join('<br>');
                            Swal.fire({ title: 'Gagal', html: msg, icon: 'error' });
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    }
                });
            });

            // === tombol View diklik ===
            $(document).on('click', '.btn-view', function() {
                var id = $(this).data('id');
                var url = "{{ url('master/user') }}/" + id + "/detail";

                $('#view_name, #view_username, #view_email, #view_role, #view_kecamatan, #view_kelurahan').text('Memuat...');
                $('#view_menus, #view_permissions').html('');

                $('#kt_modal_view_user').modal('show');

                $.get(url)
                    .done(function(response) {
                        $('#view_name').text(response.name);
                        $('#view_username').text(response.username);
                        $('#view_email').text(response.email);
                        $('#view_role').text(response.role_name);
                        $('#view_kecamatan').text(response.kecamatan);
                        $('#view_kelurahan').text(response.kelurahan);

                        var $menus = $('#view_menus');
                        $menus.empty();
                        if (response.menus.length === 0) {
                            $menus.append('<span class="text-muted">Tidak ada menu</span>');
                        } else {
                            $.each(response.menus, function(i, menu) {
                                $('<span class="badge badge-light-primary fs-7"></span>')
                                    .text(menu.nama_menu) // pakai .text() biar aman dari XSS
                                    .appendTo($menus);
                            });
                        }

                        var $perms = $('#view_permissions');
                        $perms.empty();
                        if (response.permissions.length === 0) {
                            $perms.append('<span class="text-muted">Tidak ada permission khusus</span>');
                        } else {
                            $.each(response.permissions, function(i, permName) {
                                $('<span class="badge badge-light-warning fs-7"></span>')
                                    .text(permName) // pakai .text() biar aman dari XSS
                                    .appendTo($perms);
                            });
                        }
                    })
                    .fail(function() {
                        $('#kt_modal_view_user').modal('hide');
                        Swal.fire('Gagal', 'Gagal mengambil detail user.', 'error');
                    });
            });

        }); // <-- SATU-SATUNYA penutup document.ready, di paling akhir
    </script>
@endsection