@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">
        <div>
            <h4 class="mb-0 fw-bold">Tambah Penerimaan Piutang</h4>
            <small class="text-muted">Input data penerimaan piutang baru</small>
        </div>
        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light border">
            <i data-feather="arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">

            <form action="{{ route('penerimaan-piutang.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Penerimaan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nomor_penerimaan"
                            class="form-control bg-light @error('nomor_penerimaan') is-invalid @enderror"
                            value="{{ old('nomor_penerimaan', $nomorPenerimaan ?? '') }}" readonly>
                        @error('nomor_penerimaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nomor otomatis (bisa diubah manual)</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Faktur Penjualan <span
                                class="text-danger">*</span></label>
                        <select name="id_faktur_penjualan"
                            class="form-select @error('id_faktur_penjualan') is-invalid @enderror" required>
                            <option value="">-- Pilih Faktur Penjualan --</option>
                            @foreach($faktur ?? [] as $f)
                            <option value="{{ $f->id_faktur_penjualan }}"
                                {{ old('id_faktur_penjualan') == $f->id_faktur_penjualan ? 'selected' : '' }}>
                                {{ $f->nomor_faktur ?? 'Faktur #'.$f->id_faktur_penjualan }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_faktur_penjualan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Perusahaan <span class="text-danger">*</span></label>
                        <select name="id_perusahaan" class="form-select @error('id_perusahaan') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach($perusahaan ?? [] as $p)
                            <option value="{{ $p->id_perusahaan }}"
                                {{ old('id_perusahaan') == $p->id_perusahaan ? 'selected' : '' }}>
                                {{ $p->nama_perusahaan }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" step="0.01"
                            class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}"
                            required>
                        @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- JURNAL - SUDAH DIBENAR -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jurnal <span class="text-muted">(Opsional)</span></label>
                        <select name="id_jurnal" class="form-select @error('id_jurnal') is-invalid @enderror">
                            <option value="">-- Pilih Jurnal (Opsional) --</option>
                            @foreach($jurnal ?? [] as $j)
                            <option value="{{ $j->id_jurnal }}"
                                {{ old('id_jurnal') == $j->id_jurnal ? 'selected' : '' }}>
                                {{ $j->nomor_jurnal ?? 'Jurnal #'.$j->id_jurnal }}
                                - {{ $j->keterangan ?? '' }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_jurnal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih jurnal jika sudah dibuat sebelumnya</small>
                    </div>

                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-primary px-5">
                        <i data-feather="save"></i> Simpan Penerimaan
                    </button>
                    <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light border px-5 ms-2">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
