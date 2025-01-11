@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Your Wishlist</h1>

    <div class="row">
        @forelse($wishlists as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset($product->url_image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <form action="{{ route('customer.wishlist.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>You have no items in your wishlist.</p>
        @endforelse
    </div>
</div>
@endsection
