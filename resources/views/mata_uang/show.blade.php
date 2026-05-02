@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f1f5f9;
    }

    .page-wrapper {
        padding: 30px;
    }

    .content-box {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .currency-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .label {
        font-size: 13px;
        color: #64748b;
    }

    .value {
        font-weight: 600;
        font-size: 18px;
    }

    .symbol-big {
        font-size: 40px;
        font-weight: bold;
        color: #f59e0b;
    }

    .btn-modern {
        border-radius: 999px;
        padding: 8px 18px;
    }
</style>

<div class="container-fluid page-wrapper">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 fw-bold">Detail Mata Uang</h3>
            <small class="text-muted">Informasi lengkap mata uang</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('mata-uang.edit', $mataUang->id_mata_uang) }}"
               class="btn btn-warning text-white btn-modern">
                <i data-feather="edit"></i> Edit
            </a>

            <a href="{{ route('mata-uang.index') }}"
               class="btn btn-light btn-modern">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content-box">

        <div class="row align-items-center">

            {{-- ICON --}}
            <div class="col-md-2 text-center mb-4 mb-md-0">
                <div class="currency-icon mx-auto">
                    <i data-feather="dollar-sign"></i>
                </div>
            </div>

            {{-- INFO --}}
            <div class="col-md-7">

                <div class="mb-3">
                    <div class="label">Kode</div>
                    <div class="value">
                        <span class="badge bg-dark px-3 py-2 rounded-pill">
                            {{ $mataUang->kode }}
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="label">Nama Mata Uang</div>
                    <div class="value">{{ $mataUang->nama }}</div>
                </div>

            </div>

            {{-- SYMBOL --}}
            <div class="col-md-3 text-md-end text-center mt-4 mt-md-0">
                <div class="label">Simbol</div>
                <div class="symbol-big">
                    {{ $mataUang->simbol ?? '-' }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    feather.replace();
</script>
@endpush
