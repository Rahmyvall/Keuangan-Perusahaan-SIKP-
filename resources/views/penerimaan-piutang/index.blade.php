@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow">
        <div>
            <h3 class="mb-1 fw-bold text-dark">
                <i data-feather="download" class="me-2 text-primary"></i>
                Penerimaan Piutang
            </h3>
            <p class="text-muted mb-0">Manajemen & Monitoring Penerimaan Piutang</p>
        </div>

        <a href="{{ route('penerimaan-piutang.create') }}" class="btn btn-primary btn-lg px-4 rounded-3 shadow-sm">
            <i data-feather="plus" class="me-2"></i> Tambah Penerimaan Baru
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        <i data-feather="check-circle" class="me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="card-body p-4">

            {{-- FILTER BAR --}}
            <div class="row g-3 mb-4 align-items-end">
                <div class="col-md-5">
                    <form method="GET" class="d-flex gap-2">
                        <div class="flex-grow-1">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari nomor penerimaan...">
                        </div>
                        <div>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="search"></i>
                        </button>
                        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </form>
                </div>

                <div class="col-md-7 text-md-end">
                    <small class="text-muted">Total Data: <strong>{{ $data->total() }}</strong></small>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="text-center">#</th>
                            <th>Nomor Penerimaan</th>
                            <th>Tanggal</th>
                            <th>Faktur Penjualan</th>
                            <th>Perusahaan</th>
                            <th class="text-end">Jumlah</th>
                            <th width="140" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $row)
                        <tr class="align-middle">
                            <td class="text-center fw-medium">{{ $data->firstItem() + $i }}</td>

                            <td>
                                <span class="fw-bold text-primary">{{ $row->nomor_penerimaan }}</span>
                            </td>

                            <td>
                                <i data-feather="calendar" class="me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                            </td>

                            <td>
                                <strong>{{ $row->fakturPenjualan->nomor_faktur ?? '-' }}</strong>
                                <small class="text-muted d-block">#{{ $row->id_faktur_penjualan }}</small>
                            </td>

                            <td class="fw-medium">
                                {{ $row->perusahaan->nama_perusahaan ?? '—' }}
                            </td>

                            <td class="text-end fw-bold text-success fs-5">
                                Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('penerimaan-piutang.show', $row->id_penerimaan) }}"
                                        class="btn btn-sm btn-light border" title="Lihat Detail">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a href="{{ route('penerimaan-piutang.edit', $row->id_penerimaan) }}"
                                        class="btn btn-sm btn-light border" title="Edit">
                                        <i data-feather="edit-2"></i>
                                    </a>
                                    <form action="{{ route('penerimaan-piutang.destroy', $row->id_penerimaan) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border text-danger"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus penerimaan ini?')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i data-feather="inbox" style="width: 60px; height: 60px;" class="text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data penerimaan piutang</h5>
                                <p class="text-muted">Silakan tambahkan data baru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }}
                        dari total {{ $data->total() }} data
                    </small>
                </div>
                <div>
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
