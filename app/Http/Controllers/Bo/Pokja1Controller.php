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

        $namaKec = DB::table('m_kecamatan')->where('id_kec', $idKec)->value('nama_kec') ?? '-';
        $namaKel = (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0)
            ? (DB::table('m_kelurahan')->where('id_kel', $idKel)->value('nama_kel') ?? '-')
            : ((int) $idKec === 32 ? 'TP PKK KOTA' : 'TP PKK KECAMATAN');

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

        // 2A. VOLUME KISAK (tabel kisak_pokja1)
        elseif ($flagKolom === 'kisak' && $tipe === 'volume') {
            $q = DB::table('kisak_pokja1')
                ->whereNull('deleted_at')
                ->whereYear('tgl_kegiatan', $tahun)
                ->where('id_kec', $idKec);

            if (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0) {
                $q->where('id_kel', (int) $idKel);
            } elseif ($idKel === 'tp_pkk') {
                $q->whereNull('id_kel');
            }

            $rows = $q->select(
                'id',
                'tgl_kegiatan as tanggal',
                'tempat as tempat_pelaksanaan',
                'materi as judul_materi',
                'tgl_kegiatan as tanggal_asli'
            )->orderByDesc('tgl_kegiatan')->get();

            $kolom = ['id', 'tanggal', 'tempat_pelaksanaan', 'judul_materi'];
            $judul = 'DATA KISAK';
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
                'tahap'
            )->orderByDesc('id')->get();

            $kolom = ['id', 'nama', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'tahap'];
            $judul = strtoupper("{$flagKolom} {$tipe}");
        }
        // 3A. JUMLAH KISAK (tabel tarikan ibu_hamil_resiko - read only)
        // 3A. JUMLAH KISAK (tabel tarikan ibu_hamil_resiko - read only)
        elseif ($flagKolom === 'kisak' && $tipe === 'peserta') {
            $q = DB::table('ibu_hamil_resiko')
                ->whereRaw('UPPER(TRIM(kecamatan)) = ?', [strtoupper(trim($namaKec))]);

            if (!empty($idKel) && is_numeric($idKel) && (int) $idKel > 0) {
                $q->whereRaw('UPPER(TRIM(kelurahan)) = ?', [strtoupper(trim($namaKel))]);
            } elseif ($idKel === 'tp_pkk') {
                $q->where(function ($sub) {
                    $sub->whereNull('kelurahan')->orWhereRaw("TRIM(kelurahan) = ''");
                });
            }

            $rows = $q->select(
                DB::raw('0 as id'),
                'nik',
                'namalengkap as nama',
                'tgl_lahir as tanggal_lahir',
                'resiko',
                'tanggalperkiraan as tanggal_perkiraan',
                'alamat',
                'kelurahan',
                'kecamatan'
            )->orderBy('namalengkap')->get();

            $rows->transform(function ($r) {
                $r->nik = $r->nik ? substr($r->nik, 0, 2) . str_repeat('X', max(0, strlen($r->nik) - 2)) : '-';
                return $r;
            });

            $kolom = ['id', 'nik', 'nama', 'tanggal_lahir', 'resiko', 'tanggal_perkiraan', 'alamat', 'kelurahan', 'kecamatan'];
            $judul = 'DETAIL BUMIL RESTI';
        }
        // 3B. PESERTA (tabel peserta_lotus)
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
                'no_kk',
                'nik',
                'nama',
                'nik_pendamping',
                'nama_pendamping',
                'pendamping',
                'alamat',
                'nama_kec as kecamatan',
                'nama_kel as kelurahan',
                'rw',
                'rt',
                'tahun',
                'tahap',
                'nik as nik_asli',
                'no_kk as no_kk_asli',
                'nik_pendamping as nik_pendamping_asli',
                'hubungan_keluarga'
            )->orderByDesc('id')->get();

            $rows->transform(function ($r) {
                $r->nik            = $r->nik ? substr($r->nik, 0, 2) . str_repeat('X', max(0, strlen($r->nik) - 2)) : '-';
                $r->no_kk          = $r->no_kk ? substr($r->no_kk, 0, 2) . str_repeat('X', max(0, strlen($r->no_kk) - 2)) : '-';
                $r->nik_pendamping = $r->nik_pendamping ? substr($r->nik_pendamping, 0, 2) . str_repeat('X', max(0, strlen($r->nik_pendamping) - 2)) : '-';
                return $r;
            });

            $kolom = ['id', 'no_kk', 'nik', 'nama', 'nik_pendamping', 'nama_pendamping', 'pendamping', 'alamat', 'kecamatan', 'kelurahan', 'rw', 'rt', 'tahun', 'tahap'];
            $judul = strtoupper("{$flagKolom} {$tipe}");
        }

        $isTarikan = ($flagKolom === 'kisak' && $tipe === 'peserta');
        $bisaCrud  = !$role->is_kota && !$isTarikan;

        return response()->json([
            'judul'       => $judul,
            'tampilan'    => 'tabel',
            'kolom'       => $kolom,
            'rows'        => $rows,
            'bisa_tambah' => $bisaCrud,
            'bisa_edit'   => $bisaCrud,
            'bisa_ubah'   => $bisaCrud,
            'is_tarikan'  => $isTarikan,
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

        }   elseif ($flagKolom === 'kisak' && $tipe === 'volume') {
            $request->validate([
                'tanggal'            => 'required|date',
                'tempat_pelaksanaan' => 'required|string|max:255',
                'judul_materi'       => 'required|string',
            ]);

            DB::table('kisak_pokja1')->insert([
                'pertanyaan_id' => $pertanyaanId,
                'tgl_kegiatan'  => $request->input('tanggal'),
                'tempat'        => $request->input('tempat_pelaksanaan'),
                'materi'        => $request->input('judul_materi'),
                'id_kec'        => $idKec,
                'id_kel'        => $idKel,
                'nama_kec'      => $namaKec,
                'nama_kel'      => $namaKel,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }   elseif ($tipe === 'volume') {
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
                'pendamping'        => $request->input('hubungan_keluarga'),
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
        } elseif ($request->input('flag_kolom') === 'kisak' && $tipe === 'volume') {
            $request->validate([
                'tanggal'            => 'required|date',
                'tempat_pelaksanaan' => 'required|string|max:255',
                'judul_materi'       => 'required|string',
            ]);

            DB::table('kisak_pokja1')->where('id', $id)->update([
                'tgl_kegiatan' => $request->input('tanggal'),
                'tempat'       => $request->input('tempat_pelaksanaan'),
                'materi'       => $request->input('judul_materi'),
                'updated_at'   => now(),
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
                'pendamping'        => $request->input('hubungan_keluarga'),
                'hubungan_keluarga' => $request->input('hubungan_keluarga'),
                'alamat'            => $request->input('alamat'),
                'rw'                => $request->input('rw'),
                'rt'                => $request->input('rt'),
                'tahun'             => (int) ($request->input('tahun') ?? 2026),
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

        $tipe      = $request->input('tipe');
        $flagKolom = $request->input('flag_kolom');

        $tabel = match (true) {
            $tipe === 'kader'                              => 'kader_pokja_1_2026',
            $flagKolom === 'kisak' && $tipe === 'volume'   => 'kisak_pokja1',
            $tipe === 'volume'                             => 'm_lotus',
            default                                        => 'peserta_lotus',
        };

        $updateData = ['deleted_at' => now()];
        if ($tipe === 'kader') {
            $updateData['deleted_by'] = Auth::id();
        }

        DB::table($tabel)->where('id', $id)->update($updateData);

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}