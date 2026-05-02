<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerusahaanController;

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)
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
| AUTH (SUDAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard Utama (Redirect otomatis berdasarkan role)
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
        Route::get('/perusahaan/by-kota/{kota}', [PerusahaanController::class, 'byCity'])
            ->name('perusahaan.by-kota');
    });

    /*
    |--------------------------------------------------------------------------
    | AKUNTAN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:akuntan')->prefix('akuntan')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('akuntan.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | MANAJER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:manajer')->prefix('manajer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('manajer.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | AUDITOR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:auditor')->prefix('auditor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('auditor.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | STAFF
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('staff.dashboard');
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});