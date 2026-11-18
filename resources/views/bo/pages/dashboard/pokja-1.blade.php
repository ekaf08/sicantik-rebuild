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
                        <a href="{{ route('data-umum.kelurahan', ['idKec' => $id, 'tab' => 'pokja1']) }}"
                        class="text-primary text-hover-dark">
                            {{ $nama }}
                        </a>
                    @else
                        {{ $nama }}
                    @endif
                </td>

                @foreach ($kolomPokja1 as $k)
                    @php
                        $teks     = \Illuminate\Support\Str::endsWith($k->alias, ['_kegiatan', '_metode']);
                        $isKader  = $k->alias === 'jumlah_kader';
                        $isDetail = \Illuminate\Support\Str::endsWith($k->alias, ['_volume', '_peserta']);
                        $nilai    = $dataPokja1[$id]->{$k->alias} ?? null;

                        // Pisahkan alias (contoh: 'kisah_volume' -> flag_kolom: 'kisah', tipe: 'volume')
                        $parts     = explode('_', $k->alias);
                        $flagKolom = $parts[0] ?? '';
                        $tipe      = $parts[1] ?? '';

                        $kecIdVal  = $lv === 'kelurahan' ? $kec->id_kec : $b->id_kec;
                        $kelIdVal  = $lv === 'kelurahan' ? $b->id_kel : 0;
                    @endphp

                    @if ($isKader && !$k->is_disable)
                        {{-- 1. JUMLAH KADER: Tetap pakai sistem modal pengurus lama --}}
                        <td class="agregat-trigger fw-bold"
                            style="cursor: pointer;"
                            data-id="{{ $k->id }}"
                            data-kec-id="{{ $kecIdVal }}"
                            data-kec-nama="{{ $nama }}"
                            data-kel-id="{{ $kelIdVal }}">
                            {{ number_format($nilai ?? 0, 0, ',', '.') }}
                        </td>

                    @elseif ($isDetail && !$k->is_disable)
                        {{-- 2. VOLUME & PESERTA POKJA 1: Pakai trigger khusus ke Pokja1Controller --}}
                        <td class="pokja1-detail-trigger fw-bold text-primary"
                            style="cursor: pointer;"
                            data-flag-kolom="{{ $flagKolom }}"
                            data-tipe="{{ $tipe }}"
                            data-judul="{{ strtoupper(str_replace('_', ' ', $k->alias)) }} - {{ strtoupper($nama) }}"
                            data-kec-id="{{ $kecIdVal }}"
                            data-kel-id="{{ $kelIdVal }}"
                            data-pertanyaan-id="{{ $dataPokja1[$id]->id ?? '' }}">
                            {{ number_format($nilai ?? 0, 0, ',', '.') }}
                        </td>

                    @else
                        {{-- 3. KEGIATAN & METODE (Teks biasa / tidak diklik) --}}
                        <td>
                            @if ($teks)
                                {{ $nilai ?? '' }}
                            @else
                                {{ number_format($nilai ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        {{-- BARIS TAMBAHAN: TP PKK KECAMATAN / TP PKK KOTA --}}
        @if (isset($dataPokja1['tp_pkk']))
            @php
                $tpRow      = $dataPokja1['tp_pkk'];
                $namaTpPkk  = $lv === 'kelurahan' ? 'TP PKK KECAMATAN' : 'TP PKK KOTA';
                $kecIdTp    = $lv === 'kelurahan' ? $kec->id_kec : 32;
            @endphp
            <tr class="fw-bold bg-light-warning">
                <td>{{ $baris->count() + 1 }}</td>
                <td class="text-start fw-bold text-uppercase">{{ $namaTpPkk }}</td>

                @foreach ($kolomPokja1 as $k)
                    @php
                        $teks     = \Illuminate\Support\Str::endsWith($k->alias, ['_kegiatan', '_metode']);
                        $isKader  = $k->alias === 'jumlah_kader';
                        $isDetail = \Illuminate\Support\Str::endsWith($k->alias, ['_volume', '_peserta']);
                        $nilai    = $tpRow->{$k->alias} ?? null;

                        $parts     = explode('_', $k->alias);
                        $flagKolom = $parts[0] ?? '';
                        $tipe      = $parts[1] ?? '';
                    @endphp

                    @if ($isKader && !$k->is_disable)
                        <td class="agregat-trigger fw-bold"
                            style="cursor: pointer;"
                            data-id="{{ $k->id }}"
                            data-kec-id="{{ $kecIdTp }}"
                            data-kec-nama="{{ $namaTpPkk }}"
                            data-kel-id="0">
                            {{ number_format($nilai ?? 0, 0, ',', '.') }}
                        </td>
                    @elseif ($lv === 'kelurahan' && $isDetail && !$k->is_disable)
                        {{-- Khusus TP PKK KECAMATAN (di level kota kolom kegiatan dikosongkan) --}}
                        <td class="pokja1-detail-trigger fw-bold text-primary"
                            style="cursor: pointer;"
                            data-flag-kolom="{{ $flagKolom }}"
                            data-tipe="{{ $tipe }}"
                            data-judul="{{ strtoupper(str_replace('_', ' ', $k->alias)) }} - {{ $namaTpPkk }}"
                            data-kec-id="{{ $kecIdTp }}"
                            data-kel-id="tp_pkk"
                            data-pertanyaan-id="{{ $tpRow->id ?? '' }}">
                            {{ number_format($nilai ?? 0, 0, ',', '.') }}
                        </td>
                    @else
                        <td>
                            @if ($lv === 'kecamatan')
                                {{-- TP PKK KOTA: semua kolom kegiatan dikosongkan --}}
                            @elseif ($teks)
                                {{ $nilai ?? '' }}
                            @else
                                {{ number_format($nilai ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                    @endif
                @endforeach
            </tr>
        @endif
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
<!--begin::Petunjuk Pengisian-->
<div class="mt-8 text-center">
    <img src="{{ asset('img/new_d_pokja_1/halaman-3.jpg') }}"
         alt="Petunjuk Pengisian Pokja 1 PKK halaman 1"
         class="img-fluid border rounded d-block mx-auto mb-4"
         style="width: 100%; max-width: 1300px;">

    <img src="{{ asset('img/new_d_pokja_1/halaman-4.jpg') }}"
         alt="Petunjuk Pengisian Pokja 1 PKK halaman 2"
         class="img-fluid border rounded d-block mx-auto"
         style="width: 100%; max-width: 1300px;">
</div>
<!--end::Petunjuk Pengisian-->