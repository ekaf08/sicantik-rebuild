<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 border-bottom pb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">Si Cantik (Sistem Informasi Pencatatan Kegiatan dan Inovasi PKK Kota Surabaya)</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative">
                    <input type="text" id="search-sicantik-input" class="form-control form-control-sm ps-9" placeholder="Cari inovasi..." style="min-width: 200px;">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 translate-middle-y ms-3 text-muted fs-7"></i>
                </div>
            </div>
        </div>

        <div class="table-custom-wrapper">
            <div class="table-responsive mb-0">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th style="min-width: 200px;">Judul</th>
                            <th style="min-width: 280px;">Deskripsi</th>
                            <th class="text-center" style="width: 120px;">Gambar</th>
                            <th style="min-width: 160px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="table-sicantik-body">
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="spinner-border spinner-border-sm text-success mb-2" role="status"></div>
                                <div class="text-muted small fw-semibold">Memuat data Si Cantik...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-4 mt-1 border-top">
            <span class="text-dark small fw-semibold" id="table-sicantik-info">
                Showing 0 to 0 of 0 entries
            </span>
            <nav aria-label="Navigasi Halaman Si Cantik">
                <ul class="pagination pagination-sm mb-0" id="table-sicantik-pagination">
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-preview-sicantik" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-content-modern bg-white">
            <div class="modal-header border-bottom px-4 py-3">
                <h6 class="modal-title fw-bold text-dark fs-6" id="modal-preview-sicantik-title">Preview Gambar</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center" style="min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <img id="modal-preview-sicantik-img" src="" class="img-fluid rounded shadow-sm" style="max-height: 480px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/custom/pages/inovasi/inovasi-sicantik.js') }}?v={{ time() }}"></script>