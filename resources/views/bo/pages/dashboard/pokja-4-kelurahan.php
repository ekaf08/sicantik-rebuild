@extends('bo.layout.app')

@section('content')
<div class="card mb-5">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title fw-bold">Data Umum PKK - Kecamatan {{ $kec->nama_kec }}</h3>
        <div class="card-toolbar">
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Kembali</a>
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="fw-bold text-uppercase bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kelurahan</th>
                        @foreach ($kolom as $k)
                            <th>{{ str_replace('_', ' ', $k->alias) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelurahan as $i => $kel)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="text-start fw-bold text-uppercase">{{ $kel->nama_kel }}</td>
                            @foreach ($kolom as $k)
                                <td>0</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection