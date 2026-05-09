<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="py-3 text-center sidebar-brand d-flex flex-column align-items-center" href="index.html">

            <!-- Logo -->
            <img src="{{ asset('admin/src/img/icons/halaman.png') }}" alt="SIKP Logo"
                style="width: 60px; height: auto;">

            <!-- Text -->
            <span class="mt-2 text-white fw-bold">SIKP</span>
            <small class="text-white" style="font-size: 11px;">
                Sistem Informasi Keuangan
            </small>

        </a>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header text-uppercase small fw-bold text-muted">
                Manajemen Keuangan
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            @auth
            @php
            $role = auth()->user()->role;
            @endphp

            {{-- ================= ADMIN ================= --}}
            @if($role === 'admin')

            {{-- MASTER DATA --}}
            <li class="sidebar-item">
                <a data-bs-target="#master" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="database" class="me-2"></i>
                    <span>Master Data</span>
                </a>
                <ul id="master" class="sidebar-dropdown list-unstyled collapse">
                    <li>
                        <a class="sidebar-link" href="{{ route('perusahaan.index') }}">
                            <i data-feather="briefcase"></i>
                            <span>Perusahaan</span>
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-link" href="{{ route('pengguna.index') }}">
                            <i data-feather="users"></i> Pengguna
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-link" href="{{ route('mata-uang.index') }}">
                            <i data-feather="dollar-sign"></i> Mata Uang
                        </a>
                    </li>
                    <li><a class="sidebar-link" href="{{ route('akun.index') }}"><i data-feather="book"></i> Akun
                            Perkiraan</a></li>
                    <li><a class="sidebar-link" href="{{ route('periode.index') }}"><i data-feather="calendar"></i>
                            Periode</a></li>
                </ul>
            </li>

            {{-- TRANSAKSI --}}
            <li class="sidebar-item">
                <a data-bs-target="#transaksi" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="repeat" class="me-2"></i>
                    <span>Transaksi</span>
                </a>
                <ul id="transaksi" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="{{ route('jurnal.index') }}"><i data-feather="edit"></i> Jurnal
                            Umum</a></li>
                    <li>
                        @if(isset($jurnal))
                        <a class="sidebar-link" href="{{ route('jurnal.detail.index', $jurnal) }}">
                            <i data-feather="file-text"></i>
                            <span>Detail Jurnal</span>
                        </a>
                        @else
                        <a class="sidebar-link" href="{{ route('jurnal.index') }}">
                            <i data-feather="file-text"></i>
                            <span>Detail Jurnal</span>
                        </a>
                        @endif
                    </li>
                </ul>
            </li>

            {{-- PIUTANG --}}
            <li class="sidebar-item">
                <a data-bs-target="#piutang" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="credit-card" class="me-2"></i>
                    <span>Piutang (AR)</span>
                </a>
                <ul id="piutang" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="{{ route('pelanggan.index') }}"><i data-feather="user"></i>
                            Pelanggan</a></li>
                    <li><a class="sidebar-link" href="{{ route('faktur-penjualan.index') }}"><i data-feather="file"></i>
                            Faktur Penjualan</a></li>
                    <li><a class="sidebar-link" href="{{ route('penerimaan-piutang.index') }}"><i
                                data-feather="download"></i> Penerimaan Piutang</a></li>
                </ul>
            </li>

            {{-- HUTANG --}}
            <li class="sidebar-item">
                <a data-bs-target="#hutang" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="archive" class="me-2"></i>
                    <span>Hutang (AP)</span>
                </a>
                <ul id="hutang" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="{{ route('supplier.index') }}"><i data-feather="truck"></i>
                            Supplier</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="shopping-cart"></i> Faktur Pembelian</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="send"></i> Pembayaran Hutang</a></li>
                </ul>
            </li>

            {{-- ASET --}}
            <li class="sidebar-item">
                <a data-bs-target="#aset" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="layers" class="me-2"></i>
                    <span>Aset & Kas/Bank</span>
                </a>
                <ul id="aset" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="box"></i> Aset Tetap</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="trending-down"></i> Depresiasi</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="home"></i> Rekening Bank</a></li>
                </ul>
            </li>

            {{-- SALDO --}}
            <li class="sidebar-item">
                <a data-bs-target="#saldo" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="database" class="me-2"></i>
                    <span>Saldo Awal</span>
                </a>
                <ul id="saldo" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="edit-3"></i> Input Saldo Awal</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="bar-chart-2"></i> View Saldo Akun</a></li>
                </ul>
            </li>

            @endif


            {{-- ================= AKUNTAN ================= --}}
            @if($role === 'akuntan')

            <li class="sidebar-item">
                <a data-bs-target="#transaksi" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="repeat" class="me-2"></i>
                    <span>Transaksi</span>
                </a>
                <ul id="transaksi" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="edit"></i> Jurnal Umum</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="file-text"></i> Detail Jurnal</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#piutang" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="credit-card" class="me-2"></i>
                    <span>Piutang</span>
                </a>
                <ul id="piutang" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="user"></i> Pelanggan</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="file"></i> Faktur</a></li>
                </ul>
            </li>

            @endif


            {{-- ================= MANAJER ================= --}}
            @if($role === 'manajer')

            <li class="sidebar-item">
                <a data-bs-target="#laporan" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="bar-chart-2" class="me-2"></i>
                    <span>Monitoring</span>
                </a>
                <ul id="laporan" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="file-text"></i> Detail Jurnal</a></li>
                    <li><a class="sidebar-link" href="#"><i data-feather="bar-chart"></i> Saldo Akun</a></li>
                </ul>
            </li>

            @endif


            {{-- ================= STAFF ================= --}}
            @if($role === 'staff')

            <li class="sidebar-item">
                <a data-bs-target="#transaksi" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i data-feather="edit" class="me-2"></i>
                    <span>Input Data</span>
                </a>
                <ul id="transaksi" class="sidebar-dropdown list-unstyled collapse">
                    <li><a class="sidebar-link" href="#"><i data-feather="edit"></i> Jurnal Umum</a></li>
                </ul>
            </li>

            @endif

            @endauth
        </ul>

        <div class="sidebar-cta">
            <div class="text-center sidebar-cta-content">
                <strong class="mb-2 d-inline-block">SIKP</strong>
                <div class="mb-3 text-sm">
                    Sistem Informasi<br>
                    Keuangan Perusahaan
                </div>
                <div class="d-grid">
                    <a href="dashboard.html" class="btn btn-primary">Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</nav>
