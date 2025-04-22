@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembayaran</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-4">
            <!-- Invoice Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    @if(isset($member) && $member)
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tag fa-2x text-primary mr-3"></i>
                                <div>
                                    <h6 class="mb-1 font-weight-bold">{{ $member->phone_number }}</h6>
                                    <p class="mb-0 text-muted">
                                        <small>Member sejak: {{ \Carbon\Carbon::parse($member->member_since)->translatedFormat('d F Y') }}</small><br>
                                        <small>Total Poin: {{ number_format($member->points, 0, ',', '.') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6 text-right">
                    <h4 class="text-primary mb-1">#{{ $invoice_number }}</h4>
                    <p class="text-muted mb-0">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ date('d F Y') }}
                    </p>
                </div>
            </div>

            <!-- Products Table -->
            <div class="table-responsive mb-4">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Produk</th>
                            <th width="15%" class="text-center">Harga Satuan</th>
                            <th width="10%" class="text-center">Jumlah</th>
                            <th width="20%" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedProducts as $product)
                        <tr>
                            <td class="font-weight-medium">{{ $product['name'] }}</td>
                            <td class="text-center">Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $product['quantity'] }}</td>
                            <td class="text-right font-weight-bold">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Payment Summary -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted small text-uppercase">Poin Digunakan</h6>
                                    <p class="h5 mb-0">{{ number_format($points_used ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted small text-uppercase">Kasir</h6>
                                    <p class="h5 mb-0">{{ $pembelian->dibuat_oleh }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted small text-uppercase">Kembalian</h6>
                                    <p class="h5 text-success mb-0">Rp. {{ number_format($kembalian, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-2 opacity-75">Total Pembayaran</h6>
                            @if($discount_from_points > 0)
                                <p class="text-light mb-1"><small><del>Rp. {{ number_format($total, 0, ',', '.') }}</del></small></p>
                            @endif
                            <h3 class="mb-0">Rp. {{ number_format($final_total, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('pembelian.index') }}" class="btn btn-light mr-2">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                </a>
                <a href="{{ route('pembelian.export_pdf', $pembelian->id) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf mr-2"></i>Unduh Invoice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection