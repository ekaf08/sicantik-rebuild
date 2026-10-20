<?php

use App\Http\Controllers\Bo\AuthController;
use App\Http\Middleware\CheckMenuPermission;
use App\Http\Controllers\Bo\DashboardController;
use App\Http\Controllers\Bo\InovasiController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Bo\PermissionController;
use App\Http\Controllers\Bo\MenuController;
use App\Http\Controllers\Bo\RoleController;
use App\Http\Controllers\Bo\MpasiController;
use App\Http\Controllers\Bo\LaporanKegiatanController;
use App\Http\Controllers\Bo\LaporanTahunanController;
use App\Http\Controllers\Bo\PenghargaanController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\MakanKetanController;
use App\Http\Controllers\PisangDanorController;
use App\Http\Controllers\PmtController;
use App\Http\Controllers\Bo\InovasiSothController;
use App\Http\Controllers\Bo\KebijakanController;
use App\Http\Controllers\DataUmumController;
use App\Http\Controllers\Bo\DaftarKetuaPkkController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Hanya untuk yang BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/refresh_captcha', [AuthController::class, 'refresh_captcha'])->name('refresh_captcha');
});

// Hanya untuk yang SUDAH login
Route::middleware(['auth', CheckMenuPermission::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/modal/{id}', [ModalController::class, 'show']);
    Route::get('/data-umum', [DataUmumController::class, 'index']);

    // Mpasi
    Route::get('/mpasi', [MpasiController::class, 'index'])->name('mpasi.index');
    Route::post('/mpasi', [MpasiController::class, 'store'])->name('mpasi.store');
    Route::get('/mpasi/{id}', [MpasiController::class, 'show'])->name('mpasi.show')->whereUuid('id');
    Route::put('/mpasi/{id}', [MpasiController::class, 'update'])->name('mpasi.update')->whereUuid('id');
    Route::delete('/mpasi/{id}', [MpasiController::class, 'destroy'])->name('mpasi.destroy')->whereUuid('id');

    // Inovasi
    Route::get('/inovasi/global', [InovasiController::class, 'global'])->name('inovasi.global');
    Route::match(['get', 'post'], '/inovasi/kota', [InovasiController::class, 'kota'])->name('inovasi.kota');

    //soth
    Route::get('/inovasi-soth/data', [InovasiSothController::class, 'getData'])->name('soth.data');
    Route::get('/inovasi-soth/chart', [InovasiSothController::class, 'getChartData'])->name('soth.chart');
    Route::post('/inovasi-soth/store', [InovasiSothController::class, 'store'])->name('soth.store');
    Route::get('/inovasi-soth/show/{id}', [InovasiSothController::class, 'show'])->name('soth.show');
    Route::post('/inovasi-soth/update/{id}', [InovasiSothController::class, 'update'])->name('soth.update');
    Route::delete('/inovasi-soth/destroy/{id}', [InovasiSothController::class, 'destroy'])->name('soth.destroy');

    Route::get('/inovasi/global/get-data', [InovasiController::class, 'getData'])->name('inovasi.global.getData');
    Route::post('/inovasi/global/store', [InovasiController::class, 'storeOrUpdateGlobal'])->name('inovasi.global.store');
    Route::delete('/inovasi/global/destroy', [InovasiController::class, 'destroyGlobal'])->name('inovasi.global.destroy');

    //Kebijakan SK
    Route::get('/kebijakan', [KebijakanController::class, 'index'])->name('kebijakan.index');
    Route::get('/kebijakan/data', [KebijakanController::class, 'getData'])->name('kebijakan.data');
    Route::post('/kebijakan/store', [KebijakanController::class, 'store'])->name('kebijakan.store');
    Route::get('/kebijakan/show/{id}', [KebijakanController::class, 'show'])->name('kebijakan.show');
    Route::post('/kebijakan/update/{id}', [KebijakanController::class, 'update'])->name('kebijakan.update');
    Route::delete('/kebijakan/destroy/{id}', [KebijakanController::class, 'destroy'])->name('kebijakan.destroy');

    // Master User
    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::get('master/user/data', [UserController::class, 'data'])->name('users.data');
    Route::get('master/user', [UserController::class, 'index'])->name('user.index');
    Route::get('master/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('master/user', [UserController::class, 'store'])->name('user.store');
    Route::get('master/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('master/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('master/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('master/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('master/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    Route::get('master/user/{id}/detail', [UserController::class, 'viewDetail'])->name('user.detail');
    Route::resource('master/permission', PermissionController::class)->only(['index']);
    Route::get('master/user/{id}/detail', [UserController::class, 'viewDetail'])->name('user.detail');
    Route::get('/get-kecamatan/{id_kec}', [UserController::class, 'getkecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{id_kec}', [UserController::class, 'getKelurahan'])->name('get.kelurahan');

    // Master Permission
    Route::get('master/permission/data', [PermissionController::class, 'getPermissions'])->name('permission.data');
    Route::post('master/permission/access', [PermissionController::class, 'updateAccess'])->name('permission.access');

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
    Route::get('laporan/tahunan', [LaporanTahunanController::class, 'index'])->name('laporan.tahunan');

    Route::get('laporan-kegiatan', [LaporanKegiatanController::class, 'index'])->name('laporan-kegiatan.index');
    Route::post('laporan-kegiatan', [LaporanKegiatanController::class, 'store'])->name('laporan-kegiatan.store');
    Route::get('laporan-kegiatan/wilayah/kecamatan', [LaporanKegiatanController::class, 'kecamatan'])->name('laporan-kegiatan.kecamatan');
    Route::get('laporan-kegiatan/wilayah/kelurahan/{kec}', [LaporanKegiatanController::class, 'kelurahan'])->name('laporan-kegiatan.kelurahan');
    Route::get('laporan-kegiatan/export', [LaporanKegiatanController::class, 'export'])->name('laporan-kegiatan.export');
    Route::get('laporan-kegiatan/statistik', [LaporanKegiatanController::class, 'statistik'])->name('laporan-kegiatan.statistik');
    Route::get('laporan-kegiatan/sub/{kegiatan}', [LaporanKegiatanController::class, 'subKegiatan'])->name('laporan-kegiatan.sub');
    Route::get('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'show'])->name('laporan-kegiatan.show');
    Route::put('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'update'])->name('laporan-kegiatan.update');
    Route::delete('laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'destroy'])->name('laporan-kegiatan.destroy');

    Route::get('/laporan-tahunan', [LaporanTahunanController::class, 'index'])->name('laporan-tahunan.index');
    Route::post('/laporan-tahunan', [LaporanTahunanController::class, 'store'])->name('laporan-tahunan.store');
    Route::put('/laporan-tahunan/{id}', [LaporanTahunanController::class, 'update'])->name('laporan-tahunan.update');
    Route::delete('/laporan-tahunan/{id}', [LaporanTahunanController::class, 'destroy'])->name('laporan-tahunan.destroy');

    // Penghargaan
    Route::get('/penghargaan', [PenghargaanController::class, 'index'])->name('penghargaan.index');
    Route::get('/get-kelurahan/{kecamatan_id}', [PenghargaanController::class, 'getKelurahan'])->name('penghargaan.kelurahan');
    Route::post('/penghargaan/store', [PenghargaanController::class, 'store'])->name('penghargaan.store');
    Route::put('/penghargaan/update/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
    Route::delete('/penghargaan/delete/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');

    // Makan Ketan
    Route::get('/makan-ketan/wilayah', [MakanKetanController::class, 'wilayah']);
    Route::get('/makan-ketan', [MakanKetanController::class, 'index']);
    Route::post('/makan-ketan', [MakanKetanController::class, 'store']);
    Route::post('/makan-ketan/{id}', [MakanKetanController::class, 'update']);

    // Pisang Danor
    Route::get('/pisang-danor/wilayah', [PisangDanorController::class, 'wilayah']);

    Route::get('/pisang-danor/bsi', [PisangDanorController::class, 'indexBsi']);
    Route::post('/pisang-danor/bsi', [PisangDanorController::class, 'storeBsi']);
    Route::post('/pisang-danor/bsi/{id}', [PisangDanorController::class, 'updateBsi']);
    Route::delete('/pisang-danor/bsi/{id}', [PisangDanorController::class, 'destroyBsi']);

    Route::get('/pisang-danor/organik', [PisangDanorController::class, 'indexOrganik']);
    Route::post('/pisang-danor/organik', [PisangDanorController::class, 'storeOrganik']);
    Route::post('/pisang-danor/organik/{id}', [PisangDanorController::class, 'updateOrganik']);
    Route::delete('/pisang-danor/organik/{id}', [PisangDanorController::class, 'destroyOrganik']);


    // PMT
     Route::get('/pmt-data/wilayah', [PmtController::class, 'wilayah']);
     Route::get('/pmt-data', [PmtController::class, 'index']);
     Route::post('/pmt-data', [PmtController::class, 'store']);
     Route::post('/pmt-data/{id}', [PmtController::class, 'update']);
     Route::delete('/pmt-data/{id}', [PmtController::class, 'destroy']);

     //Daftar-Ketua-PKK 
    Route::get('/daftar-ketua-pkk', [DaftarKetuaPkkController::class, 'index'])->name('ketua-pkk.index');
    Route::post('/daftar-ketua-pkk/upload', [DaftarKetuaPkkController::class, 'upload'])->name('ketua-pkk.upload');
    Route::delete('/daftar-ketua-pkk/destroy/{id}', [DaftarKetuaPkkController::class, 'destroy'])->name('ketua-pkk.destroy');

    // CATCH-ALL: harus paling bawah
    Route::get('/{slug}', [MenuController::class, 'handleDynamicPage']) ->where('slug', '.*')->name('menu.dynamic');
});
