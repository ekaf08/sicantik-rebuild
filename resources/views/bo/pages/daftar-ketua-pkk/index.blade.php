@extends('bo.layout.app')

@section('content')
<div class="card card-flush shadow-sm">
    <div class="card-body p-6 p-md-8">
        <form id="formUploadKetuaPkk" onsubmit="handleUploadPdf(event)" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold text-gray-800 fs-6 mb-2">Upload Dokumen</label>
                <div class="d-flex flex-column gap-1">
                    <input type="file" 
                           id="file_dokumen" 
                           name="file_dokumen" 
                           class="form-control form-control-solid border border-gray-300" 
                           accept=".pdf,application/pdf" 
                           onchange="handleDokumenFileChange(this)"
                           required>
                    <span class="text-danger fs-8">File harus di bawah 5MB dan berformat pdf.</span>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-6">
                <button type="submit" id="btnUpload" class="btn btn-primary fw-semibold px-6 py-2 fs-7" style="background-color: #3b82f6; border-color: #3b82f6;">
                    <span id="btnUploadSpinner" class="spinner-border spinner-border-sm align-middle me-2 d-none" role="status"></span>
                    <span id="btnUploadText">Upload</span>
                </button>

                <button type="button" 
                        id="btnHapusDoc" 
                        class="btn btn-danger btn-sm fw-semibold px-5 py-2 {{ $latestDoc ? '' : 'd-none' }}" 
                        onclick="konfirmasiHapusDoc('{{ $latestDoc ? $latestDoc->hash : '' }}')">
                    Hapus Dokumen
                </button>
            </div>
        </form>

        <hr class="text-gray-300 my-6">

        <div class="w-100" style="height: 85vh; min-height: 600px; background-color: #525659; border-radius: 4px; overflow: hidden; position: relative;">
            <iframe id="pdfViewer" 
                    src="{{ $pdfUrl ? $pdfUrl . '#toolbar=1&navpanes=1' : '' }}" 
                    width="100%" 
                    height="100%" 
                    style="border: none; display: {{ $pdfUrl ? 'block' : 'none' }};">
            </iframe>
            
            <div id="emptyPdfPlaceholder" 
                 class="h-100 d-flex flex-column justify-content-center align-items-center text-white" 
                 style="display: {{ $pdfUrl ? 'none' : 'flex' }}; min-height: 450px;">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3 opacity-50">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="fs-6 opacity-75">Belum ada dokumen PDF yang diunggah. Silakan upload file terlebih dahulu.</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotifikasiPesan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-350px">
        <div class="modal-content text-center p-6 border-0 shadow-lg rounded-4">
            <div class="modal-body p-0">
                <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background-color: #d1fae5;">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h4 class="fw-bolder text-gray-900 fs-5 mb-2" id="notifikasiPesanTitle">Sukses</h4>
                <p class="text-gray-600 fs-7 mb-5" id="notifikasiPesanText">Data berhasil diproses</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary btn-sm fw-semibold px-6 rounded-3" style="background-color: #0f5847; border-color: #0f5847;" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-400px">
        <div class="modal-content text-center p-6 border-0 shadow-lg rounded-4">
            <div class="modal-body p-0">
                <div class="mb-4 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 72px; height: 72px; background-color: #fee2e2;">
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </div>

                <h3 class="fw-bolder text-gray-900 fs-4 mb-2">Hapus Dokumen?</h3>
                <p class="text-gray-600 fs-7 mb-6">
                    Apakah Anda yakin ingin menghapus berkas dokumen ini? Berkas yang telah dihapus tidak dapat dipulihkan.
                </p>

                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light btn-sm fw-semibold px-5 rounded-3" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" id="btnProsesHapus" class="btn btn-danger btn-sm fw-semibold px-5 rounded-3 d-flex align-items-center justify-content-center" style="min-width: 100px;">
                        <span id="btnHapusSpinner" class="spinner-border spinner-border-sm align-middle me-2 d-none" role="status"></span>
                        <span id="btnHapusText">Ya, Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ROUTES_KETUA_PKK = {
        upload: "{{ route('ketua-pkk.upload') }}",
        destroy: "{{ url('/daftar-ketua-pkk/destroy') }}",
        csrfToken: "{{ csrf_token() }}"
    };

    let currentDocHash = "{{ $latestDoc ? $latestDoc->hash : '' }}";
    let targetHashHapus = null;

    function handleDokumenFileChange(input) {
        const label = document.getElementById('file_dokumen_label');
        const file = input.files && input.files[0];

        if (!file) {
            label.textContent = 'Belum ada file yang dipilih';
            label.className = 'text-muted fs-8 fw-semibold mt-1';
            return;
        }

        const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
        if (!isPdf) {
            alert('Format berkas wajib PDF.');
            input.value = '';
            label.textContent = 'Format berkas tidak sesuai (wajib PDF)';
            label.className = 'text-danger fs-8 fw-semibold mt-1';
            return;
        }

        const maxSizeInBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeInBytes) {
            alert('Ukuran file maksimal adalah 5MB.');
            input.value = '';
            label.textContent = 'Ukuran berkas melebihi batas 5 MB';
            label.className = 'text-danger fs-8 fw-semibold mt-1';
            return;
        }

        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        label.textContent = `File terpilih: ${file.name} (${sizeMB} MB)`;
        label.className = 'text-success fs-8 fw-bold mt-1';
    }

    function tampilkanPopUpNotifikasi(judul, pesan) {
        const titleEl = document.getElementById('notifikasiPesanTitle');
        const textEl = document.getElementById('notifikasiPesanText');
        if (titleEl) titleEl.textContent = judul;
        if (textEl) textEl.textContent = pesan;

        const modalEl = document.getElementById('modalNotifikasiPesan');
        if (modalEl) {
            const notifModal = new bootstrap.Modal(modalEl);
            notifModal.show();
        }
    }

    function handleUploadPdf(e) {
        e.preventDefault();

        const fileInput = document.getElementById('file_dokumen');
        const file = fileInput.files[0];
        const label = document.getElementById('file_dokumen_label');

        if (!file) {
            alert('Pilih file PDF terlebih dahulu.');
            return;
        }

        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
            alert('Format berkas wajib PDF.');
            fileInput.value = '';
            if (label) {
                label.textContent = 'Format berkas tidak sesuai (wajib PDF)';
                label.className = 'text-danger fs-8 fw-semibold mt-1';
            }
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal adalah 5MB.');
            fileInput.value = '';
            if (label) {
                label.textContent = 'Ukuran berkas melebihi batas 5 MB';
                label.className = 'text-danger fs-8 fw-semibold mt-1';
            }
            return;
        }

        const btn = document.getElementById('btnUpload');
        const btnSpinner = document.getElementById('btnUploadSpinner');
        const btnText = document.getElementById('btnUploadText');
        const formData = new FormData(document.getElementById('formUploadKetuaPkk'));

        btn.disabled = true;
        btnSpinner.classList.remove('d-none');
        btnText.textContent = 'Mengunggah...';

        fetch(ROUTES_KETUA_PKK.upload, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) {
                const msg = data.message || Object.values(data.errors || {}).flat().join('\n') || 'Gagal mengunggah file';
                throw new Error(msg);
            }
            return data;
        })
        .then(res => {
            const viewer = document.getElementById('pdfViewer');
            const placeholder = document.getElementById('emptyPdfPlaceholder');
            const btnHapus = document.getElementById('btnHapusDoc');

            currentDocHash = res.hash;
            viewer.src = res.pdf_url + '#toolbar=1&navpanes=1';
            viewer.style.display = 'block';
            placeholder.style.display = 'none';

            if (btnHapus) {
                btnHapus.classList.remove('d-none');
                btnHapus.onclick = () => konfirmasiHapusDoc(currentDocHash);
            }

            fileInput.value = '';
            if (label) {
                label.textContent = 'Belum ada file yang dipilih';
                label.className = 'text-muted fs-8 fw-semibold mt-1';
            }
            tampilkanPopUpNotifikasi('Sukses', 'Dokumen berhasil diunggah');
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat mengunggah.');
        })
        .finally(() => {
            btn.disabled = false;
            btnSpinner.classList.add('d-none');
            btnText.textContent = 'Upload';
        });
    }

    function konfirmasiHapusDoc(hash) {
        if (!hash) return;
        targetHashHapus = hash;
        const modalEl = document.getElementById('modalKonfirmasiHapus');
        const modalHapus = new bootstrap.Modal(modalEl);
        modalHapus.show();
    }

    document.getElementById('btnProsesHapus')?.addEventListener('click', function() {
        if (!targetHashHapus) return;

        const btn = document.getElementById('btnProsesHapus');
        const spinner = document.getElementById('btnHapusSpinner');
        const btnText = document.getElementById('btnHapusText');

        btn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Menghapus...';

        fetch(`${ROUTES_KETUA_PKK.destroy}/${encodeURIComponent(targetHashHapus)}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': ROUTES_KETUA_PKK.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                _token: ROUTES_KETUA_PKK.csrfToken,
                _method: 'DELETE'
            })
        })
        .then(async (res) => {
            if (!res.ok) {
                const err = await res.json();
                throw new Error(err.message || 'Gagal menghapus file.');
            }
            return res.json();
        })
        .then(() => {
            const modalEl = document.getElementById('modalKonfirmasiHapus');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();

            const viewer = document.getElementById('pdfViewer');
            const placeholder = document.getElementById('emptyPdfPlaceholder');
            const btnHapus = document.getElementById('btnHapusDoc');

            viewer.src = '';
            viewer.style.display = 'none';
            placeholder.style.display = 'flex';
            if (btnHapus) btnHapus.classList.add('d-none');

            targetHashHapus = null;
            currentDocHash = '';

            tampilkanPopUpNotifikasi('Sukses', 'Data telah dihapus');
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menghapus.');
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = 'Ya, Hapus';
        });
    });
</script>
@endsection