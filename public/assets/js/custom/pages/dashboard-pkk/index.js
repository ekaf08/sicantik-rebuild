/* global bootstrap */
/* Modal Basic */
document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        const trigger = e.target.closest(".agregat-trigger");
        if (!trigger) return;

        const field = trigger.getAttribute("data-field") || "";
        const kecamatan = trigger.getAttribute("data-kecamatan") || "";
        const value =
            trigger.getAttribute("data-value") || trigger.textContent.trim();

        const titleEl = document.getElementById("modalAgregatTitle");
        const valueEl = document.getElementById("modalAgregatValue");
        const modalEl = document.getElementById("kt_modal_agregat");

        // These used to fail silently, which made "the modal just doesn't
        // show up" impossible to diagnose. Now they log exactly what's
        // missing so it shows up in the browser console.
        if (!modalEl) {
            console.error(
                "[agregat modal] #kt_modal_agregat not found in the DOM. " +
                    "Make sure dashboard_blade.php (which contains the modal markup) " +
                    "is the page actually being rendered, and that the modal div " +
                    "isn't nested inside an element with display:none.",
            );
        }
        if (!titleEl || !valueEl) {
            console.error(
                "[agregat modal] #modalAgregatTitle or #modalAgregatValue not found.",
            );
        }
        if (typeof bootstrap === "undefined" || !bootstrap.Modal) {
            console.error(
                "[agregat modal] `bootstrap` (or bootstrap.Modal) is not available " +
                    "as a global. If Bootstrap is bundled via a module system, it may " +
                    "not be attached to window — check that plugins/bootstrap bundle " +
                    "script is loaded before this file.",
            );
            return;
        }

        if (titleEl) {
            titleEl.textContent =
                `AGREGATE ${field} - ${kecamatan}`.toUpperCase();
        }
        if (valueEl) {
            valueEl.value = value;
        }
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    });
});

/* Detail DataTables PJ 1 */
document.addEventListener('DOMContentLoaded', function () {
    const table = $('#kt_table_pengurus').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            paginate: { previous: "‹", next: "›" }
        }
    });

    const modalEl = document.getElementById('kt_modal_detail_pengurus');
    if (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function () {
            table.columns.adjust();
        });
    }
});

/* Aksi */
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-aksi-terkunci');
        if (!btn) return;

        if (typeof Swal === 'undefined') {
            console.error('[akses dibatasi] SweetAlert2 (Swal) tidak ditemukan. Pastikan plugin SweetAlert2 sudah di-load.');
            return;
        }

        Swal.fire({
            icon: 'info',
            title: 'Akses Dibatasi',
            text: 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#6f42c1',
            customClass: {
                confirmButton: 'btn fw-bold btn-primary'
            },
            buttonsStyling: false
        });
    });
});