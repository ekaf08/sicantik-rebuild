/* global bootstrap, Swal */

// ==========================================
// 1. DataTables Detail Pengurus Pokja I
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    const tableEl = $("#kt_table_pengurus");

    if (tableEl.length) {
        const table = tableEl.DataTable({
            destroy: true, // Mencegah re-initialization error
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                paginate: { previous: "‹", next: "›" },
            },
        });

        const modalEl = document.getElementById("kt_modal_detail_pengurus");
        if (modalEl) {
            modalEl.addEventListener("shown.bs.modal", function () {
                table.columns.adjust();
            });
        }
    }
});

// ==========================================
// 2. SweetAlert Aksi Terkunci
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
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
            confirmButtonColor: "#6f42c1",
            customClass: {
                confirmButton: "btn fw-bold btn-infoy",
            },
            buttonsStyling: false,
        });
    });
});

/* Modal Edit Data Volume*/
document.addEventListener("DOMContentLoaded", function () {
    // 1. Inisialisasi DataTables (search, pagination, bahasa Indonesia)
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

    // 2. Update judul modal sesuai tombol yang diklik
    const modalEditDataEl = document.getElementById("kt_modal_edit_data");
    if (modalEditDataEl) {
        modalEditDataEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger.getAttribute("data-nama-item") || "";
            document.getElementById("modalEditDataSubtitle").textContent =
                namaItem;
        });
    }
});

/* Modal Edit Data Jumlah Peserta */
document.addEventListener("DOMContentLoaded", function () {
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

    const modalEditPesertaEl = document.getElementById(
        "kt_modal_edit_data_peserta",
    );
    if (modalEditPesertaEl) {
        modalEditPesertaEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger.getAttribute("data-nama-item") || "";
            document.getElementById(
                "modalEditDataPesertaSubtitle",
            ).textContent = namaItem;
        });
    }
});
