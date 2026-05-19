@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Tambah Saldo Awal</h3>
            <small class="text-muted">Input saldo awal akun & periode</small>
        </div>

        <a href="{{ route('saldo-awal.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- ERROR --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    {{-- FORM --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-plus-circle me-2"></i>
            Form Saldo Awal
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('saldo-awal.store') }}">
                @csrf

                <div class="row g-4">

                    {{-- AKUN --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Akun</label>
                        <select name="id_akun" class="form-control form-control-lg" required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($akunList as $akun)
                            <option value="{{ $akun->id_akun }}">
                                {{ $akun->nama_akun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PERIODE --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Periode</label>
                        <select name="id_periode" class="form-control form-control-lg" required>
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periodeList as $periode)
                            <option value="{{ $periode->id_periode }}">
                                {{ $periode->nama_periode ?? ('Periode #' . $periode->id_periode) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DEBIT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Debit</label>
                        <input type="number" name="debit" class="form-control form-control-lg" placeholder="0">
                    </div>

                    {{-- KREDIT --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kredit</label>
                        <input type="number" name="kredit" class="form-control form-control-lg" placeholder="0">
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-12 d-flex gap-2 mt-3">

                        <button class="btn btn-success btn-lg">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>

                        <a href="{{ route('saldo-awal.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
