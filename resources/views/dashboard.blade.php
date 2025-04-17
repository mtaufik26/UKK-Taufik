@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if(Auth::user()->role == 'admin')

        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body ">
                <h2 class="h4 mb-1 text-gray-800">Selamat Datang, Admin!</h2>
            </div>

            <div class="row m-1">
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Product Categories</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-primary"></i> Electronics
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Clothing
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-info"></i> Accessories
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <h1 class="h3 mb-3  text-gray-800">Dashboard</h1>

            <div class="card shadow rounded-lg">
                <div class="card-body p-5">
                    <h2 class="h4 mb-4 text-gray-800">Selamat Datang, Stuf!</h2>

                    <div class="card bg-light border-0">
                        <div class="card-body text-center p-5">
                            <div class="text-gray-500 mb-3">Total Penjualan Hari Ini</div>
                            
                            <div class="h1 mb-3 font-weight-bold text-gray-800">0</div>
                            
                            <div class="text-gray-500 mb-4">
                                Jumlah total penjualan yang terjadi hari ini.
                            </div>

                            <div class="text-gray-500 text-sm">
                                Terakhir diperbarui: {{ now()->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection