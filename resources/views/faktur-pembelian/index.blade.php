@extends('layouts.app')

@section('title', 'Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h1 class="fw-bold mb-1 text-dark">
                <i class="fas fa-file-invoice-dollar text-primary me-3"></i>
                Faktur Pembelian
            </h1>
            <p class="text-muted mb-0 fs-6">
                Kelola semua faktur pembelian dari supplier
            </p>
        </div>

        <a href="{{ route('faktur-pembelian.create') }}"
            class="btn btn-primary btn-lg px-4 shadow-sm d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Faktur Baru</span>
        </a>
    </div>

    <!-- ALERT -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- FILTER CARD -->
    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-4">
            <h5 class="fw-semibold mb-0 text-dark">
                <i class="fas fa-sliders-h me-2 text-primary"></i> Filter & Pencarian
            </h5>
        </div>
        <div class="card-body pb-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-medium text-muted">Perusahaan</label>
                    <select name="id_perusahaan" class="form-select form-select-lg">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaan as $item)
                        <option value="{{ $item->id_perusahaan }}"
                            {{ request('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>
                            {{ $item->nama_perusahaan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-medium text-muted">Status</label>
                    <select name="status" class="form-select form-select-lg">
                        <option value="">Semua Status</option>
                        <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum
                            Lunas</option>
                        <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-medium text-muted">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control form-control-lg"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-medium text-muted">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control form-control-lg"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-lg-3 col-md-12">
                    <label class="form-label fw-medium text-muted">Cari Faktur</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Nomor faktur atau supplier..." value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-filter me-2"></i> Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-header bg-white border-0 py-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-semibold mb-1">Daftar Faktur Pembelian</h5>
                    <small class="text-muted">
                        Total <strong>{{ $fakturPembelian->total() }}</strong> data
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center fw-medium">No</th>
                            <th class="fw-medium">Nomor Faktur</th>
                            <th class="fw-medium">Tanggal</th>
                            <th class="fw-medium">Supplier</th>
                            <th class="fw-medium">Perusahaan</th>
                            <th class="text-end fw-medium">Subtotal</th>
                            <th class="text-end fw-medium">PPN</th>
                            <th class="text-end fw-medium">Total</th>
                            <th class="text-center fw-medium">Status</th>
                            <th width="180" class="text-center fw-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top">
                        @forelse($fakturPembelian as $item)
                        <tr>
                            <td class="text-center fw-medium">
                                {{ $loop->iteration + ($fakturPembelian->firstItem() - 1) }}
                            </td>
                            <td>
                                <span class="fw-semibold text-primary">{{ $item->nomor_faktur }}</span>
                            </td>
                            <td>{{ $item->tanggal?->format('d M Y') }}</td>
                            <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $item->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->ppn ?? 0, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold text-success">
                                Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if($item->status == 'Lunas')
                                <span class="badge bg-success px-3 py-2">Lunas</span>
                                @elseif($item->status == 'Belum Lunas')
                                <span class="badge bg-warning text-dark px-3 py-2">Belum Lunas</span>
                                @else
                                <span class="badge bg-danger px-3 py-2">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('faktur-pembelian.show', $item) }}" class="btn btn-light border"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('faktur-pembelian.edit', $item) }}" class="btn btn-light border"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('faktur-pembelian.print', $item) }}" class="btn btn-light border"
                                        title="Cetak" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('faktur-pembelian.destroy', $item) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light border text-danger"
                                            onclick="return confirm('Yakin ingin menghapus faktur ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="fw-semibold text-muted">Tidak Ada Data</h5>
                                <p class="text-muted">Belum ada faktur pembelian yang ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($fakturPembelian->hasPages())
        <div class="card-footer bg-white border-0 py-4">
            {{ $fakturPembelian->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

</div>

@endsection