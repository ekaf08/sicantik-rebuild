<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(10);
        $menus = DB::table('m_menu')->orderBy('id_menu', 'asc')->get();
        $permissions = DB::table('permissions')->get();

        return view('bo.role.index', compact('roles', 'menus', 'permissions'));
    }

    public function create()
    {
        $permissions = DB::table('permissions')->get();
        $menus = DB::table('m_menu')->get();

        return view('bo.role.create', compact('permissions', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            if ($request->filled('menus')) {
                $insertMenuRole = [];
                foreach ($request->menus as $menuId) {
                    $insertMenuRole[] = [
                        'role_id'    => $role->id,
                        'menu_id'    => $menuId,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('menu_role')->insert($insertMenuRole);
            }

            if ($request->filled('permissions')) {
                $insertRolePermission = [];
                foreach ($request->permissions as $permId) {
                    $insertRolePermission[] = [
                        'role_id'       => $role->id,
                        'permission_id' => $permId,
                    ];
                }
                DB::table('role_has_permissions')->insert($insertRolePermission);
            }

            DB::commit();
            return redirect()->route('role.index')->with('success', 'Role dan Akses Menu berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Dipanggil lewat AJAX untuk mengisi modal edit.
     */
    public function edit(string $id)
    {
        $realId = Role::decId($id);
        $role = Role::findOrFail($realId);

        $selectedMenuIds = DB::table('menu_role')
            ->where('role_id', $role->id)
            ->whereNull('deleted_at')
            ->pluck('menu_id');

        $selectedPermissionIds = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id');

        return response()->json([
            'id'                   => $role->enc_id,
            'name'                 => $role->name,
            'selected_menus'       => $selectedMenuIds,
            'selected_permissions' => $selectedPermissionIds,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $realId = Role::decId($id);
        $role = Role::findOrFail($realId);

        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
            ]);

            // --- Menu ---
            $newMenuIds = array_map('intval', $request->menus ?? []);

            DB::table('menu_role')
                ->where('role_id', $role->id)
                ->whereNull('deleted_at')
                ->whereNotIn('menu_id', $newMenuIds)
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => Auth::id(),
                ]);

            $existingMenuIds = DB::table('menu_role')
                ->where('role_id', $role->id)
                ->whereNull('deleted_at')
                ->pluck('menu_id')
                ->all();

            $toInsertMenu = array_diff($newMenuIds, $existingMenuIds);
            if (!empty($toInsertMenu)) {
                $insertMenuRole = [];
                foreach ($toInsertMenu as $menuId) {
                    $insertMenuRole[] = [
                        'role_id'    => $role->id,
                        'menu_id'    => $menuId,
                        'created_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('menu_role')->insert($insertMenuRole);
            }

            // --- Permission ---
            $newPermissionIds = array_map('intval', $request->permissions ?? []);

            DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->whereNotIn('permission_id', $newPermissionIds)
                ->delete();

            $existingPermissionIds = DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->pluck('permission_id')
                ->all();

            $toInsertPermission = array_diff($newPermissionIds, $existingPermissionIds);
            if (!empty($toInsertPermission)) {
                $insertRolePermission = [];
                foreach ($toInsertPermission as $permId) {
                    $insertRolePermission[] = [
                        'role_id'       => $role->id,
                        'permission_id' => $permId,
                    ];
                }
                DB::table('role_has_permissions')->insert($insertRolePermission);
            }

            DB::commit();
            return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $realId = Role::decId($id);
        $role = Role::findOrFail($realId);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus!');
    }
}
