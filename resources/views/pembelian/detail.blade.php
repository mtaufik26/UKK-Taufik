<div class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.6)">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-receipt mr-2"></i>Detail Penjualan #{{ $pembelian->id }}
                </h5>
                <a href="{{ route('pembelian.index') }}" class="close text-white">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <div class="modal-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 pr-md-2">
                        <div class="card h-100 border-0 shadow-sm rounded-lg">
                            <div class="card-body p-4">
                                <h6 class="card-title text-primary mb-4 d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-lg mr-2"></i>
                                    <span>Informasi Pelanggan</span>
                                </h6>
                                
                                @php
                                    $member = \App\Models\Member::where('name', $pembelian->customer_name)->first();
                                @endphp
                                
                                @if($member)
                                    <div class="mb-3">
                                        <span class="badge badge-success px-3 py-2">
                                            <i class="fas fa-star mr-1"></i> Member
                                        </span>
                                    </div>
                                    <div class="info-group mb-2">
                                        <label class="text-muted small mb-1">Nama Pelanggan</label>
                                        <p class="font-weight-bold mb-2">{{ $pembelian->customer_name }}</p>
                                    </div>
                                    <div class="info-group mb-2">
                                        <label class="text-muted small mb-1">Nomor Telepon</label>
                                        <p class="font-weight-bold mb-2">{{ $member->phone_number }}</p>
                                    </div>
                                    <div class="info-group mb-2">
                                        <label class="text-muted small mb-1">Total Poin</label>
                                        <p class="mb-2">
                                            <span class="badge badge-info px-3 py-2">
                                                <i class="fas fa-award mr-1"></i> {{ $member->points }} Poin
                                            </span>
                                        </p>
                                    </div>
                                    <div class="info-group">
                                        <label class="text-muted small mb-1">Member Sejak</label>
                                        <p class="text-primary mb-0">
                                            {{ \Carbon\Carbon::parse($member->member_since)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <span class="badge badge-secondary px-3 py-2">
                                            <i class="fas fa-user mr-1"></i> Non-Member
                                        </span>
                                    </div>
                                    <div class="info-group mb-2">
                                        <label class="text-muted small mb-1">Nama Pelanggan</label>
                                        <p class="font-weight-bold mb-0">{{ $pembelian->customer_name ?? '-' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 pl-md-2">
                        <div class="card h-100 border-0 shadow-sm rounded-lg">
                            <div class="card-body p-4">
                                <h6 class="card-title text-primary mb-4 d-flex align-items-center">
                                    <i class="fas fa-info-circle fa-lg mr-2"></i>
                                    <span>Informasi Transaksi</span>
                                </h6>
                                
                                <div class="info-group mb-3">
                                    <label class="text-muted small mb-1">Tanggal Transaksi</label>
                                    <p class="font-weight-bold mb-2">
                                        {{ $pembelian->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                
                                <div class="info-group mb-3">
                                    <label class="text-muted small mb-1">Waktu Transaksi</label>
                                    <p class="font-weight-bold mb-2">
                                        {{ $pembelian->created_at->format('H:i') }} WIB
                                    </p>
                                </div>
                                
                                <div class="info-group">
                                    <label class="text-muted small mb-1">Kasir</label>
                                    <p class="font-weight-bold mb-0">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        {{ $pembelian->dibuat_oleh }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-body p-0">
                        <h6 class="card-title bg-light p-4 mb-0 text-primary d-flex align-items-center">
                            <i class="fas fa-shopping-basket fa-lg mr-2"></i>
                            <span>Detail Pembelian</span>
                        </h6>
                        
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Produk</th>
                                        <th class="py-3 px-4 text-center" width="100">Qty</th>
                                        <th class="py-3 px-4 text-right" width="200">Harga Satuan</th>
                                        <th class="py-3 px-4 text-right" width="200">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembelian->details as $detail)
                                    <tr>
                                        <td class="py-3 px-4">{{ $detail->product->nama_produk }}</td>
                                        <td class="py-3 px-4 text-center">{{ $detail->quantity }}</td>
                                        <td class="py-3 px-4 text-right">Rp {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4 text-right font-weight-bold">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <td colspan="3" class="py-3 px-4 text-right font-weight-bold">Total Pembelian</td>
                                        <td class="py-3 px-4 text-right">
                                            <span class="h5 font-weight-bold text-primary mb-0">
                                                Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light py-3">
                <a href="{{ route('pembelian.index') }}" class="btn btn-primary px-4">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .modal-content {
        border-radius: 0.5rem;
    }
    .card {
        transition: all 0.2s ease;
    }
    .badge {
        font-size: 0.9rem;
    }
    .info-group label {
        color: #858796;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .modal-backdrop {
        opacity: 0.6;
    }
</style>
@endpush