@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm p-4">

        <h2 class="fw-bold mb-4">Tambah Pembayaran Hutang</h2>

        @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('pembayaran-hutang.store') }}" method="POST">
            @csrf
            <div class="row g-3">

                <div class="col-md-12">
                    <label class="form-label">Nomor Pembayaran</label>
                    <input type="text" name="nomor_pembayaran" class="form-control"
                        value="{{ old('nomor_pembayaran', $nomorPembayaran) }}" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Faktur Pembelian</label>
                    <select name="id_faktur_pembelian" class="form-select" required>
                        <option value="">Pilih Faktur</option>
                        @foreach($fakturPembelian as $f)
                        <option value="{{ $f->id_faktur_pembelian }}">{{ $f->nomor_faktur }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jurnal</label>
                    <select name="id_jurnal" class="form-select">
                        <option value="">Pilih Jurnal</option>
                        @foreach($jurnal as $j)
                        <option value="{{ $j->id_jurnal }}">{{ $j->nomor_jurnal }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Perusahaan</label>
                    <select name="id_perusahaan" class="form-select" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach($perusahaan as $p)
                        <option value="{{ $p->id_perusahaan }}">{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" step="0.01" class="form-control" value="{{ old('jumlah') }}"
                        required>
                </div>

            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                    <i data-feather="check"></i> Simpan
                </button>
                <a href="{{ route('pembayaran-hutang.index') }}"
                    class="btn btn-secondary d-flex align-items-center gap-2">
                    <i data-feather="arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection