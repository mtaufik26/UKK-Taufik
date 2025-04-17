@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product List</h1>
    @if(Auth::user()->role == 'admin')
    <a href="{{ route('products.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add Product
    </a>
    @endif
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        @if(Auth::user()->role == 'admin')
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="text-center align-middle">
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @if($product->img)
                                <img src="{{ asset('storage/'.$product->img) }}" 
                                    alt="{{ $product->nama_produk }}" 
                                    class="img-thumbnail"
                                    style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <img src="{{ asset('img/no-image.png') }}" 
                                    alt="No Image" 
                                    class="img-thumbnail"
                                    style="width: 70px; height: 70px; object-fit: cover;">
                            @endif
                        </td>
                        <td class="align-middle">{{ $product->nama_produk }}</td>
                        <td class="align-middle">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td class="align-middle text-lg">
                            <span class="{{ $product->stok < 10 ? 'badge text-danger' : 'badge text-success' }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        @if(Auth::user()->role == 'admin')
                        <td class="align-middle">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#stockModal{{ $product->id }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($products as $product)
<div class="modal fade" id="stockModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="stockModalLabel">Update Stock - {{ $product->nama_produk }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.update-stock', $product->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" value="{{ $product->nama_produk }}" readonly>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control text-center" 
                                id="stockInput{{ $product->id }}" 
                                value="{{ $product->stok }}"
                                min="0"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.modal').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });

        const forms = document.querySelectorAll('form[action*="update-stock"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const input = this.querySelector('input[name="stok"]');
                const value = parseInt(input.value) || 0;
                
                if (value <= 0) {
                    e.preventDefault();
                    alert('Stock cannot be zero or negative');
                }
            });
        });
    });
</script>
@endpush