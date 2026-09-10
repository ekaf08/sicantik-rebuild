<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;

class InovasiController extends Controller
{
    public function global()
    {
    return view('bo.pages.inovasi.inovasiglobal.index');
    
    }

    public function kota()
    {
        return view('bo.pages.inovasi.inovasikota.index');
    }
}