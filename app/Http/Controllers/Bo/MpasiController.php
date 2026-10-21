<?php

namespace App\Http\Controllers\Bo;

use App\Support\Access;
use App\Http\Controllers\Controller;
use App\Models\Mpasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

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

        $request->validate($this->rules());

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
        if (!Access::can('mpasi', 'update')) {
        return response()->json(['status' => 'error', 'message' => 'Akses ditolak'], 403);
        }

        $mpasi = Mpasi::where('uuid', $id)->firstOrFail();

        return response()->json([
            'status'    => 'success',
            'data'      => $mpasi,
            'embed_url' => $mpasi->embed_video_url,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!Access::can('mpasi', 'update')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit resep.');
        }

        $mpasi = Mpasi::where('uuid', $id)->firstOrFail();

        $request->validate($this->rules());

        $gambarPath = $mpasi->mpasi_foto;
        $fotoLama   = null;

        if ($request->hasFile('mpasi_foto')) {
            $fotoLama   = $mpasi->mpasi_foto;
            $gambarPath = $request->file('mpasi_foto')->store('mpasi', 'public');
        }

        try {
            $mpasi->update([
                'judul'         => $request->judul,
                'kategori_usia' => $request->kategori_usia,
                'deskripsi'     => $request->deskripsi,
                'bahan'         => $request->bahan,
                'langkah'       => $request->langkah,
                'mpasi_foto'    => $gambarPath,
                'url_video'     => $request->url_video,
            ]);
        } catch (\Throwable $e) {
            if ($fotoLama) {
                Storage::disk('public')->delete($gambarPath);
            }
            Log::error('Update MPASI gagal: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data MPASI.');
        }

        if ($fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()->route('mpasi.index')->with('success', 'Data MPASI berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Access::can('mpasi', 'delete')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus resep.');
        }

        $mpasi = Mpasi::where('uuid', $id)->firstOrFail();
        $mpasi->delete();

        return redirect()->route('mpasi.index')->with('success', 'Data MPASI berhasil dihapus!');
    }

    private function rules(): array
    {
        return [
            'judul'         => 'required|string|max:255',
            'kategori_usia' => ['required', 'string', Rule::in(array_keys(Mpasi::listKategoriUsia()))],
            'deskripsi'     => 'nullable|string',
            'bahan'         => 'required|string',
            'langkah'       => 'required|string',
            'mpasi_foto'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_video'     => 'nullable|url',
        ];
    }
}