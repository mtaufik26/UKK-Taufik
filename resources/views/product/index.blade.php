@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Product List</h1>
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Product
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th width="15%">Image</th>
                            <th width="30%">Product Name</th>
                            <th width="20%">Price</th>
                            <th width="15%">Stock</th>
                            @if(Auth::user()->role == 'admin')
                                <th width="15%">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">
                                    @if($product->img)
                                        <img src="{{ asset('storage/'.$product->img) }}" 
                                            alt="{{ $product->nama_produk }}" 
                                            class="img-thumbnail"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('img/no-image.png') }}" 
                                            alt="No Image" 
                                            class="img-thumbnail"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                </td>
                                <td class="align-middle">{{ $product->nama_produk }}</td>
                                <td class="align-middle text-right">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-pill {{ $product->stok < 10 ? 'badge-danger' : 'badge-success' }} px-3 py-2">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('products.edit', $product->id) }}" 
                                                class="btn btn-warning btn-sm" 
                                                title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                class="btn btn-primary btn-sm" 
                                                data-toggle="modal" 
                                                data-target="#stockModal{{ $product->id }}"
                                                title="Update Stock">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <form action="{{ route('products.destroy', $product->id) }}" 
                                                method="POST" 
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    title="Delete Product">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role == 'admin' ? '6' : '5' }}" class="text-center py-5">
                                    <div class="text-center">
                                        <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 mb-3">No products available</p>
                                        @if(Auth::user()->role == 'admin')
                                            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus mr-1"></i> Add First Product
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
@foreach($products as $product)
    <div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-box-open mr-2"></i>
                        Update Stock
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.update-stock', $product->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            @if($product->img)
                                <img src="{{ asset('storage/'.$product->img) }}" 
                                    alt="{{ $product->nama_produk }}" 
                                    class="img-thumbnail mb-3"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                            <h5 class="font-weight-bold text-primary mb-0">{{ $product->nama_produk }}</h5>
                            <small class="text-muted">Product ID: {{ $product->id }}</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Current Stock</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-layer-group"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control bg-light" 
                                    value="{{ $product->stok }} units" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-dark">New Stock Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                                <input type="number" 
                                    name="stok" 
                                    class="form-control text-center font-weight-bold" 
                                    value="{{ $product->stok }}"
                                    min="0"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-light">units</span>
                                </div>
                            </div>
                            <small class="text-muted">Enter the new total stock amount</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@push('styles')
<style>
    .modal-content {
        border: none;
        border-radius: 0.5rem;
    }
    .modal-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>
@endpush

@push('styles')
<style>
    .badge {
        font-size: 0.9rem;
    }
    .btn-group .btn {
        margin: 0 2px;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@endsection