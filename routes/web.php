<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

   Route::get('/inovasi/global', [InovasiController::class, 'global'])->name('inovasi.global');
       Route::get('/inovasi/kota', [InovasiController::class, 'kota'])->name('inovasi.kota');
