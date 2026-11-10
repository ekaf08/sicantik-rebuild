<!--begin::Table Container-->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle gs-0 gy-4 text-center">
        <!--begin:mana:Table head-->
        <thead>
            <tr class="fw-bold fs-7 text-uppercase bg-light align-middle text-center">
                <th rowspan="4" class="w-50px bg-dark text-white">NO</th>
                <th rowspan="4" class="min-w-150px bg-secondary text-dark">
                    @if (($level ?? 'kecamatan') === 'kelurahan')
                        Nama Kelurahan
                    @else
                        Nama Kecamatan
                    @endif
                </th>
                <th colspan="23" class="bg-info text-white">PENDIDIKAN KETERAMPILAN</th>
                <th colspan="10" class="w-60px bg-warning text-white">PENGEMBANGAN KEHIDUPAN BERKOPERASI</th>
                <th rowspan="4" class="w-100px bg-primary text-white">Keterangan</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th rowspan="3" class="bg-light-warning">Jml Warga yang Masih 3 Buta</th>
                <th colspan="8" class="bg-light-success">Kelompok Belajar</th>
                <th rowspan="3" class="bg-light-primary">Paud Sejenis</th>
                <th rowspan="3" class="bg-light-danger">TAMAN BACAAN/ PERPUSTAKAAN</th>
                <th colspan="4" class="bg-light-warning">BKB</th>
                <th colspan="5" class="bg-light-danger">Kader Khusus</th>
                <th colspan="3" class="bg-light-success">JML KADER YG SDH DILATIH</th>
                <th colspan="8" class="bg-light-primary">Prakoperasi/Usaha bersama/UP2K PKK</th>
                <th colspan="2" rowspan="2" class="bg-light-warning">Koperasi Berbadan Hukum</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th colspan="2" class="bg-light-danger">Paket A</th>
                <th colspan="2" class="bg-light-info">Paket B</th>
                <th colspan="2" class="bg-light-pink">Paket C</th>
                <th colspan="2" class="bg-light-warning">KF</th>
                <th rowspan="2" class="bg-light-success">JML KELP</th>
                <th rowspan="2" class="bg-light-success">JML IBU PESERTA</th>
                <th rowspan="2" class="bg-light-success">JML APE ( Set)</th>
                <th rowspan="2" class="bg-light-success">JML KELP Simulasi</th>
                <th colspan="2" class="bg-light-info">Tutor</th>
                <th rowspan="2" class="bg-light-info">BKB</th>
                <th rowspan="2" class="bg-light-info">KOPERASI</th>
                <th rowspan="2" class="bg-light-info">KETERAMPILAN</th>
                <th rowspan="2" class="bg-light-primary">LP3 PKK</th>
                <th rowspan="2" class="bg-light-primary">TPK3 PKK</th>
                <th rowspan="2" class="bg-light-primary">DAMAS PKK</th>
                <th colspan="2" class="bg-light-info">Pemula</th>
                <th colspan="2" class="bg-light-success">Madya</th>
                <th colspan="2" class="bg-light-danger">Utama</th>
                <th colspan="2" class="bg-light-pink">Mandiri</th>

            </tr>
            <tr class="fw-bold fs-7 text-uppercase text-center">
                <th class="bg-light-info">Jml KLP Belajar</th>
                <th class="bg-light-info">Warga Belajar</th>
                <th class="bg-light-info">Jml KLP Belajar</th>
                <th class="bg-light-info">Warga Belajar</th>
                <th class="bg-light-info">Jml KLP Belajar</th>
                <th class="bg-light-info">Warga Belajar</th>
                <th class="bg-light-info">Jml KLP Belajar</th>
                <th class="bg-light-info">Warga Belajar</th>
                <th class="bg-light-primary">KF</th>
                <th class="bg-light-primary">Paud Sejenis</th>
                <th class="bg-light-white">KELP</th>
                <th class="bg-light-white">PSRT</th>
                <th class="bg-light-white">KELP</th>
                <th class="bg-light-white">PSRT</th>
                <th class="bg-light-white">KELP</th>
                <th class="bg-light-white">PSRT</th>
                <th class="bg-light-white">KELP</th>
                <th class="bg-light-white">PSRT</th>
                <th class="bg-light-white">KOPERASI</th>
                <th class="bg-light-white">Anggota</th>
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
                <td>28</td>
                <td>29</td>
                <td>30</td>
                <td>31</td>
                <td>32</td>
                <td>33</td>
                <td>34</td>
                <td>35</td>
                <td>36</td>
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
                            <a href="{{ route('pokja-2.kelurahan', ['idKec' => $b->id_kec, 'tab' => 'pokja2']) }}" class="text-primary">{{ $nama }}</a>
                    @else
                            {{ $nama }}
                    @endif
                </td>

                @foreach ($kolomPokja2 as $k)
                    <td @class(['agregat-trigger fw-bold' => !$k->is_disable])
                        @unless ($k->is_disable)
                            data-id="{{ $k->id }}"
                            data-kec-id="{{ $lv === 'kelurahan' ? $kec->id_kec : $b->id_kec }}"
                            data-kec-nama="{{ $nama }}"
                            data-kel-id="{{ $lv === 'kelurahan' ? $b->id_kel : 0 }}"
                        @endunless>
                        {{ number_format($dataPokja2[$id]->{$k->alias} ?? 0, 0, ',', '.') }}
                    </td>
                @endforeach

                <td>{{ $dataPokja2[$id]->keterangan ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
        <!--end::Table body-->
        <!--begin::Table foot (Total)-->
        <tfoot>
            <tr class="fw-bold fs-6 bg-light-success text-dark">
                <td colspan="2" class="text-center">JUMLAH SELURUHNYA</td>
                @foreach ($kolomPokja2 as $k)
                    <td>{{ number_format($dataPokja2->sum($k->alias), 0, ',', '.') }}</td>
                @endforeach
                <td></td>
            </tr>
        </tfoot>
        <!--end::Table foot-->
    </table>
</div>
<!--end::Table Container-->