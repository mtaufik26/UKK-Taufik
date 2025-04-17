@extends('layouts.app')
@section('title', 'Detail Pembelian')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Pembelian</h1>
            <p class="mb-0 text-muted">Detail lengkap transaksi pembelian</p>
        </div>
        <div>
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Invoice #123456</h6>
                <span class="badge badge-success">
                    <i class="fas fa-check-circle mr-1"></i> LUNAS
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Informasi Pembelian -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <h5 class="font-weight-bold mb-3"><i class="fas fa-info-circle mr-2"></i>Informasi Pembelian</h5>
                        <div class="row">
                            <div class="col-5 font-weight-bold">Tanggal</div>
                            <div class="col-7">
                                17 April 2025 15:30
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-5 font-weight-bold">Customer</div>
                            <div class="col-7">John Doe</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-5 font-weight-bold">Kasir</div>
                            <div class="col-7">Admin</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded h-100">
                        <h5 class="font-weight-bold mb-3"><i class="fas fa-receipt mr-2"></i>Ringkasan Pembayaran</h5>
                        
                        <!-- Daftar Produk -->
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="font-weight-bold">Produk A</span>
                                <div class="text-muted small">
                                    Rp. 100,000 × 2
                                </div>
                            </div>
                            <div class="text-right">
                                Rp. 200,000
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="font-weight-bold">Produk B</span>
                                <div class="text-muted small">
                                    Rp. 150,000 × 1
                                </div>
                            </div>
                            <div class="text-right">
                                Rp. 150,000
                            </div>
                        </div>
                        
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Belanja:</span>
                            <span>Rp. 350,000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pembayaran:</span>
                            <span>Rp. 400,000</span>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Kembalian:</span>
                            <span class="text-success">Rp. 50,000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="card-footer bg-white text-center">
            <p class="mb-0 text-muted">
                <i class="fas fa-info-circle mr-1"></i> Transaksi selesai pada 17 April 2025 15:30
            </p>
        </div>
    </div>
</div>
@endsection
