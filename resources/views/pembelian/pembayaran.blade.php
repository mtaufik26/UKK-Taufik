@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pembayaran</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body p-5">
            <div class=" justify-content-between align-items-center mb-5">
                <div class="btn-group mt-3 mb-4">
                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('pembelian.download', $pembelian->id) }}" class="btn btn-primary">
                        <i class="fas fa-download mr-2"></i>Unduh Struk
                    </a>
                </div>
                <div class="d-flex justify-content-between">
                    <h5 class="text-muted font-weight-bold">INVOICE #{{ $pembelian->invoice_number }}</h5>
                    <div class="badge badge-success p-2 mb-2">
                        <i class="fas fa-check-circle mr-1"></i> LUNAS
                    </div>
                </div>
                <p class="text-muted mb-0">
                    <i class="far fa-calendar-alt mr-1"></i>
                    @if($pembelian->tanggal instanceof \DateTime)
                        {{ $pembelian->tanggal->format('d F Y H:i') }}
                    @else
                        {{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d F Y H:i') }}
                    @endif
                </p>
                
            </div>

            @if($pembelian->customer_name !== 'Non Member')
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-tag fa-2x mr-3"></i>
                    <div>
                        <h5 class="mb-1">Member: {{ $pembelian->customer_name }}</h5>
                        <p class="mb-0">Terima kasih telah berbelanja</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Produk</th>
                            <th width="15%" class="text-center">Harga</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="20%" class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product['name'] }}</td>
                            <td class="text-center">Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td class="text-center">{{ $product['quantity'] }}</td>
                            <td class="text-right">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="bg-light p-4 rounded">
                        <h5 class="font-weight-bold mb-4">Ringkasan Pembayaran</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Belanja:</span>
                            <span class="font-weight-bold">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pembayaran:</span>
                            <span class="font-weight-bold">Rp. {{ number_format($total + $kembalian, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="font-weight-bold">Kembalian:</span>
                            <span class="font-weight-bold text-success">Rp. {{ number_format($kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
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
            </div>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted">Terima kasih telah berbelanja di toko kami</p>
            </div>
        </div>
    </div>
</div>
@endsection