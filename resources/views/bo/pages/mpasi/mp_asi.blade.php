@extends('bo.layout.app')

@section('content')

<!--begin::Card Banner Header-->
<div class="card border-0 mb-5 mb-xl-8 overflow-hidden rounded-4 position-relative" style="background: linear-gradient(135deg, #fff5f8 0%, #fff8dd 100%);">
    <div class="card-body p-8 p-lg-10">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-5">
            <div class="max-w-md-500px">
                <span class="badge badge-lg badge-light-primary text-primary fw-bold mb-4 px-4 py-2 rounded-pill">
                    Dapur PKK Kota Surabaya
                </span>

                <h1 class="text-dark fw-bolder mb-3 fs-2hx">Dapur Resep MPASI 🥑</h1>
                <p class="text-gray-600 fw-semibold fs-6 mb-6">
                    Catat dan bagikan panduan resep makanan pendamping ASI yang lezat dan mudah dibuat.
                </p>

                @if(\App\Support\Access::can('mpasi', 'create'))
                    <button type="button" class="btn btn-primary fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Resep MPASI
                    </button>
                @endif
            </div>

            <div class="d-none d-lg-block me-5 opacity-75">
                <i class="ki-outline ki-heart-circle text-info" style="font-size: 12rem;"></i>
            </div>
        </div>
    </div>
</div>

<!--begin::Main Card Data Table-->
<div class="card mb-5 mb-xl-8">
    
    <!--begin::Card Header / Toolbar-->
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center gap-2">
                <span class="text-gray-600 fs-7 fw-semibold">Show</span>
                <select class="form-select form-select-sm form-select-solid w-75px me-2" data-control="select2" data-hide-search="true">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-gray-600 fs-7 fw-semibold">entries</span>
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!-- Filter Usia -->
                <select id="filterUsia" class="form-select form-select-solid w-150px">
                    <option value="">Semua Usia</option>
                    @foreach($listKategori as $key => $label)
                        <option value="{{ strtolower($label) }}">{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Search Bar -->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4 text-gray-500"></i>
                    <input type="text" id="searchInput" class="form-control form-control-solid w-200px w-sm-250px ps-12" placeholder="Cari resep..." />
                </div>
            </div>
        </div>
    </div>
    <!--end::Card Header-->

    <!--begin::Card Body-->
    <div class="card-body py-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table table-row-bordered table-row-gray-200 align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 min-w-50px rounded-start">No</th>
                        <th class="min-w-250px">Judul & Gambar</th>
                        <th class="min-w-150px">Kategori Usia</th>
                        <th class="min-w-300px">Deskripsi / Bahan</th>
                        <th class="min-w-150px">Dibuat Oleh</th>
                        @if(\App\Support\Access::can('mpasi', 'update') || \App\Support\Access::can('mpasi', 'delete'))
                            <th class="min-w-100px text-center rounded-end">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <!--end::Table head-->

                <!--begin::Table body-->
                <tbody>
                    @forelse($dataMpasi as $index =>$item)
                        <tr>
                            <td class="ps-4">
                                <span class="text-gray-800 fw-bold fs-6">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $imgSrc = $item->mpasi_foto ? asset('storage/' . $item->mpasi_foto) : 'https://images.unsplash.com/photo-1547592180-85f173990554?w=100';
                                    @endphp
                                    <div class="symbol me-5 overflow-hidden rounded-3 border border-gray-200 cursor-pointer flex-shrink-0"
                                        style="width: 100px; height: 100px; min-width: 100px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#imagePreviewModal"
                                        onclick="openImageModal('{{ $imgSrc }}', '{{ addslashes($item->judul) }}')">
                                        <img src="{{ $imgSrc }}" class="object-fit-cover w-100 h-100" alt="{{ $item->judul }}" />
                                    </div>
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="javascript:void(0)" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $item->judul }}</a>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-muted fw-semibold fs-7">Resep MPASI</span>
                                            @if($item->url_video)
                                                <button type="button" class="btn btn-link p-0 text-danger fs-8 fw-bold btn-play-video" 
                                                        data-embed="{{ $item->embed_video_url }}" 
                                                        data-title="{{ $item->judul }}">
                                                    <i class="ki-outline ki-youtube fs-5 text-danger me-1"></i> Video
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($item->kategori_usia) {
                                        '6-8_bulan' => 'badge-light-warning',
                                        '9-11_bulan' => 'badge-light-info',
                                        '12-23_bulan' => 'badge-light-primary',
                                        default => 'badge-light-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} fs-7 fw-bold">
                                    {{ $listKategori[$item->kategori_usia] ?? $item->kategori_usia }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray-700 fw-semibold d-block fs-7 text-wrap max-w-300px">
                                    {{ Str::limit($item->deskripsi ?? $item->bahan, 120) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-gray-900 fw-bold d-block fs-7 text-uppercase">
                                    {{ $item->creator->name ?? 'Kominfo Kota Surabaya' }}
                                </span>
                            </td>
                            @if(\App\Support\Access::can('mpasi', 'update') || \App\Support\Access::can('mpasi', 'delete'))
                                <td class="text-center">
                                    {{-- Tombol Edit --}}
                                    @if(\App\Support\Access::can('mpasi', 'update'))
                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 btn-edit" 
                                                data-id="{{ $item->id_mpasi }}" title="Edit">
                                            <i class="ki-outline ki-pencil fs-2"></i>
                                        </button>
                                    @endif

                                    {{-- Tombol Delete --}}
                                    @if(\App\Support\Access::can('mpasi', 'delete'))
                                        <form action="{{ route('mpasi.destroy', $item->id_mpasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete" title="Hapus">
                                                <i class="ki-outline ki-trash fs-2"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-muted fs-6">
                                Belum ada data resep MPASI. Klik tombol <strong>+ Tambah Resep MPASI</strong> untuk menambahkan data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->

        <!--begin::Pagination Footer-->
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Menampilkan {{ $dataMpasi->count() }} data
            </div>
        </div>
        <!--end::Pagination Footer-->

    </div>
    <!--end::Card Body-->
</div>
<!--end::Main Card Data Table-->

<!--begin::Modal Tambah Data-->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form action="{{ route('mpasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-gray-900">Tambah Resep MPASI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Judul Resep</label>
                            <input type="text" name="judul" class="form-control form-control-solid" required placeholder="Contoh: BUBUR AYAM EDAMAME" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori Usia</label>
                            <select name="kategori_usia" class="form-select form-select-solid" required>
                                <option value="">-- Pilih Usia --</option>
                                @foreach($listKategori as $key =>$label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-solid" rows="2" placeholder="Penjelasan singkat resep..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bahan-Bahan</label>
                            <textarea name="bahan" class="form-control form-control-solid" rows="3" required placeholder="Daftar bahan makanan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Langkah Pembuatan</label>
                            <textarea name="langkah" class="form-control form-control-solid" rows="3" required placeholder="Langkah-langkah pembuatan..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gambar Resep</label>
                            <input type="file" name="mpasi_foto" class="form-control form-control-solid" accept="image/*" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">URL Video (YouTube / Google Drive)</label>
                            <input type="url" name="url_video" class="form-control form-control-solid" placeholder="https://..." />
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Resep</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Tambah Data-->

<!--begin::Modal Edit Data-->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form id="formEditMpasi" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-gray-900">Edit Resep MPASI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Judul Resep</label>
                            <input type="text" id="edit_judul" name="judul" class="form-control form-control-solid" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori Usia</label>
                            <select id="edit_kategori_usia" name="kategori_usia" class="form-select form-select-solid" required>
                                <option value="">-- Pilih Usia --</option>
                                @foreach($listKategori as $key =>$label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control form-control-solid" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bahan-Bahan</label>
                            <textarea id="edit_bahan" name="bahan" class="form-control form-control-solid" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Langkah Pembuatan</label>
                            <textarea id="edit_langkah" name="langkah" class="form-control form-control-solid" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ganti Gambar (Opsional)</label>
                            <input type="file" name="mpasi_foto" class="form-control form-control-solid" accept="image/*" />
                            <div id="previewGambarLama"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">URL Video (YouTube / Google Drive)</label>
                            <input type="url" id="edit_url_video" name="url_video" class="form-control form-control-solid" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Edit Data-->

<!--begin::Image Preview Modal-->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-gray-900" id="imageModalTitle">Preview Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-6">
                <img id="imageModalSrc" src="" class="img-fluid rounded-3 shadow-sm max-h-500px object-fit-contain" alt="Preview" />
            </div>
        </div>
    </div>
</div>
<!--end::Image Preview Modal-->

<!-- begin::Video Tutorial Modal -->
<div class="modal fade" id="modalVideo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-gray-900" id="modalVideoTitle">Video Tutorial MPASI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                    <iframe id="iframeVideo" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end::Video Tutorial Modal -->

@endsection

@section('js')
<script>
    function openImageModal(imageSrc, title) {
        $('#imageModalSrc').attr('src', imageSrc);
        $('#imageModalTitle').text(title);
    }

    $(document).ready(function () {

    $(document).on('click', '.btn-play-video', function () {
        let embedUrl = $(this).data('embed');
        let title = $(this).data('title');

        if (!embedUrl) {
            Swal.fire('Informasi', 'Link video tidak valid atau belum diisi.', 'warning');
            return;
        }

        $('#modalVideoTitle').text(title);
        $('#iframeVideo').attr('src', embedUrl);
        $('#modalVideo').modal('show');
    });

    $('#modalVideo').on('hidden.bs.modal', function () {
        $('#iframeVideo').attr('src', '');
    });


    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');
        let updateUrl = `/mpasi/${id}`;

        $('#formEditMpasi').attr('action', updateUrl);

        $.ajax({
            url: updateUrl,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    let data = response.data;

                    $('#edit_judul').val(data.judul);
                    $('#edit_kategori_usia').val(data.kategori_usia);
                    $('#edit_deskripsi').val(data.deskripsi);
                    $('#edit_bahan').val(data.bahan);
                    $('#edit_langkah').val(data.langkah);
                    $('#edit_url_video').val(data.url_video);

                    if (data.mpasi_foto) {
                        $('#previewGambarLama').html(`
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Foto saat ini:</small>
                                <img src="/storage/${data.mpasi_foto}" class="rounded h-60px object-fit-cover border">
                            </div>
                        `);
                    } else {
                        $('#previewGambarLama').empty();
                    }

                    $('#modalEdit').modal('show');
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal mengambil data MPASI', 'error');
            }
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data menu MPASI ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f1416c',
            cancelButtonColor: '#78829d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('#searchInput').on('keyup', function () {
        let value = $(this).val().toLowerCase().trim();

        $('tbody tr').each(function () {
            // Abaikan baris kosong/empty state
            if ($(this).find('td').length <= 1) return;

            let rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(value) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    function applyTableFilter() {
    let searchText = $('#searchInput').val().toLowerCase().trim();
    let selectedUsia = $('#filterUsia').val().toLowerCase().trim();

    $('tbody tr').each(function () {
        if ($(this).find('td').length <= 1) return;

            let rowText = $(this).text().toLowerCase();

            let matchSearch = searchText === '' || rowText.indexOf(searchText) > -1;
            let matchUsia = selectedUsia === '' || rowText.indexOf(selectedUsia) > -1;

            if (matchSearch && matchUsia) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $('#searchInput').on('keyup', applyTableFilter);
    $('#filterUsia').on('change', applyTableFilter);
    

});
</script>
@endsection