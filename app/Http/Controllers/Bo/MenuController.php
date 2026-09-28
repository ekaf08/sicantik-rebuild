<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu; 
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $parentMenus = Menu::whereNull('parent_id')->orWhere('parent_id', 0)->get();
        return view('bo.menu.index', compact('parentMenus'));
    }

   // Mengambil data untuk tabel via AJAX (DataTables)
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
                // Sesuaikan jika status di database Anda menggunakan angka (1 untuk Aktif, 0 untuk Non Aktif)
                $isAktif = ($row->status_menu == 1 || $row->status_menu == 'Aktes' || $row->status_menu == 'Aktif');
                
                $text = $isAktif ? 'Aktif' : 'Non Aktif';
                $class = $isAktif ? 'bg-success' : 'bg-secondary';
                
                return '<span class="badge ' . $class . ' px-3 py-2">' . $text . '</span>';
            })
            ->addColumn('icon_display', function($row){
                return '<i class="' . $row->icon . ' fs-5 me-2"></i> <span class="text-muted">' . $row->icon . '</span>';
            })
            ->addColumn('action', function($row){
                $editUrl = route('menu.edit', $row->id_menu);
                $updateUrl = route('menu.update', $row->id_menu);
                $deleteUrl = route('menu.destroy', $row->id_menu);

                return '
                    <div class="d-flex justify-content-end gap-2">
                        <!-- Tombol Edit Warna Hijau (btn-light-success) -->
                        <button type="button" class="btn btn-icon btn-light-success btn-sm me-1" onclick="editForm(\'' . $editUrl . '\', \'' . $updateUrl . '\', \'EDIT MENU\')">
                            <i class="ki-outline ki-pencil fs-3"></i>
                        </button>
                        <!-- Tombol Delete Warna Merah (btn-light-danger) -->
                        <button type="button" class="btn btn-icon btn-light-danger btn-sm" onclick="deleteData(\'' . $deleteUrl . '\')">
                            <i class="ki-outline ki-trash fs-3"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status_badge', 'icon_display', 'action'])
            ->make(true);
    }

    // Menyimpan data baru (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu'   => 'required|string|max:255',
            'icon'        => 'required|string|max:255',
            'url_menu'    => 'required|string|max:255',
            'status_menu' => 'required|in:Aktif,Non Aktif',
            // PERBAIKAN DI SINI: Ubah 'menus' menjadi 'm_menu' sesuai nama tabel model
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

    // Mengambil data satuan untuk form Edit (AJAX)
    public function edit($id)
    {
        $menu = Menu::where('id_menu', $id)->firstOrFail();
        
        return response()->json([
            'status' => 'success',
            'data' => $menu
        ]);
    }

    // Memperbarui data (AJAX)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu'   => 'required|string|max:255',
            'icon'        => 'required|string|max:255',
            'url_menu'    => 'required|string|max:255',
            'status_menu' => 'required|in:Aktif,Non Aktif',
            // PERBAIKAN DI SINI: Ubah 'menus' menjadi 'm_menu' sesuai nama tabel model
            'parent_id'   => 'nullable|exists:m_menu,id_menu',
            'urutan'      => 'nullable|integer',
        ]);

        $menu = Menu::where('id_menu', $id)->firstOrFail();

        $menu->update([
            'parent_id'   => $request->parent_id ?: null,
            'nama_menu'   => $request->nama_menu,
            'icon'        => $request->icon,
            'url_menu'    => $request->url_menu,
            'status_menu' => $request->status_menu,
            'urutan'      => $request->urutan ?? 0,
        ]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Data menu berhasil diperbarui!'
        ]);
    }

    // Menghapus data (AJAX)
    public function destroy($id)
    {
        $menu = Menu::where('id_menu', $id)->firstOrFail();
        $menu->delete();
        
        return response()->json([
            'status' => 'success', 
            'message' => 'Menu berhasil dihapus!'
        ]);
    }
}