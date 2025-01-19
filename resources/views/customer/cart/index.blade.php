@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Shopping Cart</h2>

    {{-- Alert Messages --}}
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Cart Content --}}
    @if($cart->details->count() > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cart->details as $item)
                            <div class="cart-item d-flex align-items-center mb-3" id="cart-item-{{ $item->id }}">
                                <img src="{{ asset($item->product->url_image) }}" alt="{{ $item->product->name }}"
                                     class="cart-item-image">
                                <div class="cart-item-details flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    <div class="d-flex align-items-center">
                                        <input type="number"
                                               class="form-control quantity-input me-2"
                                               value="{{ $item->quantity }}"
                                               min="1"
                                               id="quantity-{{ $item->id }}">

                                        {{-- Tombol Update dan Delete --}}
                                        <div class="btn-group ms-2">
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm"
                                                    onclick="updateCart({{ $item->id }})">
                                                <i class="fas fa-sync-alt"></i> Update
                                            </button>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm ms-1"
                                                    onclick="removeFromCart({{ $item->id }})">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item-price text-end">
                                    <h6>Subtotal:</h6>
                                    <p class="fw-bold" id="subtotal-{{ $item->id }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Cart Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Items:</span>
                            <span class="total-items">{{ $cart->details->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Price:</span>
                            <span class="fw-bold" id="cart-total">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4>Your cart is empty</h4>
            <p class="text-muted">Browse our products and add some items to your cart!</p>
            <a href="{{ route('customer.products') }}" class="btn btn-primary">
                Browse Products
            </a>
        </div>
    @endif
</div>

<style>
    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    .quantity-input {
        width: 80px;
    }

    .cart-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .cart-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
function updateCart(id) {
    var quantity = $('#quantity-' + id).val();

    $.ajax({
        url: '/cart/update/' + id,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'PATCH',
            quantity: quantity
        },
        success: function(response) {
            if (response.success) {
                // Update subtotal
                $('#subtotal-' + id).text('Rp ' + response.subtotal);
                // Update total cart
                $('#cart-total').text('Rp ' + response.total);
                // Update total items
                $('.total-items').text(response.total_items);
                // Tampilkan pesan sukses
                alert('Cart updated successfully!');
            } else {
                alert(response.message || 'Failed to update cart');
            }
        },
        error: function(xhr, status, error) {
            alert('Failed to update cart. Please try again.');
            console.error('Error details:', xhr.responseText);
        }
    });
}

function removeFromCart(id) {
    if (confirm('Are you sure you want to remove this item?')) {
        $.ajax({
            url: '/cart/' + id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                if (response.success) {
                    // Hapus element cart item dengan animasi
                    var $cartItem = $('#cart-item-' + id);
                    $cartItem.fadeOut(300, function() {
                        $(this).remove();

                        // Update total cart
                        $('#cart-total').text('Rp ' + response.total);
                        $('.total-items').text(response.total_items);

                        // Jika cart kosong, reload halaman
                        if (response.total_items == 0) {
                            window.location.reload();
                        }
                    });

                    alert('Item removed from cart!');
                } else {
                    alert(response.message || 'Failed to remove item');
                }
            },
            error: function(xhr, status, error) {
                alert('Failed to remove item. Please try again.');
                console.error('Error details:', xhr.responseText);
            }
        });
    }
}
</script>

@endsection
