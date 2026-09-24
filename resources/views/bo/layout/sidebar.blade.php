<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Header (Dibuat lebih ringkas tingginya) -->
    <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-4 pb-2 px-3" id="kt_app_sidebar_header">

        <!--begin::Logo & Teks-->
        <a href="{{ url('/dashboard') }}" class="app-sidebar-logo d-flex flex-column align-items-center text-center text-decoration-none mx-auto py-1">
            <!-- Gambar Logo (Ukuran disesuaikan agar pas) -->
            <img alt="Logo" src="{{ asset('img/png/logo-sicantik-pkk.png') }}" class="h-25px mb-1 app-sidebar-logo-default" />

            <!-- Teks di Bawah Logo -->
            <div class="app-sidebar-text-wrapper">
                <span class="fs-8 fw-bold text-dark theme-light-show d-block">Si Cantik Surabaya</span>
                <span class="fs-8 fw-bold text-white theme-dark-show d-block">Si Cantik Surabaya</span>
            </div>
        </a>
        <!--end::Logo-->

        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon bg-light btn-color-gray-700 btn-active-color-primary rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-text-align-right rotate-180 fs-1"></i>
        </div>
        <!--end::Sidebar toggle-->

    </div>
    <!--end::Header-->
    <!--begin::Navs-->
    <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
        <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper hover-scroll-y my-2" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">

            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary">
                <!--begin::Heading-->
                <div class="menu-item mb-2">
                    <div class="menu-heading text-uppercase fs-7 fw-bold">Menu</div>
                    <!--begin::Separator-->
                    <div class="app-sidebar-separator separator"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Heading-->

                <!--begin:Menu item Dashboards-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Default</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item Dashboards-->

                <!--begin:Menu item Master-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Master</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">User</span>
                            </a>
                        </div>
                    </div>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('permission.*') ? 'active' : '' }}" href="{{ route('permission.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Permission</span>
                            </a>
                        </div>
                    </div>
                     <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('menu.*') ? 'active' : '' }}" href="{{ route('menu.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Menu</span>
                            </a>
                        </div>
                                                <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('role*') || request()->routeIs('master.role*') ? 'active' : '' }}" href="{{ route('role.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Role</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item Master-->


                <!--begin:Menu item Inovasi (Parent)-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('inovasi.*') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-gift fs-2"></i>
                        </span>
                        <span class="menu-title">Inovasi</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion {{ request()->routeIs('inovasi.*') ? 'show' : '' }}">
                        <!--begin:Menu item Inovasi Global-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('inovasi.global') ? 'active' : '' }}" href="{{ route('inovasi.global') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Inovasi Global</span>
                            </a>
                        </div>
                        <!--end:Menu item Inovasi Global-->

                        <!--begin:Menu item Inovasi Kota-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('inovasi.kota') ? 'active' : '' }}" href="{{ route('inovasi.kota') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Inovasi Kota</span>
                            </a>
                        </div>
                        <!--end:Menu item Inovasi Kota-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item Inovasi (Parent)-->

                <!--begin:Menu item Help-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-briefcase fs-2"></i>
                        </span>
                        <span class="menu-title">Help</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs" target="_blank">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Si Cantik Surabaya</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item Help-->

            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Navs-->
</div>
