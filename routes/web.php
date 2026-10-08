<?php

use App\Http\Controllers\Bo\AuthController;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Bo\PermissionController;
use App\Http\Controllers\Bo\MenuController;
use App\Http\Controllers\Bo\RoleController;
use App\Http\Controllers\Bo\LaporanKegiatanController;
use App\Http\Controllers\Bo\LaporanTahunanController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Hanya untuk yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/refresh_captcha', [AuthController::class, 'refresh_captcha'])->name('refresh_captcha');
});

// Hanya untuk yang SUDAH login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-pkk', fn () => view('bo.pages.dasboard-pkk.index'))->name('dashboard.pkk');

    Route::get('/inovasi/global', [InovasiController::class, 'global'])->name('inovasi.global');
    Route::get('/inovasi/kota', [InovasiController::class, 'kota'])->name('inovasi.kota');

    // Master User
    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('master/user', UserController::class)->except(['create', 'edit']);
    Route::post('master/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::get('master/user/{id}/detail', [UserController::class, 'viewDetail'])->name('user.detail');
    Route::get('/get-kecamatan/{id_kec}', [UserController::class, 'getkecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{id_kec}', [UserController::class, 'getKelurahan'])->name('get.kelurahan');

    // Master Permission
    Route::get('master/permission/data', [PermissionController::class, 'getPermissions'])->name('permission.data');
    Route::post('master/permission/access', [PermissionController::class, 'updateAccess'])->name('permission.access');
    Route::resource('master/permission', PermissionController::class)->except(['create', 'edit']);

    // Master Menu

    Route::get('laporan/kegiatan', [RoleController::class, 'laporanKegiatan'])->name('laporan.kegiatan');
    Route::get('laporan/tahunan', [RoleController::class, 'laporanTahunan'])->name('laporan.tahunan');

    Route::get('master/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('master/menu/data', [MenuController::class, 'data'])->name('menu.data');
    Route::post('master/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('master/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');

    Route::put('master/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('master/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    Route::put('master/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update'); 
    Route::delete('master/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');


    Route::delete('master/menu/delete', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Master Menu
        Route::get('master/menu', [MenuController::class, 'index'])->name('menu.index');
        Route::get('master/menu/data', [MenuController::class, 'data'])->name('menu.data');
        Route::post('master/menu', [MenuController::class, 'store'])->name('menu.store');
        Route::get('master/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('master/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('master/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
 
    // Master Role
    Route::get('master/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('master/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('master/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('master/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('master/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('master/role/destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    // Laporan
    Route::get('laporan/kegiatan', [RoleController::class, 'laporanKegiatan'])->name('laporan.kegiatan');
    Route::get('laporan/tahunan', [RoleController::class, 'laporanTahunan'])->name('laporan.tahunan');

    Route::get('laporan-kegiatan', [LaporanKegiatanController::class, 'index'])->name('laporan-kegiatan.index');
    Route::post('laporan-kegiatan', [LaporanKegiatanController::class, 'store'])->name('laporan-kegiatan.store');
    Route::get('laporan-kegiatan/wilayah/kecamatan', [LaporanKegiatanController::class, 'kecamatan'])->name('laporan-kegiatan.kecamatan');
    Route::get('laporan-kegiatan/wilayah/kelurahan/{kec}', [LaporanKegiatanController::class, 'kelurahan'])->name('laporan-kegiatan.kelurahan');
    Route::get('laporan-kegiatan/export', [LaporanKegiatanController::class, 'export'])->name('laporan-kegiatan.export');
    Route::get('laporan-kegiatan/sub/{kegiatan}', [LaporanKegiatanController::class, 'subKegiatan'])->name('laporan-kegiatan.sub');
    Route::get('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'show'])->name('laporan-kegiatan.show');
    Route::put('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'update'])->name('laporan-kegiatan.update');
    Route::delete('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'destroy'])->name('laporan-kegiatan.destroy');

    Route::get('laporan-tahunan', [LaporanTahunanController::class, 'index'])->name('laporan-tahunan.index');

    // CATCH-ALL: harus paling bawah
    Route::get('/{slug}', [MenuController::class, 'handleDynamicPage'])->name('menu.dynamic');
});