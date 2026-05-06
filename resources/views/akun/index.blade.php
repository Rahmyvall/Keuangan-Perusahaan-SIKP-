@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="fw-bold mb-0">Chart of Account</h4>
            <small class="text-muted">Manajemen akun perusahaan (COA)</small>
        </div>

        <a href="{{ route('akun.create') }}" class="btn btn-primary px-4 rounded-3">
            + Tambah Akun
        </a>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>Saldo</th>
                            <th>Level</th>
                            <th>Parent</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($data->groupBy('tipe_akun') as $tipe => $items)

                        {{-- HEADER TIPE --}}
                        <tr class="table-light">
                            <td colspan="9">
                                <strong>{{ strtoupper($tipe) }}</strong>
                            </td>
                        </tr>

                        @foreach($items as $i => $row)
                        <tr>
                            <td>{{ $i+1 }}</td>

                            <td class="fw-bold">
                                {{ $row->kode_akun }}
                            </td>

                            <td>
                                @if($row->parent_id) ↳ @endif
                                {{ $row->nama_akun }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $row->tipe_akun }}
                                </span>
                            </td>

                            <td>{{ $row->saldo_normal }}</td>
                            <td>{{ $row->level }}</td>
                            <td>{{ $row->parent->nama_akun ?? '-' }}</td>

                            <td>
                                <span class="badge {{ $row->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $row->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <td>
                                @include('akun.partials.action', ['row' => $row])
                            </td>

                        </tr>
                        @endforeach

                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection