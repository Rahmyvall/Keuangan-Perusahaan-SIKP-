@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid py-3">

    <!-- Header Mobile Friendly -->
    <div
        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 no-print gap-3">
        <div>
            <h1 class="h3 mb-1">Detail Pelanggan</h1>
            <p class="text-muted mb-0">Informasi lengkap pelanggan</p>
        </div>

        <div class="btn-group w-100 w-sm-auto">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary flex-grow-1 flex-sm-grow-0">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-info text-white flex-grow-1 flex-sm-grow-0">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-warning flex-grow-1 flex-sm-grow-0">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-12 col-lg-12">

            <div class="card shadow border-0">
                <!-- Header Card -->
                <div class="card-header bg-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h4 class="mb-1">{{ $pelanggan->nama_pelanggan }}</h4>
                            <h5 class="text-primary font-monospace mb-0">{{ $pelanggan->kode_pelanggan }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-sm-5">

                    <div class="row g-4">
                        <div class="col-6">
                            <label class="text-muted small">Perusahaan</label>
                            <p class="fw-semibold">{{ optional($pelanggan->perusahaan)->nama_perusahaan ?? '-' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Limit Kredit</label>
                            <p class="fs-5 fw-bold text-success">
                                Rp {{ number_format($pelanggan->limit_kredit, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Telepon</label>
                            <p class="mb-0">{{ $pelanggan->telepon ?? '<span class="text-muted">—</span>' }}</p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small">Email</label>
                            <p class="mb-0">{{ $pelanggan->email ?? '<span class="text-muted">—</span>' }}</p>
                        </div>
                    </div>

                    @if($pelanggan->alamat)
                    <hr>
                    <label class="text-muted small">Alamat Lengkap</label>
                    <p class="mb-0">{{ $pelanggan->alamat }}</p>
                    @endif

                    <!-- Barcode -->
                    <hr class="my-5">
                    <div class="text-center">
                        <label class="text-muted small d-block mb-3">Barcode Kode Pelanggan</label>
                        <svg id="barcode" class="mx-auto"></svg>
                        <small class="text-muted d-block mt-2">{{ $pelanggan->kode_pelanggan }}</small>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- JsBarcode -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    JsBarcode("#barcode", "{{ $pelanggan->kode_pelanggan }}", {
        format: "CODE128",
        lineColor: "#1e3a8a",
        width: 2.8,
        height: 85,
        displayValue: true,
        fontSize: 15,
        margin: 10
    });
});
</script>

<!-- Print & Mobile Styles -->
<style>
@media print {

    .no-print,
    .btn,
    nav,
    footer {
        display: none !important;
    }

    body {
        background: white !important;
        font-family: Arial, Helvetica, sans-serif;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }

    @page {
        margin: 1.5cm;
        size: A4;
    }
}

/* Mobile Optimization */
@media (max-width: 576px) {
    .card-body {
        padding: 1.25rem !important;
    }

    h4 {
        font-size: 1.35rem !important;
    }

    .btn-group .btn {
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }
}
</style>

@endsection