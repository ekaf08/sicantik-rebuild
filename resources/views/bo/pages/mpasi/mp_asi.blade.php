@extends('bo.layout.app')

@section('content')

<!--begin::Card Banner Header-->
<div class="card bg-light-primary border-0 mb-5 mb-xl-8 overflow-hidden position-relative">
    <div class="card-body p-8 p-lg-10">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-5 position-relative z-index-1">
            <div class="max-w-md-500px">
                <h1 class="text-dark fw-bold mb-3 fs-2hx">Data Resep MPASI</h1>
                <p class="text-gray-600 fw-semibold fs-6 mb-5">
                    Berikut adalah data resep MPASI yang telah diinputkan ke dalam sistem secara terpusat.
                </p>
                <a href="#" class="btn btn-primary fw-bold px-6 py-3">
                    <i class="ki-outline ki-plus fs-2 me-1"></i> Tambah Resep MPASI
                </a>
            </div>
            <!-- Illustration / Decorative Icon -->
            <div class="d-none d-lg-block opacity-75">
                <i class="ki-outline ki-note-2 text-primary" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
</div>
<!--end::Card Banner Header-->

<!--begin::Main Card Data Table-->
<div class="card mb-5 mb-xl-8">
    
    <!--begin::Card Header / Toolbar (Show entries & Search)-->
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
            <div class="d-flex align-items-center position-relative my-1">
                <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari resep..." />
            </div>
        </div>
    </div>
    <!--end::Card Header-->

    <!--begin::Card Body-->
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bold text-muted bg-light">
                        <th class="ps-4 min-w-50px rounded-start">No</th>
                        <th class="min-w-250px">Judul & Gambar</th>
                        <th class="min-w-150px">Kategori Usia</th>
                        <th class="min-w-300px">Deskripsi</th>
                        <th class="min-w-175px">Dibuat Oleh</th>
                        <th class="min-w-100px text-end rounded-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <!--end::Table head-->

                <!--begin::Table body-->
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td class="ps-4">
                            <span class="text-gray-800 fw-bold fs-6">1</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5 overflow-hidden rounded-3 border border-gray-200 cursor-pointer"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imagePreviewModal"
                                    onclick="openImageModal('https://images.unsplash.com/photo-1547592180-85f173990554?w=800', 'sop pencegah stunting')">
                                    <img src="https://images.unsplash.com/photo-1547592180-85f173990554?w=100" class="object-fit-cover w-100 h-100" alt="sop pencegah stunting" />
                                </div>
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">sop pencegah stunting</a>
                                        <span class="text-muted fw-semibold d-block fs-7">Resep MPASI</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-primary fs-7 fw-bold">Usia 12 - 23 Bulan</span>
                        </td>
                        <td>
                            <span class="text-gray-700 fw-semibold d-block fs-7 text-wrap max-w-300px">
                                pembuatan sop dengan sayur lengkap dan tanpa garam dan MSG
                            </span>
                        </td>
                        <td>
                            <span class="text-gray-900 fw-bold d-block fs-7">SEKETARIS</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td class="ps-4">
                            <span class="text-gray-800 fw-bold fs-6">2</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                 <div class="symbol symbol-50px me-5 overflow-hidden rounded-3 border border-gray-200 cursor-pointer"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imagePreviewModal">
                                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=100&auto=format&fit=crop&q=80" class="object-fit-cover w-100 h-100" alt="NASI TIM UDANG PELANGI 1" />
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">NASI TIM UDANG PELANGI 1</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Resep MPASI</span>
                                </div>
                                 </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-info fs-7 fw-bold">Usia 9 - 11 Bulan</span>
                        </td>
                        <td>
                            <span class="text-gray-700 fw-semibold d-block fs-7 text-wrap max-w-300px">
                                Nasi tim dengan aneka warna sayuran (pelangi) seperti wortel, labu, dan buncis, yang dipadukan dengan udang cincang. Menu ini memastikan si Kecil mendapatkan beragam vitamin dan antioksidan dari berbagai jenis sayuran.
                            </span>
                        </td>
                        <td>
                            <span class="text-gray-900 fw-bold d-block fs-7">SEKRETARIS PKK KOTA SURABAYA</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr>
                        <td class="ps-4">
                            <span class="text-gray-800 fw-bold fs-6">3</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5 overflow-hidden rounded-3 border border-gray-200 cursor-pointer"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#imagePreviewModal">
                                        <img src="https://images.unsplash.com/photo-1525351484163-7529414344d8?w=100&auto=format&fit=crop&q=80" class="object-fit-cover w-100 h-100" alt="ROTI PANGGANG ALPUKAT" />
                                    </div>
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">ROTI PANGGANG ALPUKAT</a>
                                        <span class="text-muted fw-semibold d-block fs-7">Resep MPASI</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-primary fs-7 fw-bold">Usia 12 - 23 Bulan</span>
                        </td>
                        <td>
                            <span class="text-gray-700 fw-semibold d-block fs-7 text-wrap max-w-300px">
                                Camilan cepat dan berlemak sehat. Roti tawar dipanggang sebentar hingga renyah, lalu diolesi dengan alpukat matang yang kaya akan lemak tak jenuh tunggal. Sempurna sebagai sumber energi dan lemak baik untuk si Kecil
                            </span>
                        </td>
                        <td>
                            <span class="text-gray-900 fw-bold d-block fs-7">SEKRETARIS PKK KOTA SURABAYA</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr>
                        <td class="ps-4">
                            <span class="text-gray-800 fw-bold fs-6">4</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5 overflow-hidden rounded-3 border border-gray-200">
                                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&auto=format&fit=crop&q=80" class="object-fit-cover w-100 h-100" alt="BUBUR AYAM EDAMAME" />
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">BUBUR AYAM EDAMAME</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Resep MPASI</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-light-warning fs-7 fw-bold">Usia 6 - 8 Bulan</span>
                        </td>
                        <td>
                            <span class="text-gray-700 fw-semibold d-block fs-7 text-wrap max-w-300px">
                                Bubur klasik yang ditingkatkan nutrisinya. Ayam cincang/suwir (protein hewani) dipadukan dengan edamame yang kaya protein nabati dan asam folat. Kombinasi protein ganda ini sangat baik untuk pertumbuhan sel dan otot.
                            </span>
                        </td>
                        <td>
                            <span class="text-gray-900 fw-bold d-block fs-7">SEKRETARIS PKK KOTA SURABAYA</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" title="Hapus">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->

        <!--begin::Pagination Footer-->
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Menampilkan 1 sampai 4 dari 4 data
            </div>
            <ul class="pagination">
                <li class="page-item previous disabled"><a href="#" class="page-link"><i class="previous"></i></a></li>
                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                <li class="page-item next disabled"><a href="#" class="page-link"><i class="next"></i></a></li>
            </ul>
        </div>
        <!--end::Pagination Footer-->

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

        <!--begin::Modal Script-->
        <script>
            function openImageModal(imageSrc, title) {
                document.getElementById('imageModalSrc').src = imageSrc;
                document.getElementById('imageModalTitle').textContent = title;
            }

            function formModal() {
                
            }
        </script>
        <!--end::Modal Script-->

    </div>
    <!--end::Card Body-->
</div>
<!--end::Main Card Data Table-->

@endsection