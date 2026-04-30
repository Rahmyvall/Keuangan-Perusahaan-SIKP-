<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
 <a class="py-3 text-center sidebar-brand d-flex flex-column align-items-center" href="index.html">

  <!-- Logo -->
  <img src="{{ asset('admin/src/img/icons/halaman.png') }}"
       alt="SIKP Logo"
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
						<a class="sidebar-link" href="index.html">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>
<li class="sidebar-item text-dynamic">
    <a data-bs-target="#master" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="database"></i>
        <span class="align-middle">Master Data</span>
    </a>
    <ul id="master" class="sidebar-dropdown list-unstyled collapse">
        <li class="sidebar-item"><a class="sidebar-link" href="perusahaan.html">Perusahaan</a></li>
        <li class="sidebar-item"><a class="sidebar-link" href="pengguna.html">Pengguna</a></li>
        <li class="sidebar-item"><a class="sidebar-link" href="mata-uang.html">Mata Uang</a></li>
        <li class="sidebar-item"><a class="sidebar-link" href="akun.html">Akun Perkiraan</a></li>
        <li class="sidebar-item"><a class="sidebar-link" href="periode.html">Periode</a></li>
    </ul>
</li>


					<li class="sidebar-item">
    <a data-bs-target="#transaksi" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="repeat"></i>
        <span class="align-middle">Transaksi</span>
    </a>

    <ul id="transaksi" class="sidebar-dropdown list-unstyled collapse">
        <li class="sidebar-item">
            <a class="sidebar-link" href="jurnal-umum.html">
                Jurnal Umum
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="jurnal-detail.html">
                Detail Jurnal
            </a>
        </li>
    </ul>
</li>

					<li class="sidebar-item">
    <a data-bs-target="#piutang" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="dollar-sign"></i>
        <span class="align-middle">Piutang (AR)</span>
    </a>

    <ul id="piutang" class="sidebar-dropdown list-unstyled collapse">
        <li class="sidebar-item">
            <a class="sidebar-link" href="pelanggan.html">
                Pelanggan
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="faktur-penjualan.html">
                Faktur Penjualan
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="penerimaan-piutang.html">
                Penerimaan Piutang
            </a>
        </li>
    </ul>
</li>

					<li class="sidebar-item">
    <a data-bs-target="#hutang" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="archive"></i>
        <span class="align-middle">Hutang (AP)</span>
    </a>

    <ul id="hutang" class="sidebar-dropdown list-unstyled collapse">
        <li class="sidebar-item">
            <a class="sidebar-link" href="supplier.html">
                Supplier
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="faktur-pembelian.html">
                Faktur Pembelian
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="pembayaran-hutang.html">
                Pembayaran Hutang
            </a>
        </li>
    </ul>
</li>
				<li class="sidebar-item">
    <a data-bs-target="#aset" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="layers"></i>
        <span class="align-middle">Aset & Kas/Bank</span>
    </a>

    <ul id="aset" class="sidebar-dropdown list-unstyled collapse">

        <li class="sidebar-item">
            <a class="sidebar-link" href="aset-tetap.html">
                Aset Tetap
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="depresiasi.html">
                Depresiasi
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="rekening-bank.html">
                Rekening Bank
            </a>
        </li>

    </ul>
</li>
<li class="sidebar-item">
    <a data-bs-target="#saldo" data-bs-toggle="collapse" class="sidebar-link collapsed">
        <i class="align-middle" data-feather="database"></i>
        <span class="align-middle">Saldo Awal</span>
    </a>

    <ul id="saldo" class="sidebar-dropdown list-unstyled collapse">

        <li class="sidebar-item">
            <a class="sidebar-link" href="saldo-awal.html">
                Input Saldo Awal
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="saldo-akun.html">
                View Saldo Akun
            </a>
        </li>

    </ul>
</li>
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
