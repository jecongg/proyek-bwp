@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="section-title mb-4">Your Orders</h2>

    @if($orders->isNotEmpty())
        <div class="row">
            @foreach($orders as $order)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order ID: {{ $order->id }}</h5>
                            <p class="card-text">Date: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>

                            <div class="order-items">
                                @foreach($order->details as $detail)
                                    <div class="d-flex align-items-center mb-2">
                                        @if($detail->product && !$detail->product->trashed())
                                            <img src="{{ asset($detail->product->url_image) }}"
                                                 alt="{{ $detail->product->name }}"
                                                 class="img-fluid order-item-image me-3">
                                            <div>
                                                <h5 class="mb-1">{{ $detail->product->name }}</h5>
                                                <p class="mb-0">Quantity: {{ $detail->quantity }}</p>
                                                <p class="mb-0">Price: Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                                <p class="mb-0">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        @else
                                            <div>
                                                <h5 class="mb-1 text-muted">Product Deleted</h5>
                                                <p class="mb-0">Quantity: {{ $detail->quantity }}</p>
                                                <p class="mb-0">Price: Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                                <p class="mb-0">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-end mt-3">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info" role="alert">
            No orders found.
        </div>
    @endif
</div>

<style>
    .order-item-image {
        width: 150px;
        height: 150px;
    }
    .card-title {
        font-size: 2rem;
    }
    .card-body p, .card-body h3, .card-body h4, .card-body h5 {
        font-size: 1.5rem;
    }
</style>
@endsection
