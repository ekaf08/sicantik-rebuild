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

        // 1. VOLUME (tabel m_lotus untuk semua kegiatan Pokja I)
        if ($tipe === 'volume') {
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
                'rt',
                'tahap'
            )->orderByDesc('id')->get();

            $kolom = ['id', 'nama', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'rt', 'tahap'];
        }
        // 2. PESERTA (tabel peserta_lotus)
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
                'rt',
                'nik as nik_asli',
                'no_kk as no_kk_asli',
                'nik_pendamping',
                'hubungan_keluarga',
                'tahap'
            )->orderByDesc('id')->get();

            $rows->transform(function ($r) {
                $r->nik   = $r->nik ? substr($r->nik, 0, 2) . str_repeat('X', max(0, strlen($r->nik) - 2)) : '-';
                $r->no_kk = $r->no_kk ? substr($r->no_kk, 0, 2) . str_repeat('X', max(0, strlen($r->no_kk) - 2)) : '-';
                return $r;
            });

            $kolom = ['id', 'nik', 'no_kk', 'nama', 'pendamping', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'rt'];
        }

        $bisaCrud = !$role->is_kota;
        $namaKec  = DB::table('m_kecamatan')->where('id_kec', $idKec)->value('nama_kec') ?? '-';
        $namaKel  = (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0)
            ? (DB::table('m_kelurahan')->where('id_kel', $idKel)->value('nama_kel') ?? '-')
            : 'TP PKK KECAMATAN';

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
                'nama_kec'      => $namaKec,
                'nama_kel'      => $namaKel,
                'flag_kolom'    => $flagKolom,
                'tipe'          => $tipe,
                'pertanyaan_id' => $request->pertanyaan_id,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $role = $this->getUserRole();
        abort_if($role->is_kota, 403, 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan.');

        $flagKolom    = $request->input('flag_kolom');
        $tipe         = $request->input('tipe');
        $idKec        = (int) $request->input('id_kec');
        $rawKel       = $request->input('id_kel');
        $idKel        = ($rawKel === 'tp_pkk' || empty($rawKel) || (int) $rawKel <= 0) ? null : (int) $rawKel;
        $pertanyaanId = $request->input('pertanyaan_id') ?: null;
        $tahun        = (int) ($request->input('tahun') ?? 2026);

        $namaKec = DB::table('m_kecamatan')->where('id_kec', $idKec)->value('nama_kec');
        $namaKel = $idKel ? DB::table('m_kelurahan')->where('id_kel', $idKel)->value('nama_kel') : null;

        if ($tipe === 'volume') {
            $request->validate([
                'nama'   => 'required|string|max:255',
                'alamat' => 'nullable|string|max:255',
                'rw'     => 'nullable|string|max:10',
                'rt'     => 'nullable|string|max:10',
                'tahap'  => 'nullable|string|max:50',
            ]);

            DB::table('m_lotus')->insert([
                'pertanyaan_id' => $pertanyaanId,
                'name'          => $request->input('nama'),
                'nama_kec'      => $namaKec,
                'nama_kel'      => $namaKel,
                'tahap'         => $request->input('tahap'),
                'id_kec'        => $idKec,
                'id_kel'        => $idKel,
                'rw'            => $request->input('rw'),
                'rt'            => $request->input('rt'),
                'alamat'        => $request->input('alamat'),
                'flag_kolom'    => $flagKolom,
                'tahun'         => $tahun,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } else {
            $request->validate([
                'nik'  => 'required|string|max:20',
                'nama' => 'required|string|max:255',
            ]);

            DB::table('peserta_lotus')->insert([
                'pertanyaan_id'     => $pertanyaanId,
                'nik'               => $request->input('nik'),
                'no_kk'             => $request->input('no_kk'),
                'nama'              => $request->input('nama'),
                'nik_pendamping'    => $request->input('nik_pendamping'),
                'nama_pendamping'   => $request->input('pendamping'),
                'pendamping'        => $request->input('pendamping'),
                'hubungan_keluarga' => $request->input('hubungan_keluarga'),
                'alamat'            => $request->input('alamat'),
                'id_kec'            => $idKec,
                'id_kel'            => $idKel,
                'nama_kec'          => $namaKec,
                'nama_kel'          => $namaKel,
                'rw'                => $request->input('rw'),
                'rt'                => $request->input('rt'),
                'tahap'             => $request->input('tahap'),
                'flag_kolom'        => $flagKolom,
                'tahun'             => $tahun,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $role = $this->getUserRole();
        abort_if($role->is_kota, 403, 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan.');

        $tipe = $request->input('tipe');

        if ($tipe === 'volume') {
            $request->validate([
                'nama' => 'required|string|max:255',
            ]);

            DB::table('m_lotus')->where('id', $id)->update([
                'name'       => $request->input('nama'),
                'alamat'     => $request->input('alamat'),
                'rw'         => $request->input('rw'),
                'rt'         => $request->input('rt'),
                'tahap'      => $request->input('tahap'),
                'updated_at' => now(),
            ]);
        } else {
            $request->validate([
                'nik'  => 'required|string|max:20',
                'nama' => 'required|string|max:255',
            ]);

            DB::table('peserta_lotus')->where('id', $id)->update([
                'nik'               => $request->input('nik'),
                'no_kk'             => $request->input('no_kk'),
                'nama'              => $request->input('nama'),
                'nik_pendamping'    => $request->input('nik_pendamping'),
                'nama_pendamping'   => $request->input('pendamping'),
                'pendamping'        => $request->input('pendamping'),
                'hubungan_keluarga' => $request->input('hubungan_keluarga'),
                'alamat'            => $request->input('alamat'),
                'rw'                => $request->input('rw'),
                'rt'                => $request->input('rt'),
                'tahap'             => $request->input('tahap'),
                'updated_at'        => now(),
            ]);
        }

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy(Request $request, $id)
    {
        $role = $this->getUserRole();
        abort_if($role->is_kota, 403, 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan.');

        $tabel = $request->input('tipe') === 'volume' ? 'm_lotus' : 'peserta_lotus';

        DB::table($tabel)->where('id', $id)->update([
            'deleted_at' => now(),
        ]);

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}