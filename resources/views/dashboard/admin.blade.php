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
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="mb-0 card-title">Recent Movement</h5>
            </div>
            <div class="py-3 card-body">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
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
<!-- Script Grafik Minimal -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
    // Line chart
    new Chart(document.getElementById("chartjs-dashboard-line"), {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                "Dec"
            ],
            datasets: [{
                label: "Sales ($)",
                fill: true,
                backgroundColor: gradient,
                borderColor: window.theme.primary,
                data: [
                    2115,
                    1562,
                    1584,
                    1892,
                    1587,
                    1923,
                    2566,
                    2448,
                    2805,
                    3438,
                    2917,
                    3327
                ]
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                intersect: false
            },
            hover: {
                intersect: true
            },
            plugins: {
                filler: {
                    propagate: false
                }
            },
            scales: {
                xAxes: [{
                    reverse: true,
                    gridLines: {
                        color: "rgba(0,0,0,0.0)"
                    }
                }],
                yAxes: [{
                    ticks: {
                        stepSize: 1000
                    },
                    display: true,
                    borderDash: [3, 3],
                    gridLines: {
                        color: "rgba(0,0,0,0.0)"
                    }
                }]
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('perusahaanKotaChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // Data dari Laravel (aman dari null)
    const labels = @json($kota_labels ?? []);
    const data = @json($kota_data ?? []);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Perusahaan',
                data: data,
                backgroundColor: '#0d6efd',
                borderRadius: 6
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
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }]
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
