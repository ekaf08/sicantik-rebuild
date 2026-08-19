<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('bo.pages.dashboard');
    }
}