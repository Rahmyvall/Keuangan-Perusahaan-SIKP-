@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">
        <div>
            <h4 class="mb-0 fw-bold">Data Mata Uang</h4>
            <small class="text-muted">Manajemen seluruh mata uang</small>
        </div>

        <a href="{{ route('mata-uang.create') }}" class="btn btn-primary px-4 rounded-3">
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
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Cari kode / nama / simbol...">
                    </div>
                    <div class="col-md-3">
                        <select name="sort" class="form-select">
                            <option value="kode" {{ request('sort') == 'kode' ? 'selected' : '' }}>Kode</option>
                            <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                            <option value="simbol" {{ request('sort') == 'simbol' ? 'selected' : '' }}>Simbol</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="direction" class="form-select">
                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>A-Z</option>
                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Z-A</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary w-100">
                            <i data-feather="search"></i> Cari
                        </button>
                        <a href="{{ route('mata-uang.index') }}" class="btn btn-light border">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Icon</th>
                            <th>Kode</th>
                            <th>Nama Mata Uang</th>
                            <th>Simbol</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $row)
                        <tr>
                            <td>{{ $data->firstItem() + $i }}</td>

                            <td>
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                    style="width:45px;height:45px;">
                                    <i data-feather="dollar-sign" style="width:24px;height:24px;"></i>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-dark px-3 py-2 rounded-pill fs-6">
                                    {{ $row->kode }}
                                </span>
                            </td>

                            <td class="fw-semibold">{{ $row->nama }}</td>
                            <td class="fs-4 fw-bold text-primary">{{ $row->simbol ?? '-' }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('mata-uang.show', $row->id_mata_uang) }}"
                                        class="btn btn-light border btn-sm">
                                        <i data-feather="eye"></i>
                                    </a>

                                    <a href="{{ route('mata-uang.edit', $row->id_mata_uang) }}"
                                        class="btn btn-light border btn-sm">
                                        <i data-feather="edit"></i>
                                    </a>

                                    <form action="{{ route('mata-uang.destroy', $row->id_mata_uang) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-light border btn-sm"
                                            onclick="return confirm('Hapus data mata uang ini?')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i data-feather="inbox" width="45"></i>
                                <h5 class="mt-3">Data belum tersedia</h5>
                                <p class="text-muted">Silakan tambahkan data mata uang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($data->hasPages())
            <div class="mt-4 d-flex justify-content-end">
                {{ $data->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>
    </div>

</div>

{{-- STYLE TAMBAHAN (opsional) --}}
<style>
.card-hover {
    transition: all 0.25s ease;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
}
</style>

@endsection