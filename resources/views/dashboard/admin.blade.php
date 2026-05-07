@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4 fw-bold text-dark">{{ $title ?? 'Dashboard' }}</h1>

    <div class="row g-4">

        <!-- KOLOM KIRI - STATISTIK -->
        <div class="col-xl-7 col-xxl-8">
            <div class="row g-4">

                <!-- Pengguna -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small fw-medium">Total Pengguna</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">{{ $total_pengguna ?? 0 }}</h1>
                                    <div>
                                        <span class="text-success fw-semibold">{{ $pengguna_aktif ?? 0 }} aktif</span>
                                        <span class="text-muted"> / {{ $pengguna_nonaktif ?? 0 }} nonaktif</span>
                                    </div>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i data-feather="users" class="align-middle" style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Transaksi Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Transaksi</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">
                                        {{ number_format($total_transaksi ?? 0) }}
                                    </h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span
                                            class="text-{{ $growth_transaksi >= 0 ? 'success' : 'danger' }} fw-semibold">
                                            {{ $growth_transaksi >= 0 ? '↑' : '↓' }} {{ abs($growth_transaksi ?? 0) }}%
                                        </span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Earnings</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">
                                        Rp {{ number_format($total_earnings ?? 0, 0, ',', '.') }}
                                    </h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span
                                            class="text-{{ $growth_earnings >= 0 ? 'success' : 'danger' }} fw-semibold">
                                            {{ $growth_earnings >= 0 ? '↑' : '↓' }} {{ abs($growth_earnings ?? 0) }}%
                                        </span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i data-feather="dollar-sign" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Orders -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="text-muted small fw-medium">Orders</div>
                                    <h1 class="mt-3 mb-1 fw-bold text-dark">64</h1>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="text-danger fw-semibold">↓ 2.25%</span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i data-feather="shopping-cart" class="align-middle"
                                        style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART COA -->
        <div class="col-xl-5 col-xxl-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">Distribusi Akun (COA) per Tipe</h5>
                    <small class="text-muted">Jumlah akun berdasarkan kategori</small>
                </div>
                <div class="card-body">
                    <div class="chart chart-sm">
                        <canvas id="coaChart" height="220"></canvas>
                    </div>
                </div>
                @if(isset($akun_chart))
                <div class="card-footer bg-white border-0">
                    <div class="row text-center g-3">
                        @foreach($akun_chart as $tipe => $jumlah)
                        <div class="col-6 col-sm-4 col-md-3">
                            <small class="text-muted d-block">{{ $tipe }}</small>
                            <strong class="text-primary fs-5">{{ number_format($jumlah) }}</strong>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- STATISTIK MATA UANG -->
        <div class="col-12 col-xxl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0 fw-bold">Statistik Mata Uang</h5>
                </div>
                <div class="card-body px-4 pb-4">

                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div>
                            <small class="text-muted">Total Mata Uang</small>
                            <h2 class="fw-bold text-dark mb-0">{{ $total_mata_uang ?? 0 }}</h2>
                        </div>
                        <div class="bg-light p-3 rounded-3">
                            <i data-feather="dollar-sign" style="width: 32px; height: 32px;"></i>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm bg-light rounded-4">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-3 px-2">
                                <small class="text-muted fw-medium">Mata Uang Terbaru</small>
                                <a href="#" class="text-primary small fw-medium text-decoration-none">Lihat Semua →</a>
                            </div>

                            @foreach($mata_uang_terbaru ?? [] as $item)
                            <div
                                class="d-flex align-items-center justify-content-between py-3 px-2 border-bottom last:border-0 currency-row">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="fs-3">💵</div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->kode }}</div>
                                        <small class="text-muted">{{ $item->nama }}</small>
                                    </div>
                                </div>
                                <div class="fw-bold fs-5">{{ $item->simbol ?? '-' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRAFIK PERUSAHAAN PER KOTA -->
        <div class="col-12 col-xxl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0 fw-bold">Jumlah Perusahaan per Kota</h5>
                    <small class="text-muted">Grafik total perusahaan berdasarkan kota</small>
                </div>
                <div class="card-body p-4">
                    <div style="height: 420px;">
                        <canvas id="perusahaanKotaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {

    // === COA Chart ===
    new Chart(document.getElementById('coaChart'), {
        type: 'doughnut', // atau 'pie'
        data: {
            labels: ['Aset', 'Liabilitas', 'Ekuitas', 'Pendapatan', 'Beban'],
            datasets: [{
                data: [
                    <?= $akun_chart['Aset'] ?? 0 ?>,
                    <?= $akun_chart['Liabilitas'] ?? 0 ?>,
                    <?= $akun_chart['Ekuitas'] ?? 0 ?>,
                    <?= $akun_chart['Pendapatan'] ?? 0 ?>,
                    <?= $akun_chart['Beban'] ?? 0 ?>
                ],
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                ],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 25,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Bar Chart Perusahaan per Kota (sudah bagus, tinggal keep)
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('perusahaanKotaChart');
    if (!canvas) return;

    // Data dari Laravel (paling aman)
    const labels = @json($kota_labels ?? []);
    const data = @json($kota_data ?? []);

    new Chart(canvas, { // Bisa langsung pakai canvas (lebih modern)
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Perusahaan',
                data: data,
                backgroundColor: '#0d6efd',
                borderColor: '#0b5ed7',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: '#0b5ed7'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 15
                    },
                    displayColors: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 13
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 13
                        },
                        maxRotation: 45, // Agar label kota tidak bertumpuk
                        minRotation: 0
                    }
                }
            }
        }
    });
});
</script>