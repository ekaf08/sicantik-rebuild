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
        $isKecamatan = empty($user->id_kel) && !empty($user->id_kec) && (int) $user->id_kec !== 32;
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
        $flagKolom = $request->flag_kolom; // kisah, krisan, kilas, kiat, kisak, pkbn, atau kader
        $tipe      = $request->tipe;       // volume, peserta, atau kader
        $idKec     = $request->kec;
        $idKel     = $request->kel;
        $tahun     = $request->tahun ?? 2026;

        // 1. KADER POKJA 1 (tabel kader_pokja_1_2026)
        // 1. KADER POKJA 1 (tabel kader_pokja_1_2026)
        if ($tipe === 'kader') {
            $q = DB::table('kader_pokja_1_2026 as k')
                ->whereNull('k.deleted_at')
                ->where('k.periode', $tahun)
                ->whereNotNull('k.nik')
                ->whereNotNull('k.jenis_kelamin')
                ->where('k.id_kec', $idKec);

            if (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0) {
                $q->where('k.id_kel', (int) $idKel);
            } elseif ($idKel === 'tp_pkk') {
                $q->whereNull('k.id_kel');
            }

            $rows = $q->select(
                'k.id',
                'k.nik',
                'k.nama',
                'k.jenis_kelamin as kelamin',
                'k.rw',
                'k.rt',
                'k.alamat',
                'k.no_hp',
                'k.jabatan',
                'k.nik as nik_asli',
                'k.no_kk as no_kk_asli'
            )->orderByDesc('k.id')->get();

            $rows->transform(function ($r) {
                $r->nik = $r->nik ? substr($r->nik, 0, 2) . str_repeat('X', max(0, strlen($r->nik) - 2)) : '-';
                return $r;
            });

            $kolom = ['id', 'nik', 'nama', 'kelamin', 'rw', 'rt', 'alamat', 'no_hp', 'jabatan'];
            $judul = 'JUMLAH KADER POKJA I';
        }
        
        // 2. VOLUME (tabel m_lotus untuk semua kegiatan Pokja I)
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
                'rt',
                'tahap'
            )->orderByDesc('id')->get();

            $kolom = ['id', 'nama', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'rt', 'tahap'];
            $judul = strtoupper("{$flagKolom} {$tipe}");
        }
        // 3. PESERTA (tabel peserta_lotus)
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
            $judul = strtoupper("{$flagKolom} {$tipe}");
        }

        $bisaCrud = !$role->is_kota;
        $namaKec  = DB::table('m_kecamatan')->where('id_kec', $idKec)->value('nama_kec') ?? '-';
        $namaKel  = (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0)
            ? (DB::table('m_kelurahan')->where('id_kel', $idKel)->value('nama_kel') ?? '-')
            : ((int) $idKec === 32 ? 'TP PKK KOTA' : 'TP PKK KECAMATAN');

        return response()->json([
            'judul'       => $judul,
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

        if ($tipe === 'kader') {
            $request->validate([
                'nik'           => 'required|string|max:20',
                'nama'          => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'jabatan'       => 'nullable|string|max:100',
                'no_hp'         => 'nullable|string|max:30',
            ]);

            DB::table('kader_pokja_1_2026')->insert([
                'id_kec'        => $idKec,
                'id_kel'        => $idKel,
                'periode'       => $tahun,
                'nik'           => $request->input('nik'),
                'nama'          => $request->input('nama'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'no_kk'         => $request->input('no_kk'),
                'rw'            => $request->input('rw'),
                'rt'            => $request->input('rt'),
                'alamat'        => $request->input('alamat'),
                'no_hp'         => $request->input('no_hp'),
                'jabatan'       => $request->input('jabatan'),
                'nama_role'     => $request->input('jabatan'),
                'created_by'    => Auth::id(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } elseif ($tipe === 'volume') {
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
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $role = $this->getUserRole();
        abort_if($role->is_kota, 403, 'Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan.');

        $tipe = $request->input('tipe');

        if ($tipe === 'kader') {
            $request->validate([
                'nik'           => 'required|string|max:20',
                'nama'          => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
            ]);

            DB::table('kader_pokja_1_2026')->where('id', $id)->update([
                'nik'           => $request->input('nik'),
                'no_kk'         => $request->input('no_kk'),
                'nama'          => $request->input('nama'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'jabatan'       => $request->input('jabatan'),
                'nama_role'     => $request->input('jabatan'),
                'no_hp'         => $request->input('no_hp'),
                'alamat'        => $request->input('alamat'),
                'rw'            => $request->input('rw'),
                'rt'            => $request->input('rt'),
                'updated_by'    => Auth::id(),
                'updated_at'    => now(),
            ]);
        } elseif ($tipe === 'volume') {
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

        $tipe  = $request->input('tipe');
        $tabel = match ($tipe) {
            'kader'  => 'kader_pokja_1_2026',
            'volume' => 'm_lotus',
            default  => 'peserta_lotus',
        };

        $updateData = ['deleted_at' => now()];
        if ($tipe === 'kader') {
            $updateData['deleted_by'] = Auth::id();
        }

        DB::table($tabel)->where('id', $id)->update($updateData);

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}