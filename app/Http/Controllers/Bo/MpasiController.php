<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MpasiController extends Controller
{
    // Tambahkan method ini
    public function mpasi()
    {
        return view('bo.pages.mpasi.mp_asi'); 
    }
}