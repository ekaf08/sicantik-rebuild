<?php

use App\Http\Controllers\Bo\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bo\DashboardController;


// Guest routes — hanya bisa diakses kalau BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/captcha/refresh', function () {
        return response()->json(['captcha' => captcha_src('flat')])
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    })->name('captcha.refresh');
});

// Protected routes — hanya bisa diakses kalau SUDAH login
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // taruh route-route lain yang butuh login di sini
});
