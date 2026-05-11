@extends('layouts.app')

@section('title', 'Detail Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="bg-primary bg-gradient text-white p-4 p-lg-5">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-25 rounded-3 p-3 me-3">
                            <i class="fas fa-file-invoice fs-3"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Detail Faktur Pembelian</h2>
                            <div class="opacity-75">{{ $fakturPembelian->nomor_faktur }}</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <!-- Print Button -->
                    <a href="{{ route('admin.faktur-pembelian.print', $fakturPembelian) }}" target="_blank"
                        class="btn btn-light shadow-sm">
                        <i class="fas fa-print me-2"></i> Print
                    </a>

                    <!-- Edit Button -->
                    <a href="{{ route('admin.faktur-pembelian.edit', $fakturPembelian) }}"
                        class="btn btn-warning shadow-sm">
                        <i class="fas fa-edit me-2"></i> Edit
                    </a>

                    <!-- Back Button -->
                    <a href="{{ route('admin.faktur-pembelian.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- INFORMASI FAKTUR -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-circle-info text-primary me-2"></i>
                        Informasi Faktur
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">
                                <div class="text-muted small mb-2">Nomor Faktur</div>
                                <div class="fw-bold fs-5">{{ $fakturPembelian->nomor_faktur }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">
                                <div class="text-muted small mb-2">Tanggal</div>
                                <div class="fw-semibold fs-5">
                                    {{ \Carbon\Carbon::parse($fakturPembelian->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">
                                <div class="text-muted small mb-2">Supplier</div>
                                <div class="fw-semibold fs-5">
                                    {{ $fakturPembelian->supplier->nama_supplier ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">
                                <div class="text-muted small mb-2">Perusahaan</div>
                                <div class="fw-semibold fs-5">
                                    {{ $fakturPembelian->perusahaan->nama_perusahaan ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-4 p-4">
                                <div class="text-muted small mb-2">Jurnal</div>
                                <div class="fw-semibold">
                                    @if($fakturPembelian->jurnal)
                                    {{ $fakturPembelian->jurnal->nomor_jurnal }} -
                                    {{ $fakturPembelian->jurnal->keterangan ?? '-' }}
                                    @else
                                    -
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- RINGKASAN -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-0 py-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-wallet text-success me-2"></i>
                        Ringkasan Pembayaran
                    </h5>
                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">Subtotal</span>
                        <strong>Rp {{ number_format($fakturPembelian->subtotal ?? 0, 0, ',', '.') }}</strong>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">PPN</span>
                        <strong>Rp {{ number_format($fakturPembelian->ppn ?? 0, 0, ',', '.') }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Total</h5>
                        <h3 class="fw-bold text-primary mb-0">
                            Rp {{ number_format($fakturPembelian->total ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>

                    <!-- Status -->

                    <div>
                        @switch($fakturPembelian->status)
                        @case('Lunas')
                        <div class="alert alert-success border-0 rounded-4 mb-0">
                            <i class="fas fa-circle-check me-2"></i>
                            Status : <strong>Lunas</strong>
                        </div>
                        @break

                        @case('Belum Lunas')
                        <div class="alert alert-warning border-0 rounded-4 mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Status : <strong>Belum Lunas</strong>
                        </div>
                        @break

                        @default
                        <div class="alert alert-danger border-0 rounded-4 mb-0">
                            <i class="fas fa-circle-xmark me-2"></i>
                            Status : <strong>{{ $fakturPembelian->status ?? 'Dibatalkan' }}</strong>
                        </div>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection