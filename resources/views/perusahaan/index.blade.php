@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h1 class="fw-bold text-dark mb-1">Data Perusahaan</h1>
            <p class="text-muted mb-0 fs-5">
                Kelola seluruh data perusahaan dengan efisien dan profesional
            </p>
        </div>

        <a href="{{ route('perusahaan.create') }}"
            class="btn btn-lg btn-primary shadow d-flex align-items-center gap-2 px-5 py-3"
            style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
            <i data-feather="plus" width="22"></i>
            Tambah Perusahaan
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4 py-3"
        style="background: linear-gradient(135deg, #10b981, #34d399); color: white;">
        <i data-feather="check-circle" width="24"></i>
        <div class="flex-grow-1">{{ session('success') }}</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow rounded-4 overflow-hidden">

        {{-- HEADER --}}
        <div class="card-header border-bottom py-4 px-4"
            style="background: linear-gradient(to right, #f8fafc, #f1f5f9);">

            <h5 class="mb-1 fw-semibold text-dark">Daftar Perusahaan</h5>
            <small class="text-muted">
                Total <strong class="text-primary">{{ $data->total() }}</strong> perusahaan terdaftar
            </small>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead style="background: #f1f5f9;">
                    <tr>
                        <th class="ps-4" width="60">#</th>
                        <th>Perusahaan</th>
                        <th>Email</th>
                        <th>NPWP</th>
                        <th>Kota</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center pe-4" width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $i => $row)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">
                            {{ $data->firstItem() + $i }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">

                                @if($row->logo)
                                <img src="{{ asset('storage/'.$row->logo) }}" class="rounded-3 border" width="50"
                                    height="50" style="object-fit: cover;">
                                @else
                                <div class="rounded-3 d-flex align-items-center justify-content-center border"
                                    style="width:50px;height:50px;background:#e0e7ff;">
                                    <i data-feather="briefcase" width="22"></i>
                                </div>
                                @endif

                                <div>
                                    <div class="fw-semibold text-dark">
                                        {{ $row->nama_perusahaan }}
                                    </div>
                                    <small class="text-muted">
                                        ID: {{ $row->id }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        <td>{{ $row->email ?? '-' }}</td>
                        <td>{{ $row->npwp ?? '-' }}</td>
                        <td>{{ $row->kota ?? '-' }}</td>
                        <td>{{ $row->telepon ?? '-' }}</td>

                        <td>
                            @if($row->status == 'aktif')
                            <span class="badge bg-success">Aktif</span>
                            @elseif($row->status == 'nonaktif' || $row->status == 'inactive')
                            <span class="badge bg-warning text-dark">Nonaktif</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>

                        <td class="text-muted">
                            {{ $row->created_at?->format('d M Y') ?? '-' }}
                        </td>

                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('perusahaan.show', $row) }}" class="btn btn-sm btn-outline-info">
                                    <i data-feather="eye" width="17"></i>
                                </a>

                                <a href="{{ route('perusahaan.edit', $row) }}" class="btn btn-sm btn-outline-primary">
                                    <i data-feather="edit-2" width="17"></i>
                                </a>

                                <form action="{{ route('perusahaan.destroy', $row) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Hapus data ini?')"
                                        class="btn btn-sm btn-outline-danger">
                                        <i data-feather="trash-2" width="17"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <h5>Belum ada data</h5>
                            <a href="{{ route('admin.perusahaan.create') }}" class="btn btn-primary mt-2">
                                Tambah Data
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- FOOTER --}}
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex justify-content-between">
                <small>
                    {{ $data->firstItem() ?? 0 }}–{{ $data->lastItem() ?? 0 }}
                    dari {{ $data->total() }}
                </small>

                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
@endsection