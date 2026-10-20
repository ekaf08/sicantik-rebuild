@extends('bo.layout.app')

@section('content')
    @php
        // Peta wilayah dari database: { id_kecamatan: { nama, kel: [ {id, nama} ] } }
        $wil = [];
        foreach (($kecamatan ?? []) as $k) {
            if (!empty($k->deleted_at ?? null)) { continue; }
            $kid = $k->id_kec ?? ($k->id_kecamatan ?? ($k->id ?? null));
            if ($kid === null) { continue; }
            $wil[$kid] = ['nama' => $k->nama_kec ?? ($k->nama_kecamatan ?? ($k->nama ?? '')), 'kel' => []];
        }
        foreach (($kelurahan ?? []) as $l) {
            $kid = $l->no_kec ?? ($l->id_kec ?? ($l->kecamatan_id ?? ($l->id_kecamatan ?? null)));
            if ($kid !== null && isset($wil[$kid])) {
                $wil[$kid]['kel'][] = [
                    'id'   => $l->id_kel ?? ($l->id_kelurahan ?? ($l->id ?? '')),
                    'nama' => $l->nama_kel ?? ($l->nama_kelurahan ?? ($l->nama ?? '')),
                ];
            }
        }
    @endphp
    <!-- SweetAlert2 untuk pop-up notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Teks tabel Penghargaan: hitam tegas */
        #kt_table_penghargaan thead th { color: #000 !important; font-weight: 800 !important; }
        #kt_table_penghargaan tbody td { color: #000 !important; }
    </style>
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">

                <!-- Banner Header Hijau Tema SiCantik -->
                <div class="card mb-7 border-0 position-relative overflow-hidden"
                    style="background-color: #0d5c3a; border-radius: 12px;">
                    <div
                        class="card-body p-8 text-white d-flex align-items-center justify-content-between position-relative z-index-1">
                        <div>
                            <h1 class="text-white fw-bolder fs-2hx mb-2" style="letter-spacing: 0.5px;">PENGHARGAAN</h1>
                            <p class="fs-6 text-white opacity-80 mb-0">Data Penghargaan Kota Surabaya</p>
                        </div>
                    </div>
                </div>

                <!-- Card Utama -->
                <div class="card card-flush">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title flex-column">
                            <h2 class="fw-bold mb-1">Data Penghargaan</h2>
                            <span class="text-muted fs-7">Daftar capaian dan dokumentasi penghargaan Kota Surabaya</span>
                        </div>

                        <!-- Toolbar Filter & Button Tambah -->
                        <div class="card-toolbar gap-3">
                            <!-- Filter Kecamatan -->
                            <select id="filter_kecamatan" class="form-select form-select-solid w-175px">
                                <option value="">Semua Kecamatan</option>
                            </select>

                            <!-- Filter Kelurahan -->
                            <select id="filter_kelurahan" class="form-select form-select-solid w-175px" disabled>
                                <option value="">Semua Kelurahan</option>
                            </select>

                            <!-- Filter Tahun -->
                            <select id="filter_tahun" class="form-select form-select-solid w-125px">
                                <option value="">Semua Tahun</option>
                                @for ($t = 2030; $t >= 2020; $t--)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>

                            <!-- Tombol Tambah Penghargaan Hijau Tema -->
                            <button type="button" class="btn fw-bold text-white px-6" style="background-color: #0d5c3a;"
                                data-bs-toggle="modal" data-bs-target="#modal_tambah_penghargaan">
                                <i class="ki-outline ki-plus fs-2 text-white me-1"></i> Tambah Penghargaan
                            </button>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <!-- Input Search Real-time -->
                        <div class="d-flex align-items-center position-relative my-5">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5 text-gray-500"></i>
                            <input type="text" id="search_penghargaan"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search..." />
                        </div>

                        <!-- Tabel Data Penghargaan -->
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_penghargaan">
                                <thead>
                                    <tr class="text-start text-gray-900 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="w-50px">NO</th>
                                        <th>NAMA PENGHARGAAN</th>
                                        <th>DESKRIPSI PENGHARGAAN</th>
                                        <th>KATEGORI PENGHARGAAN</th>
                                        <th>TAHUN</th>
                                        <th>FOTO</th>
                                        <th>FILE</th>
                                        <th>DIBUAT OLEH</th>
                                        <th class="text-end">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-900">
                                    @if (isset($penghargaan) && count($penghargaan) > 0)
                                        @foreach ($penghargaan as $index =>$item)
                                            <tr data-kec="{{ $item->kecamatan_id ?? '' }}" data-kel="{{ $item->kelurahan_id ?? '' }}" data-tahun="{{ $item->tahun }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td class="fw-bold text-gray-800">{{ $item->nama_penghargaan }}</td>
                                                <td>{{ $item->deskripsi_penghargaan }}</td>
                                                <td><span
                                                        class="badge badge-light-success fw-bold fs-8">{{ $item->kategori_penghargaan }}</span>
                                                </td>
                                                <td>{{ $item->tahun }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-light-success fw-bold px-3"
                                                        onclick="previewFoto('{{ asset('storage/' . $item->foto) }}')">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat Foto
                                                    </button>
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                                        class="btn btn-sm btn-light-success fw-bold px-3">
                                                        <i class="ki-outline ki-eye fs-5"></i> Lihat File
                                                    </a>
                                                </td>
                                                <td>{{ $item->created_by ?? 'Admin' }}</td>
                                                <td class="text-end">
                                                    <button type="button"
                                                        class="btn btn-icon btn-light-primary btn-sm me-1"
                                                        onclick="editPenghargaan({{ json_encode($item) }})">
                                                        <i class="ki-outline ki-pencil fs-2"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-light-danger btn-sm"
                                                        onclick="hapusPenghargaan('{{ $item->id }}', '{{$item->nama_penghargaan }}')">
                                                        <i class="ki-outline ki-trash fs-2"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-10 fs-6">Belum ada data
                                                penghargaan.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Penghargaan -->
    <div class="modal fade" id="modal_tambah_penghargaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0d5c3a;">
                    <h2 class="fw-bold text-white mb-0">Tambah Data Penghargaan</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('penghargaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body py-8 px-lg-10">
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Nama Penghargaan</label>
                            <input type="text" class="form-control form-control-solid" name="nama_penghargaan"
                                placeholder="Masukkan nama penghargaan" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Deskripsi Penghargaan</label>
                            <textarea class="form-control form-control-solid" rows="3" name="deskripsi_penghargaan"
                                placeholder="Masukkan deskripsi" required></textarea>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kategori Penghargaan</label>
                                <input type="text" class="form-control form-control-solid" name="kategori_penghargaan"
                                    placeholder="Pemerintahan / Inovasi" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                                <input type="text" class="form-control form-control-solid" name="tahun"
                                    placeholder="2026" maxlength="4" required />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kecamatan</label>
                                <select class="form-select form-select-solid" id="add_kecamatan_id" name="kecamatan_id" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kelurahan</label>
                                <select class="form-select form-select-solid" id="add_kelurahan_id" name="kelurahan_id" required disabled>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Upload Foto (JPG/PNG, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="foto"
                                accept=".jpg,.jpeg,.png" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Upload File Dokumen (PDF/DOC/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file"
                                accept=".pdf,.doc,.docx" required />
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn fw-bold text-white px-8"
                            style="background-color: #0d5c3a;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Penghargaan -->
    <div class="modal fade" id="modal_edit_penghargaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0d5c3a;">
                    <h2 class="fw-bold text-white mb-0">Edit Data Penghargaan</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit_penghargaan" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-8 px-lg-10">
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Nama Penghargaan</label>
                            <input type="text" class="form-control form-control-solid" id="edit_nama_penghargaan" name="nama_penghargaan" required />
                        </div>
                        <div class="mb-5">
                            <label class="required fs-6 fw-semibold mb-2">Deskripsi Penghargaan</label>
                            <textarea class="form-control form-control-solid" rows="3" id="edit_deskripsi_penghargaan" name="deskripsi_penghargaan" required></textarea>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kategori Penghargaan</label>
                                <input type="text" class="form-control form-control-solid" id="edit_kategori_penghargaan" name="kategori_penghargaan" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Tahun</label>
                                <input type="text" class="form-control form-control-solid" id="edit_tahun" name="tahun" maxlength="4" required />
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kecamatan</label>
                                <select class="form-select form-select-solid" id="edit_kecamatan_id" name="kecamatan_id" >
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="required fs-6 fw-semibold mb-2">Kelurahan</label>
                                <select class="form-select form-select-solid" id="edit_kelurahan_id" name="kelurahan_id"  disabled>
                                    <option value="">Pilih Kelurahan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="fs-6 fw-semibold mb-2">Ganti Foto (Opsional, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="foto" accept=".jpg,.jpeg,.png" />
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                        </div>
                        <div class="mb-5">
                            <label class="fs-6 fw-semibold mb-2">Ganti File Dokumen (PDF/DOC/DOCX, Max 2MB)</label>
                            <input type="file" class="form-control form-control-solid" name="file" accept=".pdf,.doc,.docx" />
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file.</small>
                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn fw-bold text-white px-8" style="background-color: #0d5c3a;">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview Foto -->
    <div class="modal fade" id="modal_preview_foto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Preview Foto Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <img id="img_preview" src="" class="img-fluid rounded shadow-sm" alt="Foto Penghargaan" />
                </div>
            </div>
        </div>
    </div>

    <!-- Form Hidden Delete -->
    <form id="form_delete_penghargaan" action="" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>

    <script>
    // 1. Fungsi Edit Data
    function editPenghargaan(data) {
        $('#form_edit_penghargaan').attr('action', `/penghargaan/update/${data.id}`);
        $('#edit_nama_penghargaan').val(data.nama_penghargaan);
        $('#edit_deskripsi_penghargaan').val(data.deskripsi_penghargaan);
        $('#edit_kategori_penghargaan').val(data.kategori_penghargaan);
        $('#edit_tahun').val(data.tahun);
        $('#edit_kecamatan_id').val(data.kecamatan_id || '');
        isiKel(document.getElementById('edit_kelurahan_id'), data.kecamatan_id, 'Pilih Kelurahan', data.kelurahan_id);

        var modalEdit = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_edit_penghargaan'));
        modalEdit.show();
    }

    // 2. Wilayah (kecamatan -> kelurahan) dari database
    var WILAYAH = @json($wil, JSON_FORCE_OBJECT);

    function urutNama(ids) {
        return ids.sort(function (x, y) { return String(WILAYAH[x].nama).localeCompare(String(WILAYAH[y].nama)); });
    }
    function isiKec(select, placeholder) {
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        urutNama(Object.keys(WILAYAH)).forEach(function (id) { select.appendChild(new Option(WILAYAH[id].nama, id)); });
    }
    function isiKel(select, kecId, placeholder, terpilih) {
        select.innerHTML = '<option value="">' + placeholder + '</option>';
        var list = (kecId && WILAYAH[kecId]) ? Object.values(WILAYAH[kecId].kel) : [];
        list.sort(function (x, y) { return String(x.nama).localeCompare(String(y.nama)); })
            .forEach(function (k) { select.appendChild(new Option(k.nama, k.id)); });
        select.disabled = list.length === 0;
        if (terpilih) select.value = terpilih;
    }

    // 2b. Filter tabel (Kecamatan, Kelurahan, Tahun) + pencarian
    var tabelPenghargaan = null;

    function cocokFilter(tr) {
        var kec = document.getElementById('filter_kecamatan').value;
        var kel = document.getElementById('filter_kelurahan').value;
        var thn = document.getElementById('filter_tahun').value;
        if (kec && tr.dataset.kec !== kec) return false;
        if (kel && tr.dataset.kel !== kel) return false;
        if (thn && tr.dataset.tahun !== thn) return false;
        return true;
    }
    function terapkanFilter() {
        if (tabelPenghargaan) { tabelPenghargaan.draw(); return; }
        var q = document.getElementById('search_penghargaan').value.toLowerCase();
        document.querySelectorAll('#kt_table_penghargaan tbody tr').forEach(function (tr) {
            var tampil = cocokFilter(tr) && tr.textContent.toLowerCase().indexOf(q) !== -1;
            tr.style.display = tampil ? '' : 'none';
        });
    }

    // 3. Preview Foto
    function previewFoto(url) {
        $('#img_preview').attr('src', url);
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_preview_foto'));
        modal.show();
    }

    // 4. Pop-up Konfirmasi & Proses Hapus
    function hapusPenghargaan(id, nama) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin menghapus ${nama}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yakin',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger fw-bold px-6 me-2',
                cancelButton: 'btn btn-success fw-bold px-6'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('form_delete_penghargaan');
                form.action = `/penghargaan/delete/${id}`;

                form.submit();
            }
        });
    }

    // 5. Pop-up notifikasi (hijau = berhasil, merah = gagal)
    function tampilPopup(opsi) {
        if (typeof Swal === 'undefined') { alert(opsi.text || opsi.title); return; }
        Swal.fire(Object.assign({
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'btn fw-bold px-6 ' + (opsi.icon === 'error' ? 'btn-danger' : 'btn-success')
            }
        }, opsi));
    }

    // Dijalankan setelah SEMUA script halaman (jQuery, DataTables, SweetAlert) selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {

        @if (session('success_store'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Berhasil menambahkan data' });
        @endif

        @if (session('success_update') || session('success'))
            tampilPopup({ icon: 'success', title: 'Berhasil', text: 'Edit data telah berhasil' });
        @endif

        @if (session('success_delete'))
            tampilPopup({ icon: 'success', title: 'Berhasil Dihapus', text: @json(session('success_delete')) });
        @endif

        @if ($errors->any())
            tampilPopup({ icon: 'error', title: 'Gagal Simpan Data', html: @json(implode('<br>', array_map('e', $errors->all()))) });
        @endif

        @if (session('error'))
            tampilPopup({ icon: 'error', title: 'Gagal', text: @json(session('error')) });
        @endif

        // Isi dropdown wilayah
        isiKec(document.getElementById('filter_kecamatan'), 'Semua Kecamatan');
        isiKec(document.getElementById('add_kecamatan_id'), 'Pilih Kecamatan');
        isiKec(document.getElementById('edit_kecamatan_id'), 'Pilih Kecamatan');

        document.getElementById('filter_kecamatan').addEventListener('change', function () {
            isiKel(document.getElementById('filter_kelurahan'), this.value, 'Semua Kelurahan');
            terapkanFilter();
        });
        document.getElementById('filter_kelurahan').addEventListener('change', terapkanFilter);
        document.getElementById('filter_tahun').addEventListener('change', terapkanFilter);

        document.getElementById('add_kecamatan_id').addEventListener('change', function () {
            isiKel(document.getElementById('add_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });
        document.getElementById('edit_kecamatan_id').addEventListener('change', function () {
            isiKel(document.getElementById('edit_kelurahan_id'), this.value, 'Pilih Kelurahan');
        });

        // Tabel + pencarian
        try {
            var punyaData = document.querySelectorAll('#kt_table_penghargaan tbody tr td[colspan]').length === 0;
            if (window.jQuery && $.fn.DataTable && punyaData) {
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (settings.nTable.id !== 'kt_table_penghargaan') return true;
                    return cocokFilter(settings.aoData[dataIndex].nTr);
                });
                tabelPenghargaan = $('#kt_table_penghargaan').DataTable({ "info": false, 'order': [], 'pageLength': 10 });
                $('#search_penghargaan').on('keyup', function () { tabelPenghargaan.search(this.value).draw(); });
            } else {
                document.getElementById('search_penghargaan').addEventListener('input', terapkanFilter);
            }
        } catch (e) { console.error(e); }
    });
</script>
@endsection
