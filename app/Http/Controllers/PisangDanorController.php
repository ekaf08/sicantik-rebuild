<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PisangBsi;
use App\Models\PisangOrganik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PisangDanorController extends Controller
{
    // Daftar kecamatan + kelurahan
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

    // ===================== ANORGANIK (Pisang BSI) =====================

    public function indexBsi()
    {
        $data = PisangBsi::orderByDesc('created_at')->get()->map(function ($row) {
            $row->upload_file_1_url = $row->upload_file_1 ? asset('storage/' . $row->upload_file_1) : null;
            $row->upload_file_2_url = $row->upload_file_2 ? asset('storage/' . $row->upload_file_2) : null;
            return $row;
        });

        return response()->json($data);
    }

    public function storeBsi(Request $request)
    {
        $validated = $request->validate([
            'nama_bsi' => 'required|string|max:255',
            'alamat_bsi' => 'required|string|max:255',
            'metode_pengolahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'rw' => 'required|string|max:10',
            'rt' => 'required|string|max:10',
            'upload_file_1' => 'nullable|image|max:2048',
            'upload_file_2' => 'nullable|image|max:2048',
        ]);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('pisang-danor', 'public');
            }
        }

        $item = PisangBsi::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $item]);
    }

    public function updateBsi(Request $request, int $id)
    {
        $item = PisangBsi::findOrFail($id);

        $validated = $request->validate([
            'nama_bsi' => 'required|string|max:255',
            'alamat_bsi' => 'required|string|max:255',
            'metode_pengolahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'rw' => 'required|string|max:10',
            'rt' => 'required|string|max:10',
            'upload_file_1' => 'nullable|image|max:2048',
            'upload_file_2' => 'nullable|image|max:2048',
        ]);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($request->hasFile($field)) {
                if ($item->$field) {
                    Storage::disk('public')->delete($item->$field);
                }
                $validated[$field] = $request->file($field)->store('pisang-danor', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diubah', 'data' => $item]);
    }

    public function destroyBsi(int $id)
    {
        $item = PisangBsi::findOrFail($id);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($item->$field) {
                Storage::disk('public')->delete($item->$field);
            }
        }

        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // ===================== ORGANIK =====================

    private function organikRules(): array
    {
        return [
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'rw' => 'nullable|string|max:10',
            'rt' => 'nullable|string|max:10',
            'jumlah_tonase' => 'required|numeric|min:0',
            'tonase_residu' => 'required|numeric|min:0',
            'sampah_terolah_anorganik' => 'nullable|numeric|min:0',
            'sampah_terolah_organik' => 'nullable|numeric|min:0',
            'metode_pengolahan' => 'nullable|array',
            'metode_pengolahan.*' => 'string|max:100',
            'upload_file_1' => 'nullable|image|max:2048',
            'upload_file_2' => 'nullable|image|max:2048',
        ];
    }

    public function indexOrganik()
    {
        $data = PisangOrganik::orderByDesc('created_at')->get()->map(function ($row) {
            $row->upload_file_1_url = $row->upload_file_1 ? asset('storage/' . $row->upload_file_1) : null;
            $row->upload_file_2_url = $row->upload_file_2 ? asset('storage/' . $row->upload_file_2) : null;
            return $row;
        });

        return response()->json($data);
    }

    public function storeOrganik(Request $request)
    {
        $validated = $request->validate($this->organikRules());
        $validated['metode_pengolahan'] = $request->input('metode_pengolahan', []);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('pisang-danor-organik', 'public');
            }
        }

        $item = PisangOrganik::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan', 'data' => $item]);
    }

    public function updateOrganik(Request $request, int $id)
    {
        $item = PisangOrganik::findOrFail($id);

        $validated = $request->validate($this->organikRules());
        $validated['metode_pengolahan'] = $request->input('metode_pengolahan', []);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($request->hasFile($field)) {
                if ($item->$field) {
                    Storage::disk('public')->delete($item->$field);
                }
                $validated[$field] = $request->file($field)->store('pisang-danor-organik', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $item->update($validated);

        return response()->json(['message' => 'Data berhasil diubah', 'data' => $item]);
    }

    public function destroyOrganik(int $id)
    {
        $item = PisangOrganik::findOrFail($id);

        foreach (['upload_file_1', 'upload_file_2'] as $field) {
            if ($item->$field) {
                Storage::disk('public')->delete($item->$field);
            }
        }

        $item->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
