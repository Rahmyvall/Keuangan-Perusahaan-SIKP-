@extends('layouts.app')

@section('content')

{{-- BOOTSTRAP ICON --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid py-4 px-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
                Depresiasi Aset
            </h3>
            <small class="text-muted">
                Perhitungan depresiasi bulanan aset tetap
            </small>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">

            <form method="GET" class="row g-3 align-items-end">

                {{-- ASET --}}
                <div class="col-lg-6">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-box-seam me-1"></i>
                        Aset
                    </label>

                    <select name="id_aset" class="form-select rounded-3">
                        <option value="">Semua Aset</option>

                        @foreach ($asetList as $aset)
                        <option value="{{ $aset->id_aset }}"
                            {{ request('id_aset') == $aset->id_aset ? 'selected' : '' }}>
                            {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- PERIODE --}}
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i>
                        Periode
                    </label>

                    <input type="month" name="periode" class="form-control rounded-3" value="{{ request('periode') }}">
                </div>

                {{-- FILTER BUTTON --}}
                <div class="col-lg-1">
                    <button class="btn btn-primary rounded-3 shadow-sm w-100">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                </div>

                {{-- RESET --}}
                <div class="col-lg-2">
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary rounded-3 w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- GENERATE --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">

            <form method="POST" action="{{ url('/depresiasi/generate') }}">
                @csrf

                <div class="row g-3 align-items-end">

                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-calendar-plus me-1"></i>
                            Generate Periode
                        </label>

                        <input type="month" name="periode_depresiasi" class="form-control rounded-3"
                            value="{{ date('Y-m') }}">
                    </div>

                    <div class="col-lg-3">
                        <button class="btn btn-success rounded-3 shadow-sm w-100">
                            <i class="bi bi-plus-circle-fill me-1"></i>
                            Generate Depresiasi
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Aset</th>
                        <th>Nama Aset</th>
                        <th>Periode</th>
                        <th>Perolehan</th>
                        <th>Sisa</th>
                        <th>Manfaat</th>
                        <th>Depresiasi</th>
                        <th>Akumulasi</th>
                        <th>Nilai Buku</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $item)

                    @php
                    $aset = $item->aset ?? null;

                    $periode = $item->periode_depresiasi
                    ? \Carbon\Carbon::parse($item->periode_depresiasi)->format('Y-m')
                    : '-';
                    @endphp

                    <tr>

                        <td>
                            {{ $loop->iteration + ($data->firstItem() - 1) }}
                        </td>

                        {{-- KODE --}}
                        <td>
                            <span class="badge rounded-pill bg-secondary-subtle text-dark px-3 py-2">
                                {{ $item->kode_aset ?? $aset->kode_aset ?? '-' }}
                            </span>
                        </td>

                        {{-- NAMA --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $item->nama_aset ?? $aset->nama_aset ?? '-' }}
                            </div>
                        </td>

                        {{-- PERIODE --}}
                        <td>
                            <span class="text-muted">
                                {{ $periode }}
                            </span>
                        </td>

                        {{-- PEROLEHAN --}}
                        <td class="fw-semibold">
                            Rp {{ number_format($item->nilai_perolehan ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- SISA --}}
                        <td>
                            Rp {{ number_format($item->nilai_sisa ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- MANFAAT --}}
                        <td>
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                {{ $item->masa_manfaat ?? 0 }} th
                            </span>
                        </td>

                        {{-- DEPRESIASI --}}
                        <td>
                            <span class="badge bg-warning-subtle text-dark rounded-pill px-3 py-2">
                                Rp {{ number_format($item->nilai_depresiasi ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- AKUMULASI --}}
                        <td>
                            Rp {{ number_format($item->akumulasi_depresiasi ?? 0, 0, ',', '.') }}
                        </td>

                        {{-- NILAI BUKU --}}
                        <td>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                Rp {{ number_format($item->nilai_buku ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">

                            <a href="{{ route('depresiasi.show', $item->id_aset) }}"
                                class="btn btn-sm btn-info rounded-circle shadow-sm" title="Detail">

                                <i class="bi bi-eye-fill"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="11" class="text-center py-5 text-muted">

                            <i class="bi bi-inbox" style="font-size: 50px;"></i>

                            <p class="mt-3 mb-0 fw-semibold">
                                Belum ada data depresiasi
                            </p>

                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="card-footer bg-white border-0 py-3">
            {{ $data->links() }}
        </div>

    </div>

</div>

@endsection
