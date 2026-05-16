{{-- resources/views/aset-tetap/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Aset Tetap')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0 fw-semibold">
                <i class="fas fa-building me-2 text-primary"></i> Aset Tetap
            </h3>
            <p class="text-muted mb-0">Daftar semua data aset tetap</p>
        </div>

        <a href="{{ route('aset-tetap.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Aset
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
                    <label class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-5">
                    <label class="form-label">Cari</label>

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Kode / Nama Aset..."
                            value="{{ request('search') }}">

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
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
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Akun Aset</th>
                            <th>Tanggal Pengadaan</th>
                            <th class="text-end">Nilai Perolehan</th>
                            <th class="text-center">Masa Manfaat</th>
                            <th class="text-end">Nilai Sisa</th>
                            <th>Perusahaan</th>
                            <th class="text-center" width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($asetTetap as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $item->kode_aset }}
                            </td>

                            <td>
                                {{ $item->nama_aset }}
                            </td>

                            <td>
                                @if($item->akunAset)
                                <strong>{{ $item->akunAset->kode_akun }}</strong>
                                - {{ $item->akunAset->nama_akun }}
                                @else
                                <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_pengadaan)->format('d M Y') }}
                            </td>

                            <td class="text-end fw-semibold">
                                Rp {{ number_format($item->nilai_perolehan, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                {{ $item->masa_manfaat }} Tahun
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($item->nilai_sisa, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $item->perusahaan->nama_perusahaan ?? '-' }}
                            </td>

                            <td class="text-center">

                                <a href="{{ route('aset-tetap.show', $item->id_aset) }}"
                                    class="btn btn-info btn-sm me-1">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('aset-tetap.edit', $item->id_aset) }}"
                                    class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('aset-tetap.destroy', $item->id_aset) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus aset tetap ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                Tidak ada data aset tetap
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $asetTetap->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection