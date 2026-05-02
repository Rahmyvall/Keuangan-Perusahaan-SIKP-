@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h4 class="fw-bold mb-1">Detail Perusahaan</h4>
            <div class="text-muted small">Informasi lengkap & data legal perusahaan</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('perusahaan.index') }}"
               class="btn btn-light border rounded-3 px-3">
                ← Kembali
            </a>

            <a href="{{ route('perusahaan.edit', $perusahaan->id_perusahaan) }}"
               class="btn btn-warning rounded-3 px-3 d-flex align-items-center gap-1">
                <i data-feather="edit"></i>
                Edit
            </a>
        </div>

    </div>

    {{-- MAIN CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- TOP PROFILE SECTION --}}
                <div class="p-4 bg-light d-flex align-items-center gap-3 border-bottom">

                    {{-- LOGO --}}
                    <div>
                        @if($perusahaan->logo)
                            <img src="{{ asset('storage/'.$perusahaan->logo) }}"
                                 class="rounded-circle border bg-white"
                                 width="80" height="80"
                                 style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center"
                                 style="width:80px;height:80px;">
                                <i data-feather="briefcase"></i>
                            </div>
                        @endif
                    </div>

                    {{-- INFO --}}
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">{{ $perusahaan->nama_perusahaan }}</h5>

                        <div class="text-muted small mb-2">
                            {{ $perusahaan->email ?? 'Email belum tersedia' }}
                        </div>

                        @if(isset($perusahaan->status))
                            <span class="badge rounded-pill px-3 py-2
                                {{ $perusahaan->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($perusahaan->status) }}
                            </span>
                        @endif
                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-4">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="label">NPWP</div>
                                <div class="value">{{ $perusahaan->npwp ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="label">Telepon</div>
                                <div class="value">{{ $perusahaan->telepon ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="label">Kota</div>
                                <div class="value">{{ $perusahaan->kota ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="label">Email</div>
                                <div class="value">{{ $perusahaan->email ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-card">
                                <div class="label">Alamat</div>
                                <div class="value">{{ $perusahaan->alamat ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-card small-text text-muted">
                                <div>Dibuat pada</div>
                                <div class="fw-semibold">
                                    {{ optional($perusahaan->created_at)->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

{{-- STYLE --}}
<style>
.info-card{
    background:#ffffff;
    border:1px solid #eef0f3;
    border-radius:14px;
    padding:14px 16px;
    transition:.2s;
}

.info-card:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
}

.label{
    font-size:12px;
    color:#6c757d;
    margin-bottom:4px;
}

.value{
    font-weight:600;
    color:#212529;
}

.small-text{
    font-size:13px;
}
</style>

@endsection