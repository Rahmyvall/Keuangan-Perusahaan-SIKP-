<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\Api\PenggunaController;

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

    // PROTECTED (LOGIN REQUIRED)
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