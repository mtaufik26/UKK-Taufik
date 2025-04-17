{{-- filepath: c:\xampp\htdocs\UKK-Taufik\resources\views\product\index.blade.php --}}
@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Produk</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="{{ route('product.export-all') }}" class="btn btn-success shadow-sm">
                    <i class="fas fa-file-excel fa-sm text-white-50 mr-1"></i> Export Excel
                </a>
            </div>
            <div>
                @if(Auth::user()->role == 'staff')
                <a href="{{ route('product.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Produk
                </a>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($products->count() > 0)
                        @foreach($products as $key => $product)
                        <tr>
                            <td class="text-center">{{ $startingNumber + $key }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td class="text-center">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center gap-3">
                                <!-- Ikon diperkecil (h-10 w-10 / ukuran 2.5rem) -->
                                <svg className="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z"/>
                                  </svg>
                                <div>
                                    <h5 class="text-muted mb-1">Belum ada data pembelian</h5>
                                </div>
                                @if(Auth::user()->role == 'admin')
                                <p class="small text-muted opacity-75 mb-0">Klik tombol di bawah untuk menambahkan data</p>
                                <a href="{{ route('pembelian.create') }}" class="btn btn-primary btn-sm mt-1 px-4">
                                    <i class="fas fa-plus me-2"></i> Tambah Pembelian
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            @if($products->count() > 0)
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                    </div>
                    <div>
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection