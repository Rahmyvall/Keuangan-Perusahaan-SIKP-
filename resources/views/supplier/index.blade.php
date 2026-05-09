@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="mb-1 fw-bold">
                <i data-feather="truck" class="me-2 text-primary"></i>
                Data Supplier
            </h4>

            <small class="text-muted">
                Manajemen seluruh data supplier perusahaan
            </small>
        </div>

        <a href="{{ route('supplier.create') }}" class="btn btn-primary px-4 rounded-3 shadow-sm">

            <i data-feather="plus" class="me-1"></i>
            Tambah

        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0">

        <div class="d-flex align-items-center">
            <i data-feather="check-circle" class="me-2"></i>

            <span>{{ session('success') }}</span>
        </div>

        <button class="btn-close" data-bs-dismiss="alert"></button>

    </div>
    @endif

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-body">

            {{-- SEARCH --}}
            <div class="d-flex justify-content-end mb-4">

                <div class="position-relative" style="width: 280px;">

                    <i data-feather="search" class="position-absolute text-muted"
                        style="top: 12px; left: 12px; width:18px;">
                    </i>

                    <input type="text" id="searchInput" class="form-control rounded-3 ps-5"
                        placeholder="Cari supplier...">

                </div>

            </div>

            {{-- TABLE --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle" id="datatable">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Supplier</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Perusahaan</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($data as $i => $row)

                        <tr>

                            {{-- NUMBER --}}
                            <td class="fw-semibold">
                                {{ $data->firstItem() + $i }}
                            </td>

                            {{-- KODE --}}
                            <td>

                                @if($row->kode_supplier)
                                <span class="badge bg-dark rounded-pill px-3 py-2">
                                    {{ $row->kode_supplier }}
                                </span>
                                @else
                                -
                                @endif

                            </td>

                            {{-- NAMA --}}
                            <td>

                                <div class="d-flex align-items-center">

                                    <div class="bg-primary bg-opacity-10 rounded-circle
                                                    d-flex align-items-center justify-content-center me-3"
                                        style="width:45px;height:45px;">

                                        <i data-feather="user" class="text-primary"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold text-dark">
                                            {{ $row->nama_supplier }}
                                        </div>

                                        <small class="text-muted">
                                            Supplier Perusahaan
                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- ALAMAT --}}
                            <td>

                                <span class="text-muted">
                                    {{ $row->alamat ?? '-' }}
                                </span>

                            </td>

                            {{-- TELEPON --}}
                            <td>

                                @if($row->telepon)
                                <span class="text-dark">
                                    <i data-feather="phone" style="width:14px;height:14px;"
                                        class="me-1 text-success"></i>

                                    {{ $row->telepon }}
                                </span>
                                @else
                                -
                                @endif

                            </td>

                            {{-- PERUSAHAAN --}}
                            <td>

                                @if($row->perusahaan)
                                <span class="badge bg-info-subtle text-info-emphasis
                                                     px-3 py-2 rounded-pill">

                                    {{ $row->perusahaan->nama_perusahaan }}

                                </span>
                                @else
                                -
                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td>

                                <div class="d-flex gap-1">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('supplier.show',$row->id_supplier) }}"
                                        class="btn btn-light border btn-sm rounded-3 shadow-sm">

                                        <i data-feather="eye"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('supplier.edit',$row->id_supplier) }}"
                                        class="btn btn-light border btn-sm rounded-3 shadow-sm">

                                        <i data-feather="edit"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('supplier.destroy',$row->id_supplier) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-light border btn-sm rounded-3 shadow-sm"
                                            onclick="return confirm('Hapus data ini?')">

                                            <i data-feather="trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <div class="d-flex flex-column align-items-center">

                                    <i data-feather="inbox" class="text-muted mb-3" style="width:50px;height:50px;"></i>

                                    <h5 class="fw-bold text-muted">
                                        Data supplier kosong
                                    </h5>

                                    <small class="text-muted">
                                        Silakan tambahkan supplier baru
                                    </small>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-4 d-flex justify-content-end">

                <nav aria-label="Page navigation">
                    {{ $data->links('pagination::bootstrap-5') }}
                </nav>

            </div>

        </div>

    </div>

</div>

{{-- SEARCH SCRIPT --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {

    let value = this.value.toLowerCase();

    let rows = document.querySelectorAll('#datatable tbody tr');

    rows.forEach(row => {

        let text = row.innerText.toLowerCase();

        row.style.display = text.includes(value) ?
            '' :
            'none';

    });

});
</script>
@endsection
