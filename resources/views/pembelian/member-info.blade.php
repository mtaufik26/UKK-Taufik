@extends('layouts.app')

@section('title', 'Informasi Member')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Informasi Member</h3>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Product List -->
                <div class="col-md-6">
                    <h5 class="mb-3">Produk yang dipilih</h5>
                    @php
                        $selectedProducts = json_decode($products, true);
                    @endphp
                    
                    <div class="card bg-light">
                        <div class="card-body">
                            @foreach($selectedProducts as $product)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-0 fw-medium">{{ $product['name'] }}</p>
                                    <small class="text-muted">Rp. {{ number_format($product['price'], 0, ',', '.') }} × {{ $product['quantity'] }}</small>
                                </div>
                                <div>
                                    <p class="mb-0 fw-medium">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="my-2">
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Total Pembelian</span>
                                <span class="fw-bold">Rp. {{ number_format($total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Total Bayar</span>
                                <span class="fw-bold text-primary">Rp. {{ number_format($total_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-medium">Poin Yang Didapat</span>
                                <span class="fw-bold text-success">{{ number_format($points, 0, ',', '.') }} Poin</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Form -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('pembelian.pembayaran') }}" method="POST">
                                @csrf
                                <input type="hidden" name="products" value="{{ $products }}">
                                <input type="hidden" name="total_amount" value="{{ $total_amount }}">
                                <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">
                                <input type="hidden" name="phone_number" value="{{ $phone_number }}">
                                <input type="hidden" name="member_type" value="member">
                                <input type="hidden" name="points_to_use" value="{{ $existingPoints }}">

                                <div class="form-group mb-4">
                                    <label class="form-label fw-medium">Nama Member</label>
                                    <input type="text" name="member_name" class="form-control" 
                                           value="{{ $memberName }}" {{ $memberName ? 'readonly' : 'required' }}>
                                    <small class="text-muted">Digunakan sebagai identitas member</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-medium">Poin Member</label>
                                    <div class="p-3 rounded border bg-light">
                                        <span class="fw-bold fs-5">{{ number_format($existingPoints, 0, ',', '.') }}</span>
                                        <small class="d-block text-muted mt-1">Total poin yang dimiliki</small>
                                    </div>

                                    @if($isNewMember)
                                    <div class="alert alert-danger mt-2 mb-0 py-2">
                                        <small class="d-block">Poin tidak dapat digunakan pada pembelanjaan pertama</small>
                                    </div>
                                    @else
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="use_points" id="usePoints">
                                        <label class="form-check-label" for="usePoints">
                                            Gunakan poin untuk pembelian ini
                                        </label>
                                    </div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Proses Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection