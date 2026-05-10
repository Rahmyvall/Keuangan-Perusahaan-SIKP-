@extends('layouts.app')

@section('title', 'Tambah Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================= --}}
    {{-- HEADER --}}
    {{-- ========================================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                Tambah Faktur Pembelian
            </h2>

            <p class="text-muted mb-0">
                Input data faktur pembelian baru
            </p>
        </div>

        <a href="{{ route('faktur-pembelian.index') }}" class="btn btn-light border shadow-sm">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    {{-- ========================================= --}}
    {{-- ERROR --}}
    {{-- ========================================= --}}
    @if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm">

        <div class="fw-semibold mb-2">
            <i class="fas fa-exclamation-circle me-2"></i>
            Terjadi Kesalahan
        </div>

        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

    @endif

    {{-- ========================================= --}}
    {{-- FORM --}}
    {{-- ========================================= --}}
    <form action="{{ route('faktur-pembelian.store') }}" method="POST" id="formFaktur">

        @csrf

        <div class="row g-4">

            {{-- ========================================= --}}
            {{-- LEFT CONTENT --}}
            {{-- ========================================= --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 py-3">

                        <h5 class="fw-semibold mb-0">
                            Informasi Faktur
                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            {{-- TANGGAL --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tanggal
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>

                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- SUPPLIER --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Supplier
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="id_supplier"
                                    class="form-select @error('id_supplier') is-invalid @enderror" required>

                                    <option value="">
                                        -- Pilih Supplier --
                                    </option>

                                    @foreach($supplier as $item)

                                    <option value="{{ $item->id_supplier }}"
                                        {{ old('id_supplier') == $item->id_supplier ? 'selected' : '' }}>

                                        {{ $item->nama_supplier }}

                                    </option>

                                    @endforeach

                                </select>

                                @error('id_supplier')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- JURNAL --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Jurnal
                                </label>

                                <select name="id_jurnal" class="form-select @error('id_jurnal') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Jurnal --
                                    </option>

                                    @foreach($jurnal as $item)

                                    <option value="{{ $item['id'] }}"
                                        {{ old('id_jurnal') == $item['id'] ? 'selected' : '' }}>

                                        {{ $item['text'] }}

                                    </option>

                                    @endforeach

                                </select>

                                @error('id_jurnal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- PERUSAHAAN --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Perusahaan
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="id_perusahaan"
                                    class="form-select @error('id_perusahaan') is-invalid @enderror" required>

                                    <option value="">
                                        -- Pilih Perusahaan --
                                    </option>

                                    @foreach($perusahaan as $item)

                                    <option value="{{ $item->id_perusahaan }}"
                                        {{ old('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>

                                        {{ $item->nama_perusahaan }}

                                    </option>

                                    @endforeach

                                </select>

                                @error('id_perusahaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- SUBTOTAL --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Subtotal
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input type="number" step="0.01" min="0" name="subtotal" id="subtotal"
                                        class="form-control @error('subtotal') is-invalid @enderror"
                                        value="{{ old('subtotal', 0) }}" required>

                                </div>

                                @error('subtotal')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- PPN --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    PPN (11%)
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input type="number" step="0.01" min="0" name="ppn" id="ppn"
                                        class="form-control bg-light @error('ppn') is-invalid @enderror"
                                        value="{{ old('ppn', 0) }}" readonly>

                                </div>

                                <small class="text-muted">
                                    Otomatis 11% dari subtotal
                                </small>

                                @error('ppn')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            {{-- TOTAL --}}
                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Total
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light">
                                        Rp
                                    </span>

                                    <input type="text" id="total" class="form-control bg-light fw-bold" readonly>

                                </div>

                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <select name="status" class="form-select @error('status') is-invalid @enderror">

                                    <option value="Belum Lunas"
                                        {{ old('status', 'Belum Lunas') == 'Belum Lunas' ? 'selected' : '' }}>

                                        Belum Lunas

                                    </option>

                                    <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>

                                        Lunas

                                    </option>

                                    <option value="Dibatalkan" {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>

                                        Dibatalkan

                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ========================================= --}}
            {{-- SIDEBAR --}}
            {{-- ========================================= --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm sticky-top" style="top:20px;">

                    <div class="card-body">

                        <h5 class="fw-semibold mb-4">
                            Ringkasan Faktur
                        </h5>

                        <div class="bg-light rounded-4 p-4">

                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Subtotal
                                </span>

                                <strong id="subtotalPreview">
                                    Rp 0
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    PPN
                                </span>

                                <strong id="ppnPreview">
                                    Rp 0
                                </strong>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">

                                <h5 class="mb-0 fw-bold">
                                    Total
                                </h5>

                                <h4 class="text-primary fw-bold mb-0" id="totalPreview">

                                    Rp 0

                                </h4>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4 py-3 shadow-sm">

                            <i class="fas fa-save me-2"></i>
                            Simpan Faktur

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

{{-- ========================================= --}}
{{-- SCRIPT --}}
{{-- ========================================= --}}
<script>
const PPN_PERCENT = 11;

function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

function hitungTotal() {
    let subtotal =
        parseFloat(
            document.getElementById('subtotal').value
        ) || 0;

    // HITUNG PPN
    let ppn =
        subtotal * (PPN_PERCENT / 100);

    // TOTAL
    let total =
        subtotal + ppn;

    // INPUT
    document.getElementById('ppn').value =
        ppn.toFixed(2);

    document.getElementById('total').value =
        total.toLocaleString('id-ID');

    // PREVIEW
    document.getElementById('subtotalPreview').innerText =
        formatRupiah(subtotal);

    document.getElementById('ppnPreview').innerText =
        formatRupiah(ppn);

    document.getElementById('totalPreview').innerText =
        formatRupiah(total);
}

document
    .getElementById('subtotal')
    .addEventListener('input', hitungTotal);

document.addEventListener(
    'DOMContentLoaded',
    hitungTotal
);
</script>

@endsection