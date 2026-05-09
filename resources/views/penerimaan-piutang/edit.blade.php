@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">
        <div>
            <h4 class="mb-0 fw-bold">Edit Penerimaan Piutang</h4>
            <small class="text-muted">{{ $penerimaanPiutang->nomor_penerimaan }}</small>
        </div>
        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light border">
            <i data-feather="arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">

            <form action="{{ route('penerimaan-piutang.update', $penerimaanPiutang->id_penerimaan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nomor Penerimaan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nomor_penerimaan" class="form-control"
                            value="{{ old('nomor_penerimaan', $penerimaanPiutang->nomor_penerimaan) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control"
                            value="{{ old('tanggal', $penerimaanPiutang->tanggal->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Faktur Penjualan <span
                                class="text-danger">*</span></label>
                        <select name="id_faktur_penjualan" class="form-select" required>
                            @foreach($faktur ?? [] as $f)
                            <option value="{{ $f->id_faktur_penjualan }}"
                                {{ old('id_faktur_penjualan', $penerimaanPiutang->id_faktur_penjualan) == $f->id_faktur_penjualan ? 'selected' : '' }}>
                                {{ $f->nomor_faktur ?? 'Faktur #'.$f->id_faktur_penjualan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Perusahaan <span class="text-danger">*</span></label>
                        <select name="id_perusahaan" class="form-select" required>
                            @foreach($perusahaan ?? [] as $p)
                            <option value="{{ $p->id_perusahaan }}"
                                {{ old('id_perusahaan', $penerimaanPiutang->id_perusahaan) == $p->id_perusahaan ? 'selected' : '' }}>
                                {{ $p->nama_perusahaan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" step="0.01" class="form-control"
                            value="{{ old('jumlah', $penerimaanPiutang->jumlah) }}" required>
                    </div>

                    <!-- JURNAL - SUDAH DIBENAR -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jurnal <span class="text-muted">(Opsional)</span></label>
                        <select name="id_jurnal" class="form-select @error('id_jurnal') is-invalid @enderror">
                            <option value="">-- Tidak ada jurnal --</option>

                            @foreach($jurnal ?? [] as $j)
                            <option value="{{ $j->id_jurnal }}"
                                {{ old('id_jurnal', $penerimaanPiutang->id_jurnal) == $j->id_jurnal ? 'selected' : '' }}>
                                {{ $j->nomor_jurnal ?? 'Jurnal #' . $j->id_jurnal }}
                                @if($j->tanggal)
                                - {{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}
                                @endif
                                @if($j->keterangan)
                                - {{ Str::limit($j->keterangan, 50) }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('id_jurnal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih jurnal yang terkait dengan penerimaan ini</small>
                    </div>

                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-success px-5">
                        <i data-feather="save"></i> Update Data
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
