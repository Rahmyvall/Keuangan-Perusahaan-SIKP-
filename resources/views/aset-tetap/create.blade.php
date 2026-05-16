{{-- resources/views/aset-tetap/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Aset Tetap Baru')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-plus-circle text-primary me-2"></i>
                Tambah Aset Tetap Baru
            </h3>
            <p class="text-muted mb-0">Isi data aset tetap dengan lengkap</p>
        </div>

        <a href="{{ route('aset-tetap.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Form Aset Tetap</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('aset-tetap.store') }}" method="POST" id="createForm">

                @csrf

                <div class="row g-4">

                    <!-- Nama Aset -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nama Aset</label>

                        <input type="text" name="nama_aset" class="form-control" value="{{ old('nama_aset') }}"
                            placeholder="Masukkan nama aset" required>
                    </div>

                    <!-- Akun Aset -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Akun Aset</label>

                        <select name="id_akun_aset" class="form-select" required>

                            <option value="">-- Pilih Akun Aset --</option>

                            @foreach($akun as $item)
                            <option value="{{ $item->id_akun }}"
                                {{ old('id_akun_aset') == $item->id_akun ? 'selected' : '' }}>

                                {{ $item->kode_akun }} - {{ $item->nama_akun }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Tanggal Pengadaan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tanggal Pengadaan</label>

                        <input type="date" name="tanggal_pengadaan" class="form-control"
                            value="{{ old('tanggal_pengadaan', now()->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Perusahaan -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Perusahaan</label>

                        <select name="id_perusahaan" class="form-select" required>

                            <option value="">-- Pilih Perusahaan --</option>

                            @foreach($perusahaan as $item)
                            <option value="{{ $item->id_perusahaan }}"
                                {{ old('id_perusahaan') == $item->id_perusahaan ? 'selected' : '' }}>

                                {{ $item->nama_perusahaan }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Nilai Perolehan -->
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Nilai Perolehan</label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>

                            <input type="number" step="0.01" name="nilai_perolehan" id="nilai_perolehan"
                                class="form-control text-end" value="{{ old('nilai_perolehan') }}" required>
                        </div>
                    </div>

                    <!-- Nilai Sisa -->
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Nilai Sisa</label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>

                            <input type="number" step="0.01" name="nilai_sisa" id="nilai_sisa"
                                class="form-control text-end" value="{{ old('nilai_sisa', 0) }}">
                        </div>
                    </div>

                    <!-- Masa Manfaat -->
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Masa Manfaat (Tahun)</label>

                        <input type="number" name="masa_manfaat" class="form-control" min="1"
                            value="{{ old('masa_manfaat') }}" required>
                    </div>

                    <!-- Penyusutan per Tahun -->
                    <div class="col-md-6">
                        <label class="form-label fw-medium">
                            Estimasi Penyusutan per Tahun
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>

                            <input type="text" id="penyusutan" class="form-control text-end fw-bold bg-light" readonly>
                        </div>

                        <small class="text-muted">
                            Perhitungan otomatis:
                            (Nilai Perolehan - Nilai Sisa) / Masa Manfaat
                        </small>
                    </div>

                </div>

                <div class="d-flex gap-3 mt-5">

                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i>
                        Simpan Aset
                    </button>

                    <a href="{{ route('aset-tetap.index') }}" class="btn btn-secondary btn-lg px-4">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const nilaiPerolehan = document.getElementById('nilai_perolehan');
    const nilaiSisa = document.getElementById('nilai_sisa');
    const masaManfaat = document.querySelector('[name="masa_manfaat"]');
    const penyusutan = document.getElementById('penyusutan');

    function hitungPenyusutan() {

        const perolehan = parseFloat(nilaiPerolehan.value) || 0;
        const sisa = parseFloat(nilaiSisa.value) || 0;
        const masa = parseFloat(masaManfaat.value) || 0;

        let hasil = 0;

        if (masa > 0) {
            hasil = (perolehan - sisa) / masa;
        }

        penyusutan.value = hasil.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    nilaiPerolehan.addEventListener('input', hitungPenyusutan);
    nilaiSisa.addEventListener('input', hitungPenyusutan);
    masaManfaat.addEventListener('input', hitungPenyusutan);

    hitungPenyusutan();
});
</script>
@endpush