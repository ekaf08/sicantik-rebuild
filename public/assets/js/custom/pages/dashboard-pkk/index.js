/* global bootstrap */

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
