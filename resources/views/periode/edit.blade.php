@extends('layouts.app')

@section('title', 'Edit Periode')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Edit Periode</h1>
            <p class="text-muted">{{ $periode->label }} • {{ $periode->perusahaan->nama_perusahaan ?? '—' }}</p>
        </div>
        <a href="{{ route('periode.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-edit fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Formulir Edit Periode</h5>
                            <small class="text-muted">Perubahan akan memengaruhi seluruh transaksi di periode
                                ini</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('periode.update', $periode) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-5">

                            <!-- Perusahaan -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-building text-muted me-2"></i> Perusahaan
                                </label>
                                <select name="id_perusahaan"
                                    class="form-select form-select-lg @error('id_perusahaan') is-invalid @enderror"
                                    required>
                                    @foreach(App\Models\Perusahaan::orderBy('nama_perusahaan')->get() as $p)
                                    <option value="{{ $p->id_perusahaan }}"
                                        {{ $periode->id_perusahaan == $p->id_perusahaan ? 'selected' : '' }}>
                                        {{ $p->nama_perusahaan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tahun & Bulan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar text-muted me-2"></i> Tahun
                                </label>
                                <input type="number" name="tahun"
                                    class="form-control form-control-lg @error('tahun') is-invalid @enderror"
                                    value="{{ old('tahun', $periode->tahun) }}" min="2020" max="2035" required>
                                @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt text-muted me-2"></i> Bulan
                                </label>
                                <select name="bulan"
                                    class="form-select form-control-lg @error('bulan') is-invalid @enderror" required>
                                    @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}"
                                        {{ old('bulan', $periode->bulan) == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                        @endfor
                                </select>
                                @error('bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-clock text-muted me-2"></i> Tanggal Awal
                                </label>
                                <input type="date" name="tanggal_awal"
                                    class="form-control form-control-lg @error('tanggal_awal') is-invalid @enderror"
                                    value="{{ old('tanggal_awal', $periode->tanggal_awal->format('Y-m-d')) }}" required>
                                @error('tanggal_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-clock text-muted me-2"></i> Tanggal Akhir
                                </label>
                                <input type="date" name="tanggal_akhir"
                                    class="form-control form-control-lg @error('tanggal_akhir') is-invalid @enderror"
                                    value="{{ old('tanggal_akhir', $periode->tanggal_akhir->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-toggle-on text-muted me-2"></i> Status Periode
                                </label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check border p-3 rounded-3">
                                            <input class="form-check-input" type="radio" name="status" value="Terbuka"
                                                {{ old('status', $periode->status) == 'Terbuka' ? 'checked' : '' }}
                                                id="status1">
                                            <label class="form-check-label fw-medium" for="status1">✅ Terbuka</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check border p-3 rounded-3">
                                            <input class="form-check-input" type="radio" name="status" value="Ditutup"
                                                {{ old('status', $periode->status) == 'Ditutup' ? 'checked' : '' }}
                                                id="status2">
                                            <label class="form-check-label fw-medium" for="status2">🔒 Ditutup</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check border p-3 rounded-3">
                                            <input class="form-check-input" type="radio" name="status" value="Dikunci"
                                                {{ old('status', $periode->status) == 'Dikunci' ? 'checked' : '' }}
                                                id="status3">
                                            <label class="form-check-label fw-medium" for="status3">🔐 Dikunci</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                            <a href="{{ route('periode.index') }}" class="btn btn-secondary px-5">Batal</a>
                            <button type="submit" class="btn btn-warning btn-lg px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection