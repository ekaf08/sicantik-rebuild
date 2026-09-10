@extends('bo.layout.app')

@section('content')
<div class="d-flex flex-column flex-column-fluid">

    {{-- Header Card --}}
    <div class="card card-flush mb-5">
        <div class="card-header pt-6">
            <div class="card-title d-flex flex-column">
                <h2 class="fs-2hx fw-bold text-gray-900 mb-1">Inovasi Global</h2>
                <span class="text-gray-500 fw-semibold fs-6">Ringkasan jumlah data inovasi PKK Kota Surabaya</span>
            </div>
            <div class="card-toolbar">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success active" id="btn-tab-dashboard" onclick="switchInovasiTab('dashboard')">
                        Dashboard
                    </button>
                    <button type="button" class="btn btn-sm btn-light-success" id="btn-tab-input" onclick="switchInovasiTab('input')">
                        Input Inovasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card card-flush mb-5">
        <div class="card-body py-4">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label fs-7 fw-bold text-gray-700">Kecamatan</label>
                    <select class="form-select form-select-solid">
                        <option>Semua kecamatan</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fs-7 fw-bold text-gray-700">Kelurahan</label>
                    <select class="form-select form-select-solid">
                        <option>Pilih kelurahan</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fs-7 fw-bold text-gray-700">Periode</label>
                    <select class="form-select form-select-solid">
                        <option>2026</option>
                        <option>2025</option>
                        <option>2024</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- View Dashboard --}}
    <div id="view-inovasi-dashboard" class="d-flex flex-column gap-5">
        
        {{-- Card Statistik (12 Kolom Terbagi Pas) --}}
        <div class="row g-4">
            @foreach ([
                ['label' => 'Sekretaris', 'value' => 27, 'color' => 'primary'],
                ['label' => 'Pokja 1', 'value' => 24, 'color' => 'success'],
                ['label' => 'Pokja 2', 'value' => 24, 'color' => 'success'],
                ['label' => 'Pokja 3', 'value' => 32, 'color' => 'primary'],
                ['label' => 'Pokja 4', 'value' => 40, 'color' => 'success'],
            ] as $stat)
                <div class="col-6 col-md-4 col-xl">
                    <div class="card card-flush h-100 border border-gray-100 shadow-sm">
                        <div class="card-body p-5">
                            <span class="fs-2x fw-bold text-gray-900 d-block mb-1">{{ $stat['value'] }}</span>
                            <span class="text-gray-500 fs-7 fw-semibold d-block mb-3">{{ $stat['label'] }}</span>
                            <span class="badge badge-light-{{ $stat['color'] }} fs-8 fw-bold">Inovasi</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Progress Bar Distribusi --}}
        <div class="card card-flush shadow-sm border border-gray-100">
            <div class="card-header pt-5">
                <h3 class="card-title fw-bold text-gray-800 fs-5">Distribusi Inovasi per Pokja</h3>
            </div>
            <div class="card-body pt-2">
                <div class="d-flex flex-column gap-4">
                    @foreach ([
                        ['label' => 'Pokja 4', 'value' => 40, 'percent' => 100, 'color' => 'primary'],
                        ['label' => 'Pokja 3', 'value' => 32, 'percent' => 80, 'color' => 'success'],
                        ['label' => 'Sekretaris', 'value' => 27, 'percent' => 67, 'color' => 'success'],
                        ['label' => 'Pokja 1', 'value' => 24, 'percent' => 60, 'color' => 'primary'],
                        ['label' => 'Pokja 2', 'value' => 24, 'percent' => 60, 'color' => 'primary'],
                    ] as $bar)
                        <div class="d-flex align-items-center">
                            <span class="text-gray-700 fw-bold fs-7 w-90px flex-shrink-0">{{ $bar['label'] }}</span>
                            <div class="progress h-8px w-100 bg-light mx-3">
                                <div class="progress-bar bg-{{ $bar['color'] }}" role="progressbar" style="width: {{ $bar['percent'] }}%"></div>
                            </div>
                            <span class="text-gray-900 fw-bold fs-7 w-30px text-end flex-shrink-0">{{ $bar['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- View Form Input --}}
    <div id="view-inovasi-input" class="d-none">
        <div class="card card-flush shadow-sm border border-gray-100">
            <div class="card-header pt-5">
                <h3 class="card-title fw-bold text-gray-800 fs-5">Tambah Inovasi Baru</h3>
            </div>
            <div class="card-body pt-0">
                <form onsubmit="event.preventDefault(); alert('Inovasi berhasil disimpan!');">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label required">Nama Inovasi</label>
                            <input type="text" class="form-control form-control-solid" required placeholder="Masukkan nama inovasi" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Pokja</label>
                            <select class="form-select form-select-solid">
                                <option>Sekretaris</option>
                                <option>Pokja 1</option>
                                <option>Pokja 2</option>
                                <option>Pokja 3</option>
                                <option>Pokja 4</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Nama kelurahan" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Periode</label>
                            <input type="text" class="form-control form-control-solid" value="2026" />
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Inovasi</label>
                            <textarea class="form-control form-control-solid" rows="4" placeholder="Jelaskan deskripsi inovasi..."></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success">Simpan Inovasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function switchInovasiTab(type) {
        const viewDash = document.getElementById('view-inovasi-dashboard');
        const viewInp = document.getElementById('view-inovasi-input');
        const btnDash = document.getElementById('btn-tab-dashboard');
        const btnInp = document.getElementById('btn-tab-input');

        if (type === 'dashboard') {
            viewDash.classList.remove('d-none');
            viewInp.classList.add('d-none');
            btnDash.className = 'btn btn-sm btn-success active';
            btnInp.className = 'btn btn-sm btn-light-success';
        } else {
            viewDash.classList.add('d-none');
            viewInp.classList.remove('d-none');
            btnDash.className = 'btn btn-sm btn-light-success';
            btnInp.className = 'btn btn-sm btn-success active';
        }
    }
</script>
@endsection