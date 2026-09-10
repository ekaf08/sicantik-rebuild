<!--begin::Modal Edit Data-->
<div class="modal fade" id="kt_modal_edit_data" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title fw-bold text-white">Edit Data</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <h6 class="fw-bold text-uppercase mb-5" id="modalEditDataSubtitle">Krisan Volume</h6>

                <div class="table-responsive">
                    <table id="kt_table_edit_data" class="table table-bordered align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold fs-7 text-uppercase bg-light text-center">
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>KECAMATAN</th>
                                <th>KELURAHAN</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th>TAHAP</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            {{-- kosong dulu, nanti diisi data lewat AJAX/DataTables --}}
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!--end::Modal Edit Data-->