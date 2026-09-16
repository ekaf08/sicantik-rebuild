<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;

class InovasiController extends Controller
{
    public function global()
    {
        // Siapkan variabel $data (nanti jika sudah ada Model DB, ganti jadi: InovasiModel::all();)
        $data = [];

        return view('bo.pages.inovasi.inovasiglobal.index', compact('data'));
    }

    public function kota()
    {
        return view('bo.pages.inovasi.inovasikota.index');
    }
}