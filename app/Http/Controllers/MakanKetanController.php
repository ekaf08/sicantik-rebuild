<?php

namespace App\Http\Controllers;

use App\Models\MakanKetan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Support\IdCipher;

class MakanKetanController extends Controller
{
    // Daftar kecamatan + kelurahan dari tabel m_kecamatan & m_kelurahan
    public function wilayah()
    {
        $kecamatan = DB::table('m_kecamatan')->whereNull('deleted_at')->orderBy('nama_kec')->get(['id_kec', 'nama_kec']);
        $kelurahan = DB::table('m_kelurahan')->orderBy('nama_kel')->get(['no_kec', 'nama_kel'])->groupBy('no_kec');

        $result = [];
        foreach ($kecamatan as $kec) {
            $result[$kec->nama_kec] = ($kelurahan[$kec->id_kec] ?? collect())->pluck('nama_kel')->values();
        }

        return response()->json($result);
    }

    public function index()
    {
        $data = MakanKetan::orderByDesc('created_at')->get()->map(function ($row) {
            $row->foto_1_url = $row->foto_1 ? asset('storage/' . $row->foto_1) : null;
            $row->foto_2_url = $row->foto_2 ? asset('storage/' . $row->foto_2) : null;
            // Ubah ke array dulu: model otomatis mengubah 'id' jadi angka, sehingga token akan terbaca 0
            $item = $row->toArray();
            $item['id'] = IdCipher::encode($row->id);
            return $item;
        });

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'nama_dasa_wisma' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'jumlah_rumah' => 'nullable|integer|min:1',
            'tahun' => 'required|string|max:4',
            'juara' => 'nullable|string|max:255',
            'foto_1' => 'nullable|image|max:2048', // max 2MB
            'foto_2' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_1')) {
            $validated['foto_1'] = $request->file('foto_1')->store('makan-ketan', 'public');
        }
        if ($request->hasFile('foto_2')) {
            $validated['foto_2'] = $request->file('foto_2')->store('makan-ketan', 'public');
        }

        MakanKetan::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    public function update(Request $request, string $id)
    {
        $id = IdCipher::decodeOrFail($id);
        $item = MakanKetan::findOrFail($id);

        $validated = $request->validate([
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'nama_dasa_wisma' => 'required|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'jumlah_rumah' => 'nullable|integer|min:1',
            'tahun' => 'required|string|max:4',
            'juara' => 'nullable|string|max:255',
            'foto_1' => 'nullable|image|max:2048',
            'foto_2' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_1')) {
            if ($item->foto_1) {
                Storage::disk('public')->delete($item->foto_1);
            }
            $validated['foto_1'] = $request->file('foto_1')->store('makan-ketan', 'public');
        }
        if ($request->hasFile('foto_2')) {
            if ($item->foto_2) {
                Storage::disk('public')->delete($item->foto_2);
            }
            $validated['foto_2'] = $request->file('foto_2')->store('makan-ketan', 'public');
        }

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diubah']);
    }

    /**
     * Hapus data (soft delete: baris tetap ada di database, hanya ditandai deleted_at)
     */
    public function destroy(string $id)
    {
        $id = IdCipher::decodeOrFail($id);

        $item = MakanKetan::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
