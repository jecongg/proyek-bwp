@extends('layouts.app')

@section('content')
<div class="container my-5">

    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center section-title mb-4">Customer Dashboard</h2>
        </div>
    </div>

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
        <br><br><br>
    </div>

    <!-- About Us Section -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-6 mx-auto">
            <h2 class="section-title">About Us</h2>
            <p class="text-muted">Text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.</p>
            <ul class="list-unstyled">
                <li><i class="bi bi-check-circle text-primary"></i> What is Lorem Ipsum?</li>
                <li><i class="bi bi-check-circle text-primary"></i> Where can I get some?</li>
            </ul>
        </div>
        <div class="col-md-6 mx-auto">
            <img src="/images/aboutus.jpg" alt="About Us" class="img-fluid rounded shadow" style="width: 100%; height: 300px; object-fit: cover;">
        </div>
    </div>


    <!-- Our Gallery Section -->
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="section-title">Our Gallery</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <img src="/images/ourgallery1.jpg" class="img-fluid rounded shadow gallery-image" alt="Gallery Image 1">
        </div>
        <div class="col-md-4 mb-4">
            <img src="/images/ourgallery2.jpg" class="img-fluid rounded shadow gallery-image" alt="Gallery Image 2">
        </div>
        <div class="col-md-4 mb-4">
            <img src="/images/ourgallery3.jpg" class="img-fluid rounded shadow gallery-image" alt="Gallery Image 3">
        </div>
    </div>

    <style>
        .gallery-image {
            width: 100%; 
            height: 300px; 
            object-fit: cover;
        }
    </style>


    <!-- Customer Dashboard Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text price-tag">5 Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Spent</h5>
                    <p class="card-text price-tag">Rp 2,500,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Loyalty Points</h5>
                    <p class="card-text price-tag">150 Points</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-light">Recent Orders</div>
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
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-light">Notifications</div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">Your order #1234 has been shipped</li>
                        <li class="list-group-item">New product "Cue Stick" is now available</li>
                        <li class="list-group-item">You have earned 50 loyalty points</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('customer.orders') }}" class="btn btn-primary w-100 mb-3">View All Orders</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-primary w-100 mb-3">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
