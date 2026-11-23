@extends('bo.layout.app')

@push('css')
    <style>
        .table td, .table th {
            padding: 16px 16px !important;
        }
        .table th:first-child,
        .table td:first-child {
            min-width: 60px;
        }
        .table th:nth-child(3),
        .table td:nth-child(3) {
            min-width: 70px;
        }
        .table tbody td {
            text-align: center !important;
        }
        .table thead th > :not(caption) > * > * {
            border-left: 0.5px solid #dee2e6;
            border-right: 0.5px solid #dee2e6;
        }
        .bg-pink {
            background-color: #d63384 !important;
        }
        .bg-light-pink {
            background-color: #fce4f0 !important;
        }
        .agregat-trigger {
            cursor: pointer !important;
        }
        .agregat-trigger:hover {
            opacity: 0.8;
        }
        tr.text-gray td {
            color: var(--bs-gray-600) !important;
        }

        /* Memaksa isi th dan td pada tabel tersebut agar rata tengah */
        /* Otomatis menargetkan semua ID yang diawali dengan "kt_table_" */
        table[id^="kt_table_"] th,
        table[id^="kt_table_"] td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .dataTables_wrapper table[id^="kt_table_"] th,
        .dataTables_wrapper table[id^="kt_table_"] td {
            text-align: center !important;
        }

        /* --- Kustomisasi Warna Toska untuk Nav Tabs --- */

        /* Warna teks (active & hover) */
        .nav-tabs .nav-link.active,
        .nav-tabs .nav-link:hover,
        .nav-tabs .nav-link.text-active-primary.active,
        .nav-tabs .nav-link.text-active-primary:hover,
        .nav-line-tabs .nav-item .nav-link.active,
        .nav-line-tabs .nav-item .nav-link:hover:not(.disabled) {
            color: #3FAAB2 !important;
        }

        /* Garis bawah versi border */
        .nav-line-tabs .nav-item .nav-link.active,
        .nav-line-tabs .nav-item .nav-link:hover:not(.disabled) {
            border-bottom-color: #3FAAB2 !important;
        }

        /* Garis bawah versi pseudo-element ::after */
        .nav-line-tabs .nav-item .nav-link.active::after,
        .nav-line-tabs .nav-item .nav-link:hover:not(.disabled)::after,
        .nav-line-tabs .nav-item.show .nav-link::after {
            background-color: #3FAAB2 !important;
        }
        #modalIsi table th,
        #modalIsi table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
        #modalIsi table thead th {
            background-color: #3b9eff !important;
            color: #fff !important;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        #modalIsi table tbody td {
            border-left: 0 !important;
            border-right: 0 !important;
        }
        #modalIsi table thead th {
        border-left: 0 !important;
        border-right: 0 !important;
        }
        #modalIsi table tbody tr:nth-child(odd) td {
        background-color: #f1f1f2 !important;
        }
        #modalIsi table tbody tr:nth-child(even) td {
            background-color: #ffffff !important;
        }
    </style>
@endpush
@section('content')

<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-5">
        <!--begin::Nav Tabs (Data Umum PKK, Pokja, dll)-->
            @php
                $tabAktif = $activeTab ?? 'data_umum';
            
                $tabs = [
                    'data_umum' => ['Data Umum PKK', 'kt_tab_data_umum', 'bo.pages.dashboard.data-umum'],
                    'pokja1'    => ['Pokja I',       'kt_tab_pokja_1',   'bo.pages.dashboard.pokja-1'],
                    'pokja2'    => ['Pokja II',      'kt_tab_pokja_2',   'bo.pages.dashboard.pokja-2'],
                    'pokja3'    => ['Pokja III',     'kt_tab_pokja_3',   'bo.pages.dashboard.pokja-3'],
                    'pokja4'    => ['Pokja IV',      'kt_tab_pokja_4',   'bo.pages.dashboard.pokja-4'],
                ];
            @endphp
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-5">
                @foreach ($tabs as $kunci => [$label, $idTab, $viewTab])
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 {{ $tabAktif === $kunci ? 'active' : '' }}"
                        data-bs-toggle="tab" href="#{{ $idTab }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        <!--end::Nav Tabs-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
<!--begin::Filter Periode-->
        <div class="d-flex justify-content-between align-items-center mb-8">
            <div class="d-flex align-items-center">
                <label class="fs-6 fw-bold text-gray-700 me-3">Periode</label>
                <div class="w-150px">
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true">
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>

            {{-- Tombol Lihat Panduan di pojok kanan --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPanduanGlobal">
                <i class="bi bi-info-circle-fill me-2"></i> Lihat Panduan
            </button>
        </div>
        <!--end::Filter Periode-->

        
        @if (($level ?? '') === 'kelurahan' && empty(auth()->user()->id_kec) && empty(auth()->user()->id_kel))
            <div class="mb-5 d-flex align-items-center">
                <a href="{{ route('dashboard') }}"
                class="btn btn-light btn-sm d-inline-flex align-items-center gap-2 rounded-2 px-4 py-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        @endif


        <!--begin::Tab Content-->
        <div class="tab-content">
            @foreach ($tabs as $kunci => [$label, $idTab, $viewTab])
                <div id="{{ $idTab }}" class="tab-pane fade {{ $tabAktif === $kunci ? 'show active' : '' }}">
                    @include($viewTab)
                </div>
            @endforeach
        </div>
        <!--end::Tab Content-->
    </div>
    <!--end::Card body-->
</div>

{{-- <!--begin::Row-->
<div class="row g-5 gx-xl-10">
    <!--begin::Col-->
    <div class="col-xxl-6 mb-md-5 mb-xl-10">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">
            <!--begin::Col-->
            <div class="col-md-6 col-xl-6 mb-xxl-10">
                <!--begin::Card widget 8-->
                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                        <!--begin::Statistics-->
                        <div class="mb-4 px-9">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center mb-2">
                                <!--begin::Currency-->
                                <span class="fs-4 fw-semibold text-gray-500 align-self-start me-1&gt;">$</span>
                                <!--end::Currency-->
                                <!--begin::Value-->
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">69,700</span>
                                <!--end::Value-->
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.2%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">Total Online Sales</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Statistics-->
                        <!--begin::Chart-->
                        <div id="kt_card_widget_8_chart" class="min-h-auto" style="height: 125px"></div>
                        <!--end::Chart-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 8-->
                <!--begin::Card widget 5-->
                <div class="card card-flush h-md-50 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">1,836</span>
                                <!--end::Amount-->
                                <!--begin::Badge-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>2.2%</span>
                                <!--end::Badge-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Total Sales</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex align-items-end pt-0">
                        <!--begin::Progress-->
                        <div class="d-flex align-items-center flex-column mt-3 w-100">
                            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                <span class="fw-bolder fs-6 text-gray-900">1,048 to Goal</span>
                                <span class="fw-bold fs-6 text-gray-500">62%</span>
                            </div>
                            <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 5-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 col-xl-6 mb-xxl-10">
                <!--begin::Card widget 9-->
                <div class="card overflow-hidden h-md-50 mb-5 mb-xl-10">
                    <!--begin::Card body-->
                    <div class="card-body d-flex justify-content-between flex-column px-0 pb-0">
                        <!--begin::Statistics-->
                        <div class="mb-4 px-9">
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-center mb-2">
                                <!--begin::Value-->
                                <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1">29,420</span>
                                <!--end::Value-->
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">Total Online Visitors</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Statistics-->
                        <!--begin::Chart-->
                        <div id="kt_card_widget_9_chart" class="min-h-auto" style="height: 125px"></div>
                        <!--end::Chart-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 9-->
                <!--begin::Card widget 7-->
                <div class="card card-flush h-md-50 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">6.3k</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Total New Customers</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Card body-->
                    <div class="card-body d-flex flex-column justify-content-end pe-0">
                        <!--begin::Title-->
                        <span class="fs-6 fw-bolder text-gray-800 d-block mb-2">Today’s Heroes</span>
                        <!--end::Title-->
                        <!--begin::Users group-->
                        <div class="symbol-group symbol-hover flex-nowrap">
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                                <img alt="Pic" src="{{ asset('') }}assets/media/avatars/300-11.jpg" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                <img alt="Pic" src="{{ asset('') }}assets/media/avatars/300-2.jpg" />
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                                <span class="symbol-label bg-danger text-inverse-danger fw-bold">P</span>
                            </div>
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                                <img alt="Pic" src="{{ asset('') }}assets/media/avatars/300-12.jpg" />
                            </div>
                            <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                <span class="symbol-label bg-light text-gray-400 fs-8 fw-bold">+42</span>
                            </a>
                        </div>
                        <!--end::Users group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card widget 7-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xxl-6 mb-5 mb-xl-10">
        <!--begin::Maps widget 1-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">World Sales</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Top Selling Countries</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu 3-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Create Invoice</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link flex-stack px-3">Create Payment 
                            <span class="ms-2" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference">
                                <i class="ki-outline ki-information fs-6"></i>
                            </span></a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Generate Bill</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">Subscription</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Plans</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Billing</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Statements</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content px-3">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                            <!--end::Input-->
                                            <!--end::Label-->
                                            <span class="form-check-label text-muted fs-6">Recuring</span>
                                            <!--end::Label-->
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-1">
                            <a href="#" class="menu-link px-3">Settings</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 3-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body d-flex flex-center">
                <!--begin::Map container-->
                <div id="kt_maps_widget_1_map" class="w-100 h-350px"></div>
                <!--end::Map container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Maps widget 1-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-10 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <!--begin::Engage widget 1-->
        <div class="card h-md-100" dir="ltr">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column flex-center">
                <!--begin::Heading-->
                <div class="mb-2">
                    <!--begin::Title-->
                    <h1 class="fw-semibold text-gray-800 text-center lh-lg">Have you tried 
                    <br />new 
                    <span class="fw-bolder">Invoice Manager ?</span></h1>
                    <!--end::Title-->
                    <!--begin::Illustration-->
                    <div class="py-10 text-center">
                        <img src="{{ asset('') }}assets/media/svg/illustrations/easy/2.svg" class="theme-light-show w-200px" alt="" />
                        <img src="{{ asset('') }}assets/media/svg/illustrations/easy/2-dark.svg" class="theme-dark-show w-200px" alt="" />
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Heading-->
                <!--begin::Links-->
                <div class="text-center mb-1">
                    <!--begin::Link-->
                    <a class="btn btn-sm btn-primary me-2" href="apps/ecommerce/customers/listing.html">Try now</a>
                    <!--end::Link-->
                    <!--begin::Link-->
                    <a class="btn btn-sm btn-light" href="apps/invoices/view/invoice-1.html">Learn more</a>
                    <!--end::Link-->
                </div>
                <!--end::Links-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Engage widget 1-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <!--begin::Chart widget 5-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header flex-nowrap pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Top Selling Categories</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">8k social visitors</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Ticket</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Customer</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                            <!--begin::Menu item-->
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">New Group</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end::Menu item-->
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Member Group</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Contact</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mt-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content px-3 py-3">
                                <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                            </div>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5 ps-6">
                <div id="kt_charts_widget_5" class="min-h-auto"></div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart widget 5-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-4 mb-5 mb-xl-10">
        <!--begin::List widget 6-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Top Selling Products</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">8k social visitors</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="apps/ecommerce/catalog/categories.html" class="btn btn-sm btn-light">View All</a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th class="p-0 w-50px pb-1">ITEM</th>
                                <th class="ps-0 min-w-140px"></th>
                                <th class="text-end min-w-140px p-0 pb-1">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr>
                                <td>
                                    <img src="{{ asset('') }}assets/media/stock/ecommerce/210.png" class="w-50px" alt="" />
                                </td>
                                <td class="ps-0">
                                    <a href="apps/ecommerce/sales/details.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Elephant 1802</a>
                                    <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Item: #XDG-2347</span>
                                </td>
                                <td>
                                    <span class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$72.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ asset('') }}assets/media/stock/ecommerce/215.png" class="w-50px" alt="" />
                                </td>
                                <td class="ps-0">
                                    <a href="apps/ecommerce/sales/details.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Red Laga</a>
                                    <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Item: #XDG-2347</span>
                                </td>
                                <td>
                                    <span class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$45.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ asset('') }}assets/media/stock/ecommerce/209.png" class="w-50px" alt="" />
                                </td>
                                <td class="ps-0">
                                    <a href="apps/ecommerce/sales/details.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">RiseUP</a>
                                    <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Item: #XDG-2347</span>
                                </td>
                                <td>
                                    <span class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$168.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ asset('') }}assets/media/stock/ecommerce/214.png" class="w-50px" alt="" />
                                </td>
                                <td class="ps-0">
                                    <a href="apps/ecommerce/sales/details.html" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">Yellow Stone</a>
                                    <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Item: #XDG-2347</span>
                                </td>
                                <td>
                                    <span class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">$72.00</span>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List widget 6-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-xxl-4 mb-xxl-10">
        <!--begin::List widget 7-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header py-7">
                <!--begin::Statistics-->
                <div class="m-0">
                    <!--begin::Heading-->
                    <div class="d-flex align-items-center mb-2">
                        <!--begin::Title-->
                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">0.37%</span>
                        <!--end::Title-->
                        <!--begin::Badge-->
                        <span class="badge badge-light-danger fs-base">
                        <i class="ki-outline ki-arrow-up fs-5 text-danger ms-n1"></i>8.02%</span>
                        <!--end::Badge-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Description-->
                    <span class="fs-6 fw-semibold text-gray-500">Online store convertion rate</span>
                    <!--end::Description-->
                </div>
                <!--end::Statistics-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Ticket</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Customer</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                            <!--begin::Menu item-->
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">New Group</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end::Menu item-->
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Member Group</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Contact</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mt-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content px-3 py-3">
                                <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                            </div>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0">
                <!--begin::Items-->
                <div class="mb-0">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5">
                                <span class="symbol-label">
                                    <i class="ki-outline ki-magnifier fs-3 text-gray-600"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Search Retargeting</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-6 me-3">0.24%</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center">
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.4%</span>
                                <!--end::label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5">
                                <span class="symbol-label">
                                    <i class="ki-outline ki-tiktok fs-3 text-gray-600"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Social Retargeting</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-6 me-3">0.94%</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center">
                                <!--begin::label-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>9.4%</span>
                                <!--end::label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5">
                                <span class="symbol-label">
                                    <i class="ki-outline ki-sms fs-3 text-gray-600"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Email Retargeting</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-6 me-3">1.23%</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center">
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>
                                <!--end::label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5">
                                <span class="symbol-label">
                                    <i class="ki-outline ki-icon fs-3 text-gray-600"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals Customers</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-6 me-3">0.08%</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center">
                                <!--begin::label-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                <!--end::label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Section-->
                        <div class="d-flex align-items-center me-5">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5">
                                <span class="symbol-label">
                                    <i class="ki-outline ki-abstract-25 fs-3 text-gray-600"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Other</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-6 me-3">0.46%</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center">
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                <!--end::label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Items-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List widget 7-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xxl-8 mb-5 mb-xl-10">
        <!--begin::Chart widget 13-->
        <div class="card card-flush h-md-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Sales Statistics</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Top Selling Products</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Remove</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Mute</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Settings</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Chart container-->
                <div id="kt_charts_widget_13_chart" class="w-100 h-325px"></div>
                <!--end::Chart container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart widget 13-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-10 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <!--begin::List widget 8-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7 mb-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Visits by Country</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">20 countries share 97% visits</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="apps/ecommerce/sales/listing.html" class="btn btn-sm btn-light">View All</a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0">
                <!--begin::Items-->
                <div class="m-0">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/united-states.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">United States</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">9,763</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/brazil.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Brasil</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">All Social Channels</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">4,062</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-danger fs-base">
                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/turkey.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Turkey</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Mailchimp Campaigns</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">1,680</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/france.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">France</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Impact Radius visits</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">849</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/india.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">India</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Many Sources</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">604</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-danger fs-base">
                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>8.3%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('') }}assets/media/flags/sweden.svg" class="me-4 w-25px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex flex-stack flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Sweden</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-6 me-3 d-block">237</span>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>1.9%</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Items-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::LIst widget 8-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-4 mb-xl-10">
        <!--begin::List widget 9-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header py-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Social Network Visits</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">8k social visitors</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <a href="#" class="btn btn-sm btn-light">View All</a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body card-body d-flex justify-content-between flex-column pt-3">
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/dribbble-icon-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Dribbble</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Community</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">579</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/linkedin-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Linked In</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Media</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">2,588</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/slack-icon.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Slack</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Messanger</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/youtube-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">YouTube</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Video Channel</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">1,578</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/instagram-2-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Instagram</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">3,458</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                <!--begin::Separator-->
                <div class="separator separator-dashed my-3"></div>
                <!--end::Separator-->
                <!--begin::Item-->
                <div class="d-flex flex-stack">
                    <!--begin::Flag-->
                    <img src="{{ asset('') }}assets/media/svg/brand-logos/facebook-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                    <!--end::Flag-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <!--begin::Content-->
                        <div class="me-5">
                            <!--begin::Title-->
                            <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Facebook</a>
                            <!--end::Title-->
                            <!--begin::Desc-->
                            <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                            <!--end::Desc-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center">
                            <!--begin::Number-->
                            <span class="text-gray-800 fw-bold fs-4 me-3">2,047</span>
                            <!--end::Number-->
                            <!--begin::Info-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>1.9%</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List widget 9-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-4 mb-5 mb-xl-10">
        <!--begin::Chart widget 14-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Departments</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Performance & achievements</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu 3-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Create Invoice</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link flex-stack px-3">Create Payment 
                            <span class="ms-2" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference">
                                <i class="ki-outline ki-information fs-6"></i>
                            </span></a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Generate Bill</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">Subscription</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Plans</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Billing</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Statements</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content px-3">
                                        <!--begin::Switch-->
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            <!--begin::Input-->
                                            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                            <!--end::Input-->
                                            <!--end::Label-->
                                            <span class="form-check-label text-muted fs-6">Recuring</span>
                                            <!--end::Label-->
                                        </label>
                                        <!--end::Switch-->
                                    </div>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-1">
                            <a href="#" class="menu-link px-3">Settings</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 3-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Chart container-->
                <div id="kt_charts_widget_14_chart" class="w-100 h-350px"></div>
                <!--end::Chart container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart widget 14-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
<!--begin::Row-->
<div class="row g-5 g-xl-10 g-xl-10">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::List widget 12-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Visits by Source</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">29.4k visitors</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mb-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Ticket</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Customer</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                            <!--begin::Menu item-->
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">New Group</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--end::Menu item-->
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Admin Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Staff Group</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Member Group</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">New Contact</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator mt-3 opacity-75"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content px-3 py-3">
                                <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                            </div>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body d-flex align-items-end">
                <!--begin::Wrapper-->
                <div class="w-100">
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Direct Source</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">1,067</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-tiktok fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Social Networks</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">All Social Channels</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">24,588</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-sms fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Email Newsletter</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Mailchimp Campaigns</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-icon fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Impact Radius visits</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">6,578</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                <span class="badge badge-light-danger fs-base">
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-center">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-30px me-5">
                            <span class="symbol-label">
                                <i class="ki-outline ki-abstract-25 fs-3 text-gray-600"></i>
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Container-->
                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Other</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Many Sources</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">79,458</span>
                                <!--end::Number-->
                                <!--begin::Info-->
                                <!--begin::label-->
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                <!--end::label-->
                                <!--end::Info-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Link-->
                    <div class="text-center pt-8 d-1">
                        <a href="apps/ecommerce/sales/details.html" class="text-primary opacity-75-hover fs-6 fw-bold">View Store Analytics 
                        <i class="ki-outline ki-arrow-right fs-3 text-primary"></i></a>
                    </div>
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::List widget 12-->
    </div>
    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xl-8">
        <!--begin::Chart widget 15-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-7">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Author Sales</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Statistics by Countries</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <!--begin::Menu-->
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                    </button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold w-100px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Remove</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Mute</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Settings</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                <!--begin::Chart container-->
                <div id="kt_charts_widget_15_chart" class="min-h-auto ps-4 pe-6 mb-3 h-350px"></div>
                <!--end::Chart container-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart widget 15-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row--> --}}

<!--begin::Modal - Dinamis-->
<div class="modal fade" id="modalDinamis" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalJudul"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="modalIsi"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFormDinamis" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success py-4">
        <h5 class="modal-title text-white fw-bold" id="judulFormDinamis">
          <i class="fas fa-plus-circle text-white me-2"></i>Tambah Data
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-6" id="isiFormDinamis"></div>
      <div class="modal-footer border-0 pt-0 px-6 pb-6">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="btnSimpanFormDinamis">
          <i class="fas fa-save me-1"></i> Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<!--begin::Modal - Panduan Pengisian Data-->
<div class="modal fade" id="modalPanduanGlobal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Panduan Pengisian Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-6" id="modalPanduanBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!--begin::Modal - Form Pokja 1-->
<div class="modal fade" id="modalFormPokja1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white py-4">
        <h5 class="modal-title text-white fw-bold" id="judulFormPokja1">Tambah Data</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formDynamicPj1" class="modal-body p-6 row g-3"></form>
      <div class="modal-footer border-0 pt-0 px-6 pb-6">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="formDynamicPj1" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

@push('js')
  {{-- Ganti blok dari <script src=index.js> sampai </script> penutup (sebelum @endpush) dengan isi file ini --}}
  <script src="{{ asset('assets/js/custom/pages/dashboard-pkk/index.js') }}"></script>
<script>
const modal     = new bootstrap.Modal(document.getElementById('modalDinamis'));
const modalForm = new bootstrap.Modal(document.getElementById('modalFormDinamis'));
const CSRF      = '{{ csrf_token() }}';

let ctx = {};
let berubah = false;
let pindahKeForm = false;
let kembaliKeModalUtama = true;

const esc = s => String(s ?? '').replace(/[&<>"']/g,
  c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

document.getElementById('modalDinamis').addEventListener('hidden.bs.modal', () => {
  if (pindahKeForm) { pindahKeForm = false; return; }
  if (berubah) { berubah = false; location.reload(); }
});

document.getElementById('modalFormDinamis').addEventListener('show.bs.modal', () => {
  pindahKeForm = true;
  modal.hide();
});

document.getElementById('modalFormDinamis').addEventListener('hidden.bs.modal', () => {
  if (kembaliKeModalUtama) {
    modal.show();
  }
});

function bukaFormPopup(judul, isEdit, htmlBody, onSimpan) {
  document.getElementById('judulFormDinamis').innerHTML =
    `<i class="fas ${isEdit ? 'fa-edit' : 'fa-plus-circle'} text-white me-2"></i>${esc(judul)}`;
  document.getElementById('isiFormDinamis').innerHTML = htmlBody;

  const btnSimpan = document.getElementById('btnSimpanFormDinamis');
  btnSimpan.disabled = false;
  btnSimpan.onclick = () => {
    btnSimpan.disabled = true;
    Promise.resolve(onSimpan()).finally(() => {
      btnSimpan.disabled = false;
    });
  };

  kembaliKeModalUtama = true;
  modalForm.show();
}

document.addEventListener('click', function (e) {
  const el = e.target.closest('.agregat-trigger[data-id]');
  if (!el) return;
  ctx = { id: el.dataset.id, kec: el.dataset.kecId, kel: el.dataset.kelId ?? 0, nama: el.dataset.kecNama };
  muat();
});

// Listener klik sel Volume & Jumlah Peserta Pokja 1
document.addEventListener('click', function (e) {
  const el = e.target.closest('.pokja1-detail-trigger');
  if (!el) return;

  ctx = {
    isPokja1: true,
    flagKolom: el.dataset.flagKolom,
    tipe: el.dataset.tipe,
    pertanyaanId: el.dataset.pertanyaanId ?? '',
    kec: el.dataset.kecId,
    kel: el.dataset.kelId ?? 0,
    nama: el.dataset.judul ?? ''
  };
  muatPokja1();
});

function muatPokja1() {
  const params = new URLSearchParams({
    flag_kolom: ctx.flagKolom,
    tipe: ctx.tipe,
    kec: ctx.kec,
    kel: ctx.kel,
    pertanyaan_id: ctx.pertanyaanId
  });

  fetch(`{{ route('pokja-1.detail') }}?${params.toString()}`, {
    headers: { 'Accept': 'application/json' }
  })
    .then(async r => {
      const hasil = await r.json();
      if (!r.ok) {
        throw new Error(hasil.message || `HTTP Error ${r.status}`);
      }
      return hasil;
    })
    .then(hasil => {
      document.getElementById('modalJudul').textContent = `DETAIL ${ctx.nama}`;
      tampilkanPokja1(hasil);
    })
    .catch(err => alert('Gagal memuat detail Pokja 1:\n' + err.message));
}

function alertAksesKota() {
  if (typeof Swal !== 'undefined') {
    Swal.fire({
      icon: 'info',
      title: 'Akses Dibatasi',
      text: 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan',
      confirmButtonText: 'Mengerti',
      customClass: {
        confirmButton: 'btn btn-primary'
      }
    });
  } else {
    alert('Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan');
  }
}

function tampilkanPokja1(hasil) {
  ctx.namaKec = hasil.pokja1_meta?.nama_kec ?? '';
  ctx.namaKel = hasil.pokja1_meta?.nama_kel ?? '';
  const isi = document.getElementById('modalIsi');

  if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tabelModal')) {
    $('#tabelModal').DataTable().destroy();
  }

  const kolom = hasil.kolom.filter(k => k !== 'id');
  const baris = hasil.rows.map((r, i) => {
    let tombolAksi = '';
    if (hasil.is_kota) {
      tombolAksi = ctx.tipe === 'kader'
        ? `<button type="button" class="btn btn-sm" style="background-color:#d5d7e2; color:#4b5675;" onclick="alertAksesKota()"><i class="fas fa-lock"></i></button>`
        : `<button type="button" class="btn btn-sm btn-warning me-1" onclick="alertAksesKota()"><i class="fas fa-edit"></i></button>
           <button type="button" class="btn btn-sm btn-danger" onclick="alertAksesKota()"><i class="fas fa-trash"></i></button>`;
    } else {
      tombolAksi = `<button type="button" class="btn btn-sm btn-warning btn-edit-pj1 me-1" data-idx="${i}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger btn-hapus-pj1" data-id="${esc(r.id)}"><i class="fas fa-trash"></i></button>`;
    }

    return `<tr>
      <td>${i + 1}</td>
      ${kolom.map(k => `<td>${esc(r[k] ?? '-')}</td>`).join('')}
      <td class="text-nowrap">${tombolAksi}</td>
    </tr>`;
  }).join('');

  isi.innerHTML = `
    ${hasil.bisa_tambah ? '<div class="mb-4"><button class="btn btn-sm btn-primary" id="btnTambahPj1">+ Tambah Data</button></div>' : ''}
    <table id="tabelModal" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>NO</th>
          ${kolom.map(k => `<th>${esc(k.replace(/_/g, ' ').toUpperCase())}</th>`).join('')}
          <th>AKSI</th>
        </tr>
      </thead>
      <tbody>${baris}</tbody>
    </table>`;

  if ($.fn.DataTable) {
    $('#tabelModal').DataTable({
      pageLength: 10,
      language: {
        emptyTable: 'Tidak ada data untuk ditampilkan', lengthMenu: '_MENU_',
        info: 'Showing _START_ to _END_ of _TOTAL_ records', infoEmpty: 'Showing no records',
        search: 'Search:', paginate: { previous: '‹', next: '›' }
      },
      dom:
        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>"
    });
  }

  isi.onclick = (e) => {
    const ed = e.target.closest('.btn-edit-pj1');
    if (ed) {
      formPokja1(hasil.rows[+ed.dataset.idx]);
      return;
    }
    const del = e.target.closest('.btn-hapus-pj1');
    if (!del) return;
    if (!confirm('Hapus data ini?')) return;

    kirim(`/pokja-1/delete/${del.dataset.id}`, 'DELETE', { tipe: ctx.tipe })
      .then(() => { berubah = true; muatPokja1(); })
      .catch(err => alert(err.message));
  };

  const btnTambah = document.getElementById('btnTambahPj1');
  if (btnTambah) btnTambah.onclick = () => formPokja1();

  modal.show();
}

const modalFormPj1 = new bootstrap.Modal(document.getElementById('modalFormPokja1'));

document.getElementById('modalFormPokja1').addEventListener('show.bs.modal', () => {
  pindahKeForm = true;
  modal.hide();
});

function formPokja1(data = null) {
  const isKader = ctx.tipe === 'kader';
  const isVol   = ctx.tipe === 'volume';
  const kegiatan = ({ kisah: 'Kemangi', krisan: 'Krisan', kilas: 'Kilas', kiat: 'Kiat', kisak: 'Kisak', pkbn: 'PKBN' })[ctx.flagKolom] || ctx.flagKolom.toUpperCase();

  const labelJudul = isKader ? 'Kader Pokja I' : (isVol ? 'Lotus' : 'Peserta');
  document.getElementById('judulFormPokja1').innerHTML =
    `<i class="fas ${data ? 'fa-edit' : 'fa-plus-circle'} text-white me-2"></i>${data ? 'Edit' : 'Tambah'} Data ${labelJudul}`;

  const fields = isKader ? [
    ['nik', 'NIK', 6, 'text', true, { maxlength: 16, valKey: 'nik_asli', placeholder: '16 digit NIK' }],
    ['no_kk', 'No KK', 6, 'text', false, { maxlength: 16, valKey: 'no_kk_asli', placeholder: '16 digit No KK' }],
    ['nama', 'Nama Kader', 12, 'text', true, { placeholder: 'Masukkan nama lengkap' }],
    ['jenis_kelamin', 'Jenis Kelamin', 6, 'select', true, { options: ['L', 'P'], valKey: 'kelamin' }],
    ['jabatan', 'Jabatan', 6, 'select', true, { options: ['Ketua POKJA I', 'Sekretaris POKJA I', 'Anggota POKJA I'] }],
    ['no_hp', 'No HP', 6, 'text', false, { placeholder: 'Contoh: 08123456789' }],
    ['rw', 'RW', 3, 'text', false, { maxlength: 5, placeholder: '01' }],
    ['rt', 'RT', 3, 'text', false, { maxlength: 5, placeholder: '01' }],
    ['alamat', 'Alamat', 12, 'textarea', false, { rows: 2, placeholder: 'Masukkan alamat lengkap' }],
    ['nama_kec', 'Kecamatan', 6, 'text', false, { value: ctx.namaKec, disabled: true }],
    ['nama_kel', 'Kelurahan', 6, 'text', false, { value: ctx.namaKel, disabled: true }],
  ] : (isVol ? [
    ['nama', `Nama ${kegiatan}`, 12, 'text', true, { placeholder: 'Masukkan nama' }],
    ['alamat', `Alamat ${kegiatan}`, 12, 'textarea', true, { placeholder: 'Masukkan alamat', rows: 3 }],
    ['nama_kec', 'Kecamatan', 6, 'text', false, { value: ctx.namaKec, disabled: true }],
    ['nama_kel', 'Kelurahan', 6, 'text', false, { value: ctx.namaKel, disabled: true }],
    ['rw', 'RW', 6, 'text', true, { placeholder: 'Contoh: 01', maxlength: 5 }],
    ['rt', 'RT', 6, 'text', false, { placeholder: 'Contoh: 01', maxlength: 5 }],
    ['tahun', 'Tahun', 6, 'select', true, { options: ['2025', '2026'], value: '2026' }],
    ['tahap', 'Tahap', 6, 'select', true, { options: ['Tahap 1', 'Tahap 2', 'Tahap 3', 'Tahap 4'] }],
  ] : [
    ['nik', 'NIK', 6, 'text', true, { maxlength: 16, valKey: 'nik_asli' }],
    ['no_kk', 'No KK', 6, 'text', false, { maxlength: 16, valKey: 'no_kk_asli' }],
    ['nama', 'Nama Peserta', 12, 'text', true, {}],
    ['pendamping', 'Nama Pendamping', 6, 'text', false, {}],
    ['nik_pendamping', 'NIK Pendamping', 6, 'text', false, { maxlength: 16 }],
    ['hubungan_keluarga', 'Hubungan Keluarga', 12, 'text', false, {}],
    ['alamat', 'Alamat', 12, 'textarea', false, { rows: 2 }],
    ['nama_kec', 'Kecamatan', 6, 'text', false, { value: ctx.namaKec, disabled: true }],
    ['nama_kel', 'Kelurahan', 6, 'text', false, { value: ctx.namaKel, disabled: true }],
    ['rw', 'RW', 4, 'text', false, { maxlength: 5 }],
    ['rt', 'RT', 4, 'text', false, { maxlength: 5 }],
    ['tahap', 'Tahap', 4, 'select', false, { options: ['Tahap 1', 'Tahap 2', 'Tahap 3', 'Tahap 4'] }],
  ]);

  const form = document.getElementById('formDynamicPj1');
  form.innerHTML = fields.map(([name, label, col, type, req, opt = {}]) => {
    const val = data ? (data[opt.valKey || name] ?? '') : (opt.value ?? '');
    const attr = `name="${name}" ${req ? 'required' : ''} ${opt.disabled ? 'disabled' : ''} ${opt.maxlength ? `maxlength="${opt.maxlength}"` : ''} placeholder="${opt.placeholder || ''}"`;

    let input = `<input class="form-control form-control-solid ${opt.disabled ? 'bg-light' : ''}" value="${esc(val)}" ${attr}>`;
    if (type === 'textarea') input = `<textarea class="form-control form-control-solid" rows="${opt.rows || 2}" ${attr}>${esc(val)}</textarea>`;
    if (type === 'select') {
      input = `<select class="form-select form-select-solid" ${attr}><option value="">-- PILIH --</option>` +
        opt.options.map(o => `<option value="${o}" ${val == o ? 'selected' : ''}>${o}</option>`).join('') + `</select>`;
    }
    return `<div class="col-${col}"><label class="form-label fw-semibold">${label}${req ? ' <span class="text-danger">*</span>' : ''}</label>${input}</div>`;
  }).join('');

  form.onsubmit = (e) => {
    e.preventDefault();
    const payload = Object.assign(Object.fromEntries(new FormData(form)), {
      flag_kolom: ctx.flagKolom, tipe: ctx.tipe, pertanyaan_id: ctx.pertanyaanId, id_kec: ctx.kec, id_kel: ctx.kel
    });

    (data ? kirim(`/pokja-1/update/${data.id}`, 'PUT', payload) : kirim('/pokja-1/store', 'POST', payload))
      .then(() => { berubah = true; modalFormPj1.hide(); muatPokja1(); })
      .catch(err => alert(err.message));
  };

  modalFormPj1.show();
}

function muat() {
  fetch(`/modal/${ctx.id}?kec=${ctx.kec}&kel=${ctx.kel}`, { headers: { 'Accept': 'application/json' } })
    .then(async r => {
      const j = await r.json().catch(() => ({}));
      if (!r.ok) throw new Error(j.message || `Error ${r.status}`);
      return j;
    })
    .then(tampilkan)
    .catch(err => alert(err.message));
}

function kirim(url, method, body) {
  return fetch(url, {
    method,
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
    body: body ? JSON.stringify(body) : undefined,
  }).then(async r => {
    const j = await r.json().catch(() => ({}));
    if (!r.ok) {
      const pesan = j.errors ? Object.values(j.errors).flat().join('\n') : (j.message || 'Terjadi kesalahan.');
      throw new Error(pesan);
    }
    return j;
  });
}

function tampilkan(hasil) {
  ctx.judulIndikator = hasil.judul.replace(/_/g, ' ');
  document.getElementById('modalJudul').textContent =
    `DETAIL ${ctx.judulIndikator} - ${ctx.nama ?? ''}`;
  const isi = document.getElementById('modalIsi');

  if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tabelModal')) {
    $('#tabelModal').DataTable().destroy();
  }

  if (hasil.tampilan === 'angka') {
    const nilai = hasil.rows[0]?.nilai ?? 0;
    if (+ctx.kel > 0 && hasil.bisa_input) {
      isi.innerHTML = `
        <label class="form-label fw-bold">Jumlah</label>
        <div class="input-group">
          <input type="number" min="0" step="1" id="inputAgregat" class="form-control" value="${esc(nilai)}">
          <button class="btn btn-primary" id="btnSimpanAgregat">Simpan</button>
        </div>`;
      document.getElementById('btnSimpanAgregat').onclick = () => {
        kirim(hasil.url_agregat || '/pokja-3/agregat', 'POST', {
          id_pertanyaan: ctx.id, id_kec: +ctx.kec, id_kel: +ctx.kel,
          nilai: document.getElementById('inputAgregat').value,
        }).then(() => { berubah = true; modal.hide(); })
          .catch(err => alert(err.message));
      };
    } else {
      isi.innerHTML = `<input class="form-control" value="${esc(nilai)}" readonly>`;
    }
  } else {
    const isGkstb  = ['kesehatan', 'kelestarian_lh', 'perencanaan_sehat'].includes(hasil.alias);
    const isPokja4 = !isGkstb && (hasil.tb_dashboard === 'd_pokja_4_2026' || ['imunisasi', 'pkg', 'tbc'].includes(hasil.alias));

    const parseKategori = raw => {
      try {
        const arr = typeof raw === 'string' ? JSON.parse(raw) : raw;
        return Array.isArray(arr) ? arr : [String(raw ?? '-')];
      } catch {
        return [String(raw ?? '-')];
      }
    };

    const adaAksi = hasil.bisa_ubah || hasil.bisa_edit;
    const kolom = hasil.kolom.filter(k => k !== 'id');
    const baris = hasil.rows.map((r, i) =>
      `<tr><td>${i + 1}</td>${kolom.map(k => {
        if (isGkstb && k === 'KATEGORI') {
          const items = parseKategori(r[k]).map(item => `<li>${esc(item)}</li>`).join('');
          return `<td class="text-start"><ul class="mb-0 ps-4">${items}</ul></td>`;
        }
        return `<td>${esc(r[k])}</td>`;
      }).join('')}
        ${adaAksi ? `<td class="text-nowrap">
          ${hasil.bisa_edit ? `<button class="btn btn-sm btn-warning btn-edit me-1" data-idx="${i}"><i class="fas fa-edit"></i></button>` : ''}
          ${hasil.bisa_ubah ? `<button class="btn btn-sm btn-danger btn-hapus" data-kader="${esc(r.id)}"><i class="fas fa-trash"></i></button>` : ''}
        </td>` : ''}
      </tr>`).join('');

    isi.innerHTML = `
      ${hasil.bisa_tambah ? '<div class="mb-4"><button class="btn btn-sm btn-primary" id="btnTambah">+ Tambah Data</button></div>' : ''}
      <table id="tabelModal" class="table table-bordered table-striped">
        <thead><tr><th>NO</th>${kolom.map(k => `<th>${esc(k.replace(/_/g, ' ').toUpperCase())}</th>`).join('')}${adaAksi ? '<th>AKSI</th>' : ''}</tr></thead>
        <tbody>${baris}</tbody>
      </table>`;

    if ($.fn.DataTable) {
      $('#tabelModal').DataTable({
        pageLength: 10,
        language: {
          emptyTable: 'Tidak ada data untuk ditampilkan', lengthMenu: '_MENU_',
          info: 'Showing _START_ to _END_ of _TOTAL_ records', infoEmpty: 'Showing no records',
          search: 'Search:', paginate: { previous: '‹', next: '›' }
        },
        dom:
          "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>"
      });
    }

    isi.onclick = (e) => {
      const ed = e.target.closest('.btn-edit');
      if (ed) {
        const row = hasil.rows[+ed.dataset.idx];
        if (isGkstb) formGkstb(hasil.alias, row);
        else if (isPokja4) formDetailPokja4(row);
        else formTambahKader(row);
        return;
      }
      const b = e.target.closest('.btn-hapus');
      if (!b) return;
      if (!confirm('Hapus data ini?')) return;

      const urlHapus = isGkstb
        ? `/pokja-4/gkstb/${b.dataset.kader}`
        : (isPokja4 ? `/pokja-4/detail/${b.dataset.kader}` : `/pokja-3/kader/${b.dataset.kader}`);

      kirim(urlHapus, 'DELETE')
        .then(() => { berubah = true; muat(); })
        .catch(err => alert(err.message));
    };

    const btnTambah = document.getElementById('btnTambah');
    if (btnTambah) {
      btnTambah.onclick = () => {
        if (isGkstb) formGkstb(hasil.alias);
        else if (isPokja4) formDetailPokja4();
        else formTambahKader();
      };
    }
  }
  modal.show();
}

function formTambahKader(data = null) {
  const v = id => document.getElementById(id).value;
  const html = `
    <div class="row g-4">
      <div class="col-md-6">
        <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
        <div class="input-group">
          <input id="fNik" class="form-control form-control-solid" maxlength="16" inputmode="numeric" placeholder="16 digit NIK">
          <button class="btn btn-secondary" id="btnCari" type="button">Cari</button>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">No KK</label>
        <input id="fNoKk" class="form-control form-control-solid" maxlength="20" placeholder="16 digit No KK">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
        <input id="fNama" class="form-control form-control-solid" placeholder="Masukkan nama lengkap">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
        <select id="fJk" class="form-select form-select-solid">
          <option value="">-- PILIH --</option>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
        <select id="fJabatan" class="form-select form-select-solid">
          <option>Ketua</option>
          <option>Wakil Ketua</option>
          <option>Sekretaris</option>
          <option selected>Anggota</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">No HP</label>
        <input id="fHp" class="form-control form-control-solid" placeholder="Contoh: 08123456789">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">RW</label>
        <input id="fRw" class="form-control form-control-solid" maxlength="5" placeholder="01">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">RT</label>
        <input id="fRt" class="form-control form-control-solid" maxlength="5" placeholder="01">
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Alamat</label>
        <textarea id="fAlamat" class="form-control form-control-solid" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
      </div>
    </div>`;

  bukaFormPopup(`${data ? 'Edit' : 'Tambah'} Data Kader`, !!data, html, () => {
    const isiForm = {
      nik: v('fNik'), no_kk: v('fNoKk'), nama: v('fNama'), jenis_kelamin: v('fJk'),
      jabatan: v('fJabatan'), no_hp: v('fHp'), rw: v('fRw'), rt: v('fRt'), alamat: v('fAlamat'),
    };
    const req = data
      ? kirim(`/pokja-3/kader/${data.id}`, 'PUT', isiForm)
      : kirim('/pokja-3/kader', 'POST', { id_pertanyaan: ctx.id, id_kec: +ctx.kec, id_kel: +ctx.kel, ...isiForm });

    return req.then(() => {
      berubah = true;
      kembaliKeModalUtama = false;
      modalForm.hide();
      muat();
    }).catch(err => alert(err.message));
  });

  if (data) {
    const set = (id, val) => { document.getElementById(id).value = val ?? ''; };
    set('fNik', data.nik); set('fNoKk', data.no_kk); set('fNama', data.nama);
    set('fJk', data.jenis_kelamin); set('fJabatan', data.jabatan); set('fHp', data.no_hp);
    set('fRw', data.rw); set('fRt', data.rt); set('fAlamat', data.alamat);
  }

  document.getElementById('btnCari').onclick = () => {
    fetch(`/pokja-3/cari-nik?nik=${encodeURIComponent(v('fNik'))}`, { headers: { 'Accept': 'application/json' } })
      .then(async r => ({ ok: r.ok, j: await r.json() }))
      .then(({ ok, j }) => {
        if (!ok) return alert(j.message || 'NIK tidak ditemukan, lengkapi manual.');
        const d = j.data;
        const set = (id, val) => { document.getElementById(id).value = val ?? ''; };
        set('fNoKk', d.no_kk); set('fNama', d.nama); set('fJk', d.jenis_kelamin);
        set('fHp', d.no_hp); set('fRw', d.rw); set('fRt', d.rt); set('fAlamat', d.alamat);
      });
  };
}

function formDetailPokja4(data = null) {
  const v = id => document.getElementById(id).value;
  const html = `
    <div class="row g-4">
      <div class="col-md-6">
        <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
        <div class="input-group">
          <input id="p4Nik" class="form-control form-control-solid" maxlength="20" inputmode="numeric" placeholder="16 digit NIK">
          <button class="btn btn-secondary" id="btnCariP4" type="button">Cari</button>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">No KK</label>
        <input id="p4NoKk" class="form-control form-control-solid" maxlength="30" placeholder="16 digit No KK">
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
        <input id="p4Nama" class="form-control form-control-solid" placeholder="Masukkan nama lengkap">
      </div>
      <div class="col-md-6">
        <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
        <select id="p4Jk" class="form-select form-select-solid">
          <option value="">-- PILIH --</option>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">RT</label>
        <input id="p4Rt" class="form-control form-control-solid" maxlength="5" placeholder="01">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">RW</label>
        <input id="p4Rw" class="form-control form-control-solid" maxlength="5" placeholder="01">
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Alamat</label>
        <textarea id="p4Alamat" class="form-control form-control-solid" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
      </div>
    </div>`;

  bukaFormPopup(`${data ? 'Edit' : 'Tambah'} Data ${ctx.judulIndikator ?? ''}`, !!data, html, () => {
    const payload = {
      nik: v('p4Nik'),
      no_kk: v('p4NoKk'),
      nama: v('p4Nama'),
      jenis_kelamin: v('p4Jk'),
      rt: v('p4Rt'),
      rw: v('p4Rw'),
      alamat: v('p4Alamat'),
    };
    const req = data
      ? kirim(`/pokja-4/detail/${data.id}`, 'PUT', payload)
      : kirim('/pokja-4/detail', 'POST', {
          id_pertanyaan: ctx.id,
          id_kec: +ctx.kec,
          id_kel: +ctx.kel,
          ...payload,
        });

    return req.then(() => {
      berubah = true;
      kembaliKeModalUtama = false;
      modalForm.hide();
      muat();
    }).catch(err => alert(err.message));
  });

  if (data) {
    const set = (id, val) => { document.getElementById(id).value = val ?? ''; };
    set('p4Nik', data['NIK'] ?? data.nik);
    set('p4NoKk', data['NO KK'] ?? data.no_kk);
    set('p4Nama', data['NAMA'] ?? data.nama);
    const jkRaw = data['JENIS KELAMIN'] ?? data.jenis_kelamin ?? '';
    set('p4Jk', jkRaw === 'LAKI-LAKI' ? 'L' : (jkRaw === 'PEREMPUAN' ? 'P' : jkRaw));
    set('p4Rt', data['RT'] ?? data.rt);
    set('p4Rw', data['RW'] ?? data.rw);
    set('p4Alamat', data['ALAMAT'] ?? data.alamat);
  }

  document.getElementById('btnCariP4').onclick = () => {
    fetch(`/pokja-4/cari-nik?nik=${encodeURIComponent(v('p4Nik'))}`, { headers: { 'Accept': 'application/json' } })
      .then(async r => ({ ok: r.ok, j: await r.json() }))
      .then(({ ok, j }) => {
        if (!ok) return alert(j.message || 'NIK tidak ditemukan, lengkapi manual.');
        const d = j.data;
        const set = (id, val) => { document.getElementById(id).value = val ?? ''; };
        set('p4NoKk', d.no_kk);
        set('p4Nama', d.nama);
        set('p4Jk', d.jenis_kelamin);
        set('p4Rt', d.rt);
        set('p4Rw', d.rw);
        set('p4Alamat', d.alamat);
      });
  };
}

const OPSI_GKSTTB = {
  kesehatan: {
    judul: '1. Kesehatan',
    items: [
      'Peduli Stunting',
      'Menuju PHBS',
      'Peduli Kesehatan Keluarga',
    ],
  },
  kelestarian_lh: {
    judul: '2. Kelestarian Lingkungan Hidup',
    items: [
      'Siaga Kebakaran Lingkungan',
      'Mitigasi Bencana Alam',
      'Peduli Lingkungan',
    ],
  },
  perencanaan_sehat: {
    judul: '3. Perencanaan Sehat',
    items: [
      'Menuju Keluarga Sehat Berkualitas',
      'Menuju Keuangan Sehat',
      'Menuju Keluarga Sehat Pasangan Usia Subur',
    ],
  },
};

function formGkstb(alias, data = null) {
  const cfg = OPSI_GKSTTB[alias] || { judul: 'Kategori', items: [] };
  let terpilih = [];
  if (data && data['KATEGORI']) {
    try {
      terpilih = typeof data['KATEGORI'] === 'string' ? JSON.parse(data['KATEGORI']) : data['KATEGORI'];
    } catch { terpilih = []; }
  }

  const html = `
    <div class="mb-5">
      <label class="form-label fw-semibold">Project Name <span class="text-danger">*</span></label>
      <input id="gkProyek" class="form-control form-control-solid" placeholder="Masukkan Project Name" value="${esc(data ? data['NAMA PROYEK'] : '')}">
    </div>
    <div>
      <label class="form-label fw-bold d-block mb-3">${esc(cfg.judul)}</label>
      <div class="d-flex flex-column gap-3">
        ${cfg.items.map(item => `
          <label class="form-check form-check-custom form-check-solid">
            <input class="form-check-input gk-kat" type="checkbox" value="${esc(item)}" ${terpilih.includes(item) ? 'checked' : ''}>
            <span class="form-check-label text-gray-700">${esc(item)}</span>
          </label>`).join('')}
      </div>
    </div>`;

  bukaFormPopup(`${data ? 'Edit' : 'Tambah'} GKSTTB`, !!data, html, () => {
    const namaProyek = document.getElementById('gkProyek').value.trim();
    const kategori = [...document.querySelectorAll('.gk-kat:checked')].map(el => el.value);

    const req = data
      ? kirim(`/pokja-4/gkstb/${data.id}`, 'PUT', { nama_proyek: namaProyek, kategori })
      : kirim('/pokja-4/gkstb', 'POST', {
          id_pertanyaan: ctx.id,
          id_kec: +ctx.kec,
          id_kel: +ctx.kel,
          nama_proyek: namaProyek,
          kategori,
        });

    return req.then(() => {
      berubah = true;
      kembaliKeModalUtama = false;
      modalForm.hide();
      muat();
    }).catch(err => alert(err.message));
  });
}
</script>
@endpush

@include('bo.pages.dashboard.modals.pokja2-modal')
@endsection