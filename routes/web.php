<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LoginController,
    DashboardController,
    MataUangController,
    PenggunaController,
    PerusahaanController,
    AkunController,
    AsetTetapController,
    FakturPembelianController,
    JurnalController,
    JurnalDetailController,
    LaporanController,
    PelangganController,
    PeriodeController,
    FakturPenjualanController,
    NotificationController,
    PenerimaanPiutangController,
    SupplierController,
    DepresiasiController,
    PembayaranHutangController,
    RekeningBankController,
    SaldoAwalController
};

/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'))->name('home');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::resources([
            'perusahaan' => PerusahaanController::class,
            'pengguna' => PenggunaController::class,
            'mata-uang' => MataUangController::class,
            'akun' => AkunController::class,
            'periode' => PeriodeController::class,
            'supplier' => SupplierController::class,
            'pelanggan' => PelangganController::class,
            'faktur-pembelian' => FakturPembelianController::class,
            'faktur-penjualan' => FakturPenjualanController::class,
            'jurnal' => JurnalController::class,
            'penerimaan-piutang' => PenerimaanPiutangController::class,
            'aset-tetap' => AsetTetapController::class,
            'depresiasi' => DepresiasiController::class,
            'rekening-bank' => RekeningBankController::class,
            'pembayaran-hutang' => PembayaranHutangController::class,
            'saldo-awal' => SaldoAwalController::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | DEPRESIASI CUSTOM ROUTE
        |--------------------------------------------------------------------------
        */
        Route::prefix('depresiasi')->name('depresiasi.')->group(function () {
            Route::post('/generate', [DepresiasiController::class, 'generate'])
                ->name('generate');
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN EXTRA
        |--------------------------------------------------------------------------
        */
        Route::prefix('admin-extra')->group(function () {

            Route::get('perusahaan/by-kota/{kota}', [PerusahaanController::class, 'byKota'])
                ->name('perusahaan.by-kota');

            Route::get('akun/by-tipe/{tipe}', [AkunController::class, 'byTipe'])
                ->name('akun.by-tipe');

            Route::patch('faktur-pembelian/{fakturPembelian}/update-status',
                [FakturPembelianController::class, 'updateStatus']
            )->name('faktur-pembelian.update-status');

            Route::get('faktur-pembelian/{fakturPembelian}/print',
                [FakturPembelianController::class, 'print']
            )->name('faktur-pembelian.print');

            Route::patch('faktur-penjualan/{fakturPenjualan}/status',
                [FakturPenjualanController::class, 'updateStatus']
            )->name('faktur-penjualan.update-status');

            Route::prefix('jurnal/{jurnal}/detail')
                ->name('jurnal.detail.')
                ->group(function () {

                    Route::get('/', [JurnalDetailController::class, 'index'])->name('index');
                    Route::get('/create', [JurnalDetailController::class, 'create'])->name('create');
                    Route::post('/', [JurnalDetailController::class, 'store'])->name('store');

                    Route::get('/{detail}/edit', [JurnalDetailController::class, 'edit'])->name('edit');
                    Route::put('/{detail}', [JurnalDetailController::class, 'update'])->name('update');
                    Route::delete('/{detail}', [JurnalDetailController::class, 'destroy'])->name('destroy');

                    Route::post('/bulk', [JurnalDetailController::class, 'bulkUpdate'])->name('bulk');
                });

            Route::post('jurnal/{jurnal}/post', [JurnalController::class, 'post'])->name('jurnal.post');
            Route::post('jurnal/{jurnal}/unpost', [JurnalController::class, 'unpost'])->name('jurnal.unpost');
            Route::post('jurnal/{jurnal}/approve', [JurnalController::class, 'approve'])->name('jurnal.approve');
            Route::post('jurnal/{jurnal}/reject', [JurnalController::class, 'reject'])->name('jurnal.reject');

            Route::get('laporan/neraca', [LaporanController::class, 'neraca'])->name('laporan.neraca');
            Route::get('laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');

            Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('notifications.fetch');
            Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | ROLE DASHBOARD
    |--------------------------------------------------------------------------
    */
    foreach (['akuntan', 'manajer', 'auditor', 'staff'] as $role) {
        Route::middleware("role:$role")
            ->prefix($role)
            ->name($role . '.')
            ->group(function () {
                Route::get('/dashboard', [DashboardController::class, 'index'])
                    ->name('dashboard');
            });
    }
});
