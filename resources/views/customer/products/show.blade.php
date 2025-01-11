@extends('layouts.app')

@section('content')
<div class="container py-5">
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

                <div class="d-flex align-items-center">
                    <a href="{{ route('customer.cart.add', $product->id) }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </a>
                    <a href="#"
                    onclick="event.preventDefault(); document.getElementById('add-to-wishlist-form').submit();"
                    class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-heart"></i> Add to Wishlist
                    </a>
                    <form id="add-to-wishlist-form" action="{{ route('customer.wishlist.add') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .product-image-wrapper {
        border: 1px solid #eaeaea;
        padding: 15px;
        border-radius: 8px;
        background-color: #f8f9fa;
    }

    .product-title {
        font-size: 2.5rem; /* Memperbesar ukuran nama produk */
        font-weight: bold;
        color: #333;
    }

    .product-category {
        font-size: 1.25rem; /* Memperbesar ukuran teks kategori */
        color: #555;
    }

    .product-description {
        font-size: 1.25rem; /* Memperbesar ukuran teks deskripsi */
        line-height: 1.8;
        color: #555;
    }

    .product-price {
        font-size: 1.75rem; /* Ukuran harga tetap menonjol */
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
