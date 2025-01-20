@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
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
                                    <h3 class="card-title mb-1">Order #{{ $order->id }}</h3>
                                    <p class="text-muted mb-0">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <h4 class="mb-1">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'cancelled' ? 'danger' : ($order->status === 'processed' ? 'info' : 'success')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="order-items">
                                @foreach($order->details as $detail)
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset($detail->product->url_image) }}"
                                             alt="{{ $detail->product->name }}"
                                             class="img-fluid order-item-image me-3">
                                        <div>
                                            <h5 class="mb-1">{{ $detail->product->name }}</h5>
                                            <p class="mb-0">Quantity: {{ $detail->quantity }}</p>
                                            <p class="mb-0">Price: Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                            <p class="mb-0">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                        </div>
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
