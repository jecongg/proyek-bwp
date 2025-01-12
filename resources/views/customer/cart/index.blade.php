@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">Shopping Cart</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($cart->details && $cart->details->count() > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cart->details as $item)
                            <div class="cart-item d-flex align-items-center mb-3">
                                <img src="{{ asset($item->product->url_image) }}" alt="{{ $item->product->name }}"
                                     class="cart-item-image">
                                <div class="cart-item-details flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('cart.update-quantity', $item) }}" method="POST"
                                              class="d-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                   min="1" class="form-control quantity-input me-2">
                                            <button type="submit" class="btn btn-sm btn-outline-primary me-2">Update</button>
                                        </form>
                                        <form action="{{ route('cart.remove-item', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="cart-item-price text-end">
                                    <h6>Subtotal:</h6>
                                    <p class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
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
                            <span>{{ $cart->details->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Price:</span>
                            <span class="fw-bold">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4>Your cart is empty</h4>
            <p class="text-muted">Add some products to your cart and they will appear here</p>
            <a href="{{ route('customer.products') }}" class="btn btn-primary">Continue Shopping</a>
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
@endsection
