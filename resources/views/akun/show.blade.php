@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4">

        <div>
            <h4 class="mb-0 fw-bold">Detail Akun</h4>
            <small class="text-muted">Informasi lengkap Chart of Account</small>
        </div>

        <a href="{{ route('akun.index') }}" class="btn btn-secondary rounded-3">
            ← Kembali
        </a>

    </div>

    <div class="row">

        {{-- KIRI --}}
        <div class="col-md-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <h5 class="mb-3">Informasi Akun</h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Kode Akun</small>
                                <div class="fw-bold fs-5">{{ $akun->kode_akun }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Nama Akun</small>
                                <div class="fw-bold fs-5">{{ $akun->nama_akun }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Tipe</small>
                                <div>
                                    <span class="badge bg-primary fs-6">
                                        {{ $akun->tipe_akun }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Saldo Normal</small>
                                <div>
                                    <span class="badge bg-dark fs-6">
                                        {{ $akun->saldo_normal }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Level</small>
                                <div class="fw-bold fs-5">{{ $akun->level }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Parent Akun</small>
                                <div class="fw-bold">
                                    {{ $akun->parent->nama_akun ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Status</small>
                                <div>
                                    @if($akun->is_active)
                                    <span class="badge bg-success fs-6">Aktif</span>
                                    @else
                                    <span class="badge bg-secondary fs-6">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted">Tanggal Dibuat</small>
                                <div class="fw-bold">
                                    {{ $akun->created_at?->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- KANAN (SUMMARY CARD) --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center">

                    <div class="mb-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width:70px;height:70px;">
                            <i data-feather="database"></i>
                        </div>
                    </div>

                    <h5 class="fw-bold">{{ $akun->nama_akun }}</h5>
                    <p class="text-muted mb-3">{{ $akun->kode_akun }}</p>

                    <hr>

                    <div class="text-start">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tipe</span>
                            <strong>{{ $akun->tipe_akun }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Level</span>
                            <strong>{{ $akun->level }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Status</span>
                            <strong>
                                {{ $akun->is_active ? 'Aktif' : 'Nonaktif' }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection