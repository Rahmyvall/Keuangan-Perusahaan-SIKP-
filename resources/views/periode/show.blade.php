@extends('layouts.app')

@section('title', 'Detail Periode')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">{{ $periode->label }}</h1>
            <p class="text-muted mb-0">{{ $periode->nama_bulan }} {{ $periode->tahun }} • Periode Pelaporan</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('periode.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <a href="{{ route('periode.edit', $periode) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i> Edit Periode
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- Main Info Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informasi Periode
                    </h5>
                    <div>
                        {!! $periode->status_badge !!}
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-building fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Perusahaan</small>
                                    <h6 class="mb-0 fw-semibold">{{ $periode->perusahaan->nama_perusahaan ?? '—' }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3">
                                    <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Periode</small>
                                    <h6 class="mb-0 fw-semibold">{{ $periode->nama_bulan }} {{ $periode->tahun }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 border-top pt-4">
                            <div class="row text-center">
                                <div class="col-6">
                                    <small class="text-muted">Tanggal Mulai</small>
                                    <h5 class="fw-bold text-primary mb-0">
                                        {{ $periode->tanggal_awal->format('d') }}
                                        <span class="fs-6 fw-normal">{{ $periode->tanggal_awal->format('M Y') }}</span>
                                    </h5>
                                </div>
                                <div class="col-6 border-start">
                                    <small class="text-muted">Tanggal Selesai</small>
                                    <h5 class="fw-bold text-danger mb-0">
                                        {{ $periode->tanggal_akhir->format('d') }}
                                        <span class="fs-6 fw-normal">{{ $periode->tanggal_akhir->format('M Y') }}</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Side Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-semibold mb-4">
                        <i class="fas fa-clock me-2 text-muted"></i>
                        Informasi Waktu
                    </h5>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Dibuat pada</span>
                            <span class="fw-medium">{{ $periode->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Terakhir diubah</span>
                            <span class="fw-medium">{{ $periode->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="text-center mt-4">
                        <small class="text-muted">Durasi Periode</small>
                        <h4 class="fw-bold text-success mt-1">
                            {{ $periode->tanggal_awal->diffInDays($periode->tanggal_akhir) + 1 }} Hari
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Additional Actions -->
    <div class="mt-4">
        <a href="{{ route('periode.edit', $periode) }}" class="btn btn-outline-warning">
            <i class="fas fa-pencil-alt me-2"></i> Ubah Data Periode
        </a>
    </div>

</div>
@endsection