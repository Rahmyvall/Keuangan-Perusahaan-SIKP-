@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Pelanggan</h1>
            <p class="text-muted">{{ $pelanggan->nama_pelanggan }} • {{ $pelanggan->kode_pelanggan }}</p>
        </div>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0">
                <div class="card-header bg-white py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-edit fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Ubah Data Pelanggan</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">

                    <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            <!-- Kode Pelanggan -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Kode Pelanggan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="kode_pelanggan"
                                    class="form-control @error('kode_pelanggan') is-invalid @enderror"
                                    value="{{ old('kode_pelanggan', $pelanggan->kode_pelanggan) }}" required>
                                @error('kode_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Pelanggan -->
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nama Pelanggan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_pelanggan"
                                    class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                    value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                                @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Perusahaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Perusahaan <span
                                        class="text-danger">*</span></label>
                                <select name="id_perusahaan"
                                    class="form-select @error('id_perusahaan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    @foreach($perusahaan as $p)
                                    <option value="{{ $p->id_perusahaan }}"
                                        {{ old('id_perusahaan', $pelanggan->id_perusahaan) == $p->id_perusahaan ? 'selected' : '' }}>
                                        {{ $p->nama_perusahaan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Limit Kredit -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Limit Kredit</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="limit_kredit"
                                        class="form-control @error('limit_kredit') is-invalid @enderror"
                                        value="{{ old('limit_kredit', $pelanggan->limit_kredit) }}" min="0" step="1000">
                                </div>
                                @error('limit_kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telepon & Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="telepon"
                                    class="form-control @error('telepon') is-invalid @enderror"
                                    value="{{ old('telepon', $pelanggan->telepon) }}">
                                @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $pelanggan->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                    rows="4">
                                    {{ old('alamat', $pelanggan->alamat) }}
                                </textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <hr class="my-5">

                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
