    @extends('layouts.app')

    @section('title', 'Konfirmasi Penjualan')

    @section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konfirmasi Penjualan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form id="payment_form" method="POST" action="">
                    <input type="hidden" name="" value="">
                <input type="hidden" name="total_amount" value="">
                <input type="hidden" id="hidden_member_type" name="member_type" value="non_member">
                <input type="hidden" id="hidden_phone_number" name="phone_number" value="">
                <input type="hidden" id="hidden_total_bayar" name="payment_amount" value="">
                
                <div class="row">
                    <!-- Product Information -->
                    <div class="col-md-6">
                        <h5 class="font-weight-bold mb-3">Produk yang dipilih</h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="font-weight-bold mb-0"></p>
                                    <small class="text-muted">
                                        Rp. 
                                    </small>
                                </div>
                                <div class="text-right">
                                    <p class="mb-0">Rp. </p>
                                </div>
                            </div>
                        @endforeach

                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">Rp.</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Member Status</label>
                            <select id="memberType" class="form-control">
                                <option value="non_member">Non Member</option>
                                <option value="member">Member</option>
                            </select>
                        </div>

                        <div id="memberFields" class="form-group d-none">
                            <label>No Telepon</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Total Bayar</label>
                            <input type="text" name="total_bayar" id="total_bayar" 
                                   class="form-control" placeholder="Rp. "
                                   oninput="">
                            <small id="payment_error" class="text-danger d-none">
                                Jumlah bayar kurang dari total pembelian
                            </small>
                        </div>

                        <button type="submit" id="submit_btn" class="btn btn-primary btn-block">
                            <i class="fas fa-money-bill-wave mr-1"></i> Proses Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</script>
@endpush
@endsection
