@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="row mb-4">

        <div class="col-md-8">

            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-bank2 text-primary me-2"></i>
                Data Rekening Bank
            </h2>

            <p class="text-muted mb-0">
                Management rekening bank perusahaan secara lengkap dan modern
            </p>

        </div>

        <div class="col-md-4 text-md-end mt-3 mt-md-0">

            <a href="{{ route('rekening-bank.create') }}" class="btn btn-primary px-4 shadow rounded-3">

                <i class="bi bi-plus-circle-fill me-2"></i>
                Tambah Rekening

            </a>

        </div>

    </div>

    {{-- STATISTIC CARD --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Rekening
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $rekeningBank->count() }}
                            </h3>

                        </div>

                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">

                            <i class="bi bi-credit-card text-primary fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Saldo
                            </p>

                            <h5 class="fw-bold text-success mb-0">

                                Rp
                                {{ number_format($rekeningBank->sum('saldo_awal'), 0, ',', '.') }}

                            </h5>

                        </div>

                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">

                            <i class="bi bi-cash-stack text-success fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Perusahaan
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $rekeningBank->pluck('id_perusahaan')->unique()->count() }}
                            </h3>

                        </div>

                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">

                            <i class="bi bi-buildings text-warning fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Bank Aktif
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $rekeningBank->pluck('nama_bank')->unique()->count() }}
                            </h3>

                        </div>

                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">

                            <i class="bi bi-bank text-info fs-4"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert">
        </button>

    </div>

    @endif

    {{-- MAIN TABLE CARD --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

        {{-- CARD HEADER --}}
        <div class="card-header bg-white border-0 py-3 px-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h5 class="fw-bold mb-1">
                        Daftar Rekening Bank
                    </h5>

                    <small class="text-muted">
                        Seluruh data rekening perusahaan tersimpan disini
                    </small>

                </div>

                {{-- SEARCH --}}
                <div class="mt-3 mt-md-0">

                    <input type="text" class="form-control rounded-3" placeholder="Cari rekening bank..."
                        style="width: 250px;">

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="table align-middle table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4 py-3">#</th>
                        <th>Bank</th>
                        <th>Nomor Rekening</th>
                        <th>Pemilik Rekening</th>
                        <th>Akun Kas</th>
                        <th>Saldo</th>
                        <th>Perusahaan</th>
                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($rekeningBank as $item)

                    <tr>

                        {{-- NO --}}
                        <td class="ps-4 fw-semibold text-secondary">
                            {{ $loop->iteration }}
                        </td>

                        {{-- BANK --}}
                        <td>

                            <div class="d-flex align-items-center">

                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">

                                    <i class="bi bi-bank2 text-primary"></i>

                                </div>

                                <div>

                                    <div class="fw-bold text-dark">
                                        {{ $item->nama_bank }}
                                    </div>

                                    <small class="text-muted">
                                        Bank Provider
                                    </small>

                                </div>

                            </div>

                        </td>

                        {{-- NO REKENING --}}
                        <td>

                            <span class="badge bg-light text-dark border px-3 py-2 fs-6">

                                {{ $item->nomor_rekening }}

                            </span>

                        </td>

                        {{-- NAMA --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $item->nama_rekening }}

                            </div>

                        </td>

                        {{-- AKUN --}}
                        <td>

                            <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">

                                {{ $item->akunKas->nama_akun ?? '-' }}

                            </span>

                        </td>

                        {{-- SALDO --}}
                        <td>

                            <div class="fw-bold text-success fs-6">

                                Rp
                                {{ number_format($item->saldo_awal, 0, ',', '.') }}

                            </div>

                        </td>

                        {{-- PERUSAHAAN --}}
                        <td>

                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">

                                {{ $item->perusahaan->nama_perusahaan ?? '-' }}

                            </span>

                        </td>

                        {{-- ACTION --}}
                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('rekening-bank.show', $item->id_rekening) }}"
                                    class="btn btn-light btn-sm border shadow-sm rounded-3">

                                    <i class="bi bi-eye-fill text-primary"></i>

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('rekening-bank.edit', $item->id_rekening) }}"
                                    class="btn btn-warning btn-sm text-white shadow-sm rounded-3">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('rekening-bank.destroy', $item->id_rekening) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm rounded-3"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                        <i class="bi bi-trash-fill"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center py-5">

                            <div class="py-5">

                                <div class="mb-3">

                                    <i class="bi bi-bank2 text-secondary" style="font-size: 70px;"></i>

                                </div>

                                <h4 class="fw-bold text-dark">
                                    Data Rekening Kosong
                                </h4>

                                <p class="text-muted">

                                    Belum ada data rekening bank yang tersedia.

                                </p>

                                <a href="{{ route('rekening-bank.create') }}" class="btn btn-primary rounded-3 px-4">

                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Rekening Pertama

                                </a>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">

        <div class="text-muted small">

            Menampilkan
            {{ $rekeningBank->firstItem() ?? 0 }}
            sampai
            {{ $rekeningBank->lastItem() ?? 0 }}
            dari
            {{ $rekeningBank->total() }}
            data

        </div>

        <div>

            {{ $rekeningBank->links() }}

        </div>

    </div>

</div>

@endsection
