@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Saldo Awal</h3>
            <small class="text-muted">Manajemen saldo awal akun & periode</small>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif


    {{-- ================= FILTER ================= --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('saldo-awal.index') }}">
                <div class="row g-2">

                    <div class="col-md-5">
                        <select name="id_akun" class="form-control">
                            <option value="">Semua Akun</option>
                            @foreach($akunList as $akun)
                            <option value="{{ $akun->id_akun }}"
                                {{ request('id_akun') == $akun->id_akun ? 'selected' : '' }}>
                                {{ $akun->nama_akun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="month" name="periode" class="form-control" value="{{ request('periode') }}">
                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i>
                        </button>

                        <a href="{{ route('saldo-awal.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>

                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- ================= FORM INPUT ================= --}}
    <div class="card shadow-sm border-0 mb-3">

        <div class="card-header bg-primary text-white">
            <i class="bi bi-plus-circle"></i> Tambah Saldo Awal
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('saldo-awal.store') }}">
                @csrf

                <div class="row g-3">

                    <div class="col-md-3">
                        <select name="id_akun" class="form-control" required>
                            <option value="">Pilih Akun</option>
                            @foreach($akunList as $akun)
                            <option value="{{ $akun->id_akun }}">
                                {{ $akun->nama_akun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="id_periode" class="form-control" required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodeList as $periode)
                            <option value="{{ $periode->id_periode }}">
                                {{ $periode->nama_periode ?? ('Periode #' . $periode->id_periode) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="debit" class="form-control" placeholder="Debit">
                    </div>

                    <div class="col-md-2">
                        <input type="number" name="kredit" class="form-control" placeholder="Kredit">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success w-100">
                            <i class="bi bi-save"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>


    {{-- ================= TABLE ================= --}}
    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <span class="fw-bold">
                <i class="bi bi-table"></i> Data Saldo Awal
            </span>
            <span class="text-muted small">
                Total: {{ $data->total() }} data
            </span>
        </div>

        <div class="card-body p-0 table-responsive">

            <table class="table table-hover table-striped mb-0 align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Akun</th>
                        <th>Periode</th>
                        <th class="text-end">Debit</th>
                        <th class="text-end">Kredit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $key => $row)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>

                        <td class="fw-semibold">
                            {{ $row->akun->nama_akun ?? '-' }}
                        </td>

                        <td>
                            {{ $row->periode->nama_periode ?? ('Periode #' . $row->id_periode) }}
                        </td>

                        <td class="text-end text-success fw-semibold">
                            Rp {{ number_format($row->debit, 0, ',', '.') }}
                        </td>

                        <td class="text-end text-danger fw-semibold">
                            Rp {{ number_format($row->kredit, 0, ',', '.') }}
                        </td>

                        <td class="text-center">

                            <form action="{{ route('saldo-awal.destroy', $row->id_saldo) }}" method="POST"
                                onsubmit="return confirm('Hapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white">
            {{ $data->links() }}
        </div>

    </div>

</div>
@endsection
