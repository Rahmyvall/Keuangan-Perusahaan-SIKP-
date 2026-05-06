@extends('layouts.app')

@section('title', 'Tambah Periode Baru')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold">Tambah Periode Baru</h1>
            <p class="text-muted">Buat periode pelaporan baru</p>
        </div>
        <a href="{{ route('periode.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-semibold">Form Periode</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('periode.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Perusahaan -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Perusahaan <span
                                        class="text-danger">*</span></label>
                                <select name="id_perusahaan"
                                    class="form-select @error('id_perusahaan') is-invalid @enderror" required>
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach(App\Models\Perusahaan::orderBy('nama_perusahaan')->get() as $p)
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

                            <!-- Tahun & Bulan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="tahun"
                                    class="form-control @error('tahun') is-invalid @enderror"
                                    value="{{ old('tahun', date('Y')) }}" min="2020" max="2030" required>
                                @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bulan <span class="text-danger">*</span></label>
                                <select name="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                                    @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}"
                                        {{ old('bulan') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                        @endfor
                                </select>
                                @error('bulan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Tanggal Awal & Akhir -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Awal <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal_awal"
                                    class="form-control @error('tanggal_awal') is-invalid @enderror"
                                    value="{{ old('tanggal_awal') }}" required>
                                @error('tanggal_awal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Akhir <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                    value="{{ old('tanggal_akhir') }}" required>
                                @error('tanggal_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="Terbuka"
                                        {{ old('status', 'Terbuka') == 'Terbuka' ? 'selected' : '' }}>Terbuka</option>
                                    <option value="Ditutup" {{ old('status') == 'Ditutup' ? 'selected' : '' }}>Ditutup
                                    </option>
                                    <option value="Dikunci" {{ old('status') == 'Dikunci' ? 'selected' : '' }}>Dikunci
                                    </option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i> Simpan Periode
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection