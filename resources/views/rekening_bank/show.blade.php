@extends('layouts.app')

@section('content')

<style>
/* =========================
   PAGE STYLE
========================= */

body {
    background: #f1f5f9;
    font-family: Arial, Helvetica, sans-serif;
}

.page-wrapper {
    min-height: 100vh;
}

/* =========================
   HEADER BUTTON
========================= */

.btn-custom {
    border-radius: 12px;
    padding: 11px 24px;
    font-weight: 600;
}

/* =========================
   CARD STYLE
========================= */

.passbook-card {
    background: white;
    border: none;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(0, 0, 0, .08);
}

/* =========================
   TOP HEADER
========================= */

.passbook-header {
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
    padding: 50px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.passbook-header::before {
    content: '';
    position: absolute;
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, .06);
    border-radius: 50%;
    top: -100px;
    right: -80px;
}

.passbook-header::after {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, .05);
    border-radius: 50%;
    bottom: -70px;
    left: -50px;
}

.passbook-content {
    position: relative;
    z-index: 2;
}

.bank-icon {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .15);

    display: flex;
    align-items: center;
    justify-content: center;

    margin: auto;
    backdrop-filter: blur(10px);
}

.bank-icon i {
    font-size: 48px;
    color: white;
}

.bank-name {
    font-size: 34px;
    color: white;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 18px;
}

.bank-number {
    display: inline-block;
    background: white;
    color: #111827;
    padding: 14px 35px;
    border-radius: 50px;
    font-size: 24px;
    font-weight: bold;
    letter-spacing: 4px;
    border: 2px solid rgba(255, 255, 255, .3);
}

/* =========================
   DETAIL SECTION
========================= */

.detail-section {
    padding: 40px;
}

.detail-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    transition: .3s;
    height: 100%;
}

.detail-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
}

.detail-label {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    font-weight: 700;
}

.detail-value {
    font-size: 22px;
    color: #111827;
    font-weight: bold;
}

.saldo-value {
    font-size: 28px;
    color: #16a34a;
    font-weight: 800;
}

/* =========================
   PRINT STYLE
========================= */

@media print {

    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    /* hide admin */
    aside,
    nav,
    header,
    footer,
    .sidebar,
    .navbar,
    .main-sidebar,
    .main-header,
    .main-footer,
    .topbar,
    .no-print {
        display: none !important;
    }

    html,
    body {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .container,
    .container-fluid,
    .content-wrapper,
    .main-content,
    main {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .page-wrapper {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* =========================
       CARD PRINT
    ========================= */

    .passbook-card {
        border: 2px solid #111827 !important;
        border-radius: 18px !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    /* =========================
       HEADER PRINT
    ========================= */

    .passbook-header {
        background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
        padding: 30px 20px !important;
        border-bottom: 3px solid #111827 !important;
    }

    .bank-icon {
        display: none !important;
    }

    .bank-name {
        font-size: 28px !important;
        margin-bottom: 15px !important;
        color: white !important;
    }

    .bank-number {
        font-size: 22px !important;
        padding: 12px 28px !important;
        letter-spacing: 3px !important;
        border: 2px solid #111827 !important;
    }

    /* =========================
       DETAIL PRINT
    ========================= */

    .detail-section {
        padding: 20px !important;
    }

    .row {
        display: block !important;
    }

    .col-md-6 {
        width: 100% !important;
        margin-bottom: 14px !important;
        padding: 0 !important;
    }

    .detail-box {
        background: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 14px !important;
        box-shadow: none !important;
        padding: 18px !important;
        page-break-inside: avoid;
    }

    .detail-label {
        font-size: 11px !important;
        margin-bottom: 6px !important;
    }

    .detail-value {
        font-size: 18px !important;
        color: black !important;
    }

    .saldo-value {
        font-size: 22px !important;
        color: #16a34a !important;
    }

    /* =========================
       FOOTER PRINT
    ========================= */

    .print-footer {
        text-align: center;
        font-size: 12px;
        color: #6b7280;
        margin-top: 20px;
        border-top: 1px solid #cbd5e1;
        padding-top: 10px;
    }

}
</style>

<div class="container-fluid py-4 page-wrapper">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-bank2 text-primary me-2"></i>

                Detail Rekening Bank

            </h2>

            <p class="text-muted mb-0">

                Informasi lengkap rekening bank perusahaan

            </p>

        </div>

        <div class="d-flex gap-2 mt-3 mt-md-0">

            {{-- PRINT --}}
            <button onclick="window.print()" class="btn btn-dark shadow-sm btn-custom">

                <i class="bi bi-printer-fill me-1"></i>
                Print

            </button>

            {{-- BACK --}}
            <a href="{{ route('rekening-bank.index') }}" class="btn btn-light border shadow-sm btn-custom">

                <i class="bi bi-arrow-left me-1"></i>
                Kembali

            </a>

        </div>

    </div>

    {{-- CARD --}}
    <div class="card passbook-card">

        {{-- TOP --}}
        <div class="passbook-header">

            <div class="passbook-content">

                <div class="bank-icon">

                    <i class="bi bi-bank2"></i>

                </div>

                <div class="bank-name">

                    {{ $rekeningBank->nama_bank }}

                </div>

                <div class="bank-number">

                    {{ $rekeningBank->nomor_rekening }}

                </div>

            </div>

        </div>

        {{-- DETAIL --}}
        <div class="detail-section">

            <div class="row g-4">

                {{-- NAMA BANK --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Nama Bank
                        </div>

                        <div class="detail-value">

                            {{ $rekeningBank->nama_bank }}

                        </div>

                    </div>

                </div>

                {{-- NO REKENING --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Nomor Rekening
                        </div>

                        <div class="detail-value">

                            {{ $rekeningBank->nomor_rekening }}

                        </div>

                    </div>

                </div>

                {{-- PEMILIK --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Nama Pemilik Rekening
                        </div>

                        <div class="detail-value">

                            {{ $rekeningBank->nama_rekening }}

                        </div>

                    </div>

                </div>

                {{-- SALDO --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Saldo Awal
                        </div>

                        <div class="saldo-value">

                            Rp {{ number_format($rekeningBank->saldo_awal,0,',','.') }}

                        </div>

                    </div>

                </div>

                {{-- AKUN --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Akun Kas
                        </div>

                        <div class="detail-value">

                            {{ $rekeningBank->akunKas->nama_akun ?? '-' }}

                        </div>

                    </div>

                </div>

                {{-- PERUSAHAAN --}}
                <div class="col-md-6">

                    <div class="detail-box">

                        <div class="detail-label">
                            Perusahaan
                        </div>

                        <div class="detail-value">

                            {{ $rekeningBank->perusahaan->nama_perusahaan ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="print-footer">

                Dokumen Rekening Bank • Dicetak pada
                {{ now()->format('d M Y H:i') }}

            </div>

        </div>

    </div>

</div>

@endsection
