@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- ================= HEADER ================= --}}
    <div class="page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i data-feather="layers"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1">
                        Chart Of Account
                    </h2>

                    <p class="text-muted mb-0">
                        Manajemen akun perusahaan (COA)
                    </p>
                </div>

            </div>

            <a href="{{ route('akun.create') }}" class="btn btn-primary modern-btn px-4">

                <i data-feather="plus" class="me-2"></i>
                Tambah Akun

            </a>

        </div>

    </div>

    {{-- ================= CARD ================= --}}
    <div class="main-card">

        {{-- TOOLBAR --}}
        <div class="table-toolbar">

            <div>
                <h5 class="fw-bold mb-1">
                    Data Chart Of Account
                </h5>

                <small class="text-muted">
                    Total {{ $data->count() }} akun terdaftar
                </small>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table modern-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Kode</th>
                        <th>Nama Akun</th>
                        <th>Tipe</th>
                        <th>Saldo</th>
                        <th>Level</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th class="text-center pe-4">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($data->groupBy('tipe_akun') as $tipe => $items)

                    {{-- GROUP HEADER --}}
                    <tr class="group-row">

                        <td colspan="9">

                            <div class="group-title">

                                <div class="group-dot"></div>

                                {{ strtoupper($tipe) }}

                            </div>

                        </td>

                    </tr>

                    @foreach($items as $i => $row)

                    <tr>

                        {{-- NUMBER --}}
                        <td class="ps-4 text-muted fw-semibold">
                            {{ $i + 1 }}
                        </td>

                        {{-- CODE --}}
                        <td>

                            <span class="account-code">
                                {{ $row->kode_akun }}
                            </span>

                        </td>

                        {{-- ACCOUNT NAME --}}
                        <td>

                            <div class="d-flex align-items-center gap-2">

                                @if($row->parent_id)

                                <span class="child-arrow">
                                    ↳
                                </span>

                                @endif

                                <div>

                                    <div class="fw-bold text-dark">
                                        {{ $row->nama_akun }}
                                    </div>

                                    @if($row->parent)

                                    <small class="text-muted">
                                        Parent :
                                        {{ $row->parent->nama_akun }}
                                    </small>

                                    @endif

                                </div>

                            </div>

                        </td>

                        {{-- TYPE --}}
                        <td>

                            <span class="type-badge">

                                {{ ucfirst($row->tipe_akun) }}

                            </span>

                        </td>

                        {{-- BALANCE --}}
                        <td>

                            <span class="balance-badge">

                                {{ ucfirst($row->saldo_normal) }}

                            </span>

                        </td>

                        {{-- LEVEL --}}
                        <td>

                            <div class="level-badge">

                                Level {{ $row->level }}

                            </div>

                        </td>

                        {{-- PARENT --}}
                        <td>

                            <span class="text-muted">

                                {{ $row->parent->nama_akun ?? '-' }}

                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if($row->is_active)

                            <span class="status-badge status-active">

                                <span class="dot"></span>

                                Aktif

                            </span>

                            @else

                            <span class="status-badge status-inactive">

                                <span class="dot"></span>

                                Nonaktif

                            </span>

                            @endif

                        </td>

                        {{-- ACTION --}}
                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center">

                                @include('akun.partials.action', ['row' => $row])

                            </div>

                        </td>

                    </tr>

                    @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>

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
    --dark: #0f172a;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
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
    width: 72px;
    height: 72px;
    border-radius: 22px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 24px rgba(37, 99, 235, .25);
}

.header-icon svg {
    width: 30px;
    height: 30px;
}

/* BUTTON */
.modern-btn {
    height: 48px;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    transition: .25s ease;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, .18);
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
    padding-top: 18px;
    padding-bottom: 18px;
    vertical-align: middle;
}

.modern-table tbody tr {
    transition: .2s ease;
}

.modern-table tbody tr:hover {
    background: #f8fbff;
}

/* GROUP */
.group-row td {
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.group-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 700;
    color: #334155;
    letter-spacing: 1px;
}

.group-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary);
}

/* ACCOUNT CODE */
.account-code {
    background: #0f172a;
    color: white;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .5px;
}

/* CHILD */
.child-arrow {
    color: #94a3b8;
    font-size: 18px;
}

/* BADGE */
.type-badge {
    background: var(--primary-soft);
    color: var(--primary);
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
}

.balance-badge {
    background: #f1f5f9;
    color: #334155;
    padding: 8px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
}

.level-badge {
    background: #fff7ed;
    color: #ea580c;
    padding: 8px 14px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    display: inline-block;
}

/* STATUS */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
}

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

    .group-row td {
        display: block !important;
    }

}
</style>

@endsection