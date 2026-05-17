@extends('layouts.app')

@section('content')
<div class="container-fluid py-3 px-4 print-area">

    {{-- ================= PRINT STYLE ================= --}}

    {{-- ================= HEADER (SCREEN) ================= --}}
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">

        <div>
            <h4 class="mb-0">Detail Depresiasi Aset</h4>
            <small class="text-muted">
                {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
            </small>
        </div>

        <button onclick="window.print()" class="btn btn-primary btn-sm">
            Print
        </button>

    </div>

    {{-- ================= HEADER (PRINT) ================= --}}
    <div class="d-none d-print-block print-title">
        <h4 class="mb-0">Detail Depresiasi Aset</h4>
        <small>
            Kode: {{ $aset->kode_aset }} - {{ $aset->nama_aset }}
        </small>
        <hr>
    </div>

    {{-- ================= SUMMARY CARD ================= --}}
    <div class="row g-3 mb-3 no-print">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Nilai Perolehan</small>
                    <h5 class="mb-0">
                        Rp {{ number_format($aset->nilai_perolehan, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Depresiasi</small>
                    <h5 class="mb-0 text-danger">
                        Rp {{ number_format($totalDepresiasi, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Nilai Buku</small>
                    <h5 class="mb-0 text-primary">
                        Rp {{ number_format($nilaiAkhir, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover table-striped align-middle mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Depresiasi</th>
                        <th>Akumulasi</th>
                        <th>Nilai Buku</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->periode_depresiasi)->format('Y-m') }}
                        </td>

                        <td>
                            Rp {{ number_format($item->nilai_depresiasi, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item->akumulasi_depresiasi, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item->nilai_buku, 0, ',', '.') }}
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Belum ada data depresiasi
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection
