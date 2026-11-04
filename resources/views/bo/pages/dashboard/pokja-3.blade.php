<!--begin::Table Container-->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle gs-0 gy-4 text-center">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold fs-7 text-uppercase bg-light align-middle text-center">
                <th rowspan="3" class="w-50px bg-dark text-white">NO</th>
                <th rowspan="3" class="min-w-150px bg-secondary text-dark">Nama Wilayah</th>
                <th colspan="3" class="bg-success text-white">Jumlah Kader</th>
                <th colspan="9" class="bg-primary text-white">Pangan</th>
                <th colspan="3" class="bg-info text-white">Jumlah Industri Rumah Tangga</th>
                <th colspan="2" class="bg-warning text-white">Jumlah Rumah</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th rowspan="2" class="bg-light-success">Pangan</th>
                <th rowspan="2" class="bg-light-success">Sandang</th>
                <th rowspan="2" class="bg-light-success">Tata Laksana Rumah Tangga</th>
                <th colspan="2" class="bg-light-primary">Makanan Pokok</th>
                <th colspan="7" class="bg-light">Pemanfaatan Pekarangan / HATINYA PKK</th>
                <th rowspan="2" class="bg-light-info">Pangan</th>
                <th rowspan="2" class="bg-light-info">Sandang</th>
                <th rowspan="2" class="bg-light-info">Jasa</th>
                <th rowspan="2" class="bg-light-warning">Sehat dan Layak Huni</th>
                <th rowspan="2" class="bg-light-warning">Tidak Sehat dan Tidak Layak Huni</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th class="bg-light-primary">Beras</th>
                <th class="bg-light-primary">Non Beras</th>
                <th class="bg-light">Peternakan</th>
                <th class="bg-light">Perikanan</th>
                <th class="bg-light">Warung Hidup</th>
                <th class="bg-light">Lumbung Hidup</th>
                <th class="bg-light">TOGA</th>
                <th class="bg-light">Tanaman Keras</th>
                <th class="bg-light">Tanaman Lainnya</th>
            </tr>
            <tr class="fw-semibold fs-7 text-gray bg-light text-center">
                @for ($n = 1; $n <= 19; $n++)
                    <td>{{ $n }}</td>
                @endfor
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
      <tbody>
            @foreach ($baris as $i => $b)
                @php
                    $lv   = $level ?? 'kecamatan';
                    $id   = $lv === 'kelurahan' ? $b->id_kel : $b->id_kec;
                    $nama = $lv === 'kelurahan' ? $b->nama_kel : $b->nama_kec;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-start fw-bold text-uppercase">
                        @if ($lv === 'kecamatan')
                            <a href="{{ route('data-umum.kelurahan', ['idKec' => $b->id_kec, 'tab' => 'pokja3']) }}#kt_tab_pokja_3" class="text-primary">{{ $nama }}</a>
                        @else
                            {{ $nama }}
                        @endif
                    </td>

                    @foreach ($kolomPokja3 as $k)
                        <td @class(['agregat-trigger fw-bold' => !$k->is_disable])
                            @unless ($k->is_disable)
                                data-id="{{ $k->id }}"
                                data-kec-id="{{ $lv === 'kelurahan' ? $kec->id_kec : $b->id_kec }}"
                                data-kec-nama="{{ $nama }}"
                                data-kel-id="{{ $lv === 'kelurahan' ? $b->id_kel : 0 }}"
                            @endunless>
                            {{ number_format($dataPokja3[$id]->{$k->alias} ?? 0, 0, ',', '.') }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
        <!--begin::Table foot (Total)-->
        <tfoot>
            <tr class="fw-bold fs-6 bg-light-success text-dark">
                <td colspan="2" class="text-center">JUMLAH SELURUHNYA</td>
                @foreach ($kolomPokja3 as $k)
                    <td>{{ number_format($dataPokja3->sum($k->alias), 0, ',', '.') }}</td>
                @endforeach
            </tr>
        </tfoot>
        <!--end::Table foot-->
    </table>
</div>
<!--end::Table Container-->