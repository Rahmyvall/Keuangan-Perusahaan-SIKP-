@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i data-feather="users"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1">
                        Human Resource
                    </h2>

                    <p class="text-muted mb-0">
                        Manajemen pengguna sistem perusahaan
                    </p>
                </div>

            </div>

            <a href="{{ route('pengguna.create') }}" class="btn btn-primary modern-btn px-4">

                <i data-feather="plus" class="me-2"></i>
                Tambah Pengguna

            </a>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="filter-card mb-4">

        <form method="GET" action="{{ route('pengguna.index') }}">

            <div class="row g-3 align-items-center">

                {{-- SEARCH --}}
                <div class="col-lg-5">

                    <div class="search-wrapper">

                        <i data-feather="search" class="search-icon"></i>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control modern-input" placeholder="Cari pengguna...">

                    </div>

                </div>

                {{-- ROLE --}}
                <div class="col-lg-3">

                    <select name="role" class="form-select modern-input">

                        <option value="">
                            Semua Role
                        </option>

                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>
                            Manager
                        </option>

                        <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>
                            Staff
                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="col-lg-4 d-flex gap-2">

                    <button class="btn btn-primary modern-btn px-4">
                        Filter
                    </button>

                    <a href="{{ route('pengguna.index') }}" class="btn btn-light modern-btn-light px-4">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    {{-- TABLE CARD --}}
    <div class="main-card">

        {{-- TABLE HEADER --}}
        <div class="table-toolbar">

            <div>
                <h5 class="fw-bold mb-1">
                    Data Pengguna
                </h5>

                <small class="text-muted">
                    Total {{ $pengguna->total() ?? count($pengguna) }} pengguna terdaftar
                </small>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table modern-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Pengguna</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th class="text-center pe-4">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengguna as $i => $item)

                    @php
                    $words = explode(' ', $item->nama_lengkap);

                    $initials = strtoupper(
                    substr($words[0],0,1) .
                    (isset($words[1]) ? substr($words[1],0,1) : '')
                    );
                    @endphp

                    <tr>

                        {{-- NO --}}
                        <td class="ps-4 text-muted fw-semibold">

                            {{ $pengguna instanceof \Illuminate\Pagination\LengthAwarePaginator
                                ? $pengguna->firstItem() + $i
                                : $i + 1 }}

                        </td>

                        {{-- USER --}}
                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="avatar-user">
                                    {{ $initials }}
                                </div>

                                <div>

                                    <div class="fw-bold text-dark">
                                        {{ $item->nama_lengkap }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $item->email ?? '-' }}
                                    </small>

                                </div>

                            </div>

                        </td>

                        {{-- USERNAME --}}
                        <td>

                            <span class="username-badge">
                                {{ $item->username }}
                            </span>

                        </td>

                        {{-- ROLE --}}
                        <td>

                            @php
                            $roleClass = match($item->role) {
                            'admin' => 'role-admin',
                            'manager' => 'role-manager',
                            'staff' => 'role-staff',
                            default => 'role-default'
                            };
                            @endphp

                            <span class="role-badge {{ $roleClass }}">

                                <span class="dot"></span>

                                {{ ucfirst($item->role ?? '-') }}

                            </span>

                        </td>

                        {{-- COMPANY --}}
                        <td>

                            <span class="fw-medium">
                                {{ $item->perusahaan->nama_perusahaan ?? '—' }}
                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if($item->is_active)

                            <span class="status-badge status-active">

                                <span class="dot"></span>

                                Active

                            </span>

                            @else

                            <span class="status-badge status-inactive">

                                <span class="dot"></span>

                                Inactive

                            </span>

                            @endif

                        </td>

                        {{-- DATE --}}
                        <td>

                            <span class="text-muted">
                                {{ $item->created_at?->format('d M Y') }}
                            </span>

                        </td>

                        {{-- ACTION --}}
                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center gap-2">

                                {{-- VIEW --}}
                                <a href="{{ route('pengguna.show', $item->id_pengguna) }}" class="action-btn btn-view">

                                    <i data-feather="eye"></i>

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('pengguna.edit', $item->id_pengguna) }}" class="action-btn btn-edit">

                                    <i data-feather="edit-2"></i>

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('pengguna.destroy', $item->id_pengguna) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Hapus pengguna ini?')"
                                        class="action-btn btn-delete border-0">

                                        <i data-feather="trash-2"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center py-5">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i data-feather="users"></i>
                                </div>

                                <h5 class="fw-bold mt-4">
                                    Belum Ada Pengguna
                                </h5>

                                <p class="text-muted mb-3">
                                    Data pengguna masih kosong
                                </p>

                                <a href="{{ route('pengguna.create') }}" class="btn btn-primary modern-btn px-4">

                                    Tambah Pengguna

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($pengguna->hasPages())

        <div class="table-footer">

            {{ $pengguna->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

        @endif

    </div>

</div>

<style>
:root {
    --primary: #2563eb;
    --primary-soft: #eff6ff;
    --success: #16a34a;
    --success-soft: #f0fdf4;
    --danger: #dc2626;
    --danger-soft: #fef2f2;
    --warning: #d97706;
    --warning-soft: #fff7ed;
    --dark: #0f172a;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
    --white: #ffffff;
}

body {
    background: var(--bg);
    font-family: 'Inter', sans-serif;
}

/* HEADER */
.page-header {
    background: linear-gradient(135deg, #ffffff, #f8fbff);
    border-radius: 26px;
    padding: 28px;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
}

.header-icon {
    width: 70px;
    height: 70px;
    border-radius: 22px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 12px 25px rgba(37, 99, 235, .25);
}

.header-icon svg {
    width: 30px;
    height: 30px;
}

/* BUTTON */
.modern-btn {
    height: 48px;
    border-radius: 14px;
    font-weight: 600;
    border: none;
    display: inline-flex;
    align-items: center;
    transition: .25s ease;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, .18);
}

.modern-btn-light {
    background: white;
    border: 1px solid var(--border);
    color: var(--dark);
}

.modern-btn-light:hover {
    background: #f8fafc;
}

/* FILTER */
.filter-card {
    background: white;
    border-radius: 24px;
    padding: 24px;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 8px 25px rgba(15, 23, 42, .04);
}

.search-wrapper {
    position: relative;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 18px;
    transform: translateY(-50%);
    color: #94a3b8;
    width: 18px;
    height: 18px;
}

.modern-input {
    height: 50px;
    border-radius: 16px;
    border: 1px solid var(--border);
    background: #f8fafc;
    padding: 0 16px;
    transition: .2s ease;
}

.search-wrapper .modern-input {
    padding-left: 48px;
}

.modern-input:focus {
    background: white;
    border-color: rgba(37, 99, 235, .4);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
}

/* CARD */
.main-card {
    background: white;
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
}

/* TOOLBAR */
.table-toolbar {
    padding: 24px;
    border-bottom: 1px solid var(--border);
    background: #fcfdff;
}

/* TABLE */
.modern-table thead {
    background: #f8fafc;
}

.modern-table thead th {
    border: none;
    padding-top: 18px;
    padding-bottom: 18px;
    color: #64748b;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
}

.modern-table tbody td {
    border-color: #f1f5f9;
    padding-top: 20px;
    padding-bottom: 20px;
    vertical-align: middle;
}

.modern-table tbody tr {
    transition: .2s ease;
}

.modern-table tbody tr:hover {
    background: #f8fbff;
}

/* AVATAR */
.avatar-user {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: white;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 18px rgba(99, 102, 241, .25);
}

/* USERNAME */
.username-badge {
    background: #f1f5f9;
    padding: 8px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}

/* ROLE */
.role-badge,
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
}

.role-admin {
    background: rgba(239, 68, 68, .1);
    color: #ef4444;
}

.role-manager {
    background: rgba(234, 179, 8, .1);
    color: #eab308;
}

.role-staff {
    background: rgba(59, 130, 246, .1);
    color: #3b82f6;
}

.role-default {
    background: #f1f5f9;
    color: #64748b;
}

/* STATUS */
.status-active {
    background: rgba(34, 197, 94, .1);
    color: #22c55e;
}

.status-inactive {
    background: rgba(239, 68, 68, .1);
    color: #ef4444;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

/* ACTION */
.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
    text-decoration: none;
}

.action-btn:hover {
    transform: translateY(-2px);
}

.btn-view {
    background: #eff6ff;
    color: #2563eb;
}

.btn-edit {
    background: #fff7ed;
    color: #ea580c;
}

.btn-delete {
    background: #fef2f2;
    color: #dc2626;
}

/* EMPTY */
.empty-state {
    padding: 50px 20px;
}

.empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 28px;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
}

.empty-icon svg {
    width: 44px;
    height: 44px;
}

/* FOOTER */
.table-footer {
    padding: 22px 24px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    background: #fcfdff;
}

/* PAGINATION */
.pagination {
    margin-bottom: 0;
}

.page-link {
    border: none;
    margin: 0 3px;
    border-radius: 12px !important;
    color: var(--dark);
    padding: 10px 14px;
}

.page-item.active .page-link {
    background: var(--primary);
}

/* RESPONSIVE */
@media (max-width: 768px) {

    .page-header,
    .filter-card,
    .main-card {
        border-radius: 20px;
    }

    .modern-table thead {
        display: none;
    }

    .modern-table tbody tr {
        display: block;
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody td {
        display: flex;
        justify-content: space-between;
        border: none;
        padding: 10px 0;
    }

}
</style>
@endsection