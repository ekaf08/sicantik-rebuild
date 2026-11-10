@extends('bo.layout.app')

@section('content')
<style>
    #view-inovasi-dashboard, 
    #view-inovasi-input,
    #modal-form-inovasi,
    #modal-confirm-delete,
    #modal-preview-media,
    #modal-detail-pokja {
        color: #0f172a !important;
        font-family: inherit;
    }

    .banner-inovasi-tosca {
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

    .banner-inovasi-tosca::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.18) 1.2px, transparent 1.2px);
        background-size: 22px 22px;
        -webkit-mask-image: linear-gradient(90deg, #000 0%, #000 30%, transparent 58%);
        mask-image: linear-gradient(90deg, #000 0%, #000 30%, transparent 58%);
        pointer-events: none !important;
        z-index: 1;
    }

    .banner-siluet-kanan {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 100%;
        width: auto;
        aspect-ratio: 350 / 210;
        pointer-events: none !important;
        z-index: 1 !important;
    }

    @media (max-width: 991px) {
        .banner-siluet-kanan {
            opacity: 0.3;
        }
    }

    .banner-inovasi-tosca h2 {
        color: #ffffff !important;
    }
    .banner-inovasi-tosca span.fw-semibold {
        color: #e6fffa !important;
    }

    .btn-tab-pill-tosca {
        min-width: 230px !important;
        padding: 16px 26px !important;
        border-radius: 1.1rem !important;
        transition: all 0.25s ease;
        cursor: pointer !important;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        text-decoration: none;
        border: none;
        outline: none;
        position: relative !important;
        z-index: 9999 !important;
        pointer-events: auto !important;
    }

    .btn-tab-pill-tosca.active {
        background-color: #ffffff !important;
        border: 1px solid #ffffff !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
    }
    .btn-tab-pill-tosca.active .tab-title-text {
        color: #0d4e48 !important;
        font-weight: 800 !important;
    }
    .btn-tab-pill-tosca.active .tab-sub-text {
        color: #334155 !important;
    }

    .btn-tab-pill-tosca:not(.active) {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        backdrop-filter: blur(4px);
    }
    .btn-tab-pill-tosca:not(.active) .tab-title-text {
        color: #ffffff !important;
        font-weight: 800 !important;
    }
    .btn-tab-pill-tosca:not(.active) .tab-sub-text {
        color: #a7f3d0 !important;
    }

    .btn-tab-pill-tosca .tab-title-text {
        font-size: 1.1rem !important;
        letter-spacing: 0.6px !important;
    }
    .btn-tab-pill-tosca .tab-sub-text {
        font-size: 0.88rem !important;
        margin-top: 2px;
    }

    .card-pokja-clickable {
        transition: all 0.22s ease-in-out;
        cursor: pointer !important;
        border: 1.5px solid transparent !important;
        background-color: #ffffff;
    }
    .card-pokja-clickable:hover {
        transform: translateY(-4px);
        background-color: #f0fdfa !important;
        border-color: #2dd4bf !important;
        box-shadow: 0 12px 24px -4px rgba(13, 148, 136, 0.18) !important;
    }
    .card-pokja-clickable:active {
        transform: scale(0.98);
        background-color: #ccfbf1 !important;
        border-color: #0d9488 !important;
    }

    .stat-card-title {
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 1rem !important;
    }

    .table-custom-wrapper {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .table-custom thead th {
        color: #334155 !important;
        font-weight: 700 !important;
        font-size: 0.85rem;
        padding: 16px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        background: #f8fafc !important;
    }

    .table-custom tbody td {
        padding: 16px 14px;
        vertical-align: middle;
        font-size: 0.84rem;
        border-bottom: 1px solid #f1f5f9;
        color: #0f172a !important;
    }

    .filter-select-compact {
        width: auto !important;
        display: inline-block !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.65rem !important;
        padding: 7px 34px 7px 14px !important;
        font-size: 0.82rem !important;
        color: #334155 !important;
        font-weight: 600;
        background-color: #ffffff !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
        cursor: pointer;
    }
    .filter-select-compact:focus {
        border-color: #0d9488 !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12) !important;
    }

    .dt-search-input {
        width: 190px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.55rem !important;
        padding: 6px 12px !important;
        font-size: 0.84rem !important;
        background-color: #f8fafc !important;
        color: #0f172a !important;
        outline: none;
        transition: all 0.2s ease;
    }
    .dt-search-input:focus {
        background-color: #ffffff !important;
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12) !important;
    }

    .modal-content-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        background-color: #ffffff !important;
    }

    .form-control-modern {
        border: 1.5px solid #cbd5e1;
        border-radius: 0.55rem;
        padding: 10px 14px !important;
        font-size: 0.95rem !important;
        background-color: #ffffff !important;
        color: #0f172a !important;
        transition: all 0.2s ease;
    }
    .form-control-modern:focus {
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
        outline: none;
    }

    .upload-card-box {
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 10px;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        text-align: center;
        position: relative;
    }
    .upload-card-box:hover {
        border-color: #0d9488;
        background-color: #f0fdfa;
    }

    .preview-img-container {
        width: 100%;
        height: 100px;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .preview-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-table-thumb {
        width: 72px !important;
        height: 60px !important;
        object-fit: cover;
        border-radius: 8px !important;
        border: 2px solid #cbd5e1 !important;
        transition: transform 0.2s;
        cursor: pointer;
    }
    .img-table-thumb:hover {
        transform: scale(1.12);
    }

    .btn-icon-square-edit {
        width: 36px;
        height: 36px;
        background-color: #eff6ff !important;
        border: 1px solid #dbeafe !important;
        color: #2563eb !important;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-icon-square-edit:hover {
        background-color: #dbeafe !important;
        transform: translateY(-1px);
    }

    .btn-icon-square-delete {
        width: 36px;
        height: 36px;
        background-color: #fff1f2 !important;
        border: 1px solid #ffe4e6 !important;
        color: #f43f5e !important;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-icon-square-delete:hover {
        background-color: #ffe4e6 !important;
        transform: translateY(-1px);
    }

    .modal-delete-icon-box {
        width: 84px;
        height: 84px;
        background-color: #ffe4e6;
        color: #e11d48;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.3rem;
        box-shadow: 0 0 0 8px #fff1f2;
    }

    .modal-delete-desc {
        color: #334155 !important;
        font-size: 1.05rem !important;
        font-weight: 500 !important;
        line-height: 1.5;
    }

    #table-pagination-list {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    #table-pagination-list .page-link {
        color: #0f172a !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1;
        border-radius: 6px !important;
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        padding: 0 !important;
        cursor: pointer;
    }

    #table-pagination-list .page-item.active .page-link {
        color: #ffffff !important;
        background-color: #0d9488 !important;
        border-color: #0d9488 !important;
    }

    .tab-view-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        width: 100%;
    }

    .btn-preview-pdf {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px !important;
        font-size: 0.9rem !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
    }
    .btn-preview-pdf i { font-size: 1.5rem; }

    .btn-remove-foto {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 24px;
        height: 24px;
        border: none;
        border-radius: 50%;
        background: rgba(225, 29, 72, 0.92);
        color: #fff;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 5;
        padding: 0;
    }
    .btn-remove-foto:hover { background: #be123c; }

    #modal-form-inovasi .modal-dialog {
        max-width: 780px !important;
        width: 94%;
    }
    #modal-form-inovasi .modal-title { font-size: 1.35rem !important; }
    #modal-form-inovasi .form-label { font-size: 0.92rem !important; }
    #modal-form-inovasi .btn { font-size: 0.92rem !important; }
    #modal-alert-box {
        font-size: 0.98rem !important;
        padding: 12px 16px !important;
    }

    #modal-confirm-delete .modal-dialog {
        max-width: 540px !important;
        width: 94%;
    }
    #modal-confirm-delete .modal-content-modern { padding: 2.2rem !important; }
    #modal-confirm-delete h5 { font-size: 1.5rem !important; }
    #modal-confirm-delete .btn { font-size: 1rem !important; padding: 10px 26px !important; }

    #modal-preview-media .modal-dialog {
        max-width: 1000px !important;
        width: 95%;
    }
    #modal-preview-media .modal-title { font-size: 1.2rem !important; }
    #preview-media-body { min-height: 75vh !important; }
    #preview-media-body iframe { height: 75vh !important; }
    #preview-media-body img { max-height: 75vh !important; }

    .toast-container-custom {
        position: fixed;
        top: 50% !important;
        left: 50% !important;
        right: auto !important;
        bottom: auto !important;
        transform: translate(-50%, -50%);
        z-index: 20000;
    }
    .toast-container-custom .toast {
        width: 520px;
        max-width: 92vw;
        border-radius: 1rem !important;
    }
    .toast-container-custom .toast-body {
        padding: 1.5rem 1.5rem !important;
    }
    #toast-message { font-size: 1.1rem !important; line-height: 1.5; }
    #toast-icon { font-size: 2.2rem !important; }

    #dash-filter-kelurahan:disabled,
    #table-filter-kelurahan:disabled {
        background-color: #ffffff !important;
        opacity: 1 !important;
        pointer-events: none;
    }
    #dash-filter-kelurahan:disabled { color: #0f172a !important; }
    #table-filter-kelurahan:disabled { color: #334155 !important; }
</style>

<div class="d-flex flex-column gap-4 w-100 p-2 p-md-3">

    <div class="card banner-inovasi-tosca mb-4">
        <svg class="banner-siluet-kanan" viewBox="50 0 350 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
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

        <div class="card-body py-5 px-4 px-md-5 ps-4 ps-md-5 ps-lg-5 d-flex flex-column justify-content-center position-relative w-100" style="z-index: 10; padding-left: 2.75rem !important;">
            <h2 class="fw-bolder mb-2 text-uppercase tracking-wide" style="font-size: 2.1rem; letter-spacing: 0.5px;">
                Inovasi Global
            </h2>
            <span class="fw-semibold mb-4" style="font-size: 0.95rem; color: #e6fffa;">
                Berikut adalah Inovasi PKK yang telah diinputkan 
            </span>
            <div class="d-flex flex-wrap gap-3" style="position: relative; z-index: 9999;">
                <button type="button" class="btn-tab-pill-tosca active" id="btn-tab-dashboard">
                    <div>
                        <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Dashboard</span>
                        <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Ringkasan & Distribusi</span>
                    </div>
                </button>

                <button type="button" class="btn-tab-pill-tosca" id="btn-tab-input">
                    <div>
                        <span class="tab-title-text d-block text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Input Inovasi</span>
                        <span class="tab-sub-text small d-block" style="font-size: 0.73rem;">Daftar & Kelola</span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div id="view-inovasi-dashboard" class="tab-view-container">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Kecamatan</label>
                        <select id="dash-filter-kecamatan" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua kecamatan</option>
                            @if(isset($kecamatan) && is_iterable($kecamatan))
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->nama_kec }}">{{ $kec->nama_kec }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Kelurahan</label>
                        <select id="dash-filter-kelurahan" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua kelurahan</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-dark text-uppercase mb-1">Periode</label>
                        <select id="dash-filter-periode" class="form-select bg-white border-light-subtle rounded-3 small fw-semibold text-dark">
                            <option value="Semua">Semua Periode</option>
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm rounded-4 text-center h-100 card-pokja-clickable" data-pokja="Sekretaris" style="background-color: #f0fdfa !important; border: 1.5px solid #a7f3d0 !important;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                <h1 class="fw-bolder mb-2" id="stat-count-sekretaris" style="font-size: 3.2rem; line-height: 1; color: #0d6e66;">0</h1>
                <span class="stat-card-title d-block mb-3 fs-5" style="color: #0b5e57 !important;">Sekretaris</span>
                <span class="badge px-4 py-2 rounded-pill fw-bold" style="font-size: 0.85rem; background-color: #ccfbf1; color: #0d6e66; border: 1px solid #99f6e4;">Inovasi</span>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm rounded-4 text-center h-100 card-pokja-clickable" data-pokja="POKJA 1" style="background-color: #f0fdf4 !important; border: 1.5px solid #a7f3d0 !important;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                <h1 class="fw-bolder mb-2" id="stat-count-pokja1" style="font-size: 3.2rem; line-height: 1; color: #14867c;">0</h1>
                <span class="stat-card-title d-block mb-3 fs-5" style="color: #0f6860 !important;">Pokja 1</span>
                <span class="badge px-4 py-2 rounded-pill fw-bold" style="font-size: 0.85rem; background-color: #d1fae5; color: #14867c; border: 1px solid #6ee7b7;">Inovasi</span>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm rounded-4 text-center h-100 card-pokja-clickable" data-pokja="POKJA 2" style="background-color: #f2f9f6 !important; border: 1.5px solid #bbf2e5 !important;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                <h1 class="fw-bolder mb-2" id="stat-count-pokja2" style="font-size: 3.2rem; line-height: 1; color: #2f8f83;">0</h1>
                <span class="stat-card-title d-block mb-3 fs-5" style="color: #1e6b62 !important;">Pokja 2</span>
                <span class="badge px-4 py-2 rounded-pill fw-bold" style="font-size: 0.85rem; background-color: #dcf6ef; color: #2f8f83; border: 1px solid #a3ebd8;">Inovasi</span>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl">
        <div class="card border-0 shadow-sm rounded-4 text-center h-100 card-pokja-clickable" data-pokja="POKJA 3" style="background-color: #fffdf5 !important; border: 1.5px solid #fde68a !important;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                <h1 class="fw-bolder mb-2" id="stat-count-pokja3" style="font-size: 3.2rem; line-height: 1; color: #d97706;">0</h1>
                <span class="stat-card-title d-block mb-3 fs-5" style="color: #b45309 !important;">Pokja 3</span>
                <span class="badge px-4 py-2 rounded-pill fw-bold" style="font-size: 0.85rem; background-color: #fef3c7; color: #b45309; border: 1px solid #fcd34d;">Inovasi</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 col-xl">
        <div class="card border-0 shadow-sm rounded-4 text-center h-100 card-pokja-clickable" data-pokja="POKJA 4" style="background-color: #fff8f5 !important; border: 1.5px solid #fed7aa !important;">
            <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 220px;">
                <h1 class="fw-bolder mb-2" id="stat-count-pokja4" style="font-size: 3.2rem; line-height: 1; color: #ea580c;">0</h1>
                <span class="stat-card-title d-block mb-3 fs-5" style="color: #c2410c !important;">Pokja 4</span>
                <span class="badge px-4 py-2 rounded-pill fw-bold" style="font-size: 0.85rem; background-color: #ffedd5; color: #c2410c; border: 1px solid #fdba74;">Inovasi</span>
            </div>
        </div>
    </div>
</div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <h5 class="fw-bold text-dark mb-1 fs-4">Distribusi Inovasi per Pokja</h5>
                    </div>
                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold fs-7 shadow-xs" id="stat-total-badge">Total: 0 Inovasi</span>
                </div>
                
                <div class="d-flex flex-column gap-4 py-2">
                    <div class="d-flex align-items-center p-2 rounded-3 bg-light-subtle card-pokja-clickable" data-pokja="Sekretaris">
                        <span class="text-dark fw-bold small text-start ps-2" style="width: 130px; font-size: 0.92rem;">Sekretaris</span>
                        <div class="progress flex-grow-1 mx-3 rounded-pill bg-secondary-subtle" style="height: 14px;">
                            <div class="progress-bar bg-success rounded-pill transition-all" id="bar-sekretaris" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bolder text-end pe-2" id="val-sekretaris" style="width: 45px; font-size: 1rem;">0</span>
                    </div>

                    <div class="d-flex align-items-center p-2 rounded-3 bg-light-subtle card-pokja-clickable" data-pokja="POKJA 1">
                        <span class="text-dark fw-bold small text-start ps-2" style="width: 130px; font-size: 0.92rem;">Pokja 1</span>
                        <div class="progress flex-grow-1 mx-3 rounded-pill bg-secondary-subtle" style="height: 14px;">
                            <div class="progress-bar bg-primary rounded-pill transition-all" id="bar-pokja1" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bolder text-end pe-2" id="val-pokja1" style="width: 45px; font-size: 1rem;">0</span>
                    </div>

                    <div class="d-flex align-items-center p-2 rounded-3 bg-light-subtle card-pokja-clickable" data-pokja="POKJA 2">
                        <span class="text-dark fw-bold small text-start ps-2" style="width: 130px; font-size: 0.92rem;">Pokja 2</span>
                        <div class="progress flex-grow-1 mx-3 rounded-pill bg-secondary-subtle" style="height: 14px;">
                            <div class="progress-bar bg-primary rounded-pill transition-all" id="bar-pokja2" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bolder text-end pe-2" id="val-pokja2" style="width: 45px; font-size: 1rem;">0</span>
                    </div>

                    <div class="d-flex align-items-center p-2 rounded-3 bg-light-subtle card-pokja-clickable" data-pokja="POKJA 3">
                        <span class="text-dark fw-bold small text-start ps-2" style="width: 130px; font-size: 0.92rem;">Pokja 3</span>
                        <div class="progress flex-grow-1 mx-3 rounded-pill bg-secondary-subtle" style="height: 14px;">
                            <div class="progress-bar bg-success rounded-pill transition-all" id="bar-pokja3" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bolder text-end pe-2" id="val-pokja3" style="width: 45px; font-size: 1rem;">0</span>
                    </div>

                    <div class="d-flex align-items-center p-2 rounded-3 bg-light-subtle card-pokja-clickable" data-pokja="POKJA 4">
                        <span class="text-dark fw-bold small text-start ps-2" style="width: 130px; font-size: 0.92rem;">Pokja 4</span>
                        <div class="progress flex-grow-1 mx-3 rounded-pill bg-secondary-subtle" style="height: 14px;">
                            <div class="progress-bar bg-primary rounded-pill transition-all" id="bar-pokja4" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="text-dark fw-bolder text-end pe-2" id="val-pokja4" style="width: 45px; font-size: 1rem;">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="view-inovasi-input" class="tab-view-container" style="display: none;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <div class="d-flex flex-wrap justify-content-end align-items-center mb-4 gap-2">
                    <select id="table-filter-kecamatan" class="form-select filter-select-compact text-uppercase">
                        <option value="Semua">SEMUA KECAMATAN</option>
                        @if(isset($kecamatan) && is_iterable($kecamatan))
                            @foreach($kecamatan as $kec)
                                <option value="{{ $kec->nama_kec }}">{{ strtoupper($kec->nama_kec) }}</option>
                            @endforeach
                        @endif
                    </select>

                    <select id="table-filter-kelurahan" class="form-select filter-select-compact">
                        <option value="Semua">Pilih Kelurahan</option>
                    </select>

                    <select id="table-filter-periode" class="form-select filter-select-compact">
                        <option value="Semua">Semua</option>
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-dark fw-semibold" style="font-size: 0.9rem;">Show</span>
                        <select id="entries-per-page" class="form-select filter-select-compact py-1 px-2" style="padding-right: 28px !important;">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <button type="button" id="btn-tambah-data-modal" class="btn btn-sm btn-success px-3 py-2 fw-bold rounded-3 shadow-sm me-2 text-white">
                            <i class="fa-solid fa-plus me-1 text-white"></i> Tambah Inovasi
                        </button>
                        <span class="text-dark fw-semibold" style="font-size: 0.9rem;">Search:</span>
                        <input type="text" id="search-inovasi-input" class="dt-search-input" placeholder="" autocomplete="off" />
                    </div>
                </div>

                <div class="table-custom-wrapper">
                    <div class="table-responsive mb-0">
                        <table class="table table-custom align-middle mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">No <i class="fa-solid fa-angle-up text-secondary ms-1" style="font-size: 0.7rem;"></i></th>
                                    <th>Tanggal<br>Entry</th>
                                    <th>Nama Inovasi</th>
                                    <th>Deskripsi<br>Inovasi</th>
                                    <th class="text-center">File</th>
                                    <th class="text-center">Foto<br>Inovasi</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Keterangan</th>
                                    <th>Dibuat<br>Oleh</th>
                                    <th class="text-center" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="innovation-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-4 mt-1 border-top">
                    <span class="text-dark small fw-semibold" id="table-info-label">
                        Showing 0 to 0 of 0 entries
                    </span>
                    <nav aria-label="Navigasi Halaman">
                        <ul class="pagination pagination-sm mb-0" id="table-pagination-list">
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-detail-pokja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-content-modern bg-white">
            <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-5 mb-0" id="modal-detail-pokja-title">Detail Inovasi - Sekretaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="table-custom-wrapper">
                    <div class="table-responsive mb-0">
                        <table class="table table-custom align-middle mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">No <i class="fa-solid fa-angle-up text-secondary ms-1" style="font-size: 0.7rem;"></i></th>
                                    <th>Tanggal Entry</th>
                                    <th>Nama Inovasi</th>
                                    <th>Deskripsi Inovasi</th>
                                    <th class="text-center">Periode</th>
                                    <th class="text-center">Keterangan</th>
                                    <th>Dibuat Oleh</th>
                                </tr>
                            </thead>
                            <tbody id="detail-pokja-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form-inovasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
        <div class="modal-content modal-content-modern">
            <div class="modal-header border-bottom px-4 py-3 bg-white">
                <h6 class="modal-title fw-bold text-dark fs-5 mb-0" id="modal-form-title">Tambah Data Inovasi</h6>
                <button type="button" class="btn-close" id="btn-close-modal" aria-label="Close"></button>
            </div>

            <form id="form-submit-inovasi" class="p-4 d-flex flex-column gap-3 bg-white">
                @csrf
                <input type="hidden" id="entry-index-id" name="id" value="-1">
                <input type="hidden" id="remove-foto-1" name="remove_foto_1" value="0">
                <input type="hidden" id="remove-foto-2" name="remove_foto_2" value="0">
                <input type="hidden" id="remove-file-dokumen" name="remove_file_dokumen" value="0">

                <div id="modal-alert-box" class="alert alert-danger py-2 px-3 small rounded-3 d-none align-items-center gap-2" role="alert">
                    <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    <span id="modal-alert-msg" class="text-danger fw-bold">Mohon lengkapi semua kolom wajib!</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Tanggal Entry <span class="text-danger">*</span></label>
                        <input type="date" id="form-input-tanggal" name="tanggal_entry" class="form-control-modern w-100 fw-bold text-dark cursor-pointer" required />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Pokja <span class="text-danger">*</span></label>
                        <select id="form-input-pokja" name="pokja" class="form-control-modern w-100 fw-semibold text-dark" required>
                            <option value="" selected>-- Pilih Pokja --</option>
                            <option value="Sekretaris">Sekretaris</option>
                            <option value="POKJA 1">POKJA 1</option>
                            <option value="POKJA 2">POKJA 2</option>
                            <option value="POKJA 3">POKJA 3</option>
                            <option value="POKJA 4">POKJA 4</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Kecamatan <span class="text-danger">*</span></label>
                        <select id="form-input-kecamatan" name="id_kec" class="form-control-modern w-100 fw-semibold text-dark" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @if(isset($kecamatan) && is_iterable($kecamatan))
                                @foreach($kecamatan as $kec)
                                    <option value="{{ $kec->id_kec ?? $kec->ref ?? $kec->nama_kec }}">{{ $kec->nama_kec }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label small fw-bold text-dark mb-1">Dibuat Oleh <span class="text-danger">*</span></label>
                        <input type="text" id="form-input-dibuat" name="dibuat_oleh" value="{{ Auth::user()->name ?? 'Kader PKK' }}" placeholder="Nama kader / pengurus" class="form-control-modern w-100 text-dark" readonly required />
                    </div>
                </div>

                <div>
                    <label class="form-label small fw-bold text-dark mb-1">Nama Inovasi <span class="text-danger">*</span></label>
                    <input type="text" id="form-input-nama" name="nama_inovasi" placeholder="Contoh: PJ IT" class="form-control-modern w-100 text-dark" required />
                </div>

                <div>
                    <label class="form-label small fw-bold text-dark mb-1">Deskripsi Inovasi <span class="text-danger">*</span></label>
                    <textarea id="form-input-deskripsi" name="deskripsi_inovasi" rows="2" placeholder="Deskripsi inovasi" class="form-control-modern w-100 text-dark" required></textarea>
                </div>

                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-dark mb-0"><i class="fa-solid fa-images text-secondary me-1"></i> Lampiran Foto</span>
                        <span class="badge bg-danger-subtle text-danger small fw-bold" style="font-size: 0.68rem;">Maks. 2 MB</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="upload-card-box">
                                <div class="preview-img-container mb-2" id="box-preview-1">
                                    <span class="small fw-semibold text-secondary" id="text-preview-1"><i class="fa-regular fa-image fa-2x d-block mb-1 text-secondary"></i>Foto 1</span>
                                    <img src="" id="img-preview-1" class="d-none" alt="Preview Foto 1">
                                    <button type="button" class="btn-remove-foto d-none" id="btn-remove-foto-1" data-num="1" title="Hapus Foto 1">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <input type="file" id="file-foto-1" name="foto_1" accept="image/*" class="d-none">
                                <button type="button" id="btn-pilih-foto-1" class="btn btn-sm btn-white border shadow-xs fw-bold small w-100 py-1 text-dark">
                                    <i class="fa-solid fa-cloud-arrow-up text-secondary me-1"></i> Upload 1
                                </button>
                                <span id="label-foto-1" class="small text-truncate d-block mt-1 fw-medium text-secondary" style="font-size: 0.75rem;">Belum ada foto</span>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="upload-card-box">
                                <div class="preview-img-container mb-2" id="box-preview-2">
                                    <span class="small fw-semibold text-secondary" id="text-preview-2"><i class="fa-regular fa-image fa-2x d-block mb-1 text-secondary"></i>Foto 2</span>
                                    <img src="" id="img-preview-2" class="d-none" alt="Preview Foto 2">
                                    <button type="button" class="btn-remove-foto d-none" id="btn-remove-foto-2" data-num="2" title="Hapus Foto 2">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <input type="file" id="file-foto-2" name="foto_2" accept="image/*" class="d-none">
                                <button type="button" id="btn-pilih-foto-2" class="btn btn-sm btn-white border shadow-xs fw-bold small w-100 py-1 text-dark">
                                    <i class="fa-solid fa-cloud-arrow-up text-secondary me-1"></i> Upload 2
                                </button>
                                <span id="label-foto-2" class="small text-truncate d-block mt-1 fw-medium text-secondary" style="font-size: 0.75rem;">Belum ada foto</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small fw-bold text-dark mb-0"><i class="fa-solid fa-file-pdf text-danger me-1"></i> Dokumen Proposal / Juknis</span>
                        <span class="badge bg-danger-subtle text-danger small fw-bold" style="font-size: 0.68rem;">PDF (Maks. 2 MB)</span>
                    </div>

                    <div class="flex-column gap-2 d-flex">
                        <div class="d-flex align-items-center gap-2">
                            <input type="file" id="file-dokumen-pdf" name="file_dokumen" accept="application/pdf" class="d-none">
                            <button type="button" id="btn-pilih-dokumen" class="btn btn-sm btn-white border shadow-xs fw-bold small text-dark">
                                <i class="fa-solid fa-file-pdf text-danger me-1"></i> Pilih Berkas PDF
                            </button>
                            <span id="label-dokumen-pdf" class="text-dark small text-truncate fw-semibold" style="max-width: 250px;">Belum ada PDF dipilih</span>
                        </div>

                        <div id="pdf-preview-box" class="d-none">
                            <div class="d-inline-flex align-items-center gap-2 p-2 rounded-3 bg-danger-subtle text-danger small fw-semibold">
                                <i class="fa-solid fa-file-pdf fa-lg"></i>
                                <span id="pdf-preview-name" class="text-truncate text-danger" style="max-width: 260px;">file.pdf</span>
                                <span id="pdf-preview-size" class="text-danger small"></span>
                                <button type="button" id="btn-remove-pdf" class="btn-close ms-2" style="font-size: 0.6rem;"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-2">
                    <button type="button" id="btn-batal-modal" class="btn btn-light text-dark fw-bold px-4 rounded-3 small">
                        Batal
                    </button>
                    <button type="button" id="btn-submit-modal" class="btn btn-success text-white fw-bold px-4 rounded-3 shadow-sm small">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirm-delete" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content modal-content-modern p-4 text-center bg-white">
            <div class="modal-delete-icon-box">
                <i class="fa-solid fa-trash-can"></i>
            </div>

            <h5 class="fw-bold text-dark mb-2 fs-5">Hapus Data Inovasi?</h5>
            
            <p class="modal-delete-desc mb-4">
                Apakah Anda yakin ingin menghapus <strong id="delete-item-title" class="text-danger fw-bold">"SOTH"</strong>? 
            </p>

            <input type="hidden" id="delete-target-id" value="">

            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn-light btn text-dark fw-bold px-4 rounded-3 small" id="btn-cancel-delete">
                    Batal
                </button>
                <button type="button" class="btn-danger btn text-white fw-bold px-4 rounded-3 shadow-sm small" id="btn-execute-delete">
                    <i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-preview-media" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-modern bg-white">
            <div class="modal-header border-bottom px-4 py-3">
                <h6 class="modal-title fw-bold text-dark fs-6" id="preview-media-title">Preview Berkas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center" id="preview-media-body" style="min-height: 480px; display: flex; align-items: center; justify-content: center;">
            </div>
        </div>
    </div>
</div>

<div class="toast-container-custom">
    <div id="live-toast-alert" class="toast align-items-center text-white bg-dark border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 py-3 px-3">
                <i id="toast-icon" class="fa-solid fa-circle-check text-success fs-5"></i>
                <span id="toast-message" class="small fw-semibold text-white">Data berhasil diproses!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const BASE_ASSET_URL = "{{ url('/') }}";
    const MASTER_KELURAHAN_LIST = @json(isset($kelurahan) ? $kelurahan : []);
    let inovasiData = [];
    let currentFoto1 = '';
    let currentFoto2 = '';
    let currentPdfUrl = '';
    let currentPdfName = '';
    let currentPage = 1;
    let searchDebounceTimer = null;

    const MAX_FILE_SIZE_BYTES = 2 * 1024 * 1024;

    function notifyToast(message, isSuccess = true) {
        const toastEl = document.getElementById('live-toast-alert');
        const msgEl = document.getElementById('toast-message');
        const iconEl = document.getElementById('toast-icon');

        if (!toastEl) return;

        msgEl.innerText = message;
        if (isSuccess) {
            iconEl.className = 'fa-solid fa-circle-check text-success fs-5';
        } else {
            iconEl.className = 'fa-solid fa-triangle-exclamation text-danger fs-5';
        }

        if (window.bootstrap && window.bootstrap.Toast) {
            const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
            toast.show();
        } else {
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 3500);
        }
    }

    function formatAssetUrl(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('blob:') || path.startsWith('data:')) {
            return path;
        }
        const cleanPath = path.startsWith('/') ? path : '/' + path;
        return BASE_ASSET_URL + cleanPath;
    }

    function escapeHtml(v) {
        return String(v ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function resetRemoveFlags() {
        ['remove-foto-1', 'remove-foto-2', 'remove-file-dokumen'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '0';
        });
    }

    function resetFileInputs() {
        ['file-foto-1', 'file-foto-2', 'file-dokumen-pdf'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
    }

    function removeFoto(num) {
        document.getElementById(`file-foto-${num}`).value = '';
        if (String(num) === '1') currentFoto1 = ''; else currentFoto2 = '';
        setPreviewBox(num, '');
        document.getElementById(`label-foto-${num}`).innerText = 'Belum ada foto';
        document.getElementById(`remove-foto-${num}`).value = '1';
    }

    function openPreviewModal(type, url, title) {
        const body = document.getElementById('preview-media-body');
        const titleEl = document.getElementById('preview-media-title');
        titleEl.innerText = title || 'Preview Berkas';
        body.innerHTML = '';

        if (type === 'pdf') {
            const frame = document.createElement('iframe');
            frame.src = url;
            frame.style.cssText = 'width:100%;height:500px;border:none;border-radius:8px;';
            body.appendChild(frame);
        } else {
            const img = document.createElement('img');
            img.src = url;
            img.className = 'img-fluid rounded shadow-sm';
            img.style.cssText = 'max-height:500px;object-fit:contain;';
            body.appendChild(img);
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-preview-media')).show();
    }

    const PETA_WILAYAH_SURABAYA = {
        "tegalsari": ["Kedungdoro", "Keputran", "Dr. Soetomo", "Tegalsari", "Wonorejo"],
        "simokerto": ["Kapasan", "Sidodadi", "Simokerto", "Simolawang", "Tambakrejo"],
        "genteng": ["Embong Kaliasin", "Genteng", "Kapasari", "Ketabang", "Peneleh"],
        "bubutan": ["Alun-alun Contong", "Bubutan", "Gundih", "Jepara", "Tembok Dukuh"],
        "gubeng": ["Airlangga", "Baratajaya", "Gubeng", "Kertajaya", "Mojo", "Pucangsewu"],
        "gunung anyar": ["Gunung Anyar", "Gunung Anyar Tambak", "Rungkut Menanggal", "Rungkut Tengah"],
        "sukolilo": ["Gebang Putih", "Keputih", "Klampisngasem", "Medokan Semampir", "Menur Pumpungan", "Nginden Jangkungan", "Semolowaru"],
        "tambaksari": ["Dukuh Setro", "Gading", "Kapasmadya Baru", "Pacarkembang", "Pacarkeling", "Ploso", "Rangkah", "Tambaksari"],
        "mulyorejo": ["Kalijudan", "Kalisari", "Kejawan Putih Tambak", "Manyar Sabrangan", "Mulyorejo", "Dukuh Sutorejo"],
        "rungkut": ["Kalirungkut", "Kedungbaruk", "Medokan Ayu", "Penjaringan Sari", "Rungkut Kidul", "Wonorejo"],
        "tenggilis mejoyo": ["Kendangsari", "Kutisari", "Panjang Jiwo", "Prapen", "Tenggilis Mejoyo"],
        "benowo": ["Kandangan", "Romokalisari", "Sememi", "Tambak Osowilangun"],
        "pakal": ["Babur Jerawat", "Benowo", "Pakal", "Sumberejo"],
        "asemrowo": ["Asemrowo", "Genting Kalianak", "Tambak Sarioso"],
        "sukomanunggal": ["Putat Gede", "Simomulyo", "Simomulyo Baru", "Sonokwijenan", "Sukomanunggal", "Tanjungsari"],
        "tandes": ["Balongsari", "Banjar Sugihan", "Karang Poh", "Manukan Kulon", "Manukan Wetan", "Tandes"],
        "sambikerep": ["Benowo", "Bringin", "Made", "Lakar Santri", "Sambikerep"],
        "lakarsantri": ["Bangkingan", "Jeruk", "Lakarsantri", "Lidah Kulon", "Lidah Wetan", "Sumur Welut"],
        "karangpilang": ["Karang Pilang", "Kebraon", "Kedurus", "Warugunung"],
        "jambangan": ["Jambangan", "Karah", "Kebonsari", "Pagesangan"],
        "gayungan": ["Dukuh Menanggal", "Gayungan", "Ketintang", "Menanggal"],
        "wonocolo": ["Bendul Merisi", "Jemur Wonosari", "Margorejo", "Sidosermo", "Siwalankerto"],
        "wonokromo": ["Darmo", "Jagir", "Ngagel", "Ngagelrejo", "Sawunggaling", "Wonokromo"],
        "sawahan": ["Banyu Urip", "Kupang Krajan", "Pakis", "Petemon", "Putat Jaya", "Sawahan"],
        "dukuh pakis": ["Dukuh Kupang", "Dukuh Pakis", "Gunung Sari", "Pradah Kalikendal"],
        "wiyung": ["Babatan", "Balasklumprik", "Jajar Tunggal", "Wiyung"],
        "krembangan": ["Dupak", "Kemayoran", "Krembangan Selatan", "Morokrembangan", "Perak Barat"],
        "pabean cantikan": ["Bongkaran", "Krembangan Utara", "Nyamplungan", "Perak Timur", "Perak Utara"],
        "semampir": ["Ampel", "Pegirian", "Sidotopo", "Ujung", "Wonokusumo"],
        "kenjeran": ["Bulak Banteng", "Tambak Wedi", "Tanah Kali Kedinding", "Sidotopo Wetan"],
        "bulak": ["Bulak", "Kedung Cowek", "Kenjeran", "Sukolilo Baru"]
    };

    function syncKelurahanFilter(kecId, kelId, defaultText) {
        const kecEl = document.getElementById(kecId);
        const kelEl = document.getElementById(kelId);
        if (!kecEl || !kelEl) return;

        const rawKec = (kecEl.options[kecEl.selectedIndex]?.text || kecEl.value || '').trim().toLowerCase();
        const cleanKec = rawKec.replace('kecamatan', '').trim();
        const isSemua = (!cleanKec || cleanKec === 'semua' || cleanKec.includes('semua'));
        
        let listKel = [];

        if (!isSemua && PETA_WILAYAH_SURABAYA[cleanKec]) {
            listKel = PETA_WILAYAH_SURABAYA[cleanKec];
        }

        const uniqueSorted = [...new Set(listKel)].sort((a, b) => a.localeCompare(b, 'id'));
        const esc = s => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

        let html = `<option value="Semua">${defaultText}</option>`;
        uniqueSorted.forEach(nama => {
            html += `<option value="${esc(nama)}">${esc(nama)}</option>`;
        });

        kelEl.innerHTML = html;
        kelEl.value = 'Semua';
        kelEl.disabled = isSemua;

        if (window.jQuery && $(kelEl).data('select2')) {
            $(kelEl).trigger('change.select2');
        }
    }

    let fetchSeq = 0;
    let fetchInFlight = false;

    function fetchDataFromServer(silent = false) {
        if (silent && fetchInFlight) return;
        fetchInFlight = true;
        const reqId = ++fetchSeq;
        const tbody = document.getElementById('innovation-table-body');
        if (tbody && !silent) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="spinner-border spinner-border-sm text-teal mb-2" role="status"></div>
                        <div class="text-muted small fw-semibold">Memuat data dari server...</div>
                    </td>
                </tr>
            `;
        }

        const url = "{{ route('inovasi.global.getData') ?? url('/inovasi/global/get-data') }}";

        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(res => {
            if (reqId !== fetchSeq) return;
            if (res.status === 'success' && Array.isArray(res.data)) {
                inovasiData = res.data.map(item => ({
                    id: item.ref,
                    tanggal: item.tanggal_entry || '',
                    nama: item.nama_inovasi || '',
                    id_kec: item.id_kec || '',
                    kecamatan: item.nama_kec || '-',
                    id_kel: item.id_kel || '',
                    kelurahan: item.nama_kel || '-',
                    deskripsi: item.deskripsi_inovasi || '',
                    file: item.file_dokumen ? item.file_dokumen.split('/').pop() : '',
                    pdfUrl: formatAssetUrl(item.file_dokumen),
                    foto1: formatAssetUrl(item.foto_1),
                    foto2: formatAssetUrl(item.foto_2),
                    periode: item.periode || '2026',
                    keterangan: item.keterangan || (item.pokja ? item.pokja + ' - Kota Surabaya' : '-'),
                    dibuatOleh: item.creator_name || item.dibuat_oleh || 'Kader PKK',
                    pokja: item.pokja || 'POKJA 3'
                }));
            } else if (!silent) {
                inovasiData = [];
            }
            if (!silent) {
                syncKelurahanFilter('dash-filter-kecamatan', 'dash-filter-kelurahan', 'Semua kelurahan');
                syncKelurahanFilter('table-filter-kecamatan', 'table-filter-kelurahan', 'Pilih Kelurahan');
            }
            updateDashboardCounters();
            renderCustomTable();
        })
        .catch(err => {
            console.error(err);
            if (silent) return;
            inovasiData = [];
            renderCustomTable();
        })
        .finally(() => {
            fetchInFlight = false;
        });
    }

    function toDisplayDateFormat(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3 && parts[0].length === 4) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    function toInputDateFormat(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        if (parts.length === 3 && parts[0].length === 2) {
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }
        return dateStr;
    }

    function updateDashboardCounters() {
        const selKec = (document.getElementById('dash-filter-kecamatan')?.value || 'Semua').toLowerCase();
        const selKel = (document.getElementById('dash-filter-kelurahan')?.value || 'Semua').toLowerCase();
        const selPeriode = (document.getElementById('dash-filter-periode')?.value || 'Semua').toLowerCase();

        let counts = { sekretaris: 0, pokja1: 0, pokja2: 0, pokja3: 0, pokja4: 0 };

        inovasiData.forEach(item => {
            const itemKec = (item.kecamatan || '').toString().toLowerCase();
            const itemIdKec = (item.id_kec || '').toString().toLowerCase();
            const itemKel = (item.kelurahan || '').toString().toLowerCase();
            const itemIdKel = (item.id_kel || '').toString().toLowerCase();
            const itemPeriode = (item.periode || '').toString().toLowerCase();

            const matchKec = (selKec === 'semua' || itemKec === selKec || itemIdKec === selKec);
            const matchKel = (selKel === 'semua' || itemKel === selKel || itemIdKel === selKel);
            const matchPeriode = (selPeriode === 'semua' || itemPeriode === selPeriode);

            if (matchKec && matchKel && matchPeriode) {
                const pokja = (item.pokja || '').toUpperCase();
                if (pokja.includes('SEKRETARIS')) counts.sekretaris++;
                else if (pokja.includes('1')) counts.pokja1++;
                else if (pokja.includes('2')) counts.pokja2++;
                else if (pokja.includes('3')) counts.pokja3++;
                else if (pokja.includes('4')) counts.pokja4++;
            }
        });

        const total = counts.sekretaris + counts.pokja1 + counts.pokja2 + counts.pokja3 + counts.pokja4;

        const setElText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val;
        };

        setElText('stat-count-sekretaris', counts.sekretaris);
        setElText('stat-count-pokja1', counts.pokja1);
        setElText('stat-count-pokja2', counts.pokja2);
        setElText('stat-count-pokja3', counts.pokja3);
        setElText('stat-count-pokja4', counts.pokja4);
        setElText('stat-total-badge', `Total: ${total} Inovasi`);

        const getPercent = (val) => (total > 0 ? (val / total) * 100 : 0);

        const setBar = (barId, valId, val) => {
            const bar = document.getElementById(barId);
            const text = document.getElementById(valId);
            if (bar) bar.style.width = getPercent(val) + '%';
            if (text) text.innerText = val;
        };

        setBar('bar-sekretaris', 'val-sekretaris', counts.sekretaris);
        setBar('bar-pokja1', 'val-pokja1', counts.pokja1);
        setBar('bar-pokja2', 'val-pokja2', counts.pokja2);
        setBar('bar-pokja3', 'val-pokja3', counts.pokja3);
        setBar('bar-pokja4', 'val-pokja4', counts.pokja4);
    }

    function openDetailPokjaModal(pokjaKey) {
        const titleEl = document.getElementById('modal-detail-pokja-title');
        const tbody = document.getElementById('detail-pokja-table-body');
        if (!tbody) return;

        const displayPokjaName = pokjaKey.toUpperCase().includes('SEKRETARIS') ? 'Sekretaris' : pokjaKey.toUpperCase();
        if (titleEl) {
            titleEl.innerText = `Detail Inovasi - ${displayPokjaName}`;
        }

        const selKec = (document.getElementById('dash-filter-kecamatan')?.value || 'Semua').toLowerCase();
        const selKel = (document.getElementById('dash-filter-kelurahan')?.value || 'Semua').toLowerCase();
        const selPeriode = (document.getElementById('dash-filter-periode')?.value || 'Semua').toLowerCase();

        const filtered = inovasiData.filter(item => {
            const itemKec = (item.kecamatan || '').toString().toLowerCase();
            const itemIdKec = (item.id_kec || '').toString().toLowerCase();
            const itemKel = (item.kelurahan || '').toString().toLowerCase();
            const itemIdKel = (item.id_kel || '').toString().toLowerCase();
            const itemPeriode = (item.periode || '').toString().toLowerCase();
            const itemPokja = (item.pokja || '').toUpperCase();

            const matchKec = (selKec === 'semua' || itemKec === selKec || itemIdKec === selKec);
            const matchKel = (selKel === 'semua' || itemKel === selKel || itemIdKel === selKel);
            const matchPeriode = (selPeriode === 'semua' || itemPeriode === selPeriode);

            let matchPokja = false;
            if (pokjaKey.toUpperCase().includes('SEKRETARIS')) {
                matchPokja = itemPokja.includes('SEKRETARIS');
            } else {
                const num = pokjaKey.replace(/\D/g, '');
                matchPokja = itemPokja.includes(num);
            }

            return matchKec && matchKel && matchPeriode && matchPokja;
        });

        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted small fw-semibold">
                        <i class="fa-solid fa-folder-open text-muted fs-3 d-block mb-2"></i>
                        Belum ada data inovasi untuk ${displayPokjaName}.
                    </td>
                </tr>
            `;
        } else {
            tbody.innerHTML = filtered.map((item, idx) => `
                <tr>
                    <td class="text-center fw-bold text-dark">${idx + 1}</td>
                    <td class="fw-bold text-dark">${escapeHtml(item.tanggal)}</td>
                    <td class="fw-bold text-dark">${escapeHtml(item.nama)}</td>
                    <td class="text-dark small" style="max-width: 280px; white-space: normal;">${escapeHtml(item.deskripsi)}</td>
                    <td class="text-center fw-bold text-dark">${escapeHtml(item.periode)}</td>
                    <td class="text-center text-dark fw-semibold">${escapeHtml(item.keterangan)}</td>
                    <td class="fw-semibold text-dark">${escapeHtml(item.dibuatOleh)}</td>
                </tr>
            `).join('');
        }

        const modalEl = document.getElementById('modal-detail-pokja');
        if (modalEl) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    }

    function renderCustomTable(resetPage = false) {
        const tbody = document.getElementById('innovation-table-body');
        if (!tbody) return;

        if (resetPage) currentPage = 1;

        const searchInput = document.getElementById('search-inovasi-input');
        const q = (searchInput ? searchInput.value : '').toLowerCase().trim();
        const limit = parseInt(document.getElementById('entries-per-page')?.value || '10');

        const filterKec = (document.getElementById('table-filter-kecamatan')?.value || 'Semua').toLowerCase();
        const filterKel = (document.getElementById('table-filter-kelurahan')?.value || 'Semua').toLowerCase();
        const filterPeriode = (document.getElementById('table-filter-periode')?.value || 'Semua').toLowerCase();

        const filtered = inovasiData.filter(item => {
            const namaVal    = (item.nama || item.nama_inovasi || '').toString().toLowerCase();
            const deskVal    = (item.deskripsi || item.deskripsi_inovasi || '').toString().toLowerCase();
            const ketVal     = (item.keterangan || '').toString().toLowerCase();
            const userVal    = (item.dibuatOleh || item.dibuat_oleh || item.creator_name || '').toString().toLowerCase();
            const kecVal     = (item.kecamatan || item.nama_kec || '').toString().toLowerCase();
            const idKecVal   = (item.id_kec || '').toString().toLowerCase();
            const kelVal     = (item.kelurahan || item.nama_kel || '').toString().toLowerCase();
            const idKelVal   = (item.id_kel || '').toString().toLowerCase();
            const periodeVal = (item.periode || '').toString().toLowerCase();
            const tglVal     = (item.tanggal || '').toString().toLowerCase();
            const pokjaVal   = (item.pokja || '').toString().toLowerCase();

            const haystack = [namaVal, deskVal, ketVal, userVal, kecVal, kelVal, periodeVal, tglVal, pokjaVal]
                                .join(' ')
                                .replace(/\s+/g, ' ');
            const matchSearch = (q === '') || q.split(/\s+/).every(word => haystack.includes(word));

            const matchKec = (filterKec === 'semua') || (idKecVal === filterKec) || (kecVal === filterKec);
            const matchKel = (filterKel === 'semua') || (idKelVal === filterKel) || (kelVal === filterKel);
            const matchPeriode = (filterPeriode === 'semua') || (periodeVal === filterPeriode);

            return matchSearch && matchKec && matchKel && matchPeriode;
        });

        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / limit));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * limit;
        const rows = filtered.slice(start, start + limit);

        if (rows.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <i class="fa-solid fa-folder-open text-muted fs-3 d-block mb-2"></i>
                        Belum ada data inovasi yang sesuai.
                    </td>
                </tr>`;
            document.getElementById('table-info-label').innerText = 'Showing 0 to 0 of 0 entries';
            renderPagination(0);
            return;
        }

        tbody.innerHTML = rows.map((item, idx) => {
            const pdfBtn = (item.pdfUrl && item.pdfUrl !== '#')
                ? `<button type="button" class="btn btn-outline-danger btn-preview-pdf btn-preview-media shadow-xs"
                        data-type="pdf" data-url="${escapeHtml(item.pdfUrl)}" data-title="${escapeHtml('Dokumen: ' + item.nama)}">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                   </button>`
                : `<span class="text-muted small">-</span>`;

            const fotoThumb1 = item.foto1
                ? `<a href="javascript:void(0)" class="d-inline-block me-1 btn-preview-media"
                      data-type="img" data-url="${escapeHtml(item.foto1)}" data-title="${escapeHtml('Foto 1 - ' + item.nama)}">
                      <img src="${escapeHtml(item.foto1)}" class="img-table-thumb shadow-xs" alt="Foto 1" title="Lihat Foto 1">
                   </a>`
                : '';
            const fotoThumb2 = item.foto2
                ? `<a href="javascript:void(0)" class="d-inline-block btn-preview-media"
                      data-type="img" data-url="${escapeHtml(item.foto2)}" data-title="${escapeHtml('Foto 2 - ' + item.nama)}">
                      <img src="${escapeHtml(item.foto2)}" class="img-table-thumb shadow-xs" alt="Foto 2" title="Lihat Foto 2">
                   </a>`
                : '';

            return `
                <tr>
                    <td class="text-center fw-bold text-dark">${start + idx + 1}</td>
                    <td class="fw-bold text-dark">${escapeHtml(item.tanggal)}</td>
                    <td class="fw-bold text-dark">${escapeHtml(item.nama)}</td>
                    <td class="text-dark small" style="max-width: 250px; white-space: normal;">${escapeHtml(item.deskripsi)}</td>
                    <td class="text-center">${pdfBtn}</td>
                    <td class="text-center">
                        ${fotoThumb1}${fotoThumb2}
                        ${(!item.foto1 && !item.foto2) ? '<span class="text-muted small">-</span>' : ''}
                    </td>
                    <td class="text-center fw-bold text-dark">${escapeHtml(item.periode)}</td>
                    <td class="text-center text-dark fw-semibold">${escapeHtml(item.keterangan)}</td>
                    <td class="fw-semibold text-dark">${escapeHtml(item.dibuatOleh)}</td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                            <button type="button" class="btn-icon-square-edit btn-edit-item" data-id="${escapeHtml(item.id)}" title="Edit Data">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </button>
                            <button type="button" class="btn-icon-square-delete btn-delete-item" data-id="${escapeHtml(item.id)}" title="Hapus Data">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        const from = total ? start + 1 : 0;
        const to = Math.min(start + limit, total);
        document.getElementById('table-info-label').innerText = `Showing ${from} to ${to} of ${total} entries`;
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const ul = document.getElementById('table-pagination-list');
        if (!ul) return;

        const pages = Math.max(1, totalPages);
        let html = `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" data-page="${currentPage - 1}">&lt;</a>
            </li>
        `;

        for (let p = 1; p <= pages; p++) {
            html += `
                <li class="page-item ${p === currentPage ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" data-page="${p}">${p}</a>
                </li>
            `;
        }

        html += `
            <li class="page-item ${currentPage >= pages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" data-page="${currentPage + 1}">&gt;</a>
            </li>
        `;

        ul.innerHTML = html;
    }

    function showModalInovasi() {
        const modalEl = document.getElementById('modal-form-inovasi');
        if (!modalEl) return;
        document.getElementById('modal-alert-box').classList.add('d-none');
        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }

    function hideModalInovasi() {
        const modalEl = document.getElementById('modal-form-inovasi');
        if (!modalEl) return;
        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        } else if (window.jQuery) {
            $(modalEl).modal('hide');
        }
    }

    function showModalDelete(id, nama) {
        document.getElementById('delete-target-id').value = id;
        document.getElementById('delete-item-title').innerText = `"${nama}"`;
        const modalEl = document.getElementById('modal-confirm-delete');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }

    function hideModalDelete() {
        const modalEl = document.getElementById('modal-confirm-delete');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        } else if (window.jQuery) {
            $(modalEl).modal('hide');
        }
    }

    function setPreviewBox(num, src) {
        const img = document.getElementById(`img-preview-${num}`);
        const text = document.getElementById(`text-preview-${num}`);
        const btnRemove = document.getElementById(`btn-remove-foto-${num}`);
        if (src) {
            img.src = src;
            img.classList.remove('d-none');
            text.classList.add('d-none');
            btnRemove?.classList.remove('d-none');
        } else {
            img.src = '';
            img.classList.add('d-none');
            text.classList.remove('d-none');
            btnRemove?.classList.add('d-none');
        }
    }

    function setPreviewPdf(name, sizeStr) {
        const box = document.getElementById('pdf-preview-box');
        const nameEl = document.getElementById('pdf-preview-name');
        const sizeEl = document.getElementById('pdf-preview-size');
        const label = document.getElementById('label-dokumen-pdf');

        if (name) {
            nameEl.innerText = name;
            sizeEl.innerText = sizeStr ? `(${sizeStr})` : '';
            box.classList.remove('d-none');
            label.innerText = name;
        } else {
            nameEl.innerText = '';
            sizeEl.innerText = '';
            box.classList.add('d-none');
            label.innerText = 'Belum ada PDF dipilih';
        }
    }

    function openModalTambah() {
        document.getElementById('form-submit-inovasi').reset();
        resetRemoveFlags();
        resetFileInputs();
        document.getElementById('entry-index-id').value = '-1';
        document.getElementById('modal-form-title').innerText = 'Tambah Data Inovasi';
        document.getElementById('label-foto-1').innerText = 'Belum ada foto';
        document.getElementById('label-foto-2').innerText = 'Belum ada foto';
        document.getElementById('form-input-tanggal').value = new Date().toISOString().split('T')[0];
        currentFoto1 = '';
        currentFoto2 = '';
        currentPdfUrl = '';
        currentPdfName = '';
        setPreviewBox(1, '');
        setPreviewBox(2, '');
        setPreviewPdf('', '');
        showModalInovasi();
    }

    function openModalEdit(id) {
        const item = inovasiData.find(d => d.id == id);
        if (!item) return;

        resetRemoveFlags();
        resetFileInputs();

        document.getElementById('entry-index-id').value = item.id;
        document.getElementById('modal-form-title').innerText = 'Edit Data Inovasi';
        document.getElementById('form-input-tanggal').value = toInputDateFormat(item.tanggal);
        document.getElementById('form-input-pokja').value = item.pokja || 'POKJA 3';
        const kecEl = document.getElementById('form-input-kecamatan');
        kecEl.value = '';
        [...kecEl.options].forEach(o => {
            if (o.value === String(item.id_kec) || o.text.trim().toLowerCase() === String(item.kecamatan).trim().toLowerCase()) {
                kecEl.value = o.value;
            }
        });
        document.getElementById('form-input-dibuat').value = item.dibuatOleh;
        document.getElementById('form-input-nama').value = item.nama;
        document.getElementById('form-input-deskripsi').value = item.deskripsi;
        
        currentFoto1 = item.foto1 || '';
        currentFoto2 = item.foto2 || '';
        setPreviewBox(1, currentFoto1);
        setPreviewBox(2, currentFoto2);
        document.getElementById('label-foto-1').innerText = currentFoto1 ? 'Foto 1 tersimpan' : 'Belum ada foto';
        document.getElementById('label-foto-2').innerText = currentFoto2 ? 'Foto 2 tersimpan' : 'Belum ada foto';

        currentPdfUrl = item.pdfUrl || '';
        currentPdfName = item.file || '';
        if (currentPdfName) {
            setPreviewPdf(currentPdfName, 'Tersimpan');
        } else {
            setPreviewPdf('', '');
        }

        showModalInovasi();
    }

    function switchTab(tab) {
        const viewDash = document.getElementById('view-inovasi-dashboard');
        const viewInp = document.getElementById('view-inovasi-input');
        const btnDash = document.getElementById('btn-tab-dashboard');
        const btnInp = document.getElementById('btn-tab-input');

        if (!viewDash || !viewInp) return;

        if (tab === 'dashboard') {
            viewDash.style.setProperty('display', 'flex', 'important');
            viewInp.style.setProperty('display', 'none', 'important');
            btnDash?.classList.add('active');
            btnInp?.classList.remove('active');
            updateDashboardCounters();
        } else {
            viewDash.style.setProperty('display', 'none', 'important');
            viewInp.style.setProperty('display', 'flex', 'important');
            btnInp?.classList.add('active');
            btnDash?.classList.remove('active');
            renderCustomTable(true);
        }
    }

    function handleSimpanInovasi() {
        const alertBox = document.getElementById('modal-alert-box');
        const alertMsg = document.getElementById('modal-alert-msg');
        alertBox.classList.add('d-none');

        const formElement = document.getElementById('form-submit-inovasi');
        const formData = new FormData(formElement);

        const btnSubmit = document.getElementById('btn-submit-modal');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';

        const storeUrl = "{{ route('inovasi.global.store') ?? url('/inovasi/global/store') }}";

        fetch(storeUrl, {
            method: 'POST',
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(res => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Simpan';

            if (res.status === 'success') {
                notifyToast(res.message || 'Data inovasi berhasil disimpan!');
                hideModalInovasi();
                fetchDataFromServer();
            } else {
                alertMsg.innerText = res.message || 'Terjadi kesalahan saat menyimpan data.';
                alertBox.classList.remove('d-none');
            }
        })
        .catch(err => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Simpan Inovasi';
            alertMsg.innerText = 'Gagal terhubung ke server database.';
            alertBox.classList.remove('d-none');
        });
    }

    function handleHapusInovasi() {
        const id = document.getElementById('delete-target-id').value;
        const btnDelete = document.getElementById('btn-execute-delete');

        if (!id || id === '-1') return;

        btnDelete.disabled = true;
        btnDelete.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menghapus...';

        const deleteUrl = "{{ route('inovasi.global.destroy') }}";

        const fd = new FormData();
        fd.append('id', id);
        fd.append('_method', 'DELETE');
        fd.append('_token', "{{ csrf_token() }}");

        fetch(deleteUrl, {
            method: 'POST',
            body: fd,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        })
        .then(async res => {
            const json = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(json.message || `HTTP status ${res.status}`);
            }
            return json;
        })
        .then(res => {
            btnDelete.disabled = false;
            btnDelete.innerHTML = '<i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus';
            hideModalDelete();

            if (res.status === 'success') {
                notifyToast(res.message || 'Data berhasil dihapus.');
                fetchDataFromServer();
            } else {
                notifyToast(res.message || 'Gagal menghapus data.', false);
            }
        })
        .catch(err => {
            btnDelete.disabled = false;
            btnDelete.innerHTML = '<i class="fa-solid fa-trash me-1 text-white"></i> Ya, Hapus';
            hideModalDelete();
            console.error('Error delete:', err);
            notifyToast(err.message || 'Gagal menghapus data.', false);
        });
    }

    document.addEventListener('click', function (e) {
        const pokjaCard = e.target.closest('.card-pokja-clickable');
        if (pokjaCard) {
            e.preventDefault();
            const pokja = pokjaCard.getAttribute('data-pokja');
            if (pokja) openDetailPokjaModal(pokja);
            return;
        }

        if (e.target.closest('#btn-tab-dashboard')) {
            e.preventDefault();
            switchTab('dashboard');
        } else if (e.target.closest('#btn-tab-input')) {
            e.preventDefault();
            switchTab('input');
        } else if (e.target.closest('#btn-tambah-data-modal')) {
            e.preventDefault();
            openModalTambah();
        } else if (e.target.closest('#btn-close-modal') || e.target.closest('#btn-batal-modal')) {
            e.preventDefault();
            hideModalInovasi();
        } else if (e.target.closest('#btn-submit-modal')) {
            e.preventDefault();
            handleSimpanInovasi();
        } else if (e.target.closest('#btn-pilih-foto-1')) {
            e.preventDefault();
            document.getElementById('file-foto-1').click();
        } else if (e.target.closest('#btn-pilih-foto-2')) {
            e.preventDefault();
            document.getElementById('file-foto-2').click();
        } else if (e.target.closest('#btn-pilih-dokumen')) {
            e.preventDefault();
            document.getElementById('file-dokumen-pdf').click();
        } else if (e.target.closest('#btn-remove-pdf')) {
            e.preventDefault();
            document.getElementById('file-dokumen-pdf').value = '';
            document.getElementById('remove-file-dokumen').value = '1';
            currentPdfUrl = '';
            currentPdfName = '';
            setPreviewPdf('', '');
        } else if (e.target.closest('.btn-remove-foto')) {
            e.preventDefault();
            removeFoto(e.target.closest('.btn-remove-foto').getAttribute('data-num'));
        } else if (e.target.closest('.btn-preview-media')) {
            e.preventDefault();
            const b = e.target.closest('.btn-preview-media');
            openPreviewModal(b.dataset.type, b.dataset.url, b.dataset.title);
        } else if (e.target.closest('.btn-edit-item')) {
            e.preventDefault();
            openModalEdit(e.target.closest('.btn-edit-item').getAttribute('data-id'));
        } else if (e.target.closest('.btn-delete-item')) {
            e.preventDefault();
            const id = e.target.closest('.btn-delete-item').getAttribute('data-id');
            const item = inovasiData.find(d => d.id == id);
            if (item) {
                showModalDelete(id, item.nama);
            }
        } else if (e.target.closest('#btn-cancel-delete')) {
            e.preventDefault();
            hideModalDelete();
        } else if (e.target.closest('#btn-execute-delete')) {
            e.preventDefault();
            handleHapusInovasi();
        } else if (e.target.closest('#table-pagination-list a[data-page]')) {
            e.preventDefault();
            const page = parseInt(e.target.closest('a[data-page]').getAttribute('data-page'));
            if (page && page !== currentPage) {
                currentPage = page;
                renderCustomTable();
            }
        }
    });

    document.addEventListener('change', function (e) {
        const allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (e.target.id === 'dash-filter-kecamatan') {
            syncKelurahanFilter('dash-filter-kecamatan', 'dash-filter-kelurahan', 'Semua kelurahan');
            updateDashboardCounters();
            return;
        }
        if (e.target.id === 'table-filter-kecamatan') {
            syncKelurahanFilter('table-filter-kecamatan', 'table-filter-kelurahan', 'Pilih Kelurahan');
            renderCustomTable(true);
            return;
        }
        if (['dash-filter-kelurahan', 'dash-filter-periode'].includes(e.target.id)) {
            updateDashboardCounters();
            return;
        }
        if (['table-filter-kelurahan', 'table-filter-periode', 'entries-per-page'].includes(e.target.id)) {
            renderCustomTable(true);
            return;
        }

        if (e.target.id === 'file-foto-1') {
            const file = e.target.files[0];
            if (file) {
                if (!allowedImageTypes.includes(file.type)) {
                    notifyToast('Format Foto 1 tidak sesuai! Gunakan JPG, PNG, atau WEBP.', false);
                    e.target.value = '';
                    setPreviewBox(1, '');
                    document.getElementById('label-foto-1').innerText = 'Belum ada foto';
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran Foto 1 melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewBox(1, '');
                    document.getElementById('label-foto-1').innerText = 'Belum ada foto';
                    return;
                }
                document.getElementById('label-foto-1').innerText = file.name;
                const reader = new FileReader();
                reader.onload = (evt) => setPreviewBox(1, evt.target.result);
                reader.readAsDataURL(file);
            }
        } 
        else if (e.target.id === 'file-foto-2') {
            const file = e.target.files[0];
            if (file) {
                if (!allowedImageTypes.includes(file.type)) {
                    notifyToast('Format Foto 2 tidak sesuai! Gunakan JPG, PNG, atau WEBP.', false);
                    e.target.value = '';
                    setPreviewBox(2, '');
                    document.getElementById('label-foto-2').innerText = 'Belum ada foto';
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran Foto 2 melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewBox(2, '');
                    document.getElementById('label-foto-2').innerText = 'Belum ada foto';
                    return;
                }
                document.getElementById('label-foto-2').innerText = file.name;
                const reader = new FileReader();
                reader.onload = (evt) => setPreviewBox(2, evt.target.result);
                reader.readAsDataURL(file);
            }
        } 
        else if (e.target.id === 'file-dokumen-pdf') {
            const file = e.target.files[0];
            if (file) {
                if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                    notifyToast('Format berkas harus berupa dokumen .PDF!', false);
                    e.target.value = '';
                    setPreviewPdf('', '');
                    return;
                }
                if (file.size > MAX_FILE_SIZE_BYTES) {
                    notifyToast('Ukuran dokumen PDF melebihi batas 2 MB!', false);
                    e.target.value = '';
                    setPreviewPdf('', '');
                    return;
                }
                const sizeKb = Math.round(file.size / 1024) + ' KB';
                currentPdfName = file.name;
                currentPdfUrl = URL.createObjectURL(file);
                setPreviewPdf(file.name, sizeKb);
            }
        }
    });

    document.addEventListener('change', function (e) {
        const map = {
            'file-foto-1': 'remove-foto-1',
            'file-foto-2': 'remove-foto-2',
            'file-dokumen-pdf': 'remove-file-dokumen'
        };
        if (map[e.target.id] && e.target.files && e.target.files.length) {
            document.getElementById(map[e.target.id]).value = '0';
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target.id === 'search-inovasi-input') {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                renderCustomTable(true);
            }, 120);
        }
    });

    document.addEventListener('keyup', function (e) {
        if (e.target.id === 'search-inovasi-input') {
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                renderCustomTable(true);
            }, 120);
        }
    });

    document.addEventListener('search', function (e) {
        if (e.target.id === 'search-inovasi-input') {
            renderCustomTable(true);
        }
    });

    const AUTO_REFRESH_MS = 30000; 
    function isAnyModalOpen() {
        return !!document.querySelector('.modal.show');
    }
    setInterval(function () {
        if (document.hidden || isAnyModalOpen()) return;
        fetchDataFromServer(true);
    }, AUTO_REFRESH_MS);

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden && !isAnyModalOpen()) {
            fetchDataFromServer(true);
        }
    });

    fetchDataFromServer();
</script>
@endsection