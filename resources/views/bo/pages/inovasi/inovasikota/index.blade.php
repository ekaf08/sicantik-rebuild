@extends('bo.layout.app')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">

        <style>
            /* 1. Banner Tosca Elegan */
            .banner-inovasi-kota {
                background: linear-gradient(135deg, #0b5e57 0%, #0d6e66 50%, #084943 100%) !important;
                position: relative;
                overflow: hidden;
                border-radius: 1.25rem !important;
                border: none !important;
                box-shadow: 0 10px 25px -5px rgba(11, 94, 87, 0.35);
                min-height: 200px;
                display: flex;
                align-items: center;
            }

            /* Pola Grid Titik-titik Halus */
            .banner-inovasi-kota::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: radial-gradient(rgba(255, 255, 255, 0.16) 1.2px, transparent 1.2px);
                background-size: 22px 22px;
                pointer-events: none;
                z-index: 1;
            }

            /* Siluet Grafis Kota & Landmark di Sudut Kanan Bawah */
            .banner-siluet-kota {
                position: absolute;
                right: 0;
                bottom: 0;
                height: 100%;
                max-height: 180px;
                opacity: 0.55;
                pointer-events: none;
                z-index: 1;
            }

            /* Form Filter Dropdown */
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

            /* Card Placeholder Putihan Bersih */
            .empty-detail-clean {
                max-width: 420px;
                margin: 0 auto;
                padding: 1rem;
                text-align: center;
            }
        </style>

        <div class="d-flex flex-column gap-5 w-100 py-2">

            <!-- 1. Header Banner Inovasi Kota -->
            <div class="card banner-inovasi-kota mb-2">
                <svg class="banner-siluet-kota" viewBox="0 0 450 180" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M280 180 L310 40 L315 40 L345 180 Z" fill="#2dd4bf" />
                    <path d="M312 15 L314 15 L314 40 L312 40 Z" fill="#2dd4bf" />
                    <path d="M340 180 L340 100 L355 100 L355 180 Z" fill="#14b8a6" />
                    <path d="M358 180 L358 80 L378 80 L378 180 Z" fill="#0d9488" />
                    <path d="M382 180 L382 110 L400 110 L400 180 Z" fill="#14b8a6" />
                    <path d="M360 180 C390 110 420 90 460 80 L460 180 Z" fill="#0f766e" />
                    <path d="M390 180 C410 130 435 110 460 105 L460 180 Z" fill="#115e59" />
                </svg>

                <div class="card-body p-4 p-md-5 d-flex flex-column justify-content-center position-relative w-100" style="z-index: 2;">
                    <h2 class="fw-bolder text-white mb-2 text-uppercase tracking-wide" style="font-size: 2.1rem; letter-spacing: 0.5px;">
                        INOVASI KOTA
                    </h2>
                    <span class="fw-semibold" style="color: #e6fffa; font-size: 1.05rem;">
                        Data Inovasi Kota
                    </span>
                </div>
            </div>

            <!-- 2. Filter Dropdown Pokja & Inovasi -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label for="select-filter-pokja" class="label-filter-custom">Pilih Pokja</label>
                            <select id="select-filter-pokja" class="form-select form-select-custom" onchange="handlePokjaChange()">
                                <option value="semua" selected>Semua</option>
                                <option value="sekretaris">Sekretaris</option>
                                <option value="pokja 1">Pokja 1</option>
                                <option value="pokja 2">Pokja 2</option>
                                <option value="pokja 3">Pokja 3</option>
                                <option value="pokja 4">Pokja 4</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="select-filter-inovasi" class="label-filter-custom">Pilih Inovasi</label>
                            <select id="select-filter-inovasi" class="form-select form-select-custom" onchange="handleInovasiChange()">
                                <option value="" selected disabled>Pilih salah satu inovasi...</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Area Konten Detail Inovasi -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body py-5 px-4">

                    <!-- State 1: Placeholder Putihan Bersih Sesuai Teks Saja -->
                    <div id="state-placeholder-empty" class="empty-detail-clean">
                        <p class="text-muted fw-semibold mb-0" style="font-size: 0.95rem;">
                            Silakan pilih inovasi untuk menampilkan detail
                        </p>
                    </div>

                    <!-- State 2: Wadah Render Konten Terpisah (File Sejajar) -->
                    <div id="state-detail-content" class="d-none">

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
    <!--end::Content container-->
</div>
<!--end::Content-->

<script>
    // Data list inovasi kota dengan key slug untuk pemanggilan file blade
    const daftarInovasiKota = [
        { key: 'elearning-puspaga', pokja: 'pokja 1', title: 'E-learning Puspaga PKK' },
        { key: 'kemanggi', pokja: 'pokja 1', title: 'Kemanggi (Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri)' },
        { key: 'selantang', pokja: 'pokja 2', title: 'Selantang' },
        { key: 'soth', pokja: 'pokja 2', title: 'SOTH (Sekolah Orang Tua Hebat)' },
        { key: 'empty-sekretaris', pokja: 'sekretaris', title: 'Data Inovasi tidak ditemukan' },
        { key: 'makan-ketan', pokja: 'pokja 3', title: 'Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan)' },
        { key: 'pisang-danor', pokja: 'pokja 3', title: 'Pisang Danor (Pilah Sampah Anorganik dan Organik)' },
        { key: 'pmt', pokja: 'pokja 3', title: 'PMT (Pemberian Makanan Tambahan)' },
        { key: 'pendampingan-bumil', pokja: 'pokja 4', title: 'Inovasi Pendampingan Ibu Hamil dan Ibu Hamil Resti' },
        { key: 'kampung-asi', pokja: 'pokja 4', title: 'Kampung ASI' },
        { key: 'surabaya-emas', pokja: 'pokja 4', title: 'Surabaya Emas' }
    ];

    function populateInovasiOptions(selectedPokja = 'semua') {
        const inovasiSelect = document.getElementById('select-filter-inovasi');
        if (!inovasiSelect) return;

        inovasiSelect.innerHTML = '';

        // Kasus khusus Sekretaris: Otomatis terpilih dan disabled
        if (selectedPokja.toLowerCase() === 'sekretaris') {
            const opt = document.createElement('option');
            opt.value = "empty-sekretaris";
            opt.textContent = "Data Inovasi tidak ditemukan";
            opt.selected = true;
            opt.disabled = true;
            inovasiSelect.appendChild(opt);
            return;
        }

        // Placeholder default untuk Pokja lainnya
        const defaultOpt = document.createElement('option');
        defaultOpt.value = "";
        defaultOpt.textContent = "Pilih salah satu inovasi...";
        defaultOpt.selected = true;
        defaultOpt.disabled = true;
        inovasiSelect.appendChild(defaultOpt);

        const filtered = daftarInovasiKota.filter(item => {
            if (item.pokja.toLowerCase() === 'sekretaris') return false;
            return selectedPokja === 'semua' || item.pokja.toLowerCase() === selectedPokja.toLowerCase();
        });

        filtered.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.key;
            opt.textContent = item.title;
            inovasiSelect.appendChild(opt);
        });
    }

    function handlePokjaChange() {
        const selectedPokja = document.getElementById('select-filter-pokja').value;
        populateInovasiOptions(selectedPokja);
        resetDetailState();
    }

    function handleInovasiChange() {
        const selectedKey = document.getElementById('select-filter-inovasi').value;
        const emptyState = document.getElementById('state-placeholder-empty');
        const detailState = document.getElementById('state-detail-content');

        // Sembunyikan semua partial inovasi terlebih dahulu
        document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));

        if (selectedKey && selectedKey !== 'empty-sekretaris') {
            emptyState.classList.add('d-none');
            detailState.classList.remove('d-none');

            // Tampilkan komponen blade yang sesuai key
            const activeContent = document.getElementById('content-' + selectedKey);
            if (activeContent) {
                activeContent.classList.remove('d-none');
            }
        } else {
            resetDetailState();
        }
    }

    function resetDetailState() {
        const emptyState = document.getElementById('state-placeholder-empty');
        const detailState = document.getElementById('state-detail-content');

        if (emptyState && detailState) {
            emptyState.classList.remove('d-none');
            detailState.classList.add('d-none');
            document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateInovasiOptions('semua');
    });
</script>
@endsection
