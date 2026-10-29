<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModalController extends Controller
{
    public function show(Request $request, $id)
    {
        $p = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $id)->whereNull('deleted_at')->first();

        abort_if(!$p, 404);

        // Kalau query_detail diisi di master, pakai itu (detail khusus).
        // Kalau kosong, bentuk query bawaan dari tb_dashboard + alias.
        if (filled($p->query_detail)) {
            $sql   = $p->query_detail;
            $jenis = (int) $p->jenis_form;
        } else {
            [$sql, $jenis] = $this->queryBawaan($p);
        }

        abort_unless(preg_match('/^\s*select/i', $sql), 422);

        $bindings = [];
        if (str_contains($sql, ':kec')) {
            $bindings['kec'] = (int) $request->query('kec');
        }
        if (str_contains($sql, ':periode')) {
            $bindings['periode'] = (int) $request->query('periode', 2026);
        }

        $stmt = DB::connection()->getPdo()->prepare($sql);
        $stmt->execute($bindings);

        $kolom = [];
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $kolom[] = $stmt->getColumnMeta($i)['name'];
        }

        return response()->json([
            'judul'      => strtoupper($p->nama_pertanyaan),
            'jenis_form' => $jenis,
            'kolom'      => $kolom,
            'rows'       => $stmt->fetchAll(\PDO::FETCH_ASSOC),
        ]);
    }

    /**
     * Query bawaan: rincian per kelurahan kalau tabelnya punya id_kel,
     * kalau tidak, satu angka tingkat kecamatan.
     * Nama tabel/kolom divalidasi lewat Schema::hasColumn sebelum dipakai.
     */
    private function queryBawaan($p): array
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

        if (Schema::hasColumn($tabel, 'id_kel')) {
            return [
                "SELECT k.nama_kel AS kelurahan, d.$c AS jumlah
                   FROM $t d
                   JOIN m_kelurahan k ON k.id_kel = d.id_kel
                  WHERE d.id_kec = :kec AND d.id_kel IS NOT NULL AND d.periode = :periode
                  ORDER BY k.nama_kel",
                0,
            ];
        }

        return [
            "SELECT $c AS nilai FROM $t WHERE id_kec = :kec AND periode = :periode",
            1,
        ];
    }
}