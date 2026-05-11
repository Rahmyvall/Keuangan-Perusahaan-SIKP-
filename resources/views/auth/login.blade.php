<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login SIKP</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --primary: #2563eb;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
        margin: 0;
        min-height: 100vh;
    }

    /* LEFT PANEL - Modern Overlay */
    .left-panel {
        background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.75)),
            url('https://images.unsplash.com/photo-1554224155-6726b3ff858f') center/cover no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        padding: 60px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .left-panel::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 50%, rgba(37, 99, 235, 0.3), transparent 70%);
    }

    .left-content {
        position: relative;
        z-index: 2;
        max-width: 460px;
    }

    .logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .left-content h1 {
        font-size: 42px;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 16px;
    }

    /* RIGHT PANEL */
    .right-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }

    .login-box {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 48px 40px;
        border-radius: 24px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .login-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
    }

    .form-control {
        border-radius: 14px;
        padding: 14px 18px;
        border: 1.5px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        outline: none;
    }

    .input-group-text {
        background: white;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
        border-radius: 14px 0 0 14px;
    }

    .btn-sikp {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border: none;
        border-radius: 14px;
        padding: 16px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-sikp:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
    }

    .form-label {
        font-weight: 500;
        color: #334155;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-box {
        animation: fadeInUp 0.6s ease forwards;
    }

    @media (max-width: 768px) {
        .left-panel {
            display: none;
        }

        .login-box {
            padding: 40px 24px;
        }
    }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- LEFT PANEL -->
            <div class="col-lg-6 left-panel d-none d-lg-flex">
                <div class="left-content">
                    <div class="logo">
                        <i class="bi bi-building-check"></i>
                        SIKP
                    </div>
                    <h1>Sistem Informasi Keuangan Perusahaan</h1>
                    <p class="lead opacity-90">
                        Kelola keuangan perusahaan dengan lebih cepat, aman, dan transparan.
                    </p>
                    <div class="mt-5 d-flex gap-4 text-sm">
                        <div><i class="bi bi-shield-check"></i> Keamanan Tinggi</div>
                        <div><i class="bi bi-graph-up"></i> Real-time Analytics</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div class="col-lg-6 right-panel">
                <div class="login-box">

                    <h3 class="mb-2 fw-semibold">Selamat Datang Kembali</h3>
                    <p class="text-muted mb-4">Masuk untuk melanjutkan ke dashboard</p>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <!-- Username -->
                        <div class="mb-4">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                            </div>
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password" required>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label class="form-label">Login Sebagai</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="akuntan" {{ old('role') == 'akuntan' ? 'selected' : '' }}>Akuntan
                                </option>
                                <option value="manajer" {{ old('role') == 'manajer' ? 'selected' : '' }}>Manajer
                                </option>
                                <option value="auditor" {{ old('role') == 'auditor' ? 'selected' : '' }}>Auditor
                                </option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="text-decoration-none small text-primary">Lupa password?</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-sikp text-white">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Sistem
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-5 text-muted small">
                        © 2026 SIKP • Enterprise Financial System
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>