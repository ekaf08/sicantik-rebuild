@extends('bo.layout.app')
@section('content')
<div class="container-fluid">
    <!-- Filter Card Header -->
    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 mb-5">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Permission</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Master</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Permission</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
    </div>
    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <div class="perm-filter">
                <select id="select-role" class="form-select form-select-solid"
                        data-control="select2" data-placeholder="-- Pilih Role --" data-allow-clear="true">
                    <option value=""></option>
                    @foreach($roles as $role)
                        <option value="{{ Crypt::encryptString($role->id) }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <input type="text" id="search-menu" class="form-control form-control-solid"
                    placeholder="Cari menu..." autocomplete="off">
            </div>
        </div>
    </div>

    <!-- Container Card Matriks Menu -->
    <div id="permission-container">
        <div class="card shadow-sm">
            <div class="card-body text-center py-10 text-muted">
                Silakan pilih Role terlebih dahulu untuk menampilkan hak akses menu.
            </div>
        </div>
    </div>
    <div id="no-result" class="card shadow-sm" style="display:none;">
        <div class="card-body text-center py-10 text-muted">Menu tidak ditemukan.</div>
    </div>
</div>

<style>
.perm-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}
.perm-filter > select,
.perm-filter > input,
.perm-filter .select2-container {
    flex: 1 1 240px;
    max-width: 320px;
    width: auto !important; 
}
.perm-filter > button {
    flex: 0 0 auto;
}

.perm-badge-check {
    display: none;
}
.perm-badge-label {
    cursor: pointer;
    border: 1px solid #e4e6ef;
    border-radius: 6px;
    padding: 6px 14px;
    font-weight: 500;
    color: #5e6278;
    background-color: #f9f9f9;
    transition: all 0.2s ease;
    user-select: none;
}
.perm-badge-check:checked + .perm-badge-label {
    background-color: #e8fff3;
    border-color: #50cd89;
    color: #47be7d;
}
.perm-badge-check:checked + .perm-badge-label::before {
    content: "✓ ";
    font-weight: bold;
}
</style>
@endsection

@push('js')
<script>
$('#select-role').select2({ width: '100%', allowClear: true, placeholder: '-- Pilih Role --' });

$(document).ready(function () {

    function applySearch() {
    const q = $('#search-menu').val().trim().toLowerCase();

    $('.perm-card').each(function () {
        const $card = $(this);
        const groupName = $card.find('.card-header h6').text().toLowerCase();
        const groupMatch = q === '' || groupName.includes(q);
        let anyVisible = false;

        $card.find('.perm-row').each(function () {
            const text = $(this).find('h6, .text-muted').text().toLowerCase();
            const match = groupMatch || text.includes(q);
            $(this).toggle(match);
            if (match) anyVisible = true;
        });

        $card.toggle(anyVisible);
    });

    const hasCards = $('.perm-card').length > 0;
    $('#no-result').toggle(q !== '' && hasCards && $('.perm-card:visible').length === 0);
}

    $('#search-menu').on('input', applySearch);

    $('#select-role').on('change', function () {
        loadPermissions();
    });

    $('#btn-reload').on('click', function () {
        loadPermissions();
    });

    function notifyError(xhr, fallback) {
        let msg = fallback + ' (' + xhr.status + ')';

        if (xhr.responseJSON) {
            if (xhr.responseJSON.errors) {
                msg = Object.values(xhr.responseJSON.errors).flat().map(esc).join('<br>');
            } else if (xhr.responseJSON.message) {
                msg = esc(xhr.responseJSON.message);
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: msg,
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: { confirmButton: 'btn btn-primary' }
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    function notifySuccess(msg) {
        Toast.fire({ icon: 'success', title: msg });
    }

    function esc(str) {
    return $('<div>').text(str ?? '').html();
    }

    function loadPermissions() {
        let roleId = $('#select-role').val();
        if (!roleId) {
            $('#permission-container').html(`
                <div class="card shadow-sm"><div class="card-body text-center py-10 text-muted">
                    Silakan pilih Role terlebih dahulu untuk menampilkan hak akses menu.
                </div></div>`);
            return;
        }

        $.ajax({
            url: "{{ route('permission.data') }}",
            type: "GET",
            data: { role_id: roleId },
            success: function (res) {
                renderCards(res.menus, res.permissions);
            },
            error: function (xhr) {
                notifyError(xhr, 'Gagal memuat');
            }
        });
    }

  function renderCards(menus, permissions) {
    let html = '';

    if (!menus || menus.length === 0) {
        $('#permission-container').html(`
            <div class="card shadow-sm">
                <div class="card-body text-center text-muted perm-card">Role ini belum memiliki menu. Atur di submenu Role.</div>
            </div>`);
        return;
    }

    menus.forEach(function (menu) {
        if (menu.children && menu.children.length > 0) {
            html += `
            <div class="card mb-5 shadow-sm perm-card">
                <div class="card-header bg-light">
                    <h6 class="card-title fw-bold m-0">${esc(menu.nama_menu)}</h6>
                </div>
                <div class="card-body">`;
            if (menu.parent_assigned) {
                html += buildMenuRow(menu, permissions);
            }
            menu.children.forEach(function (child) {
                html += buildMenuRow(child, permissions);
            });
            html += `</div></div>`;
        } else {
            html += `
            <div class="card mb-4 shadow-sm perm-card">
                <div class="card-body">${buildMenuRow(menu, permissions)}</div>
            </div>`;
        }
    });

    $('#permission-container').html(html);
    applySearch();
}

  function buildMenuRow(menu, permissions) {
    let menuId = parseInt(menu.id_menu, 10);
    let enc    = esc(menu.enc_id);
    let perm   = permissions[menuId] || {};

    let isTable  = perm.table  ? 'checked' : '';
    let isCreate = perm.create ? 'checked' : '';
    let isUpdate = perm.update ? 'checked' : '';
    let isDelete = perm.delete ? 'checked' : '';
    let isAll    = (perm.table && perm.create && perm.update && perm.delete) ? 'checked' : '';

    return `
    <div class="py-3 border-bottom perm-row">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold mb-1">${esc(menu.nama_menu)}</h6>
                <span class="text-muted fs-7">${esc(menu.url_menu || '-')}</span>
            </div>
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input check-all" type="checkbox"
                       data-menu-id="${menuId}" data-enc="${enc}" ${isAll} id="all_${menuId}">
                <label class="form-check-label fw-bold" for="all_${menuId}">ALL</label>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <div>
                <input type="checkbox" class="perm-badge-check perm-item" id="tbl_${menuId}"
                       data-menu-id="${menuId}" data-enc="${enc}" data-field="table" ${isTable}>
                <label class="perm-badge-label" for="tbl_${menuId}">Lihat</label>
            </div>
            <div>
                <input type="checkbox" class="perm-badge-check perm-item" id="crt_${menuId}"
                       data-menu-id="${menuId}" data-enc="${enc}" data-field="create" ${isCreate}>
                <label class="perm-badge-label" for="crt_${menuId}">Tambah</label>
            </div>
            <div>
                <input type="checkbox" class="perm-badge-check perm-item" id="upd_${menuId}"
                       data-menu-id="${menuId}" data-enc="${enc}" data-field="update" ${isUpdate}>
                <label class="perm-badge-label" for="upd_${menuId}">Ubah</label>
            </div>
            <div>
                <input type="checkbox" class="perm-badge-check perm-item" id="del_${menuId}"
                       data-menu-id="${menuId}" data-enc="${enc}" data-field="delete" ${isDelete}>
                <label class="perm-badge-label" for="del_${menuId}">Hapus</label>
            </div>
        </div>
    </div>`;
};

    $(document).on('change', '.perm-item', function () {
        let roleId = $('#select-role').val();
        let menuId = $(this).data('menu-id');
        let enc    = $(this).attr('data-enc');
        let field  = $(this).data('field');
        let value  = $(this).is(':checked') ? 1 : 0;

        let total   = $(`.perm-item[data-menu-id="${menuId}"]`).length;
        let checked = $(`.perm-item[data-menu-id="${menuId}"]:checked`).length;
        $(`#all_${menuId}`).prop('checked', total === checked);

        updatePermissionAjax(roleId, enc, field, value);
    });

    $(document).on('change', '.check-all', function () {
        let roleId    = $('#select-role').val();
        let menuId    = $(this).data('menu-id');
        let enc       = $(this).attr('data-enc');
        let isChecked = $(this).is(':checked');

        $(`#tbl_${menuId}, #crt_${menuId}, #upd_${menuId}, #del_${menuId}`).prop('checked', isChecked);

        updatePermissionAjax(roleId, enc, 'all', isChecked ? 1 : 0);
    });

    function updatePermissionAjax(roleId, menuId, field, value) {
        $.ajax({
            url: "{{ route('permission.access') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                role_id: roleId,
                menu_id: menuId,
                field: field,
                value: value
            },
            success: function (res) {
                notifySuccess(res.message);
                loadPermissions();
            },
            error: function (xhr) {
                notifyError(xhr, 'Gagal menyimpan');
                loadPermissions(); 
            },
        });
    }

});
</script>
@endpush