@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                        <i data-feather="credit-card"></i>
                    </div>

                    <div>
                        <h3 class="fw-bold mb-0">Penerimaan Piutang</h3>
                        <small class="text-muted">
                            Monitoring transaksi penerimaan pembayaran pelanggan
                        </small>
                    </div>
                </div>
            </div>

            <a href="{{ route('penerimaan-piutang.create') }}" class="btn btn-primary rounded-3 px-4 py-2 shadow-sm">
                <i data-feather="plus" class="me-2"></i>
                Tambah Data
            </a>

        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <small class="text-muted">Total Transaksi</small>
                    <h2 class="fw-bold mb-0">{{ $data->total() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <small class="text-muted">Total Nominal</small>
                    <h2 class="fw-bold text-success mb-0">
                        Rp {{ number_format($data->sum('jumlah'),0,',','.') }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <small class="text-muted">Hari Ini</small>
                    <h2 class="fw-bold text-primary mb-0">
                        {{ now()->format('d M Y') }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        <div class="d-flex align-items-center">
            <i data-feather="check-circle" class="me-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- MAIN TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4">

        {{-- FILTER --}}
        <div class="card-body border-bottom">

            <form method="GET">
                <div class="row g-3 align-items-center">

                    <div class="col-md-4">
                        <div class="position-relative">
                            <i data-feather="search"
                                class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control ps-5 rounded-3 border-0 bg-light"
                                placeholder="Cari nomor penerimaan...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="form-control rounded-3 border-0 bg-light">
                    </div>

                    <div class="col-md-auto">
                        <button class="btn btn-primary rounded-3 px-4">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-auto">
                        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light rounded-3 px-4">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">No</th>
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
                    <tr class="table-row">

                        <td class="ps-4 fw-semibold">
                            {{ $data->firstItem() + $i }}
                        </td>

                        <td>
                            <div class="fw-bold text-primary">
                                {{ $row->nomor_penerimaan }}
                            </div>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $row->fakturPenjualan->nomor_faktur ?? '-' }}
                            </div>

                            <small class="text-muted">
                                #{{ $row->id_faktur_penjualan }}
                            </small>
                        </td>

                        <td>
                            {{ $row->perusahaan->nama_perusahaan ?? '-' }}
                        </td>

                        <td class="text-end">
                            <span class="fw-bold text-success fs-6">
                                Rp {{ number_format($row->jumlah,0,',','.') }}
                            </span>
                        </td>

                        <td class="text-center pe-4">

                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('penerimaan-piutang.show',$row->id_penerimaan) }}"
                                    class="btn btn-light btn-sm rounded-circle shadow-sm">
                                    <i data-feather="eye"></i>
                                </a>

                                <a href="{{ route('penerimaan-piutang.edit',$row->id_penerimaan) }}"
                                    class="btn btn-warning btn-sm rounded-circle shadow-sm text-white">
                                    <i data-feather="edit-2"></i>
                                </a>

                                <form action="{{ route('penerimaan-piutang.destroy',$row->id_penerimaan) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Yakin hapus data?')"
                                        class="btn btn-danger btn-sm rounded-circle shadow-sm">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-5">

                            <div class="py-5">
                                <i data-feather="inbox" style="width:70px;height:70px" class="text-muted mb-3"></i>

                                <h5 class="fw-bold">
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
        <div class="card-body border-top d-flex justify-content-between align-items-center flex-wrap gap-3">

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

<style>
body {
    background: #f4f7fb;
}

.table-row {
    transition: all .2s ease;
}

.table-row:hover {
    background: #f8fbff;
    transform: scale(1.002);
}

.card {
    backdrop-filter: blur(10px);
}

.btn {
    transition: .2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.table th {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6c757d;
}
</style>
@endsection