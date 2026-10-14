<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PenghargaanController extends Controller
{
    public function index()
{
    try {
        $penghargaans = Penghargaan::orderBy('id', 'desc')->get();
    } catch (\Throwable $e) {
        // Jika tabel belum dibuat di DB, kembalikan array/collection kosong agar UI tidak crash
        $penghargaans = collect([]);
    }

    return view('bo.pages.penghargaan.penghargaan', compact('penghargaans'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'deskripsi_penghargaan' => 'required|string',
            'kategori_penghargaan' => 'required|string|max:255',
            'tahun' => 'required|numeric',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('penghargaan/foto', 'public');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('penghargaan/file', 'public');
        }

        Penghargaan::create([
            'nama_penghargaan' => $request->nama_penghargaan,
            'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
            'kategori_penghargaan' => $request->kategori_penghargaan,
            'tahun' => $request->tahun,
            'foto' => $fotoPath,
            'file' => $filePath,
            'created_by' => Auth::user()->name ?? 'Admin Kominfo',
        ]);

        return redirect()->back()->with('success', 'Data penghargaan berhasil ditambahkan');
    }

    public function update(Request $request, int $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'deskripsi_penghargaan' => 'required|string',
            'kategori_penghargaan' => 'required|string|max:255',
            'tahun' => 'required|numeric',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($penghargaan->foto) {
                Storage::disk('public')->delete($penghargaan->foto);
            }
            $penghargaan->foto = $request->file('foto')->store('penghargaan/foto', 'public');
        }

        if ($request->hasFile('file')) {
            if ($penghargaan->file) {
                Storage::disk('public')->delete($penghargaan->file);
            }
            $penghargaan->file = $request->file('file')->store('penghargaan/file', 'public');
        }

        $penghargaan->update([
            'nama_penghargaan' => $request->nama_penghargaan,
            'deskripsi_penghargaan' => $request->deskripsi_penghargaan,
            'kategori_penghargaan' => $request->kategori_penghargaan,
            'tahun' => $request->tahun,
        ]);

        return redirect()->back()->with('success', 'Data penghargaan berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        $penghargaan = Penghargaan::findOrFail($id);

        if ($penghargaan->foto) {
            Storage::disk('public')->delete($penghargaan->foto);
        }
        if ($penghargaan->file) {
            Storage::disk('public')->delete($penghargaan->file);
        }

        $penghargaan->delete();

        return redirect()->back()->with('success', 'Data penghargaan berhasil dihapus');
    }
}
