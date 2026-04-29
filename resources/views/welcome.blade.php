<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login SIKP - Dark</title>

<link href="{{ asset('admin/static/css/app.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
	body {
		font-family: 'Inter', sans-serif;
		background: #0f172a;
		color: #e2e8f0;
		margin: 0;
	}

	/* LEFT SIDE */
	.left-panel {
		background: radial-gradient(circle at top, #1e293b, #020617);
		padding: 60px;
		height: 100vh;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.logo {
		font-size: 20px;
		font-weight: 600;
		color: #38bdf8;
		margin-bottom: 20px;
	}

	.left-panel h1 {
		font-size: 30px;
		font-weight: 700;
	}

	.left-panel p {
		color: #94a3b8;
		margin-top: 10px;
	}

	.feature {
		margin-top: 30px;
	}

	.feature i {
		color: #38bdf8;
		margin-right: 10px;
	}

	/* RIGHT SIDE */
	.right-panel {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100vh;
	}

	.login-box {
		background: rgba(15, 23, 42, 0.8);
		border: 1px solid rgba(255,255,255,0.05);
		backdrop-filter: blur(20px);
		padding: 40px;
		border-radius: 16px;
		width: 100%;
		max-width: 420px;
		box-shadow: 0 0 40px rgba(56,189,248,0.08);
	}

	.login-box h3 {
		font-weight: 700;
		color: #f1f5f9;
	}

	.text-muted {
		color: #94a3b8 !important;
	}

	.form-control {
		background: #020617;
		border: 1px solid #1e293b;
		color: #e2e8f0;
		border-radius: 10px;
		padding: 12px;
	}

	.form-control::placeholder {
		color: #64748b;
	}

	.form-control:focus {
		border-color: #38bdf8;
		box-shadow: 0 0 0 2px rgba(56,189,248,0.2);
		background: #020617;
		color: #fff;
	}

	.input-group-text {
		background: #020617;
		border: 1px solid #1e293b;
		color: #38bdf8;
		border-radius: 10px 0 0 10px;
	}

	.btn-sikp {
		background: linear-gradient(135deg, #38bdf8, #2563eb);
		border: none;
		border-radius: 10px;
		padding: 12px;
		font-weight: 600;
		color: white;
		transition: 0.3s;
	}

	.btn-sikp:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 20px rgba(56,189,248,0.3);
	}

	a {
		color: #38bdf8;
	}

	.footer-text {
		text-align: center;
		margin-top: 20px;
		font-size: 13px;
		color: #64748b;
	}

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

		<!-- LEFT -->
		<div class="col-md-6 left-panel">
			<div class="logo">SIKP</div>

			<h1 class="text-white">Enterprise Financial System</h1>
			<p>
				Solusi profesional untuk manajemen keuangan perusahaan
				dengan keamanan tinggi dan performa maksimal.
			</p>

			<div class="feature">
				<p><i class="bi bi-shield-lock"></i> Secure & Encrypted System</p>
				<p><i class="bi bi-bar-chart"></i> Real-time Analytics</p>
				<p><i class="bi bi-lightning-charge"></i> High Performance</p>
			</div>
		</div>

		<!-- RIGHT -->
		<div class="col-md-6 right-panel">
			<div class="login-box">

				<h3>Login SIKP</h3>
				<p class="mb-4 text-muted">Akses sistem keuangan perusahaan</p>

				<form>

					<div class="mb-3">
						<label>Email</label>
						<div class="input-group">
							<span class="input-group-text">
								<i class="bi bi-envelope"></i>
							</span>
							<input type="email" class="form-control" placeholder="email@company.com">
						</div>
					</div>

					<div class="mb-3">
						<label>Password</label>
						<div class="input-group">
							<span class="input-group-text">
								<i class="bi bi-lock"></i>
							</span>
							<input type="password" class="form-control" placeholder="••••••••">
						</div>
					</div>

					<div class="mb-3 d-flex justify-content-between">
						<div class="form-check">
							<input class="form-check-input" type="checkbox">
							<label class="form-check-label">Remember</label>
						</div>
						<a href="#">Forgot?</a>
					</div>

					<div class="d-grid">
						<button class="btn btn-sikp">Secure Login</button>
					</div>

				</form>

				<div class="footer-text">
					© 2026 SIKP • Enterprise System
				</div>

			</div>
		</div>

	</div>
</div>

</body>
</html>
