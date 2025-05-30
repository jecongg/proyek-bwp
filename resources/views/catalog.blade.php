@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Our Products</h2>

    {{-- Alert Messages --}}
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('catalog') }}" class="d-flex gap-3">
                <select name="category" class="form-select w-auto">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4 mb-5">
        @forelse($products as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('customer.products.show', $product->id) }}">
                            <img src="{{ asset($product->url_image) }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="product-details">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-category">{{ $product->category->name }}</p>
                        <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Shop Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No products found.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .section-title {
        font-size: 2rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .product-image {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-details {
        padding: 1rem;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-category {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Search and Filter Styles */
    .form-select, .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .form-select:focus, .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .gap-3 {
        gap: 1rem;
    }
</style>
@endsection
