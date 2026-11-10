@extends('bo.layout.app')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <style>
            .banner-inovasi-kota {
                background: linear-gradient(100deg, #0b5e57 0%, #0d6e66 34%, #2f8f83 46%, #7fbfb0 56%, #cfe6d6 66%, #f6efd9 76%, #fbf3e1 100%) !important;
                position: relative;
                overflow: hidden;
                border-radius: 1.25rem !important;
                border: none !important;
                box-shadow: 0 10px 25px -5px rgba(11, 94, 87, 0.35);
                min-height: 280px;
                display: flex;
                align-items: center;
            }

            .banner-inovasi-kota::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1.2px, transparent 1.2px);
                background-size: 22px 22px;
                -webkit-mask-image: linear-gradient(90deg, #000 0%, #000 30%, transparent 58%);
                mask-image: linear-gradient(90deg, #000 0%, #000 30%, transparent 58%);
                pointer-events: none;
                z-index: 1;
            }

            .banner-siluet-kota {
                position: absolute;
                right: 0;
                bottom: 0;
                height: 100%;
                width: auto;
                aspect-ratio: 350 / 210;
                pointer-events: none;
                z-index: 1;
            }

            @media (max-width: 991px) {
                .banner-siluet-kota {
                    opacity: 0.3;
                }
            }

            .form-select-custom {
                background-color: #ffffff !important;
                border: 1.5px solid #e2e8f0 !important;
                border-radius: 0.85rem !important;
                padding: 0.75rem 1.15rem !important;
                font-size: 0.9rem !important;
                font-weight: 600 !important;
                color: #0f172a !important;
                transition: all 0.2s ease-in-out;
            }

            .form-select-custom:focus {
                border-color: #0d9488 !important;
                box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15) !important;
                outline: none;
            }

            .label-filter-custom {
                font-size: 0.85rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 0.5rem;
                display: block;
            }

            .empty-detail-clean {
                max-width: 420px;
                margin: 0 auto;
                padding: 1rem;
                text-align: center;
            }
        </style>

        <div class="d-flex flex-column gap-5 w-100 py-2">

            <div class="card banner-inovasi-kota mb-2">
                <svg class="banner-siluet-kota" viewBox="50 0 350 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                    <defs>
                        <linearGradient id="fadeKiriKota" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0" stop-color="#000"/>
                            <stop offset="0.3" stop-color="#fff"/>
                        </linearGradient>
                        <mask id="maskKiriKota" maskUnits="userSpaceOnUse" x="50" y="0" width="350" height="210">
                            <rect x="50" y="0" width="350" height="210" fill="url(#fadeKiriKota)"/>
                        </mask>
                        <radialGradient id="gGlowMatahari" cx="352" cy="46" r="110" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#ffe3a0" stop-opacity="0.7"/>
                            <stop offset="0.45" stop-color="#ffe9b8" stop-opacity="0.3"/>
                            <stop offset="1" stop-color="#ffe9b8" stop-opacity="0"/>
                        </radialGradient>
                        <radialGradient id="gMatahari" cx="0.4" cy="0.4" r="0.7">
                            <stop offset="0" stop-color="#fffbe6"/>
                            <stop offset="1" stop-color="#f2b740"/>
                        </radialGradient>
                        <radialGradient id="gAwan" cx="0.5" cy="0.5" r="0.5">
                            <stop offset="0" stop-color="#ffffff" stop-opacity="0.55"/>
                            <stop offset="1" stop-color="#ffffff" stop-opacity="0"/>
                        </radialGradient>
                    </defs>

                    <circle cx="352" cy="46" r="110" fill="url(#gGlowMatahari)"/>
                    <ellipse cx="236" cy="46" rx="48" ry="12" fill="url(#gAwan)"/>
                    <ellipse cx="296" cy="74" rx="40" ry="10" fill="url(#gAwan)"/>
                    <circle cx="352" cy="46" r="21" fill="url(#gMatahari)"/>
                    <g fill="none" stroke="#0d6e66" stroke-width="1.5" stroke-linecap="round" opacity="0.75">
                        <path d="M262 30 q4 -5 8 0 q4 -5 8 0"/>
                        <path d="M286 44 q3 -4 6 0 q3 -4 6 0"/>
                    </g>

                    <rect x="272" y="162" width="128" height="30" fill="#bfe0d8" opacity="0.9"/>
                    <g stroke="#14867c" stroke-width="1" stroke-linecap="round" opacity="0.3">
                        <line x1="285" y1="172" x2="305" y2="172"/>
                        <line x1="296" y1="185" x2="312" y2="185"/>
                    </g>
                    <g stroke="#f2b740" stroke-width="1.6" stroke-linecap="round" opacity="0.75">
                        <line x1="340" y1="166" x2="364" y2="166"/>
                        <line x1="344" y1="172" x2="360" y2="172"/>
                        <line x1="334" y1="178" x2="370" y2="178"/>
                        <line x1="346" y1="184" x2="358" y2="184"/>
                    </g>

                    <g mask="url(#maskKiriKota)">
                        <path d="M50 192 V184 H62 V178 H76 V186 H90 V174 H100 V180 H110 V158 H124 V146 H138 V162 H150 V150 H164 V166 H236 V152 H248 V140 H262 V158 H272 V192Z" fill="#0d6e66" opacity="0.14"/>
                        <path d="M110 192 V172 H128 V162 H142 V176 H160 V168 H174 V192Z" fill="#0d6e66" opacity="0.26"/>
                        <path d="M226 192 V170 H240 V158 H254 V172 H272 V192Z" fill="#0d6e66" opacity="0.26"/>
                    </g>

                    <g fill="#14867c" opacity="0.5">
                        <rect x="298" y="104" width="4" height="56"/>
                        <rect x="370" y="104" width="4" height="56"/>
                        <rect x="262" y="156" width="138" height="3"/>
                        <rect x="290" y="159" width="2" height="25"/>
                        <rect x="316" y="159" width="2" height="25"/>
                        <rect x="350" y="159" width="2" height="25"/>
                        <rect x="388" y="159" width="2" height="25"/>
                    </g>
                    <g stroke="#14867c" stroke-width="0.8" opacity="0.5">
                        <path d="M300 108 L268 156 M300 108 L278 156 M300 108 L288 156 M300 108 L312 156 M300 108 L322 156 M300 108 L332 156"/>
                        <path d="M372 108 L342 156 M372 108 L352 156 M372 108 L362 156 M372 108 L384 156 M372 108 L394 156"/>
                    </g>

                    <g mask="url(#maskKiriKota)">
                        <path d="M50 210 C150 196 240 200 320 197 C360 195 380 198 400 194 L400 210Z" fill="#14867c"/>
                        <path d="M50 210 C200 205 300 207 400 202 L400 210Z" fill="#0b5e57"/>
                    </g>

                    <ellipse cx="200" cy="194" rx="32" ry="3" fill="#0b5e57" opacity="0.28"/>
                    <g>
                        <rect x="174" y="188" width="52" height="5" fill="#0a554f"/>
                        <rect x="182" y="180" width="36" height="8" fill="#0d6e66"/>
                        <polygon points="190,180 193,72 207,72 210,180" fill="#0d6e66"/>
                        <polygon points="200,180 200,72 207,72 210,180" fill="#0a554f"/>
                        <polygon points="192,72 188,62 212,62 208,72" fill="#0d6e66"/>
                        <polygon points="200,62 212,62 208,72 200,72" fill="#0a554f"/>
                        <polygon points="198,62 199,50 201,50 202,62" fill="#f2b740"/>
                        <g stroke="#fbf3e1" stroke-width="0.8" opacity="0.6">
                            <line x1="195" y1="76" x2="193" y2="178"/>
                            <line x1="200" y1="76" x2="200" y2="178"/>
                            <line x1="205" y1="76" x2="207" y2="178"/>
                        </g>
                    </g>

                    <g>
                        <rect x="148" y="170" width="4" height="24" fill="#0a554f"/>
                        <circle cx="150" cy="163" r="12" fill="#14867c"/>
                        <circle cx="141" cy="170" r="9" fill="#2dd4bf"/>
                        <circle cx="159" cy="170" r="9" fill="#0d6e66"/>
                        <rect x="251" y="174" width="3" height="20" fill="#0a554f"/>
                        <circle cx="252" cy="168" r="10" fill="#14867c"/>
                        <circle cx="245" cy="174" r="7" fill="#2dd4bf"/>
                        <circle cx="259" cy="174" r="7" fill="#0d6e66"/>
                    </g>

                    <ellipse cx="322" cy="203" rx="46" ry="3.5" fill="#0b5e57" opacity="0.28"/>
                    <g>
                        <rect x="337" y="126" width="8" height="22" fill="#b4553a"/>
                        <rect x="296" y="153" width="52" height="45" fill="#fffaf0"/>
                        <rect x="322" y="153" width="26" height="45" fill="#f1e4c3" opacity="0.7"/>
                        <polygon points="288,153 322,117 356,153" fill="#e8795a"/>
                        <polygon points="322,117 356,153 322,153" fill="#d4654a"/>
                        <rect x="288" y="152" width="68" height="3" fill="#b4553a"/>
                        <circle cx="322" cy="139" r="6" fill="#0d9488" stroke="#fffaf0" stroke-width="1.2"/>
                        <path d="M322 142 c-1.5 -2.5 -5 -0.5 -2.5 2 l2.5 2.5 l2.5 -2.5 c2.5 -2.5 -1 -4.5 -2.5 -2z" fill="#fffaf0"/>
                        <rect x="302" y="162" width="11" height="11" fill="#0d6e66" stroke="#fffaf0" stroke-width="0.8"/>
                        <rect x="331" y="162" width="11" height="11" fill="#0d6e66" stroke="#fffaf0" stroke-width="0.8"/>
                        <g stroke="#fffaf0" stroke-width="0.8">
                            <line x1="307.5" y1="162" x2="307.5" y2="173"/>
                            <line x1="302" y1="167.5" x2="313" y2="167.5"/>
                            <line x1="336.5" y1="162" x2="336.5" y2="173"/>
                            <line x1="331" y1="167.5" x2="342" y2="167.5"/>
                        </g>
                        <rect x="316" y="172" width="13" height="26" fill="#e9b44c"/>
                        <circle cx="326" cy="186" r="1" fill="#fffaf0"/>
                        <path d="M316 198 L311 206 L334 206 L329 198Z" fill="#cfe8e3"/>
                        <g fill="#5fc7b5">
                            <rect x="278" y="184" width="2.5" height="14"/>
                            <rect x="283" y="184" width="2.5" height="14"/>
                            <rect x="288" y="184" width="2.5" height="14"/>
                            <rect x="354" y="184" width="2.5" height="14"/>
                            <rect x="359" y="184" width="2.5" height="14"/>
                            <rect x="364" y="184" width="2.5" height="14"/>
                            <rect x="276" y="188" width="17" height="2"/>
                            <rect x="352" y="188" width="17" height="2"/>
                        </g>
                        <circle cx="300" cy="197" r="2" fill="#f2b740"/>
                        <circle cx="306" cy="198" r="2" fill="#f4a3bd"/>
                        <circle cx="338" cy="198" r="2" fill="#f4a3bd"/>
                        <circle cx="344" cy="197" r="2" fill="#f2b740"/>
                    </g>

                    <g>
                        <circle cx="266" cy="198" r="7" fill="#14867c"/>
                        <circle cx="260" cy="200" r="5" fill="#2dd4bf"/>
                        <circle cx="263" cy="194" r="1.5" fill="#f2b740"/>
                        <circle cx="270" cy="197" r="1.5" fill="#f4a3bd"/>
                        <path d="M385 197 L397 197 L395 205 L387 205Z" fill="#e8795a"/>
                        <path d="M391 197 C383 192 384 184 389 182 C392 188 392 193 391 197Z" fill="#2dd4bf"/>
                        <path d="M391 197 C399 192 398 184 393 182 C390 188 390 193 391 197Z" fill="#14867c"/>
                    </g>
                </svg>

                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center position-relative w-100" style="z-index: 2;">
                    <h2 class="fw-bolder text-white mb-2 text-uppercase tracking-wide" style="font-size: 2.1rem; letter-spacing: 0.5px;">
                        INOVASI KOTA
                    </h2>
                    <span id="banner-subtitle-inovasi" class="fw-semibold" style="color: #e6fffa; font-size: 1.05rem;">
                        Berikut adalah Inovasi PKK yang telah di Inputkan 
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-5">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-gray-700 fs-6">Pilih Pokja</label>
                            <select id="select-filter-pokja" class="form-select form-select-solid fw-semibold" onchange="handlePokjaChange()">
                                <option value="semua" selected>Semua</option>
                                <option value="sekretaris">Sekretaris</option>
                                <option value="pokja 1">Pokja 1</option>
                                <option value="pokja 2">Pokja 2</option>
                                <option value="pokja 3">Pokja 3</option>
                                <option value="pokja 4">Pokja 4</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-gray-700 fs-6">Pilih Inovasi</label>
                            <select id="select-filter-inovasi" class="form-select form-select-solid fw-semibold" onchange="handleInovasiChange()">
                                <option value="" selected disabled>Pilih salah satu inovasi...</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-5 px-4">

                    <div id="state-placeholder-empty" class="empty-detail-clean">
                        <p class="text-muted fw-semibold mb-0" style="font-size: 0.95rem;">
                            Silakan pilih inovasi untuk menampilkan detail.
                        </p>
                    </div>

                    <div id="state-detail-content" class="d-none">

                        {{-- Sekretaris --}}
                        <div id="content-sicantik" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.sicantik')
                        </div>

                        {{-- Pokja 1 --}}
                        <div id="content-elearning-puspaga" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.elearning-puspaga')
                        </div>
                        <div id="content-kemanggi" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.kemanggi')
                        </div>

                        {{-- Pokja 2 --}}
                        <div id="content-selantang" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.selantang')
                        </div>
                        <div id="content-soth" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.soth')
                        </div>

                        {{-- Pokja 3 --}}
                        <div id="content-makan-ketan" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.makan-ketan')
                        </div>
                        <div id="content-pisang-danor" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.pisang-danor')
                        </div>
                        <div id="content-pmt" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.pmt')
                        </div>

                        {{-- Pokja 4 --}}
                        <div id="content-pendampingan-bumil" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.pendampingan-bumil')
                        </div>
                        <div id="content-kampung-asi" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.kampung-asi')
                        </div>
                        <div id="content-surabaya-emas" class="inovasi-item-view d-none">
                            @includeIf('bo.pages.inovasi.inovasikota.surabaya-emas')
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('assets/js/custom/pages/inovasi/inovasi-kota.js') }}?v={{ time() }}"></script>
@endsection
