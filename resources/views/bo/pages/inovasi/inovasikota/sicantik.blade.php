<!-- Banner atas Si Cantik: otomatis naik menggantikan banner hijau "Inovasi Kota" saat submenu ini dipilih -->
<style>
    /* Banner atas Si Cantik: merah muda dusty, naik menggantikan banner hijau saat submenu ini dipilih */
    .sc-hero { position: relative; overflow: hidden; display: flex; align-items: center; min-height: 210px; padding: 2rem 2.5rem; margin-bottom: .5rem; border-radius: 1rem; background: #fbeaf0; }
    .sc-hero-text { position: relative; z-index: 2; max-width: 52%; }
    .sc-hero-label { display: block; margin-bottom: .5rem; font-size: .72rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: #d0678f; }
    .sc-hero-title { margin: 0 0 .4rem; font-size: 2.1rem; font-weight: 800; line-height: 1.15; color: #5a2740; }
    .sc-hero-sub { margin: 0; font-size: .95rem; font-weight: 500; line-height: 1.5; color: #8a5069; }
    .sc-hero-art { position: absolute; right: 0; bottom: 0; height: 100%; width: auto; max-width: 58%; z-index: 1; pointer-events: none; }
    @media (max-width: 767.98px) {
        .sc-hero { padding: 1.5rem; min-height: 170px; }
        .sc-hero-title { font-size: 1.6rem; }
        .sc-hero-text { max-width: 100%; }
        .sc-hero-art { opacity: .3; max-width: 80%; }
    }

    /* Kartu tabel: mengambang dengan bayangan merah muda lembut */
    .sc-card { border: 1px solid #f3dde6 !important; box-shadow: 0 1px 2px rgba(90, 39, 64, .05), 0 10px 24px -12px rgba(90, 39, 64, .22) !important; }
    .sc-judul { display: flex; align-items: center; gap: .6rem; color: #5a2740 !important; }
    .sc-judul::before { content: ""; width: 10px; height: 10px; border-radius: 50%; background: #d0678f; flex-shrink: 0; }
    .sc-card .border-bottom, .sc-card .border-top { border-color: #f3dde6 !important; }
    .sc-card .table-custom thead th { background-color: #fbeaf0 !important; color: #5a2740 !important; border-color: #f3dde6 !important; }
    .sc-card .table-custom tbody td { border-color: #f6e8ee !important; }
    .sc-card .table-custom tbody tr:hover td { background-color: #fff7fa !important; }
    .sc-card .text-teal { color: #d0678f !important; }
    .sc-card .pagination .page-link { color: #8a5069; border-color: #f3dde6; }
    .sc-card .pagination .page-item.active .page-link { background-color: #c4567f !important; border-color: #c4567f !important; color: #fff !important; }
    .sc-card .pagination .page-link:hover { background-color: #fbeaf0; color: #5a2740; }
</style>

<div id="sc-top-banner" class="sc-hero sub-banner-top d-none">
    <div class="sc-hero-text">
        <span class="sc-hero-label">Inovasi Kota</span>
        <h2 class="sc-hero-title">Si Cantik</h2>
        <p class="sc-hero-sub">Sistem Informasi Pencatatan Kegiatan dan Inovasi PKK Kota Surabaya</p>
    </div>

    <svg class="sc-hero-art" viewBox="0 0 440 210" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMaxYMax meet" aria-hidden="true">
        <path d="M0 210 C10 110 80 40 200 32 C320 24 400 42 440 52 L440 210 Z" fill="#f4dce6"/>
        <circle cx="318" cy="22" r="46" fill="#eecbda" opacity=".6"/>
        <circle cx="46" cy="176" r="14" fill="#eecbda"/>
        <ellipse cx="228" cy="193" rx="196" ry="8" fill="#000" opacity=".07"/>

        <!-- kilau dekor -->
        <path d="M0 -8 L2 -2 L8 0 L2 2 L0 8 L-2 2 L-8 0 L-2 -2 Z" transform="translate(196 58)" fill="#f2c14e"/>
        <path d="M0 -8 L2 -2 L8 0 L2 2 L0 8 L-2 2 L-8 0 L-2 -2 Z" transform="translate(356 46) scale(.7)" fill="#f2c14e"/>
        <circle cx="170" cy="86" r="3.5" fill="#d0678f"/>
        <circle cx="290" cy="52" r="3" fill="#7fa58f"/>

        <!-- papan catatan -->
        <g transform="rotate(-4 157 143)">
            <rect x="120" y="98" width="74" height="90" rx="8" fill="#d9b38c"/>
            <rect x="128" y="108" width="58" height="74" rx="4" fill="#fff"/>
            <rect x="143" y="92" width="28" height="13" rx="4" fill="#8a5069"/>
            <circle cx="139" cy="126" r="4.5" fill="#d0678f"/>
            <rect x="149" y="123" width="29" height="5" rx="2.5" fill="#f0d3de"/>
            <circle cx="139" cy="144" r="4.5" fill="#d0678f"/>
            <rect x="149" y="141" width="24" height="5" rx="2.5" fill="#f0d3de"/>
            <circle cx="139" cy="162" r="4.5" fill="#e9a0b8"/>
            <rect x="149" y="159" width="29" height="5" rx="2.5" fill="#f0d3de"/>
        </g>

        <!-- laptop berisi grafik -->
        <rect x="230" y="72" width="152" height="94" rx="8" fill="#5a2740"/>
        <rect x="238" y="80" width="136" height="78" rx="4" fill="#fff"/>
        <rect x="238" y="80" width="136" height="13" rx="4" fill="#fbeaf0"/>
        <circle cx="246" cy="86.5" r="2.5" fill="#d0678f"/>
        <circle cx="254" cy="86.5" r="2.5" fill="#e9a0b8"/>
        <rect x="250" y="130" width="15" height="22" rx="2" fill="#e9a0b8"/>
        <rect x="271" y="116" width="15" height="36" rx="2" fill="#d0678f"/>
        <rect x="292" y="124" width="15" height="28" rx="2" fill="#e9a0b8"/>
        <rect x="313" y="104" width="15" height="48" rx="2" fill="#c4567f"/>
        <rect x="334" y="112" width="15" height="40" rx="2" fill="#e9a0b8"/>
        <path d="M257 122 L278 108 L299 116 L320 96 L341 104" stroke="#f2c14e" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M214 168 H398 L390 179 H222 Z" fill="#7a3d5a"/>
        <rect x="288" y="168" width="36" height="4" rx="2" fill="#5a2740"/>

        <!-- ponsel -->
        <rect x="396" y="112" width="30" height="58" rx="7" fill="#5a2740"/>
        <rect x="400" y="119" width="22" height="42" rx="3" fill="#fff"/>
        <circle cx="411" cy="134" r="6" fill="#e9a0b8"/>
        <rect x="404" y="146" width="14" height="3.5" rx="1.75" fill="#f0d3de"/>
        <rect x="404" y="153" width="10" height="3.5" rx="1.75" fill="#f0d3de"/>

        <!-- tunas dekor -->
        <g stroke="#7fa58f" stroke-width="2.5" stroke-linecap="round"><path d="M76 188 L76 160"/><path d="M76 174 L67 164"/><path d="M76 168 L85 158"/></g>
    </svg>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4 sc-card">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 border-bottom pb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1 sc-judul">Si Cantik (Sistem Informasi Pencatatan Kegiatan dan Inovasi PKK Kota Surabaya)</h5>
            </div>

        </div>

        <div class="table-custom-wrapper">
            <div class="table-responsive mb-0">
                <table class="table table-custom align-middle mb-0 text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">No <i class="fa-solid fa-angle-up text-secondary ms-1" style="font-size: 0.7rem;"></i></th>
                            <th style="min-width: 180px;">Judul</th>
                            <th style="min-width: 280px;">Deskripsi</th>
                            <th class="text-center" style="width: 120px;">Gambar</th>
                            <th style="min-width: 160px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="table-sicantik-body">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="spinner-border spinner-border-sm text-teal mb-2" role="status"></div>
                                <div class="text-muted small fw-semibold">Memuat data Si Cantik...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-4 mt-1 border-top">
            <span class="text-dark small fw-semibold" id="table-sicantik-info">
                Showing 0 to 0 of 0 entries
            </span>
            <nav aria-label="Navigasi Halaman Si Cantik">
                <ul class="pagination pagination-sm mb-0" id="table-sicantik-pagination">
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-preview-sicantik" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-modern bg-white">
            <div class="modal-header border-bottom px-4 py-3">
                <h6 class="modal-title fw-bold text-dark fs-6" id="modal-preview-sicantik-title">Preview Gambar</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center" style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <img id="modal-preview-sicantik-img" src="" class="img-fluid rounded shadow-sm" style="max-height: 480px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/custom/pages/inovasi/inovasi-sicantik.js') }}?v={{ time() }}"></script>

{{-- Tukar banner: banner pastel Si Cantik naik ke posisi banner atas, banner hijau disembunyikan --}}
<script>
(function () {
    var banner = document.getElementById('sc-top-banner');
    if (!banner) return;
    var item = banner.closest('.inovasi-item-view') || document.getElementById('content-sicantik');   // wadah konten Si Cantik (tampil/sembunyi sesuai dropdown)
    if (!item) return;   // wadah tidak ditemukan: banner tetap tersembunyi agar tidak muncul di submenu lain

    // Cari banner hijau "Inovasi Kota" di index.blade.php (tidak bergantung pada nama class tertentu)
    function cariBannerHijau() {
        var el = document.querySelector('#banner-inovasi-default, .banner-inovasi-kota');
        if (el) return el;
        var sub = document.getElementById('banner-subtitle-inovasi');
        var pilih = document.getElementById('select-filter-inovasi');
        if (!sub || !pilih) return null;
        el = sub;
        while (el.parentElement && !el.parentElement.contains(pilih)) el = el.parentElement;
        return el;
    }
    var hijau = cariBannerHijau();

    if (hijau) hijau.insertAdjacentElement('afterend', banner);   // naik ke posisi banner atas

    function sync() {
        var tampil = item.offsetParent !== null;
        banner.classList.toggle('d-none', !tampil);
        // Banner hijau tampil hanya jika tidak ada banner submenu yang sedang aktif
        if (hijau) hijau.classList.toggle('d-none', !!document.querySelector('.sub-banner-top:not(.d-none)'));
    }

    new MutationObserver(sync).observe(item, { attributes: true, attributeFilter: ['class', 'style'] });
    document.addEventListener('change', function (e) {
        if (e.target && (e.target.id === 'select-filter-inovasi' || e.target.id === 'select-filter-pokja')) setTimeout(sync, 0);
    });
    sync();
})();
</script>
