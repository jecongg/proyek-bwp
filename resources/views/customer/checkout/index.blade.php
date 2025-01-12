@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">Checkout</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Shipping Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->phone }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Items</h5>
                        @foreach($cart->details as $detail)
                            <div class="d-flex mb-3 align-items-center">
                                <img src="{{ asset($detail->product->url_image) }}"
                                     alt="{{ $detail->product->name }}"
                                     class="checkout-item-image me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $detail->product->name }}</h6>
                                    <p class="mb-0 text-muted">
                                        {{ $detail->quantity }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-bold">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Items</span>
                            <span>{{ $cart->details->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Total Price</span>
                            <span class="fw-bold">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .checkout-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
@endsection
