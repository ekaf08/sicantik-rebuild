<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanKegiatanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dari model atau sumber data lainnya
            $data = []; // Ganti dengan data yang sesuai

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('bo.pages.laporan.laporan-kegiatan.index');
    }
}