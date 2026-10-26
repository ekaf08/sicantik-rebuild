<!--begin::Table Container-->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle gs-0 gy-4 text-center">
        <!--begin:mana:Table head-->
        <thead>
            <tr class="fw-bold fs-7 text-uppercase bg-light align-middle text-center">
                <th rowspan="3" class="w-50px bg-dark text-white">NO</th>
                <th rowspan="3" class="min-w-150px bg-secondary text-dark">Nama Wilayah</th>
                <th rowspan="3" class="w-60px bg-warning text-white">JUMLAH KADER</th>
                <th colspan="24" class="bg-success text-white">PENGHAYATAN DAN PENGAMALAN PANCASILA - GOTONG ROYONG</th>
                
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th colspan="4" class="bg-light-info">Kisah</th>
                <th colspan="4" class="bg-light-danger">KRISAN</th>
                <th colspan="4" class="bg-light-success">Kilas</th>
                <th colspan="4" class="bg-light-primary">Kiat</th>
                <th colspan="4" class="bg-light-warning">Kisak</th>
                <th colspan="4" class="bg-light-pink">PKBN</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase text-center">
                <th class="bg-light-info">Kegiatan</th>
                <th class="bg-light-info">Volume</th>
                <th class="bg-light-info">Metode</th>
                <th class="bg-light-info">Jumlah</th>
                <th class="bg-light-danger">Kegiatan</th>
                <th class="bg-light-danger">Volume</th>
                <th class="bg-light-danger">Metode</th>
                <th class="bg-light-danger">Jumlah</th>
                <th class="bg-light-success">Kegiatan</th>
                <th class="bg-light-success">Volume</th>
                <th class="bg-light-success">Metode</th>
                <th class="bg-light-success">Jumlah</th>
                <th class="bg-light-primary">Kegiatan</th>
                <th class="bg-light-primary">Volume</th>
                <th class="bg-light-primary">Metode</th>
                <th class="bg-light-primary">Jumlah</th>
                <th class="bg-light-warning">Kegiatan</th>
                <th class="bg-light-warning">Volume</th>
                <th class="bg-light-warning">Metode</th>
                <th class="bg-light-warning">Jumlah</th>
                <th class="bg-light-pink">Kegiatan</th>
                <th class="bg-light-pink">Volume</th>
                <th class="bg-light-pink">Metode</th>
                <th class="bg-light-pink">Jumlah</th>
            </tr>
            <tr class="fw-semibold fs-7 text-gray bg-light text-center">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>13</td>
                <td>14</td>
                <td>15</td>
                <td>16</td>
                <td>17</td>
                <td>18</td>
                <td>19</td>
                <td>20</td>
                <td>21</td>
                <td>22</td>
                <td>23</td>
                <td>24</td>
                <td>25</td>
                <td>26</td>
                <td>27</td>
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <tbody>
        @foreach ($kecamatan as $i => $kec)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="text-start fw-bold text-uppercase">{{ $kec->nama_kec }}</td>

                @foreach ($kolomPokja1 as $k)
                    @php
                        $teks = \Illuminate\Support\Str::endsWith($k->alias, ['_kegiatan', '_metode']);
                        $nilai = $dataPokja1[$kec->id_kec]->{$k->alias} ?? null;
                    @endphp
                    <td @class(['agregat-trigger fw-bold' => !$k->is_disable])
                        @unless ($k->is_disable)
                            data-id="{{ $k->id }}"
                            data-kec-id="{{ $kec->id_kec }}"
                            data-kec-nama="{{ $kec->nama_kec }}"
                        @endunless>
                        @if ($teks)
                            {{ $nilai ?? '' }}
                        @else
                            {{ number_format($nilai ?? 0, 0, ',', '.') }}
                        @endif
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
                @foreach ($kolomPokja1 as $k)
                    @if (\Illuminate\Support\Str::endsWith($k->alias, ['_kegiatan', '_metode']))
                        <td></td>
                    @else
                        <td>{{ number_format($dataPokja1->sum($k->alias), 0, ',', '.') }}</td>
                    @endif
                @endforeach
            </tr>
        </tfoot>
        <!--end::Table foot-->
    </table>
</div>
<!--end::Table Container-->