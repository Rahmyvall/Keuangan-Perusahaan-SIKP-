<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('admin/src/img/icons/halaman.png') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>{{ $title ?? 'Dashboard' }} | SIKP</title>
    <!-- Di dalam <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('admin/static/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
    :root {
        --primary: #4361ee;
    }

    /* === CUSTOM ENHANCEMENT === */
    body {
        font-family: 'Inter', sans-serif;
    }

    /* Card Modern Look */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .pagination ul {
        display: flex;
        /* atau inline-flex */
        flex-direction: row;
        /* pastikan ini row, bukan column */
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
        /* jarak antar nomor */
        justify-content: center;
        align-items: center;
    }

    .pagination li {
        display: inline-block;
        /* atau flex */
    }

    .pagination a {
        padding: 8px 12px;
        text-decoration: none;
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

    /* Sidebar Enhancement */
    .sidebar {
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    }

    [data-bs-theme="dark"] .sidebar {
        background: linear-gradient(180deg, #212529 0%, #2b3035 100%);
    }

    .sidebar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        padding: 1.25rem 1.75rem;
    }

    /* Navbar Enhancement */
    .navbar-bg {
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        backdrop-filter: blur(10px);
    }

    /* Hover Effects */
    .sidebar-link {
        transition: all 0.25s ease;
        border-radius: 8px;
        margin: 3px 8px;
    }

    .sidebar-link:hover {
        transform: translateX(6px);
        background-color: rgba(67, 97, 238, 0.1) !important;
    }

    .sidebar-item.active .sidebar-link {
        background-color: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    /* Button & Badge */
    .btn-primary {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
    }

    /* Content Padding */
    .content {
        padding: 2rem 1.5rem;
    }

    /* Scrollbar Modern */
    .js-simplebar::-webkit-scrollbar {
        width: 6px;
    }

    .js-simplebar::-webkit-scrollbar-thumb {
        background: #4361ee;
        border-radius: 10px;
    }

    /* Notification Indicator */
    .indicator {
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    @keyframes ping {

        75%,
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    /* Dark Mode Fine Tuning */
    [data-bs-theme="dark"] .card {
        background: #2b3035;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    [data-bs-theme="dark"] .card:hover {
        box-shadow: 0 12px 30px rgba(67, 97, 238, 0.25);
    }

    /* === TEXT COLOR FOLLOW PRIMARY === */
    .text-primary,
    body,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    span,
    a {
        color: var(--primary);
    }

    /* Optional: link hover biar lebih hidup */
    a:hover {
        color: #2f49d1;
        /* versi lebih gelap dari primary */
    }

    [data-bs-theme="dark"] {
        --primary: #7b9cff;
        /* versi lebih terang biar kontras */
    }

    .text-dynamic {
        color: var(--primary);
    }

    .navbar {
        position: relative;
        z-index: 1050;
        /* pastikan di atas content */
    }

    .dropdown-menu {
        z-index: 2000;
        /* supaya dropdown tidak ketutup */
    }

    .navbar-collapse {
        z-index: 1050;
    }
    </style>
</head>
