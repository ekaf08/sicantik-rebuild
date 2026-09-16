<!--begin::Modal Detail Pengurus-->
<div class="modal fade" id="kt_modal_detail_pengurus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDetailPengurusTitle">Detail Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="kt_table_pengurus" class="table table-bordered table-striped align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold fs-7 text-uppercase bg-light text-center">
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>KELAMIN</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th>ALAMAT</th>
                                <th>NO HP</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td>1</td>
                                <td>3578285803800001</td>
                                <td class="text-start">DUROTUL AINI</td>
                                <td>PEREMPUAN</td>
                                <td>4</td>
                                <td>1</td>
                                <td class="text-start">OREGES BARAT GG.MAKAM NO. 31</td>
                                <td>081290963145</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-light btn-aksi-terkunci">
                                        <i class="bi bi-lock-fill "></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>3578285212730002</td>
                                <td class="text-start">LAILATUL ILMIA</td>
                                <td>PEREMPUAN</td>
                                <td>2</td>
                                <td>2</td>
                                <td class="text-start">GENTING TAMBAK DALAM VI NO. 5</td>
                                <td>085745918685</td>
                                <td>
                                    <button class="btn btn-sm btn-icon btn-light btn-aksi-terkunci">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal Detail Pengurus-->

<!--begin::Modal Edit Data Volume-->
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
<!--end::Modal Edit Data Volume-->

<!--begin::Modal Edit Data Peserta-->
<div class="modal fade" id="kt_modal_edit_data_peserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title fw-bold text-white">Edit Data</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <h6 class="fw-bold text-uppercase mb-5" id="modalEditDataPesertaSubtitle">Kisah Peserta</h6>

                <div class="table-responsive">
                    <table id="kt_table_edit_data_peserta" class="table table-bordered align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold fs-7 text-uppercase bg-light text-center">
                                <th>NO</th>
                                <th>NIK</th>
                                <th>NAMA</th>
                                <th>NIK IBU</th>
                                <th>NAMA IBU</th>
                                <th>ALAMAT</th>
                                <th>KECAMATAN</th>
                                <th>KELURAHAN</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            {{-- kosong dulu --}}
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!--end::Modal Edit Data Peserta-->