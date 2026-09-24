<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu; 

class MenuController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $menus = Menu::when($search, function ($query, $search) {
        return $query->where('nama_menu', 'like', '%' . $search . '%');
    })
    ->orderBy('urutan', 'asc')
    ->paginate(10);

    $parentMenus = Menu::whereNull('parent_id')->orWhere('parent_id', 1)->get();

    return view('bo.menu.index', compact('menus', 'parentMenus', 'search'));
}

    public function store(Request $request)
{
    $request->validate([
        'nama_menu'   => 'required|string|max:255',
        'icon'        => 'required|string|max:255',
        'url_menu'    => 'required|string|max:255',
        'status_menu' => 'required|in:Aktif,Non Aktif',
    ]);

    $url = $request->url_menu;
    $parentId = str_contains($url, '/') ? 1 : ($request->parent_id ?: null);

    Menu::create([
        'parent_id'   => $parentId,
        'nama_menu'   => $request->nama_menu,
        'icon'        => $request->icon,
        'url_menu'    => $url,
        'status_menu' => $request->status_menu,
        'urutan'      => $request->urutan ?? 0,
        'created_by'  => auth()->id(), 
    ]);

    return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'url_menu' => 'required|string|max:255',
            'status_menu' => 'required|in:Aktif,Non Aktif',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'parent_id' => $request->parent_id ?: null,
            'nama_menu' => $request->nama_menu,
            'icon' => $request->icon,
            'url_menu' => $request->url_menu,
            'status_menu' => $request->status_menu,
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

   public function destroy($id)
{
    $menu = Menu::where('id_menu', $id)->firstOrFail();
    $menu->delete();
    return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
}

public function handleDynamicPage($slug)
{
    $menu = \App\Models\Menu::where('url_menu', $slug)->first();

    if (!$menu) {
        abort(404); 
    }
    return view('bo.menu.dynamic-page', compact('menu'));
}
}