<?php

use App\Http\Controllers\Api\MataUangApiController;
use App\Http\Controllers\Api\AkunController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\PeriodeController;

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

    // PUBLIC
    Route::get('/', [PerusahaanController::class, 'index']);
    Route::get('/{id}', [PerusahaanController::class, 'show']);

    // PROTECTED
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PerusahaanController::class, 'store']);
        Route::put('/{id}', [PerusahaanController::class, 'update']);
        Route::delete('/{id}', [PerusahaanController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| PENGGUNA API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pengguna')->group(function () {

    // PUBLIC
    Route::get('/', [PenggunaController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| MATA UANG API ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('mata-uang')->group(function () {

    // PUBLIC
    Route::get('/', [MataUangApiController::class, 'index']);
    Route::get('/{id}', [MataUangApiController::class, 'show']);

    // PROTECTED
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

    // PUBLIC (READ ONLY)
    Route::get('/', [AkunController::class, 'index']);
    Route::get('/{id}', [AkunController::class, 'show']);

    // PROTECTED (LOGIN REQUIRED)
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/', [AkunController::class, 'store']);
        Route::put('/{id}', [AkunController::class, 'update']);
        Route::delete('/{id}', [AkunController::class, 'destroy']);
    });
});

Route::prefix('periode')->name('api.periode.')->group(function () {

    Route::get('/', [PeriodeController::class, 'index'])->name('index');
    Route::post('/', [PeriodeController::class, 'store'])->name('store');
    
    Route::get('/{periode}', [PeriodeController::class, 'show'])->name('show');
    Route::put('/{periode}', [PeriodeController::class, 'update'])->name('update');
    Route::patch('/{periode}', [PeriodeController::class, 'update']); // support partial update
    Route::delete('/{periode}', [PeriodeController::class, 'destroy'])->name('destroy');

    // Additional useful endpoints
    Route::get('/perusahaan/{id_perusahaan}', [PeriodeController::class, 'byPerusahaan']);
    Route::get('/aktif', [PeriodeController::class, 'aktif']);
});