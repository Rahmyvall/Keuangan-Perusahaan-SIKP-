@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">Edit Mata Uang</h5>

            <form action="{{ route('mata-uang.update', $mataUang->id_mata_uang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode</label>
                    <input type="text" name="kode" class="form-control"
                           maxlength="3"
                           value="{{ old('kode', $mataUang->kode) }}" required>
                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama', $mataUang->nama) }}" required>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Simbol</label>
                    <input type="text" name="simbol" class="form-control"
                           value="{{ old('simbol', $mataUang->simbol) }}">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('mata-uang.index') }}" class="btn btn-light">Batal</a>
                    <button class="btn btn-warning text-white">Update</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
