@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Tambah Mata Uang</h5>

            <form action="{{ route('mata-uang.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Kode</label>
                    <input type="text" name="kode" class="form-control"
                           maxlength="3" value="{{ old('kode') }}" required>
                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama') }}" required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Simbol</label>
                    <input type="text" name="simbol" class="form-control"
                           value="{{ old('simbol') }}">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('mata-uang.index') }}" class="btn btn-light">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
