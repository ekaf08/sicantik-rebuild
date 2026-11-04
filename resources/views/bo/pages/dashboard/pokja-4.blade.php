<!--begin::Table Container-->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle gs-0 gy-4 text-center">
        <!--begin::Table head-->
        <thead>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th rowspan="3" class="w-50px bg-dark text-white">NO</th>
                <th rowspan="3" class="min-w-150px bg-secondary text-dark">
                    @if (($level ?? 'kecamatan') === 'kelurahan')
                        Nama Kelurahan
                    @else
                        Nama Kecamatan
                    @endif
                </th>
                <th colspan="10" class="bg-success text-white">KESEHATAN</th>
                <th colspan="7" class="bg-info text-white">KELESTARIAN LINGKUNGAN HIDUP</th>
                <th colspan="6" class="bg-warning text-white">PERENCANAAN SEHAT</th>
                <th colspan="3" class="bg-primary text-white">PROGRAM UNGGULAN GERAKAN KELUARGA SEHAT TANGGUH BENCANA (GKSTB)</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th colspan="6" class="bg-light-success">JUMLAH KADER</th>
                <th rowspan="2" class="bg-light-warning">POSYANDU</th>
                <th rowspan="2" class="bg-light-warning">IMUNISASI / VAKSINASI BAYI/BALITA</th>
                <th rowspan="2" class="bg-light-warning">PKG</th>
                <th rowspan="2" class="bg-light-warning">TBC</th>
                <th colspan="3" class="bg-light-info">JUMLAH RUMAH YANG MEMILIKI</th>
                <th rowspan="2" class="bg-light-warning text-dark">JUMLAH MCK</th>
                <th colspan="3" class="bg-light-info">JUMLAH KRT YANG MENGGUNAKAN AIR</th>
                <th rowspan="2" class="bg-light-warning">JUMLAH PUS</th>
                <th rowspan="2" class="bg-light-warning">JUMLAH WUS</th>
                <th colspan="2" class="bg-light-danger">JUMLAH AKSEPTOR KB</th>
                <th rowspan="2" class="bg-light-warning">JML. KK YANG MEMILIKI TABUNGAN KELUARGA</th>
                <th rowspan="2" class="bg-light-warning">JML. KK YANG MEMILIKI ASURANSI KESEHATAN</th>
                <th rowspan="2" class="bg-light-primary">KESEHATAN</th>
                <th rowspan="2" class="bg-light-primary">KELESTARIAN LINGKUNGAN HIDUP</th>
                <th rowspan="2" class="bg-light-primary">PERENCANAAN SEHAT</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th class="bg-light-success text-dark">KADER KESEHATAN</th>
                <th class="bg-light-danger text-dark">GIZI</th>
                <th class="bg-light-danger text-dark">KESLING</th>
                <th class="bg-light-danger text-dark">PHBS</th>
                <th class="bg-light-danger text-dark">KB</th>
                <th class="bg-light-success text-dark">KADER SURABAYA HEBAT</th>
                <th class="bg-light-primary text-dark">JAMBAN</th>
                <th class="bg-light-primary text-dark">SPAL</th>
                <th class="bg-light-primary text-dark">TEMPAT SAMPAH</th>
                <th class="bg-light-info text-dark">PDAM</th>
                <th class="bg-light-info text-dark">SUMUR</th>
                <th class="bg-light-info text-dark">LAIN-LAIN</th>
                <th class="bg-light-primary text-dark">L</th>
                <th class="bg-light-primary text-dark">P</th>
            </tr>
            <tr class="fw-semibold fs-7 text-gray bg-light text-center">
                @for ($n = 1; $n <= 28; $n++) 
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
                            <a href="{{ route('data-umum.kelurahan', ['idKec' => $b->id_kec, 'tab' => 'pokja4']) }}#kt_tab_pokja_4" class="text-primary">{{ $nama }}</a>
                        @else
                            {{ $nama }}
                        @endif
                    </td>

                    @foreach ($kolomPokja4 as $k)
                        <td @class(['agregat-trigger fw-bold' => !$k->is_disable])
                            @unless ($k->is_disable)
                                data-id="{{ $k->id }}"
                                data-kec-id="{{ $lv === 'kelurahan' ? $kec->id_kec : $b->id_kec }}"
                                data-kec-nama="{{ $nama }}"
                                data-kel-id="{{ $lv === 'kelurahan' ? $b->id_kel : 0 }}"
                            @endunless>
                            {{ number_format($dataPokja4[$id]->{$k->alias} ?? 0, 0, ',', '.') }}
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
                @foreach ($kolomPokja4 as $k)
                    <td>{{ number_format($dataPokja4->sum($k->alias), 0, ',', '.') }}</td>
                @endforeach
            </tr>
        </tfoot>
        <!--end::Table foot-->
    </table>
</div>
<!--end::Table Container-->