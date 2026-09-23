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
// Route::get('/mpasi', [MpasiController::class, 'mpasi'])->name('mpasi.mp_asi');

Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inovasi
    Route::get('/inovasi/global', [InovasiController::class, 'global'])->name('inovasi.global');
    Route::get('/inovasi/kota', [InovasiController::class, 'kota'])->name('inovasi.kota');

    // Master User
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
    // Master Role
    Route::get('master/role', [RoleController::class, 'index'])->name('role.index');
    Route::post('master/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::put('master/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('master/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

});

Route::get('/master/role/create', [RoleController::class, 'create'])->name('role.create');
Route::post('/master/role', [RoleController::class, 'store'])->name('role.store');

