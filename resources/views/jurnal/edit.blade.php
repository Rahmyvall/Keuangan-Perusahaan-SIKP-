@extends('layouts.app')

@section('title', 'Edit Jurnal')

@section('content')
<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h5>Edit Jurnal - {{ $jurnal->nomor_jurnal }}</h5>
        </div>

        <div class="card-body">

            {{-- LOCK EDIT JIKA SUDAH POSTED (opsional UI protection) --}}
            @if($jurnal->posted)
            <div class="alert alert-danger">
                Jurnal sudah <strong>POSTED</strong> dan tidak dapat diubah.
            </div>
            @endif

            <form action="{{ route('jurnal.update', $jurnal) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ROW 1 --}}
                <div class="row">

                    {{-- Nomor Jurnal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Jurnal</label>

                        <input type="text" name="nomor_jurnal" value="{{ old('nomor_jurnal', $jurnal->nomor_jurnal) }}"
                            class="form-control @error('nomor_jurnal') is-invalid @enderror" required
                            {{ $jurnal->posted ? 'readonly' : '' }}>

                        @error('nomor_jurnal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>

                        <input type="date" name="tanggal"
                            value="{{ old('tanggal', $jurnal->tanggal->format('Y-m-d')) }}"
                            class="form-control @error('tanggal') is-invalid @enderror" required
                            {{ $jurnal->posted ? 'readonly' : '' }}>

                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- TIPE JURNAL --}}
                <div class="mb-3">
                    <label class="form-label">Tipe Jurnal</label>

                    <select name="tipe_jurnal" class="form-select @error('tipe_jurnal') is-invalid @enderror" required
                        {{ $jurnal->posted ? 'disabled' : '' }}>

                        @foreach($tipeJurnal as $tipe)
                        <option value="{{ $tipe }}"
                            {{ old('tipe_jurnal', $jurnal->tipe_jurnal) == $tipe ? 'selected' : '' }}>
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

                    {{-- PERIODE --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Periode</label>

                        <select name="id_periode" class="form-select @error('id_periode') is-invalid @enderror" required
                            {{ $jurnal->posted ? 'disabled' : '' }}>

                            @foreach($periodes as $periode)
                            <option value="{{ $periode->id_periode }}"
                                {{ old('id_periode', $jurnal->id_periode) == $periode->id_periode ? 'selected' : '' }}>
                                {{ $periode->nama_periode ?? $periode->tahun }}
                            </option>
                            @endforeach

                        </select>

                        @error('id_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PERUSAHAAN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Perusahaan</label>

                        <select name="id_perusahaan" class="form-select @error('id_perusahaan') is-invalid @enderror"
                            required {{ $jurnal->posted ? 'disabled' : '' }}>

                            @foreach($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id_perusahaan }}"
                                {{ old('id_perusahaan', $jurnal->id_perusahaan) == $perusahaan->id_perusahaan ? 'selected' : '' }}>
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
                    <label class="form-label">Deskripsi</label>

                    <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror"
                        required
                        {{ $jurnal->posted ? 'readonly' : '' }}>{{ old('deskripsi', $jurnal->deskripsi) }}</textarea>

                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="mt-4">

                    @if(!$jurnal->posted)
                    <button type="submit" class="btn btn-primary">
                        Update Jurnal
                    </button>
                    @else
                    <button type="button" class="btn btn-secondary" disabled>
                        Tidak Bisa Diedit (Posted)
                    </button>
                    @endif

                    <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
