<?php

namespace App\Http\Controllers;

use App\Models\Bumil;
use App\Support\IdCipher;
use Illuminate\Support\Facades\DB;

class BumilController extends Controller
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

    // Data ibu hamil dan ibu nifas (hanya untuk ditampilkan)
    public function index()
    {
        $data = Bumil::orderByDesc('created_at')->get()->map(function ($row) {
            // Ubah ke array dulu: model otomatis mengubah 'id' jadi angka, sehingga token akan terbaca 0
            $item = $row->toArray();
            $item['id'] = IdCipher::encode($row->id);
            return $item;
        });

        return response()->json($data);
    }

    // Riwayat satu ibu (untuk popup Lihat): riwayat kehamilan + riwayat calon pengantin
    public function riwayat(string $id)
    {
        $id = IdCipher::decodeOrFail($id);
        $bumil = Bumil::findOrFail($id);

        $sembunyi = ['id', 'bumil_id', 'created_at', 'updated_at', 'deleted_at'];

        return response()->json([
            'kehamilan'       => $bumil->kehamilan()->orderBy('tanggal')->get()->makeHidden($sembunyi)->values(),
            'calon_pengantin' => $bumil->calonPengantin()->orderBy('tanggal')->get()->makeHidden($sembunyi)->values(),
        ]);
    }
}
