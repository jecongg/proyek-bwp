@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">My Orders</h2>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="row">
            @foreach($orders as $order)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="card-title mb-1">Order #{{ $order->id }}</h5>
                                    <p class="text-muted mb-0">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-1">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h6>
                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-items">
                                @foreach($order->details as $detail)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset($detail->product->url_image) }}"
                                             alt="{{ $detail->product->name }}"
                                             class="order-item-image me-3">
                                        <div>
                                            <h6 class="mb-0">{{ $detail->product->name }}</h6>
                                            <small class="text-muted">
                                                {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('customer.orders.show', $order->id) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    View Details
                                </a>
                                @if($order->status === 'pending')
                                    <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <h4>No orders found</h4>
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="{{ route('customer.products') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>

<style>
    .order-item-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>
@endsection
