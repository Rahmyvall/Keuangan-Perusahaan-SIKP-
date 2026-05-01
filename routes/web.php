<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT (AUTO ROLE)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        $role = auth()->role;

        return match ($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'akuntan' => redirect()->route('akuntan.dashboard'),
            'manajer' => redirect()->route('manajer.dashboard'),
            'auditor' => redirect()->route('auditor.dashboard'),
            'staff'   => redirect()->route('staff.dashboard'),
            default   => abort(403),
        };
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', fn() => view('dashboard.admin'))
            ->name('admin.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | AKUNTAN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:akuntan')->group(function () {
        Route::get('/akuntan/dashboard', fn() => view('dashboard.akuntan'))
            ->name('akuntan.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | MANAJER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:manajer')->group(function () {
        Route::get('/manajer/dashboard', fn() => view('dashboard.manajer'))
            ->name('manajer.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | AUDITOR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:auditor')->group(function () {
        Route::get('/auditor/dashboard', fn() => view('dashboard.auditor'))
            ->name('auditor.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | STAFF
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', fn() => view('dashboard.staff'))
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
