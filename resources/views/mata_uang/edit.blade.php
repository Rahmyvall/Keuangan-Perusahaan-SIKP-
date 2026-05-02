@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f1f5f9;
    }

    .page-wrapper {
        padding: 30px;
    }

    .page-title {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 14px;
    }

    .content-box {
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .form-control-modern {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }

    .form-control-modern:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }

    .btn-modern {
        border-radius: 999px;
        padding: 10px 22px;
    }

    .btn-warning-modern {
        background: #f59e0b;
        border: none;
    }

    .btn-warning-modern:hover {
        background: #d97706;
    }
</style>

<div class="container-fluid page-wrapper">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <h3 class="page-title">Edit Mata Uang</h3>
        <div class="page-subtitle">
            Update data mata uang yang tersedia di sistem
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content-box">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <strong>Oops!</strong> Ada kesalahan:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mata-uang.update', $mataUang->id_mata_uang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- KODE --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kode</label>
                    <input type="text"
                           name="kode"
                           maxlength="3"
                           class="form-control form-control-modern"
                           value="{{ old('kode', $mataUang->kode) }}"
                           required>
                </div>

                {{-- NAMA --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama</label>
                    <input type="text"
                           name="nama"
                           class="form-control form-control-modern"
                           value="{{ old('nama', $mataUang->nama) }}"
                           required>
                </div>

                {{-- SIMBOL --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Simbol</label>
                    <input type="text"
                           name="simbol"
                           class="form-control form-control-modern"
                           value="{{ old('simbol', $mataUang->simbol) }}">
                </div>

            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-between align-items-center mt-5">

                <a href="{{ route('mata-uang.index') }}"
                   class="btn btn-light btn-modern">
                    ← Kembali
                </a>

                <button type="submit"
                        class="btn btn-warning-modern text-white btn-modern shadow-sm">
                    💾 Update Data
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
