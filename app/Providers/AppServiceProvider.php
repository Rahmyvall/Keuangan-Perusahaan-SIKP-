<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // ==================== DASHBOARD ROUTE HELPER ====================
        if (!function_exists('dashboard_route')) {
            function dashboard_route()
            {
                if (!auth()->check()) {
                    return route('login');
                }

                $role = auth()->user()->role ?? null;

                if ($role === 'admin') {
                    return route('admin.dashboard');
                }

                // akuntan, manajer, staff, auditor, dll
                return route("{$role}.dashboard");
            }
        }
        // ============================================================
    }
}