<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pokja2Controller extends Controller
{
    public static function getRekapData(int $periode = 2026, ?int $idKec = null): array
    {
        $kolomPokja2 = DB::table('m_pertanyaan_dashboard_2026')
            ->where('tb_dashboard', 'd_pokja_2_2026')
            ->whereNull('deleted_at')
            ->orderBy('urutan')
            ->get();

        // Tentukan kunci pengelompokan: id_kel jika mode kelurahan, id_kec jika mode kecamatan
        $keyWilayah = $idKec ? 'id_kel' : 'id_kec';
        $dataPokja2 = collect();

        $wilayahList = $idKec
            ? DB::table('m_kelurahan')
                ->join('m_kecamatan', 'm_kecamatan.kode_bpjs', '=', 'm_kelurahan.kode_kec_bpjs')
                ->where('m_kecamatan.id_kec', $idKec)
                ->pluck('m_kelurahan.id_kel')
            : DB::table('m_kecamatan')
                ->whereNull('deleted_at')
                ->pluck('id_kec');

        foreach ($wilayahList as $idWil) {
            $obj = (object) [$keyWilayah => $idWil];
            foreach ($kolomPokja2 as $k) {
                $obj->{$k->alias} = 0;
            }
            $dataPokja2[$idWil] = $obj;
        }

        // Helper untuk mengisi nilai ke $dataPokja2
        $isiNilai = function ($rows, string $alias) use (&$dataPokja2, $keyWilayah) {
            foreach ($rows as $idWil => $total) {
                if (!$dataPokja2->has($idWil)) {
                    $dataPokja2[$idWil] = (object) [$keyWilayah => $idWil];
                }
                $dataPokja2[$idWil]->$alias = $total;
            }
        };

        // 1. Kelompok Belajar & Warga Belajar (Paket A, B, C dari tabel tarikan baru)
        $tabelBelajar = [
            'paket_a_klp'   => 'm_detail_kelompok_belajar_a',
            'paket_b_klp'   => 'm_detail_kelompok_belajar_b',
            'paket_c_klp'   => 'm_detail_kelompok_belajar_c',
            'paket_a_warga' => 'm_detail_warga_belajar_a',
            'paket_b_warga' => 'm_detail_warga_belajar_b',
            'paket_c_warga' => 'm_detail_warga_belajar_c',
        ];

        foreach ($tabelBelajar as $alias => $namaTabel) {
            $q = DB::table($namaTabel)->whereNotNull($keyWilayah);
            if ($idKec) {
                $q->where('id_kec', $idKec);
            }
            $rows = $q->selectRaw("$keyWilayah, COUNT(*) AS total")
                ->groupBy($keyWilayah)
                ->pluck('total', $keyWilayah);

            $isiNilai($rows, $alias);
        }

        // 2. Kader & Peserta dari d_kader_2026
        $mapKader = [
            'warga_3_buta'       => 'warga_buta',
            'tpk3_pkk'           => 'tpk3_pkk',
            'damas_pkk'          => 'damas_pkk',
            'pemula_psrt'        => 'up2k_pemula',
            'madya_psrt'         => 'up2k_madya',
            'anggota'            => 'koperasi_anggota',
            'tutor_kf'           => 'tutor_kf',
            'kader_koperasi'     => 'kader_koperasi',
            'kader_keterampilan' => 'kader_keterampilan',
            'kader_bkb'          => 'kader_bkb',
            'lp3_pkk'            => 'lp3_pkk',
        ];

        $qKader = DB::table('d_kader_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereIn('jenis_kader', array_values($mapKader))
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qKader->where('id_kec', $idKec);
        }

        $aliasDariJenis = array_flip($mapKader);
        foreach ($qKader->selectRaw("$keyWilayah, jenis_kader, COUNT(*) AS total")->groupBy($keyWilayah, 'jenis_kader')->get() as $r) {
            $idWil = $r->$keyWilayah;
            if (!$dataPokja2->has($idWil)) {
                $dataPokja2[$idWil] = (object) [$keyWilayah => $idWil];
            }
            $dataPokja2[$idWil]->{$aliasDariJenis[$r->jenis_kader]} = $r->total;
        }

        // 3. BKB Kelompok, APE, dan Simulasi
        $qBkb = DB::table('d_bkb_kelompok_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qBkb->where('id_kec', $idKec);
        }

        foreach ($qBkb->selectRaw("$keyWilayah, COUNT(*) AS kelp, COALESCE(SUM(jumlah_ape),0) AS ape, COUNT(*) FILTER (WHERE is_simulasi) AS simulasi")->groupBy($keyWilayah)->get() as $r) {
            $idWil = $r->$keyWilayah;
            if (!$dataPokja2->has($idWil)) {
                $dataPokja2[$idWil] = (object) [$keyWilayah => $idWil];
            }
            $dataPokja2[$idWil]->bkb_kelp = $r->kelp;
            $dataPokja2[$idWil]->bkb_ape = $r->ape;
            $dataPokja2[$idWil]->bkb_kelp_simulasi = $r->simulasi;
        }

        // 4. BKB Ibu Peserta
        $qIbu = DB::table('d_bkb_ibu_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qIbu->where('id_kec', $idKec);
        }
        $isiNilai($qIbu->selectRaw("$keyWilayah, COUNT(*) AS total")->groupBy($keyWilayah)->pluck('total', $keyWilayah), 'bkb_ibu_peserta');

        // 5. PAUD Sejenis (dari m_detail_paud_perkelurahan)
        $qPaud = DB::table('m_detail_paud_perkelurahan')
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qPaud->where('id_kec', $idKec);
        }
        $isiNilai(
            $qPaud->selectRaw("$keyWilayah, COUNT(*) AS total")
                ->groupBy($keyWilayah)
                ->pluck('total', $keyWilayah),
            'paud_sejenis'
        );

        // Tutor PAUD Sejenis (tetap dari d_paud_2026)
        $qTutorPaud = DB::table('d_paud_2026')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereNotNull('nama_pegawai')
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qTutorPaud->where('id_kec', $idKec);
        }
        $isiNilai(
            $qTutorPaud->selectRaw("$keyWilayah, COUNT(*) AS total")
                ->groupBy($keyWilayah)
                ->pluck('total', $keyWilayah),
            'tutor_paud_sejenis'
        );

        // 6. Taman Bacaan
        $qTb = DB::table('m_detail_taman_bacaan')
            ->where('periode', $periode)
            ->whereNull('deleted_at')
            ->whereNotNull($keyWilayah);
        if ($idKec) {
            $qTb->where('id_kec', $idKec);
        }
        $isiNilai($qTb->selectRaw("$keyWilayah, COUNT(*) AS total")->groupBy($keyWilayah)->pluck('total', $keyWilayah), 'taman_bacaan');

        return [
            'kolomPokja2' => $kolomPokja2,
            'dataPokja2'  => $dataPokja2,
        ];
    }

    private function tabelKf(?string $alias): string
    {
        abort_unless(in_array($alias, ['kf_klp', 'kf_warga'], true), 422, 'Indikator KF tidak valid.');

        return $alias === 'kf_klp'
            ? 'm_kelompok_belajar_pokja2_kf'
            : 'm_warga_belajar_pokja2_kf';
    }

    public function storeKf(Request $request)
    {
        $tabel = $this->tabelKf($request->input('alias'));

        $data = $request->validate([
            'id_pertanyaan'      => 'required|integer',
            'id_kec'             => 'required|integer',
            'id_kel'             => 'required|integer|min:1',
            'nama'               => 'required|string|max:255',
            'alamat'             => 'nullable|string',
            'rt'                 => 'nullable|string|max:10',
            'rw'                 => 'nullable|string|max:10',
            'jenis_keterampilan' => 'nullable|string|max:255',
        ]);

        DB::table($tabel)->insert([
            ...$data,
            'periode'    => 2026,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data KF berhasil ditambahkan',
        ]);
    }

    public function updateKf(Request $request, int $id)
    {
        $tabel = $this->tabelKf($request->input('alias'));

        $data = $request->validate([
            'nama'               => 'required|string|max:255',
            'alamat'             => 'nullable|string',
            'rt'                 => 'nullable|string|max:10',
            'rw'                 => 'nullable|string|max:10',
            'jenis_keterampilan' => 'nullable|string|max:255',
        ]);

        DB::table($tabel)->where('id', $id)->update([
            ...$data,
            'updated_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data KF berhasil diubah',
        ]);
    }

    public function destroyKf(Request $request, int $id)
    {
        $tabel = $this->tabelKf($request->input('alias'));

        DB::table($tabel)->where('id', $id)->update([
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data KF berhasil dihapus',
        ]);
    }

    public function updateAgregat(Request $request)
    {
        $validated = $request->validate([
            'id_pertanyaan' => 'required|integer',
            'id_kec'        => 'required|integer',
            'id_kel'        => 'required|integer|min:1',
            'periode'       => 'nullable|integer',
            'nilai'         => 'required|integer|min:0|max:2147483647',
        ]);

        $periode = (int) ($validated['periode'] ?? 2026);

        $wilayahValid = DB::table('m_kelurahan as kl')
            ->join('m_kecamatan as kc', 'kc.kode_bpjs', '=', 'kl.kode_kec_bpjs')
            ->where('kl.id_kel', $validated['id_kel'])
            ->where('kc.id_kec', $validated['id_kec'])
            ->exists();

        abort_unless($wilayahValid, 422, 'Kelurahan tidak sesuai dengan kecamatan.');

        $pertanyaan = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $validated['id_pertanyaan'])
            ->where('tb_dashboard', 'd_pokja_2_2026')
            ->where('is_kader', false)
            ->where('jenis_form', 1)
            ->where(fn ($q) => $q->whereNull('is_disable')->orWhere('is_disable', false))
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$pertanyaan, 422, 'Indikator Pokja 2 tidak valid.');

        $kolom = $pertanyaan->alias;
        abort_unless(\Illuminate\Support\Facades\Schema::hasColumn('d_pokja_2_2026', $kolom), 422, 'Kolom target tidak ditemukan.');

        $key = [
            'id_kec'  => $validated['id_kec'],
            'id_kel'  => $validated['id_kel'],
            'periode' => $periode,
        ];

        $updated = DB::table('d_pokja_2_2026')
            ->where($key)
            ->update([$kolom => $validated['nilai'], 'updated_at' => now()]);

        if (!$updated) {
            DB::table('d_pokja_2_2026')->insert($key + [
                $kolom       => $validated['nilai'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ]);
    }
}