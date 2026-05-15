<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO -->
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap 5, admin dashboard, responsive template">

    <title>{{ $title ?? 'Dashboard' }} | SIKP</title>

    <!-- ICON -->
    <link rel="shortcut icon" href="{{ asset('admin/src/img/icons/halaman.png') }}">

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('admin/static/css/app.css') }}" rel="stylesheet">

    <!-- DATATABLE -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CUSTOM STYLE -->
    <style>
    :root {
        --primary: #4361ee;
        --primary-hover: #2f49d1;
        --dark-bg: #121212;
        --dark-card: #1e1e1e;
        --dark-soft: #2b3035;
    }

    /* =========================================================
           GLOBAL
        ========================================================= */
    body {
        font-family: 'Inter', sans-serif;
        overflow-x: hidden;
    }

    a {
        text-decoration: none;
        transition: 0.2s ease;
    }

    a:hover {
        color: var(--primary-hover);
    }

    .text-dynamic {
        color: var(--primary);
    }

    /* =========================================================
           DARK MODE
        ========================================================= */
    [data-bs-theme="dark"] {
        --primary: #7b9cff;
        background-color: var(--dark-bg);
        color: #fff;
    }

    [data-bs-theme="dark"] body,
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .navbar,
    [data-bs-theme="dark"] .sidebar,
    [data-bs-theme="dark"] .dropdown-menu {
        background-color: var(--dark-card) !important;
        color: #fff !important;
    }

    [data-bs-theme="dark"] .card {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
    }

    [data-bs-theme="dark"] .card:hover {
        box-shadow: 0 12px 30px rgba(67, 97, 238, 0.25);
    }

    [data-bs-theme="dark"] .table {
        color: #fff;
    }

    [data-bs-theme="dark"] a {
        color: #9ec5fe;
    }

    /* =========================================================
           CARD
        ========================================================= */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(67, 97, 238, 0.15);
    }

    .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        padding: 1.5rem 1.75rem;
    }

    /* =========================================================
           SIDEBAR
        ========================================================= */
    .sidebar {
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    }

    [data-bs-theme="dark"] .sidebar {
        background: linear-gradient(180deg, #212529 0%, #2b3035 100%);
    }

    .sidebar-brand {
        font-size: 1.5rem;
        font-weight: 700;
        padding: 1.25rem 1.75rem;
    }

    .sidebar-link {
        border-radius: 8px;
        margin: 3px 8px;
        transition: all 0.25s ease;
    }

    .sidebar-link:hover {
        transform: translateX(6px);
        background-color: rgba(67, 97, 238, 0.1) !important;
    }

    .sidebar-item.active .sidebar-link {
        background-color: var(--primary) !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    /* =========================================================
           NAVBAR
        ========================================================= */
    .navbar {
        position: relative;
        z-index: 1050;
    }

    .navbar-bg {
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .navbar-collapse {
        z-index: 1050;
    }

    .dropdown-menu {
        z-index: 2000;
        border-radius: 12px;
    }

    /* =========================================================
           BUTTON
        ========================================================= */
    .btn-primary {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
    }

    /* =========================================================
           CONTENT
        ========================================================= */
    .content {
        padding: 2rem 1.5rem;
    }

    /* =========================================================
           PAGINATION
        ========================================================= */
    .pagination ul {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        margin: 0;
        padding: 0;

        list-style: none;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination a {
        padding: 8px 12px;
    }

    /* =========================================================
           SCROLLBAR
        ========================================================= */
    .js-simplebar::-webkit-scrollbar {
        width: 6px;
    }

    .js-simplebar::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 10px;
    }

    /* =========================================================
           NOTIFICATION
        ========================================================= */
    .indicator {
        animation: ping 2s cubic-bezier(0, 0, .2, 1) infinite;
    }

    @keyframes ping {

        75%,
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }
    </style>
</head>
