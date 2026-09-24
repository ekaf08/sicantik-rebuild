<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bo\AuthController;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Bo\MpasiController;
use App\Http\Controllers\Bo\PermissionController;

Route::get('/', function () {
    return redirect()->route('login');
});


use App\Http\Controllers\Bo\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes — hanya bisa diakses kalau BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/refresh_captcha', [AuthController::class, 'refresh_captcha'])->name('refresh_captcha');
});

// Protected routes — hanya bisa diakses kalau SUDAH login
// s
Route::get('/mpasi', [MpasiController::class, 'mpasi'])->name('mpasi.mp_asi');

Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('master/user', UserController::class)->except(['create', 'edit']);
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('master/permission/data', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('master/permission', PermissionController::class)->except(['create', 'edit']);
    // taruh route-route lain yang butuh login di sini
    Route::get('master/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('master/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('master/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('master/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // menu slug
    Route::get('/{slug}', [App\Http\Controllers\MenuController::class, 'handleDynamicPage'])->name('menu.dynamic');
});
// Closure route
Route::get('/dashboard-pkk', function () {
    return view('bo.pages.dasboard-pkk.index');
})->middleware(['auth'])->name('dashboard.pkk');
