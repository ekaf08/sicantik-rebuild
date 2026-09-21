<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch flex-stack" id="kt_app_header_container">

        <!--begin::Sidebar toggle (Mobile)-->
        <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--begin::Logo image-->
            <a href="index.html">
                <img alt="Logo" src="{{ asset('assets/media/logos/demo38-small.svg') }}" class="h-30px" />
            </a>
            <!--end::Logo image-->
        </div>
        <!--end::Sidebar toggle-->

        <!--begin::Navbar-->
        <div class="app-navbar flex-lg-grow-1 justify-content-end" id="kt_app_header_navbar">

            <!--begin::User menu-->
            <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">

                <!--begin::Avatar Trigger (Panah Biru: Logo PKK di Pojok Kanan Atas Header)-->
                <div class="cursor-pointer symbol symbol-circle symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <img src="{{ asset('assets/media/logos/logo-pkk.png') }}" alt="Logo PKK" class="object-fit-cover" />
                </div>
                <!--end::Avatar Trigger-->

                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">

                    <!--begin::User Info Header-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--Logo PKK di Dalam Dropdown Menu-->
                            <div class="symbol symbol-50px me-5">
                                <img alt="Logo PKK" src="{{ asset('assets/media/logos/logo-pkk.png') }}" class="rounded-circle object-fit-cover" />
                            </div>
                            <!--User Detail-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5 text-gray-900">
                                    {{ Auth::user()->name ?? 'User PKK' }}
                                </div>
                                <span class="fw-semibold text-muted fs-7 text-break">
                                    {{ Auth::user()->email ?? 'user@surabaya.go.id' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::User Info Header-->

                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->

                    <!--begin::Account Settings (Buka Modal Ganti Password)-->
                    <div class="menu-item px-5">
                        <a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#modal_ganti_password">
                            <i class="ki-outline ki-key fs-5 me-2"></i> Account Settings
                        </a>
                    </div>
                    <!--end::Account Settings-->

                    <!--begin::Sign Out-->
                    <div class="menu-item px-5">
                        <a href="#" class="menu-link px-5 text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ki-outline ki-exit-right fs-5 me-2 text-danger"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    <!--end::Sign Out-->

                </div>
                <!--end::User account menu-->

            </div>
            <!--end::User menu-->

        </div>
        <!--end::Navbar-->

        <!--begin::Separator-->
        <div class="app-navbar-separator separator d-none d-lg-flex"></div>
        <!--end::Separator-->

    </div>
    <!--end::Header container-->
</div>

<!-- ========================================== -->
<!-- MODAL GANTI PASSWORD (ACCOUNT SETTINGS)     -->
<!-- ========================================== -->
<div class="modal fade" id="modal_ganti_password" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0 pb-0">
                <h3 class="modal-title fw-bold text-gray-900 fs-4">Ganti Password</h3>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>

            <div class="modal-body py-6 px-8">
                <form id="form_ganti_password" action="#" method="POST">
                    @csrf

                    <!-- Password Lama -->
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-bold text-gray-700 required">Password Lama</label>
                        <input type="password" class="form-control form-control-solid" name="current_password" placeholder="Masukkan password lama" required />
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-bold text-gray-700 required">Password Baru</label>
                        <input type="password" class="form-control form-control-solid" name="new_password" placeholder="Masukkan password baru" required />
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="mb-6">
                        <label class="form-label fs-7 fw-bold text-gray-700 required">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control form-control-solid" name="new_password_confirmation" placeholder="Ulangi password baru" required />
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                        <button type="button" class="btn btn-light fw-bold px-6" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold px-6">Simpan Password</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
