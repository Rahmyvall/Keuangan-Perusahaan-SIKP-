@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="bg-white shadow-sm rounded-4 p-4 mb-4 d-flex justify-content-between align-items-center">

        <div>
            <h4 class="fw-bold mb-1">Tambah Akun</h4>
            <small class="text-muted">Chart of Account (COA) otomatis & terstruktur</small>
        </div>

        <span class="badge bg-primary px-3 py-2 rounded-pill">
            COA System
        </span>

    </div>

    {{-- CARD FORM --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('akun.store') }}" method="POST">
                @csrf

                {{-- SECTION --}}
                <div class="mb-3">
                    <h6 class="fw-bold text-muted">Struktur Akun</h6>
                    <hr>
                </div>

                <div class="row g-3">

                    {{-- TIPE --}}
                    <div class="col-md-4">
                        <label class="form-label">Tipe Akun</label>
                        <select name="tipe_akun" id="tipe_akun" class="form-select shadow-sm" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Aset">Aset</option>
                            <option value="Liabilitas">Liabilitas</option>
                            <option value="Ekuitas">Ekuitas</option>
                            <option value="Pendapatan">Pendapatan</option>
                            <option value="Beban">Beban</option>
                        </select>
                    </div>

                    {{-- PARENT --}}
                    <div class="col-md-4">
                        <label class="form-label">Parent Akun</label>
                        <select name="parent_id" id="parent_id" class="form-select shadow-sm">
                            <option value="">-- Akun Utama --</option>
                            @foreach($akun ?? [] as $a)
                            <option value="{{ $a->id_akun }}">
                                {{ $a->kode_akun }} - {{ $a->nama_akun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KODE --}}
                    <div class="col-md-4">
                        <label class="form-label">Kode Akun (Auto)</label>
                        <input type="text" name="kode_akun" id="kode_akun" class="form-control bg-light shadow-sm"
                            readonly>
                    </div>

                </div>

                {{-- SECTION --}}
                <div class="mt-4 mb-2">
                    <h6 class="fw-bold text-muted">Detail Akun</h6>
                    <hr>
                </div>

                <div class="row g-3">

                    {{-- NAMA --}}
                    <div class="col-md-8">
                        <label class="form-label">Nama Akun</label>
                        <input type="text" name="nama_akun" class="form-control shadow-sm"
                            placeholder="Contoh: Kas / Bank / Piutang" required>
                    </div>

                    {{-- SALDO --}}
                    <div class="col-md-4">
                        <label class="form-label">Saldo Normal</label>
                        <select name="saldo_normal" class="form-select shadow-sm">
                            <option value="Debit">Debit</option>
                            <option value="Kredit">Kredit</option>
                        </select>
                    </div>

                    {{-- LEVEL --}}
                    <div class="col-md-4">
                        <label class="form-label">Level</label>
                        <input type="number" name="level" class="form-control shadow-sm" value="1">
                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select shadow-sm">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ route('akun.index') }}" class="btn btn-light border rounded-3">
                        Batal
                    </a>

                    <button class="btn btn-primary px-4 rounded-3 shadow-sm">
                        Simpan Akun
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

{{-- AUTO KODE AKUN --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    let tipe = document.getElementById('tipe_akun');
    let parent = document.getElementById('parent_id');
    let kode = document.getElementById('kode_akun');

    function generateKode() {

        let tipeVal = tipe.value;
        let parentVal = parent.value;

        let prefix = "";

        if (tipeVal === "Aset") prefix = "1";
        if (tipeVal === "Liabilitas") prefix = "2";
        if (tipeVal === "Ekuitas") prefix = "3";
        if (tipeVal === "Pendapatan") prefix = "4";
        if (tipeVal === "Beban") prefix = "5";

        if (!tipeVal) return;

        if (!parentVal) {
            kode.value = prefix + "-" + Math.floor(100 + Math.random() * 900);
        } else {
            kode.value = prefix + "-" + parentVal + "-" + Math.floor(10 + Math.random() * 90);
        }
    }

    tipe.addEventListener('change', generateKode);
    parent.addEventListener('change', generateKode);

});
</script>

@endsection