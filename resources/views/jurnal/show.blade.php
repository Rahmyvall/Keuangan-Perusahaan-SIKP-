@extends('layouts.app')

@section('title', 'Detail Jurnal')

@php
function rupiah($angka)
{
return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
}
@endphp

@section('content')
<div class="container-fluid">

    <div class="card">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Jurnal: <strong>{{ $jurnal->nomor_jurnal }}</strong>
            </h5>

            <div>
                @if(!$jurnal->posted)
                <a href="{{ route('jurnal.edit', $jurnal) }}" class="btn btn-warning btn-sm">
                    Edit
                </a>
                @endif

                <a href="{{ route('jurnal.index') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </div>

        </div>

        <div class="card-body">

            {{-- INFO UTAMA --}}
            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Tanggal</strong><br>
                    {{ optional($jurnal->tanggal)->format('d F Y') }}
                </div>

                <div class="col-md-3">
                    <strong>Tipe Jurnal</strong><br>
                    <span class="badge bg-primary">
                        {{ $jurnal->tipe_jurnal }}
                    </span>
                </div>

                <div class="col-md-3">
                    <strong>Status</strong><br>

                    @if($jurnal->posted)
                    <span class="badge bg-success">Posted</span>
                    @else
                    <span class="badge bg-warning text-dark">Draft</span>
                    @endif
                </div>

                <div class="col-md-3">
                    <strong>Dibuat Oleh</strong><br>
                    {{ optional($jurnal->creator)->nama ?? '-' }}
                </div>

            </div>

            {{-- INFO RELASI --}}
            <div class="row mb-3">

                <div class="col-md-3">
                    <strong>Periode</strong><br>
                    {{ optional($jurnal->periode)->nama_periode ?? '-' }}
                </div>

                <div class="col-md-3">
                    <strong>Perusahaan</strong><br>
                    {{ optional($jurnal->perusahaan)->nama_perusahaan ?? '-' }}
                </div>

                <div class="col-md-3">
                    <strong>Approved By</strong><br>
                    {{ optional($jurnal->approver)->nama ?? '-' }}
                </div>

                <div class="col-md-3">
                    <strong>Approved At</strong><br>
                    {{ optional($jurnal->approved_at)?->format('d F Y H:i') ?? '-' }}
                </div>

            </div>

            <hr>

            {{-- DESKRIPSI --}}
            <div class="mb-3">
                <strong>Deskripsi</strong>
                <p class="mt-2">{{ $jurnal->deskripsi }}</p>
            </div>

            <hr>

            {{-- DETAIL JURNAL --}}
            <h5 class="mb-3">Detail Jurnal</h5>

            @php
            $details = $jurnal->details ?? collect();
            @endphp

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Akun</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Kredit</th>
                            <th>Keterangan</th>

                            @if(!$jurnal->posted)
                            <th width="80">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($details as $detail)
                        <tr>

                            <td>
                                {{ optional($detail->akun)->kode_akun }}
                                -
                                {{ optional($detail->akun)->nama_akun }}
                            </td>

                            <td class="text-end">
                                {{ rupiah($detail->debit) }}
                            </td>

                            <td class="text-end">
                                {{ rupiah($detail->kredit) }}
                            </td>

                            <td>
                                {{ $detail->keterangan }}
                            </td>

                            @if(!$jurnal->posted)
                            <td>
                                <form action="{{ route('jurnal-detail.destroy', $detail) }}" method="POST"
                                    onsubmit="return confirm('Hapus baris ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>
                            </td>
                            @endif

                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $jurnal->posted ? 4 : 5 }}" class="text-center py-4 text-muted">
                                Belum ada detail jurnal
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="table-info">
                        <tr>
                            <th>Total</th>

                            <th class="text-end">
                                {{ rupiah($details->sum('debit')) }}
                            </th>

                            <th class="text-end">
                                {{ rupiah($details->sum('kredit')) }}
                            </th>

                            <th colspan="{{ $jurnal->posted ? 1 : 2 }}"></th>
                        </tr>
                    </tfoot>

                </table>

            </div>

        </div>

    </div>

</div>
@endsection
