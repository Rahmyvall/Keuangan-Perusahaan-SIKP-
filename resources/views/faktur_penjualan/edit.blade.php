{{-- resources/views/faktur_penjualan/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Faktur - ' . $fakturPenjualan->nomor_faktur)

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-edit text-warning me-2"></i>Edit Faktur Penjualan
            </h3>
            <h5 class="text-muted">{{ $fakturPenjualan->nomor_faktur }}</h5>
        </div>
        <a href="{{ route('faktur-penjualan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Form Edit Faktur</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('faktur-penjualan.update', $fakturPenjualan->id_faktur_penjualan) }}" method="POST"
                id="editForm">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- Nomor Faktur & Tanggal -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nomor Faktur</label>
                        <input type="text" name="nomor_faktur" class="form-control"
                            value="{{ $fakturPenjualan->nomor_faktur }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tanggal Faktur</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $fakturPenjualan->tanggal }}"
                            required>
                    </div>

                    <!-- Pelanggan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Pelanggan</label>
                        <select name="id_pelanggan" class="form-select" required>
                            @foreach($pelanggan as $item)
                            <option value="{{ $item->id_pelanggan }}"
                                {{ $fakturPenjualan->id_pelanggan == $item->id_pelanggan ? 'selected' : '' }}>
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
                                {{ $fakturPenjualan->id_jurnal == $item->id_jurnal ? 'selected' : '' }}>
                                {{ $item->keterangan ?? 'Jurnal #' . $item->id_jurnal }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Perusahaan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Perusahaan</label>
                        <select name="id_perusahaan" class="form-select" required>
                            @foreach($perusahaan as $item)
                            <option value="{{ $item->id_perusahaan }}"
                                {{ $fakturPenjualan->id_perusahaan == $item->id_perusahaan ? 'selected' : '' }}>
                                {{ $item->nama_perusahaan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Belum Lunas"
                                {{ $fakturPenjualan->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Lunas" {{ $fakturPenjualan->status == 'Lunas' ? 'selected' : '' }}>Lunas
                            </option>
                            <option value="Dibatalkan" {{ $fakturPenjualan->status == 'Dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Subtotal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="subtotal" class="form-control text-end"
                                value="{{ $fakturPenjualan->subtotal }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">PPN</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="ppn" class="form-control text-end"
                                value="{{ $fakturPenjualan->ppn ?? 0 }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-medium">Total</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" name="total" class="form-control text-end fw-bold"
                                value="{{ $fakturPenjualan->total }}" required>
                        </div>
                    </div>

                </div>

                <div class="d-flex gap-2 mt-5">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
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
