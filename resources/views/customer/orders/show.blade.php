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
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Order Items</h2>
                    @foreach($order->details as $detail)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <img src="{{ asset($detail->product->url_image) }}" alt="{{ $detail->product->name }}" class="img-fluid order-item-image">
                            </div>
                            <div class="col-md-9">
                                <h3>{{ $detail->product->name }}</h3>
                                <p class="mb-1">Quantity: {{ $detail->quantity }}</p>
                                <p class="mb-1">Price: Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                <p class="mb-1">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Order Summary</h2>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Order Date:</strong></p>
                        <p>{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Status:</strong></p>
                        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : ($order->status === 'processed' ? 'info' : ($order->status === 'cancelled' ? 'danger' : 'secondary'))) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>Total Items:</strong></p>
                        <p>{{ $order->details->sum('quantity') }} items</p>
                    </div>
                    <div class="mb-4">
                        <p class="mb-1"><strong>Total Price:</strong></p>
                        <h2>Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
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
        width: 200px;
        height: 200px;
    }
    .card-title {
        font-size: 2.5rem;
    }
    .card-body p, .card-body h2, .card-body h3 {
        font-size: 1.75rem;
    }
</style>
@endsection
