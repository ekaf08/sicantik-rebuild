<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $parentMenus = Menu::whereNull('parent_id')->orWhere('parent_id', 0)->get();
        return view('bo.menu.index', compact('parentMenus'));
    }

    public function data(Request $request)
    {
        $search = $request->input('search.value');
        $menus = Menu::with('parent')
            ->when($search, function ($query, $search) {
                return $query->where('nama_menu', 'ilike', '%' . $search . '%');
            })
            ->orderBy('urutan', 'asc');

        return DataTables::of($menus)
            ->addIndexColumn()
            ->addColumn('parent_name', function($row){
                return $row->parent ? $row->parent->nama_menu : '-';
            })
            ->addColumn('status_badge', function($row){
                $isAktif = ($row->status_menu == 1 || $row->status_menu == 'Aktif');
                $text = $isAktif ? 'Aktif' : 'Non Aktif';
                $class = $isAktif ? 'bg-success' : 'bg-secondary';
                return '<span class="badge ' . $class . ' px-3 py-2">' . $text . '</span>';
            })
            ->addColumn('icon_display', function($row){
                return '<i class="' . $row->icon . ' fs-5 me-2"></i> <span class="text-muted">' . $row->icon . '</span>';
            })
            ->addColumn('action', function($row){
                $encryptedId = Crypt::encryptString($row->id_menu);

                $editUrl = route('menu.edit', $encryptedId);
                $updateUrl = route('menu.update', $encryptedId);
                $deleteUrl = route('menu.destroy', $encryptedId);

                return '
                    <div class="d-flex justify-content-end gap-1">
                        <button type="button" class="btn btn-icon btn-light-success btn-sm me-1" onclick="editForm(\'' . $editUrl . '\', \'' . $updateUrl . '\', \'EDIT MENU\')">
                            <i class="ki-outline ki-pencil fs-3"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-light-danger btn-sm" onclick="deleteData(\'' . $deleteUrl . '\')">
                            <i class="ki-outline ki-trash fs-3"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status_badge', 'icon_display', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu'   => 'required|string|max:255',
            'icon'        => 'required|string|max:255',
            'url_menu'    => 'required|string|max:255',
            'status_menu' => 'required|in:1,0,Aktif,Non Aktif',
            'parent_id'   => 'nullable|exists:m_menu,id_menu',
            'urutan'      => 'nullable|integer',
        ]);

        Menu::create([
            'parent_id'   => $request->parent_id ?: null,
            'nama_menu'   => $request->nama_menu,
            'icon'        => $request->icon,
            'url_menu'    => $request->url_menu,
            'status_menu' => $request->status_menu,
            'urutan'      => $request->urutan ?? 0,
            'created_by'  => auth()->id(), 
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Menu baru berhasil ditambahkan!'
        ]);
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $menu = Menu::where('id_menu', $id)->firstOrFail();
            
            return response()->json([
                'status' => 'success',
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid!'], 404);
        }
    }

    public function update(Request $request, $encryptedId)
    {
        $request->validate([
            'nama_menu'   => 'required|string|max:255',
            'icon'        => 'required|string|max:255',
            'url_menu'    => 'required|string|max:255',
            'status_menu' => 'required|in:1,0,Aktif,Non Aktif',
            'parent_id'   => 'nullable|exists:m_menu,id_menu',
            'urutan'      => 'nullable|integer',
        ]);

        $id = Crypt::decryptString($encryptedId);
        $menu = Menu::where('id_menu', $id)->firstOrFail();

        $menu->update([
            'parent_id'   => $request->parent_id ?: null,
            'nama_menu'   => $request->nama_menu,
            'icon'        => $request->icon,
            'url_menu'    => $request->url_menu,
            'status_menu' => $request->status_menu,
            'urutan'      => $request->urutan ?? 0,
            'updated_by'  => auth()->id(), 
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Data menu berhasil diperbarui!'
        ]);
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            
            $menu = Menu::where('id_menu', $id)->firstOrFail();
            $menu->delete(); // Otomatis terhapus di database
            
            return response()->json([
                'status' => 'success', 
                'message' => 'Menu berhasil dihapus dari database!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Gagal mendekripsi ID atau data tidak ditemukan!'
            ], 400);
        }
    }
    public function handleDynamicPage($slug)
{
    $menu = Menu::where('url_menu', $slug)->first();

    if (!$menu) {
        abort(404); 
    }

    return view('bo.halaman-dinamis', compact('menu'));
}
}