@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm">

        <div>
            <h4 class="mb-0 fw-bold">Tambah Perusahaan</h4>
            <small class="text-muted">Form input data perusahaan baru</small>
        </div>

        <a href="{{ route('perusahaan.index') }}"
           class="btn btn-light border rounded-3 px-4">
            ← Kembali
        </a>

    </div>

    {{-- FORM CARD --}}
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <form action="{{ route('perusahaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- NAMA PERUSAHAAN --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Perusahaan</label>
                            <input type="text"
                                   name="nama_perusahaan"
                                   class="form-control rounded-3"
                                   placeholder="PT Contoh Indonesia"
                                   required>
                        </div>

                        {{-- NPWP --}}
                        <div class="mb-3">
                            <label class="form-label">NPWP</label>
                            <input type="text"
                                   name="npwp"
                                   class="form-control rounded-3"
                                   placeholder="00.000.000.0-000.000">
                        </div>

                        <div class="row">
                            {{-- KOTA --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text"
                                       name="kota"
                                       class="form-control rounded-3"
                                       placeholder="Jakarta">
                            </div>

                            {{-- TELEPON --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text"
                                       name="telepon"
                                       class="form-control rounded-3"
                                       placeholder="08123456789">
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control rounded-3"
                                   placeholder="email@perusahaan.com">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                      class="form-control rounded-3"
                                      rows="3"
                                      placeholder="Alamat lengkap perusahaan"></textarea>
                        </div>

                        {{-- LOGO --}}
                        <div class="mb-4">
                            <label class="form-label">Logo Perusahaan</label>
                            <input type="file"
                                   name="logo"
                                   class="form-control rounded-3"
                                   accept="image/*">
                        </div>

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('perusahaan.index') }}"
                               class="btn btn-light border rounded-3 px-4">
                                Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4">
                                Simpan Data
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- STYLE --}}
<style>
.form-control {
    padding: 10px 14px;
    border-radius: 10px;
}

.form-control:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

label {
    font-weight: 500;
    margin-bottom: 6px;
}
</style>

@endsection