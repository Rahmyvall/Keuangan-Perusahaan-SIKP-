@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4">

        <div>
            <h4 class="mb-0 fw-bold">Edit Akun</h4>
            <small class="text-muted">Perubahan data Chart of Account (COA)</small>
        </div>

        <a href="{{ route('akun.index') }}" class="btn btn-secondary rounded-3">
            ← Kembali
        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('akun.update', $akun->id_akun) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- SECTION: IDENTITAS --}}
                    <div class="col-12">
                        <h6 class="text-muted fw-bold">Identitas Akun</h6>
                        <hr>
                    </div>

                    {{-- KODE --}}
                    <div class="col-md-4">
                        <label class="form-label">Kode Akun</label>
                        <input type="text" name="kode_akun" class="form-control bg-light" value="{{ $akun->kode_akun }}"
                            required>
                    </div>

                    {{-- NAMA --}}
                    <div class="col-md-8">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama_akun" class="form-control" value="{{ $akun->nama_akun }}"
                            required>
                    </div>

                    {{-- SECTION: KLASIFIKASI --}}
                    <div class="col-12 mt-3">
                        <h6 class="text-muted fw-bold">Klasifikasi Akun</h6>
                        <hr>
                    </div>

                    {{-- TIPE --}}
                    <div class="col-md-4">
                        <label class="form-label">Tipe Akun</label>
                        <select name="tipe_akun" class="form-select">
                            @foreach(['Aset','Liabilitas','Ekuitas','Pendapatan','Beban'] as $t)
                            <option value="{{ $t }}" {{ $akun->tipe_akun == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SALDO --}}
                    <div class="col-md-4">
                        <label class="form-label">Saldo Normal</label>
                        <select name="saldo_normal" class="form-select">
                            <option value="Debit" {{ $akun->saldo_normal == 'Debit' ? 'selected' : '' }}>Debit</option>
                            <option value="Kredit" {{ $akun->saldo_normal == 'Kredit' ? 'selected' : '' }}>Kredit
                            </option>
                        </select>
                    </div>

                    {{-- LEVEL --}}
                    <div class="col-md-4">
                        <label class="form-label">Level</label>
                        <input type="number" name="level" class="form-control" value="{{ $akun->level }}">
                    </div>

                    {{-- SECTION: HIERARKI --}}
                    <div class="col-12 mt-3">
                        <h6 class="text-muted fw-bold">Struktur Akun</h6>
                        <hr>
                    </div>

                    {{-- PARENT --}}
                    {{-- PARENT --}}
                    <div class="col-md-6">
                        <label class="form-label">Parent Akun</label>

                        <select name="parent_id" class="form-select">
                            <option value="">-- Akun Utama --</option>

                            @foreach($allAkun ?? [] as $a)

                            {{-- ❌ jangan tampilkan dirinya sendiri --}}
                            @if($a->id_akun != $akun->id_akun)

                            <option value="{{ $a->id_akun }}" {{ $akun->parent_id == $a->id_akun ? 'selected' : '' }}>

                                {{-- visual hierarchy --}}
                                {{ str_repeat('— ', $a->level ?? 1) }}
                                {{ $a->kode_akun }} - {{ $a->nama_akun }}

                            </option>

                            @endif

                            @endforeach
                        </select>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $akun->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$akun->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ route('akun.index') }}" class="btn btn-light border">
                        Batal
                    </a>

                    <button class="btn btn-warning px-4">
                        Update Akun
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection