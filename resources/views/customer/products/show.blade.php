@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Alert Messages --}}
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

    <div class="row">
        <!-- Image Section -->
        <div class="col-md-6">
            <div class="product-image-wrapper text-center mb-4">
                <img src="{{ asset($product->url_image) }}" class="img-fluid rounded shadow-sm" alt="{{ $product->name }}">
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-md-6">
            <div class="product-details">
                <h1 class="product-title mb-4">{{ $product->name }}</h1>
                <p class="product-category text-muted mb-3">
                    <span class="text-dark fw-bold">Category:</span> {{ $product->category ? $product->category->name : 'No category' }}
                </p>
                <p class="product-description text-secondary mb-4">
                    <span class="text-dark fw-bold">Description:</span> {{ $product->description }}
                </p>
                <h4 class="product-price mb-4">Price: <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></h4>

                <!-- Add to Cart Form with Quantity -->
                <form action="{{ route('customer.cart.add') }}" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="quantity-wrapper">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                   value="1" min="1" style="width: 100px;">
                        </div>
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                    </div>
                </form>

                <!-- Wishlist button -->
                @if($inWishlist)
                    <form action="{{ route('customer.wishlist.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-heart-broken me-2"></i>Remove from Wishlist
                        </button>
                    </form>
                @else
                    <form action="{{ route('customer.wishlist.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-heart me-2"></i>Add to Wishlist
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .product-image-wrapper {
        border: 1px solid #eaeaea;
        padding: 15px;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
    }

    .product-category {
        font-size: 1.25rem;
        color: #555;
    }

    .product-description {
        font-size: 1.25rem;
        line-height: 1.8;
        color: #555;
    }

    .product-price {
        font-size: 1.75rem;
        font-weight: bold;
        color: #28a745;
    }

    .btn {
        padding: 10px 20px;
        font-size: 1.1rem;
        border-radius: 50px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>
@endsection
