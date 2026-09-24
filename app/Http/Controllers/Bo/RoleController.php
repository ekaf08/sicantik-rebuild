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
        // 1. Ambil data roles (menggunakan primary key 'id' standar tabel roles)
        $roles = Role::orderBy('id', 'asc')->paginate(10);

        // 2. Ambil data menu dari tabel m_menu diurutkan berdasarkan id_menu
        $menus = DB::table('m_menu')->orderBy('id_menu', 'asc')->get();

        // 3. Ambil data permissions
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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // A. Simpan data ke tabel 'roles'
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => 'web',
            ]);

            // B. Simpan daftar menu yang dicentang ke tabel 'menu_role'
            if ($request->has('menus') && is_array($request->menus)) {
                $insertMenuRole = [];
                foreach ($request->menus as $menuId) {
                    $insertMenuRole[] = [
                        'role_id'    => $role->id,
                        'id_menu'    => $menuId, // Disesuaikan menjadi 'id_menu' agar cocok dengan tabel m_menu
                        'created_by' => Auth::id() ?? 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Simpan sekaligus ke tabel menu_role
                DB::table('menu_role')->insert($insertMenuRole);
            }

            DB::commit();
            return redirect()->route('role.index')->with('success', 'Role dan Akses Menu berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
