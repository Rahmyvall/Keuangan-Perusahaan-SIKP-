@extends('layouts.app')

@section('title', 'Detail Jurnal - ' . ($jurnal->nomor_jurnal ?? 'Tidak Ditemukan'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h4 class="mb-0 fw-bold text-dark">
                                Detail Jurnal
                                <span class="text-primary">#{{ $jurnal->nomor_jurnal ?? '-' }}</span>
                            </h4>
                            @if($jurnal->tanggal)
                            <small class="text-muted">
                                Tanggal: {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d F Y') }}
                            </small>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            @if(!empty($jurnal) && !$jurnal->posted)
                            <a href="{{ route('jurnal.detail.create', $jurnal) }}" class="btn btn-primary btn-lg">
                                <i data-feather="plus-circle" class="me-2"></i> Tambah Detail
                            </a>
                            @endif
                            <a href="{{ route('jurnal.show', $jurnal) }}" class="btn btn-outline-secondary btn-lg">
                                <i data-feather="arrow-left" class="me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">Kode Akun</th>
                                    <th>Nama Akun</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Debit</th>
                                    <th class="text-end">Kredit</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($details ?? [] as $index => $detail)
                                <tr>
                                    <td class="fw-medium">{{ $index + 1 }}</td>
                                    <td>
                                        <strong class="text-primary">{{ $detail->akun->kode_akun ?? '-' }}</strong>
                                    </td>
                                    <td>{{ $detail->akun->nama_akun ?? '-' }}</td>
                                    <td class="text-muted small">{{ $detail->keterangan ?? '-' }}</td>
                                    <td class="text-end fw-medium text-success">
                                        @if($detail->debit > 0)
                                        Rp {{ number_format($detail->debit, 2) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-end fw-medium text-danger">
                                        @if($detail->kredit > 0)
                                        Rp {{ number_format($detail->kredit, 2) }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($jurnal) && !$jurnal->posted)
                                        <div class="btn-group">
                                            <a href="{{ route('jurnal.detail.edit', [$jurnal, $detail]) }}"
                                                class="btn btn-sm btn-warning">
                                                <i data-feather="edit-2"></i>
                                            </a>
                                            <form action="{{ route('jurnal.detail.destroy', [$jurnal, $detail]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin menghapus detail ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <span class="badge bg-success">Posted</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i data-feather="file-text" style="width: 48px; height: 48px;"
                                                class="text-muted mb-3"></i>
                                            <p class="text-muted mb-2">Belum ada detail transaksi</p>
                                            @if(!empty($jurnal) && !$jurnal->posted)
                                            <a href="{{ route('jurnal.detail.create', $jurnal) }}"
                                                class="btn btn-outline-primary">
                                                <i data-feather="plus"></i> Buat Detail Pertama
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light border-top border-2">
                                <tr class="fw-bold">
                                    <td colspan="4" class="text-end fs-5">Total :</td>
                                    <td class="text-end fs-5 text-success">
                                        Rp {{ number_format(($details ?? collect())->sum('debit'), 2) }}
                                    </td>
                                    <td class="text-end fs-5 text-danger">
                                        Rp {{ number_format(($details ?? collect())->sum('kredit'), 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
