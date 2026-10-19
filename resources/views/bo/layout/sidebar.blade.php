@php
    $sidebarMenus = App\Support\Access::getSidebarMenus();
@endphp

<!-- Style Kustom -->
<style>
    .app-sidebar-menu-custom .menu-link.active {
        background-color: #3FAAB2 !important;
    }

    .app-sidebar-logo-minimize {
        display: none;
        height: 48px !important;
        width: auto;
        object-fit: contain;
    }

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
    [data-kt-app-sidebar-minimize="on"] .app-sidebar-toggle {
        display: none !important;
    }

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

    <!--begin::Header-->
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
                    <div class="app-sidebar-separator separator"></div>
                </div>
                <!--end::Heading-->

                <!--begin:Dashboard (Statis untuk semua user)-->
                <div class="menu-item">
                    <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboards</span>
                    </a>
                </div>
                <!--end:Dashboard-->

                <!--begin:Menu Dinamis dari Database m_menu-->
                @foreach($sidebarMenus as $menu)
                    @php
                        $hasChildren = $menu->children->isNotEmpty();
                        $cleanUrl    = trim($menu->url_menu ?? '', '/');
                        $menuUrl     = $cleanUrl ? url('/' . $cleanUrl) : '#';

                        // Cek status aktif menu parent & child
                        $isParentActive = false;
                        if ($hasChildren) {
                            foreach ($menu->children as $child) {
                                $childClean = trim($child->url_menu ?? '', '/');
                                if ($childClean && request()->is($childClean . '*')) {
                                    $isParentActive = true;
                                    break;
                                }
                            }
                        } else {
                            $isParentActive = $cleanUrl && request()->is($cleanUrl . '*');
                        }
                    @endphp

                    @if($hasChildren)
                        <!-- Parent Accordion Dropdown -->
                        <div data-kt-menu-trigger="click"
                            class="menu-item menu-accordion {{ $isParentActive ? 'here show' : '' }}">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="{{ $menu->icon ?: 'ki-outline ki-element-11' }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ $menu->nama_menu }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion {{ $isParentActive ? 'show' : '' }}">
                                @foreach($menu->children as $child)
                                    @php
                                        $childCleanUrl = trim($child->url_menu ?? '', '/');
                                        $childUrl      = $childCleanUrl ? url('/' . $childCleanUrl) : '#';
                                        $isChildActive = $childCleanUrl && request()->is($childCleanUrl . '*');
                                    @endphp
                                    <div class="menu-item">
                                        <a class="menu-link {{ $isChildActive ? 'active' : '' }}" href="{{ $childUrl }}">
                                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                            <span class="menu-title">{{ $child->nama_menu }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Menu Tunggal (Tanpa Sub-menu) -->
                        <div class="menu-item">
                            <a class="menu-link {{ $isParentActive ? 'active' : '' }}" href="{{ $menuUrl }}">
                                <span class="menu-icon">
                                    <i class="{{ $menu->icon ?: 'ki-outline ki-element-11' }} fs-2"></i>
                                </span>
                                <span class="menu-title">{{ $menu->nama_menu }}</span>
                            </a>
                        </div>
                    @endif
                @endforeach
                <!--end:Menu Dinamis-->

                <!--begin:Menu Help-->
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
                            <a class="menu-link" href="https://preview.keenthemes.com/html/metronic/docs" target="_blank">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Si Cantik Surabaya</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end:Menu Help-->

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

        if (isMinimized) {
            e.preventDefault();
            toggle.click();
        }
    });
});
</script>