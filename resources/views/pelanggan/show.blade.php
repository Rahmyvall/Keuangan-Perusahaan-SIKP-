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
                            <small class="text-white-50">
                                Limit Kredit
                            </small>

                            <h2 class="fw-bold mb-0 text-white">
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
        width: 1.8,
        height: 45,
        displayValue: true,
        fontSize: 12,
        margin: 4,
        lineColor: "#111827"
    });

});
</script>

<style>
/* =========================
   A4 PAPER UI
========================= */

body {
    background: #e5e7eb;
    font-family: 'Inter', sans-serif;
}

/* Kertas A4 */
.a4-paper {
    width: 210mm;
    min-height: 297mm;
    margin: 30px auto;
    background: white;
    padding: 18mm;
    box-shadow:
        0 0 0 1px rgba(0, 0, 0, .05),
        0 10px 30px rgba(0, 0, 0, .12);
    border-radius: 10px;
    overflow: hidden;
}

/* Header */
.customer-card {
    overflow: hidden;
    position: relative;
}

.customer-card::before {
    content: '';
    position: absolute;
    inset: 0 0 auto 0;
    height: 120px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

/* Avatar */
.customer-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    color: #2563eb;
    position: relative;
    z-index: 2;
    margin-top: 25px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
}

/* Card */
.card {
    border: none;
    border-radius: 24px;
    overflow: hidden;
}

/* Info Box */
.info-box {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px;
    background: #f8fafc;
    border-radius: 14px;
}

.info-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

/* Credit */
.credit-box {
    background: linear-gradient(135deg, #16a34a, #15803d);
    border-radius: 22px;
    padding: 26px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    box-shadow: 0 12px 30px rgba(22, 163, 74, .20);
}

.credit-icon {
    font-size: 52px;
    opacity: .18;
}

/* Address */
.address-box {
    background: #f8fafc;
    border-radius: 18px;
    padding: 22px;
    line-height: 1.8;
    color: #374151;
}

/* Barcode */
.barcode-wrapper {
    border-top: 1px dashed #d1d5db;
    padding-top: 35px;
}

.barcode-box {
    display: inline-block;
    background: white;
    padding: 22px;
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
}

/* =========================
   PRINT MODE
========================= */

@media print {

    @page {
        size: A4 portrait;
        margin: 5mm;
    }

    html,
    body {
        width: 210mm;
        height: 297mm;
        overflow: hidden !important;
        background: #fff !important;
        font-size: 10px !important;
    }

    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        box-sizing: border-box !important;
    }

    /* hide */
    .no-print,
    .btn,
    nav,
    footer {
        display: none !important;
    }

    /* paper */
    .a4-paper {
        width: 100% !important;
        min-height: auto !important;
        height: auto !important;
        margin: 0 !important;
        padding: 8mm !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    .container-fluid {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* layout */
    .row {
        display: flex !important;
        flex-wrap: nowrap !important;
        gap: 8px !important;
        --bs-gutter-x: 0 !important;
        --bs-gutter-y: 0 !important;
    }

    .col-lg-4 {
        width: 32% !important;
        flex: 0 0 32% !important;
    }

    .col-lg-8 {
        width: 68% !important;
        flex: 0 0 68% !important;
    }

    /* card */
    .card {
        border: 1px solid #d1d5db !important;
        border-radius: 10px !important;
        box-shadow: none !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .card-body {
        padding: 10px !important;
    }

    /* top blue */
    .customer-card::before {
        height: 55px !important;
    }

    /* avatar */
    .customer-avatar {
        width: 52px !important;
        height: 52px !important;
        font-size: 18px !important;
        margin-top: 8px !important;
        box-shadow: none !important;
    }

    /* text */
    h2 {
        font-size: 16px !important;
        margin-bottom: 2px !important;
    }

    h3 {
        font-size: 13px !important;
        margin-bottom: 2px !important;
    }

    h5 {
        font-size: 11px !important;
        margin-bottom: 4px !important;
    }

    p,
    span,
    small,
    div {
        font-size: 9.5px !important;
        line-height: 1.3 !important;
    }

    hr {
        margin: 8px 0 !important;
    }

    /* info box */
    .info-box {
        padding: 6px !important;
        gap: 6px !important;
        border-radius: 8px !important;
    }

    .info-icon {
        width: 26px !important;
        height: 26px !important;
        font-size: 10px !important;
        border-radius: 6px !important;
    }

    /* credit */
    .credit-box {
        padding: 10px !important;
        border-radius: 10px !important;
        box-shadow: none !important;
    }

    .credit-box h2 {
        font-size: 16px !important;
    }

    .credit-icon {
        font-size: 24px !important;
    }

    /* address */
    .address-box {
        padding: 10px !important;
        border-radius: 8px !important;
        line-height: 1.4 !important;
    }

    /* barcode */
    .barcode-wrapper {
        padding-top: 10px !important;
    }

    .barcode-box {
        padding: 6px 10px !important;
        border-radius: 8px !important;
        box-shadow: none !important;
    }

    #barcode {
        width: 160px !important;
        height: 35px !important;
    }

    /* spacing */
    .mb-5 {
        margin-bottom: .7rem !important;
    }

    .mb-4 {
        margin-bottom: .5rem !important;
    }

    .mb-3 {
        margin-bottom: .4rem !important;
    }

    .p-4,
    .p-lg-5 {
        padding: 10px !important;
    }
}

/* =========================
   MOBILE
========================= */

@media(max-width:768px) {

    .a4-paper {
        width: 100%;
        min-height: auto;
        padding: 16px;
        margin: 0;
        border-radius: 0;
    }

    .credit-box {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .credit-icon {
        display: none;
    }
}
</style>

@endsection
