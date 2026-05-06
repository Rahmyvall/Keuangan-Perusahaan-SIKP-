@extends('layouts.app')

@section('title', 'Manajemen Periode')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold">Manajemen Periode</h1>
            <p class="text-muted mb-0">Kelola periode akuntansi / pelaporan perusahaan</p>
        </div>
        <a href="{{ route('periode.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Periode Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $periode->total() ?? 0 }}</h5>
                            <small class="text-muted">Total Periode</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-lock-open fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 text-success">{{ $periode->where('status', 'Terbuka')->count() }}</h5>
                            <small class="text-muted">Sedang Terbuka</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-lock fa-2x text-danger"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 text-danger">{{ $periode->where('status', 'Ditutup')->count() }}</h5>
                            <small class="text-muted">Sudah Ditutup</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-key fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0 text-warning">{{ $periode->where('status', 'Dikunci')->count() }}</h5>
                            <small class="text-muted">Dikunci</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Search & Filter -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('periode.index') }}" class="row g-3 align-items-end">

                <!-- Search Input dengan Icon -->
                <div class="col-lg-5">
                    <label class="form-label fw-semibold text-muted">🔍 Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Cari tahun, bulan, atau nama perusahaan..." value="{{ request('search') }}">
                        @if(request('search'))
                        <a href="{{ route('periode.index') }}" class="input-group-text bg-white text-danger">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Status -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold text-muted">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Terbuka" {{ request('status') == 'Terbuka' ? 'selected' : '' }}>✅ Terbuka
                        </option>
                        <option value="Ditutup" {{ request('status') == 'Ditutup' ? 'selected' : '' }}>🔒 Ditutup
                        </option>
                        <option value="Dikunci" {{ request('status') == 'Dikunci' ? 'selected' : '' }}>🔐 Dikunci
                        </option>
                    </select>
                </div>

                <!-- Perusahaan -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold text-muted">Perusahaan</label>
                    <select name="id_perusahaan" class="form-select">
                        <option value="">Semua Perusahaan</option>
                        @foreach(App\Models\Perusahaan::orderBy('nama_perusahaan')->get() as $p)
                        <option value="{{ $p->id_perusahaan }}"
                            {{ request('id_perusahaan') == $p->id_perusahaan ? 'selected' : '' }}>
                            {{ $p->nama_perusahaan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-lg-1 col-md-6">
                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table (sama seperti sebelumnya) -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Perusahaan</th>
                            <th>Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periode as $p)
                        <tr>
                            <td><strong>{{ $p->perusahaan->nama_perusahaan ?? '—' }}</strong></td>
                            <td>
                                <div class="fw-semibold">{{ $p->label }}</div>
                                <small class="text-muted">{{ $p->nama_bulan }} {{ $p->tahun }}</small>
                            </td>
                            <td>{{ $p->tanggal_awal->format('d M Y') }}</td>
                            <td>{{ $p->tanggal_akhir->format('d M Y') }}</td>
                            <td>{!! $p->status_badge !!}</td>
                            <td class="text-center pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('periode.show', $p) }}" class="btn btn-sm btn-outline-info"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('periode.edit', $p) }}" class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('periode.destroy', $p) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-times fa-3x mb-3"></i><br>
                                <strong>Tidak ada data periode</strong>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-transparent">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $periode->firstItem() ?? 0 }} - {{ $periode->lastItem() ?? 0 }}
                    dari {{ $periode->total() }} data
                </small>
                {{ $periode->links() }}
            </div>
        </div>
    </div>
</div>
@endsection