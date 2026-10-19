@extends('bo.layout.app')

@section('content')

<style>
    /* Preview PDF (viewer bawaan browser) */
    .file-frame { width:100%; height:420px; border:0; border-radius:14px; background:#3c3c3c; display:block; }
</style>

@if(session('success'))
    <div class="alert alert-success d-flex align-items-center p-4 mb-5">
        <i class="ki-outline ki-check-circle fs-2x text-success me-3"></i>
        <span class="fw-semibold">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger p-4 mb-5">
        <div class="fw-bold mb-2">Data belum bisa disimpan:</div>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $canCreate = \App\Support\Access::can('laporan-tahunan', 'create');
    $canUpdate = \App\Support\Access::can('laporan-tahunan', 'update');
    $canDelete = \App\Support\Access::can('laporan-tahunan', 'delete');

    $tabLaporan = [
        [
            'field'   => 'file_kata_pengantar',
            'tab'     => 'Kata Pengantar',
            'judul'   => 'Kata Pengantar',
            'panduan' => ['Kata pengantar dari Ketua TP PKK'],
        ],
        [
            'field'   => 'file_bab_1',
            'tab'     => 'BAB 1',
            'judul'   => 'BAB 1',
            'panduan' => ['Pendahuluan', 'Dasar Pembuatan Laporan', 'Maksud & Tujuan Pembuatan Laporan', 'Jangka Waktu Pelaporan'],
        ],
        [
            'field'   => 'file_bab_2',
            'tab'     => 'BAB 2',
            'judul'   => 'BAB 2',
            'panduan' => ['Pelaksanaan Program & Kegiatan'],
            'catatan' => 'Dalam Pelaksanaan Program & Kegiatan dapat dituliskan Kegiatan:',
            'butir'   => ['Sekretariat', 'Keuangan', 'Kegiatan Pokja-Pokja'],
        ],
        [
            'field'   => 'file_bab_3',
            'tab'     => 'BAB 3',
            'judul'   => 'BAB 3',
            'panduan' => ['Instansi/Lembaga yang terlibat dalam pelaksanaan Program & Kegiatan'],
            'catatan' => 'Dalam hal ini dapat dituliskan mengenai:',
            'butir'   => ['Nama-nama instansi/Lembaga', 'Peran/Kontribusi instansi/lembaga'],
        ],
        [
            'field'   => 'file_bab_4',
            'tab'     => 'BAB 4',
            'judul'   => 'BAB 4',
            'panduan' => ['Jumlah & Sasaran Kegiatan:'],
            'butir'   => ['Target program & kegiatan', 'Capaian program & kegiatan', 'Manfaat program & kegiatan'],
        ],
        [
            'field'   => 'file_bab_5',
            'tab'     => 'BAB 5',
            'judul'   => 'BAB 5',
            'panduan' => ['Pembiayaan / Anggaran Kegiatan:'],
            'butir'   => [
                'Rincian & kegunaan APBD',
                'Rincian & kegunaan APBDesa',
                'Rincian & kegunaan anggaran yang berasal dari sumber lain',
            ],
        ],
        [
            'field'   => 'file_bab_6',
            'tab'     => 'BAB 6',
            'judul'   => 'BAB 6',
            'panduan' => ['Permasalahan:'],
            'butir'   => ['Permasalahan Internal', 'Permasalahan Eksternal'],
        ],
        [
            'field'   => 'file_bab_7',
            'tab'     => 'BAB 7',
            'judul'   => 'BAB 7',
            'panduan' => ['Upaya Pemecahan Permasalahan'],
            'butir'   => ['Langkah & Strategi Pemecahan Permasalahan'],
        ],
        [
            'field'   => 'file_bab_8',
            'tab'     => 'BAB 8',
            'judul'   => 'BAB 8',
            'panduan' => ['Penutup'],
            'butir'   => [
                'Kesimpulan: kesimpulan yang singkat & padat berisi garis besar laporan yang telah ditulis',
                'Saran: menyampaikan saran penyelesaian dari hambatan/permasalahan yang dihadapi, dengan harapan ada jalan keluar/pemecahan masalah yang dapat dilaksanakan oleh TP PKK setingkat di atasnya / pada tahap selanjutnya',
            ],
        ],
        [
            'field'   => 'file_full_laporan',
            'tab'     => 'Upload Laporan Tahunan',
            'judul'   => 'Upload Laporan Tahunan (Gabungan)',
            'panduan' => ['Unggah gabungan seluruh bab dalam satu file PDF'],
        ],
    ];
@endphp

<div class="card mb-5 mb-xl-8">
    <!--begin::Card Banner Header-->
<div class="card border-0 mb-5 mb-xl-8 overflow-hidden rounded-4 position-relative" style="background: linear-gradient(135deg, #fff5f8 0%, #fff8dd 100%);">
    <div class="card-body p-8 p-lg-10">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-5">
            <div class="max-w-md-500px">
                <h1 class="text-dark fw-bolder mb-3 fs-2hx">Laporan Pertanggungjawaban</h1>
                <p class="text-gray-600 fw-semibold fs-6 mb-6">
                    Dokumentasi Laporan Tahunan dan Memori Pertanggungjawaban
                </p>
                @if($canCreate)
                    <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahLaporan">
                        <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Laporan
                    </button>
                @endif
            </div>

            <div class="d-none d-lg-block me-5 opacity-75">
                <i class="ki-outline ki-heart-circle text-info" style="font-size: 12rem;"></i>
            </div>
        </div>
    </div>
</div>

    <!-- Card Body / Tabel -->
    <div class="card-body py-4">
        @php
            $filterAktif = collect(['q', 'jenis', 'tahun', 'wilayah'])->contains(fn ($k) => request()->filled($k));
        @endphp

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('laporan-tahunan.index') }}" class="mb-6">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label fs-7 fw-semibold text-gray-700 mb-1">Cari</label>
                    <div class="position-relative">
                        <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle-y ms-4"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="form-control form-control-solid ps-12"
                               placeholder="Cari tahun, wilayah, atau pembuat..." />
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label fs-7 fw-semibold text-gray-700 mb-1">Jenis Laporan</label>
                    <select name="jenis" class="form-select form-select-solid" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="laporan_tahunan" @selected(request('jenis') === 'laporan_tahunan')>Laporan Tahunan</option>
                        <option value="memori_pj" @selected(request('jenis') === 'memori_pj')>Memori PJ Ketua</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label fs-7 fw-semibold text-gray-700 mb-1">Tahun Periode</label>
                    <select name="tahun" class="form-select form-select-solid" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        @foreach($tahunList as $th)
                            <option value="{{ $th }}" @selected((string) request('tahun') === (string) $th)>{{ $th }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4">
                    <label class="form-label fs-7 fw-semibold text-gray-700 mb-1">Tingkat Wilayah</label>
                    <select name="wilayah" class="form-select form-select-solid" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="kota" @selected(request('wilayah') === 'kota')>Kota</option>
                        <option value="kecamatan" @selected(request('wilayah') === 'kecamatan')>Kecamatan</option>
                        <option value="kelurahan" @selected(request('wilayah') === 'kelurahan')>Kelurahan</option>
                    </select>
                </div>

                <!-- <div class="col-lg-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1">
                        <i class="ki-outline ki-filter fs-4 me-1"></i> Terapkan
                    </button>
                    @if($filterAktif)
                        <a href="{{ route('laporan-tahunan.index') }}" class="btn btn-light fw-bold" title="Reset filter">
                            <i class="ki-outline ki-cross fs-3 p-0"></i>
                        </a>
                    @endif
                </div> -->
            </div>

            
        </form>

        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 bg-light">
                        <th class="ps-4 rounded-start">No</th>
                        <th>Jenis Laporan</th>
                        <th>Tahun Periode</th>
                        <th>Tingkat Wilayah</th>
                        <th>Kelengkapan File</th>
                        <th>Dibuat Oleh</th>
                        @if($canUpdate || $canDelete)
                            <th class="text-center rounded-end">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($dataLaporan as $index => $item)
                        @php
                            [$terisi, $total] = $item->kelengkapan;

                            $editPayload = [
                                'id'    => $item->id_lap_tahunan,
                                'tahun' => $item->tahun_periode,
                                'jenis' => $item->jenis_laporan,
                                'files' => collect($item->fileFields())->mapWithKeys(fn ($f) => [
                                    $f => $item->{$f} ? \Illuminate\Support\Facades\Storage::disk('public')->url($item->{$f}) : null,
                                ])->all(),
                            ];
                        @endphp
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                @if($item->jenis_laporan == 'memori_pj')
                                    <span class="badge badge-light-danger fs-7 fw-bold">Memori PJ Ketua</span>
                                @else
                                    <span class="badge badge-light-primary fs-7 fw-bold">Laporan Tahunan</span>
                                @endif
                            </td>
                            <td><span class="text-gray-800 fw-bold">{{ $item->tahun_periode }}</span></td>
                            <td><span class="text-uppercase badge badge-light-info fs-8">{{ $item->level_wilayah }}</span></td>
                            <td>
                                <span class="badge {{ $terisi === $total ? 'badge-light-success' : 'badge-light-warning' }} fs-7 fw-bold">
                                    {{ $terisi }} / {{ $total }} file
                                </span>
                            </td>
                            <td>{{ $item->creator->name ?? 'Sistem' }}</td>
                            @if($canUpdate || $canDelete)
                                <td class="text-center">
                                    @if($canUpdate)
                                        <button type="button"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-edit-laporan"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditLaporan"
                                                data-item="{{ json_encode($editPayload) }}"
                                                title="Edit / lengkapi file">
                                            <i class="ki-outline ki-pencil fs-2"></i>
                                        </button>
                                    @endif

                                    @if($canDelete)
                                        <form action="{{ route('laporan-tahunan.destroy', $item->id_lap_tahunan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                <i class="ki-outline ki-trash fs-2"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-muted">
                                {{ $filterAktif ? 'Tidak ada data yang sesuai dengan pencarian atau filter.' : 'Belum ada data laporan yang diunggah.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-muted fs-7 mt-3">
                Menampilkan <span class="fw-bold text-gray-800">{{ $dataLaporan->count() }}</span> data
                @if($filterAktif) sesuai filter @endif
            </div>
    </div>
</div>

{{-- MODAL TAMBAH LAPORAN --}}
@if($canCreate)
    <div class="modal fade" id="modalTambahLaporan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <form action="{{ route('laporan-tahunan.store') }}" method="POST" enctype="multipart/form-data" id="formTambahLaporan">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-gray-900 fs-3">Tambah Laporan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-6">
                        <div class="row g-5 mb-6">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-gray-700 required">Jenis Laporan</label>
                                <select name="jenis_laporan" id="selectJenisLaporan" class="form-select form-select-solid" required>
                                    <option value="laporan_tahunan" @selected(old('jenis_laporan', 'laporan_tahunan') === 'laporan_tahunan')>Laporan Tahunan</option>
                                    <option value="memori_pj" @selected(old('jenis_laporan') === 'memori_pj')>Memori Pertanggungjawaban Ketua</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-gray-700 required">Tahun Periode</label>
                                <input type="number" name="tahun_periode" class="form-control form-control-solid" value="{{ old('tahun_periode', date('Y')) }}" min="2000" max="2100" required />
                            </div>
                        </div>

                        <!-- Memori PJ -->
                        <div class="d-none" id="sectionMemoriPj">
                            <label class="form-label fw-bold text-gray-700 required">
                                File Memori PJ <span class="fst-italic text-danger fs-7">(PDF, file maksimal 2Mb)</span>
                            </label>
                            <input type="file" name="file_memori_pj" class="form-control form-control-solid input-file-laporan" accept=".pdf" disabled />
                        </div>

                        <!-- Laporan Tahunan (tab per bab) -->
                        <div id="sectionLaporanTahunan">
                            @include('bo.pages.laporan.laporan-tahunan.tab', ['tabLaporan' => $tabLaporan, 'prefix' => 'add'])
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- MODAL EDIT LAPORAN --}}
@if($canUpdate)
    <div class="modal fade" id="modalEditLaporan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <form action="#" method="POST" enctype="multipart/form-data" id="formEditLaporan">
                    @csrf
                    @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-gray-900 fs-3">Edit Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-6">
                        <div class="row g-5 mb-6">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-gray-700">Jenis Laporan</label>
                                <input type="text" id="editJenisLabel" class="form-control form-control-solid" disabled />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-gray-700 required">Tahun Periode</label>
                                <input type="number" name="tahun_periode" id="editTahun" class="form-control form-control-solid" min="2000" max="2100" required />
                            </div>
                        </div>

                        <!-- Memori PJ -->
                        <div class="d-none" id="editSectionMemoriPj">
                            <div class="file-status mb-4" data-field="file_memori_pj"></div>
                            <label class="form-label fw-bold text-gray-700">
                                File Memori PJ
                                <span class="fst-italic text-danger fs-7">(PDF, file maksimal 2Mb)</span>
                            </label>
                            <input type="file" name="file_memori_pj" class="form-control form-control-solid input-file-laporan" accept=".pdf" disabled />
                            <div class="form-text">Pilih file baru hanya jika ingin mengganti file yang sekarang.</div>
                        </div>

                        <!-- Laporan Tahunan (tab per bab) -->
                        <div id="editSectionLaporanTahunan">
                            @include('bo.pages.laporan.laporan-tahunan.tab', ['tabLaporan' => $tabLaporan, 'prefix' => 'edit'])
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection

@section('js')
<script>
    $(document).ready(function () {
        const MAX_SIZE = 2 * 1024 * 1024;
        const updateUrlTemplate = @json(route('laporan-tahunan.update', ':id'));

        function toggleJenis() {
            const isMemori = $('#selectJenisLaporan').val() === 'memori_pj';

            $('#sectionMemoriPj').toggleClass('d-none', !isMemori)
                .find('input[type=file]').prop('disabled', !isMemori);

            $('#sectionLaporanTahunan').toggleClass('d-none', isMemori)
                .find('input[type=file]').prop('disabled', isMemori);
        }

        $('#selectJenisLaporan').on('change', toggleJenis);
        toggleJenis();

        $(document).on('change', '.input-file-laporan', function () {
            let file = this.files[0];

            if (file && file.size > MAX_SIZE) {
                alert('Ukuran file maksimal 2MB. File "' + file.name + '" terlalu besar.');
                $(this).val('');
                file = null;
            }

            const $scope  = $(this).closest('.tab-pane, #sectionMemoriPj, #editSectionMemoriPj');
            const $status = $scope.find('.file-status'); // hanya ada di modal edit

            if ($status.length) {
                // EDIT: preview langsung diganti file baru, batal pilih = balik ke file lama
                if (file) {
                    $status.empty().append(
                        $('<div class="file-preview"></div>')
                            .append($('<iframe class="file-frame"></iframe>').attr('src', URL.createObjectURL(file)))
                    );
                } else {
                    renderStatus($status, $status.data('url'));
                }
            } else {
                // TAMBAH: preview muncul di bawah input
                let $new = $scope.find('.new-file-preview');
                if (!$new.length) {
                    $new = $('<div class="new-file-preview mt-4"></div>').insertAfter($(this));
                }
                $new.empty();
                if (file) {
                    $new.append($('<iframe class="file-frame"></iframe>').attr('src', URL.createObjectURL(file)));
                }
            }

            const $pane = $(this).closest('.tab-pane');
            if ($pane.length) {
                const $check = $('a[href="#' + $pane.attr('id') + '"] .tab-check');
                const sudahAda = $pane.find('.file-status .file-preview').length > 0;
                $check.toggleClass('d-none', !(file || sudahAda));
            }
        });

        function resetTabs(formSelector, tabsSelector) {
            $(formSelector)[0].reset();
            $(formSelector).find('.new-file-preview').remove();
            const firstTab = document.querySelector(tabsSelector + ' .nav-link');
            if (firstTab) {
                new bootstrap.Tab(firstTab).show();
            }
        }

        $('#modalTambahLaporan').on('hidden.bs.modal', function () {
            resetTabs('#formTambahLaporan', '#tabs_add');
            $('#tabs_add .tab-check').addClass('d-none');
            toggleJenis();
        });

        function renderStatus($box, url) {
            $box.empty().data('url', url || null);
            if (url) {
                $box.append(
                    $('<div class="file-preview"></div>')
                        .append($('<iframe class="file-frame" loading="lazy"></iframe>').attr('src', url))
                );
            } else {
                $box.append(
                    $('<div class="d-flex align-items-center bg-light-warning rounded p-4"></div>')
                        .append('<i class="ki-outline ki-information-5 fs-2 text-warning me-3"></i>')
                        .append('<span class="fw-semibold text-gray-800">Belum ada file yang diunggah.</span>')
                );
            }
        }

        $(document).on('click', '.btn-edit-laporan', function () {
            const d = $(this).data('item'); 
            const isMemori = d.jenis === 'memori_pj';

            resetTabs('#formEditLaporan', '#tabs_edit');

            $('#formEditLaporan').attr('action', updateUrlTemplate.replace(':id', d.id));
            $('#editTahun').val(d.tahun);
            $('#editJenisLabel').val(isMemori ? 'Memori Pertanggungjawaban Ketua' : 'Laporan Tahunan');

            $('#editSectionMemoriPj').toggleClass('d-none', !isMemori)
                .find('input[type=file]').prop('disabled', !isMemori);
            $('#editSectionLaporanTahunan').toggleClass('d-none', isMemori)
                .find('input[type=file]').prop('disabled', isMemori);

            $('#formEditLaporan .file-status').each(function () {
                const field = $(this).data('field');
                const url = d.files[field] || null;

                renderStatus($(this), url);
                $('#tabs_edit a[data-field="' + field + '"] .tab-check').toggleClass('d-none', !url);
            });

            $('#editSectionLaporanTahunan .tab-pane').each(function () {
                const hasFile = $(this).find('.file-status .file-preview').length > 0;
                $(this).find('.form-text').text(
                    hasFile
                        ? 'Pilih file baru hanya jika ingin mengganti file yang sekarang. Kosongkan jika tidak diubah.'
                        : 'Format PDF. Pilih file untuk mengunggah bagian ini.'
                );
            });
        });

        @if($errors->any() && $canCreate && old('jenis_laporan'))
            new bootstrap.Modal(document.getElementById('modalTambahLaporan')).show();
        @endif
    });
</script>
@endsection