@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h1 class="mb-5 fw-bold text-dark">{{ $title ?? 'Dashboard' }}</h1>

    <div class="row g-4">

        <!-- ==================== STATISTIK UTAMA ==================== -->
        <div class="col-12">
            <div class="row g-4">

                <!-- Total Pengguna -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small fw-medium">Total Pengguna</div>
                                    <h2 class="mt-3 mb-1 fw-bold text-dark">{{ $total_pengguna ?? 0 }}</h2>
                                    <div class="small">
                                        <span class="text-success fw-semibold">{{ $pengguna_aktif ?? 0 }} aktif</span>
                                        <span class="text-muted"> / {{ $pengguna_nonaktif ?? 0 }} nonaktif</span>
                                    </div>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i data-feather="users" style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaksi -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small fw-medium">Total Transaksi</div>
                                    <h2 class="mt-3 mb-1 fw-bold text-dark">
                                        {{ number_format($total_transaksi ?? 0) }}
                                    </h2>
                                    <div class="d-flex align-items-center gap-1">
                                        <span
                                            class="text-{{ $growth_transaksi >= 0 ? 'success' : 'danger' }} fw-semibold">
                                            {{ $growth_transaksi >= 0 ? '↑' : '↓' }} {{ abs($growth_transaksi ?? 0) }}%
                                        </span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i data-feather="shopping-cart" style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-muted small fw-medium">Total Earnings</div>
                                    <h2 class="mt-3 mb-1 fw-bold text-dark">
                                        Rp {{ number_format($total_earnings ?? 0) }}
                                    </h2>
                                    <div class="d-flex align-items-center gap-1">
                                        <span
                                            class="text-{{ $growth_earnings >= 0 ? 'success' : 'danger' }} fw-semibold">
                                            {{ $growth_earnings >= 0 ? '↑' : '↓' }} {{ abs($growth_earnings ?? 0) }}%
                                        </span>
                                        <span class="text-muted small">minggu lalu</span>
                                    </div>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                    <i data-feather="dollar-sign" style="width: 42px; height: 42px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders -->
                <div class="col-md-6 col-lg-3">

                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow transition-all">

                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>

                                    <div class="text-muted small fw-medium">
                                        Total Supplier
                                    </div>

                                    <h2 class="mt-3 mb-1 fw-bold text-dark">
                                        {{ $total_supplier ?? 0 }}
                                    </h2>

                                    <div class="d-flex align-items-center gap-1">

                                        <span class="text-success fw-semibold">
                                            Supplier Terdaftar
                                        </span>

                                        <span class="text-muted small">
                                            aktif di sistem
                                        </span>

                                    </div>

                                </div>

                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4">

                                    <i data-feather="truck" style="width:42px;height:42px;"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- ==================== PENERIMAAN ==================== -->
        <div class="row g-4 mb-5">

            <!-- Card 1: Penerimaan Hari Ini -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small fw-medium">Hari Ini</div>
                                <h1 class="mt-3 mb-1 fw-bold text-success">
                                    Rp {{ number_format($penerimaan_hari_ini ?? 0, 0, ',', '.') }}
                                </h1>
                                <div class="d-flex align-items-center gap-1">
                                    <span
                                        class="{{ ($growth_hari_ini ?? 0) >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                        {{ ($growth_hari_ini ?? 0) >= 0 ? '↑' : '↓' }} {{ abs($growth_hari_ini ?? 0) }}%
                                    </span>
                                    <span class="text-muted small">dari kemarin</span>
                                </div>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                                <i data-feather="calendar" class="align-middle" style="width: 42px; height: 42px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Penerimaan Bulan Ini -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small fw-medium">Bulan Ini</div>
                                <h1 class="mt-3 mb-1 fw-bold text-primary">
                                    Rp {{ number_format($penerimaan_bulan_ini ?? 0, 0, ',', '.') }}
                                </h1>
                                <div class="d-flex align-items-center gap-1">
                                    <span
                                        class="{{ ($growth_bulan_ini ?? 0) >= 0 ? 'text-primary' : 'text-danger' }} fw-semibold">
                                        {{ ($growth_bulan_ini ?? 0) >= 0 ? '↑' : '↓' }}
                                        {{ abs($growth_bulan_ini ?? 0) }}%
                                    </span>
                                    <span class="text-muted small">dari bulan lalu</span>
                                </div>
                            </div>
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                <i data-feather="dollar-sign" class="align-middle"
                                    style="width: 42px; height: 42px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Penerimaan Keseluruhan -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small fw-medium">Total Penerimaan</div>
                                <h1 class="mt-3 mb-1 fw-bold text-dark">
                                    Rp {{ number_format($total_penerimaan ?? 0, 0, ',', '.') }}
                                </h1>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="badge bg-info">{{ $total_transaksi_penerimaan ?? 0 }} Transaksi</span>
                                </div>
                            </div>
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                                <i data-feather="trending-up" class="align-middle"
                                    style="width: 42px; height: 42px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ==================== CHARTS ==================== -->
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="mb-0 fw-bold">Distribusi Akun (COA) per Tipe</h5>
                    <small class="text-muted">Jumlah akun berdasarkan kategori</small>
                </div>
                <div class="card-body">
                    <div style="height: 320px;">
                        <canvas id="coaChart"></canvas>
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

        <!-- Statistik Mata Uang -->
        <div class="col-xl-5">
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
                            <i data-feather="dollar-sign" style="width: 36px; height: 36px;"></i>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm bg-light rounded-4">
                        <div class="card-body p-3">
                            @foreach($mata_uang_terbaru ?? [] as $item)
                            <div
                                class="d-flex align-items-center justify-content-between py-3 px-2 border-bottom last:border-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="fs-2">💵</div>
                                    <div>
                                        <div class="fw-semibold">{{ $item->kode }}</div>
                                        <small class="text-muted">{{ $item->nama }}</small>
                                    </div>
                                </div>
                                <div class="fw-bold fs-4">{{ $item->simbol ?? '-' }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Perusahaan per Kota -->
        <div class="col-12">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // COA Doughnut Chart
    new Chart(document.getElementById('coaChart'), {
        type: 'doughnut',
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
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                borderWidth: 0,
                hoverOffset: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 13
                        }
                    }
                }
            }
        }
    });

    // Perusahaan per Kota Bar Chart
    const ctx = document.getElementById('perusahaanKotaChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($kota_labels ?? []),
                datasets: [{
                    label: 'Jumlah Perusahaan',
                    data: @json($kota_data ?? []),
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush