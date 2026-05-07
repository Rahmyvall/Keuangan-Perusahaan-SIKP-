@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Daftar Pelanggan</h1>

        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pelanggan
        </a>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('pelanggan.index') }}" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Perusahaan</label>
                    <select name="id_perusahaan" class="form-select">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaan as $p)
                        <option value="{{ $p->id_perusahaan }}"
                            {{ request('id_perusahaan') == $p->id_perusahaan ? 'selected' : '' }}>
                            {{ $p->nama_perusahaan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cari Pelanggan</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Kode, Nama, Telepon, atau Email" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Perusahaan</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Limit Kredit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $p)
                    <tr>
                        <td>{{ $loop->iteration + ($pelanggan->firstItem() - 1) }}</td>
                        <td><strong class="font-monospace">{{ $p->kode_pelanggan }}</strong></td>
                        <td>
                            <div class="fw-bold">{{ $p->nama_pelanggan }}</div>
                            @if($p->alamat)
                            <small class="text-muted">{{ Str::limit($p->alamat, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                {{ optional($p->perusahaan)->nama_perusahaan ?? '-' }}
                            </span>
                        </td>
                        <td>{{ $p->telepon ?? '-' }}</td>
                        <td>{{ $p->email ?? '-' }}</td>
                        <td class="text-end fw-semibold text-success">
                            Rp {{ number_format($p->limit_kredit, 0, ',', '.') }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pelanggan.show', $p) }}" class="btn btn-info text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-users fa-2x text-muted mb-3"></i><br>
                            Belum ada data pelanggan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <!-- PAGINATION - SUDAH DIOPTIMASI -->
        <div class="card-footer">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                <!-- Info Data -->
                <div class="text-muted">
                    Menampilkan <strong>{{ $pelanggan->firstItem() }}</strong> -
                    <strong>{{ $pelanggan->lastItem() }}</strong>
                    dari total <strong>{{ $pelanggan->total() }}</strong> data
                </div>

                <!-- Pagination Links -->
                <div>
                    {{ $pelanggan->onEachSide(2)->links() }}
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
