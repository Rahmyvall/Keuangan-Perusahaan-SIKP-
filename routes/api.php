<?php

use App\Http\Controllers\Api\MataUangApiController;
use App\Http\Controllers\Api\AkunController;
use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\Api\PelangganController;     // ← Tambahkan ini
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\Api\JurnalDetailController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| USER AUTH ROUTE (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'User authenticated',
        'data' => $request->user()
    ]);
});

/*
|--------------------------------------------------------------------------
| PERUSAHAAN API ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('perusahaan')->group(function () {
    Route::get('/', [PerusahaanController::class, 'index']);
    Route::get('/{id}', [PerusahaanController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PerusahaanController::class, 'store']);
        Route::put('/{id}', [PerusahaanController::class, 'update']);
        Route::delete('/{id}', [PerusahaanController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PELANGGAN API ROUTES (BARU)
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')->group(function () {

    // PUBLIC - Read Only
    Route::get('/', [PelangganController::class, 'index']);
    Route::get('/{pelanggan}', [PelangganController::class, 'show']);

    // PROTECTED - Membutuhkan Login (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PelangganController::class, 'store']);
        Route::put('/{pelanggan}', [PelangganController::class, 'update']);
        Route::delete('/{pelanggan}', [PelangganController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PENGGUNA API ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('pengguna')->group(function () {
    Route::get('/', [PenggunaController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| MATA UANG API ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('mata-uang')->group(function () {
    Route::get('/', [MataUangApiController::class, 'index']);
    Route::get('/{id}', [MataUangApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [MataUangApiController::class, 'store']);
        Route::put('/{id}', [MataUangApiController::class, 'update']);
        Route::delete('/{id}', [MataUangApiController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| AKUN API ROUTES (COA)
|--------------------------------------------------------------------------
*/
Route::prefix('akun')->group(function () {
    Route::get('/', [AkunController::class, 'index']);
    Route::get('/{id}', [AkunController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AkunController::class, 'store']);
        Route::put('/{id}', [AkunController::class, 'update']);
        Route::delete('/{id}', [AkunController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PERIODE API ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('periode')->name('api.periode.')->group(function () {
    Route::get('/', [PeriodeController::class, 'index'])->name('index');
    Route::post('/', [PeriodeController::class, 'store'])->name('store');

    Route::get('/{periode}', [PeriodeController::class, 'show'])->name('show');
    Route::put('/{periode}', [PeriodeController::class, 'update'])->name('update');
    Route::patch('/{periode}', [PeriodeController::class, 'update']);
    Route::delete('/{periode}', [PeriodeController::class, 'destroy'])->name('destroy');

    Route::get('/perusahaan/{id_perusahaan}', [PeriodeController::class, 'byPerusahaan']);
    Route::get('/aktif', [PeriodeController::class, 'aktif']);
});

Route::prefix('supplier')->group(function () {

    // PUBLIC - Read Only
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/{supplier}', [SupplierController::class, 'show']);

    // PROTECTED - Membutuhkan Login (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [SupplierController::class, 'store']);
        Route::put('/{supplier}', [SupplierController::class, 'update']);
        Route::delete('/{supplier}', [SupplierController::class, 'destroy']);

    });
});
