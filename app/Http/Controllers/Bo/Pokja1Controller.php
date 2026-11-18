<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pokja1Controller extends Controller
{
    private function getUserRole()
    {
        $user = Auth::user();
        $isKelurahan = !empty($user->id_kel);
        $isKecamatan = empty($user->id_kel) && !empty($user->id_kec) && $user->id_kec != 32;
        $isKota      = !$isKelurahan && !$isKecamatan;

        return (object) [
            'user'    => $user,
            'is_kota' => $isKota,
            'is_kec'  => $isKecamatan,
            'is_kel'  => $isKelurahan,
        ];
    }

    public function detail(Request $request)
    {
        $role      = $this->getUserRole();
        $flagKolom = $request->flag_kolom; // kisah, krisan, kilas, kiat, kisak, pkbn
        $tipe      = $request->tipe;       // volume, peserta
        $idKec     = $request->kec;
        $idKel     = $request->kel;
        $tahun     = $request->tahun ?? 2026;

        // 1. KISAK VOLUME (tabel kisak_pokja1)
        if ($flagKolom === 'kisak' && $tipe === 'volume') {
            $q = DB::table('kisak_pokja1')
                ->whereNull('deleted_at')
                ->where('id_kec', $idKec);

            if (!empty($idKel) && (int) $idKel > 0) {
                $q->where('id_kel', $idKel);
            } elseif ($idKel === 'tp_pkk') {
                $q->whereNull('id_kel');
            }

            $rows = $q->select(
                'id',
                'tgl_kegiatan as tanggal',
                'tempat',
                'materi',
                'nama_kec as kecamatan',
                'nama_kel as kelurahan'
            )->orderByDesc('id')->get();

            $kolom = ['id', 'tanggal', 'tempat', 'materi', 'kecamatan', 'kelurahan'];
        }
        // 2. VOLUME LOTUS (tabel m_lotus)
        elseif ($tipe === 'volume') {
            $q = DB::table('m_lotus')
                ->whereNull('deleted_at')
                ->where('tahun', $tahun)
                ->where('flag_kolom', $flagKolom)
                ->where('id_kec', $idKec);

            if (!empty($idKel) && (int) $idKel > 0) {
                $q->where('id_kel', $idKel);
            } elseif ($idKel === 'tp_pkk') {
                $q->whereNull('id_kel');
            }

            $rows = $q->select(
                'id',
                'name as nama',
                'alamat',
                'nama_kec as kecamatan',
                'nama_kel as kelurahan',
                'rw',
                'tahap'
            )->orderByDesc('id')->get();

            $kolom = ['id', 'nama', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'tahap'];
        }
        // 3. PESERTA LOTUS (tabel peserta_lotus)
        else {
            $q = DB::table('peserta_lotus')
                ->whereNull('deleted_at')
                ->where('tahun', $tahun)
                ->where('flag_kolom', $flagKolom)
                ->where('id_kec', $idKec);

            if (!empty($idKel) && (int) $idKel > 0) {
                $q->where('id_kel', $idKel);
            } elseif ($idKel === 'tp_pkk') {
                $q->whereNull('id_kel');
            }

            $rows = $q->select(
                'id',
                'nik',
                'no_kk',
                'nama',
                'nama_pendamping as pendamping',
                'alamat',
                'nama_kec as kecamatan',
                'nama_kel as kelurahan',
                'rw',
                'rt'
            )->orderByDesc('id')->get();

            $rows->transform(function ($r) {
                $r->nik   = $r->nik ? substr($r->nik, 0, 2) . str_repeat('X', max(0, strlen($r->nik) - 2)) : '-';
                $r->no_kk = $r->no_kk ? substr($r->no_kk, 0, 2) . str_repeat('X', max(0, strlen($r->no_kk) - 2)) : '-';
                return $r;
            });

            $kolom = ['id', 'nik', 'no_kk', 'nama', 'pendamping', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'rt'];
        }

        // Hak akses: Kota hanya lihat (bisa_tambah = false), Kecamatan/Kelurahan boleh CRUD
        $bisaCrud = !$role->is_kota;

        return response()->json([
            'judul'       => strtoupper("{$flagKolom} {$tipe}"),
            'tampilan'    => 'tabel',
            'kolom'       => $kolom,
            'rows'        => $rows,
            'bisa_tambah' => $bisaCrud,
            'bisa_edit'   => $bisaCrud,
            'bisa_ubah'   => $bisaCrud,
            'is_kota'     => $role->is_kota,
            'pokja1_meta' => [
                'flag_kolom'    => $flagKolom,
                'tipe'          => $tipe,
                'pertanyaan_id' => $request->pertanyaan_id,
            ],
        ]);
    }
}