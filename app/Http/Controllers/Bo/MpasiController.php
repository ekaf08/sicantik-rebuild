<?php

namespace App\Http\Controllers\Bo;

use App\Support\Access;
use App\Http\Controllers\Controller;
use App\Models\Mpasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MpasiController extends Controller
{
    public function index()
    {
        if (!Access::can('mpasi', 'table')) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat menu ini.');
        }

        $dataMpasi = Mpasi::latest()->get();
        $listKategori = Mpasi::listKategoriUsia();

        return view('bo.pages.mpasi.mp_asi', compact('dataMpasi', 'listKategori'));
    }

    public function store(Request $request)
    {

        if (!Access::can('mpasi', 'create')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menambah resep.');
        }

        $request->validate([
            'judul'         => 'required|string|max:255',
            'kategori_usia' => 'required|string',
            'deskripsi'     => 'nullable|string',
            'bahan'         => 'required|string',
            'langkah'       => 'required|string',
            'mpasi_foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_video'     => 'nullable|url',
        ]);

        $gambarPath = null;
        if ($request->hasFile('mpasi_foto')) {
            $gambarPath = $request->file('mpasi_foto')->store('mpasi', 'public');
        }

        Mpasi::create([
            'judul'         => $request->judul,
            'kategori_usia' => $request->kategori_usia,
            'deskripsi'     => $request->deskripsi,
            'bahan'         => $request->bahan,
            'langkah'       => $request->langkah,
            'mpasi_foto'    => $gambarPath,
            'url_video'     => $request->url_video,
            'created_by'    => auth()->id(),
        ]);

        return redirect()->route('mpasi.index')->with('success', 'Data MPASI berhasil disimpan!');
    }

    public function show($id)
    {
        $mpasi = Mpasi::findOrFail($id);

        return response()->json([
            'status'    => 'success',
            'data'      => $mpasi,
            'embed_url' => $mpasi->embed_video_url ?? null,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Access::can('mpasi', 'update')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses untuk mengedit resep.'
            ], 403);
        }

        $mpasi = Mpasi::findOrFail($id);

        $request->validate([
            'judul'         => 'required|string|max:255',
            'kategori_usia' => 'required|string',
            'deskripsi'     => 'nullable|string',
            'bahan'         => 'required|string',
            'langkah'       => 'required|string',
            'mpasi_foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_video'     => 'nullable|url',
        ]);

        $gambarPath = $mpasi->mpasi_foto;
        if ($request->hasFile('mpasi_foto')) {
            if ($mpasi->mpasi_foto && Storage::disk('public')->exists($mpasi->mpasi_foto)) {
                Storage::disk('public')->delete($mpasi->mpasi_foto);
            }
            $gambarPath = $request->file('mpasi_foto')->store('mpasi', 'public');
        }

        $mpasi->update([
            'judul'         => $request->judul,
            'kategori_usia' => $request->kategori_usia,
            'deskripsi'     => $request->deskripsi,
            'bahan'         => $request->bahan,
            'langkah'       => $request->langkah,
            'mpasi_foto'    => $gambarPath,
            'url_video'     => $request->url_video,
        ]);

        return redirect()->route('mpasi.index')->with('success', 'Data MPASI berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Access::can('mpasi', 'delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus resep.');
        }
        $mpasi = Mpasi::findOrFail($id);

        if ($mpasi->mpasi_foto && Storage::disk('public')->exists($mpasi->mpasi_foto)) {
            Storage::disk('public')->delete($mpasi->mpasi_foto);
        }

        $mpasi->delete();

        return redirect()->route('mpasi.index')->with('success', 'Data MPASI berhasil dihapus!');
    }
}