@extends('layouts.app')
@section('title', 'Pembelian')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pembelian</h1>
        @if(Auth::user()->role === 'stuf')
            <a href="{{ route('pembelian.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Penjualan
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian</h6>
            <a href="{{ route('pembelian.export') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-file-excel fa-sm text-white-50 mr-1"></i> Export Excel
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search fa-sm"></i>
                            </span>
                        </div>
                        <input type="text" id="search" class="form-control" placeholder="Cari pembelian..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="d-inline-flex align-items-center">
                        <span class="mr-2 text-gray-600">Tampilkan</span>
                        <select id="per-page" class="form-control form-control-sm" style="width: auto;">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="75" {{ request('per_page') == 75 ? 'selected' : '' }}>75</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span class="ml-2 text-gray-600">entri</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="15%">Tanggal Penjualan</th>
                            <th width="20%">Total Harga</th>
                            <th width="20%">Dibuat Oleh</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelians as $index => $pembelian)
                            <tr>
                                <td class="text-center">{{ ($pembelians->currentPage() - 1) * $pembelians->perPage() + $index + 1 }}</td>
                                <td>{{ $pembelian->customer_name }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d/m/Y') }}</td>
                                <td class="text-right">Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                                <td>{{ $pembelian->dibuat_oleh }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" onclick="showDetail({{ $pembelian->id }})" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('pembelian.export_pdf', $pembelian->id) }}" class="btn btn-danger btn-sm" title="Download PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Belum ada data pembelian.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $pembelians->firstItem() ?? 0 }} sampai {{ $pembelians->lastItem() ?? 0 }} dari {{ $pembelians->total() }} data
                </div>
                <div>
                    {{ $pembelians->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <div class="modal-body">
        <!-- Content will be loaded here -->
    </div>
</div>

@push('scripts')
<script>
function showDetail(id) {
    $('#detailModal').modal('show');
    fetch(`/pembelian/detail/${id}`)
        .then(response => response.text())
        .then(html => {
            $('#detailModal .modal-body').html(html);
        })
        .catch(error => {
            console.error('Error:', error);
            $('#detailModal .modal-body').html('<div class="alert alert-danger">Error loading detail</div>');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const perPageSelect = document.getElementById('per-page');
    let typingTimer;

    function updatePage() {
        const search = searchInput.value;
        const perPage = perPageSelect.value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', search);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    }

    searchInput.addEventListener('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(updatePage, 500);
    });

    perPageSelect.addEventListener('change', updatePage);
});
</script>
@endpush
@endsection