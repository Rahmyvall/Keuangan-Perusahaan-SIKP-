@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h1 class="mb-5 fw-bold text-dark">{{ $title ?? 'Dashboard' }}</h1>

    <div class="row g-4">

        <!-- ==================== STATISTIK UTAMA ==================== -->
        <div class="row g-4">

            <!-- ================= KPI UTAMA ================= -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Total Pengguna</div>
                            <h3 class="fw-bold mt-2 mb-1">{{ $total_pengguna ?? 0 }}</h3>
                            <div class="small text-muted">
                                <span class="text-success fw-semibold">{{ $pengguna_aktif ?? 0 }}</span> aktif
                                /
                                <span>{{ $pengguna_nonaktif ?? 0 }}</span> nonaktif
                            </div>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <i data-feather="users" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Transaksi -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Total Transaksi</div>
                            <h3 class="fw-bold mt-2 mb-1">
                                {{ number_format($total_transaksi ?? 0) }}
                            </h3>

                            @php $growth = $growth_transaksi ?? 0; @endphp

                            <div class="small">
                                <span class="{{ $growth >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ $growth >= 0 ? '↑' : '↓' }} {{ number_format(abs($growth), 2) }}%
                                </span>
                                <span class="text-muted"> vs minggu lalu</span>
                            </div>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <i data-feather="shopping-cart" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Earnings -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Total Earnings</div>
                            <h3 class="fw-bold mt-2 mb-1">
                                Rp {{ number_format($total_earnings ?? 0) }}
                            </h3>

                            @php $growth = $growth_earnings ?? 0; @endphp

                            <div class="small">
                                <span class="{{ $growth >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ $growth >= 0 ? '↑' : '↓' }} {{ number_format(abs($growth), 2) }}%
                                </span>
                                <span class="text-muted"> vs minggu lalu</span>
                            </div>
                        </div>

                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                            <i data-feather="dollar-sign" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Supplier -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Total Supplier</div>
                            <h3 class="fw-bold mt-2 mb-1">
                                {{ $total_supplier ?? 0 }}
                            </h3>
                            <div class="small text-muted">
                                Supplier terdaftar di sistem
                            </div>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <i data-feather="truck" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ================= PENERIMAAN ================= -->

            <!-- Hari Ini -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Hari Ini</div>
                            <h4 class="fw-bold text-success mt-2">
                                Rp {{ number_format($penerimaan_hari_ini ?? 0, 0, ',', '.') }}
                            </h4>

                            <div class="small">
                                <span class="{{ ($growth_hari_ini ?? 0) >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ ($growth_hari_ini ?? 0) >= 0 ? '↑' : '↓' }}
                                    {{ abs($growth_hari_ini ?? 0) }}%
                                </span>
                                <span class="text-muted"> vs kemarin</span>
                            </div>
                        </div>

                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                            <i data-feather="calendar" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Rekening Bank -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Rekening Bank</div>
                            <h3 class="fw-bold mt-2 mb-1">
                                {{ $total_rekening_bank ?? 0 }}
                            </h3>
                            <div class="small text-muted">
                                Total rekening terdaftar
                            </div>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <i data-feather="credit-card" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Bulan Ini -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Bulan Ini</div>
                            <h4 class="fw-bold text-primary mt-2">
                                Rp {{ number_format($penerimaan_bulan_ini ?? 0, 0, ',', '.') }}
                            </h4>

                            <div class="small">
                                <span class="{{ ($growth_bulan_ini ?? 0) >= 0 ? 'text-primary' : 'text-danger' }}">
                                    {{ ($growth_bulan_ini ?? 0) >= 0 ? '↑' : '↓' }}
                                    {{ abs($growth_bulan_ini ?? 0) }}%
                                </span>
                                <span class="text-muted"> vs bulan lalu</span>
                            </div>
                        </div>

                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                            <i data-feather="dollar-sign" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>
            <!-- ================= SALDO AWAL ================= -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Saldo Awal</div>

                            <h3 class="fw-bold mt-2 mb-1">
                                Rp {{ number_format($saldo_awal_total ?? 0) }}
                            </h3>

                            <div class="small text-muted">
                                <span class="text-success fw-semibold">
                                    Debit: {{ number_format($saldo_awal_debit ?? 0) }}
                                </span>
                                /
                                <span class="text-danger">
                                    Kredit: {{ number_format($saldo_awal_kredit ?? 0) }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                            <i data-feather="layers" style="width:38px;height:38px;"></i>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Total Penerimaan -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-start">

                        <div>
                            <div class="text-muted small">Total Penerimaan</div>
                            <h4 class="fw-bold mt-2">
                                Rp {{ number_format($total_penerimaan ?? 0, 0, ',', '.') }}
                            </h4>

                            <span class="badge bg-info mt-2">
                                {{ $total_transaksi_penerimaan ?? 0 }} transaksi
                            </span>
                        </div>

                        <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                            <i data-feather="trending-up" style="width:38px;height:38px;"></i>
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

        <div class="col-xl-5">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0 pt-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="mb-1 fw-bold">
                                Grafik Faktur Pembelian
                            </h5>

                            <small class="text-muted">
                                Statistik total transaksi pembelian
                            </small>
                        </div>

                        <div class="bg-primary-subtle p-3 rounded-4">
                            <i data-feather="shopping-cart" class="text-primary" style="width:32px;height:32px;">
                            </i>
                        </div>

                    </div>

                </div>

                <div class="card-body px-4 pb-4">

                    <div class="row mb-4">

                        <div class="col-6">

                            <small class="text-muted">
                                Total Faktur
                            </small>

                            <h2 class="fw-bold mb-0 text-dark">
                                {{ $total_faktur_pembelian ?? 0 }}
                            </h2>

                        </div>

                        <div class="col-6 text-end">

                            <small class="text-muted">
                                Total Pembelian
                            </small>

                            <h5 class="fw-bold text-primary mb-0">
                                Rp {{ number_format($total_nominal_pembelian ?? 0,0,',','.') }}
                            </h5>

                        </div>

                    </div>

                    <!-- Chart -->
                    <div class="bg-light rounded-4 p-3">

                        <canvas id="fakturPembelianChart" height="180">
                        </canvas>

                    </div>

                    <!-- Statistik bawah -->
                    <div class="row text-center mt-4 g-3">

                        <div class="col-4">

                            <div class="bg-success-subtle rounded-4 p-3">

                                <div class="fw-bold text-success fs-5">
                                    {{ $faktur_lunas ?? 0 }}
                                </div>

                                <small class="text-muted">
                                    Lunas
                                </small>

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="bg-warning-subtle rounded-4 p-3">

                                <div class="fw-bold text-warning fs-5">
                                    {{ $faktur_belum_lunas ?? 0 }}
                                </div>

                                <small class="text-muted">
                                    Belum Lunas
                                </small>

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="bg-danger-subtle rounded-4 p-3">

                                <div class="fw-bold text-danger fs-5">
                                    {{ $faktur_dibatalkan ?? 0 }}
                                </div>

                                <small class="text-muted">
                                    Dibatalkan
                                </small>

                            </div>

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
        <!-- ==================== GRAFIK DEPRESIASI ==================== -->
        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 pt-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Grafik Depresiasi Aset
                            </h5>

                            <small class="text-muted">
                                Statistik penyusutan aset per bulan
                            </small>

                        </div>

                        <div class="bg-danger-subtle p-3 rounded-4">

                            <i data-feather="bar-chart-2" class="text-danger" style="width:32px;height:32px;"></i>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <canvas id="depresiasiChart" height="120"></canvas>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/*
|--------------------------------------------------------------------------
| DEPRESIASI CHART
|--------------------------------------------------------------------------
*/

const depresiasiCtx = document.getElementById('depresiasiChart');

if (depresiasiCtx) {

    new Chart(depresiasiCtx, {

        type: 'line',

        data: {

            labels: @json($depresiasi_bulan ?? []),

            datasets: [{

                label: 'Nilai Depresiasi',

                data: @json($depresiasi_total ?? []),

                borderColor: '#dc3545',

                backgroundColor: 'rgba(220,53,69,0.15)',

                borderWidth: 3,

                fill: true,

                tension: 0.4,

                pointRadius: 5,

                pointHoverRadius: 7,

                pointBackgroundColor: '#dc3545'
            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
}
</script>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const ctx = document.getElementById(
        'fakturPembelianChart'
    );

    if (!ctx) {
        console.log('Canvas tidak ditemukan');
        return;
    }

    const chartBulan = @json($chart_bulan ?? []);

    const chartTotal = @json($chart_total ?? []);

    console.log(chartBulan);
    console.log(chartTotal);

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: chartBulan,

            datasets: [{

                label: 'Total Pembelian',

                data: chartTotal,

                borderColor: '#0d6efd',

                backgroundColor: 'rgba(13,110,253,0.15)',

                borderWidth: 3,

                fill: true,

                tension: 0.4,

                pointRadius: 5,

                pointHoverRadius: 7

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: true
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'Rp ' +
                                value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

});
</script>
@endpush
