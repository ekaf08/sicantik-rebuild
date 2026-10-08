@extends('bo.layout.app')
@section('content')
<div class="container-fluid">
    <!-- Filter Card Header -->
    <div class="card mb-5 shadow-sm">
        <div class="card-body">
            <label class="form-label fw-bold">Pilih Role</label>
            <div class="d-flex align-items-center gap-3">
                <select id="select-role" class="form-select form-select-solid w-300px">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ Crypt::encryptString($role->id) }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <button type="button" id="btn-reload" class="btn btn-light btn-active-light-primary">
                    <i class="fas fa-sync-alt me-1"></i> Muat Ulang
                </button>
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
</div>

<style>
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
$(document).ready(function () {

    $('#select-role').on('change', function () {
        loadPermissions();
    });

    $('#btn-reload').on('click', function () {
        loadPermissions();
    });

    function notifyError(xhr, fallback) {
        let msg = (xhr.responseJSON && xhr.responseJSON.message)
            ? xhr.responseJSON.message
            : fallback + ' (' + xhr.status + ')';
        if (typeof toastr !== 'undefined') toastr.error(msg);
        else alert(msg);
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
                    <div class="card-body text-center text-muted">Data menu tidak ditemukan.</div>
                </div>`);
            return;
        }

        menus.forEach(function (menu) {
            if (menu.children && menu.children.length > 0) {
                html += `
                <div class="card mb-5 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title fw-bold m-0">${esc(menu.nama_menu)}</h6>
                    </div>
                    <div class="card-body">`;
                menu.children.forEach(function (child) {
                    html += buildMenuRow(child, permissions);
                });
                html += `</div></div>`;
            } else {
                html += `
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">${buildMenuRow(menu, permissions)}</div>
                </div>`;
            }
        });

        $('#permission-container').html(html);
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
    <div class="py-3 border-bottom">
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
}

    $(document).on('change', '.perm-item', function () {
        let roleId = $('#select-role').val();
        let menuId = $(this).data('menu-id');
        let field  = $(this).data('field');
        let value  = $(this).is(':checked') ? 1 : 0;

        let total   = $(`.perm-item[data-menu-id="${menuId}"]`).length;
        let checked = $(`.perm-item[data-menu-id="${menuId}"]:checked`).length;
        $(`#all_${menuId}`).prop('checked', total === checked);

        updatePermissionAjax(roleId, menuId, field, value);
    });

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
                if (typeof toastr !== 'undefined') toastr.success(res.message);
            },
            error: function (xhr) {
                notifyError(xhr, 'Gagal menyimpan');
            }
        });
    }

});
</script>
@endpush