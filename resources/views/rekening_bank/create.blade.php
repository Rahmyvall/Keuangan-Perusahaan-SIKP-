@extends('layouts.app')

@section('content')

<style>
body {
    background: #f4f7fb;
}

/* =========================
   PAGE
========================= */

.page-wrapper {
    min-height: 100vh;
}

/* =========================
   CARD
========================= */

.create-card {
    border: none;
    border-radius: 32px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 20px 45px rgba(0, 0, 0, .08);
}

/* =========================
   TOP HEADER
========================= */

.card-header-custom {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    padding: 50px;
    position: relative;
    overflow: hidden;
}

.card-header-custom::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, .08);
    border-radius: 50%;
    top: -120px;
    right: -80px;
}

.card-header-custom::after {
    content: '';
    position: absolute;
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, .05);
    border-radius: 50%;
    bottom: -70px;
    left: -50px;
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .15);
    backdrop-filter: blur(10px);

    display: flex;
    align-items: center;
    justify-content: center;

    margin: auto;
}

.header-icon i {
    font-size: 42px;
    color: white;
}

.top-badge {
    background: rgba(255, 255, 255, .15);
    padding: 10px 18px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: white;
    margin-top: 18px;
    backdrop-filter: blur(10px);
    font-size: 14px;
}

/* =========================
   FORM
========================= */

.form-section {
    padding: 45px;
}

.form-box {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 22px;
    padding: 25px;
    transition: .3s;
    height: 100%;
}

.form-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .05);
}

.form-label {
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.form-control,
.form-select {
    min-height: 55px;
    border-radius: 16px !important;
    border: 1px solid #dbe3ec;
    padding-inline: 18px;
}

.form-control:focus,
.form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
}

.input-group-text {
    border-radius: 16px 0 0 16px !important;
    border: 1px solid #dbe3ec;
    background: white;
    font-weight: 700;
    padding-inline: 18px;
}

.invalid-feedback {
    margin-top: 10px;
}

/* =========================
   BUTTON
========================= */

.btn-custom {
    border-radius: 14px;
    padding: 12px 26px;
    font-weight: 600;
}

.btn-save {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    color: white;
}

.btn-save:hover {
    color: white;
    opacity: .95;
}

/* =========================
   MOBILE
========================= */

@media(max-width:768px) {

    .card-header-custom {
        padding: 35px 25px;
    }

    .form-section {
        padding: 25px;
    }

}
</style>

<div class="container-fluid py-4 page-wrapper">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

        <div>

            <h2 class="fw-bold mb-1">

                <i class="bi bi-plus-circle-fill text-primary me-2"></i>

                Tambah Rekening Bank

            </h2>

            <p class="text-muted mb-0">

                Tambahkan data rekening bank perusahaan baru

            </p>

        </div>

        {{-- BACK --}}
        <a href="{{ route('rekening-bank.index') }}" class="btn btn-light border shadow-sm btn-custom mt-3 mt-md-0">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

    {{-- CARD --}}
    <div class="card create-card">

        {{-- HEADER --}}
        <div class="card-header-custom text-center">

            <div class="header-content">

                <div class="header-icon mb-4">

                    <i class="bi bi-bank2"></i>

                </div>

                <h1 class="fw-bold text-white mb-2">

                    Tambah Rekening Baru

                </h1>

                <p class="text-white opacity-75 mb-0">

                    Kelola rekening bank perusahaan dengan mudah dan aman

                </p>

                <div class="top-badge">

                    <i class="bi bi-shield-check"></i>

                    Sistem Data Rekening Bank

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="form-section">

            <form action="{{ route('rekening-bank.store') }}" method="POST">

                @csrf

                <div class="row g-4">

                    {{-- NAMA BANK --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Nama Bank

                            </label>

                            <input type="text" name="nama_bank"
                                class="form-control @error('nama_bank') is-invalid @enderror"
                                placeholder="Contoh : Bank BCA" value="{{ old('nama_bank') }}">

                            @error('nama_bank')

                            <div class="invalid-feedback">

                                {{ $message }}

                            </div>

                            @enderror

                        </div>

                    </div>

                    {{-- NOMOR REKENING --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label d-flex justify-content-between align-items-center">

                                <span>
                                    Nomor Rekening
                                </span>

                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">

                                    Auto Generate

                                </span>

                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-primary text-white border-0">

                                    <i class="bi bi-credit-card-2-front-fill"></i>

                                </span>

                                <input type="text" name="nomor_rekening" class="form-control fw-bold fs-5 bg-light
                @error('nomor_rekening') is-invalid @enderror" value="{{ old('nomor_rekening', $nomorRekening) }}"
                                    readonly>

                            </div>

                            <small class="text-muted mt-2 d-block">

                                Nomor rekening dibuat otomatis seperti sistem perbankan.

                            </small>

                        </div>

                    </div>

                    {{-- NAMA PEMILIK --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Nama Pemilik Rekening

                            </label>

                            <input type="text" name="nama_rekening" class="form-control"
                                placeholder="Masukkan nama pemilik rekening" value="{{ old('nama_rekening') }}">

                        </div>

                    </div>

                    {{-- AKUN KAS --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Akun Kas

                            </label>

                            <select name="id_akun_kas" class="form-select">

                                <option value="">
                                    -- Pilih Akun Kas --
                                </option>

                                @foreach($akun as $a)

                                <option value="{{ $a->id_akun }}">

                                    {{ $a->nama_akun }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    {{-- SALDO --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Saldo Awal

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    Rp

                                </span>

                                <input type="number" name="saldo_awal" class="form-control"
                                    value="{{ old('saldo_awal',0) }}">

                            </div>

                        </div>

                    </div>

                    {{-- PERUSAHAAN --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Perusahaan

                            </label>

                            <select name="id_perusahaan" class="form-select">

                                <option value="">
                                    -- Pilih Perusahaan --
                                </option>

                                @foreach($perusahaan as $p)

                                <option value="{{ $p->id_perusahaan }}">

                                    {{ $p->nama_perusahaan }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end gap-3 mt-5 flex-wrap">

                    <a href="{{ route('rekening-bank.index') }}" class="btn btn-light border shadow-sm btn-custom">

                        <i class="bi bi-x-circle me-1"></i>

                        Batal

                    </a>

                    <button type="submit" class="btn btn-save shadow-sm btn-custom">

                        <i class="bi bi-save2-fill me-1"></i>

                        Simpan Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
