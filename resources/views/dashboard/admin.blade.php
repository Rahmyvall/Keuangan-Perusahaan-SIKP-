@extends('layouts.app')
@section('content')
<h1 class="mb-3 h3">{{ $title ?? 'Dashboard' }}</h1>
<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start">

                                <!-- LEFT -->
                                <div>
                                    <h5 class="card-title">Pengguna</h5>

                                    <h1 class="mt-2 mb-2">
                                        {{ $total_pengguna ?? 0 }}
                                    </h1>

                                    <div class="mb-0">
                                        <span class="text-success">
                                            {{ $pengguna_aktif ?? 0 }} aktif
                                        </span>
                                        <span class="text-muted">/ {{ $pengguna_nonaktif ?? 0 }} nonaktif</span>
                                    </div>
                                </div>

                                <!-- ICON -->
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-0 col">
                                    <h5 class="card-title">Visitors</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">14.212</h1>
                            <div class="mb-0">
                                <span class="text-success">5.25%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-0 col">
                                    <h5 class="card-title">Visitors</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">14.212</h1>
                            <div class="mb-0">
                                <span class="text-success">5.25%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-0 col">
                                    <h5 class="card-title">Earnings</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">$21.300</h1>
                            <div class="mb-0">
                                <span class="text-success">6.65%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-0 col">
                                    <h5 class="card-title">Orders</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">64</h1>
                            <div class="mb-0">
                                <span class="text-danger">-2.25%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mt-0 col">
                                    <h5 class="card-title">Orders</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">64</h1>
                            <div class="mb-0">
                                <span class="text-danger">-2.25%</span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100 shadow-sm border-0 rounded-4">

            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">Distribusi Akun (COA) per Tipe</h5>
                <small class="text-muted">Jumlah akun berdasarkan kategori</small>
            </div>

            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="coaPieChart" width="400" height="300"></canvas>
                </div>
            </div>

            @if(isset($akun_chart))
            <div class="card-footer bg-white border-0">
                <div class="row text-center">
                    @foreach($akun_chart as $tipe => $jumlah)
                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                        <small class="text-muted">{{ $tipe }}</small><br>
                        <strong class="text-primary">{{ number_format($jumlah) }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
<div class="order-3 col-12 col-md-12 col-xxl-6 d-flex order-xxl-2">
    <div class="card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0">Statistik Mata Uang</h5>
        </div>

        <div class="card-body px-4">

            {{-- TOTAL --}}
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <small class="text-muted">Total Mata Uang</small>
                    <h4 class="fw-bold">{{ $total_mata_uang ?? 0 }}</h4>
                </div>

                <div class="bg-light rounded p-3">
                    <i data-feather="dollar-sign"></i>
                </div>
            </div>

            <hr>

            {{-- LIST SAMPLE --}}
            <div class="card border-0 shadow-sm rounded-4 mt-3">
                <div class="card-body p-3">

                    <div class="d-flex justify-content-between mb-2">
                        <small class="text-muted">Currencies</small>
                        <small class="text-primary">View all</small>
                    </div>

                    @foreach($mata_uang_terbaru ?? [] as $item)
                    <div class="d-flex align-items-center justify-content-between py-2 currency-row">

                        <div class="d-flex align-items-center gap-2">
                            <div class="currency-icon">
                                💵
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $item->kode }}</div>
                                <small class="text-muted">{{ $item->nama }}</small>
                            </div>
                        </div>

                        <div class="fw-bold text-dark">
                            {{ $item->simbol ?? '-' }}
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- GRAFIK PERUSAHAAN PER KOTA -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Jumlah Perusahaan per Kota</h5>
                <small class="text-muted">Grafik total perusahaan berdasarkan kota</small>
            </div>

            <div class="card-body">
                <div style="height: 450px;">
                    <canvas id="perusahaanKotaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('coaPieChart'); // Ganti ID jika perlu

    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Aset',
                'Liabilitas',
                'Ekuitas',
                'Pendapatan',
                'Beban'
            ],
            datasets: [{
                label: 'Jumlah Akun',
                data: [
                    <?= $akun_chart['Aset'] ?? 0 ?>,
                    <?= $akun_chart['Liabilitas'] ?? 0 ?>,
                    <?= $akun_chart['Ekuitas'] ?? 0 ?>,
                    <?= $akun_chart['Pendapatan'] ?? 0 ?>,
                    <?= $akun_chart['Beban'] ?? 0 ?>
                ],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 4,
                tension: 0.4, // Membuat garis melengkung (smooth)
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4e73df',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw + ' akun';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1, // Karena jumlah akun biasanya integer
                        font: {
                            size: 13
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 13
                        }
                    }
                }
            }
        }
    });
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
    var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
    document.getElementById("datetimepicker-dashboard").flatpickr({
        inline: true,
        prevArrow: "<span title=\"Previous month\">&laquo;</span>",
        nextArrow: "<span title=\"Next month\">&raquo;</span>",
        defaultDate: defaultDate
    });
});
</script>
