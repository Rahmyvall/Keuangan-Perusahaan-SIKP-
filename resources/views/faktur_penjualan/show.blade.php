{{-- resources/views/faktur_penjualan/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Faktur - ' . $fakturPenjualan->nomor_faktur)

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-file-invoice text-primary me-2"></i>
                Detail Faktur Penjualan
            </h3>
            <h4 class="text-muted">{{ $fakturPenjualan->nomor_faktur }}</h4>
        </div>

        <div class="btn-group">
            <a href="{{ route('faktur-penjualan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <a href="{{ route('faktur-penjualan.edit', $fakturPenjualan->id_faktur_penjualan) }}"
                class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <button onclick="window.print()" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak Faktur
            </button>

            <form action="{{ route('faktur-penjualan.destroy', $fakturPenjualan->id_faktur_penjualan) }}" method="POST"
                class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus faktur ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <!-- Invoice Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Faktur</h5>
                        <span class="badge fs-6 px-4 py-2
                            {{ $fakturPenjualan->status == 'Lunas' ? 'bg-success' :
                               ($fakturPenjualan->status == 'Belum Lunas' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $fakturPenjualan->status }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">

                        <!-- Left Column -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="140" class="text-muted">Nomor Faktur</th>
                                    <td class="fw-bold">{{ $fakturPenjualan->nomor_faktur }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($fakturPenjualan->tanggal)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Perusahaan</th>
                                    <td>{{ $fakturPenjualan->perusahaan->nama_perusahaan ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="140" class="text-muted">Pelanggan</th>
                                    <td class="fw-bold">{{ $fakturPenjualan->pelanggan->nama_pelanggan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Jurnal</th>
                                    <td>
                                        @if($fakturPenjualan->jurnal)
                                        {{ $fakturPenjualan->jurnal->nomor_jurnal ?? '#' . $fakturPenjualan->jurnal->id_jurnal }}
                                        - {{ Str::limit($fakturPenjualan->jurnal->keterangan, 80) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Ringkasan Pembayaran -->
                    <h5 class="mb-3">Ringkasan Pembayaran</h5>
                    <div class="bg-light p-4 rounded border">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="200">Subtotal</th>
                                <td class="text-end">Rp {{ number_format($fakturPenjualan->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th>PPN</th>
                                <td class="text-end">Rp {{ number_format($fakturPenjualan->ppn ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="border-top border-2 border-primary">
                                <th class="fs-5">Total Tagihan</th>
                                <td class="text-end fs-4 fw-bold text-primary">
                                    Rp {{ number_format($fakturPenjualan->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Status -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center py-5">
                    <i class="fas fa-file-invoice-dollar fa-7x text-primary opacity-10 mb-4"></i>
                    <h4>Status Faktur</h4>
                    <h2 class="mt-3 mb-0">
                        @if($fakturPenjualan->status == 'Lunas')
                        <span class="text-success">LUNAS</span>
                        @elseif($fakturPenjualan->status == 'Belum Lunas')
                        <span class="text-warning">BELUM LUNAS</span>
                        @else
                        <span class="text-danger">DIBATALKAN</span>
                        @endif
                    </h2>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Print functionality
function printFaktur() {
    window.print();
}
</script>

<style>
@media print {

    .navbar,
    .sidebar,
    .btn-group,
    footer,
    .card-header .btn {
        display: none !important;
    }

    .container-fluid {
        padding: 20px !important;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endpush
