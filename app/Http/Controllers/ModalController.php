<?php

namespace App\Http\Controllers;

use App\Support\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModalController extends Controller
{
    private const MENU_DASHBOARD = '/dashboard';

    private const URL_AGREGAT = [
        'd_pokja_3_2026' => '/pokja-3/agregat',
        'd_pokja_4_2026' => '/pokja-4/agregat',
    ];

    public function show(Request $request, $id)
    {
        $p = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$p, 404, 'Indikator tidak ditemukan.');

        $kec     = (int) $request->query('kec', 0);
        $kel     = (int) $request->query('kel', 0); // 0 = tingkat kecamatan
        $periode = (int) $request->query('periode', 2026);

        if ($p->alias === 'jumlah_kader' && (($p->bagian ?? '') === 'pokja1' || str_contains((string) $p->tb_dashboard, 'pokja'))) {
            $sql = "SELECT nik,
                           nama,
                           jenis_kelamin AS kelamin,
                           rw,
                           rt,
                           alamat,
                           no_hp,
                           jabatan
                      FROM d_kader_2026
                     WHERE id_kec = :kec
                       AND (:kel = 0 OR id_kel = :kel)
                       AND jenis_kader IN ('pengurus_pokja1', 'pokja1', 'pokja_1')
                       AND periode = :periode
                       AND deleted_at IS NULL
                     ORDER BY CASE jabatan
                       WHEN 'Ketua' THEN 1
                       WHEN 'Wakil Ketua' THEN 2
                       WHEN 'Sekretaris' THEN 3
                       ELSE 4
                     END, nama ASC";
            $jenis = 0;
        } elseif (filled($p->query_detail)) {
            $sql   = $p->query_detail;
            $jenis = (int) $p->jenis_form;

            abort_if($kel && !preg_match('/:kel\b/', $sql), 422, 'Detail tingkat kelurahan belum tersedia');
        } elseif (
            in_array($p->tb_dashboard, ['d_pokja_3_2026', 'd_pokja_4_2026'], true)
            && (bool) $p->is_kader
        ) {
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

        abort_unless(preg_match('/^\s*select/i', $sql), 422, 'Query tidak valid.');

        $nilai = [
            'kec'           => $kec,
            'kel'           => $kel,
            'periode'       => $periode,
            'id_pertanyaan' => (int) $p->id,
        ];

        $bindings = [];
        $counter  = 0;
        $sql = preg_replace_callback(
            "/'[^']*'|(?<!:):([a-z_]\w*)\b/i",
            function (array $m) use ($nilai, &$bindings, &$counter) {
                if (empty($m[1])) {
                    return $m[0];
                }

                $nama = $m[1];
                abort_unless(
                    array_key_exists($nama, $nilai),
                    422,
                    "Parameter :$nama tidak dikenal"
                );

                $unik = $nama . '_' . (++$counter);
                $bindings[$unik] = $nilai[$nama];

                return ':' . $unik;
            },
            $sql
        );

        $stmt = DB::connection()->getPdo()->prepare($sql);
        $stmt->execute($bindings);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $kolom = [];
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $meta = $stmt->getColumnMeta($i);
            if ($meta && isset($meta['name'])) {
                $kolom[] = $meta['name'];
            }
        }

        $tampilan       = (count($kolom) === 1 && $kolom[0] === 'nilai') ? 'angka' : 'tabel';
        $kaderPokja3    = (bool) $p->is_kader && (bool) $p->is_tarik && $p->tb_dashboard === 'd_pokja_3_2026';
        $isPokja4       = $p->tb_dashboard === 'd_pokja_4_2026';
        $isDetailPokja4 = $isPokja4 && !(bool) $p->is_kader && (int) $jenis === 2 && !(bool) $p->is_disable;
        
        $user        = auth()->user();
        $isKelurahan = $user && !empty($user->id_kel);
        $kelSesuai   = $isKelurahan && $kel > 0 && (int) $user->id_kel === $kel;

        $bolehPokja3Create = $kel > 0 && (Access::isSuperUser() || Access::can(self::MENU_DASHBOARD, 'create'));
        $bolehPokja3Update = $kel > 0 && (Access::isSuperUser() || Access::can(self::MENU_DASHBOARD, 'update'));
        $bolehPokja3Delete = $kel > 0 && (Access::isSuperUser() || Access::can(self::MENU_DASHBOARD, 'delete'));

        $bisaInput = isset(self::URL_AGREGAT[$p->tb_dashboard])
            && !(bool) $p->is_kader
            && in_array((int) $p->jenis_form, [1, 2], true)
            && !(bool) $p->is_disable
            && ($isPokja4 ? $kelSesuai : $bolehPokja3Update);

        return response()->json([
            'id'            => $p->id,
            'id_pertanyaan' => (int) $p->id,
            'alias'         => $p->alias,
            'tb_dashboard'  => $p->tb_dashboard,
            'judul'         => strtoupper($p->nama_pertanyaan),
            'jenis_form'    => $jenis,
            'tampilan'      => $tampilan,
            'url_agregat'   => self::URL_AGREGAT[$p->tb_dashboard] ?? '/pokja-3/agregat',
            'bisa_input'    => (bool) $bisaInput,
            'bisa_tambah'   => (bool) ($isPokja4 ? ($isDetailPokja4 && $kelSesuai) : ($kaderPokja3 && $bolehPokja3Create)),
            'bisa_edit'     => (bool) ($isPokja4 ? ($isDetailPokja4 && $kelSesuai) : ($kaderPokja3 && $bolehPokja3Update)),
            'bisa_ubah'     => (bool) ($isPokja4 ? ($isDetailPokja4 && $kelSesuai) : ($kaderPokja3 && $bolehPokja3Delete)),
            'kolom'         => $kolom,
            'rows'          => $rows,
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