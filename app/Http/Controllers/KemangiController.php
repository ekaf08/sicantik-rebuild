<?php

namespace App\Http\Controllers;

use App\Models\Kemangi;
use App\Support\IdCipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KemangiController extends Controller
{
    // Daftar kecamatan + kelurahan dari database
    public function wilayah()
    {
        try {
            $kecamatan = DB::table('m_kecamatan')->whereNull('deleted_at')->orderBy('nama_kec')->get(['id_kec', 'nama_kec']);
            $kelurahan = DB::table('m_kelurahan')->orderBy('nama_kel')->get(['no_kec', 'nama_kel'])->groupBy('no_kec');

            $result = [];
            foreach ($kecamatan as $kec) {
                $result[$kec->nama_kec] = ($kelurahan[$kec->id_kec] ?? collect())->pluck('nama_kel')->values();
            }

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Gagal membaca data wilayah: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $data = Kemangi::orderByDesc('created_at')->get()->map(function ($row) {
            // Ubah ke array dulu: model otomatis mengubah 'id' jadi angka, sehingga token akan terbaca 0
            $item = $row->toArray();
            $item['id'] = IdCipher::encode($row->id);
            return $item;
        });

        return response()->json($data);
    }

    private function aturan(): array
    {
        return [
            'kelompok'       => ['required', Rule::in(['Remaja', 'Orang Tua'])],
            'kecamatan'      => 'required|string|max:255',
            'kelurahan'      => 'required|string|max:255',
            'tahun'          => 'required|digits:4',
            'nilai_pre'      => 'required|numeric|min:0|max:9999',
            'nilai_post'     => 'required|numeric|min:0|max:9999',
            'jumlah_peserta' => 'required|integer|min:0',
        ];
    }

    private function pesan(): array
    {
        return [
            'kelompok.required'       => 'Kelompok wajib dipilih.',
            'kecamatan.required'      => 'Kecamatan wajib dipilih.',
            'kelurahan.required'      => 'Kelurahan wajib dipilih.',
            'tahun.required'          => 'Tahun wajib dipilih.',
            'nilai_pre.required'      => 'Rata-rata nilai pre wajib diisi.',
            'nilai_pre.numeric'       => 'Rata-rata nilai pre harus berupa angka.',
            'nilai_post.required'     => 'Rata-rata nilai post wajib diisi.',
            'nilai_post.numeric'      => 'Rata-rata nilai post harus berupa angka.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.integer'  => 'Jumlah peserta harus berupa angka bulat.',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->aturan(), $this->pesan());

        Kemangi::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    public function update(Request $request, string $id)
    {
        $id = IdCipher::decodeOrFail($id);
        $item = Kemangi::findOrFail($id);

        $validated = $request->validate($this->aturan(), $this->pesan());

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diubah']);
    }

    // Hapus data (baris tetap ada di database, hanya ditandai deleted_at)
    public function destroy(string $id)
    {
        $id = IdCipher::decodeOrFail($id);

        $item = Kemangi::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
