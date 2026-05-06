@extends('layouts.app')

@section('title', 'Daftar Jurnal')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Daftar Jurnal</h1>

        <a href="{{ route('jurnal.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jurnal
        </a>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('jurnal.index') }}" class="row g-3">

                {{-- PERIODE --}}
                <div class="col-md-3">
                    <label class="form-label">Periode</label>
                    <select name="periode" class="form-select">
                        <option value="">Semua Periode</option>
                        @foreach($periodes as $periode)
                        <option value="{{ $periode->id_periode }}"
                            {{ request('periode') == $periode->id_periode ? 'selected' : '' }}>
                            {{ $periode->nama_periode ?? ('Periode ' . $periode->tahun) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- TIPE --}}
                <div class="col-md-3">
                    <label class="form-label">Tipe Jurnal</label>
                    <select name="tipe" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeJurnal as $tipe)
                        <option value="{{ $tipe }}" {{ request('tipe') == $tipe ? 'selected' : '' }}>
                            {{ $tipe }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="posted" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" {{ request('posted') === '1' ? 'selected' : '' }}>
                            Posted
                        </option>
                        <option value="0" {{ request('posted') === '0' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                </div>

                {{-- SEARCH --}}
                <div class="col-md-3">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nomor / Deskripsi"
                            value="{{ request('search') }}">

                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-hover table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nomor Jurnal</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Deskripsi</th>
                        <th>Periode</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($jurnals as $jurnal)
                    <tr>

                        <td>
                            {{ $loop->iteration + ($jurnals->firstItem() - 1) }}
                        </td>

                        <td>
                            <strong>{{ $jurnal->nomor_jurnal }}</strong>
                        </td>

                        <td>
                            {{ optional($jurnal->tanggal)->format('d M Y') }}
                        </td>

                        <td>
                            <span class="badge bg-info">
                                {{ $jurnal->tipe_jurnal }}
                            </span>
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($jurnal->deskripsi, 60) }}
                        </td>

                        {{-- PERIODE --}}
                        <td>
                            {{ optional($jurnal->periode)->nama_periode
                                ?? optional($jurnal->periode)->tahun
                                ?? '-' }}
                        </td>

                        {{-- CREATED BY (FIX UTAMA) --}}
                        <td>
                            {{ optional($jurnal->creator)->nama ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($jurnal->posted)
                            <span class="badge bg-success">Posted</span>
                            @else
                            <span class="badge bg-warning text-dark">Draft</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('jurnal.show', $jurnal) }}" class="btn btn-info text-white">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(!$jurnal->posted)
                                <a href="{{ route('jurnal.edit', $jurnal) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('jurnal.destroy', $jurnal) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus jurnal ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>
                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            Belum ada data jurnal
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $jurnals->links() }}
        </div>
    </div>

</div>
@endsection
