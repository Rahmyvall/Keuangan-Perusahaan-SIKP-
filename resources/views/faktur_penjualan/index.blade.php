{{-- resources/views/faktur_penjualan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Faktur Penjualan')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-semibold">
                <i class="fas fa-file-invoice me-2 text-primary"></i> Faktur Penjualan
            </h3>
            <p class="text-muted mb-0">Daftar semua faktur penjualan</p>
        </div>

        <a href="{{ route('faktur-penjualan.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Faktur Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Perusahaan</label>
                    <select name="id_perusahaan" class="form-select">
                        <option value="">-- Semua Perusahaan --</option>
                        @foreach($perusahaan as $item)
                        <option value="{{ $item->id_perusahaan }}"
                            {{ request('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>
                            {{ $item->nama_perusahaan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="Belum Lunas" {{ request('status')=='Belum Lunas'?'selected':'' }}>Belum Lunas
                        </option>
                        <option value="Lunas" {{ request('status')=='Lunas'?'selected':'' }}>Lunas</option>
                        <option value="Dibatalkan" {{ request('status')=='Dibatalkan'?'selected':'' }}>Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nomor Faktur..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nomor Faktur</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th class="text-end">Total</th>
                            <th>Status</th>
                            <th>Perusahaan</th>
                            <th class="text-center" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fakturPenjualan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $item->nomor_faktur }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>

                            <!-- Pelanggan - Sudah diperbaiki -->
                            <td>
                                @if($item->pelanggan)
                                <strong>{{ $item->pelanggan->nama_pelanggan }}</strong>
                                @else
                                <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>

                            <td class="text-end fw-semibold">
                                Rp {{ number_format($item->total ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($item->status == 'Lunas')
                                <span class="badge bg-success px-3 py-2">Lunas</span>
                                @elseif($item->status == 'Belum Lunas')
                                <span class="badge bg-warning text-dark px-3 py-2">Belum Lunas</span>
                                @else
                                <span class="badge bg-danger px-3 py-2">Dibatalkan</span>
                                @endif
                            </td>

                            <td>{{ $item->perusahaan->nama_perusahaan ?? '-' }}</td>

                            <td class="text-center">
                                <a href="{{ route('faktur-penjualan.show', $item->id_faktur_penjualan) }}"
                                    class="btn btn-info btn-sm me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faktur-penjualan.edit', $item->id_faktur_penjualan) }}"
                                    class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('faktur-penjualan.destroy', $item->id_faktur_penjualan) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus faktur ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                Tidak ada data faktur penjualan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $fakturPenjualan->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>

@endsection
