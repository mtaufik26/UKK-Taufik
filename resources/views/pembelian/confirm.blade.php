@extends('layouts.app')
@section('title', 'Konfirmasi Penjualan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konfirmasi Penjualan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0">
                <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}">Penjualan</a></li>
                <li class="breadcrumb-item active">Konfirmasi</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk yang dipilih</h6>
                </div>
                <div class="card-body">
                    @foreach($selectedProducts as $product)
                    <div class="card mb-2 border-0 bg-light">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0 font-weight-bold">{{ $product['name'] }}</p>
                                    <small class="text-muted">Rp. {{ number_format($product['price'], 0, ',', '.') }} × {{ $product['quantity'] }}</small>
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-bold">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">Total</span>
                                <span class="font-weight-bold text-primary">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            @if($points_earned > 0)
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="font-weight-bold text-success">Poin yang didapatkan</span>
                                <span class="font-weight-bold text-success">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ number_format($points_earned, 0, ',', '.') }} Poin
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Member Status <span class="text-muted small">Dapat juga membuat member</span></label>
                        <select id="memberType" name="member_type" class="form-control">
                            <option value="non_member">Bukan Member</option>
                            <option value="member">Member</option>
                        </select>
                    </div>

                    <div id="memberFields" class="mb-3 d-none">
                        <label class="font-weight-bold">No Telepon</label>
                        <input type="text" name="phone_number" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="font-weight-bold">Total Bayar</label>
                        <input type="text" name="total_bayar" id="total_bayar" class="form-control" 
                               placeholder="Rp. " oninput="validatePayment(this.value)">
                        <div id="payment_error" class="invalid-feedback d-none">Jumlah bayar kurang.</div>
                    </div>

                    <form action="{{ route('pembelian.member-info') }}" method="POST" id="payment_form">
                        @csrf
                        <input type="hidden" name="products" value="{{ json_encode($selectedProducts) }}">
                        <input type="hidden" name="total_amount" value="{{ $total }}">
                        <input type="hidden" name="member_type" id="hidden_member_type">
                        <input type="hidden" name="phone_number" id="hidden_phone_number">
                        <input type="hidden" name="total_bayar" id="hidden_total_bayar">
                        <div class="mt-4">
                            <button type="submit" id="submit_btn" class="btn btn-primary w-100">
                                Selanjutnya
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .card {
        border-radius: 0.35rem;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
    // Update form action based on member type
    document.addEventListener('DOMContentLoaded', function() {
        const memberType = document.getElementById('memberType');
        updateFormAction(memberType.value);
    });

    document.getElementById('memberType').addEventListener('change', function() {
        const memberFields = document.getElementById('memberFields');
        memberFields.classList.toggle('d-none', this.value === 'non_member');
        updateFormAction(this.value);
    });

    function updateFormAction(memberType) {
        const paymentForm = document.getElementById('payment_form');
        if (memberType === 'non_member') {
            paymentForm.action = "{{ route('pembelian.pembayaran') }}";
        } else {
            paymentForm.action = "{{ route('pembelian.member-info') }}";
        }
    }

    function formatRupiah(angka) {
        const number_string = angka.toString().replace(/[^,\d]/g, '');
        const split = number_string.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return 'Rp. ' + rupiah;
    }

    function validatePayment(value) {
        const cleanValue = parseInt(value.replace(/[^\d]/g, '')) || 0;
        const totalAmount = {{ $total }};
        const errorElement = document.getElementById('payment_error');
        const submitButton = document.getElementById('submit_btn');
        const inputElement = document.getElementById('total_bayar');
        
        inputElement.value = formatRupiah(value);
        document.getElementById('hidden_total_bayar').value = cleanValue;

        if (cleanValue < totalAmount) {
            errorElement.classList.remove('d-none');
            inputElement.classList.add('is-invalid');
            submitButton.disabled = true;
        } else {
            errorElement.classList.add('d-none');
            inputElement.classList.remove('is-invalid');
            submitButton.disabled = false;
        }
    }

    document.getElementById('payment_form').addEventListener('submit', function(e) {
        e.preventDefault();
        const memberType = document.getElementById('memberType').value;
        const phoneNumber = document.querySelector('input[name="phone_number"]')?.value;
        const totalBayar = document.getElementById('total_bayar').value;

        document.getElementById('hidden_member_type').value = memberType;
        document.getElementById('hidden_phone_number').value = phoneNumber || '';
        document.getElementById('hidden_total_bayar').value = totalBayar.replace(/[^\d]/g, '');

        if (memberType === 'member' && !phoneNumber) {
            alert('Mohon isi nomor telepon untuk member');
            return;
        }

        if (!totalBayar) {
            alert('Mohon isi total bayar');
            return;
        }

        this.submit();
    });
</script>
@endpush
@endsection