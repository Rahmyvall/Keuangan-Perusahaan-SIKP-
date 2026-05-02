@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="mb-0 fw-bold">Data Mata Uang</h4>
            <small class="text-muted">Manajemen seluruh mata uang</small>
        </div>

        <a href="{{ route('mata-uang.create') }}"
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
{{-- SEARCH & FILTER --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body">

        <form method="GET" action="{{ route('mata-uang.index') }}">
            <div class="row g-2 align-items-center">

                {{-- SEARCH --}}
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari kode / nama / simbol...">
                </div>

                {{-- SORT --}}
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="kode" {{ request('sort') == 'kode' ? 'selected' : '' }}>Kode</option>
                        <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                        <option value="simbol" {{ request('sort') == 'simbol' ? 'selected' : '' }}>Simbol</option>
                    </select>
                </div>

                {{-- DIRECTION --}}
                <div class="col-md-2">
                    <select name="direction" class="form-select">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                {{-- BUTTON --}}
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary w-100">
                        <i data-feather="search"></i> Cari
                    </button>

                    <a href="{{ route('mata-uang.index') }}"
                       class="btn btn-light border">
                        Reset
                    </a>
                </div>

            </div>
        </form>

    </div>
</div>
    {{-- GRID --}}
    <div class="row g-4 pb-5">

        @forelse($data as $row)
        <div class="col-md-6 col-lg-3">

            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover">

                <div class="card-body p-4 text-center">

                    {{-- ICON --}}
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="width:60px;height:60px;">
                            <i data-feather="dollar-sign"></i>
                        </div>
                    </div>

                    {{-- KODE --}}
                    <h5 class="fw-bold mb-1">
                        <span class="badge bg-dark px-3 py-2 rounded-pill">
                            {{ $row->kode }}
                        </span>
                    </h5>

                    {{-- NAMA --}}
                    <div class="fw-semibold">
                        {{ $row->nama }}
                    </div>

                    {{-- SIMBOL --}}
                    <div class="text-primary fw-bold fs-4 mt-2">
                        {{ $row->simbol ?? '-' }}
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex justify-content-center gap-2 mt-4">

                        <a href="{{ route('mata-uang.show',$row->id_mata_uang) }}"
                           class="btn btn-light border btn-sm rounded-3">
                            <i data-feather="eye"></i>
                        </a>

                        <a href="{{ route('mata-uang.edit',$row->id_mata_uang) }}"
                           class="btn btn-light border btn-sm rounded-3">
                            <i data-feather="edit"></i>
                        </a>

                        <form action="{{ route('mata-uang.destroy',$row->id_mata_uang) }}"
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
                <p class="text-muted">Silakan tambahkan data mata uang</p>
            </div>
        </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($data->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <div class="pagination-box">
            {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif

</div>

{{-- STYLE --}}
<style>
.card-hover {
    transition: all 0.25s ease;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
}

.pagination-box {
    background: #ffffff;
    padding: 10px 14px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    display: inline-flex;
    align-items: center;
}

.pagination {
    margin: 0;
    display: flex;
    gap: 10px;
    align-items: center;
}

.pagination .page-item .page-link {
    border: none;
    border-radius: 10px !important;
    padding: 7px 12px;
    font-size: 14px;
    color: #475569;
    background: transparent;
}

.pagination .page-item.active .page-link {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 6px 15px rgba(37,99,235,0.25);
}

.pagination .page-link:focus {
    box-shadow: none;
}
</style>

@endsection
