@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4 no-print">

        <div>
            <h2 class="fw-bold mb-1 text-dark">
                Detail Pelanggan
            </h2>
            <p class="text-muted mb-0">
                Informasi lengkap data pelanggan
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-light border shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>

            <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-warning shadow-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>

            <button onclick="window.print()" class="btn btn-primary shadow-sm">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
        </div>
    </div>

    <div class="row g-4">

        <!-- Profile Card -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-lg h-100 customer-card">

                <div class="card-body text-center p-4">

                    <div class="customer-avatar mx-auto mb-3">
                        <i class="fas fa-user"></i>
                    </div>

                    <h3 class="fw-bold mb-1">
                        {{ $pelanggan->nama_pelanggan }}
                    </h3>

                    <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fs-6">
                        {{ $pelanggan->kode_pelanggan }}
                    </div>

                    <hr class="my-4">

                    <div class="row g-3 text-start">

                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-icon bg-success-subtle text-success">
                                    <i class="fas fa-building"></i>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Perusahaan
                                    </small>

                                    <span class="fw-semibold">
                                        {{ optional($pelanggan->perusahaan)->nama_perusahaan ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-icon bg-info-subtle text-info">
                                    <i class="fas fa-phone"></i>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Telepon
                                    </small>

                                    <span class="fw-semibold">
                                        {{ $pelanggan->telepon ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-box">
                                <div class="info-icon bg-warning-subtle text-warning">
                                    <i class="fas fa-envelope"></i>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Email
                                    </small>

                                    <span class="fw-semibold">
                                        {{ $pelanggan->email ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <!-- Detail Card -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-lg h-100">

                <div class="card-body p-4 p-lg-5">

                    <!-- Kredit -->
                    <div class="credit-box mb-4">

                        <div>
                            <small class="text-muted">
                                Limit Kredit
                            </small>

                            <h2 class="fw-bold text-success mb-0">
                                Rp {{ number_format($pelanggan->limit_kredit, 0, ',', '.') }}
                            </h2>
                        </div>

                        <div class="credit-icon">
                            <i class="fas fa-wallet"></i>
                        </div>

                    </div>

                    <!-- Alamat -->
                    <div class="mb-5">

                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            Alamat Lengkap
                        </h5>

                        <div class="address-box">
                            {{ $pelanggan->alamat ?: 'Alamat belum tersedia' }}
                        </div>

                    </div>

                    <!-- Barcode -->
                    <div class="barcode-wrapper text-center">

                        <small class="text-uppercase text-muted fw-semibold d-block mb-3">
                            Barcode Pelanggan
                        </small>

                        <div class="barcode-box">
                            <svg id="barcode"></svg>
                        </div>

                        <div class="mt-3">
                            <span class="badge bg-dark px-3 py-2">
                                {{ $pelanggan->kode_pelanggan }}
                            </span>
                        </div>

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
        width: 2.5,
        height: 80,
        displayValue: true,
        fontSize: 16,
        margin: 10,
        lineColor: "#111827"
    });

});
</script>

<style>
body {
    background: #f5f7fb;
}

/* Card */
.customer-card {
    overflow: hidden;
    position: relative;
}

.customer-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
}

/* Avatar */
.customer-avatar {
    width: 95px;
    height: 95px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    color: #2563eb;
    position: relative;
    z-index: 2;
    margin-top: 30px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
}

/* Info Box */
.info-box {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px;
    border-radius: 14px;
    background: #f8fafc;
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

/* Credit */
.credit-box {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: white;
    padding: 28px;
    border-radius: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 12px 30px rgba(22, 163, 74, .25);
}

.credit-icon {
    font-size: 48px;
    opacity: .25;
}

/* Address */
.address-box {
    background: #f8fafc;
    border-radius: 18px;
    padding: 20px;
    line-height: 1.8;
    color: #374151;
}

/* Barcode */
.barcode-wrapper {
    border-top: 1px dashed #d1d5db;
    padding-top: 40px;
}

.barcode-box {
    background: white;
    padding: 25px;
    border-radius: 20px;
    display: inline-block;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
}

/* Print */
@media print {

    .no-print,
    .btn,
    nav,
    footer {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    @page {
        size: A4;
        margin: 1cm;
    }
}

/* Mobile */
@media(max-width:768px) {

    .customer-avatar {
        width: 80px;
        height: 80px;
        font-size: 30px;
    }

    .credit-box {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .credit-icon {
        display: none;
    }

    h2 {
        font-size: 1.5rem;
    }
}
</style>

@endsection
