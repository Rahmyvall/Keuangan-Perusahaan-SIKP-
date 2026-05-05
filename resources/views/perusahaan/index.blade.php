@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="mb-0 fw-bold">Data Perusahaan</h4>
            <small class="text-muted">Manajemen seluruh data perusahaan</small>
        </div>

        <a href="{{ route('perusahaan.create') }}" class="btn btn-primary px-4 rounded-3">
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

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="datatable">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NPWP</th>
                            <th>Kota</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $i => $row)
                        <tr>

                            {{-- FIX PAGINATION INDEX --}}
                            <td>{{ $data->firstItem() + $i }}</td>

                            <td>
                                @if($row->logo)
                                <img src="{{ asset('storage/'.$row->logo) }}" width="40" height="40"
                                    class="rounded-circle border" style="object-fit: cover;">
                                @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:40px;height:40px;">
                                    <i data-feather="briefcase"></i>
                                </div>
                                @endif
                            </td>

                            <td class="fw-semibold">{{ $row->nama_perusahaan }}</td>
                            <td>{{ $row->email ?? '-' }}</td>
                            <td>{{ $row->npwp ?? '-' }}</td>
                            <td>{{ $row->kota ?? '-' }}</td>
                            <td>{{ $row->telepon ?? '-' }}</td>

                            <td>
                                @if($row->status)
                                <span class="badge rounded-pill px-3 py-2
                                        {{ $row->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($row->status) }}
                                </span>
                                @else
                                -
                                @endif
                            </td>

                            <td>{{ $row->created_at?->format('d-m-Y') }}</td>

                            <td>
                                <div class="d-flex gap-1">

                                    <a href="{{ route('perusahaan.show',$row->id_perusahaan) }}"
                                        class="btn btn-light border btn-sm">
                                        <i data-feather="eye"></i>
                                    </a>

                                    <a href="{{ route('perusahaan.edit',$row->id_perusahaan) }}"
                                        class="btn btn-light border btn-sm">
                                        <i data-feather="edit"></i>
                                    </a>

                                    <form action="{{ route('perusahaan.destroy',$row->id_perusahaan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-light border btn-sm"
                                            onclick="return confirm('Hapus data ini?')">
                                            <i data-feather="trash-2"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <nav aria-label="Page navigation">
                    {{ $data->links('pagination::bootstrap-5') }}
                </nav>
            </div>

        </div>
    </div>

</div>
@endsection