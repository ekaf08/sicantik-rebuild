<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function show(Request $request, $id)
    {
        $p = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $id)->whereNull('deleted_at')->first();

        abort_if(!$p, 404);
        abort_unless(preg_match('/^\s*select/i', $p->query_detail), 422);

        $bindings = [];
        if (str_contains($p->query_detail, ':kec')) {
            $bindings['kec'] = (int) $request->query('kec');
        }

        $stmt = DB::connection()->getPdo()->prepare($p->query_detail);
        $stmt->execute($bindings);

        $kolom = [];
        for ($i = 0; $i < $stmt->columnCount(); $i++) {
            $kolom[] = $stmt->getColumnMeta($i)['name'];
        }

        return response()->json([
            'judul'      => strtoupper($p->nama_pertanyaan),
            'jenis_form' => (int) $p->jenis_form,
            'kolom'      => $kolom,
            'rows'       => $stmt->fetchAll(\PDO::FETCH_ASSOC),
        ]);
    }
}
