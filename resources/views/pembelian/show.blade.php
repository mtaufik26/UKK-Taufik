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
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Invoice #{{ $pembelian->invoice_number }}</h6>
                <span class="badge badge-success">
                    <i class="fas fa-check-circle mr-1"></i> LUNAS
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Informasi Pembelian & Ringkasan Pembayaran -->
            <div class="row mb-4">
                <!-- Informasi Pembelian -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded h-100">
                        <h5 class="font-weight-bold mb-3"><i class="fas fa-info-circle mr-2"></i>Informasi Pembelian</h5>
                        <div class="row">
                            <div class="col-5 font-weight-bold">Tanggal</div>
                            <div class="col-7">{{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d F Y H:i') }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-5 font-weight-bold">Customer</div>
                            <div class="col-7">{{ $pembelian->customer_name }}</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-5 font-weight-bold">Dibuat Oleh</div>
                            <div class="col-7">{{ $pembelian->dibuat_oleh }}</div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded h-100">
                        <h5 class="font-weight-bold mb-3"><i class="fas fa-receipt mr-2"></i>Ringkasan Pembayaran</h5>
                        @foreach($detailPembelian as $detail)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="font-weight-bold">{{ $detail->product->nama_produk }}</span>
                                <div class="text-muted small">
                                    Rp. {{ number_format($detail->product->harga, 0, ',', '.') }} × {{ $detail->quantity }}
                                </div>
                            </div>
                            <div class="text-right">
                                Rp. {{ number_format($detail->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Belanja:</span>
                            <span>Rp. {{ number_format($pembelian->grand_total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pembayaran:</span>
                            <span>Rp. {{ number_format($pembelian->grand_total + $pembelian->kembalian, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span>Kembalian:</span>
                            <span class="text-success">Rp. {{ number_format($pembelian->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Kasir -->
            {{-- <div class="row mb-4">
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded h-100">
                        <h5 class="font-weight-bold mb-4">Info Kasir</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-primary text-white rounded-circle mr-3" style="width: 40px; height: 40px; line-height: 40px; text-align: center;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold">{{ Auth::user()->name }}</h6>
                                <small class="text-muted">Kasir</small>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="font-weight-bold mb-2">Poin Didapat:</h6>
                            <div class="bg-white p-2 rounded text-center">
                                <h3 class="mb-0 text-primary">0</h3>
                                <small class="text-muted">Poin</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="card-footer bg-white text-center">
            <p class="mb-0 text-muted">
                <i class="fas fa-info-circle mr-1"></i> Transaksi selesai pada 
                {{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d F Y H:i') }}
            </p>
        </div>
    </div>
</div>
@endsection
