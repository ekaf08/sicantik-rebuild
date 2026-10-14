@php
    use App\Support\Access;
    $canUser       = Access::can('/master/user');
    $canRole       = Access::can('/master/role');
    $canPermission = Access::can('/master/permission');
    $canMenu       = Access::can('/master/menu');
    $canDashPkk    = Access::can('dashboard-pkk');
    $canLapKeg     = Access::can('laporan-kegiatan');

    $showMaster = $canUser || $canRole || $canPermission || $canMenu;
@endphp

<!-- Style Kustom: Mengubah background menu .active (baik submenu maupun menu utama/root) menjadi #3FAAB2 -->
<style>
    /* Menu aktif */
    .app-sidebar-menu-custom .menu-link.active {
        background-color: #3FAAB2 !important;
    }

    /* Logo icon: default disembunyikan (saat sidebar lebar) */
    .app-sidebar-logo-minimize {
        display: none;
        height: 48px !important;
        width: auto;
        object-fit: contain;
    }

    /* ===== Saat sidebar mengecil ===== */
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-logo-default,
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-text-wrapper {
        display: none !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-logo-minimize {
        display: block;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-logo {
        cursor: pointer;
        margin: 0 !important;
        padding: 0 !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-header {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    /* Toggle disembunyikan (logo yang jadi tombolnya) */
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-toggle {
        display: none !important;
    }

    /* ===== Saat di-hover (melebar sementara): samakan dengan sidebar lebar ===== */
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-logo-default,
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-text-wrapper {
        display: block !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-logo-minimize {
        display: none !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-header {
        justify-content: space-between !important;
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-logo {
        margin: 0 auto !important;
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
    }
    [data-kt-app-sidebar-minimize="on"] .app-sidebar:hover .app-sidebar-toggle {
        display: flex !important;
        position: static !important;
    }
</style>

<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Header (Dibuat lebih ringkas tingginya) -->
    <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-4 pb-2 px-3" id="kt_app_sidebar_header">

        <!--begin::Logo & Teks-->
        <a href="{{ url('/dashboard') }}"
            class="app-sidebar-logo d-flex flex-column align-items-center text-center text-decoration-none mx-auto py-1">

            <!-- Logo penuh (saat sidebar lebar) -->
            <img alt="Logo" src="{{ asset('img/png/logo-sicantik-pkk.png') }}"
                class="h-25px mb-1 app-sidebar-logo-default" />

            <!-- Logo icon saja (saat sidebar mengecil) -->
            <img alt="Logo" src="{{ asset('img/png/logo-sicantik.png') }}"
                class="app-sidebar-logo-minimize" />

            <div class="app-sidebar-text-wrapper">
                <span class="fs-8 fw-bold text-dark theme-light-show d-block">Si Cantik Surabaya</span>
            </div>
        </a>
        <!--end::Logo & Teks-->

        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-sm btn-icon bg-light btn-color-gray-700 btn-active-color-primary rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-text-align-right rotate-180 fs-1"></i>
        </div>
        <!--end::Sidebar toggle-->

    </div>
    <!--end::Header-->

    <!--begin::Navs-->
    <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
        <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper hover-scroll-y my-2" data-kt-scroll="true"
            data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-wrappers="#kt_app_sidebar_navs"
            data-kt-scroll-offset="5px">

            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary app-sidebar-menu-custom">

                <!--begin::Heading-->
                <div class="menu-item mb-2">
                    <div class="menu-heading text-uppercase fs-7 fw-bold">Menu</div>
                    <!--begin::Separator-->
                    <div class="app-sidebar-separator separator"></div>
                    <!--end::Separator-->
                </div>
                <!--end::Heading-->

                <!--begin:Menu item Dashboard-->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                    </a>
                </div>
                <!--end:Menu item Dashboard-->

                <!--begin:Menu item Master-->
                @if($showMaster)
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('user*') || request()->routeIs('role*') || request()->routeIs('permission*') || request()->routeIs('menu*') || request()->routeIs('master.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-user-edit fs-2"></i>
                        </span>
                        <span class="menu-title">Master</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if($canUser)
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('user*') || request()->routeIs('master.user*') ? 'active' : '' }}"
                                href="{{ route('user.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">User</span>
                            </a>
                        </div>
                        @endif
                        @if($canRole)
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('role*') || request()->routeIs('master.role*') ? 'active' : '' }}"
                                href="{{ route('role.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Role</span>
                            </a>
                        </div>
                        @endif
                        @if($canPermission)
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('permission*') ? 'active' : '' }}"
                                href="{{ route('permission.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Permission</span>
                            </a>
                        </div>
                        @endif
                        @if($canMenu)
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('menu*') ? 'active' : '' }}"
                                href="{{ Route::has('menu.index') ? route('menu.index') : '#' }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Menu</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <!--end:Menu item Master-->

                <!--begin:Menu Laporan-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('laporan-kegiatan*') || request()->routeIs('laporan-tahunan*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-document fs-2"></i>
                        </span>
                        <span class="menu-title">Laporan</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        @if($canLapKeg)
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('laporan-kegiatan.index') ? 'active' : '' }}"
                                href="{{ route('laporan-kegiatan.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Laporan Kegiatan</span>
                            </a>
                        </div>
                        @endif
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('laporan-tahunan.index') ? 'active' : '' }}"
                                href="{{ route('laporan-tahunan.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Laporan Tahunan</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end:Menu item Laporan-->

                <!--begin:Menu item MPASI-->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('mpasi.*') ? 'active' : '' }}" href="{{ route('mpasi.index') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-heart fs-2"></i>
                        </span>
                        <span class="menu-title">Data MPASI</span>
                    </a>
                </div>
                <!--end:Menu item MPASI-->

                <!--begin:Menu item Inovasi-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('inovasi.*') ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-gift fs-2"></i>
                        </span>
                        <span class="menu-title">Inovasi</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion {{ request()->routeIs('inovasi.*') ? 'show' : '' }}">
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('inovasi.global') ? 'active' : '' }}"
                                href="{{ route('inovasi.global') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Inovasi Global</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('inovasi.kota') ? 'active' : '' }}"
                                href="{{ route('inovasi.kota') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Inovasi Kota</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end:Menu item Inovasi-->

                <!--begin:Menu item Penghargaan-->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('penghargaan.*') ? 'active' : '' }}" href="{{ Route::has('penghargaan.index') ? route('penghargaan.index') : '#' }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-medal-star fs-2"></i>
                        </span>
                        <span class="menu-title">Penghargaan</span>
                    </a>
                </div>
                <!--end:Menu item Penghargaan-->
                <!--begin:Menu item Kebijakan SK-->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('kebijakan.*') ? 'active' : '' }}" href="{{ route('kebijakan.index') }}">
                        <span class="menu-icon">
                        <i class="ki-solid ki-shield-tick fs-2"></i>
                    </span>
                    <span class="menu-title">Kebijakan</span>
                    </a>
                </div>
                <!--end:Menu item Kebijakan SK-->

                <!--begin:Menu item Help-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-briefcase fs-2"></i>
                        </span>
                        <span class="menu-title">Help</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs"
                                target="_blank">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Si Cantik Surabaya</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end:Menu item Help-->

            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Navs-->
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const logo = document.querySelector('.app-sidebar-logo');
    const toggle = document.getElementById('kt_app_sidebar_toggle');

    if (!logo || !toggle) return;

    logo.addEventListener('click', function (e) {
        const isMinimized = document.body.getAttribute('data-kt-app-sidebar-minimize') === 'on';

        // Saat mengecil: logo berfungsi sebagai tombol untuk melebarkan sidebar
        if (isMinimized) {
            e.preventDefault();
            toggle.click();
        }
        // Saat melebar: logo tetap link ke dashboard seperti biasa
    });
});
</script>
