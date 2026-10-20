<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function show( string $id)
    {
        $p = DB::table('m_pertanyaan_dashboard_2026')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        abort_if(!$p, 404);

        // hanya boleh SELECT
        abort_unless(preg_match('/^\s*select/i', $p->query_detail), 422);

        return response()->json([
            'judul'      => strtoupper($p->nama_pertanyaan),
            'jenis_form' => (int) $p->jenis_form,
            'rows'       => DB::select($p->query_detail),
        ]);
    }
}
