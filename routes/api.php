<?php

use App\Http\Controllers\Api\AkunController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\MataUangApiController;
use App\Http\Controllers\Api\FakturPembelianApiController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembayaranHutangController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| AUTH USER ROUTE (SANCTUM)
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
| PERUSAHAAN API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('perusahaan')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        PerusahaanController::class,
        'index'
    ]);

    Route::get('/{id}', [
        PerusahaanController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            PerusahaanController::class,
            'store'
        ]);

        Route::put('/{id}', [
            PerusahaanController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            PerusahaanController::class,
            'destroy'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| PELANGGAN API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pelanggan')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        PelangganController::class,
        'index'
    ]);

    Route::get('/{pelanggan}', [
        PelangganController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            PelangganController::class,
            'store'
        ]);

        Route::put('/{pelanggan}', [
            PelangganController::class,
            'update'
        ]);

        Route::patch('/{pelanggan}', [
            PelangganController::class,
            'update'
        ]);

        Route::delete('/{pelanggan}', [
            PelangganController::class,
            'destroy'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| PENGGUNA API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pengguna')->group(function () {

    Route::get('/', [
        PenggunaController::class,
        'index'
    ]);
});

/*
|--------------------------------------------------------------------------
| MATA UANG API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('mata-uang')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        MataUangApiController::class,
        'index'
    ]);

    Route::get('/{id}', [
        MataUangApiController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            MataUangApiController::class,
            'store'
        ]);

        Route::put('/{id}', [
            MataUangApiController::class,
            'update'
        ]);

        Route::patch('/{id}', [
            MataUangApiController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            MataUangApiController::class,
            'destroy'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| AKUN API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('akun')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        AkunController::class,
        'index'
    ]);

    Route::get('/{id}', [
        AkunController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            AkunController::class,
            'store'
        ]);

        Route::put('/{id}', [
            AkunController::class,
            'update'
        ]);

        Route::patch('/{id}', [
            AkunController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            AkunController::class,
            'destroy'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| PERIODE API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('periode')
    ->name('api.periode.')
    ->group(function () {

        Route::get('/', [
            PeriodeController::class,
            'index'
        ])->name('index');

        Route::post('/', [
            PeriodeController::class,
            'store'
        ])->name('store');

        Route::get('/aktif', [
            PeriodeController::class,
            'aktif'
        ]);

        Route::get('/perusahaan/{id_perusahaan}', [
            PeriodeController::class,
            'byPerusahaan'
        ]);

        Route::get('/{periode}', [
            PeriodeController::class,
            'show'
        ])->name('show');

        Route::put('/{periode}', [
            PeriodeController::class,
            'update'
        ])->name('update');

        Route::patch('/{periode}', [
            PeriodeController::class,
            'update'
        ]);

        Route::delete('/{periode}', [
            PeriodeController::class,
            'destroy'
        ])->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| SUPPLIER API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('supplier')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        SupplierController::class,
        'index'
    ]);

    Route::get('/{supplier}', [
        SupplierController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            SupplierController::class,
            'store'
        ]);

        Route::put('/{supplier}', [
            SupplierController::class,
            'update'
        ]);

        Route::patch('/{supplier}', [
            SupplierController::class,
            'update'
        ]);

        Route::delete('/{supplier}', [
            SupplierController::class,
            'destroy'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| FAKTUR PEMBELIAN API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('faktur-pembelian')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        FakturPembelianApiController::class,
        'index'
    ]);

    Route::get('/{id}', [
        FakturPembelianApiController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            FakturPembelianApiController::class,
            'store'
        ]);

        Route::put('/{id}', [
            FakturPembelianApiController::class,
            'update'
        ]);

        Route::patch('/{id}', [
            FakturPembelianApiController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            FakturPembelianApiController::class,
            'destroy'
        ]);
    });
    /*
|--------------------------------------------------------------------------
| PEMBAYARAN HUTANG API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pembayaran-hutang')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    Route::get('/', [
        PembayaranHutangControllee::class,
        'index'
    ]);

    Route::get('/{id}', [
        PembayaranHutangController::class,
        'show'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [
            PembayaranHutangController::class,
            'store'
        ]);

        Route::put('/{id}', [
            PembayaranHutangController::class,
            'update'
        ]);

        Route::patch('/{id}', [
            PembayaranHutangController::class,
            'update'
        ]);

        Route::delete('/{id}', [
            PembayaranHutangController::class,
            'destroy'
        ]);
    });
});
});
