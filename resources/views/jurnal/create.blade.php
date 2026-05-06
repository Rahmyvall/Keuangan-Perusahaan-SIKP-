@extends('layouts.app')

@section('title', 'Tambah Jurnal Baru')

@section('content')
<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h5>Tambah Jurnal Baru</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('jurnal.store') }}" method="POST">
                @csrf

                {{-- ROW 1 --}}
                <div class="row">

                    {{-- Nomor Jurnal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Nomor Jurnal <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nomor_jurnal" value="{{ old('nomor_jurnal') }}"
                            class="form-control @error('nomor_jurnal') is-invalid @enderror" required>

                        @error('nomor_jurnal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Tanggal <span class="text-danger">*</span>
                        </label>

                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                            class="form-control @error('tanggal') is-invalid @enderror" required>

                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tipe Jurnal --}}
                <div class="mb-3">
                    <label class="form-label">
                        Tipe Jurnal <span class="text-danger">*</span>
                    </label>

                    <select name="tipe_jurnal" class="form-select @error('tipe_jurnal') is-invalid @enderror" required>

                        <option value="">Pilih Tipe</option>

                        @foreach($tipeJurnal as $tipe)
                        <option value="{{ $tipe }}" {{ old('tipe_jurnal') == $tipe ? 'selected' : '' }}>
                            {{ $tipe }}
                        </option>
                        @endforeach

                    </select>

                    @error('tipe_jurnal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ROW 2 --}}
                <div class="row">

                    {{-- Periode --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Periode <span class="text-danger">*</span>
                        </label>

                        <select name="id_periode" class="form-select @error('id_periode') is-invalid @enderror"
                            required>

                            <option value="">Pilih Periode</option>

                            @foreach($periodes as $periode)
                            <option value="{{ $periode->id_periode }}"
                                {{ old('id_periode') == $periode->id_periode ? 'selected' : '' }}>
                                {{ $periode->nama_periode ?? $periode->tahun }}
                            </option>
                            @endforeach

                        </select>

                        @error('id_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Perusahaan --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Perusahaan <span class="text-danger">*</span>
                        </label>

                        <select name="id_perusahaan" class="form-select @error('id_perusahaan') is-invalid @enderror"
                            required>

                            <option value="">Pilih Perusahaan</option>

                            @foreach($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id_perusahaan }}"
                                {{ old('id_perusahaan') == $perusahaan->id_perusahaan ? 'selected' : '' }}>
                                {{ $perusahaan->nama_perusahaan }}
                            </option>
                            @endforeach

                        </select>

                        @error('id_perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label">
                        Deskripsi <span class="text-danger">*</span>
                    </label>

                    <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                        required>{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- HIDDEN FIELD (SESUAI DATABASE) --}}
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">

                {{-- BUTTON --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        Simpan Jurnal
                    </button>

                    <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
