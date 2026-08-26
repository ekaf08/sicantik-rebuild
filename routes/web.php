<?php

use App\Http\Controllers\Bo\AuthController;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\UserController;
use Illuminate\Support\Facades\Route;


// Guest routes — hanya bisa diakses kalau BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/refresh_captcha', [AuthController::class, 'refresh_captcha'])->name('refresh_captcha');
});

// Protected routes — hanya bisa diakses kalau SUDAH login
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('master/user', UserController::class)->except(['create', 'edit']);

    // taruh route-route lain yang butuh login di sini
});
