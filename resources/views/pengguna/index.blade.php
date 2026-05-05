@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    {{-- HEADER - Modern Gradient --}}
    <div class="d-flex justify-content-between align-items-center mb-4 p-5 bg-gradient text-white rounded-4 shadow-lg"
        style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
        <div>
            <h2 class="mb-1 fw-bold">Human Resource</h2>
            <h5 class="mb-0">Manajemen Pengguna Sistem</h5>
        </div>
    </div>

    {{-- SEARCH & FILTER - Colorful Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body bg-light py-4">
            <form method="GET" action="{{ route('pengguna.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i data-feather="search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari nama, username, atau email...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager
                            </option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1 shadow-sm">
                            <i data-feather="search" class="me-2"></i>Cari
                        </button>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary flex-grow-1">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE - Modern & Colorful --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatable">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th width="70">Avatar</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th>Tanggal Join</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna as $i => $item)
                        @php
                        $words = explode(' ', $item->nama_lengkap);
                        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) :
                        ''));
                        $colors = ['primary', 'success', 'danger', 'warning', 'info', 'secondary'];
                        $color = $colors[$item->id_pengguna % count($colors)];
                        @endphp
                        <tr>
                            <td class="fw-semibold">
                                {{ $pengguna instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pengguna->firstItem() + $i : $i + 1 }}
                            </td>

                            <!-- Avatar -->
                            <td class="text-center">
                                <div class="rounded-circle bg-{{ $color }} text-white d-flex align-items-center justify-content-center mx-auto shadow-sm"
                                    style="width:55px; height:55px; font-size:21px; font-weight:700; border: 3px solid rgba(255,255,255,0.9);">
                                    {{ $initials }}
                                </div>
                            </td>

                            <td class="fw-bold">{{ $item->nama_lengkap }}</td>
                            <td><code class="bg-light px-2 py-1 rounded">{{ $item->username }}</code></td>
                            <td class="text-muted small">{{ $item->email ?? '-' }}</td>

                            <!-- Role dengan warna berbeda -->
                            <td>
                                @php
                                $roleColor = match($item->role) {
                                'admin' => 'danger',
                                'manager' => 'warning',
                                'staff' => 'info',
                                default => 'dark'
                                };
                                @endphp
                                <span class="badge bg-{{ $roleColor }} rounded-pill px-3 py-2">
                                    {{ ucfirst($item->role ?? '-') }}
                                </span>
                            </td>

                            <td>{{ $item->perusahaan->nama_perusahaan ?? '<span class="text-muted">—</span>' }}</td>

                            <td>
                                @if($item->is_active)
                                <span class="badge rounded-pill bg-success px-3 py-2 shadow-sm">Active</span>
                                @else
                                <span class="badge rounded-pill bg-danger px-3 py-2 shadow-sm">Inactive</span>
                                @endif
                            </td>

                            <td class="small text-muted">{{ $item->created_at?->format('d M Y') }}</td>

                            <!-- Aksi -->
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('pengguna.show', $item->id_pengguna) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a href="{{ route('pengguna.edit', $item->id_pengguna) }}"
                                        class="btn btn-outline-warning btn-sm">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <form action="{{ route('pengguna.destroy', $item->id_pengguna) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Hapus pengguna ini?')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i data-feather="users" width="80" class="text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data pengguna</h5>
                                <p class="text-muted">Silakan tambahkan pengguna baru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($pengguna->hasPages())
            <div class="mt-4 px-4 pb-4 d-flex justify-content-end">
                {{ $pengguna->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>

</div>


@endsection