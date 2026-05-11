@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i data-feather="dollar-sign"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1">
                        Data Mata Uang
                    </h2>

                    <p class="text-muted mb-0">
                        Manajemen seluruh data mata uang perusahaan
                    </p>
                </div>

            </div>

            <a href="{{ route('mata-uang.create') }}" class="btn btn-primary modern-btn px-4">

                <i data-feather="plus" class="me-2"></i>
                Tambah Data

            </a>

        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

    <div class="alert modern-alert alert-success border-0 shadow-sm">

        <div class="d-flex align-items-center">
            <i data-feather="check-circle" class="me-2"></i>
            {{ session('success') }}
        </div>

        <button class="btn-close" data-bs-dismiss="alert"></button>

    </div>

    @endif

    {{-- FILTER --}}
    <div class="filter-card mb-4">

        <form method="GET" action="{{ route('mata-uang.index') }}">

            <div class="row g-3 align-items-center">

                {{-- SEARCH --}}
                <div class="col-lg-4">

                    <div class="search-wrapper">

                        <i data-feather="search" class="search-icon"></i>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control modern-input" placeholder="Cari kode / nama / simbol...">

                    </div>

                </div>

                {{-- SORT --}}
                <div class="col-lg-3">

                    <select name="sort" class="form-select modern-input">

                        <option value="kode" {{ request('sort') == 'kode' ? 'selected' : '' }}>
                            Urutkan Kode
                        </option>

                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>
                            Urutkan Nama
                        </option>

                        <option value="simbol" {{ request('sort') == 'simbol' ? 'selected' : '' }}>
                            Urutkan Simbol
                        </option>

                    </select>

                </div>

                {{-- DIRECTION --}}
                <div class="col-lg-2">

                    <select name="direction" class="form-select modern-input">

                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>
                            A - Z
                        </option>

                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>
                            Z - A
                        </option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="col-lg-3 d-flex gap-2">

                    <button class="btn btn-primary modern-btn w-100">

                        <i data-feather="search" class="me-2"></i>

                        Cari

                    </button>

                    <a href="{{ route('mata-uang.index') }}" class="btn btn-light modern-btn-light">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    {{-- MAIN CARD --}}
    <div class="main-card">

        {{-- TOOLBAR --}}
        <div class="table-toolbar">

            <div>
                <h5 class="fw-bold mb-1">
                    List Mata Uang
                </h5>

                <small class="text-muted">
                    Total {{ $data->total() }} mata uang tersedia
                </small>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table modern-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4" width="60">#</th>
                        <th width="90">Icon</th>
                        <th>Kode</th>
                        <th>Nama Mata Uang</th>
                        <th>Simbol</th>
                        <th class="text-center pe-4" width="150">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $i => $row)

                    <tr>

                        {{-- NUMBER --}}
                        <td class="ps-4 text-muted fw-semibold">
                            {{ $data->firstItem() + $i }}
                        </td>

                        {{-- ICON --}}
                        <td>

                            <div class="currency-icon">

                                <i data-feather="dollar-sign"></i>

                            </div>

                        </td>

                        {{-- CODE --}}
                        <td>

                            <span class="currency-code">
                                {{ $row->kode }}
                            </span>

                        </td>

                        {{-- NAME --}}
                        <td>

                            <div class="fw-bold text-dark">
                                {{ $row->nama }}
                            </div>

                        </td>

                        {{-- SYMBOL --}}
                        <td>

                            <span class="currency-symbol">
                                {{ $row->simbol ?? '-' }}
                            </span>

                        </td>

                        {{-- ACTION --}}
                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center gap-2">

                                {{-- VIEW --}}
                                <a href="{{ route('mata-uang.show', $row->id_mata_uang) }}" class="action-btn btn-view">

                                    <i data-feather="eye"></i>

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('mata-uang.edit', $row->id_mata_uang) }}" class="action-btn btn-edit">

                                    <i data-feather="edit-2"></i>

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('mata-uang.destroy', $row->id_mata_uang) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Hapus data mata uang ini?')"
                                        class="action-btn btn-delete border-0">

                                        <i data-feather="trash-2"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            <div class="empty-state">

                                <div class="empty-icon">
                                    <i data-feather="inbox"></i>
                                </div>

                                <h5 class="fw-bold mt-4">
                                    Data Belum Tersedia
                                </h5>

                                <p class="text-muted mb-3">
                                    Silakan tambahkan data mata uang baru
                                </p>

                                <a href="{{ route('mata-uang.create') }}" class="btn btn-primary modern-btn px-4">

                                    Tambah Data

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($data->hasPages())

        <div class="table-footer">

            {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}

        </div>

        @endif

    </div>

</div>

<style>
:root {
    --primary: #2563eb;
    --primary-soft: #eff6ff;
    --success: #16a34a;
    --danger: #dc2626;
    --danger-soft: #fef2f2;
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
    width: 72px;
    height: 72px;
    border-radius: 22px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
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
    font-weight: 600;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .25s ease;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 22px rgba(37, 99, 235, .18);
}

.modern-btn-light {
    border-radius: 14px;
    border: 1px solid var(--border);
    background: white;
    color: var(--dark);
    min-width: 90px;
}

.modern-btn-light:hover {
    background: #f8fafc;
}

/* ALERT */
.modern-alert {
    border-radius: 18px;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
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

/* ICON */
.currency-icon {
    width: 52px;
    height: 52px;
    border-radius: 18px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
}

/* BADGE */
.currency-code {
    background: #0f172a;
    color: white;
    padding: 10px 16px;
    border-radius: 14px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .5px;
}

.currency-symbol {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
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