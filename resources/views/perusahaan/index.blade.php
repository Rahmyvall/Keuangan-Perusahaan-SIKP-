@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="mb-0 fw-bold">Data Perusahaan</h4>
            <small class="text-muted">Manajemen seluruh data perusahaan</small>
        </div>

        <a href="{{ route('perusahaan.create') }}"
           class="btn btn-primary px-4 rounded-3">
            <i data-feather="plus"></i> Tambah
        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm">
            <i data-feather="check-circle"></i>
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- GRID --}}
    <div class="row g-4 pb-5">

        @forelse($data as $row)
        <div class="col-md-6 col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover">

                <div class="card-body p-4">

                    {{-- HEADER CARD --}}
                    <div class="d-flex align-items-center mb-3">

                        {{-- LOGO --}}
                        <div class="me-3">
                            @if($row->logo)
                                <img src="{{ asset('storage/'.$row->logo) }}"
                                     width="50" height="50"
                                     class="rounded-circle border"
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:50px;height:50px;">
                                    <i data-feather="briefcase"></i>
                                </div>
                            @endif
                        </div>

                        {{-- NAME --}}
                        <div>
                            <div class="fw-bold">{{ $row->nama_perusahaan }}</div>
                            <small class="text-muted">{{ $row->email ?? '-' }}</small>
                        </div>

                    </div>

                    <hr class="my-3">

                    {{-- DETAIL --}}
                    <div class="mb-2">
                        <small class="text-muted">NPWP</small>
                        <div class="fw-semibold">{{ $row->npwp ?? '-' }}</div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Kota</small>
                        <div>{{ $row->kota ?? '-' }}</div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Telepon</small>
                        <div>{{ $row->telepon ?? '-' }}</div>
                    </div>

                    @isset($row->status)
                        <div class="mt-2">
                            <span class="badge rounded-pill px-3 py-2
                                {{ $row->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </div>
                    @endisset

                    <div class="text-muted small mt-3">
                        {{ optional($row->created_at)->format('d-m-Y') }}
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex gap-2 mt-3">

                        <a href="{{ route('perusahaan.show',$row->id_perusahaan) }}"
                           class="btn btn-light border btn-sm rounded-3">
                            <i data-feather="eye"></i>
                        </a>

                        <a href="{{ route('perusahaan.edit',$row->id_perusahaan) }}"
                           class="btn btn-light border btn-sm rounded-3">
                            <i data-feather="edit"></i>
                        </a>

                        <form action="{{ route('perusahaan.destroy',$row->id_perusahaan) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-light border btn-sm rounded-3"
                                    onclick="return confirm('Hapus data ini?')">
                                <i data-feather="trash-2"></i>
                            </button>

                        </form>

                    </div>

                </div>
            </div>

        </div>
        @empty

        <div class="col-12">
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i data-feather="inbox" width="45"></i>
                <h5 class="mt-3">Data belum tersedia</h5>
                <p class="text-muted">Silakan tambahkan data perusahaan</p>
            </div>
        </div>

        @endforelse

    </div>

    {{-- PAGINATION (FIXED + CLEAN) --}}
    @if($data->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-box">
            {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif

</div>

<style>
/* CARD HOVER (biarkan, sudah bagus) */
.card-hover {
    transition: all 0.25s ease;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
}

/* PAGINATION WRAPPER */
.pagination-box {
    background: #ffffff;
    padding: 10px 14px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    display: inline-flex;
    align-items: center;
}

/* PAGINATION BASE */
.pagination {
    margin: 0;
    display: flex;
    gap: 10px;
    align-items: center;
}

/* ITEM */
.pagination .page-item .page-link {
    border: none;
    border-radius: 10px !important;
    padding: 7px 12px;
    font-size: 14px;
    color: #475569;
    background: transparent;
    transition: all 0.2s ease;
}

/* HOVER */
.pagination .page-item .page-link:hover {
    background: #f1f5f9;
    color: #1d4ed8;
    transform: translateY(-1px);
}

/* ACTIVE */
.pagination .page-item.active .page-link {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 6px 15px rgba(37,99,235,0.25);
}

/* DISABLED */
.pagination .page-item.disabled .page-link {
    opacity: 0.4;
    pointer-events: none;
}

/* FIRST / LAST (prev-next) */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-weight: 600;
}

/* REMOVE OUTLINE BOOTSTRAP */
.pagination .page-link:focus {
    box-shadow: none;
}
</style>
@endsection
