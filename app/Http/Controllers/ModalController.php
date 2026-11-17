<?php

namespace App\Http\Controllers;

use App\Support\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModalController extends Controller
{
    // Menu yang izinnya dipakai untuk aksi Pokja 3 (harus sama dengan PATH_ALIAS di CheckMenuPermission)
    private const MENU_POKJA3 = '/data-umum';

    public function show(Request $request, $id)
    {
        $p = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $id)->whereNull('deleted_at')->first();

        abort_if(!$p, 404);

        $kel = (int) $request->query('kel'); 

        if (filled($p->query_detail)) {
            $sql   = $p->query_detail;
            $jenis = (int) $p->jenis_form;

            abort_if($kel && !preg_match('/:kel\b/', $sql), 422, 'Detail tingkat kelurahan belum tersedia');
        } elseif ($p->is_kader && $p->tb_dashboard === 'd_pokja_3_2026') {
            $alias = str_replace("'", "''", $p->alias);
            $sql   = "SELECT id, nik, no_kk, nama, jenis_kelamin, jabatan, no_hp, rw, rt, alamat
                        FROM d_kader_2026
                    WHERE id_kec = :kec
                        AND (:kel = 0 OR id_kel = :kel)
                        AND jenis_kader = '$alias'
                        AND periode = :periode
                        AND deleted_at IS NULL
                    ORDER BY CASE jabatan
                        WHEN 'Ketua' THEN 1
                        WHEN 'Wakil Ketua' THEN 2
                        WHEN 'Sekretaris' THEN 3
                        ELSE 4
                    END, nama ASC";
            $jenis = (int) $p->jenis_form;
        } else {
            [$sql, $jenis] = $this->queryBawaan($p, $kel);
        }

        abort_unless(preg_match('/^\s*select/i', $sql), 422);

        $nilai = [
            'kec'     => (int) $request->query('kec'),
            'kel'     => $kel,
            'periode' => (int) $request->query('periode', 2026),
        ];

        preg_match_all('/(?<!:):([a-z_]\w*)/i', $sql, $m);

        $bindings = [];
        foreach (array_unique($m[1]) as $nama) {
            abort_unless(
                array_key_exists($nama, $nilai),
                422,
                "Parameter :$nama tidak dikenal"
            );
            $bindings[$nama] = $nilai[$nama];
        }

        $stmt = DB::connection()->getPdo()->prepare($sql);
        $stmt->execute($bindings);

        $kolom = [];
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $kolom[] = $stmt->getColumnMeta($i)['name'];
        }

        $kaderPokja3 = $p->is_kader && $p->is_tarik && $p->tb_dashboard === 'd_pokja_3_2026';

        $bolehTambah = Access::isSuperUser() || Access::can(self::MENU_POKJA3, 'create');
        $bolehUbah   = Access::isSuperUser() || Access::can(self::MENU_POKJA3, 'update');
        $bolehHapus  = Access::isSuperUser() || Access::can(self::MENU_POKJA3, 'delete');

        $bisaInput = $p->tb_dashboard === 'd_pokja_3_2026'
            && !$p->is_kader
            && in_array((int) $p->jenis_form, [1, 2], true)
            && !$p->is_disable
            && $kel > 0
            && $bolehUbah;

        return response()->json([
            'id'          => $p->id,
            'bisa_ubah'   => (bool) ($kaderPokja3 && $bolehHapus),  // tombol hapus kader
            'bisa_input'  => (bool) $bisaInput,
            'bisa_tambah' => (bool) ($kaderPokja3 && $kel && $bolehTambah), // hanya tingkat kelurahan
            'judul'      => strtoupper($p->nama_pertanyaan),
            'jenis_form' => $jenis,
            'kolom'      => $kolom,
            'rows'       => $stmt->fetchAll(\PDO::FETCH_ASSOC),
        ]);
    }

    private function queryBawaan($p, int $kel): array
    {
        $tabel = $p->tb_dashboard;
        $kolom = $p->alias;

        abort_unless(
            $tabel && $kolom && Schema::hasColumn($tabel, $kolom),
            422,
            'Detail belum tersedia'
        );

        $t = '"' . str_replace('"', '""', $tabel) . '"';
        $c = '"' . str_replace('"', '""', $kolom) . '"';

        if (!Schema::hasColumn($tabel, 'id_kel')) {
            abort_if($kel, 422, 'Detail tingkat kelurahan belum tersedia');

            return [
                "SELECT $c AS nilai FROM $t WHERE id_kec = :kec AND periode = :periode",
                1,
            ];
        }

        if ($kel) {
            return [
                "SELECT d.$c AS nilai FROM $t d
                  WHERE d.id_kec = :kec AND d.id_kel = :kel AND d.periode = :periode",
                1,
            ];
        }

        // jenis_form = 1 di master: modal agregat (satu angka = jumlah seluruh kelurahan)
        if ((int) $p->jenis_form === 1) {
            return [
                "SELECT SUM(d.$c) AS nilai FROM $t d
                  WHERE d.id_kec = :kec AND d.id_kel IS NOT NULL AND d.periode = :periode",
                1,
            ];
        }

        return [
            "SELECT k.nama_kel AS kelurahan, d.$c AS jumlah
               FROM $t d
               JOIN m_kelurahan k ON k.id_kel = d.id_kel
              WHERE d.id_kec = :kec AND d.id_kel IS NOT NULL AND d.periode = :periode
              ORDER BY k.nama_kel",
            0,
        ];
    }
}