@extends('layouts.app')

@section('title', 'Edit Faktur Pembelian')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                Edit Faktur Pembelian
            </h3>
            <p class="text-muted mb-0">Mengedit data faktur pembelian #{{ $fakturPembelian->nomor_faktur ?? '' }}</p>
        </div>

        <a href="{{ route('faktur-pembelian.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <form action="{{ route('faktur-pembelian.update', $fakturPembelian) }}" method="POST" id="formFaktur">

        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-semibold">Informasi Faktur</h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', optional($fakturPembelian->tanggal)->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Supplier -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Supplier <span
                                        class="text-danger">*</span></label>
                                <select name="id_supplier" id="id_supplier"
                                    class="form-select @error('id_supplier') is-invalid @enderror" required>
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach($supplier as $item)
                                    <option value="{{ $item->id_supplier }}"
                                        {{ old('id_supplier', $fakturPembelian->id_supplier) == $item->id_supplier ? 'selected' : '' }}>
                                        {{ $item->nama_supplier }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_supplier')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jurnal -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jurnal <span class="text-danger">*</span></label>
                                <select name="id_jurnal" id="id_jurnal"
                                    class="form-select @error('id_jurnal') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jurnal --</option>
                                    @foreach($jurnal as $item)
                                    <option value="{{ $item['id'] }}"
                                        {{ old('id_jurnal', $fakturPembelian->id_jurnal) == $item['id'] ? 'selected' : '' }}>
                                        {{ $item['text'] }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_jurnal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Perusahaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Perusahaan <span
                                        class="text-danger">*</span></label>
                                <select name="id_perusahaan" id="id_perusahaan"
                                    class="form-select @error('id_perusahaan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    @foreach($perusahaan as $item)
                                    <option value="{{ $item->id_perusahaan }}"
                                        {{ old('id_perusahaan', $fakturPembelian->id_perusahaan) == $item->id_perusahaan ? 'selected' : '' }}>
                                        {{ $item->nama_perusahaan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nominal -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Subtotal <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="subtotal" id="subtotal"
                                    class="form-control @error('subtotal') is-invalid @enderror"
                                    value="{{ old('subtotal', $fakturPembelian->subtotal ?? 0) }}" required>
                                @error('subtotal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">PPN (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="ppn" id="ppn"
                                    class="form-control @error('ppn') is-invalid @enderror"
                                    value="{{ old('ppn', $fakturPembelian->ppn ?? 0) }}" required>
                                @error('ppn')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Total</label>
                                <input type="number" step="0.01" name="total" id="total" readonly
                                    class="form-control bg-light fw-bold @error('total') is-invalid @enderror"
                                    value="{{ old('total', $fakturPembelian->total ?? 0) }}">
                                @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="Belum Lunas"
                                        {{ old('status', $fakturPembelian->status) == 'Belum Lunas' ? 'selected' : '' }}>
                                        Belum Lunas
                                    </option>
                                    <option value="Lunas"
                                        {{ old('status', $fakturPembelian->status) == 'Lunas' ? 'selected' : '' }}>
                                        Lunas
                                    </option>
                                    <option value="Dibatalkan"
                                        {{ old('status', $fakturPembelian->status) == 'Dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan
                                    </option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Sidebar Ringkasan -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Ringkasan</h5>

                        <div class="bg-light rounded-3 p-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <strong id="subtotalPreview">Rp 0</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>PPN</span>
                                <strong id="ppnPreview">Rp 0</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="text-primary mb-0" id="totalPreview">Rp 0</h5>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mt-4 py-3">
                            <i class="fas fa-save me-2"></i> Update Faktur
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

function hitungTotal() {
    let subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    let ppn = parseFloat(document.getElementById('ppn').value) || 0;
    let total = subtotal + ppn;

    document.getElementById('total').value = total.toFixed(2);

    document.getElementById('subtotalPreview').innerText = formatRupiah(subtotal);
    document.getElementById('ppnPreview').innerText = formatRupiah(ppn);
    document.getElementById('totalPreview').innerText = formatRupiah(total);
}

// Event listeners
document.getElementById('subtotal').addEventListener('input', hitungTotal);
document.getElementById('ppn').addEventListener('input', hitungTotal);

// Jalankan saat halaman dimuat
document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

@endsection