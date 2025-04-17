@extends('layouts.app')
@section('title', 'Add Product')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
        <a href="" class="d-none d-sm-inline-block btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Products
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_produk">Product Name</label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                id="nama_produk" name="nama_produk" value="" 
                                required minlength="3" maxlength="255">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga">Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control @error('harga') is-invalid @enderror" 
                                    id="harga" name="harga" value="" 
                                    placeholder="0" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stok">Stock</label>
                            <input type="number" class="form-control " 
                                id="stok" name="stok" value="" 
                                min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="img">Product Image</label>
                            <input type="file" class="form-control " 
                                id="img" name="img" accept="image/jpeg,image/png,image/jpg">

                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-2"></i> Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
