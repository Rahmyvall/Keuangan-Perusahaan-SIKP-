@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="header-icon bg-primary text-white d-flex align-items-center justify-content-center rounded-3"
                style="width:60px; height:60px;">
                <i data-feather="credit-card"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-1 text-dark">Pembayaran Hutang</h2>
                <p class="text-muted mb-0">Monitoring pembayaran hutang perusahaan</p>
            </div>
        </div>
        <a href="{{ route('pembayaran-hutang.create') }}" class="btn btn-primary px-4 d-flex align-items-center gap-2">
            <i data-feather="plus"></i> Tambah Pembayaran
        </a>
    </div>

    {{-- STATISTICS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Transaksi</small>
                        <h4 class="fw-bold mb-0">{{ $data->total() }}</h4>
                    </div>
                    <div class="bg-primary text-white p-2 rounded">
                        <i data-feather="database"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Nominal</small>
                        <h4 class="fw-bold mb-0 text-success">Rp {{ number_format($data->sum('jumlah'),0,',','.') }}
                        </h4>
                    </div>
                    <div class="bg-success text-white p-2 rounded">
                        <i data-feather="dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Tanggal Hari Ini</small>
                        <h4 class="fw-bold mb-0">{{ now()->format('d M Y') }}</h4>
                    </div>
                    <div class="bg-warning text-white p-2 rounded">
                        <i data-feather="calendar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success d-flex align-items-center mb-4">
        <i data-feather="check-circle" class="me-2"></i> {{ session('success') }}
    </div>
    @endif

    {{-- FILTER --}}
    <div class="card shadow-sm mb-4 p-3">
        <form method="GET" class="row g-3 align-items-center">
            <div class="col-lg-5 position-relative">
                <i data-feather="search" class="position-absolute"
                    style="top:50%; left:10px; transform: translateY(-50%); color:#94a3b8;"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control ps-5"
                    placeholder="Cari nomor pembayaran...">
            </div>
            <div class="col-lg-3">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-auto d-flex gap-2">
                <button class="btn btn-primary px-4">Filter</button>
                <a href="{{ route('pembayaran-hutang.index') }}" class="btn btn-light px-4">Reset</a>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Faktur</th>
                        <th>Jurnal</th>
                        <th>Perusahaan</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                    <tr>
                        <td>{{ $data->firstItem() + $i }}</td>
                        <td><a href="{{ route('pembayaran-hutang.show', $row->id_pembayaran) }}"
                                class="text-primary fw-bold">{{ $row->nomor_pembayaran }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                        <td>{{ $row->fakturPembelian->nomor_faktur ?? '-' }}</td>
                        <td>{{ $row->jurnal->nomor_jurnal ?? '-' }}</td>
                        <td>{{ $row->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td class="text-end"><span class="badge bg-success">Rp
                                {{ number_format($row->jumlah,0,',','.') }}</span></td>
                        <td class="text-center d-flex justify-content-center gap-2">
                            <a href="{{ route('pembayaran-hutang.edit',$row->id_pembayaran) }}"
                                class="btn btn-sm btn-warning p-2">
                                <i data-feather="edit-2"></i>
                            </a>
                            <form action="{{ route('pembayaran-hutang.destroy',$row->id_pembayaran) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger p-2"><i
                                        data-feather="trash-2"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i data-feather="inbox" class="mb-2" style="font-size:32px;"></i>
                                <p class="mb-0 fw-bold">Belum Ada Data</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center p-3">
            <small class="text-muted">Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari
                {{ $data->total() }} data</small>
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection