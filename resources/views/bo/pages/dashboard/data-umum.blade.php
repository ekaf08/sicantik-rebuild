<!--begin::Table Container-->
<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle gs-0 gy-4 text-center">
        <!--begin:mana:Table head-->
        <thead>
            <tr class="fw-bold fs-7 text-uppercase bg-light align-middle text-center">
                <th rowspan="3" class="w-50px bg-dark text-white">NO</th>
                <th rowspan="3" class="min-w-150px bg-secondary text-dark">Nama Kecamatan</th>
                <th colspan="2" class="bg-danger text-white">Jumlah TP. PKK</th>
                <th rowspan="3" class="w-60px bg-secondary text-dark">RW</th>
                <th colspan="4" class="bg-primary text-white">Jumlah Kelompok</th>
                <th colspan="2" class="bg-success text-white">Jumlah</th>
                <th colspan="2" class="bg-info text-white">Jumlah Jiwa</th>
                <th colspan="6" class="bg-warning text-white">Jumlah Kader</th>
                <th colspan="4" class="bg-pink text-white">Jumlah Tenaga Sekretariat</th>
                <th rowspan="3" class="w-100px bg-secondary text-dark">Keterangan</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase align-middle text-center">
                <th rowspan="2" class="bg-light-danger">Desa</th>
                <th rowspan="2" class="bg-light-danger">Kelurahan</th>
                <th rowspan="2" class="bg-light-primary">Dusun / Lingkungan</th>
                <th rowspan="2" class="bg-light-primary">PKK RW</th>
                <th rowspan="2" class="bg-light-primary">PKK RT</th>
                <th rowspan="2" class="bg-light-primary">Dasa Wisma</th>
                <th rowspan="2" class="bg-light-success">KRT</th>
                <th rowspan="2" class="bg-light-success">KK</th>
                <th rowspan="2" class="bg-light-info">L</th>
                <th rowspan="2" class="bg-light-info">P</th>
                <th colspan="2" class="bg-light-warning">Anggota TP PKK</th>
                <th colspan="2" class="bg-light-warning">Umum</th>
                <th colspan="2" class="bg-light-warning">Khusus</th>
                <th colspan="2" class="bg-light-pink">Honorer</th>
                <th colspan="2" class="bg-light-pink">Bantuan</th>
            </tr>
            <tr class="fw-bold fs-7 text-uppercase text-center">
                <th class="bg-light-warning">L</th>
                <th class="bg-light-warning">P</th>
                <th class="bg-light-warning">L</th>
                <th class="bg-light-warning">P</th>
                <th class="bg-light-warning">L</th>
                <th class="bg-light-warning">P</th>
                <th class="bg-light-pink">L</th>
                <th class="bg-light-pink">P</th>
                <th class="bg-light-pink">L</th>
                <th class="bg-light-pink">P</th>
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
            </tr>
        </thead>
        <!--end::Table head-->
        <!--begin::Table body-->
        <!--begin::Table body-->
        <tbody>
            @foreach ($kecamatan as $i => $kec)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-start text-success fw-bold text-uppercase">{{ $kec->nama_kec }}</td>

                    @foreach ($kolom as $k)
                        <td @class(['agregat-trigger fw-bold' => !$k->is_disable])
                            @unless ($k->is_disable)
                                data-id="{{ $k->id }}"
                                data-kec-id="{{ $kec->id_kec }}"
                                data-kec-nama="{{ $kec->nama_kec }}"
                            @endunless>
                            {{ number_format($data[$kec->id_kec]->{$k->alias} ?? 0, 0, ',', '.') }}
                        </td>
                    @endforeach

                    <td>{{ $data[$kec->id_kec]->keterangan ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
        <!--end::Table body-->
        <!--end::Table body-->
        <!--begin::Table foot (Total)-->
        <tfoot>
            <tr class="fw-bold fs-6 bg-light-success text-dark">
                <td colspan="2" class="text-center">JUMLAH SELURUHNYA</td>
                @foreach ($kolom as $k)
                    <td>{{ number_format($data->sum($k->alias), 0, ',', '.') }}</td>
                @endforeach
                <td></td>
            </tr>
        </tfoot>
        <!--end::Table foot-->
    </table>
</div>
<!--end::Table Container-->
