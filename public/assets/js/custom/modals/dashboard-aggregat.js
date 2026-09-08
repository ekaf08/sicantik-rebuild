document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('kt_modal_agregat');
    const modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.agregat-trigger').forEach(function (el) {
        el.style.cursor = 'pointer';
        el.addEventListener('click', function () {
            const field = this.dataset.field;
            const kecamatan = this.dataset.kecamatan;
            const value = this.dataset.value;

            document.getElementById('modalAgregatTitle').textContent =
                'Agregate ' + field + ' - ' + kecamatan;
            document.getElementById('modalAgregatValue').value = value;

            modal.show();
        });
    });
});