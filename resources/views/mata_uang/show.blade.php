@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card border-0 shadow-sm rounded-4 text-center">
        <div class="card-body p-5">

            {{-- Icon --}}
            <div class="mb-3">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                     style="width:80px;height:80px;">
                    <i data-feather="dollar-sign"></i>
                </div>
            </div>

            {{-- Kode --}}
            <h4 class="fw-bold">
                <span class="badge bg-dark px-4 py-2 rounded-pill">
                    {{ $mataUang->kode }}
                </span>
            </h4>

            {{-- Nama --}}
            <h5 class="mt-3">{{ $mataUang->nama }}</h5>

            {{-- Simbol --}}
            <div class="display-5 text-primary fw-bold mt-3">
                {{ $mataUang->simbol ?? '-' }}
            </div>

            {{-- Actions --}}
            <div class="mt-4 d-flex justify-content-center gap-2">

                <a href="{{ route('mata-uang.edit', $mataUang->id_mata_uang) }}"
                   class="btn btn-warning text-white">
                    <i data-feather="edit"></i> Edit
                </a>

                <a href="{{ route('mata-uang.index') }}"
                   class="btn btn-light">
                    Kembali
                </a>

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
