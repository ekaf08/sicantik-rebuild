/* global bootstrap, Swal, $ */

// ==========================================
// 1. Pokja 1
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    // DataTables Detail Pengurus Pokja I
    const tableEl = $("#kt_table_pengurus");
    if (tableEl.length) {
        const table = tableEl.DataTable({
            destroy: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            // Mengatur layout: l (length) di kiri atas, f (filter/search) di kanan atas
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                search: "Search:",
                // Menambahkan kembali teks "Show" di samping parameter _MENU_ (dropdown)
                lengthMenu: "Show _MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                paginate: { previous: "‹", next: "›" },
            },
            // Menambahkan initComplete untuk memaksa tata letak horizontal
            initComplete: function () {
                // Memaksa label menjadi baris horizontal
                $(".dataTables_length label, .dataTables_filter label").css({
                    display: "flex",
                    "align-items": "center",
                    "flex-direction": "row",
                    gap: "8px",
                    "margin-bottom": "0",
                    "white-space": "nowrap",
                });

                // Mencegah select dan input mengambil lebar penuh
                $(".dataTables_length select, .dataTables_filter input").css({
                    width: "auto",
                    display: "inline-block",
                });
            },
        });

        const modalEl = document.getElementById("kt_modal_detail_pengurus");
        if (modalEl) {
            modalEl.addEventListener("shown.bs.modal", function () {
                table.columns.adjust();
            });
        }
    }

    // SweetAlert Aksi Terkunci
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-aksi-terkunci");
        if (!btn) return;

        if (typeof Swal === "undefined") {
            console.error(
                "[akses dibatasi] SweetAlert2 (Swal) tidak ditemukan.",
            );
            return;
        }

        Swal.fire({
            icon: "info",
            title: "Akses Dibatasi",
            text: "Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan",
            confirmButtonText: "Mengerti",
            confirmButtonColor: "bg-info",
            customClass: {
                confirmButton: "btn fw-bold btn-info",
            },
            buttonsStyling: false,
        });
    });

    // DataTables Modal Edit Volume
    if ($("#kt_table_edit_data").length) {
        $("#kt_table_edit_data").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data",
                info: "Tidak ada data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "",
                search: "",
                searchPlaceholder: "Search...",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalEditDataEl = document.getElementById("kt_modal_edit_data");
    if (modalEditDataEl) {
        modalEditDataEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger?.getAttribute("data-nama-item") || "";
            const subTitleEl = document.getElementById("modalEditDataSubtitle");
            if (subTitleEl) subTitleEl.textContent = namaItem;
        });
    }

    // DataTables Modal Edit Jumlah Peserta
    if ($("#kt_table_edit_data_peserta").length) {
        $("#kt_table_edit_data_peserta").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data",
                info: "Tidak ada data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "",
                search: "",
                searchPlaceholder: "Search...",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalEditPesertaEl = document.getElementById(
        "kt_modal_edit_data_peserta",
    );
    if (modalEditPesertaEl) {
        modalEditPesertaEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger?.getAttribute("data-nama-item") || "";
            const subTitleEl = document.getElementById(
                "modalEditDataPesertaSubtitle",
            );
            if (subTitleEl) subTitleEl.textContent = namaItem;
        });
    }
});

// ==========================================
// 2. Pokja 2
// ==========================================

/* Modal Detail Warga Masih Buta Pj 2 */
document.addEventListener("DOMContentLoaded", function () {
    if (!$.fn.DataTable.isDataTable("#kt_table_detail_buta")) {
        $("#kt_table_detail_buta").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalDetailButaEl = document.getElementById("kt_modal_detail_buta");
    if (modalDetailButaEl) {
        modalDetailButaEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute("data-field") || "";
            const kecamatan = trigger.getAttribute("data-kecamatan") || "";
            document.getElementById("modalDetailButaTitle").textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }
});

/* Modal Detail Jumlah Kelompok Belajar Pj 2 */
document.addEventListener("DOMContentLoaded", function () {
    if (!$.fn.DataTable.isDataTable("#kt_table_Jml_KLP_Belajar")) {
        $("#kt_table_Jml_KLP_Belajar").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalJmlKLPBelajarEl = document.getElementById(
        "kt_modal_Jml_KLP_Belajar",
    );
    if (modalJmlKLPBelajarEl) {
        modalJmlKLPBelajarEl.addEventListener(
            "show.bs.modal",
            function (event) {
                const trigger = event.relatedTarget;
                const field = trigger.getAttribute("data-field") || "";
                const kecamatan = trigger.getAttribute("data-kecamatan") || "";
                document.getElementById("modalJmlKLPBelajarTitle").textContent =
                    `DETAIL ${field} - ${kecamatan}`.toUpperCase();
            },
        );
    }
});

/* Modal Detail Warga Belajar Pj 2 */
document.addEventListener('DOMContentLoaded', function () {
    if (!$.fn.DataTable.isDataTable('#kt_table_Warga_Belajar')) {
        $('#kt_table_Warga_Belajar').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalWargaBelajarEl = document.getElementById('kt_modal_Warga_Belajar');
    if (modalWargaBelajarEl) {
        modalWargaBelajarEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalWarga_BelajarTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    if (!$.fn.DataTable.isDataTable('#kt_table_Paud_Sejenis')) {
        $('#kt_table_Paud_Sejenis').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalPaudSejenisEl = document.getElementById('kt_modal_Paud_Sejenis');
    if (modalPaudSejenisEl) {
        modalPaudSejenisEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalPaud_SejenisTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }

    /* Modal Detail Bkb Jml Kelp */
    if (!$.fn.DataTable.isDataTable('#kt_table_Bkb_Jml_Kelp')) {
        $('#kt_table_Bkb_Jml_Kelp').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalBkbJmlKelpEl = document.getElementById('kt_modal_Bkb_Jml_Kelp');
    if (modalBkbJmlKelpEl) {
        modalBkbJmlKelpEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalBkb_Jml_KelpTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }

    /* Modal Detail Bkb Jml Ibu */
    if (!$.fn.DataTable.isDataTable('#kt_table_Bkb_Jml_Ibu')) {
        $('#kt_table_Bkb_Jml_Ibu').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalBkbJmlIbuEl = document.getElementById('kt_modal_Bkb_Jml_Ibu');
    if (modalBkbJmlIbuEl) {
        modalBkbJmlIbuEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalBkb_Jml_IbuTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }

    /* Modal Detail Bkb Jml Ape */
    if (!$.fn.DataTable.isDataTable('#kt_table_Bkb_Jml_Ape')) {
        $('#kt_table_Bkb_Jml_Ape').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalBkbJmlApeEl = document.getElementById('kt_modal_Bkb_Jml_Ape');
    if (modalBkbJmlApeEl) {
        modalBkbJmlApeEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalBkb_Jml_ApeTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }

    /* Modal Detail Kader Khusus Tutor KF */
    if (!$.fn.DataTable.isDataTable('#kt_table_Tutor_KF')) {
        $('#kt_table_Tutor_KF').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalTutorKfEl = document.getElementById('kt_modal_Tutor_KF');
    if (modalTutorKfEl) {
        modalTutorKfEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalTutor_KFTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
                
        });
    }

    /* Modal Detail Kader Khusus BKB */
    if (!$.fn.DataTable.isDataTable('#kt_table_Bkb_Khusus')) {
        $('#kt_table_Bkb_Khusus').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalBkbKhususEl = document.getElementById('kt_modal_Bkb_Khusus');
    if (modalBkbKhususEl) {
        modalBkbKhususEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalBkb_KhususTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }

    /* Modal Detail Lp3 Pkk Kota */
    if (!$.fn.DataTable.isDataTable('#kt_table_Lp3_Pkk')) {
        $('#kt_table_Lp3_Pkk').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalLp3PkkKotaEl = document.getElementById('kt_modal_Lp3_Pkk');
    if (modalLp3PkkKotaEl) {
        modalLp3PkkKotaEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalLp3_PkkTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }





});


// ==========================================
// FITUR DETAIL KADER SURABAYA HEBAT (POKJA 4)
// ==========================================
const KADER_ROLES = ["Kader", "Kader", "Kader", "Sekretaris", "Bendahara"];

function generateMockKaderRecords(field, kecamatan, count) {
    const rng = mulberry32(hashString(`${field}|${kecamatan}`));
    const records = [];

    for (let i = 0; i < count; i++) {
        const first = pick(rng, FIRST_NAMES);
        const last = pick(rng, LAST_NAMES);
        records.push({
            no: i + 1,
            nik: `35782${pad(Math.floor(rng() * 100000000), 9)}${pad(i, 4)}`,
            namaKader: `${first}${last ? " " + last : ""}`.toUpperCase(),
            role: pick(rng, KADER_ROLES),
            jenisKelamin: pick(rng, GENDERS),
            kecamatan: kecamatan.toUpperCase(),
            kelurahan: kecamatan.toUpperCase(),
        });
    }
    return records;
}

let kaderAllRecords = [];
let kaderFilteredRecords = [];
let kaderCurrentPage = 1;
let kaderPageSize = 10;

function kaderApplyFilterAndRender() {
    const term = (document.getElementById("kaderHebatSearch")?.value || "")
        .trim()
        .toLowerCase();
    kaderFilteredRecords = term
        ? kaderAllRecords.filter((r) =>
              [
                  r.nik,
                  r.namaKader,
                  r.role,
                  r.jenisKelamin,
                  r.kecamatan,
                  r.kelurahan,
              ]
                  .join(" ")
                  .toLowerCase()
                  .includes(term),
          )
        : kaderAllRecords;

    kaderCurrentPage = 1;
    kaderRenderTablePage();
}

function kaderRenderTablePage() {
    const tbody = document.getElementById("kaderHebatTbody");
    const info = document.getElementById("kaderHebatInfo");
    const pagination = document.getElementById("kaderHebatPagination");
    if (!tbody || !info || !pagination) return;

    const total = kaderFilteredRecords.length;
    const totalPages = Math.max(1, Math.ceil(total / kaderPageSize));
    kaderCurrentPage = Math.min(kaderCurrentPage, totalPages);

    const start = (kaderCurrentPage - 1) * kaderPageSize;
    const pageRows = kaderFilteredRecords.slice(start, start + kaderPageSize);

    if (pageRows.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-muted py-6">Tidak ada data ditemukan.</td></tr>`;
    } else {
        tbody.innerHTML = pageRows
            .map(
                (r, idx) => `
                <tr>
                    <td>${start + idx + 1}</td>
                    <td>${r.nik}</td>
                    <td class="text-start">${r.namaKader}</td>
                    <td>${r.role}</td>
                    <td>${r.jenisKelamin}</td>
                    <td>${r.kecamatan}</td>
                    <td>${r.kelurahan}</td>
                </tr>`,
            )
            .join("");
    }

    info.textContent =
        total === 0
            ? "Showing 0 records"
            : `Showing ${start + 1} to ${Math.min(start + kaderPageSize, total)} of ${total} records`;

    const buttons = [];
    buttons.push(
        `<button type="button" class="btn btn-sm btn-light" data-kader-page="${kaderCurrentPage - 1}" ${
            kaderCurrentPage === 1 ? "disabled" : ""
        }>‹</button>`,
    );
    for (let p = 1; p <= totalPages; p++) {
        buttons.push(
            `<button type="button" class="btn btn-sm ${
                p === kaderCurrentPage ? "btn-primary" : "btn-light"
            }" data-kader-page="${p}">${p}</button>`,
        );
    }
    buttons.push(
        `<button type="button" class="btn btn-sm btn-light" data-kader-page="${kaderCurrentPage + 1}" ${
            kaderCurrentPage === totalPages ? "disabled" : ""
        }>›</button>`,
    );
    pagination.innerHTML = buttons.join("");
}

function openKaderHebatDetailModal(field, kecamatan, rawValue) {
    const titleEl = document.getElementById("modalKaderHebatTitle");
    const modalEl = document.getElementById("kt_modal_kader_hebat");

    if (!modalEl || typeof bootstrap === "undefined" || !bootstrap.Modal)
        return;

    if (titleEl) {
        titleEl.textContent =
            `DETAIL JUMLAH KADER ${field} - ${kecamatan}`.toUpperCase();
    }

    const count = parseValueToCount(rawValue);
    kaderAllRecords = generateMockKaderRecords(field, kecamatan, count);

    const pageSizeEl = document.getElementById("kaderHebatPageSize");
    kaderPageSize = pageSizeEl ? parseInt(pageSizeEl.value, 10) || 10 : 10;

    const searchEl = document.getElementById("kaderHebatSearch");
    if (searchEl) searchEl.value = "";

    kaderApplyFilterAndRender();
    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}

let allRecords = [];
let filteredRecords = [];
let currentPage = 1;
let pageSize = 10;

function applyFilterAndRender() {
    const term = (document.getElementById("agregatDetailSearch")?.value || "")
        .trim()
        .toLowerCase();
    filteredRecords = term
        ? allRecords.filter((r) =>
              [r.noKk, r.nik, r.nama, r.jenisKelamin, r.rt, r.rw, r.alamat]
                  .join(" ")
                  .toLowerCase()
                  .includes(term),
          )
        : allRecords;

    currentPage = 1;
    renderTablePage();
}

function renderTablePage() {
    const tbody = document.getElementById("agregatDetailTbody");
    const info = document.getElementById("agregatDetailInfo");
    const pagination = document.getElementById("agregatDetailPagination");
    if (!tbody || !info || !pagination) return;

    const total = filteredRecords.length;
    const totalPages = Math.max(1, Math.ceil(total / pageSize));
    currentPage = Math.min(currentPage, totalPages);

    const start = (currentPage - 1) * pageSize;
    const pageRows = filteredRecords.slice(start, start + pageSize);

    if (pageRows.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-muted py-6">Tidak ada data ditemukan.</td></tr>`;
    } else {
        tbody.innerHTML = pageRows
            .map(
                (r, idx) => `
                <tr>
                    <td>${start + idx + 1}</td>
                    <td>${r.noKk}</td>
                    <td>${r.nik}</td>
                    <td class="text-start">${r.nama}</td>
                    <td>${r.jenisKelamin}</td>
                    <td>${r.rt}</td>
                    <td>${r.rw}</td>
                    <td class="text-start">${r.alamat}</td>
                </tr>`,
            )
            .join("");
    }

    info.textContent =
        total === 0
            ? "Menampilkan 0 data"
            : `Menampilkan ${start + 1} - ${Math.min(start + pageSize, total)} dari ${total} data`;

    const buttons = [];
    buttons.push(
        `<button type="button" class="btn btn-sm btn-light" data-page="${currentPage - 1}" ${
            currentPage === 1 ? "disabled" : ""
        }>Prev</button>`,
    );
    for (let p = 1; p <= totalPages; p++) {
        buttons.push(
            `<button type="button" class="btn btn-sm ${
                p === currentPage ? "btn-primary" : "btn-light"
            }" data-page="${p}">${p}</button>`,
        );
    }
    buttons.push(
        `<button type="button" class="btn btn-sm btn-light" data-page="${currentPage + 1}" ${
            currentPage === totalPages ? "disabled" : ""
        }>Next</button>`,
    );
    pagination.innerHTML = buttons.join("");
}

function openAgregatDetailModal(field, kecamatan, rawValue) {
    const titleEl = document.getElementById("modalAgregatTitle");
    const modalEl = document.getElementById("kt_modal_agregat");

    if (!modalEl || typeof bootstrap === "undefined" || !bootstrap.Modal)
        return;

    if (titleEl) {
        titleEl.textContent = `DETAIL ${field} - ${kecamatan}`.toUpperCase();
    }

    const count = parseValueToCount(rawValue);
    allRecords = generateMockAgregatRecords(field, kecamatan, count);

    const pageSizeEl = document.getElementById("agregatDetailPageSize");
    pageSize = pageSizeEl ? parseInt(pageSizeEl.value, 10) || 10 : 10;

    const searchEl = document.getElementById("agregatDetailSearch");
    if (searchEl) searchEl.value = "";

    const inputValEl = document.getElementById("modalAgregatValue");
    if (inputValEl) inputValEl.value = rawValue;

    applyFilterAndRender();
    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}

const MOCK_GKSTB = {
    "GKSTB Kesehatan": [
        {
            no: 1,
            proyek: "SOSIALISASI BATRA BERSAMA POKJA 4 & NAKES PUSKESMAS (BATRA)",
            kategori: "Peduli kesehatan keluarga",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 2,
            proyek: "MAKAN BERSAMA BALITA STUNTING KERJASAMA POKJA 3 & 4",
            kategori: "Peduli kesehatan keluarga",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 3,
            proyek: "PEMBERIAN SUSU DAN VITAMIN BAGI BALITA STUNTING DAN PRASTUNTING",
            kategori: "Peduli stunting",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 4,
            proyek: "PARENTING KEREN STUNTING LEREN",
            kategori: "Peduli stunting",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 5,
            proyek: "PEMBERIAN MAKANAN BERGIZI",
            kategori: "Peduli stunting",
            kelurahan: "BENOWO",
            kecamatan: "TAMBAK OSO WILANGUN",
        },
    ],
    "GKSTB Lingkungan Hidup": [
        {
            no: 1,
            proyek: "SOSIALISASI PENANGGULANGAN BENCANA KEBAKARAN",
            kategori: "Mitigasi bencana",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 2,
            proyek: "KAMPUNG MACO (MANGGA & COCODAMA)",
            kategori: "Peduli lingkungan",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 3,
            proyek: "KERJA BAKTI & GOTONG ROYONG",
            kategori: "Peduli lingkungan",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 4,
            proyek: "PSN",
            kategori: "Peduli lingkungan",
            kelurahan: "BENOWO",
            kecamatan: "TAMBAK OSO WILANGUN",
        },
    ],
    "GKSTB Perencanaan Sehat": [
        {
            no: 1,
            proyek: "KOPERASI SIMPAN PINJAM KELOMPOK RT & RW",
            kategori: "Keuangan sehat",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 2,
            proyek: "SOSIALISASI DAN EDUKASI TUMBUH KEMBANG ANAK",
            kategori: "Keluarga sehat berkualitas",
            kelurahan: "BENOWO",
            kecamatan: "KANDANGAN",
        },
        {
            no: 3,
            proyek: "SOSIALISASI",
            kategori: "Keluarga sehat berkualitas",
            kelurahan: "BENOWO",
            kecamatan: "TAMBAK OSO WILANGUN",
        },
    ],
};

function openGkstbModal(field, kecamatan) {
    const modalEl = document.getElementById("kt_modal_gkstb");
    const tbody = document.getElementById("gkstbTbody");
    const info = document.getElementById("gkstbInfo");
    if (!modalEl || !tbody) return;

    const dataList = MOCK_GKSTB[field] || [];

    if (dataList.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-5">Tidak ada data proyek ditemukan.</td></tr>`;
    } else {
        tbody.innerHTML = dataList
            .map(
                (item) => `
                <tr  class="fw-bold fs-7 text-gray-700">
                    <td class="ps-3 w-50px">${item.no}</td>
                    <td class="min-w-200px">${item.proyek}</td>
                    <td class="min-w-150px">${item.kategori}</td>
                    <td class="min-w-120px">${item.kelurahan}</td>
                    <td class="min-w-120px">${item.kecamatan}</td>
                    <td class="text-center pe-3">
                        <button type="button" class="btn btn-icon btn-sm btn-light btn-aksi-terkunci">
                            <i class="ki-outline ki-lock fs-4"></i>
                        </button>
                    </td>
                </tr>
            `,
            )
            .join("");
    }

    if (info) {
        info.textContent = `Showing 1 to ${dataList.length} of ${dataList.length} records`;
    }

    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}

// --- Global Event Delegation ---
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        const trigger = e.target.closest(".agregat-trigger");
        if (trigger) {
            const field = trigger.getAttribute("data-field") || "";
            const kecamatan = trigger.getAttribute("data-kecamatan") || "";
            const value =
                trigger.getAttribute("data-value") ||
                trigger.textContent.trim();

            if (field.startsWith("GKSTB")) {
                openGkstbModal(field, kecamatan);
            } else {
                openAgregatDetailModal(field, kecamatan, value);
            }
            return;
        }

        const pageBtn = e.target.closest(
            "#agregatDetailPagination button[data-page]",
        );
        if (pageBtn && !pageBtn.disabled) {
            currentPage = parseInt(pageBtn.getAttribute("data-page"), 10) || 1;
            renderTablePage();
        }
    });

    document.addEventListener("input", function (e) {
        if (e.target.id === "agregatDetailSearch") {
            applyFilterAndRender();
        }
        if (e.target.id === "kaderHebatSearch") {
            kaderApplyFilterAndRender();
        }
    });

    document.addEventListener("change", function (e) {
        if (e.target.id === "agregatDetailPageSize") {
            pageSize = parseInt(e.target.value, 10) || 10;
            currentPage = 1;
            renderTablePage();
        }
        if (e.target.id === "kaderHebatPageSize") {
            kaderPageSize = parseInt(e.target.value, 10) || 10;
            kaderCurrentPage = 1;
            kaderRenderTablePage();
        }
    });

    document.addEventListener("click", function (e) {
        const kaderPageBtn = e.target.closest(
            "#kaderHebatPagination button[data-kader-page]",
        );
        if (kaderPageBtn && !kaderPageBtn.disabled) {
            kaderCurrentPage =
                parseInt(kaderPageBtn.getAttribute("data-kader-page"), 10) || 1;
            kaderRenderTablePage();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tableId = "#kt_table_detail_buta";

    if ($.fn.DataTable.isDataTable(tableId)) {
        $(tableId).DataTable().destroy();
    }

    const table = $(tableId).DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
        language: {
            lengthMenu: "_MENU_",
            zeroRecords: "Tidak ada data untuk ditampilkan",
            emptyTable: "Tidak ada data untuk ditampilkan",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "Showing no records",
            infoFiltered: "",
            search: "Search:",
            paginate: {
                previous: "‹",
                next: "›",
            },
        },
    });

    // ==========================================
    // FITUR DETAIL IMUNISASI BALITA (POKJA 4)
    // ==========================================

    // Fungsi Buka Modal Imunisasi
    function openImunisasiDetailModal(field, kecamatan) {
        const modalEl = document.getElementById("kt_modal_detail_imunisasi");
        const titleEl = document.getElementById("modalDetailImunisasiTitle");

        if (!modalEl) return;

        // Set judul modal secara dinamis
        if (titleEl) {
            titleEl.textContent =
                `DETAIL ${field} BALITA - ${kecamatan}`.toUpperCase();
        }

        // Pindahkan elemen modal ke <body> untuk mencegah masalah z-index/backdrop tertutup
        document.body.appendChild(modalEl);

        // Buka Modal (Bootstrap 5 native atau fallback jQuery)
        if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (typeof $ !== "undefined" && $.fn.modal) {
            $(modalEl).modal("show");
        }

        // Adjust tata letak kolom DataTables saat modal dibuka
        const tableId = "#kt_table_detail_imunisasi";
        setTimeout(() => {
            if (
                typeof $ !== "undefined" &&
                $.fn.DataTable &&
                $.fn.DataTable.isDataTable(tableId)
            ) {
                $(tableId).DataTable().columns.adjust();
            }
        }, 200);
    }

    // Inisialisasi DataTables Imunisasi
    // (Catatan perbaikan: sebelumnya kode ini terjebak di dalam beberapa
    // lapis document.addEventListener("DOMContentLoaded", ...) yang
    // bersarang. DOMContentLoaded hanya terjadi SEKALI di seluruh siklus
    // hidup halaman, jadi listener DOMContentLoaded yang didaftarkan dari
    // DALAM handler DOMContentLoaded lain tidak akan pernah terpanggil.
    // Akibatnya init DataTable imunisasi & click interceptor di bawah ini
    // tidak pernah aktif, sehingga klik pada trigger "Imunisasi" jatuh ke
    // listener generik di atas dan menampilkan modal agregat biasa
    // (nilai "0") alih-alih modal detail imunisasi.)
    const tableIdImunisasi = "#kt_table_detail_imunisasi";
    if (
        $(tableIdImunisasi).length &&
        !$.fn.DataTable.isDataTable(tableIdImunisasi)
    ) {
        $(tableIdImunisasi).DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            dom:
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                emptyTable: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: {
                    previous: "‹",
                    next: "›",
                },
            },
        });
    }

    // Intersepsi Klik Tombol Agregat (fase capture, jalan lebih dulu
    // daripada listener generik yang didaftarkan di fase bubble)
    document.addEventListener(
        "click",
        function (e) {
            const trigger = e.target.closest(".agregat-trigger");
            if (!trigger) return;

            const field = (trigger.getAttribute("data-field") || "").trim();
            const kecamatan = (
                trigger.getAttribute("data-kecamatan") || ""
            ).trim();
            const fieldLower = field.toLowerCase();

            // Pengecekan imunisasi (bebas kapital / mengandung kata imunisasi)
            if (fieldLower.includes("imunisasi")) {
                e.preventDefault();
                e.stopImmediatePropagation(); // Hentikan script lain agar modal agregat '0' tidak ikut dipicu
                openImunisasiDetailModal(field, kecamatan);
                return;
            }

            // Pengecekan Kader Surabaya Hebat
            if (fieldLower.includes("kader surabaya hebat")) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const value =
                    trigger.getAttribute("data-value") ||
                    trigger.textContent.trim();
                openKaderHebatDetailModal(field, kecamatan, value);
                return;
            }

            if (fieldLower.startsWith("gkstb")) {
                e.preventDefault();
                e.stopImmediatePropagation();
                if (typeof openGkstbModal === "function") {
                    openGkstbModal(field, kecamatan);
                }
                return;
            }

            // Jika statistik umum lainnya
            const value =
                trigger.getAttribute("data-value") ||
                trigger.textContent.trim();
            if (typeof openAgregatDetailModal === "function") {
                openAgregatDetailModal(field, kecamatan, value);
            }
        },
        true, // Jalankan di fase capture agar diproses lebih dulu
    );
})();
