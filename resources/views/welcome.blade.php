<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login SIKP</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
	font-family: 'Inter', sans-serif;
	background: #f1f5f9;
	margin: 0;
}

/* LEFT IMAGE */
.left-panel {
	background: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f') center/cover no-repeat;
	height: 100vh;
	display: flex;
	align-items: center;
	padding: 60px;
	color: white;
	position: relative;
}

/* overlay */
.left-panel::before {
	content: "";
	position: absolute;
	inset: 0;
	background: rgba(0,0,0,0.4);
}

.left-content {
	position: relative;
	z-index: 2;
	max-width: 420px;
}

.logo {
	font-size: 20px;
	font-weight: 600;
	margin-bottom: 20px;
}

.left-content h1 {
	font-size: 32px;
	font-weight: 700;
}

.left-content p {
	margin-top: 10px;
	color: #e2e8f0;
}

.feature {
	margin-top: 30px;
}

.feature p {
	margin-bottom: 10px;
}

.feature i {
	margin-right: 10px;
}

/* RIGHT */
.right-panel {
	display: flex;
	align-items: center;
	justify-content: center;
	height: 100vh;
	background: #f8fafc;
}

/* LOGIN BOX */
.login-box {
	background: white;
	padding: 40px;
	border-radius: 20px;
	width: 100%;
	max-width: 420px;
	box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.login-box h3 {
	font-weight: 700;
}

.text-muted {
	color: #64748b !important;
}

/* INPUT */
.form-control {
	border-radius: 12px;
	padding: 12px;
	border: 1px solid #e2e8f0;
}

.form-control:focus {
	border-color: #2563eb;
	box-shadow: 0 0 0 2px rgba(37,99,235,0.2);
}

/* ICON */
.input-group-text {
	background: white;
	border: 1px solid #e2e8f0;
	color: #2563eb;
	border-radius: 12px 0 0 12px;
}

/* BUTTON */
.btn-sikp {
	background: #2563eb;
	border: none;
	border-radius: 12px;
	padding: 12px;
	color: white;
	font-weight: 600;
}

.btn-sikp:hover {
	background: #1e40af;
}

/* MOBILE */
@media(max-width: 768px){
	.left-panel {
		display: none;
	}
}
</style>
</head>

<body>

<div class="container-fluid">
	<div class="row">

		<!-- LEFT IMAGE -->
		<div class="col-md-6 left-panel">
			<div class="left-content">
				<div class="logo">SIKP</div>

				<h1>Sistem Informasi Keuangan Perusahaan</h1>
				<p>
					Solusi profesional untuk pengelolaan keuangan perusahaan
					dengan keamanan tinggi dan performa optimal.
				</p>

				<div class="feature">
					<p><i class="bi bi-shield-lock"></i> Keamanan Data Tinggi</p>
					<p><i class="bi bi-graph-up"></i> Laporan Real-time</p>
					<p><i class="bi bi-lightning-charge"></i> Sistem Cepat</p>
				</div>
			</div>
		</div>

		<!-- RIGHT LOGIN -->
		<div class="col-md-6 right-panel">
			<div class="login-box">

				<h3>Login SIKP</h3>
				<p class="mb-4 text-muted">Masuk ke sistem keuangan perusahaan</p>

				<form method="POST" action="{{ route('login.post') }}">
					@csrf

					<!-- ERROR -->
					@if(session('error'))
						<div class="alert alert-danger">
							{{ session('error') }}
						</div>
					@endif

					<!-- USERNAME -->
					<div class="mb-3">
						<label>Username</label>
						<div class="input-group">
							<span class="input-group-text">
								<i class="bi bi-person"></i>
							</span>
							<input type="text" name="username"
								class="form-control @error('username') is-invalid @enderror"
								placeholder="Masukkan username"
								value="{{ old('username') }}" required>
						</div>
						@error('username')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<!-- PASSWORD -->
					<div class="mb-3">
						<label>Password</label>
						<div class="input-group">
							<span class="input-group-text">
								<i class="bi bi-lock"></i>
							</span>
							<input type="password" name="password"
								class="form-control @error('password') is-invalid @enderror"
								required>
						</div>
						@error('password')
							<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>

					<!-- ROLE -->
					<div class="mb-3">
						<label>Login Sebagai</label>
						<select name="role" class="form-select" required>
							<option value="">-- Pilih Role --</option>
							<option value="admin">Admin</option>
							<option value="akuntan">Akuntan</option>
							<option value="manajer">Manajer</option>
							<option value="auditor">Auditor</option>
							<option value="staff">Staff</option>
						</select>
					</div>

					<!-- REMEMBER -->
					<div class="mb-3 d-flex justify-content-between">
						<div>
							<input type="checkbox" name="remember"> Ingat saya
						</div>
						<a href="#">Lupa password?</a>
					</div>

					<!-- BUTTON -->
					<div class="d-grid">
						<button type="submit" class="btn btn-sikp">
							Masuk ke Sistem
						</button>
					</div>

				</form>

				<div class="text-center mt-4 text-muted">
					© 2026 SIKP • Enterprise System
				</div>

			</div>
		</div>

	</div>
</div>

</body>
</html>
