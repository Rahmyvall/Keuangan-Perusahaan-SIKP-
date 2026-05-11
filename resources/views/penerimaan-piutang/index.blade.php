@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="modern-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="header-icon">
                    <i data-feather="credit-card"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-1 text-dark">
                        Penerimaan Piutang
                    </h2>

                    <p class="text-muted mb-0">
                        Monitoring transaksi pembayaran pelanggan perusahaan
                    </p>
                </div>

            </div>

            <a href="{{ route('penerimaan-piutang.create') }}" class="btn btn-primary modern-btn px-4">
                <i data-feather="plus" class="me-2"></i>
                Tambah Data
            </a>

        </div>
    </div>

    {{-- STATISTICS --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-4">
            <div class="stats-card">

                <div class="stats-content">

                    <div>
                        <span class="stats-label">
                            Total Transaksi
                        </span>

                        <h3 class="stats-value">
                            {{ $data->total() }}
                        </h3>
                    </div>

                    <div class="stats-icon primary">
                        <i data-feather="database"></i>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="stats-card">

                <div class="stats-content">

                    <div>
                        <span class="stats-label">
                            Total Nominal
                        </span>

                        <h3 class="stats-value text-success">
                            Rp {{ number_format($data->sum('jumlah'),0,',','.') }}
                        </h3>
                    </div>

                    <div class="stats-icon success">
                        <i data-feather="dollar-sign"></i>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="stats-card">

                <div class="stats-content">

                    <div>
                        <span class="stats-label">
                            Tanggal Hari Ini
                        </span>

                        <h3 class="stats-value">
                            {{ now()->format('d M Y') }}
                        </h3>
                    </div>

                    <div class="stats-icon warning">
                        <i data-feather="calendar"></i>
                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert modern-alert alert-success border-0 shadow-sm">
        <i data-feather="check-circle" class="me-2"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="main-card">

        {{-- FILTER --}}
        <div class="filter-section">

            <form method="GET">

                <div class="row g-3 align-items-center">

                    <div class="col-lg-5">

                        <div class="search-wrapper">

                            <i data-feather="search" class="search-icon"></i>

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control modern-input" placeholder="Cari nomor penerimaan...">

                        </div>

                    </div>

                    <div class="col-lg-3">

                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="form-control modern-input">

                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary modern-btn px-4">
                            Filter
                        </button>
                    </div>

                    <div class="col-auto">
                        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light modern-btn-light px-4">
                            Reset
                        </a>
                    </div>

                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table modern-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Perusahaan</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $i => $row)

                    <tr>

                        <td class="ps-4 text-muted fw-semibold">
                            {{ $data->firstItem() + $i }}
                        </td>

                        <td>
                            <div class="fw-bold text-primary">
                                {{ $row->nomor_penerimaan }}
                            </div>
                        </td>

                        <td>
                            <span class="fw-medium">
                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                            </span>
                        </td>

                        <td>

                            <div class="fw-semibold text-dark">
                                {{ $row->fakturPenjualan->nomor_faktur ?? '-' }}
                            </div>

                            <small class="text-muted">
                                #{{ $row->id_faktur_penjualan }}
                            </small>

                        </td>

                        <td>
                            <span class="fw-medium">
                                {{ $row->perusahaan->nama_perusahaan ?? '-' }}
                            </span>
                        </td>

                        <td class="text-end">

                            <span class="amount-badge">
                                Rp {{ number_format($row->jumlah,0,',','.') }}
                            </span>

                        </td>

                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('penerimaan-piutang.show',$row->id_penerimaan) }}"
                                    class="table-action action-view">
                                    <i data-feather="eye"></i>
                                </a>

                                <a href="{{ route('penerimaan-piutang.edit',$row->id_penerimaan) }}"
                                    class="table-action action-edit">
                                    <i data-feather="edit-2"></i>
                                </a>

                                <form action="{{ route('penerimaan-piutang.destroy',$row->id_penerimaan) }}"
                                    method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Yakin hapus data?')"
                                        class="table-action action-delete border-0">

                                        <i data-feather="trash-2"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-5">

                            <div class="empty-state">

                                <div class="empty-state-icon">
                                    <i data-feather="inbox"></i>
                                </div>

                                <h5 class="fw-bold mt-4">
                                    Belum Ada Data
                                </h5>

                                <p class="text-muted mb-0">
                                    Data penerimaan piutang masih kosong
                                </p>

                            </div>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- FOOTER --}}
        <div class="table-footer">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <small class="text-muted">
                    Menampilkan
                    {{ $data->firstItem() }}
                    -
                    {{ $data->lastItem() }}
                    dari
                    {{ $data->total() }} data
                </small>

                {{ $data->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

<style>
:root {
    --primary: #2563eb;
    --primary-soft: #eff6ff;
    --success: #16a34a;
    --success-soft: #f0fdf4;
    --warning: #d97706;
    --warning-soft: #fff7ed;
    --danger: #dc2626;
    --danger-soft: #fef2f2;
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
.modern-header {
    background: linear-gradient(135deg, #ffffff, #f8fbff);
    border-radius: 24px;
    padding: 28px;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
}

.header-icon {
    width: 68px;
    height: 68px;
    border-radius: 20px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
}

.header-icon svg {
    width: 28px;
    height: 28px;
}

/* BUTTON */
.modern-btn {
    height: 48px;
    border-radius: 14px;
    font-weight: 600;
    border: none;
    transition: .25s ease;
    display: inline-flex;
    align-items: center;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, .2);
}

.modern-btn-light {
    background: white;
    border: 1px solid var(--border);
    color: var(--dark);
}

.modern-btn-light:hover {
    background: #f8fafc;
}

/* STATS */
.stats-card {
    background: white;
    border-radius: 22px;
    padding: 24px;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 4px 20px rgba(15, 23, 42, .04);
    transition: .25s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-4px);
}

.stats-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stats-label {
    color: var(--muted);
    font-size: 14px;
    display: block;
    margin-bottom: 10px;
}

.stats-value {
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0;
}

.stats-icon {
    width: 58px;
    height: 58px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stats-icon.primary {
    background: var(--primary-soft);
    color: var(--primary);
}

.stats-icon.success {
    background: var(--success-soft);
    color: var(--success);
}

.stats-icon.warning {
    background: var(--warning-soft);
    color: var(--warning);
}

/* ALERT */
.modern-alert {
    border-radius: 18px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
}

/* MAIN CARD */
.main-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(226, 232, 240, .7);
    box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
}

/* FILTER */
.filter-section {
    padding: 24px;
    border-bottom: 1px solid var(--border);
    background: #fcfdff;
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
    padding-left: 50px;
}

.modern-input:focus {
    background: white;
    border-color: rgba(37, 99, 235, .4);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
}

/* TABLE */
.modern-table thead {
    background: #f8fafc;
}

.modern-table thead th {
    border: none;
    padding-top: 20px;
    padding-bottom: 20px;
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

/* BADGE */
.amount-badge {
    background: rgba(22, 163, 74, .1);
    color: var(--success);
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 14px;
    font-weight: 700;
}

/* ACTION */
.table-action {
    width: 40px;
    height: 40px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
    text-decoration: none;
}

.table-action:hover {
    transform: translateY(-2px) scale(1.03);
}

.action-view {
    background: #eff6ff;
    color: #2563eb;
}

.action-edit {
    background: #fff7ed;
    color: #ea580c;
}

.action-delete {
    background: #fef2f2;
    color: #dc2626;
}

/* EMPTY */
.empty-state {
    padding: 40px 20px;
}

.empty-state-icon {
    width: 100px;
    height: 100px;
    border-radius: 28px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    color: #94a3b8;
}

.empty-state-icon svg {
    width: 44px;
    height: 44px;
}

/* FOOTER */
.table-footer {
    padding: 20px 24px;
    border-top: 1px solid var(--border);
    background: #fcfdff;
}

/* PAGINATION */
.pagination {
    margin-bottom: 0;
}

.page-link {
    border: none;
    margin: 0 3px;
    border-radius: 10px !important;
    color: var(--dark);
    padding: 10px 14px;
}

.page-item.active .page-link {
    background: var(--primary);
}

/* RESPONSIVE */
@media (max-width: 768px) {

    .modern-header,
    .stats-card,
    .main-card {
        border-radius: 20px;
    }

    .filter-section {
        padding: 18px;
    }

    .modern-table thead {
        display: none;
    }

    .modern-table tbody tr {
        display: block;
        padding: 14px;
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