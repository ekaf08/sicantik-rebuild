@extends('bo.layout.app')

@section('content')
<!--begin::Container Responsif Metronic-->
<div id="kt_app_content_container" class="app-container container-fluid">

    <!--begin::Header-->
    <div class="card card-flush mb-5">
        <div class="card-body py-5">
            <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Inovasi Kota</h2>
            <span class="text-gray-500 fw-semibold fs-6">Telusuri inovasi PKK yang telah diinputkan per pokja dan kelurahan</span>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Layout Row-->
    <div class="row g-5">

        <!--begin::Sidebar Filter (Kiri)-->
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card card-flush h-100">
                <div class="card-header pt-5">
                    <h3 class="card-title fw-bold text-gray-800 fs-5">Filter Pencarian</h3>
                </div>
                <div class="card-body pt-2">
                    {{-- Input Pencarian --}}
                    <div class="mb-5">
                        <label class="form-label fs-7 fw-bold text-gray-700">Cari Inovasi</label>
                        <div class="position-relative">
                            <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle-y ms-4"></i>
                            <input type="text" id="searchInput" class="form-control form-control-solid ps-12" placeholder="Nama inovasi..." />
                        </div>
                    </div>

                    {{-- Chips Pokja --}}
                    <div class="mb-5">
                        <label class="form-label fs-7 fw-bold text-gray-700 d-block">Pokja</label>
                        <div id="pokjaChips" class="d-flex flex-wrap gap-2">
                            <button type="button" data-pokja="semua" class="btn btn-sm btn-success active chip-filter">Semua</button>
                            <button type="button" data-pokja="sekertaris" class="btn btn-sm btn-light-success chip-filter">Sekretaris</button>
                            <button type="button" data-pokja="pokja 1" class="btn btn-sm btn-light-success chip-filter">Pokja 1</button>
                            <button type="button" data-pokja="pokja 2" class="btn btn-sm btn-light-success chip-filter">Pokja 2</button>
                            <button type="button" data-pokja="pokja 3" class="btn btn-sm btn-light-success chip-filter">Pokja 3</button>
                            <button type="button" data-pokja="pokja 4" class="btn btn-sm btn-light-success chip-filter">Pokja 4</button>
                        </div>
                    </div>

                    {{-- Select Kelurahan --}}
                    <div class="mb-3">
                        <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
                        <select id="kelurahanFilter" class="form-select form-select-solid">
                            <option value="semua">Semua kelurahan</option>
                            <option value="ketintang">Ketintang</option>
                            <option value="wonokromo">Wonokromo</option>
                            <option value="gubeng">Gubeng</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Sidebar Filter-->

        <!--begin::Grid Card (Kanan)-->
        <div class="col-12 col-md-8 col-xl-9">
            <div id="innovationGrid" class="row g-4">
                @foreach ([
                    ['title' => 'Dasa Wisma Sehat', 'pokja' => 'Pokja 3', 'kel' => 'Ketintang', 'color' => 'success'],
                    ['title' => 'Bank Sampah Digital', 'pokja' => 'Pokja 2', 'kel' => 'Wonokromo', 'color' => 'primary'],
                    ['title' => 'Posyandu Ramah Balita', 'pokja' => 'Pokja 4', 'kel' => 'Gubeng', 'color' => 'info'],
                    ['title' => 'Kebun Gizi Keluarga', 'pokja' => 'Pokja 3', 'kel' => 'Ketintang', 'color' => 'success'],
                    ['title' => 'Arsip Administrasi Digital', 'pokja' => 'Sekertaris', 'kel' => 'Wonokromo', 'color' => 'success'],
                    ['title' => 'Koperasi Ibu PKK', 'pokja' => 'Pokja 1', 'kel' => 'Gubeng', 'color' => 'warning'],
                ] as $item)
                    <div class="col-12 col-sm-6 col-xxl-4 innovation-card" 
                         data-title="{{ strtolower($item['title']) }}"
                         data-pokja="{{ strtolower($item['pokja']) }}"
                         data-kelurahan="{{ strtolower($item['kel']) }}">
                        <div class="card card-flush h-100 shadow-sm border border-gray-100">
                            <div class="card-body p-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="symbol symbol-40px me-3">
                                        <span class="symbol-label bg-light-{{ $item['color'] }}">
                                            <i class="ki-outline ki-bulb text-{{ $item['color'] }} fs-2"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <span class="badge badge-light-{{ $item['color'] }} fs-8 fw-bold">{{ $item['pokja'] }}</span>
                                        <span class="text-gray-400 fs-8 d-block mt-0.5">Kel. {{ $item['kel'] }}</span>
                                    </div>
                                </div>
                                <h4 class="text-gray-900 fw-bold fs-6 mb-0">{{ $item['title'] }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- State Kosong --}}
            <div id="emptyState" class="card card-flush py-10 d-none text-center">
                <div class="card-body">
                    <i class="ki-outline ki-search-list fs-3x text-gray-400 mb-3"></i>
                    <p class="text-gray-500 fs-6 fw-semibold mb-0">Tidak ada inovasi yang cocok.</p>
                </div>
            </div>
        </div>
        <!--end::Grid Card-->

    </div>
    <!--end::Layout Row-->

</div>
<!--end::Container Responsif Metronic-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const pokjaButtons = document.querySelectorAll('.chip-filter');
    const kelurahanFilter = document.getElementById('kelurahanFilter');
    const cards = document.querySelectorAll('.innovation-card');
    const emptyState = document.getElementById('emptyState');

    let selectedPokja = 'semua';

    function runFilter() {
        const searchText = searchInput.value.toLowerCase().trim();
        const selectedKel = kelurahanFilter.value.toLowerCase();
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.getAttribute('data-title');
            const pokja = card.getAttribute('data-pokja');
            const kel = card.getAttribute('data-kelurahan');

            const matchSearch = title.includes(searchText);
            const matchPokja = (selectedPokja === 'semua' || pokja === selectedPokja);
            const matchKel = (selectedKel === 'semua' || kel === selectedKel);

            if (matchSearch && matchPokja && matchKel) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            emptyState.classList.remove('d-none');
        } else {
            emptyState.classList.add('d-none');
        }
    }

    searchInput.addEventListener('input', runFilter);
    kelurahanFilter.addEventListener('change', runFilter);

    pokjaButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            pokjaButtons.forEach(b => {
                b.classList.remove('btn-success', 'active');
                b.classList.add('btn-light-success');
            });

            this.classList.remove('btn-light-success');
            this.classList.add('btn-success', 'active');

            selectedPokja = this.getAttribute('data-pokja');
            runFilter();
        });
    });
});
</script>
@endsection