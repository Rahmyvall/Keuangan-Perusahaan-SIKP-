@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Tambah Supplier
            </h3>

            <p class="text-muted mb-0">
                Tambahkan data supplier baru ke sistem
            </p>
        </div>

        <a href="{{ route('supplier.index') }}" class="btn btn-light border rounded-3 shadow-sm">

            <i data-feather="arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- TOP BAR --}}
        <div class="bg-primary" style="height: 6px;"></div>

        <div class="card-body p-5">

            <form action="{{ route('supplier.store') }}" method="POST">

                @csrf

                <div class="row g-4">

                    {{-- KODE --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Kode Supplier
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0">
                                <i data-feather="hash"></i>
                            </span>

                            <input type="text" class="form-control border-0 bg-light rounded-end-3"
                                value="{{ $kodeSupplier }}" readonly>

                        </div>

                        {{-- hidden input --}}
                        <input type="hidden" name="kode_supplier" value="{{ $kodeSupplier }}">

                    </div>

                    {{-- NAMA --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nama Supplier
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0">
                                <i data-feather="user"></i>
                            </span>

                            <input type="text" name="nama_supplier"
                                class="form-control border-0 bg-light rounded-end-3 @error('nama_supplier') is-invalid @enderror"
                                placeholder="Masukkan nama supplier" value="{{ old('nama_supplier') }}">

                        </div>

                        @error('nama_supplier')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>

                    {{-- TELEPON --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Telepon
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0">
                                <i data-feather="phone"></i>
                            </span>

                            <input type="text" name="telepon" class="form-control border-0 bg-light rounded-end-3"
                                placeholder="08xxxxxxxxxx" value="{{ old('telepon') }}">

                        </div>

                    </div>

                    {{-- PERUSAHAAN --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Perusahaan
                        </label>

                        <select name="id_perusahaan"
                            class="form-select border-0 bg-light rounded-3 @error('id_perusahaan') is-invalid @enderror">

                            <option value="">
                                -- Pilih Perusahaan --
                            </option>

                            @foreach($perusahaan as $item)

                            <option value="{{ $item->id_perusahaan }}">
                                {{ $item->nama_perusahaan }}
                            </option>

                            @endforeach

                        </select>

                        @error('id_perusahaan')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>

                    {{-- ALAMAT --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="5" class="form-control border-0 bg-light rounded-3"
                            placeholder="Masukkan alamat supplier">{{ old('alamat') }}</textarea>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-5 d-flex justify-content-end gap-2">

                    <a href="{{ route('supplier.index') }}" class="btn btn-light border px-4 rounded-3">

                        Batal

                    </a>

                    <button type="submit" class="btn btn-primary px-4 rounded-3 shadow-sm">

                        <i data-feather="save"></i>
                        Simpan Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection