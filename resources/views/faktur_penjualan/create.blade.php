{{-- resources/views/faktur_penjualan/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Faktur Penjualan Baru')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-plus-circle text-primary me-2"></i>
                Tambah Faktur Penjualan Baru
            </h3>
            <p class="text-muted mb-0">Isi data faktur dengan lengkap</p>
        </div>
        <a href="{{ route('faktur-penjualan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Form Faktur Penjualan</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('faktur-penjualan.store') }}" method="POST" id="createForm">

                @csrf

                <div class="row g-4">

                    <!-- Tanggal -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tanggal Faktur</label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Pelanggan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Pelanggan</label>
                        <select name="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $item)
                            <option value="{{ $item->id_pelanggan }}"
                                {{ old('id_pelanggan') == $item->id_pelanggan ? 'selected' : '' }}>
                                {{ $item->nama_pelanggan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Jurnal -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Jurnal</label>
                        <select name="id_jurnal" class="form-select">
                            <option value="">-- Pilih Jurnal (Opsional) --</option>
                            @foreach($jurnal as $item)
                            <option value="{{ $item->id_jurnal }}"
                                {{ old('id_jurnal') == $item->id_jurnal ? 'selected' : '' }}>
                                {{ $item->formatted_label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Perusahaan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Perusahaan</label>
                        <select name="id_perusahaan" class="form-select" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach($perusahaan as $item)
                            <option value="{{ $item->id_perusahaan }}"
                                {{ old('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>
                                {{ $item->nama_perusahaan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Subtotal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="subtotal" id="subtotal" class="form-control text-end"
                                value="{{ old('subtotal') }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">PPN</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="ppn" id="ppn" class="form-control text-end"
                                value="{{ old('ppn', 0) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Total</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="total" id="total"
                                class="form-control text-end fw-bold" value="{{ old('total') }}" required>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Status Faktur</label>
                        <select name="status" class="form-select" required>
                            <option value="Belum Lunas" {{ old('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum
                                Lunas</option>
                            <option value="Lunas" {{ old('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Dibatalkan" {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>

                </div>

                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Simpan Faktur
                    </button>
                    <a href="{{ route('faktur-penjualan.index') }}" class="btn btn-secondary btn-lg px-4">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Auto hitung Total
document.addEventListener('DOMContentLoaded', function() {
    const subtotal = document.getElementById('subtotal');
    const ppn = document.getElementById('ppn');
    const total = document.getElementById('total');

    function hitungTotal() {
        const sub = parseFloat(subtotal.value) || 0;
        const pajak = parseFloat(ppn.value) || 0;
        total.value = (sub + pajak).toFixed(2);
    }

    subtotal.addEventListener('input', hitungTotal);
    ppn.addEventListener('input', hitungTotal);
});
</script>
@endpush
