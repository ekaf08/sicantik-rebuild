<!-- Modal GKSTB -->
<div class="modal fade" id="kt_modal_gkstb" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold" id="modalGkstbTitle">GKSTTB</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<!-- Modal Detail Imunisasi Balita -->
<div class="modal fade" id="kt_modal_detail_imunisasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-uppercase" id="modalDetailImunisasiTitle">DETAIL IMUNISASI BALITA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="kt_table_detail_imunisasi" class="table align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold fs-7 text-uppercase text-center bg-primary text-white">
                                <th>NO</th>
                                <th>NO KK</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>JENIS KELAMIN</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>ALAMAT</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            {{-- Data dipopulasi via AJAX / DataTables --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_kader_hebat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-uppercase" id="modalKaderHebatTitle">Detail Jumlah Kader</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-5">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7">Show</span>
                        <select id="kaderHebatPageSize" class="form-select form-select-sm form-select-solid w-75px">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-gray-600 fs-7">Search:</span>
                        <input type="text" id="kaderHebatSearch" class="form-control form-control-sm form-control-solid w-200px">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-200 align-middle text-center gy-4 gs-0">
                        <thead>
                            <tr class="fw-bold fs-7 text-uppercase bg-primary text-white">
                                <th class="ps-3 w-50px">No</th>
                                <th class="min-w-150px">NIK</th>
                                <th class="min-w-200px text-start">Nama Kader</th>
                                <th class="min-w-100px">Role</th>
                                <th class="min-w-120px">Jenis Kelamin</th>
                                <th class="min-w-120px">Kecamatan</th>
                                <th class="min-w-120px pe-3">Kelurahan</th>
                            </tr>
                        </thead>
                        <tbody id="kaderHebatTbody" class="fs-7 text-gray-800">
                            <!-- Injected via JS -->
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5">
                    <span id="kaderHebatInfo" class="text-gray-600 fs-7"></span>
                    <div id="kaderHebatPagination" class="d-flex gap-1"></div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>