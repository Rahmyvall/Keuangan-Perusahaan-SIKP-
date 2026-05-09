@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">
        <div>
            <h4 class="mb-0 fw-bold">Detail Penerimaan Piutang</h4>
            <small class="text-muted">{{ $penerimaanPiutang->nomor_penerimaan }}</small>
        </div>
        <a href="{{ route('penerimaan-piutang.index') }}" class="btn btn-light border">
            <i data-feather="arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5">

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="160"><strong>Nomor Penerimaan</strong></td>
                            <td>:</td>
                            <td class="fw-bold">{{ $penerimaanPiutang->nomor_penerimaan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($penerimaanPiutang->tanggal)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Faktur Penjualan</strong></td>
                            <td>:</td>
                            <td>{{ $penerimaanPiutang->fakturPenjualan->nomor_faktur ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Perusahaan</strong></td>
                            <td>:</td>
                            <td>{{ $penerimaanPiutang->perusahaan->nama_perusahaan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="160"><strong>Jumlah</strong></td>
                            <td>:</td>
                            <td class="fs-4 fw-bold text-success">
                                Rp {{ number_format($penerimaanPiutang->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Jurnal</strong></td>
                            <td>:</td>
                            <td>{{ $penerimaanPiutang->jurnal->nomor_jurnal ?? 'Belum dijurnal' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat Pada</strong></td>
                            <td>:</td>
                            <td>{{ $penerimaanPiutang->created_at?->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('penerimaan-piutang.edit', $penerimaanPiutang->id_penerimaan) }}"
                    class="btn btn-warning">
                    <i data-feather="edit"></i> Edit Data
                </a>
                <form action="{{ route('penerimaan-piutang.destroy', $penerimaanPiutang->id_penerimaan) }}"
                    method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                        <i data-feather="trash-2"></i> Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
