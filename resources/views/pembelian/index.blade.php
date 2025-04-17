{{-- filepath: c:\xampp\htdocs\UKK-Taufik\resources\views\pembelian\index.blade.php --}}
@extends('layouts.app')
@section('title', 'Pembelian')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pembelian</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="{{ route('pembelian.export-all') }}" class="btn btn-success shadow-sm">
                    <i class="fas fa-file-excel fa-sm text-white-50 mr-1"></i> Export Excel
                </a>
            </div>
            <div>
                @if(Auth::user()->role == 'staff')
                <a href="{{ route('pembelian.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Penjualan
                </a>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Dibuat Oleh</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pembelians->count() > 0)
                        @foreach($pembelians as $key => $pembelian)
                        <tr>
                            <td class="text-center">{{ $startingNumber + $key }}</td>
                            <td>{{ $pembelian->customer_name }}</td>
                            <td class="text-center">{{ $pembelian->tanggal }}</td>
                            <td>Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                            <td>{{ $pembelian->dibuat_oleh }}</td>
                            <td class="text-center">
                                <a href="{{ route('pembelian.show', $pembelian->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ route('pembelian.download', $pembelian->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Unduh Bukti
                                </a>
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
                                @if(Auth::user()->role == 'staff')
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
            @if($pembelians->count() > 0)
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $pembelians->firstItem() }} to {{ $pembelians->lastItem() }} of {{ $pembelians->total() }} results
                    </div>
                    <div>
                        {{ $pembelians->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection