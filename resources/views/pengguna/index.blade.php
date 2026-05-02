@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Human Resource - Pengguna</h3>
    </div>

    <div class="row">
        @foreach($pengguna as $item)

        @php
            // Ambil inisial nama
            $words = explode(' ', $item->nama_lengkap);
            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

            // warna avatar random soft
            $colors = ['primary', 'success', 'danger', 'warning', 'info', 'secondary'];
            $color = $colors[$item->id_pengguna % count($colors)];
        @endphp

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">

            <div class="card border-0 shadow-sm h-100">

                <!-- HEADER -->
                <div class="card-body text-center">

                    <!-- AVATAR -->
                    <div class="mb-3">
                        <div class="rounded-circle bg-{{ $color }} text-white d-flex align-items-center justify-content-center mx-auto"
                             style="width:70px; height:70px; font-size:22px; font-weight:bold;">
                            {{ $initials }}
                        </div>
                    </div>

                    <!-- NAME -->
                    <h5 class="mb-1">{{ $item->nama_lengkap }}</h5>
                    <small class="text-muted">{{ $item->username }}</small>

                    <hr>

                    <!-- INFO -->
                    <p class="mb-1"><strong>Email:</strong> {{ $item->email ?? '-' }}</p>

                    <p class="mb-1">
                        <strong>Role:</strong>
                        <span class="badge bg-dark">
                            {{ ucfirst($item->role) }}
                        </span>
                    </p>

                    <p class="mb-1">
                        <strong>Perusahaan:</strong>
                        {{ $item->perusahaan->nama_perusahaan ?? '-' }}
                    </p>

                    <p class="mb-0 text-muted" style="font-size: 12px;">
                        Join: {{ $item->created_at }}
                    </p>

                </div>

                <!-- FOOTER STATUS -->
                <div class="card-footer bg-white border-0 text-center">

                    @if($item->is_active)
                        <span class="badge rounded-pill bg-success px-3 py-2">Active</span>
                    @else
                        <span class="badge rounded-pill bg-danger px-3 py-2">Inactive</span>
                    @endif

                </div>

            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection
