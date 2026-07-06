@extends('layouts.master')
@section('content')
<div class="cart-page">
    <div class="container-fluid px-3 px-md-4 py-3 py-md-4">
        {{-- Page header (centered) --}}
        <div class="cart-header mb-4 text-center">
            <h1 class="cart-title">Your Shopping Cart</h1>
            <p class="cart-subtitle text-muted mb-0">Review your items and proceed to checkout</p>
        </div>

        @if(count($cartData) > 0)
        <div class="row cart-two-cards g-4">
            {{-- Card 1: Cart items --}}
            <div class="col-12 col-md-6 d-flex">
                <div class="cart-card cart-items-card flex-grow-1 d-flex flex-column">
                    <h2 class="section-label">Cart Items</h2>
                    <div class="cart-items-list flex-grow-1">
                        @foreach ($cartData as $item)
                        <article class="cart-item-card cart-item" data-product-id="{{ $item->product_id }}">
                            <div class="cart-item-top">
                                <div class="cart-item-image">
                                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                                </div>
                                <div class="cart-item-details">
                                    <h3 class="cart-item-name">{{ $item->name }}</h3>
                                    <p class="cart-item-price price">{{ number_format($item->price, 0) }} MMK</p>
                                    <div class="cart-item-qty">
                                        <div class="qty-controls">
                                            <button type="button" class="qty-btn btn-minus" aria-label="Decrease quantity"><i class="fa fa-minus"></i></button>
                                            <input type="text" class="quantity-input qty" value="1" readonly aria-label="Quantity">
                                            <button type="button" class="qty-btn btn-plus" aria-label="Increase quantity"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-item-bottom">
                                <div class="cart-item-total-wrap">
                                    <span class="cart-item-total-label">Total</span>
                                    <span class="total cart-item-total-value"></span>
                                </div>
                                <a href="{{ route('cartDelete', $item->cart_id) }}" class="btn-remove" title="Remove item" aria-label="Remove {{ $item->name }}">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    <div class="cart-back-wrap mt-3 pt-3 border-top">
                        <a href="{{ route('saleProductView') }}" class="btn btn-outline-primary btn-back">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card 2: Order summary (equal width & height) --}}
            <div class="col-12 col-md-6 d-flex">
                <div class="cart-card cart-summary-card flex-grow-1 d-flex flex-column">
                    <h2 class="summary-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="cart-subtotal" class="summary-value"></span>
                    </div>
                    <div class="summary-description flex-grow-1">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Enter description (e.g. delivery notes)..." required>{{ old('description') }}</textarea>
                        <div class="invalid-feedback text-danger description-error">Description is required</div>
                    </div>
                    <button type="button" id="checkout-btn" class="btn btn-primary btn-checkout w-100 mt-3">
                        Sell
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="cart-empty">
            <div class="cart-empty-icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <p class="mb-2">Your cart is empty</p>
            <a href="{{ route('saleProductView') }}" class="btn btn-primary">Continue shopping</a>
        </div>
        @endif
    </div>
</div>

<style>
/* Cart page – two equal cards, centered header */
.cart-page { min-height: 60vh; }
.cart-header { border-bottom: 1px solid #e9ecef; padding-bottom: 0.75rem; }
.cart-title { font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 0.25rem; }
.cart-subtitle { font-size: 0.9rem; }

/* Two cards in one row, equal width and height */
.cart-two-cards { align-items: stretch; }
.cart-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    min-height: 380px;
}
.cart-items-card .section-label,
.cart-summary-card .summary-title { font-size: 1.1rem; font-weight: 700; color: #4a5568; margin-bottom: 1rem; }
.cart-items-list { min-height: 0; overflow-y: auto; }

/* Cart item row – no inner box, clean list with dividers */
.cart-item-card {
    padding: 1rem 0;
    border-bottom: 1px solid #eee;
    margin: 0;
}
.cart-item-card:last-child { border-bottom: none; }
.cart-item-top {
    display: flex;
    gap: 1rem;
    align-items: center;
}
.cart-item-image {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    overflow: hidden;
    background: #f8f9fa;
    flex-shrink: 0;
}
.cart-item-image img { width: 100%; height: 100%; object-fit: cover; }
.cart-item-details { min-width: 0; flex-grow: 1; }
.cart-item-name { font-size: 1rem; font-weight: 600; color: #2d3748; margin-bottom: 0.25rem; line-height: 1.35; }
.cart-item-price { font-size: 0.95rem; font-weight: 600; color: var(--amara-primary, #0B5EA8); margin-bottom: 0.5rem; }
.qty-controls {
    display: inline-flex;
    align-items: center;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
}
.qty-btn {
    width: 34px;
    height: 34px;
    border: none;
    background: #fff;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s, color 0.15s;
}
.qty-btn:hover { background: #f1f5f9; color: #0B5EA8; }
.quantity-input {
    width: 42px;
    height: 34px;
    border: none;
    border-left: 1px solid #e2e8f0;
    border-right: 1px solid #e2e8f0;
    text-align: center;
    font-weight: 600;
    font-size: 0.9rem;
}
.cart-item-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.6rem;
    padding-top: 0.6rem;
    border-top: 1px solid #f1f5f9;
}
.cart-item-total-wrap { display: flex; align-items: baseline; gap: 0.4rem; }
.cart-item-total-label { font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.03em; }
.cart-item-total-value { font-weight: 700; color: #2d3748; font-size: 1rem; }
.btn-remove {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b91c1c;
    background: transparent;
    transition: background 0.15s, color 0.15s;
}
.btn-remove:hover { background: #fef2f2; color: #991b1b; text-decoration: none; }

.cart-back-wrap { border-color: #e9ecef !important; }
.btn-back { font-weight: 500; }

/* Order summary card (same height as cart items card) */
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1rem;
}
.summary-value { font-weight: 700; color: #2d3748; }
.summary-description label { font-weight: 500; color: #4a5568; margin-bottom: 0.35rem; display: block; }
.summary-description .form-control {
    border-radius: 8px;
    border-color: #e2e8f0;
}
.summary-description .form-control:focus {
    border-color: var(--amara-primary, #0B5EA8);
    box-shadow: 0 0 0 3px rgba(11, 94, 168, 0.15);
}
.btn-checkout { border-radius: 10px; padding: 0.75rem 1rem; font-weight: 600; }

/* Empty state */
.cart-empty {
    text-align: center;
    padding: 3rem 1.5rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px dashed #cbd5e0;
}
.cart-empty-icon { font-size: 3rem; color: #cbd5e0; margin-bottom: 1rem; }
.cart-empty p { color: #718096; }

@media (max-width: 767px) {
    .cart-two-cards .col-md-6 { max-width: 100%; }
    .cart-card { min-height: 320px; }
    .cart-item-image { width: 80px; height: 80px; }
    .cart-item-card { padding: 0.85rem 0; }
    .qty-btn { width: 30px; height: 30px; }
    .quantity-input { width: 36px; height: 30px; }
}
</style>
@endsection

@section('script-js')
<script>
$(document).ready(function() {
    function extractPrice(priceText) {
        return parseFloat(priceText.replace(/[^\d.]/g, ''));
    }

    function updateTotal(element) {
        var $cartItem = $(element).closest('.cart-item');
        var price = extractPrice($cartItem.find('.price').text());
        var qty = parseInt($cartItem.find('.quantity-input').val()) || 1;
        $cartItem.find('.total').text((price * qty).toLocaleString() + ' MMK');
    }

    function updateSubtotal() {
        var subtotal = 0;
        $('.cart-item').each(function() {
            var price = extractPrice($(this).find('.price').text());
            var qty = parseInt($(this).find('.quantity-input').val()) || 1;
            subtotal += price * qty;
        });
        $('#cart-subtotal').text(subtotal.toLocaleString() + ' MMK');
    }

    $('.cart-item').each(function() {
        var price = extractPrice($(this).find('.price').text());
        var qty = parseInt($(this).find('.quantity-input').val()) || 1;
        $(this).find('.total').text((price * qty).toLocaleString() + ' mmk');
    });
    updateSubtotal();

    $('.qty-controls').on('click', '.btn-plus', function() {
        var $input = $(this).siblings('input');
        $input.val(parseInt($input.val()) + 1);
        updateTotal(this);
        updateSubtotal();
    });

    $('.qty-controls').on('click', '.btn-minus', function() {
        var $input = $(this).siblings('input');
        var val = parseInt($input.val()) || 1;
        if (val > 1) {
            $input.val(val - 1);
            updateTotal(this);
            updateSubtotal();
        }
    });

    function collectCartData() {
        var cartData = [];
        $('.cart-item').each(function() {
            var $item = $(this);
            cartData.push({
                user_id: {{ Auth::user()->id }},
                product_id: $item.data('product-id'),
                name: $item.find('.cart-item-name').text().trim(),
                price: extractPrice($item.find('.price').text()),
                description: $('textarea[name="description"]').val(),
                quantity: parseInt($item.find('.quantity-input').val()) || 1,
                total: 0
            });
        });
        cartData.forEach(function(item) { item.total = item.price * item.quantity; });
        return cartData;
    }

    $('#description').on('input', function() {
        if ($(this).val().trim() !== '') {
            $(this).removeClass('is-invalid');
            $('.description-error').hide();
        }
    });

    $('#checkout-btn').on('click', function(e) {
        e.preventDefault();
        var description = $('#description').val().trim();
        if (!description) {
            $('#description').addClass('is-invalid');
            $('.description-error').show();
            return;
        }
        var cartData = collectCartData();
        $.ajax({
            url: '{{ route('api.sale.store') }}',
            type: 'POST',
            data: JSON.stringify({ cart: cartData }),
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Checkout Successful!',
                    text: 'Your order has been placed.',
                    confirmButtonText: 'OK'
                }).then(function() { window.location.reload(); });
            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                Swal.fire('Error', (res && res.message) ? res.message : 'Something went wrong!', 'error');
            }
        });
    });
});
</script>
@endsection
