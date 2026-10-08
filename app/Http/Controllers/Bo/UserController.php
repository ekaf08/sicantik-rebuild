<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        $kecamatan = Kecamatan::all(); // 1. Ambil data kecamatan'
        $kelurahan = Kelurahan::all();

        $datas = [
            'role' => $role,
            'kecamatan' => $kecamatan, // 2. Masukkan ke dalam array datas
            'kelurahan' => $kelurahan,
        ];

        return view('bo.user.index', $datas);
    }

    public function data(Request $request)
    {
        $query = User::forDatatable();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('password', function ($row) {
                return '••••••••';
            })
            ->editColumn('role', function ($row) {
                return $row->role ?? '-';
            })
            ->editColumn('nama_kec', function ($row) {
                return $row->nama_kec ?? '-';
            })
            ->editColumn('nama_kel', function ($row) {
                return $row->nama_kel ?? '-';
            })
            ->addColumn('action', function ($row) {
                $encryptedId = Crypt::encryptString($row->id);

                return '
                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Actions
                        <i class="ki-outline ki-down fs-5 ms-1"></i>
                    </a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-6 text-start" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 btn-view" data-id="' . $encryptedId . '">View</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 btn-edit" data-id="' . $encryptedId . '">Edit</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 text-danger btn-delete" data-id="' . $encryptedId . '">Delete</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" class="menu-link px-3 text-danger btn-reset" data-id="' . $encryptedId . '">Reset Password</a>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])

            ->filter(function ($instance) use ($request) {
                if ($keyword = $request->get('search')['value']) {
                    $instance->where(function($w) use ($keyword) {
                        $w->orWhere('users.name', 'LIKE', "%{$keyword}%")
                          ->orWhere('users.username', 'LIKE', "%{$keyword}%")
                          ->orWhere('kec.nama_kec', 'LIKE', "%{$keyword}%")
                          ->orWhere('kel.nama_kel', 'LIKE', "%{$keyword}%")
                          ->orWhere('roles.name', 'LIKE', "%{$keyword}%");
                    });
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            // Password minimal 8 karakter, harus ada huruf besar, huruf kecil, angka, dan simbol
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'regex:/[a-z]/',    // harus ada huruf kecil
                'regex:/[A-Z]/',   // harus ada huruf besar
                'regex:/[0-9]/',    // harus ada angka
                'regex:/[@$!%*#?&]/', // harus ada simbol
            ],
            'id_kec' => 'required|exists:m_kecamatan,id_kec',
            'id_kel' => 'required|exists:m_kelurahan,id_kel',
            'role_id' => 'required|exists:roles,id',
        ], [
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu simbol karakter khusus.'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil ditambahkan!'
        ]);
    }

    public function getKelurahan(string $no_kec)
    {
        return response()->json(
            Kelurahan::where('no_kec', $no_kec)->orderBy('nama_kel')->get(['id_kel', 'nama_kel'])
        );
    }

    public function resetPassword(Request $request, string $id)
    {
        try {
            $realId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'ID tidak valid'], 400);
        }

        $request->validate([
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed', 
                'regex:/[a-z]/', 
                'regex:/[A-Z]/', 
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/'
            ],
        ], [
            'password.regex' => 'Password baru harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu simbol karakter khusus.'
        ]);

        $user = User::findOrFail($realId);

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil direset!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
        $realId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'ID tidak valid'], 400);
        }

        $user = User::findOrFail($realId);
        return response()->json($user);
    }

    public function viewDetail(string $id)
    {
        try {
            $realId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'ID tidak valid'], 400);
        }

        $user = User::with('role')->findOrFail($realId);

        $menus = collect();
        $permissions = collect();

        if ($user->role_id) {
            $menus = DB::table('menu_role')
                ->join('m_menu', 'm_menu.id_menu', '=', 'menu_role.menu_id')
                ->where('menu_role.role_id', $user->role_id)
                ->whereNull('menu_role.deleted_at')
                ->whereNull('m_menu.deleted_at')
                ->orderBy('m_menu.urutan')
                ->select('m_menu.id_menu', 'm_menu.nama_menu', 'm_menu.icon')
                ->get();

            $permissions = DB::table('role_has_permissions')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where('role_has_permissions.role_id', $user->role_id)
                ->pluck('permissions.name');
        }

        $kecamatan = Kecamatan::where('id_kec', $user->id_kec)->value('nama_kec');
        $kelurahan = Kelurahan::where('id_kel', $user->id_kel)->value('nama_kel');

        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role_name' => $user->role->name ?? '-',
            'kecamatan' => $kecamatan ?? '-',
            'kelurahan' => $kelurahan ?? '-',
            'menus' => $menus,
            'permissions' => $permissions,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findorFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $realId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'ID tidak valid'], 400);
        }
        $user = User::findOrFail($realId);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($realId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($realId)],
            'password' => [
                'nullable', 
                'string', 
                'min:8', 
                'regex:/[a-z]/', 
                'regex:/[A-Z]/', 
                'regex:/[0-9]/', 
                'regex:/[@$!%*#?&]/'
            ],
            'id_kec' => 'required|exists:m_kecamatan,id_kec',
            'id_kel' => 'required|exists:m_kelurahan,id_kel',
            'role_id' => 'required|exists:roles,id',
        ], [
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu simbol karakter khusus.'
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'id_kec' => $request->id_kec,
            'id_kel' => $request->id_kel,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diupdate!'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        try {
        $realId = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['message' => 'ID tidak valid'], 400);
        }

        $user = User::findOrFail($realId);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus!'
        ]);
    }
}
