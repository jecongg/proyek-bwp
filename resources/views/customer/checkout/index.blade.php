@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">Checkout</h2>

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
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
                                    <h3 class="mb-1">{{ $detail->product->name }}</h3>
                                    <p class="mb-0 text-muted" style="font-size: 1.2rem">
                                        {{ $detail->quantity }} x Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0 fw-bold" style="font-size: 1.6rem">
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
                        <div class="d-flex justify-content-between mb-3" style="font-size: 1.2rem">
                            <span>Total Items</span>
                            <span>{{ $cart->details->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4" style="font-size: 1.2rem">
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
    .section-title {
        font-size: 2.5rem;
    }
    .form-label {
        font-size: 1.5rem;
    }
    .form-control {
        font-size: 1.25rem;
    }
    .card-title {
        font-size: 1.75rem;
    }
    .btn {
        font-size: 1.25rem;
    }
    .checkout-item-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

</style>
@endsection
