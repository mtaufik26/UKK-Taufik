@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Penjualan</h1>

    <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                            <img src="" 
                                 alt=""
                                 class="img-fluid mb-3 rounded-lg"
                                 style="height: 150px; object-fit: contain;">

                            <img src="{{ asset('img/no-image.png') }}"
                                 alt="No Image"
                                 class="img-fluid mb-3 rounded-lg"
                                 style="height: 150px; object-fit: contain;">

                        <h4 class="card-title"></h4>
                        <p class="text-muted">Stok </p>
                        <h5 class="text-primary font-weight-bold">
                            Rp. 
                        </h5>

                        <div class="d-flex justify-content-center align-items-center my-3">
                            <div class="input-group" style="width: 200px;">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-primary btn-minus" 
                                        data-id=""
                                        data-price="">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>

                                <input type="number" id="" 
                                    class="form-control text-center" 
                                    value="0" 
                                    min="0" 
                                    max=""
                                    readonly>

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary btn-plus" 
                                        data-id="" 
                                        data-price=""
                                        data-stock=""
                                        >
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-muted mb-3">
                            Sub Total <span id="" class="font-weight-bold">Rp. 0</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="fixed-bottom bg-white py-3 px-4 shadow-sm" style="border-top: 1px solid #e3e6f0;">
        <div class="container-fluid">
            <form id="salesForm" method="POST" action="">
                @csrf
                <div id="selected-products"></div>
                <button type="submit" class="btn btn-primary px-5 float-right">Selanjutnya <i class="fas fa-arrow-right ml-2"></i></button>
            </form>
        </div>
    </div>
</div>
@endsection