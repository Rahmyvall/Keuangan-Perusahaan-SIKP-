@extends('layouts.app')

@section('title', 'Tambah Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                Tambah Faktur Pembelian
            </h2>

            <p class="text-muted mb-0">
                Input data faktur pembelian baru
            </p>
        </div>

        <a href="{{ route('faktur-pembelian.index') }}" class="btn btn-light border shadow-sm mt-3 mt-md-0">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    {{-- ERROR --}}
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

    {{-- FORM --}}
    <form action="{{ route('faktur-pembelian.store') }}" method="POST" id="formFaktur">

        @csrf

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

                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
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

                        <select name="id_supplier" class="form-select @error('id_supplier') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Supplier --
                            </option>

                            @forelse($supplier ?? [] as $item)

                            <option value="{{ $item->id_supplier }}"
                                {{ old('id_supplier') == $item->id_supplier ? 'selected' : '' }}>

                                {{ $item->nama_supplier }}

                            </option>

                            @empty

                            <option value="">
                                Data supplier tidak tersedia
                            </option>

                            @endforelse

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

                            @forelse($jurnal ?? [] as $item)

                            <option value="{{ $item['id'] }}" {{ old('id_jurnal') == $item['id'] ? 'selected' : '' }}>

                                {{ $item['text'] }}

                            </option>

                            @empty

                            <option value="">
                                Data jurnal tidak tersedia
                            </option>

                            @endforelse

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

                        <select name="id_perusahaan" class="form-select @error('id_perusahaan') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Perusahaan --
                            </option>

                            @forelse($perusahaan ?? [] as $item)

                            <option value="{{ $item->id_perusahaan }}"
                                {{ old('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>

                                {{ $item->nama_perusahaan }}

                            </option>

                            @empty

                            <option value="">
                                Data perusahaan tidak tersedia
                            </option>

                            @endforelse

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

                            <input type="number" step="0.01" min="0" name="ppn" id="ppn" class="form-control bg-light"
                                value="{{ old('ppn', 0) }}" readonly>

                        </div>

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

            {{-- FOOTER BUTTON --}}
            <div class="card-footer bg-white border-0 py-3">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('faktur-pembelian.index') }}" class="btn btn-light border px-4">

                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali

                    </a>

                    <button type="submit" class="btn btn-primary px-4">

                        <i class="fas fa-save me-2"></i>
                        Simpan Faktur

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

{{-- SCRIPT --}}
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

    let ppn =
        subtotal * (PPN_PERCENT / 100);

    let total =
        subtotal + ppn;

    document.getElementById('ppn').value =
        ppn.toFixed(2);

    document.getElementById('total').value =
        total.toLocaleString('id-ID');
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
