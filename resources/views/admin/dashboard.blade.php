@extends('layouts.app')

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('images/carousel1.jpg')}}" class="d-block w-100" alt="Premium Cues">
            <div class="carousel-caption">
                <h2>Premium Billiard Equipment</h2>
                <p>Discover our collection of professional-grade billiard cues and accessories</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1920x600" class="d-block w-100" alt="New Collection">
            <div class="carousel-caption">
                <h2>New Collection Arrival</h2>
                <p>Check out our latest collection of premium jump cues</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">View Collection</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://via.placeholder.com/1920x600" class="d-block w-100" alt="Special Offers">
            <div class="carousel-caption">
                <h2>Special Offers</h2>
                <p>Get up to 30% off on selected items this month</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">Shop Deals</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Dashboard Content -->
<div class="container my-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text fs-4">Rp 10,000,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-4">150</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text fs-4">75</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Notifications -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">Recent Orders</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Order #1234 - Rp 500,000</li>
                        <li class="list-group-item">Order #1235 - Rp 750,000</li>
                        <li class="list-group-item">Order #1236 - Rp 1,200,000</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">Notifications</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Product "Cue Stick" is low on stock</li>
                        <li class="list-group-item">New user registered: John Doe</li>
                        <li class="list-group-item">Order #1234 has been shipped</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100 mb-3">Create New Product</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.categories') }}" class="btn btn-outline-primary w-100 mb-3">Create New Category</a>
        </div>
    </div>
</div>

<style>
    .carousel-item {
        height: 600px;
        overflow: hidden;
    }

    .carousel-item img {
        object-fit: cover;
        height: 100%;
    }

    .carousel-caption {
        background: rgba(46, 80, 119, 0.7);
        padding: 2rem;
        border-radius: 10px;
        max-width: 600px;
        margin: 0 auto;
    }

    .carousel-caption h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

</style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection
