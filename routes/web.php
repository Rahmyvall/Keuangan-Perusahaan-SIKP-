<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataUangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('perusahaan', PerusahaanController::class);
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('mata-uang', MataUangController::class);

        Route::get('/perusahaan/by-kota/{kota}', [PerusahaanController::class, 'byCity'])
            ->name('perusahaan.by-kota');

      
    });

    /*
    |--------------------------------------------------------------------------
    | ROLE LAIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:akuntan')->prefix('akuntan')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('akuntan.dashboard');
    });

    Route::middleware('role:manajer')->prefix('manajer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('manajer.dashboard');
    });

    Route::middleware('role:auditor')->prefix('auditor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('auditor.dashboard');
    });

    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('staff.dashboard');
    });

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});