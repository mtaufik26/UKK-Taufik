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
                    <a href="#" class="btn btn-success shadow-sm">
                        <i class="fas fa-file-excel fa-sm text-white-50 mr-1"></i> Export Excel
                    </a>
                </div>
                <div>
                    <a href="#" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Penjualan
                    </a>
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
                        <tr>
                            <td class="text-center">1</td>
                            <td>John Doe</td>
                            <td class="text-center">2025-04-17</td>
                            <td>Rp 1,000,000</td>
                            <td>Admin</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="#" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Unduh Bukti
                                </a>
                            </td>
                        </tr>
                        <!-- Additional rows can go here -->
                    </tbody>
                </table>
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing 1 to 10 of 50 results
                        </div>
                        <div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
