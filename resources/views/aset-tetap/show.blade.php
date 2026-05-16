{{-- resources/views/aset-tetap/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Aset - ' . $asetTetap->kode_aset)

@section('content')

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-building text-primary me-2"></i>
                Detail Aset Tetap
            </h3>

            <h4 class="text-muted">
                {{ $asetTetap->kode_aset }}
            </h4>
        </div>

        <div class="btn-group">

            <a href="{{ route('aset-tetap.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

            <a href="{{ route('aset-tetap.edit', $asetTetap->id_aset) }}" class="btn btn-warning">

                <i class="fas fa-edit"></i>
                Edit

            </a>

            <button onclick="window.print()" class="btn btn-success">

                <i class="fas fa-print"></i>
                Cetak

            </button>

            <form action="{{ route('aset-tetap.destroy', $asetTetap->id_aset) }}" method="POST" class="d-inline">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus aset tetap ini?')">

                    <i class="fas fa-trash"></i>
                    Hapus

                </button>

            </form>

        </div>

    </div>

    <div class="row">

        <!-- Main Content -->
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">
                            Informasi Aset Tetap
                        </h5>

                        <span class="badge bg-primary fs-6 px-4 py-2">
                            ASET TETAP
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <!-- Left -->
                        <div class="col-md-6">

                            <table class="table table-borderless">

                                <tr>
                                    <th width="170" class="text-muted">
                                        Kode Aset
                                    </th>

                                    <td class="fw-bold">
                                        {{ $asetTetap->kode_aset }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">
                                        Nama Aset
                                    </th>

                                    <td>
                                        {{ $asetTetap->nama_aset }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">
                                        Tanggal Pengadaan
                                    </th>

                                    <td>
                                        {{ \Carbon\Carbon::parse($asetTetap->tanggal_pengadaan)->format('d F Y') }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">
                                        Perusahaan
                                    </th>

                                    <td>
                                        {{ $asetTetap->perusahaan->nama_perusahaan ?? '-' }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                        <!-- Right -->
                        <div class="col-md-6">

                            <table class="table table-borderless">

                                <tr>
                                    <th width="170" class="text-muted">
                                        Akun Aset
                                    </th>

                                    <td>

                                        @if($asetTetap->akunAset)

                                        <strong>
                                            {{ $asetTetap->akunAset->kode_akun }}
                                        </strong>

                                        - {{ $asetTetap->akunAset->nama_akun }}

                                        @else
                                        -
                                        @endif

                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">
                                        Masa Manfaat
                                    </th>

                                    <td>
                                        {{ $asetTetap->masa_manfaat }} Tahun
                                    </td>
                                </tr>

                                <tr>
                                    <th class="text-muted">
                                        Nilai Sisa
                                    </th>

                                    <td>
                                        Rp {{ number_format($asetTetap->nilai_sisa, 0, ',', '.') }}
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>

                    <hr class="my-4">

                    <!-- Ringkasan Nilai -->
                    <h5 class="mb-3">
                        Ringkasan Nilai Aset
                    </h5>

                    @php
                    $penyusutan = 0;

                    if($asetTetap->masa_manfaat > 0){
                    $penyusutan =
                    ($asetTetap->nilai_perolehan - $asetTetap->nilai_sisa)
                    / $asetTetap->masa_manfaat;
                    }
                    @endphp

                    <div class="bg-light p-4 rounded border">

                        <table class="table table-borderless mb-0">

                            <tr>

                                <th width="250">
                                    Nilai Perolehan
                                </th>

                                <td class="text-end fw-bold">
                                    Rp {{ number_format($asetTetap->nilai_perolehan, 0, ',', '.') }}
                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Nilai Sisa
                                </th>

                                <td class="text-end">
                                    Rp {{ number_format($asetTetap->nilai_sisa, 0, ',', '.') }}
                                </td>

                            </tr>

                            <tr>

                                <th>
                                    Penyusutan per Tahun
                                </th>

                                <td class="text-end">
                                    Rp {{ number_format($penyusutan, 0, ',', '.') }}
                                </td>

                            </tr>

                            <tr class="border-top border-2 border-primary">

                                <th class="fs-5">
                                    Nilai yang Disusutkan
                                </th>

                                <td class="text-end fs-4 fw-bold text-primary">

                                    Rp
                                    {{ number_format(($asetTetap->nilai_perolehan - $asetTetap->nilai_sisa), 0, ',', '.') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center py-5">

                    <i class="fas fa-building fa-7x text-primary opacity-10 mb-4"></i>

                    <h4>Aset Tetap</h4>

                    <h2 class="mt-3 mb-0 text-primary">
                        {{ $asetTetap->masa_manfaat }} Tahun
                    </h2>

                    <p class="text-muted mt-2">
                        Masa Manfaat Aset
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
function printAset() {
    window.print();
}
</script>

<style>
@media print {

    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    body {
        background: #fff !important;
        font-size: 12px;
        color: #000;
    }

    .navbar,
    .sidebar,
    .btn-group,
    footer,
    .card-header .btn {
        display: none !important;
    }

    .container-fluid {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .row {
        display: block !important;
    }

    .col-lg-8,
    .col-lg-4,
    .col-md-6 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        margin-bottom: 15px !important;
        page-break-inside: avoid;
    }

    .card-header {
        background: #fff !important;
        border-bottom: 1px solid #000 !important;
    }

    table {
        width: 100% !important;
        font-size: 12px;
    }

    th,
    td {
        padding: 4px 6px !important;
        vertical-align: top;
    }

    .badge {
        border: 1px solid #000 !important;
        color: #000 !important;
        background: #fff !important;
    }

    .text-primary,
    .text-success,
    .text-warning,
    .text-danger,
    .text-muted {
        color: #000 !important;
    }

    i {
        display: none !important;
    }

    h2,
    h3,
    h4,
    h5 {
        margin-bottom: 10px !important;
    }
}
</style>
@endpush
