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

        <style>
            /* ===== Banner sub menu Inovasi Kota (berganti otomatis sesuai pilihan) ===== */
            .kb {
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                min-height: 210px;
                padding: 2rem 2.5rem;
                margin-bottom: .5rem;
                border-radius: 1rem;
                background: var(--kb-bg);
            }
            .kb-text { position: relative; z-index: 2; max-width: 52%; }
            .kb-label {
                display: block; margin-bottom: .5rem;
                font-size: .72rem; font-weight: 700; letter-spacing: .14em;
                text-transform: uppercase; color: var(--kb-label);
            }
            .kb-title { margin: 0 0 .4rem; font-size: 2rem; font-weight: 800; line-height: 1.15; color: var(--kb-title); }
            .kb-desc { margin: 0; font-size: .95rem; font-weight: 500; color: var(--kb-desc); }
            .kb-art {
                position: absolute; right: 0; bottom: 0;
                height: 100%; width: auto; max-width: 58%;
                z-index: 1; pointer-events: none;
            }
            @media (max-width: 767.98px) {
                .kb { padding: 1.5rem; min-height: 170px; }
                .kb-title { font-size: 1.5rem; }
                .kb-text { max-width: 100%; }
                .kb-art { opacity: .3; max-width: 80%; }
            }

            /* Warna tiap sub menu: bg = latar, blob/dot = bentuk dekor, lalu warna teks */
            .kb--elearning-puspaga  { --kb-bg:#eef0f8; --kb-blob:#dee2f2; --kb-dot:#d2d8ee; --kb-label:#5b66b8; --kb-title:#2a2f5e; --kb-desc:#5a5f8a; }
            .kb--pendampingan-bumil { --kb-bg:#fbede8; --kb-blob:#f4d9d2; --kb-dot:#efcbc2; --kb-label:#d98080; --kb-title:#5e2e2e; --kb-desc:#8a5a5a; }
            .kb--kampung-asi        { --kb-bg:#faefe2; --kb-blob:#f2e2c8; --kb-dot:#edd6b4; --kb-label:#e07a5f; --kb-title:#5c3a1e; --kb-desc:#7d5f45; }
            .kb--kemanggi          { --kb-bg:#efecf7; --kb-blob:#e1dbf1; --kb-dot:#d6ceea; --kb-label:#8070b8; --kb-title:#3b2f66; --kb-desc:#5f5585; }
            .kb--makan-ketan        { --kb-bg:#ebf3e3; --kb-blob:#dbe8cf; --kb-dot:#d0e0c0; --kb-label:#6e9a4a; --kb-title:#2c4a1e; --kb-desc:#4f6b3c; }
            .kb--pisang-danor       { --kb-bg:#e8f2ee; --kb-blob:#d2e4de; --kb-dot:#c4dbd3; --kb-label:#2a9d8f; --kb-title:#1f4a44; --kb-desc:#4a7068; }
            .kb--pmt                { --kb-bg:#fbf1de; --kb-blob:#f3e3c0; --kb-dot:#edd8aa; --kb-label:#e8a23b; --kb-title:#5a3b0e; --kb-desc:#7d6232; }
            .kb--selantang          { --kb-bg:#eaf1f5; --kb-blob:#d6e4ec; --kb-dot:#c8dae5; --kb-label:#5b8db0; --kb-title:#24394a; --kb-desc:#4a6070; }
            .kb--soth               { --kb-bg:#f7ede7; --kb-blob:#eedace; --kb-dot:#e7ccbc; --kb-label:#d2603f; --kb-title:#5a2a1a; --kb-desc:#7d5645; }
            .kb--surabaya-emas      { --kb-bg:#edf0f8; --kb-blob:#dde2f1; --kb-dot:#d0d7ec; --kb-label:#2f4a9a; --kb-title:#1e2a5a; --kb-desc:#4a5580; }
        </style>

        <div class="d-flex flex-column gap-5 w-100 py-2">

<<<<<<< Updated upstream
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
=======
            <!-- 1. Header Banner Inovasi Kota -->
            <div id="banner-inovasi-default" class="card banner-inovasi-kota mb-2">
                <svg class="banner-siluet-kota" viewBox="0 0 450 180" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M280 180 L310 40 L315 40 L345 180 Z" fill="#2dd4bf" />
                    <path d="M312 15 L314 15 L314 40 L312 40 Z" fill="#2dd4bf" />
                    <path d="M340 180 L340 100 L355 100 L355 180 Z" fill="#14b8a6" />
                    <path d="M358 180 L358 80 L378 80 L378 180 Z" fill="#0d9488" />
                    <path d="M382 180 L382 110 L400 110 L400 180 Z" fill="#14b8a6" />
                    <path d="M360 180 C390 110 420 90 460 80 L460 180 Z" fill="#0f766e" />
                    <path d="M390 180 C410 130 435 110 460 105 L460 180 Z" fill="#115e59" />
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
=======
                        <!-- Banner sub menu: teks & ilustrasi berganti otomatis (lihat script di bawah) -->
                        <svg width="0" height="0" style="position:absolute" aria-hidden="true">
                            <symbol id="kb-base" viewBox="0 0 440 210">
                                <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" style="fill:var(--kb-blob)"/>
                                <circle cx="318" cy="22" r="46" style="fill:var(--kb-dot)" opacity=".6"/>
                                <circle cx="46" cy="176" r="14" style="fill:var(--kb-dot)"/>
                                <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>
                            </symbol>
                        </svg>

                        <div id="kb-banner" class="kb d-none">
                            <div class="kb-text">
                                <span class="kb-label">Inovasi Kota</span>
                                <h2 id="kb-title" class="kb-title"></h2>
                                <p id="kb-desc" class="kb-desc"></p>
                            </div>

                            <!-- 1. E-learning Puspaga PKK -->
                            <svg class="kb-art d-none" data-art="elearning-puspaga" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <rect x="100" y="180" width="300" height="6" rx="3" fill="#c9cde6"/>
                                <rect x="112" y="168" width="64" height="12" rx="2" fill="#5b66b8"/>
                                <rect x="116" y="156" width="56" height="12" rx="2" fill="#e9b840"/>
                                <rect x="120" y="144" width="48" height="12" rx="2" fill="#e07a5f"/>
                                <rect x="190" y="68" width="170" height="100" rx="8" fill="#2a2f5e"/>
                                <rect x="198" y="76" width="106" height="84" rx="4" fill="#e07a5f"/>
                                <polygon points="236,100 236,136 266,118" fill="#fff"/>
                                <rect x="312" y="80" width="38" height="8" rx="3" fill="#cbd0e8"/>
                                <rect x="312" y="96" width="38" height="8" rx="3" fill="#cbd0e8"/>
                                <rect x="312" y="112" width="38" height="8" rx="3" fill="#cbd0e8"/>
                                <circle cx="331" cy="140" r="5" fill="#e9b840"/>
                                <rect x="265" y="168" width="20" height="12" fill="#2a2f5e"/>
                                <path d="M275 38 L330 54 L275 70 L220 54 Z" fill="#2a2f5e"/>
                                <path d="M246 61 V72 C258 80 292 80 304 72 V61 L275 70 Z" fill="#3b4180"/>
                                <path d="M330 54 V72" stroke="#e9b840" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="330" cy="74" r="3.5" fill="#e9b840"/>
                                <rect x="368" y="50" width="44" height="26" rx="6" fill="#fff"/>
                                <rect x="376" y="58" width="28" height="4" rx="2" fill="#5b66b8"/>
                                <rect x="376" y="66" width="18" height="4" rx="2" fill="#cbd0e8"/>
                                <path d="M375 180 L395 180 L392 160 L378 160 Z" fill="#e07a5f"/>
                                <ellipse cx="385" cy="140" rx="7" ry="18" fill="#5b66b8"/>
                                <ellipse cx="372" cy="148" rx="6" ry="14" transform="rotate(-25 372 148)" fill="#e9b840"/>
                                <ellipse cx="398" cy="148" rx="6" ry="14" transform="rotate(25 398 148)" fill="#e9b840"/>
                            </svg>

                            <!-- 2. Pendampingan Ibu Hamil -->
                            <svg class="kb-art d-none" data-art="pendampingan-bumil" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <g fill="#e9b27a"><ellipse cx="146" cy="160" rx="5" ry="14" transform="rotate(-20 146 160)"/><ellipse cx="158" cy="162" rx="5" ry="14" transform="rotate(25 158 162)"/></g>
                                <path d="M152 190 L152 160" stroke="#c98a55" stroke-width="2.5" stroke-linecap="round"/>
                                <g fill="#7fa58f"><ellipse cx="402" cy="150" rx="5" ry="15" transform="rotate(-20 402 150)"/><ellipse cx="414" cy="152" rx="5" ry="15" transform="rotate(25 414 152)"/></g>
                                <path d="M408 190 L408 150" stroke="#5f8a74" stroke-width="2.5" stroke-linecap="round"/>
                                <rect x="286" y="176" width="8" height="12" rx="3" fill="#f0c3a0"/>
                                <rect x="306" y="176" width="8" height="12" rx="3" fill="#f0c3a0"/>
                                <ellipse cx="290" cy="189" rx="8" ry="3" fill="#b5736b"/>
                                <ellipse cx="310" cy="189" rx="8" ry="3" fill="#b5736b"/>
                                <path d="M280 96 C276 124 270 152 262 178 L338 178 C330 152 326 124 322 96 Z" fill="#d98585"/>
                                <path d="M322 104 C356 114 356 154 328 162 Z" fill="#cf7676"/>
                                <circle cx="301" cy="76" r="14" fill="#f0c3a0"/>
                                <path d="M286 74 C286 58 316 58 316 74 C310 67 292 67 286 74 Z" fill="#3b2a22"/>
                                <circle cx="301" cy="57" r="8" fill="#3b2a22"/>
                                <path d="M288 108 L322 134" stroke="#f0c3a0" stroke-width="7" stroke-linecap="round"/>
                                <rect x="192" y="127" width="20" height="30" rx="5" fill="#6e9988"/>
                                <rect x="194" y="157" width="7" height="28" rx="3" fill="#3d4a5c"/>
                                <rect x="204" y="157" width="7" height="28" rx="3" fill="#3d4a5c"/>
                                <circle cx="202" cy="116" r="10" fill="#f0c3a0"/>
                                <path d="M192 114 C192 104 212 104 212 114 C208 110 196 110 192 114 Z" fill="#3b2a22"/>
                                <path d="M211 136 L262 146" stroke="#f0c3a0" stroke-width="6" stroke-linecap="round"/>
                                <path d="M0 0 C-6 -8 -18 -2 0 12 C18 -2 6 -8 0 0Z" transform="translate(356 80) scale(.9)" fill="#f0b66a"/>
                                <path d="M0 0 C-6 -8 -18 -2 0 12 C18 -2 6 -8 0 0Z" transform="translate(378 106) scale(.6)" fill="#e8a0a0"/>
                            </svg>

                            <!-- 3. Kampung ASI: gizi seimbang -->
                            <svg class="kb-art d-none" data-art="kampung-asi" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <rect x="120" y="178" width="310" height="9" rx="4.5" fill="#d9c09a"/>
                                <path d="M148 150 H224 C224 172 208 180 186 180 C164 180 148 172 148 150 Z" fill="#f0cd8e"/>
                                <ellipse cx="186" cy="148" rx="38" ry="13" fill="#fff"/>
                                <rect x="246" y="150" width="12" height="28" rx="3" fill="#7fa58f"/>
                                <circle cx="252" cy="134" r="15" fill="#6e9988"/>
                                <circle cx="238" cy="144" r="11" fill="#7fa58f"/>
                                <circle cx="266" cy="144" r="11" fill="#7fa58f"/>
                                <circle cx="308" cy="152" r="25" fill="#e07a5f"/>
                                <path d="M308 128 C308 122 310 118 312 114" stroke="#7b563c" stroke-width="3" stroke-linecap="round"/>
                                <ellipse cx="320" cy="120" rx="10" ry="5" transform="rotate(-25 320 120)" fill="#7fa58f"/>
                                <rect x="350" y="132" width="36" height="46" rx="5" fill="#e3ecf3"/>
                                <rect x="352" y="146" width="32" height="30" rx="3" fill="#fff"/>
                                <path d="M372 124 L380 106" stroke="#e07a5f" stroke-width="4" stroke-linecap="round"/>
                                <ellipse cx="410" cy="170" rx="13" ry="9" fill="#fff"/>
                                <circle cx="410" cy="170" r="5" fill="#f2c14e"/>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M128 178 L128 150"/><path d="M128 164 L119 154"/><path d="M128 158 L137 148"/></g>
                            </svg>

                            <!-- 4. Kemangi -->
                            <svg class="kb-art d-none" data-art="kemanggi" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <rect x="232" y="124" width="10" height="24" rx="4" fill="#8070b8"/>
                                <rect x="240" y="121" width="22" height="34" rx="6" fill="#f2a65a"/>
                                <rect x="242" y="155" width="7" height="30" rx="3" fill="#4a5470"/>
                                <rect x="253" y="155" width="7" height="30" rx="3" fill="#4a5470"/>
                                <circle cx="251" cy="108" r="11" fill="#f1c9a0"/>
                                <path d="M240 106 C240 95 262 95 262 106 C258 101 244 101 240 106 Z" fill="#3b2a22"/>
                                <path d="M262 130 L292 114" stroke="#f1c9a0" stroke-width="6" stroke-linecap="round"/>
                                <path d="M342 92 C334 112 336 136 340 150 L362 150 C366 136 366 112 358 92 Z" fill="#8a5a3c"/>
                                <rect x="338" y="108" width="24" height="44" rx="8" fill="#8070b8"/>
                                <rect x="341" y="152" width="8" height="34" rx="3" fill="#3b3f66"/>
                                <rect x="352" y="152" width="8" height="34" rx="3" fill="#3b3f66"/>
                                <circle cx="350" cy="94" r="12" fill="#f1c9a0"/>
                                <path d="M338 92 C338 80 362 80 362 92 C356 86 344 86 338 92 Z" fill="#8a5a3c"/>
                                <path d="M338 130 L314 136" stroke="#f1c9a0" stroke-width="6" stroke-linecap="round"/>
                                <rect x="284" y="50" width="66" height="38" rx="10" fill="#fff"/>
                                <path d="M298 88 L292 102 L314 88 Z" fill="#fff"/>
                                <rect x="296" y="62" width="40" height="5" rx="2.5" fill="#8070b8"/>
                                <rect x="296" y="73" width="26" height="5" rx="2.5" fill="#d6cee8"/>
                                <circle cx="338" cy="76" r="4" fill="#7fb8a8"/>
                                <g stroke="#7fb8a8" stroke-width="2.5" stroke-linecap="round"><path d="M404 188 L404 158"/><path d="M404 174 L395 164"/><path d="M404 168 L413 158"/></g>
                            </svg>

                            <!-- 5. Makan Ketan -->
                            <svg class="kb-art d-none" data-art="makan-ketan" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <circle cx="96" cy="44" r="17" fill="#f2c14e"/>
                                <g stroke="#f2c14e" stroke-width="3" stroke-linecap="round">
                                    <line x1="96" y1="16" x2="96" y2="22"/><line x1="96" y1="66" x2="96" y2="72"/>
                                    <line x1="68" y1="44" x2="74" y2="44"/><line x1="118" y1="44" x2="124" y2="44"/>
                                </g>
                                <path d="M72 162 L108 162 L102 190 L78 190 Z" fill="#c9703f"/>
                                <rect x="70" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
                                <line x1="90" y1="158" x2="90" y2="104" stroke="#5a8a3c" stroke-width="4" stroke-linecap="round"/>
                                <ellipse cx="78" cy="122" rx="13" ry="6" transform="rotate(-30 78 122)" fill="#6fa047"/>
                                <ellipse cx="102" cy="116" rx="13" ry="6" transform="rotate(30 102 116)" fill="#6fa047"/>
                                <ellipse cx="80" cy="142" rx="13" ry="6" transform="rotate(-25 80 142)" fill="#5a8a3c"/>
                                <ellipse cx="101" cy="138" rx="13" ry="6" transform="rotate(25 101 138)" fill="#5a8a3c"/>
                                <ellipse cx="72" cy="136" rx="4" ry="10" transform="rotate(12 72 136)" fill="#d9452f"/>
                                <ellipse cx="110" cy="130" rx="4" ry="10" transform="rotate(-12 110 130)" fill="#d9452f"/>
                                <path d="M132 162 L168 162 L162 190 L138 190 Z" fill="#c9703f"/>
                                <rect x="130" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
                                <line x1="150" y1="158" x2="150" y2="108" stroke="#5a8a3c" stroke-width="4" stroke-linecap="round"/>
                                <ellipse cx="136" cy="124" rx="14" ry="6" transform="rotate(-30 136 124)" fill="#6fa047"/>
                                <ellipse cx="164" cy="118" rx="14" ry="6" transform="rotate(30 164 118)" fill="#6fa047"/>
                                <ellipse cx="138" cy="144" rx="14" ry="6" transform="rotate(-25 138 144)" fill="#5a8a3c"/>
                                <ellipse cx="162" cy="140" rx="14" ry="6" transform="rotate(25 162 140)" fill="#5a8a3c"/>
                                <ellipse cx="141" cy="134" rx="6" ry="11" fill="#7b4a9e"/>
                                <ellipse cx="160" cy="130" rx="6" ry="11" fill="#7b4a9e"/>
                                <path d="M192 162 L228 162 L222 190 L198 190 Z" fill="#c9703f"/>
                                <rect x="190" y="158" width="40" height="7" rx="3" fill="#b05f33"/>
                                <ellipse cx="200" cy="144" rx="6" ry="17" transform="rotate(-28 200 144)" fill="#5a8a3c"/>
                                <ellipse cx="220" cy="144" rx="6" ry="17" transform="rotate(28 220 144)" fill="#5a8a3c"/>
                                <ellipse cx="210" cy="140" rx="7" ry="19" fill="#7fb356"/>
                                <rect x="322" y="162" width="8" height="26" rx="3" fill="#d99a73"/>
                                <rect x="336" y="162" width="8" height="26" rx="3" fill="#d99a73"/>
                                <ellipse cx="326" cy="189" rx="7" ry="3" fill="#3b2a22"/>
                                <ellipse cx="340" cy="189" rx="7" ry="3" fill="#3b2a22"/>
                                <path d="M313 100 L353 100 L364 166 L302 166 Z" fill="#6b8f4e"/>
                                <path d="M313 100 L353 100 L356 128 L310 128 Z" fill="#f2a65a"/>
                                <circle cx="333" cy="82" r="15" fill="#f1c9a0"/>
                                <path d="M318 80 C318 64 348 64 348 80 C342 72 324 72 318 80 Z" fill="#3b2a22"/>
                                <circle cx="333" cy="63" r="7" fill="#3b2a22"/>
                                <line x1="316" y1="110" x2="282" y2="122" stroke="#f1c9a0" stroke-width="7" stroke-linecap="round"/>
                                <rect x="258" y="116" width="26" height="19" rx="4" fill="#4f7fa8"/>
                                <path d="M258 122 L238 108" stroke="#4f7fa8" stroke-width="5" stroke-linecap="round"/>
                                <g fill="#8cc7e8"><circle cx="234" cy="118" r="2.6"/><circle cx="231" cy="130" r="2.6"/><circle cx="236" cy="140" r="2.6"/></g>
                                <circle cx="388" cy="162" r="9" fill="#d9452f"/>
                                <circle cx="404" cy="164" r="8" fill="#7fb356"/>
                                <circle cx="396" cy="156" r="7" fill="#e9a23b"/>
                                <path d="M374 168 L418 168 L412 192 L380 192 Z" fill="#c89b5e"/>
                            </svg>

                            <!-- 6. Pisang Danor -->
                            <svg class="kb-art d-none" data-art="pisang-danor" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <path d="M220 114 L274 114 L268 186 L226 186 Z" fill="#2a9d8f"/>
                                <rect x="214" y="102" width="66" height="13" rx="5" fill="#1f6f66"/>
                                <rect x="239" y="93" width="16" height="9" rx="3" fill="#1f6f66"/>
                                <path d="M247 134 C260 138 262 156 247 166 C234 156 236 140 247 134 Z" fill="#fff"/>
                                <path d="M300 114 L358 114 L352 186 L306 186 Z" fill="#e8a23b"/>
                                <rect x="294" y="102" width="70" height="13" rx="5" fill="#c98a1f"/>
                                <rect x="320" y="93" width="18" height="9" rx="3" fill="#c98a1f"/>
                                <rect x="324" y="130" width="10" height="9" rx="2" fill="#fff"/>
                                <rect x="319" y="139" width="20" height="28" rx="6" fill="#fff"/>
                                <path d="M382 68 C382 100 410 112 434 100 C412 102 394 90 394 66 Z" fill="#f2c14e"/>
                                <path d="M388 64 L388 56" stroke="#b8891a" stroke-width="3" stroke-linecap="round"/>
                                <path d="M394 146 A14 14 0 1 1 402 160" stroke="#2a9d8f" stroke-width="3.5" stroke-linecap="round"/>
                                <path d="M394 140 L394 150 L404 148 Z" fill="#2a9d8f"/>
                                <g transform="rotate(-18 190 66)"><rect x="186" y="46" width="9" height="9" rx="2" fill="#fff"/><rect x="182" y="55" width="17" height="26" rx="5" fill="#fff"/></g>
                                <g stroke="#e0b878" stroke-width="2.5" stroke-linecap="round"><path d="M150 190 L150 156"/></g>
                                <g fill="#e0b878"><ellipse cx="141" cy="166" rx="5" ry="14" transform="rotate(-25 141 166)"/><ellipse cx="160" cy="164" rx="5" ry="14" transform="rotate(25 160 164)"/></g>
                            </svg>

                            <!-- 7. PMT -->
                            <svg class="kb-art d-none" data-art="pmt" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <rect x="166" y="158" width="262" height="9" rx="4" fill="#8a6648"/>
                                <rect x="176" y="167" width="242" height="20" rx="8" fill="#7b563c"/>
                                <circle cx="196" cy="148" r="11" fill="#e0b878"/>
                                <circle cx="215" cy="148" r="11" fill="#e0b878"/>
                                <circle cx="205" cy="135" r="11" fill="#e8c78d"/>
                                <path d="M250 150 C250 126 292 126 292 150 L292 158 L250 158 Z" fill="#8aae92"/>
                                <circle cx="271" cy="108" r="18" fill="#f3cca8"/>
                                <path d="M253 104 C253 88 289 88 289 104 C282 97 260 97 253 104 Z" fill="#3b2a22"/>
                                <circle cx="271" cy="86" r="7" fill="#3b2a22"/>
                                <path d="M290 142 L316 126" stroke="#f3cca8" stroke-width="6" stroke-linecap="round"/>
                                <path d="M316 126 L326 112" stroke="#b8bcc6" stroke-width="3" stroke-linecap="round"/>
                                <path d="M300 158 H348 C348 172 340 178 324 178 C308 178 300 172 300 158 Z" fill="#fff"/>
                                <path d="M298 158 H350" stroke="#e8a23b" stroke-width="4" stroke-linecap="round"/>
                                <rect x="374" y="132" width="26" height="26" fill="#fff"/>
                                <path d="M374 132 L387 118 L400 132 Z" fill="#a8c0ae"/>
                                <rect x="374" y="142" width="26" height="6" fill="#a8c0ae"/>
                                <path d="M394 120 L402 104" stroke="#e8a23b" stroke-width="3.5" stroke-linecap="round"/>
                                <path d="M410 150 C420 146 430 152 432 160 C424 158 416 158 410 150 Z" fill="#d9695a"/>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M142 188 L142 160"/><path d="M142 174 L133 164"/><path d="M142 168 L151 158"/></g>
                            </svg>

                            <!-- 8. Selantang -->
                            <svg class="kb-art d-none" data-art="selantang" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <rect x="260" y="170" width="7" height="16" rx="3" fill="#d9a07a"/>
                                <rect x="272" y="170" width="7" height="16" rx="3" fill="#d9a07a"/>
                                <path d="M254 144 H286 L296 172 H244 Z" fill="#b5667a"/>
                                <rect x="257" y="108" width="26" height="38" rx="7" fill="#e9b840"/>
                                <circle cx="270" cy="94" r="12" fill="#e0a98a"/>
                                <path d="M257 92 C257 76 283 76 283 92 C278 85 262 85 257 92 Z" fill="#e5e5ec"/>
                                <circle cx="270" cy="75" r="7" fill="#e5e5ec"/>
                                <path d="M282 120 L314 132" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M0 0 C-6 -8 -18 -2 0 12 C18 -2 6 -8 0 0Z" transform="translate(308 100) scale(.9)" fill="#e9b840"/>
                                <rect x="340" y="148" width="8" height="38" rx="3" fill="#3b4458"/>
                                <rect x="352" y="148" width="8" height="38" rx="3" fill="#3b4458"/>
                                <rect x="337" y="104" width="26" height="46" rx="7" fill="#5b8db0"/>
                                <circle cx="350" cy="90" r="12" fill="#d9a07a"/>
                                <path d="M338 94 C336 82 346 76 350 78 C354 76 364 82 362 94 C360 86 340 86 338 94 Z" fill="#cfcfd8"/>
                                <path d="M337 120 L322 130" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M363 120 L384 134" stroke="#d9a07a" stroke-width="6" stroke-linecap="round"/>
                                <path d="M386 138 L386 188" stroke="#7b563c" stroke-width="4.5" stroke-linecap="round"/>
                                <path d="M386 138 C386 128 400 128 400 138" stroke="#7b563c" stroke-width="4.5" stroke-linecap="round"/>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M180 188 L180 156"/><path d="M180 172 L171 162"/><path d="M180 166 L189 156"/></g>
                                <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M420 188 L420 164"/><path d="M420 176 L412 168"/></g>
                            </svg>

                            <!-- 9. SOTH -->
                            <svg class="kb-art d-none" data-art="soth" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <path d="M212 98 C198 128 192 160 190 188 H284 C286 160 278 128 268 98 Z" fill="#d2603f"/>
                                <rect x="231" y="144" width="9" height="42" rx="3" fill="#3b4458"/>
                                <rect x="243" y="144" width="9" height="42" rx="3" fill="#3b4458"/>
                                <rect x="228" y="98" width="28" height="48" rx="8" fill="#e9b840"/>
                                <circle cx="242" cy="80" r="13" fill="#f1c9a0"/>
                                <path d="M228 80 C226 62 258 62 256 80 C252 70 232 70 228 80 Z" fill="#3b2a22"/>
                                <circle cx="242" cy="62" r="7" fill="#3b2a22"/>
                                <path d="M254 112 L290 146" stroke="#f1c9a0" stroke-width="6" stroke-linecap="round"/>
                                <rect x="290" y="150" width="18" height="24" rx="4" fill="#4a7a5a"/>
                                <rect x="292" y="174" width="6" height="14" rx="2" fill="#3b4458"/>
                                <rect x="301" y="174" width="6" height="14" rx="2" fill="#3b4458"/>
                                <circle cx="299" cy="140" r="9" fill="#f1c9a0"/>
                                <path d="M290 138 C290 129 308 129 308 138 C304 134 294 134 290 138 Z" fill="#3b2a22"/>
                                <rect x="310" y="154" width="8" height="16" rx="4" fill="#d2603f"/>
                                <path d="M356 152 L346 188 M404 152 L414 188" stroke="#7b563c" stroke-width="4.5" stroke-linecap="round"/>
                                <rect x="340" y="100" width="76" height="54" rx="5" fill="#7b563c"/>
                                <rect x="346" y="106" width="64" height="42" rx="3" fill="#4a7a5a"/>
                                <rect x="346" y="150" width="30" height="3" rx="1.5" fill="#a98562"/>
                                <text x="378" y="138" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-weight="700" font-size="24" fill="#fff">ABC</text>
                                <g stroke="#4a7a5a" stroke-width="2.5" stroke-linecap="round"><path d="M160 188 L160 158"/><path d="M160 174 L151 164"/><path d="M160 168 L169 158"/></g>
                            </svg>

                            <!-- 10. Surabaya Emas -->
                            <svg class="kb-art d-none" data-art="surabaya-emas" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
                                <use href="#kb-base" width="440" height="210"/>
                                <polygon points="340,44 343.8,54.7 355.2,55.1 346.2,62 349.4,72.9 340,66.5 330.6,72.9 333.8,62 324.8,55.1 336.2,54.7" fill="#d4a62a"/>
                                <rect x="372" y="178" width="56" height="9" rx="2" fill="#c0951f"/>
                                <rect x="380" y="169" width="40" height="9" rx="2" fill="#d4a62a"/>
                                <path d="M388 169 C390 132 394 98 400 76 C406 98 410 132 412 169 Z" fill="#d4a62a"/>
                                <path d="M400 80 V166 M394 100 V166 M406 100 V166" stroke="#b8891a" stroke-width="1.5"/>
                                <path d="M400 76 V60" stroke="#c0951f" stroke-width="2.5" stroke-linecap="round"/>
                                <circle cx="400" cy="57" r="3.5" fill="#d4a62a"/>
                                <rect x="207" y="152" width="7" height="28" rx="3" fill="#e0a98a"/>
                                <rect x="217" y="152" width="7" height="28" rx="3" fill="#e0a98a"/>
                                <path d="M203 116 H227 L232 154 H198 Z" fill="#d98595"/>
                                <circle cx="215" cy="104" r="10" fill="#f1c9a0"/>
                                <path d="M205 102 C205 92 225 92 225 102 C221 98 209 98 205 102 Z" fill="#3b2a22"/>
                                <circle cx="203" cy="100" r="4" fill="#3b2a22"/>
                                <circle cx="227" cy="100" r="4" fill="#3b2a22"/>
                                <rect x="249" y="144" width="8" height="36" rx="3" fill="#3b4458"/>
                                <rect x="261" y="144" width="8" height="36" rx="3" fill="#3b4458"/>
                                <rect x="246" y="114" width="26" height="32" rx="5" fill="#2f4a9a"/>
                                <circle cx="259" cy="102" r="10" fill="#f1c9a0"/>
                                <path d="M249 100 C249 90 269 90 269 100 C265 96 253 96 249 100 Z" fill="#3b2a22"/>
                                <rect x="292" y="154" width="8" height="26" rx="3" fill="#e0a98a"/>
                                <rect x="304" y="154" width="8" height="26" rx="3" fill="#e0a98a"/>
                                <path d="M289 118 H315 L320 156 H284 Z" fill="#e9b840"/>
                                <circle cx="302" cy="100" r="14" fill="#8070b8"/>
                                <circle cx="302" cy="103" r="8.5" fill="#f1c9a0"/>
                                <path d="M227 130 L248 132 M270 132 L290 132" stroke="#f1c9a0" stroke-width="5" stroke-linecap="round"/>
                                <g stroke="#6f86c4" stroke-width="2.5" stroke-linecap="round"><path d="M162 188 L162 160"/><path d="M162 174 L153 164"/><path d="M162 168 L171 158"/></g>
                            </svg>
                        </div>

            <!-- 2. Filter Dropdown Pokja & Inovasi -->
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
@endsection
=======
<!-- Banner sub menu: ganti teks, warna, dan ilustrasi sesuai inovasi yang dipilih -->
<script>
(function () {
    var DATA = {
        'elearning-puspaga':  { t: 'E-learning Puspaga PKK', d: 'Pusat Pembelajaran Keluarga (Puspaga) PKK' },
        'kemanggi':           { t: 'Kemangi', d: 'Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri' },
        'selantang':          { t: 'Selantang', d: 'Sekolah Lansia Tangguh' },
        'soth':               { t: 'SOTH', d: 'Sekolah Orang Tua Hebat' },
        'makan-ketan':        { t: 'Makan Ketan', d: 'Pemanfaatan Pekarangan untuk Ketahanan Pangan' },
        'pisang-danor':       { t: 'Pisang Danor', d: 'Pilah Sampah Anorganik dan Organik' },
        'pmt':                { t: 'PMT', d: 'Pemberian Makanan Tambahan' },
        'pendampingan-bumil': { t: 'Pendampingan Ibu Hamil dan Ibu Hamil Resti', d: 'Mendampingi ibu hamil agar sehat dan selamat' },
        'kampung-asi':        { t: 'Kampung ASI', d: 'Gizi seimbang untuk ibu dan anak' },
        'surabaya-emas':      { t: 'Surabaya Emas', d: 'Generasi emas Kota Surabaya' }
    };

    var banner = document.getElementById('kb-banner');
    var defaultBanner = document.getElementById('banner-inovasi-default');
    var items = document.querySelectorAll('#state-detail-content .inovasi-item-view');
    var lastKey = null;
    if (!banner || !items.length) return;

    // Cari konten inovasi yang sedang tampil (id-nya: content-<nama>)
    function activeKey() {
        for (var i = 0; i < items.length; i++) {
            if (items[i].offsetParent !== null) return items[i].id.replace('content-', '');
        }
        return null;
    }

    function render() {
        var key = activeKey();
        if (key === lastKey) return;
        lastKey = key;

        if (!key || !DATA[key]) {
            banner.classList.add('d-none');
            if (defaultBanner) defaultBanner.classList.remove('d-none');
            return;
        }
        if (defaultBanner) defaultBanner.classList.add('d-none');

        banner.className = 'kb kb--' + key;
        document.getElementById('kb-title').textContent = DATA[key].t;
        document.getElementById('kb-desc').textContent = DATA[key].d;
        banner.querySelectorAll('.kb-art').forEach(function (svg) {
            svg.classList.toggle('d-none', svg.getAttribute('data-art') !== key);
        });
    }

    // Pantau perubahan tampil/sembunyi pada tiap konten (banner sendiri tidak ikut dipantau)
    var mo = new MutationObserver(render);
    items.forEach(function (el) { mo.observe(el, { attributes: true, attributeFilter: ['class', 'style'] }); });
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'select-filter-inovasi') setTimeout(render, 0);
    });
    render();
})();
</script>
@endsection
>>>>>>> Stashed changes
