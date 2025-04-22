@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Products
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_produk" class="font-weight-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                id="nama_produk" name="nama_produk" 
                                value="{{ old('nama_produk', $product->nama_produk) }}" 
                                required placeholder="Enter product name">
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="harga" class="font-weight-bold">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">Rp</span>
                                </div>
                                <input type="text" class="form-control @error('harga') is-invalid @enderror" 
                                    id="harga" name="harga" 
                                    value="{{ old('harga', number_format($product->harga, 0, ',', '.')) }}" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok" class="font-weight-bold">Current Stock</label>
                            <input type="number" class="form-control bg-light" 
                                id="stok" value="{{ $product->stok }}" readonly>
                            <small class="text-muted">Stock can be updated from the product list page</small>
                        </div>

                        <div class="form-group">
                            <label for="img" class="font-weight-bold">Product Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('img') is-invalid @enderror" 
                                    id="img" name="img" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="img">Choose new image...</label>
                            </div>
                            @error('img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to keep current image</small>
                        </div>

                        @if($product->img)
                            <div class="mt-3">
                                <label class="font-weight-bold">Current Image</label>
                                <div class="border rounded p-2">
                                    <img src="{{ asset('storage/'.$product->img) }}" 
                                        alt="{{ $product->nama_produk }}" 
                                        class="img-thumbnail"
                                        style="max-height: 150px;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary mr-2">
                        <i class="fas fa-undo-alt mr-1"></i> Reset Changes
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .custom-file-label::after {
        content: "Browse";
    }
    .input-group-text {
        min-width: 45px;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    const priceInput = document.getElementById('harga');
    
    priceInput.addEventListener('input', function(e) {
        let value = this.value.replace(/[^\d]/g, '');
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        this.value = value;
    });

    document.getElementById('img').addEventListener('change', function() {
        const fileName = this.files[0]?.name || 'Choose new image...';
        this.nextElementSibling.textContent = fileName;
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        if (priceInput.value) {
            priceInput.value = priceInput.value.replace(/\./g, '');
        }
    });
</script>
@endpush
@endsection