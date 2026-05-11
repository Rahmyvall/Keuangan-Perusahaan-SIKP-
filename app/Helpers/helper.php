<?php

// ==================== DASHBOARD ROUTE HELPER ====================
if (!function_exists('dashboard_route')) {
    function dashboard_route()
    {
        if (!auth()->check()) {
            return route('login');
        }

        $role = auth()->user()->role;

        if ($role === 'admin') {
            return route('admin.dashboard');
        }

        // untuk akuntan, manajer, auditor, staff, dll
        return route("{$role}.dashboard");
    }
}

// ==================== FORMAT NPWP ====================
if (!function_exists('formatNPWP')) {
    function formatNPWP($npwp)
    {
        $npwp = preg_replace('/[^0-9]/', '', $npwp);

        if (strlen($npwp) == 15) {
            return substr($npwp, 0, 2) . '.' .
                   substr($npwp, 2, 3) . '.' .
                   substr($npwp, 5, 3) . '.' .
                   substr($npwp, 8, 1) . '-' .
                   substr($npwp, 9, 3) . '.' .
                   substr($npwp, 12, 3);
        }

        return $npwp;
    }
}