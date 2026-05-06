@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Human Resource</h2>
        <p class="text-muted mb-0">Manajemen Pengguna Sistem</p>
    </div>

    {{-- SEARCH --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('pengguna.index') }}">
                <div class="row g-3 align-items-center">

                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0">
                                <i data-feather="search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control border-0 bg-light rounded-pill px-3" placeholder="Cari pengguna...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="role" class="form-select bg-light border-0 rounded-pill px-3">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager
                            </option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary rounded-pill px-4">
                            Cari
                        </button>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-light border rounded-pill px-4">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead style="background:#f8fafc;">
                    <tr class="text-muted small">
                        <th>#</th>
                        <th>Pengguna</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Perusahaan</th>
                        <th>Status</th>
                        <th>Join</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengguna as $i => $item)

                    @php
                    $words = explode(' ', $item->nama_lengkap);
                    $initials = strtoupper(substr($words[0],0,1) . (isset($words[1]) ? substr($words[1],0,1) : ''));
                    @endphp

                    <tr style="border-bottom:1px solid #f1f5f9;">

                        <td class="text-muted">
                            {{ $pengguna instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pengguna->firstItem() + $i : $i + 1 }}
                        </td>

                        {{-- USER --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                    style="width:45px;height:45px;background:#6366f1;">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $item->nama_lengkap }}</div>
                                    <div class="text-muted small">{{ $item->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <code class="px-2 py-1 bg-light rounded">{{ $item->username }}</code>
                        </td>

                        <td class="text-muted small">
                            {{ $item->email ?? '-' }}
                        </td>

                        {{-- ROLE --}}
                        <td>
                            @php
                            $roleStyle = match($item->role) {
                            'admin' => 'background:rgba(239,68,68,.1);color:#ef4444;',
                            'manager' => 'background:rgba(234,179,8,.1);color:#eab308;',
                            'staff' => 'background:rgba(59,130,246,.1);color:#3b82f6;',
                            default => 'background:#eee;color:#555;'
                            };
                            @endphp

                            <span class="px-3 py-1 rounded-pill small fw-semibold" style="{!! $roleStyle !!}">
                                {{ ucfirst($item->role ?? '-') }}
                            </span>
                        </td>

                        <td>
                            {{ $item->perusahaan->nama_perusahaan ?? '—' }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($item->is_active)
                            <span class="px-3 py-1 rounded-pill small fw-semibold"
                                style="background:rgba(34,197,94,.1);color:#22c55e;">
                                Active
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-pill small fw-semibold"
                                style="background:rgba(239,68,68,.1);color:#ef4444;">
                                Inactive
                            </span>
                            @endif
                        </td>

                        <td class="text-muted small">
                            {{ $item->created_at?->format('d M Y') }}
                        </td>

                        {{-- ACTION --}}
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">

                                <a href="{{ route('pengguna.show', $item->id_pengguna) }}"
                                    class="btn btn-light border btn-sm">
                                    <i data-feather="eye"></i>
                                </a>

                                <a href="{{ route('pengguna.edit', $item->id_pengguna) }}"
                                    class="btn btn-light border btn-sm">
                                    <i data-feather="edit"></i>
                                </a>

                                <form action="{{ route('pengguna.destroy', $item->id_pengguna) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light border btn-sm"
                                        onclick="return confirm('Hapus pengguna ini?')">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i data-feather="users" width="60" class="text-muted mb-2"></i>
                            <p class="text-muted mb-2">Belum ada pengguna</p>
                            <a href="#" class="btn btn-primary btn-sm">Tambah Pengguna</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        @if($pengguna->hasPages())
        <div class="p-4 d-flex justify-content-end">
            {{ $pengguna->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>

</div>
@endsection