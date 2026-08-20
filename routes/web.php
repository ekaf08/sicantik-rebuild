<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bo\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
