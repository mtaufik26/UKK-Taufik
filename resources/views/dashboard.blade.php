@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    @if(Auth::user()->role == 'admin')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Overview</h1>
            <div class="text-muted small">
                Last updated: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Sales Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Sales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalPembelian">{{ $totalPembelian }}</div>
                                <div class="text-xs text-gray-500 mt-2">Total transactions</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-primary opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Members Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Members</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalMember">{{ $totalMember }}</div>
                                <div class="text-xs text-gray-500 mt-2">Registered customers</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Products Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalProduk">{{ $totalProduk }}</div>
                                <div class="text-xs text-gray-500 mt-2">Available items</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-info opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Revenue</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalKeuntungan">
                                    Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-2">Overall earnings</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Sales Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Trend</h6>
                        <div class="text-muted small">Last 7 days</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area" style="height: 300px;">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Distribution Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Distribution</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2" style="height: 300px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <div class="row justify-content-center">
                                @foreach($productSales as $index => $product)
                                    <div class="col-auto mb-2">
                                        <span class="mr-2">
                                            <i class="fas fa-circle" style="color: {{ $colors[$index % count($colors)] }}"></i>
                                            {{ $product->nama_produk }}
                                            <span class="font-weight-bold">({{ $product->total_sold }})</span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Staff Dashboard -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <h2 class="h4 mb-4 text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>

                        <div class="card bg-light border-0">
                            <div class="card-body text-center p-5">
                                <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                                <div class="text-gray-500 mb-3">Today's Sales</div>
                                <div class="h1 mb-3 font-weight-bold text-primary">{{ $todaySales }}</div>
                                <div class="text-gray-500 mb-4">
                                    Total sales transactions for today
                                </div>
                                <div class="text-muted small">
                                    Last updated: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .opacity-50 {
        opacity: 0.5;
    }
    .chart-area, .chart-pie {
        position: relative;
        height: 100%;
    }
</style>
@endpush

@endsection
    

@push('scripts')
    <!-- Include Chart.js and Moment.js Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        @if (Auth::user()->role === 'admin')
        // Prepare data for area chart (line chart)
        const dailyLabels = @json($dailySales->pluck('date'));
        const dailyData = @json($dailySales->pluck('total'));

        // Prepare data for pie chart
        const productLabels = @json($nama_produk);
        const productData = @json($actualData);

        // Area chart (Line chart)
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: dailyLabels,
            datasets: [{
              label: "Jumlah Penjualan",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: dailyData
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  maxTicksLimit: 7
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 5,
                  padding: 10,
                  // Include a currency format for the ticks
                  callback: function(value) {
                    return 'Rp ' + value.toLocaleString();
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: false
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': Rp ' + tooltipItem.yLabel.toLocaleString();
                }
              }
            }
          }
        });

        // Pie chart
        new Chart(document.getElementById("pieChart"), {
            type: "pie",
            data: {
                labels: productLabels,
                datasets: [{
                    data: productData,
                    backgroundColor: @json($colors)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        @endif
    </script>
@endpush