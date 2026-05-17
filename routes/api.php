<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AkunController;
use App\Http\Controllers\Api\MataUangApiController;
use App\Http\Controllers\Api\FakturPembelianApiController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembayaranHutangController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\Api\AsetTetapController;
use App\Http\Controllers\Api\PeriodeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\DepresiasiApiController;

/*
|--------------------------------------------------------------------------
| AUTH USER ROUTE
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return response()->json([
        'success' => true,
        'message' => 'User authenticated',
        'data'    => $request->user()
    ]);
});

/*
|--------------------------------------------------------------------------
| PERUSAHAAN API
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
| PELANGGAN API
|--------------------------------------------------------------------------
*/

Route::prefix('pelanggan')->group(function () {

    Route::get('/', [PelangganController::class, 'index']);
    Route::get('/{pelanggan}', [PelangganController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [PelangganController::class, 'store']);
        Route::put('/{pelanggan}', [PelangganController::class, 'update']);
        Route::patch('/{pelanggan}', [PelangganController::class, 'update']);
        Route::delete('/{pelanggan}', [PelangganController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PENGGUNA API
|--------------------------------------------------------------------------
*/

Route::prefix('pengguna')->group(function () {

    Route::get('/', [PenggunaController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| MATA UANG API
|--------------------------------------------------------------------------
*/

Route::prefix('mata-uang')->group(function () {

    Route::get('/', [MataUangApiController::class, 'index']);
    Route::get('/{id}', [MataUangApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [MataUangApiController::class, 'store']);
        Route::put('/{id}', [MataUangApiController::class, 'update']);
        Route::patch('/{id}', [MataUangApiController::class, 'update']);
        Route::delete('/{id}', [MataUangApiController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| AKUN API
|--------------------------------------------------------------------------
*/

Route::prefix('akun')->group(function () {

    Route::get('/', [AkunController::class, 'index']);
    Route::get('/{id}', [AkunController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [AkunController::class, 'store']);
        Route::put('/{id}', [AkunController::class, 'update']);
        Route::patch('/{id}', [AkunController::class, 'update']);
        Route::delete('/{id}', [AkunController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PERIODE API
|--------------------------------------------------------------------------
*/

Route::prefix('periode')->group(function () {

    Route::get('/', [PeriodeController::class, 'index']);
    Route::post('/', [PeriodeController::class, 'store']);

    Route::get('/aktif', [PeriodeController::class, 'aktif']);
    Route::get('/perusahaan/{id_perusahaan}', [PeriodeController::class, 'byPerusahaan']);
    Route::get('/{periode}', [PeriodeController::class, 'show']);

    Route::put('/{periode}', [PeriodeController::class, 'update']);
    Route::patch('/{periode}', [PeriodeController::class, 'update']);

    Route::delete('/{periode}', [PeriodeController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| SUPPLIER API
|--------------------------------------------------------------------------
*/

Route::prefix('supplier')->group(function () {

    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/{supplier}', [SupplierController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [SupplierController::class, 'store']);
        Route::put('/{supplier}', [SupplierController::class, 'update']);
        Route::patch('/{supplier}', [SupplierController::class, 'update']);
        Route::delete('/{supplier}', [SupplierController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| FAKTUR PEMBELIAN API
|--------------------------------------------------------------------------
*/

Route::prefix('faktur-pembelian')->group(function () {

    Route::get('/', [FakturPembelianApiController::class, 'index']);
    Route::get('/{id}', [FakturPembelianApiController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [FakturPembelianApiController::class, 'store']);
        Route::put('/{id}', [FakturPembelianApiController::class, 'update']);
        Route::patch('/{id}', [FakturPembelianApiController::class, 'update']);
        Route::delete('/{id}', [FakturPembelianApiController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PEMBAYARAN HUTANG API
|--------------------------------------------------------------------------
*/

Route::prefix('pembayaran-hutang')->group(function () {

    Route::get('/', [PembayaranHutangController::class, 'index']);
    Route::get('/{id}', [PembayaranHutangController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [PembayaranHutangController::class, 'store']);
        Route::put('/{id}', [PembayaranHutangController::class, 'update']);
        Route::patch('/{id}', [PembayaranHutangController::class, 'update']);
        Route::delete('/{id}', [PembayaranHutangController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| ASET TETAP API
|--------------------------------------------------------------------------
*/

Route::prefix('aset-tetap')->group(function () {

    Route::get('/', [AsetTetapController::class, 'index']);
    Route::get('/{asetTetap}', [AsetTetapController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [AsetTetapController::class, 'store']);
        Route::put('/{asetTetap}', [AsetTetapController::class, 'update']);
        Route::patch('/{asetTetap}', [AsetTetapController::class, 'update']);
        Route::delete('/{asetTetap}', [AsetTetapController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| DEPRESIASI API
|--------------------------------------------------------------------------
*/

Route::prefix('depresiasi')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROUTE
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DepresiasiApiController::class, 'index']);
    Route::get('/{id}', [DepresiasiApiController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | AUTH ROUTE
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [DepresiasiApiController::class, 'store']);

        Route::post('/generate', [
            DepresiasiApiController::class,
            'generate'
        ]);

        Route::put('/{id}', [
            DepresiasiApiController::class,
            'update'
        ]);

        Route::patch('/{id}', [
            DepresiasiApiController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            DepresiasiApiController::class,
            'destroy'
        ]);
    });
});
