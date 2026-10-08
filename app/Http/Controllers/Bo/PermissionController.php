<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenuPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('bo.permission.index', compact('roles'));
    }

    public function getPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
        ]);

        $roleId = $request->role_id;

        $menus = Menu::with('children')
              ->where(function ($q) {
              $q->whereNull('parent_id')->orWhere('parent_id', 0);
        })
        ->whereIn('status_menu', ['1', 'Aktif'])
        ->orderBy('urutan')
        ->get();
        
        $permissions = RoleMenuPermission::where('role_id', $roleId)
            ->get()
            ->keyBy('menu_id');

        return response()->json([
            'success'     => true,
            'menus'       => $menus,
            'permissions' => $permissions,
        ]);
    }

    public function updateAccess(Request $request)
    {
        $data = $request->validate([
            'role_id' => 'required|integer',
            'menu_id' => 'required|integer',
            'field'   => 'required|in:table,create,update,delete,all',
            'value'   => 'required|in:0,1',
        ]);

        $value = (bool) $data['value'];

        $perm = RoleMenuPermission::firstOrNew([
            'role_id' => $data['role_id'],
            'menu_id' => $data['menu_id'],
        ]);

        if ($data['field'] === 'all') {
            $perm->table  = $value;
            $perm->create = $value;
            $perm->update = $value;
            $perm->delete = $value;
        } else {
            $perm->{$data['field']} = $value;
        }

        $perm->can_access = $perm->table || $perm->create || $perm->update || $perm->delete;
        $perm->save();

        return response()->json([
            'success' => true,
            'message' => 'Hak akses berhasil diperbarui',
            'data'    => $perm
        ]);
    }
}