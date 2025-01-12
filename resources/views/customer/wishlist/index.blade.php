@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="section-title mb-4">My Wishlist</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($wishlists->count() > 0)
        <div class="row">
            @foreach($wishlists as $wishlist)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset($wishlist->product->url_image) }}"
                             class="card-img-top product-image"
                             alt="{{ $wishlist->product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $wishlist->product->name }}</h5>
                            <p class="card-text text-success fw-bold">
                                Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                            </p>

                            <div class="d-flex gap-2">
                                <form action="{{ route('customer.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        Add to Cart
                                    </button>
                                </form>

                                <form action="{{ route('customer.wishlist.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
                                    <button type="submit" class="btn btn-outline-danger">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <h4>Your wishlist is empty</h4>
            <p class="text-muted">Browse our products and add some items to your wishlist!</p>
            <a href="{{ route('customer.products') }}" class="btn btn-primary">
                Browse Products
            </a>
        </div>
    @endif
</div>

<style>
.product-image {
    height: 200px;
    object-fit: cover;
}
</style>
@endsection
