<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/', fn() => redirect()->route('login'));

    Route::get('/login', fn() => view('welcome'))
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
    | DASHBOARD REDIRECT (PINTU MASUK)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {

        $role = auth()?->role;

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
    | ROLE BASED PAGES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });

    Route::middleware('role:akuntan')->group(function () {
        Route::get('/akuntan/dashboard', function () {
            return view('dashboard.akuntan');
        })->name('akuntan.dashboard');
    });

    Route::middleware('role:manajer')->group(function () {
        Route::get('/manajer/dashboard', function () {
            return view('dashboard.manajer');
        })->name('manajer.dashboard');
    });

    Route::middleware('role:auditor')->group(function () {
        Route::get('/auditor/dashboard', function () {
            return view('dashboard.auditor');
        })->name('auditor.dashboard');
    });

    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', function () {
            return view('dashboard.staff');
        })->name('staff.dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | LOGOUT (HARUS DI AUTH)
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});