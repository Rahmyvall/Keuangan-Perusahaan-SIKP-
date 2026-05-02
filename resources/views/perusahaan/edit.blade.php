@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h4 class="fw-bold mb-1">Edit Perusahaan</h4>
            <div class="text-muted small">Perbarui data perusahaan dengan lengkap</div>
        </div>

        <a href="{{ route('perusahaan.index') }}"
           class="btn btn-light border rounded-3 px-3">
            ← Kembali
        </a>

    </div>

    {{-- FORM --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <form action="{{ route('perusahaan.update', $perusahaan->id_perusahaan) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                    {{-- TOP SECTION --}}
                    <div class="p-4 bg-light border-bottom">

                        <div class="d-flex align-items-center gap-3">

                            {{-- LOGO PREVIEW --}}
                            <div>
                                @if($perusahaan->logo)
                                    <img src="{{ asset('storage/'.$perusahaan->logo) }}"
                                         class="rounded-circle border bg-white"
                                         width="80" height="80"
                                         style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center"
                                         style="width:80px;height:80px;">
                                        <i data-feather="image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">{{ $perusahaan->nama_perusahaan }}</h5>
                                <div class="text-muted small">Update informasi perusahaan</div>
                            </div>

                        </div>

                    </div>

                    {{-- BODY FORM --}}
                    <div class="p-4">

                        <div class="row g-3">

                            {{-- NAMA --}}
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text"
                                       name="nama_perusahaan"
                                       value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}"
                                       class="form-control rounded-3">
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $perusahaan->email) }}"
                                       class="form-control rounded-3">
                            </div>

                            {{-- TELEPON --}}
                            <div class="col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text"
                                       name="telepon"
                                       value="{{ old('telepon', $perusahaan->telepon) }}"
                                       class="form-control rounded-3">
                            </div>

                            {{-- NPWP --}}
                            <div class="col-md-6">
                                <label class="form-label">NPWP</label>
                                <input type="text"
                                       name="npwp"
                                       value="{{ old('npwp', $perusahaan->npwp) }}"
                                       class="form-control rounded-3">
                            </div>

                            {{-- KOTA --}}
                            <div class="col-md-6">
                                <label class="form-label">Kota</label>
                                <input type="text"
                                       name="kota"
                                       value="{{ old('kota', $perusahaan->kota) }}"
                                       class="form-control rounded-3">
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select rounded-3">
                                    <option value="aktif"
                                        {{ $perusahaan->status == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="nonaktif"
                                        {{ $perusahaan->status == 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>

                            {{-- ALAMAT --}}
                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat"
                                          rows="3"
                                          class="form-control rounded-3">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                            </div>

                            {{-- LOGO --}}
                            <div class="col-12">
                                <label class="form-label">Logo Perusahaan</label>
                                <input type="file"
                                       name="logo"
                                       class="form-control rounded-3">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti logo</small>
                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="p-4 bg-light border-top d-flex justify-content-end gap-2">

                        <a href="{{ route('perusahaan.index') }}"
                           class="btn btn-light border rounded-3 px-4">
                            Batal
                        </a>

                        <button type="submit"
                                class="btn btn-warning rounded-3 px-4 d-flex align-items-center gap-1">
                            <i data-feather="save"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

{{-- STYLE --}}
<style>
.form-control,
.form-select{
    padding:10px 12px;
    border-radius:12px;
    border:1px solid #e9ecef;
}

.form-control:focus,
.form-select:focus{
    box-shadow:none;
    border-color:#ffc107;
}

.card{
    transition:.2s;
}

.card:hover{
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
}
</style>

@endsection