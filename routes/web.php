<?php

use App\Http\Controllers\Bo\AuthController;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Bo\MpasiController;
use App\Http\Controllers\Bo\PermissionController;
use App\Http\Controllers\Bo\MenuController;
use App\Http\Controllers\Bo\RoleController;
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
//Route::get('/mpasi', [MpasiController::class, 'mpasi'])->name('mpasi.mp_asi');

Route::group([], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Master User
    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('master/user', UserController::class)->except(['create', 'edit']);
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user', [UserController::class, 'destroy'])->name('user.destroy');

    // Master Permission
    Route::get('master/permission/data', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('master/permission', PermissionController::class)->except(['create', 'edit']);

    // Master Menu
    Route::get('master/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('master/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('master/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('master/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Master Role
    Route::get('master/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/master/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('master/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::put('master/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('master/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Menu slug (Harus ditaruh paling bawah di dalam group agar tidak mengganggu route spesifik)
    Route::get('/{slug}', [MenuController::class, 'handleDynamicPage'])->name('menu.dynamic');
});

// Closure route
Route::get('/dashboard-pkk', function () {
    return view('bo.pages.dasboard-pkk.index');
})->middleware(['auth'])->name('dashboard.pkk');
