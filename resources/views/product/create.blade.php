@extends('layouts.app')
@section('title', 'Add Product')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Products
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_produk" class="font-weight-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" 
                                required minlength="3" maxlength="255"
                                placeholder="Enter product name">
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
                                    id="harga" name="harga" value="{{ old('harga') }}" 
                                    placeholder="0" required>
                            </div>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok" class="font-weight-bold">Initial Stock <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                id="stok" name="stok" value="{{ old('stok', 0) }}" 
                                min="0" required placeholder="Enter initial stock">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="img" class="font-weight-bold">Product Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('img') is-invalid @enderror" 
                                    id="img" name="img" accept="image/jpeg,image/png,image/jpg" required>
                                <label class="custom-file-label" for="img">Choose file...</label>
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Accepted formats: JPG, JPEG, PNG. Max size: 2MB</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary mr-2">
                        <i class="fas fa-undo-alt mr-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Product
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
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value.length > 0) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        e.target.value = value;
    });

    document.getElementById('productForm').addEventListener('submit', function(e) {
        const priceInput = document.getElementById('harga');
        const numericValue = priceInput.value.replace(/\./g, '');
        
        if (!numericValue || isNaN(numericValue) || numericValue <= 0) {
            e.preventDefault();
            alert('Please enter a valid price');
            priceInput.focus();
            return;
        }
        priceInput.value = numericValue;
    });

    document.getElementById('img').addEventListener('change', function() {
        const fileName = this.files[0]?.name || 'Choose file...';
        const label = this.nextElementSibling;
        label.textContent = fileName;
    });
</script>
@endpush
@endsection