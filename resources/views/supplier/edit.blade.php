@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Edit Supplier
            </h3>

            <p class="text-muted mb-0">
                Update informasi supplier
            </p>
        </div>

        <a href="{{ route('supplier.index') }}" class="btn btn-light border rounded-3 shadow-sm">

            <i data-feather="arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="bg-warning" style="height: 6px;"></div>

        <div class="card-body p-5">

            <form action="{{ route('supplier.update',$supplier->id_supplier) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Kode Supplier
                        </label>

                        <input type="text" name="kode_supplier" class="form-control border-0 bg-light rounded-3"
                            value="{{ old('kode_supplier',$supplier->kode_supplier) }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nama Supplier
                        </label>

                        <input type="text" name="nama_supplier" class="form-control border-0 bg-light rounded-3"
                            value="{{ old('nama_supplier',$supplier->nama_supplier) }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Telepon
                        </label>

                        <input type="text" name="telepon" class="form-control border-0 bg-light rounded-3"
                            value="{{ old('telepon',$supplier->telepon) }}">

                    </div>

                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Perusahaan
                        </label>

                        <select name="id_perusahaan" class="form-select border-0 bg-light rounded-3">

                            @foreach($perusahaan as $item)

                            <option value="{{ $item->id_perusahaan }}"
                                {{ $supplier->id_perusahaan == $item->id_perusahaan ? 'selected' : '' }}>

                                {{ $item->nama_perusahaan }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="5"
                            class="form-control border-0 bg-light rounded-3">{{ old('alamat',$supplier->alamat) }}</textarea>

                    </div>

                </div>

                <div class="mt-5 d-flex justify-content-end gap-2">

                    <a href="{{ route('supplier.index') }}" class="btn btn-light border px-4 rounded-3">

                        Batal

                    </a>

                    <button type="submit" class="btn btn-warning text-white px-4 rounded-3 shadow-sm">

                        <i data-feather="save"></i>
                        Update Data

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
