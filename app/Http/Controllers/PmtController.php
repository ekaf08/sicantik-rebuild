<?php

namespace App\Http\Controllers;

use App\Models\Pmt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PmtController extends Controller
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
        $data = Pmt::orderByDesc('created_at')->get()->map(function ($row) {
            $row->foto_url = $row->foto ? asset('storage/' . $row->foto) : null;
            return $row;
        });

        return response()->json($data);
    }

    private function rules(?int $ignoreId = null, bool $fotoWajib = false): array
    {
        return [
            'nik' => ['required', 'digits:16'],
            'nama_balita' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'alamat' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2100',
            'putaran' => 'required|string|max:20',
            'foto' => [$fotoWajib ? 'required' : 'nullable', 'image', 'max:2048'],
        ];
    }

    // NIK yang sama boleh ikut putaran lain, tapi tidak boleh dobel di tahun + putaran yang sama
    private function cekDobel(Request $request, ?int $ignoreId = null): ?string
    {
        $ada = Pmt::where('nik', $request->nik)
            ->where('tahun', $request->tahun)
            ->where('putaran', $request->putaran)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        return $ada ? 'NIK ini sudah tercatat pada tahun dan putaran yang sama.' : null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(null, true));

        if ($pesan = $this->cekDobel($request)) {
            return response()->json(['message' => $pesan], 422);
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pmt', 'public');
        }

        $item = Pmt::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $item]);
    }

    public function update(Request $request, int $id)
    {
        $item = Pmt::findOrFail($id);
        $validated = $request->validate($this->rules($id, false));

        if ($pesan = $this->cekDobel($request, $id)) {
            return response()->json(['message' => $pesan], 422);
        }

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pmt', 'public');
        } else {
            unset($validated['foto']);
        }

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diubah', 'data' => $item]);
    }

    public function destroy(int $id)
    {
        $item = Pmt::findOrFail($id);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
