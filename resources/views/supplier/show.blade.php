@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Detail Supplier
            </h3>

            <p class="text-muted mb-0">
                Informasi lengkap supplier
            </p>
        </div>

        <a href="{{ route('supplier.index') }}" class="btn btn-light border rounded-3 shadow-sm">

            <i data-feather="arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="bg-info" style="height: 6px;"></div>

        <div class="card-body p-5">

            {{-- PROFILE --}}
            <div class="text-center mb-5">

                <div class="bg-primary bg-opacity-10 rounded-circle
                            d-inline-flex align-items-center justify-content-center mb-3"
                    style="width:90px;height:90px;">

                    <i data-feather="truck" class="text-primary" style="width:40px;height:40px;"></i>

                </div>

                <h4 class="fw-bold mb-1">
                    {{ $supplier->nama_supplier }}
                </h4>

                <span class="badge bg-dark rounded-pill px-3 py-2">
                    {{ $supplier->kode_supplier ?? 'NO-CODE' }}
                </span>

            </div>

            {{-- DETAIL --}}
            <div class="row g-4">

                <div class="col-md-6">

                    <div class="bg-light rounded-4 p-4 h-100">

                        <small class="text-muted d-block mb-2">
                            Telepon
                        </small>

                        <h6 class="fw-bold mb-0">
                            {{ $supplier->telepon ?? '-' }}
                        </h6>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="bg-light rounded-4 p-4 h-100">

                        <small class="text-muted d-block mb-2">
                            Perusahaan
                        </small>

                        <h6 class="fw-bold mb-0">
                            {{ $supplier->perusahaan->nama_perusahaan ?? '-' }}
                        </h6>

                    </div>

                </div>

                <div class="col-12">

                    <div class="bg-light rounded-4 p-4">

                        <small class="text-muted d-block mb-2">
                            Alamat
                        </small>

                        <div class="fw-semibold">
                            {{ $supplier->alamat ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTION --}}
            <div class="mt-5 d-flex justify-content-end gap-2">

                <a href="{{ route('supplier.edit',$supplier->id_supplier) }}"
                    class="btn btn-warning text-white px-4 rounded-3 shadow-sm">

                    <i data-feather="edit"></i>
                    Edit

                </a>

                <form action="{{ route('supplier.destroy',$supplier->id_supplier) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger px-4 rounded-3 shadow-sm" onclick="return confirm('Hapus data ini?')">

                        <i data-feather="trash-2"></i>
                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
@endsection
