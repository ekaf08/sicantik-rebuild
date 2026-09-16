<div class="modal fade" id="kt_modal_gkstb" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold" id="modalGkstbTitle">GKSTTB</h3>
            </div>
            <div class="modal-body pt-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7">Show</span>
                        <select id="gkstbPageSize" class="form-select form-select-sm form-select-solid w-75px">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7">Search:</span>
                        <input type="text" id="gkstbSearch" class="form-control form-control-sm form-control-solid w-200px">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-200 align-middle text-start gy-4 gs-0">
                        <thead>
                            <tr class="fw-bold fs-7 text-gray-700 bg-light-secondary border-bottom">
                                <th class="ps-3 w-50px">No</th>
                                <th class="min-w-200px">Nama Proyek</th>
                                <th class="min-w-150px">Kategori</th>
                                <th class="min-w-120px">Kelurahan</th>
                                <th class="min-w-120px">Kecamatan</th>
                                <th class="text-center w-80px pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="gkstbTbody" class="fs-7 text-gray-800">
                            <!-- Injected via JS -->
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5">
                    <span id="gkstbInfo" class="text-gray-600 fs-7"></span>
                    <div id="gkstbPagination" class="d-flex gap-1"></div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>