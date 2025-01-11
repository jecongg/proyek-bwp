@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>
    <form method="GET" action="{{ route('customer.products') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card product-card">
                    <a href="{{ route('customer.products.show', $product->id) }}">
                        <img src="{{ asset($product->url_image) }}" class="card-img-top" alt="{{ $product->name }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->category->name }}</p>
                        <p class="card-text mt-auto"><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
</div>
@endsection

<style>
    .product-card {
        width: 100%;
        max-width: 300px; /* Fixed width for the card */
        height: 400px; /* Fixed height for the card */
        display: flex;
        flex-direction: column;
        margin: auto; /* Center the card horizontally */
        overflow: hidden; /* Hide overflow content */
    }

    .product-card img {
        height: 200px; /* Fixed height for the image */
        object-fit: cover;
    }

    .product-card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Ensure elements in card body are distributed */
        overflow: hidden; /* Hide overflow content */
    }

    .product-card .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        white-space: nowrap; /* Prevent text wrapping */
        overflow: hidden; /* Hide overflow content */
        text-overflow: ellipsis; /* Add ellipsis for overflow text */
    }

    .product-card .card-text {
        margin-bottom: 0.5rem; /* Space between elements */
        overflow: hidden; /* Hide overflow content */
        text-overflow: ellipsis; /* Add ellipsis for overflow text */
    }
</style>
