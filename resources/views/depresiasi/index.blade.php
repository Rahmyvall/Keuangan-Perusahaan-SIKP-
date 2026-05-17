@extends('layouts.app')

@section('content')
<div class="container-fluid py-3 px-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">Depresiasi Aset</h4>
            <small class="text-muted">Perhitungan depresiasi bulanan aset tetap</small>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">

                {{-- ASET --}}
                <div class="col-lg-6">
                    <label class="form-label">Aset</label>
                    <select name="id_aset" class="form-select">
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
                    <label class="form-label">Periode</label>
                    <input type="month" name="periode" class="form-control"
                           value="{{ request('periode') }}">
                </div>

                <div class="col-lg-1">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

                <div class="col-lg-2">
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- GENERATE --}}
    <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">

            <form method="POST" action="{{ url('/depresiasi/generate') }}">
                @csrf

                <div class="row g-3 align-items-end">
                    <div class="col-lg-3">
                        <label class="form-label">Generate Periode</label>
                        <input type="month" name="periode_depresiasi"
                               class="form-control"
                               value="{{ date('Y-m') }}">
                    </div>

                    <div class="col-lg-3">
                        <button class="btn btn-success w-100">
                            + Generate Depresiasi
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">

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
                        <th>Aksi</th>
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

                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->kode_aset ?? $aset->kode_aset ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <strong>
                                {{ $item->nama_aset ?? $aset->nama_aset ?? '-' }}
                            </strong>
                        </td>

                        <td>{{ $periode }}</td>

                        <td>
                            Rp {{ number_format($item->nilai_perolehan ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item->nilai_sisa ?? 0, 0, ',', '.') }}
                        </td>

                        <td>{{ $item->masa_manfaat ?? 0 }} th</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                Rp {{ number_format($item->nilai_depresiasi ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td>
                            Rp {{ number_format($item->akumulasi_depresiasi ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                Rp {{ number_format($item->nilai_buku ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('depresiasi.show', $item->id_aset) }}"
                               class="btn btn-sm btn-info">
                                Show
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 28px;"></i>
                            <p class="mb-0 mt-2">Belum ada data depresiasi</p>
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
