@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Order Details #{{ $order->id }}</h2>
        <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary">
            Back to Orders
        </a>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Items</h5>
                    @foreach($order->details as $detail)
                        <div class="d-flex mb-3 align-items-center">
                            <img src="{{ asset($detail->product->url_image) }}"
                                 alt="{{ $detail->product->name }}"
                                 class="order-item-image me-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $detail->product->name }}</h6>
                                <p class="mb-0 text-muted">
                                    {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
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
                    <div class="mb-3">
                        <p class="mb-1"><strong>Order Date:</strong></p>
                        <p>{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Status:</strong></p>
                        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'danger') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Total Items:</strong></p>
                        <p>{{ $order->details->sum('quantity') }} items</p>
                    </div>
                    <div class="mb-4">
                        <p class="mb-1"><strong>Total Price:</strong></p>
                        <h4>Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                    </div>

                    @if($order->status === 'pending')
                        <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>
@endsection
