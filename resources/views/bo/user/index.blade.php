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
                        <input type="text" data-kt-ecommerce-order-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Search Order">
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5" data-select2-id="select2-data-132-zee9">
                    <!--begin::Flatpickr-->
                    <div class="input-group w-250px">
                        <input class="form-control form-control-solid rounded rounded-end-0 flatpickr-input"
                            placeholder="Pick date range" id="kt_ecommerce_sales_flatpickr" type="hidden"><input
                            class="form-control form-control-solid rounded rounded-end-0 input"
                            placeholder="Pick date range" tabindex="0" type="text" readonly="readonly">
                        <button class="btn btn-icon btn-light" id="kt_ecommerce_sales_flatpickr_clear">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </button>
                    </div>
                    <!--end::Flatpickr-->
                    <div class="w-100 mw-150px" data-select2-id="select2-data-131-qy7q">
                        <!--begin::Select2-->
                        <select class="form-select form-select-solid select2-hidden-accessible" data-control="select2"
                            data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-order-filter="status"
                            data-select2-id="select2-data-7-2xku" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                            <option data-select2-id="select2-data-9-pn3y"></option>
                            <option value="all" data-select2-id="select2-data-136-b6wt">All</option>
                            <option value="Cancelled" data-select2-id="select2-data-137-3m7n">Cancelled</option>
                            <option value="Completed" data-select2-id="select2-data-138-7q1x">Completed</option>
                            <option value="Denied" data-select2-id="select2-data-139-y31l">Denied</option>
                            <option value="Expired" data-select2-id="select2-data-140-qb1a">Expired</option>
                            <option value="Failed" data-select2-id="select2-data-141-d6hx">Failed</option>
                            <option value="Pending" data-select2-id="select2-data-142-ann2">Pending</option>
                            <option value="Processing" data-select2-id="select2-data-143-ailo">Processing</option>
                            <option value="Refunded" data-select2-id="select2-data-144-ag7n">Refunded</option>
                            <option value="Delivered" data-select2-id="select2-data-145-wy7k">Delivered</option>
                            <option value="Delivering" data-select2-id="select2-data-146-qliw">Delivering</option>
                        </select><span
                            class="select2 select2-container select2-container--bootstrap5 select2-container--below"
                            dir="ltr" data-select2-id="select2-data-8-99j2" style="width: 100%;"><span
                                class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-solid"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-j6xe-container"
                                    aria-controls="select2-j6xe-container"><span class="select2-selection__rendered"
                                        id="select2-j6xe-container" role="textbox" aria-readonly="true" title="Status"><span
                                            class="select2-selection__placeholder">Status</span></span><span
                                        class="select2-selection__arrow" role="presentation"><b
                                            role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                aria-hidden="true"></span></span>
                        <!--end::Select2-->
                    </div>
                    <!--begin::Add product-->
                    <a href="apps/ecommerce/catalog/add-product.html" class="btn btn-primary">Add Order</a>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#kt_table_user').DataTable({
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
                    // Re-init KTMenu supaya dropdown action berfungsi setelah data di-render ulang
                    KTMenu.createInstances();
                }
            });
        });
    </script>
@endsection
