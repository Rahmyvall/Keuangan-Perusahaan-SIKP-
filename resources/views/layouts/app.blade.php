<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('admin/src/img/icons/halaman.png') }}" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>{{ $title ?? 'Dashboard' }} | SIKP</title>

	<link href="{{ asset('admin/static/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<style>
		:root {
			--primary: #4361ee;
		}

		/* === CUSTOM ENHANCEMENT === */
		body {
			font-family: 'Inter', sans-serif;
		}

		/* Card Modern Look */
		.card {
			border: none;
			border-radius: 16px;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
			transition: all 0.3s ease;
		}

		.card:hover {
			transform: translateY(-4px);
			box-shadow: 0 12px 30px rgba(67, 97, 238, 0.15);
		}

		.card-header {
			background: transparent;
			border-bottom: 1px solid rgba(0, 0, 0, 0.06);
			padding: 1.5rem 1.75rem;
		}

		/* Sidebar Enhancement */
		.sidebar {
			background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
		}

		[data-bs-theme="dark"] .sidebar {
			background: linear-gradient(180deg, #212529 0%, #2b3035 100%);
		}

		.sidebar-brand {
			font-weight: 700;
			font-size: 1.5rem;
			padding: 1.25rem 1.75rem;
		}

		/* Navbar Enhancement */
		.navbar-bg {
			box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
			backdrop-filter: blur(10px);
		}

		/* Hover Effects */
		.sidebar-link {
			transition: all 0.25s ease;
			border-radius: 8px;
			margin: 3px 8px;
		}

		.sidebar-link:hover {
			transform: translateX(6px);
			background-color: rgba(67, 97, 238, 0.1) !important;
		}

		.sidebar-item.active .sidebar-link {
			background-color: var(--primary) !important;
			color: white !important;
			box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
		}

		/* Button & Badge */
		.btn-primary {
			border-radius: 10px;
			padding: 10px 20px;
			font-weight: 500;
		}

		/* Content Padding */
		.content {
			padding: 2rem 1.5rem;
		}

		/* Scrollbar Modern */
		.js-simplebar::-webkit-scrollbar {
			width: 6px;
		}

		.js-simplebar::-webkit-scrollbar-thumb {
			background: #4361ee;
			border-radius: 10px;
		}

		/* Notification Indicator */
		.indicator {
			animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
		}

		@keyframes ping {
			75%, 100% {
				transform: scale(2);
				opacity: 0;
			}
		}

		/* Dark Mode Fine Tuning */
		[data-bs-theme="dark"] .card {
			background: #2b3035;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
		}

		[data-bs-theme="dark"] .card:hover {
			box-shadow: 0 12px 30px rgba(67, 97, 238, 0.25);
		}
        /* === TEXT COLOR FOLLOW PRIMARY === */
.text-primary,
body,
p,
h1, h2, h3, h4, h5, h6,
span,
a {
    color: var(--primary);
}

/* Optional: link hover biar lebih hidup */
a:hover {
    color: #2f49d1; /* versi lebih gelap dari primary */
}
[data-bs-theme="dark"] {
    --primary: #7b9cff; /* versi lebih terang biar kontras */
}
.text-dynamic {
    color: var(--primary);
}
.navbar {
    position: relative;
    z-index: 1050; /* pastikan di atas content */
}

.dropdown-menu {
    z-index: 2000; /* supaya dropdown tidak ketutup */
}

.navbar-collapse {
    z-index: 1050;
}
	</style>
</head>

<body>
	<div class="wrapper">
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

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
                        <!-- TOGGLE DARK MODE -->
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="themeDropdown" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="sun"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="themeDropdown">
								<a class="dropdown-item theme-toggle" href="#" data-theme="light">
									<i class="align-middle me-2" data-feather="sun"></i> Light Mode
								</a>
								<a class="dropdown-item theme-toggle" href="#" data-theme="dark">
									<i class="align-middle me-2" data-feather="moon"></i> Dark Mode
								</a>
								<a class="dropdown-item theme-toggle" href="#" data-theme="auto">
									<i class="align-middle me-2" data-feather="monitor"></i> Auto (System)
								</a>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="py-0 dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="mt-1 text-muted small">Restart server 12 to complete the update.</div>
												<div class="mt-1 text-muted small">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="mt-1 text-muted small">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="mt-1 text-muted small">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="mt-1 text-muted small">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="mt-1 text-muted small">Christina accepted your request.</div>
												<div class="mt-1 text-muted small">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							<div class="py-0 dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
									<div class="position-relative">
										4 New Messages
									</div>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Vanessa Tucker</div>
												<div class="mt-1 text-muted small">Nam pretium turpis et arcu. Duis arcu tortor.</div>
												<div class="mt-1 text-muted small">15m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">William Harris</div>
												<div class="mt-1 text-muted small">Curabitur ligula sapien euismod vitae.</div>
												<div class="mt-1 text-muted small">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Christina Mason</div>
												<div class="mt-1 text-muted small">Pellentesque auctor neque nec urna.</div>
												<div class="mt-1 text-muted small">4h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Sharon Lessman</div>
												<div class="mt-1 text-muted small">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
												<div class="mt-1 text-muted small">5h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all messages</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>
<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
    <span class="text-dark">
        {{ auth()->user()->nama_lengkap ?? 'Guest' }}
    </span>
</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<a class="dropdown-item" href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Log out
</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="p-0 container-fluid">
                    @yield('content')
				</div>
			</main>

			<footer class="footer">
  <div class="container-fluid">
    <div class="row text-muted align-items-center">

      <!-- Kiri -->
      <div class="text-center col-md-6 text-md-start">
        <p class="mb-0">
          &copy; <span id="year"></span>
          <strong>SIKP</strong> - Sistem Informasi Keuangan Perusahaan
        </p>
      </div>

      <!-- Kanan -->
      <div class="text-center col-md-6 text-md-end">
        <ul class="mb-0 list-inline">
          <li class="list-inline-item">
            <a class="text-muted text-decoration-none" href="#">Support</a>
          </li>
          <li class="list-inline-item">
            <a class="text-muted text-decoration-none" href="#">Privacy</a>
          </li>
          <li class="list-inline-item">
            <a class="text-muted text-decoration-none" href="#">Terms</a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</footer>

		</div>
	</div>

	<script src="{{asset('admin/static/js/app.js')}}"></script>
    <!-- Script Tahun Otomatis -->
<script id="year-script">
  document.getElementById("year").textContent = new Date().getFullYear();
</script>
<!-- Dark Mode Script (sudah ada di kode kamu) -->
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		const html = document.documentElement;
		const toggles = document.querySelectorAll('.theme-toggle');
		const themeIcon = document.getElementById('themeDropdown')?.querySelector('i');

		function setTheme(theme) {
			if (theme === 'auto') {
				const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				html.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
			} else {
				html.setAttribute('data-bs-theme', theme);
			}
			localStorage.setItem('theme', theme);

			if (themeIcon) {
				themeIcon.setAttribute('data-feather',
					(theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches))
					? 'moon' : 'sun'
				);
				feather.replace();
			}
		}

		const savedTheme = localStorage.getItem('theme') || 'dark';
		setTheme(savedTheme);

		toggles.forEach(toggle => {
			toggle.addEventListener('click', function(e) {
				e.preventDefault();
				setTheme(this.dataset.theme);
			});
		});

		window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
			if (localStorage.getItem('theme') === 'auto') setTheme('auto');
		});
	});
	</script>

</body>

</html>
