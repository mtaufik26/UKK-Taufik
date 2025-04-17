@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Penjualan</h1>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        @if($product->img)
                        <img src="{{ asset('storage/'.$product->img) }}" 
                             alt="{{ $product->nama_produk }}" 
                             class="img-fluid mb-3 rounded-lg"
                             style="height: 150px; width: 150px; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/no-image.png') }}"
                             alt="No Image"
                             class="img-fluid mb-3 rounded-lg"
                             style="height: 150px; width: 150px; object-fit: cover;">
                    @endif

                        <h4 class="card-title">{{ $product->nama_produk }}</h4>
                        <p class="text-muted">Stok {{ $product->stok }}</p>
                        <h5 class="text-primary font-weight-bold">
                            Rp. {{ number_format($product->harga, 0, ',', '.') }}
                        </h5>

                        <div class="d-flex justify-content-center align-items-center my-3">
                            <div class="input-group" style="width: 200px;">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-primary btn-minus" 
                                        data-id="{{ $product->id }}"
                                        data-price="{{ $product->harga }}"
                                        {{ $product->stok == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>

                                <input type="number" id="qty-{{ $product->id }}" 
                                    class="form-control text-center" 
                                    value="0" 
                                    min="0" 
                                    max="{{ $product->stok }}"
                                    {{ $product->stok == 0 ? 'disabled' : '' }}
                                    readonly>

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-primary btn-plus" 
                                        data-id="{{ $product->id }}" 
                                        data-price="{{ $product->harga }}"
                                        data-stock="{{ $product->stok }}"
                                        {{ $product->stok == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-muted mb-3">
                            Sub Total <span id="subtotal-{{ $product->id }}" class="font-weight-bold">Rp. 0</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="fixed-bottom bg-white py-3 px-4 shadow-sm" style="border-top: 1px solid #e3e6f0; margin-left: 250px; width: calc(100% - 250px);">
        <div class="container-fluid">
            <form id="salesForm" method="POST" action="{{ route('pembelian.confirm') }}">
                @csrf
                <div id="selected-products"></div>
                <button type="submit" class="btn btn-primary px-5 float-right">Selanjutnya <i class="fas fa-arrow-right ml-2"></i></button>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const formatCurrency = (number) => {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };

    const updateSubtotal = (id, quantity, price) => {
        const qtyInput = document.getElementById(`qty-${id}`);
        const plusBtn = document.querySelector(`.btn-plus[data-id="${id}"]`);
        const minusBtn = document.querySelector(`.btn-minus[data-id="${id}"]`);
        const stock = parseInt(plusBtn.dataset.stock);

        qtyInput.value = quantity;

        const subtotal = price * quantity;
        const subtotalEl = document.getElementById(`subtotal-${id}`);
        subtotalEl.textContent = `Rp. ${formatCurrency(subtotal)}`;

        if (quantity > 0) {
            let formInput = document.querySelector(`input[name="items[${id}][quantity]"]`);
            if (!formInput) {
                formInput = document.createElement('input');
                formInput.type = 'hidden';
                formInput.name = `items[${id}][quantity]`;
                document.getElementById('selected-products').appendChild(formInput);
            }
            formInput.value = quantity;
        } else {
            const formInput = document.querySelector(`input[name="items[${id}][quantity]"]`);
            if (formInput) formInput.remove();
        }

        plusBtn.disabled = quantity >= stock;
        minusBtn.disabled = quantity <= 0;
    };

    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;
            
            const id = btn.dataset.id;
            const stock = parseInt(btn.dataset.stock);
            const price = parseInt(btn.dataset.price);
            const currentQty = parseInt(document.getElementById(`qty-${id}`).value) || 0;

            if (currentQty < stock) {
                updateSubtotal(id, currentQty + 1, price);
            }
        });
    });

    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;
            
            const id = btn.dataset.id;
            const price = parseInt(btn.dataset.price);
            const currentQty = parseInt(document.getElementById(`qty-${id}`).value) || 0;

            if (currentQty > 0) {
                updateSubtotal(id, currentQty - 1, price);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('salesForm').addEventListener('submit', function(e) {
        const selectedProducts = document.querySelectorAll('input[name^="items"]');
        if (selectedProducts.length === 0) {
            e.preventDefault();
            alert('Silahkan pilih minimal satu produk');
            return false;
        }
        
        this.method = 'POST';
        this.action = "{{ route('pembelian.confirm') }}";
        return true;
    });
});
});
</script>
@endpush
@endsection