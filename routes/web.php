<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MataUangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\JurnalDetailController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\FakturPenjualanController;

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

        /*
        |----------------------------
        | MASTER DATA
        |----------------------------
        */
        Route::resource('perusahaan', PerusahaanController::class);
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('mata-uang', MataUangController::class);
        Route::resource('akun', AkunController::class);
        Route::resource('periode', PeriodeController::class);
        Route::resource('jurnal', JurnalController::class);

        // Resource biasa (opsional)
        Route::resource('jurnal-detail', JurnalDetailController::class);

        Route::resource('pelanggan', PelangganController::class);
        Route::resource('faktur-penjualan', FakturPenjualanController::class);

        // ==================== JURNAL DETAIL ROUTES (NESTED) ====================
        Route::prefix('jurnal/{jurnal}/detail')
            ->name('jurnal.detail.')
            ->group(function () {

                Route::get('/', [JurnalDetailController::class, 'index'])
                    ->name('index');

                Route::get('/create', [JurnalDetailController::class, 'create'])
                    ->name('create');

                Route::post('/', [JurnalDetailController::class, 'store'])
                    ->name('store');

                Route::get('/{detail}/edit', [JurnalDetailController::class, 'edit'])
                    ->name('edit');

                Route::put('/{detail}', [JurnalDetailController::class, 'update'])
                    ->name('update');

                Route::delete('/{detail}', [JurnalDetailController::class, 'destroy'])
                    ->name('destroy');

                Route::post('/bulk', [JurnalDetailController::class, 'bulkUpdate'])
                    ->name('bulk');
            });

        // Tambahan route khusus Jurnal
        Route::post('jurnal/{jurnal}/post', [JurnalController::class, 'post'])
            ->name('jurnal.post');

        Route::post('jurnal/{jurnal}/unpost', [JurnalController::class, 'unpost'])
            ->name('jurnal.unpost');

        Route::post('jurnal/{jurnal}/approve', [JurnalController::class, 'approve'])
            ->name('jurnal.approve');

        Route::post('jurnal/{jurnal}/reject', [JurnalController::class, 'reject'])
            ->name('jurnal.reject');

        // Tambahan route khusus Faktur Penjualan
        Route::patch('faktur-penjualan/{fakturPenjualan}/status',
            [FakturPenjualanController::class, 'updateStatus'])
            ->name('faktur-penjualan.update-status');

        /*
        |----------------------------
        | AJAX / SUPPORT DATA
        |----------------------------
        */
        Route::get('/perusahaan/by-kota/{kota}', [PerusahaanController::class, 'byKota'])
            ->name('perusahaan.by-kota');

        Route::get('/akun/by-tipe/{tipe}', [AkunController::class, 'byTipe'])
            ->name('akun.by-tipe');

        /*
        |----------------------------
        | LAPORAN AKUNTANSI
        |----------------------------
        */
        Route::get('/laporan/neraca', [LaporanController::class, 'neraca'])
            ->name('laporan.neraca');

        Route::get('/laporan/laba-rugi', [LaporanController::class, 'labaRugi'])
            ->name('laporan.laba-rugi');
    });

    // Role lain (tetap sama)
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

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});
