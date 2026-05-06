@extends('layouts.app')

@section('title', 'Detail Jurnal')

@section('content')
<div class="container-fluid">

    <!-- Header + Summary Cards -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h3 class="mb-1">
                <i class="fas fa-file-alt text-primary"></i> Detail Jurnal
            </h3>
            @if(isset($jurnal))
            <p class="text-muted mb-0">
                <strong>{{ $jurnal->no_jurnal ?? '-' }}</strong> —
                {{ $jurnal->tanggal?->format('d F Y') }}
            </p>
            @endif
        </div>

        <div>
            <a href="{{ route('jurnal.details.create', ['id_jurnal' => $jurnal->id_jurnal ?? '']) }}"
                class="btn btn-primary shadow-sm">
                <i class="fas fa-plus"></i> Tambah Detail Baru
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Debit</h6>
                            <h4 class="mb-0 fw-bold">
                                Rp {{ number_format($details->sum('debit'), 2) }}
                            </h4>
                        </div>
                        <i class="fas fa-arrow-down fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 opacity-75">Total Kredit</h6>
                            <h4 class="mb-0 fw-bold">
                                Rp {{ number_format($details->sum('kredit'), 2) }}
                            </h4>
                        </div>
                        <i class="fas fa-arrow-up fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-0 opacity-75">Selisih (Balance)</h6>
                            <h4 class="mb-0 fw-bold">
                                Rp {{ number_format($details->sum('debit') - $details->sum('kredit'), 2) }}
                            </h4>
                        </div>
                        <i class="fas fa-balance-scale fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">Daftar Detail Jurnal</h5>
                </div>
                <div class="col-auto">
                    <input type="text" id="searchTable" class="form-control form-control-sm"
                        placeholder="Cari akun atau keterangan...">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="jurnalDetailTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode Akun</th>
                            <th>Nama Akun</th>
                            <th>Keterangan</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Kredit</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->akun->kode_akun ?? '-' }}</strong></td>
                            <td>{{ $item->akun->nama_akun ?? '-' }}</td>
                            <td class="text-muted small">{{ Str::limit($item->keterangan, 80) }}</td>
                            <td class="text-end text-success fw-bold">
                                @if($item->debit > 0)
                                {{ number_format($item->debit, 2) }}
                                @else <span class="text-muted">-</span> @endif
                            </td>
                            <td class="text-end text-danger fw-bold">
                                @if($item->kredit > 0)
                                {{ number_format($item->kredit, 2) }}
                                @else <span class="text-muted">-</span> @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('jurnal.details.edit', $item) }}" class="btn btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jurnal-detail.destroy', $item->id_detail) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin menghapus detail ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Belum ada detail jurnal untuk saat ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Menampilkan {{ $details->firstItem() ?? 0 }} - {{ $details->lastItem() ?? 0 }}
                    dari {{ $details->total() }} data
                </div>
                <div>
                    {{ $details->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th,
.table td {
    vertical-align: middle;
}

.card {
    border-radius: 12px;
}

.btn-group .btn {
    border-radius: 6px;
}

#searchTable {
    width: 280px;
}
</style>
@endpush

@push('scripts')
<script>
// Live Search
document.getElementById('searchTable').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#jurnalDetailTable tbody tr');

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>
@endpush
