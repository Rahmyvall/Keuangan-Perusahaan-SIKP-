<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PerusahaanController;

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

    // GET semua data (public)
    Route::get('/', [PerusahaanController::class, 'index']);

    // GET detail (public)
    Route::get('/{id}', [PerusahaanController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES (butuh login Sanctum)
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        // create perusahaan
        Route::post('/', [PerusahaanController::class, 'store']);

        // update perusahaan
        Route::put('/{id}', [PerusahaanController::class, 'update']);

        // delete perusahaan
        Route::delete('/{id}', [PerusahaanController::class, 'destroy']);
    });
});
