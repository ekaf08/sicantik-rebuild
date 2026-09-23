<?php

use App\Http\Controllers\Bo\AuthController;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Bo\MpasiController;
use App\Http\Controllers\Bo\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


// Guest routes — hanya bisa diakses kalau BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/refresh_captcha', [AuthController::class, 'refresh_captcha'])->name('refresh_captcha');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

   Route::get('/inovasi/global', [InovasiController::class, 'global'])->name('inovasi.global');
       Route::get('/inovasi/kota', [InovasiController::class, 'kota'])->name('inovasi.kota');
// Protected routes — hanya bisa diakses kalau SUDAH login
// s
 Route::get('/mpasi', [MpasiController::class, 'mpasi'])->name('mpasi.mp_asi');

Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('master/user', UserController::class)->except(['create', 'edit']);
    Route::post('/user', [UserController::class, 'store'])->name('user.store');

    Route::get('master/permission/data', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('master/permission', PermissionController::class)->except(['create', 'edit']);

});

// Closure route
Route::get('/dashboard-pkk', function () {
    return view('bo.pages.dasboard-pkk.index');
})->middleware(['auth'])->name('dashboard.pkk');