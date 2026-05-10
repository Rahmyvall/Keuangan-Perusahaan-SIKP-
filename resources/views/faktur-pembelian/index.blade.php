@extends('layouts.app')

@section('title', 'Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================= --}}
    {{-- HEADER --}}
    {{-- ========================================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-invoice text-primary me-2"></i>
                Faktur Pembelian
            </h2>

            <p class="text-muted mb-0">
                Manajemen data faktur pembelian supplier
            </p>
        </div>

        <div>
            <a href="{{ route('faktur-pembelian.create') }}" class="btn btn-primary px-4 shadow-sm">

                <i class="fas fa-plus-circle me-2"></i>
                Tambah Faktur
            </a>
        </div>

    </div>

    {{-- ========================================= --}}
    {{-- ALERT --}}
    {{-- ========================================= --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0">
        <i class="fas fa-times-circle me-2"></i>
        {{ session('error') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert">
        </button>
    </div>
    @endif

    {{-- ========================================= --}}
    {{-- FILTER --}}
    {{-- ========================================= --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="fw-semibold mb-0">
                <i class="fas fa-filter me-2 text-primary"></i>
                Filter Data
            </h5>
        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    {{-- Perusahaan --}}
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-medium">
                            Perusahaan
                        </label>

                        <select name="id_perusahaan" class="form-select">

                            <option value="">
                                Semua Perusahaan
                            </option>

                            @foreach($perusahaan as $item)
                            <option value="{{ $item->id_perusahaan }}"
                                {{ request('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>

                                {{ $item->nama_perusahaan }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-medium">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option value="">Semua</option>

                            <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>
                                Belum Lunas
                            </option>

                            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>
                                Lunas
                            </option>

                            <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>

                        </select>
                    </div>

                    {{-- Tanggal Awal --}}
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-medium">
                            Tanggal Awal
                        </label>

                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">
                    </div>

                    {{-- Tanggal Akhir --}}
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label fw-medium">
                            Tanggal Akhir
                        </label>

                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">
                    </div>

                    {{-- Search --}}
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label fw-medium">
                            Cari Data
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-muted"></i>
                            </span>

                            <input type="text" name="search" class="form-control"
                                placeholder="Nomor faktur / supplier..." value="{{ request('search') }}">

                            <button class="btn btn-primary">
                                Filter
                            </button>

                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- ========================================= --}}
    {{-- TABLE --}}
    {{-- ========================================= --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-semibold mb-0">
                        Data Faktur Pembelian
                    </h5>

                    <small class="text-muted">
                        Total data :
                        {{ $fakturPembelian->total() }}
                    </small>
                </div>

            </div>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th width="60">No</th>
                            <th>Nomor Faktur</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Perusahaan</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">PPN</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                            <th width="180" class="text-center">
                                Aksi
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($fakturPembelian as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($fakturPembelian->firstItem() - 1) }}
                            </td>

                            <td>
                                <div class="fw-semibold text-primary">
                                    {{ $item->nomor_faktur }}
                                </div>
                            </td>

                            <td>
                                {{ $item->tanggal->format('d M Y') }}
                            </td>

                            <td>
                                <div class="fw-medium">
                                    {{ $item->supplier->nama_supplier ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $item->perusahaan->nama_perusahaan ?? '-' }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($item->ppn, 0, ',', '.') }}
                            </td>

                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </td>

                            <td>

                                @if($item->status == 'Lunas')

                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Lunas
                                </span>

                                @elseif($item->status == 'Belum Lunas')

                                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>
                                    Belum Lunas
                                </span>

                                @else

                                <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Dibatalkan
                                </span>

                                @endif

                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-1">

                                    {{-- Detail --}}
                                    <a href="{{ route('faktur-pembelian.show', $item) }}"
                                        class="btn btn-sm btn-light border" title="Detail">

                                        <i class="fas fa-eye text-info"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('faktur-pembelian.edit', $item) }}"
                                        class="btn btn-sm btn-light border" title="Edit">

                                        <i class="fas fa-edit text-warning"></i>
                                    </a>

                                    {{-- Print --}}
                                    <a href="{{ route('faktur-pembelian.print', $item) }}"
                                        class="btn btn-sm btn-light border" title="Print">

                                        <i class="fas fa-print text-secondary"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('faktur-pembelian.destroy', $item) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-light border" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">

                                            <i class="fas fa-trash text-danger"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center py-5">

                                <div class="py-4">

                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>

                                    <h5 class="fw-semibold text-muted">
                                        Tidak Ada Data Faktur
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Data faktur pembelian belum tersedia
                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}
        @if($fakturPembelian->hasPages())

        <div class="card-footer bg-white border-0 py-3">

            {{ $fakturPembelian->links('pagination::bootstrap-5') }}

        </div>

        @endif

    </div>

</div>

@endsection