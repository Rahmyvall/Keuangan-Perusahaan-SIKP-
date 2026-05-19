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

.edit-card {
    border: none;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
    background: #fff;
}

/* =========================
   HEADER
========================= */

.card-header-custom {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    padding: 45px;
    color: white;
    position: relative;
}

.header-icon {
    width: 95px;
    height: 95px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .18);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    backdrop-filter: blur(10px);
}

.header-icon i {
    font-size: 42px;
}

/* =========================
   FORM
========================= */

.form-section {
    padding: 45px;
}

.form-label {
    font-weight: 600;
    margin-bottom: 10px;
    color: #374151;
}

.form-control,
.form-select,
.input-group-text {
    border-radius: 14px !important;
    min-height: 52px;
    border: 1px solid #dbe2ea;
}

.form-control:focus,
.form-select:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 .2rem rgba(245, 158, 11, .15);
}

.input-group-text {
    background: #f9fafb;
    font-weight: 600;
    padding-inline: 18px;
}

.form-box {
    background: #f8fafc;
    border-radius: 20px;
    padding: 25px;
    height: 100%;
    border: 1px solid #edf2f7;
    transition: .3s;
}

.form-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
}

/* =========================
   BUTTON
========================= */

.btn-custom {
    border-radius: 14px;
    padding: 11px 24px;
    font-weight: 600;
}

.btn-update {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    border: none;
    color: white;
}

.btn-update:hover {
    color: white;
    opacity: .95;
}

/* =========================
   INFO TOP
========================= */

.top-info {
    background: rgba(255, 255, 255, .12);
    border-radius: 18px;
    padding: 14px 20px;
    display: inline-block;
    margin-top: 18px;
    backdrop-filter: blur(10px);
}

/* =========================
   MOBILE
========================= */

@media(max-width:768px) {

    .card-header-custom {
        padding: 30px 20px;
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

                <i class="bi bi-pencil-square text-warning me-2"></i>

                Edit Rekening Bank

            </h2>

            <p class="text-muted mb-0">

                Update dan kelola data rekening bank perusahaan

            </p>

        </div>

        {{-- BACK --}}
        <a href="{{ route('rekening-bank.index') }}" class="btn btn-light border shadow-sm btn-custom mt-3 mt-md-0">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

    {{-- CARD --}}
    <div class="card edit-card">

        {{-- HEADER --}}
        <div class="card-header-custom text-center">

            <div class="header-icon mb-4">

                <i class="bi bi-bank2"></i>

            </div>

            <h2 class="fw-bold mb-2">

                {{ $rekeningBank->nama_bank }}

            </h2>

            <p class="mb-0 opacity-75">

                {{ $rekeningBank->nomor_rekening }}

            </p>

            <div class="top-info">

                <i class="bi bi-shield-check me-1"></i>

                Data rekening sedang diperbarui

            </div>

        </div>

        {{-- FORM --}}
        <div class="form-section">

            <form action="{{ route('rekening-bank.update', $rekeningBank->id_rekening) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- NAMA BANK --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Nama Bank

                            </label>

                            <input type="text" name="nama_bank" class="form-control"
                                value="{{ old('nama_bank', $rekeningBank->nama_bank) }}">

                        </div>

                    </div>

                    {{-- NO REKENING --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Nomor Rekening

                            </label>

                            <input type="text" name="nomor_rekening" class="form-control"
                                value="{{ old('nomor_rekening', $rekeningBank->nomor_rekening) }}">

                        </div>

                    </div>

                    {{-- NAMA REKENING --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Nama Pemilik Rekening

                            </label>

                            <input type="text" name="nama_rekening" class="form-control"
                                value="{{ old('nama_rekening', $rekeningBank->nama_rekening) }}">

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
                                    value="{{ old('saldo_awal', $rekeningBank->saldo_awal) }}">

                            </div>

                        </div>

                    </div>

                    {{-- AKUN --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Akun Kas

                            </label>

                            <select name="id_akun_kas" class="form-select">

                                @foreach($akun as $a)

                                <option value="{{ $a->id_akun }}"
                                    {{ $rekeningBank->id_akun_kas == $a->id_akun ? 'selected' : '' }}>

                                    {{ $a->nama_akun }}

                                </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    {{-- PERUSAHAAN --}}
                    <div class="col-lg-6">

                        <div class="form-box">

                            <label class="form-label">

                                Perusahaan

                            </label>

                            <select name="id_perusahaan" class="form-select">

                                @foreach($perusahaan as $p)

                                <option value="{{ $p->id_perusahaan }}"
                                    {{ $rekeningBank->id_perusahaan == $p->id_perusahaan ? 'selected' : '' }}>

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

                    <button type="submit" class="btn btn-update shadow-sm btn-custom">

                        <i class="bi bi-check-circle-fill me-1"></i>

                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
