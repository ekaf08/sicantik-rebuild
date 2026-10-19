<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenuPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('bo.permission.index', compact('roles'));
    }

    private function decryptId(?string $value): int
    {
        try {
            return (int) Crypt::decryptString($value ?? '');
        } catch (DecryptException $e) {
            abort(422, 'Parameter tidak valid');
        }
    }

    public function getPermissions(Request $request)
    {
        $request->validate(['role_id' => 'required|string']);

        $roleId = $this->decryptId($request->role_id);

        $assignedIds = DB::table('menu_role')
            ->where('role_id', $roleId)
            ->whereNull('deleted_at')
            ->pluck('menu_id')
            ->all();

        $menus = Menu::with(['children' => function ($q) use ($assignedIds) {
            $q->whereIn('status_menu', ['1', 'Aktif'])
            ->whereIn('id_menu', $assignedIds)
            ->orderBy('urutan')->orderBy('id_menu');
            }])
            ->where(fn ($q) => $q->whereNull('parent_id')->orWhere('parent_id', 0))
            ->whereIn('status_menu', ['1', 'Aktif'])
            ->where(function ($q) use ($assignedIds) {
                $q->whereIn('id_menu', $assignedIds)
                ->orWhereHas('children', fn ($c) => $c->whereIn('id_menu', $assignedIds));
            })
            ->orderBy('urutan')
            ->orderBy('id_menu')
            ->get()
            ->each(function ($m) use ($assignedIds) {
                $m->parent_assigned = in_array($m->id_menu, $assignedIds);
            });
        $permissions = RoleMenuPermission::where('role_id', $roleId)
            ->get()
            ->keyBy('menu_id');

        foreach ($assignedIds as $id) {
            if (!$permissions->has($id)) {
                $permissions->put($id, new RoleMenuPermission([
                    'role_id' => $roleId, 'menu_id' => $id,
                    'table' => true, 'create' => false, 'update' => false, 'delete' => false,
                ]));
            }
        }
        return response()->json([
            'success'     => true,
            'menus'       => $menus,
            'permissions' => $permissions,
        ]);
    }

    public function updateAccess(Request $request)
    {
        $data = $request->validate([
            'role_id' => 'required|string',
            'menu_id' => 'required|string',
            'field'   => 'required|in:table,create,update,delete,all',
            'value'   => 'required|in:0,1',
        ]);

        $data['role_id'] = $this->decryptId($data['role_id']);
        $data['menu_id'] = $this->decryptId($data['menu_id']);

        $isAssigned = DB::table('menu_role')
            ->where('role_id', $data['role_id'])
            ->where('menu_id', $data['menu_id'])
            ->whereNull('deleted_at')
            ->exists();

        if (!$isAssigned) {
            abort(422, 'Menu ini belum di-assign ke role tersebut');
        }

        $value = (bool) $data['value'];

        $perm = RoleMenuPermission::firstOrNew([
            'role_id' => $data['role_id'],
            'menu_id' => $data['menu_id'],
        ]);

        // baris baru: menu yang sudah di-assign dianggap boleh dilihat
        if (!$perm->exists) {
            $perm->table  = true;
            $perm->create = false;
            $perm->update = false;
            $perm->delete = false;
        }

        if ($data['field'] === 'all') {
            $perm->table = $perm->create = $perm->update = $perm->delete = $value;
        } else {
            $perm->{$data['field']} = $value;

            if ($data['field'] === 'table' && !$value) {
                $perm->create = $perm->update = $perm->delete = false;
            } elseif ($data['field'] !== 'table' && $value) {
                $perm->table = true;
            }
        }

$perm->can_access = $perm->table;

        $perm->can_access = $perm->table || $perm->create || $perm->update || $perm->delete;
        $perm->save();

        return response()->json([
            'success' => true,
            'message' => 'Hak akses berhasil diperbarui',
            'data'    => $perm,
        ]);
    }
}