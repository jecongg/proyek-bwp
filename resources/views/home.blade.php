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
                <h2>About Us</h2>
                <p>Welcome to our store! We are dedicated to providing you with the best quality products and exceptional customer service</p>
                <a href="{{ route('about') }}" class="btn btn-primary btn-lg">About Us</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('images/car2.jpg')}}" class="d-block w-100" alt="New Collection">
            <div class="carousel-caption">
                <h2>Premium Billiard Equipments</h2>
                <p>Discover our collection of professional-grade billiard cues and accessories</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Shop Now</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('images/catalog.jpg')}}" class="d-block w-100" alt="Special Offers">
            <div class="carousel-caption">
                <h2>New Collection Arrival</h2>
                <p>Check out our latest collection of premium billiard equipments</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg">View Catalog</a>
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

<!-- Featured Categories -->
<!-- Featured Categories -->
<section class="featured-categories py-5">
    <div class="container">
        <h3 class="section-title text-center mb-4">Featured Categories</h3>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="category-box">
                    <img src="{{asset('images/cue.jpg')}}" alt="Playing Cues" class="img-fluid category-image">
                    <div class="category-content">
                        <h4>Playing Cues</h4>
                        <a href="{{ route('catalog', ['category' => 'Play Cue']) }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-box">
                    <img src="{{asset('images/cuecase.jpg')}}" alt="Cue Cases" class="img-fluid category-image">
                    <div class="category-content">
                        <h4>Cue Cases</h4>
                        <a href="{{ route('catalog', ['category' => 'Cue Case']) }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-box">
                    <img src="{{asset('images/gloves.jpg')}}" alt="Gloves" class="img-fluid category-image">
                    <div class="category-content">
                        <h4>Gloves</h4>
                        <a href="{{ route('catalog', ['category' => 'Gloves']) }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-box">
                    <img src="{{asset('images/pooltable.jpg')}}" alt="Pool Table" class="img-fluid category-image">
                    <div class="category-content">
                        <h4>Pool Table</h4>
                        <a href="{{ route('catalog', ['category' => 'Pool Table']) }}" class="btn btn-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose-us py-5" style="background-color: var(--light);">
    <div class="container">
        <h3 class="section-title text-center mb-5">Why Choose Us</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fas fa-medal mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
                    <h4>Premium Quality</h4>
                    <p>We offer only the highest quality billiard equipment from trusted manufacturers.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fas fa-shipping-fast mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
                    <h4>Fast Delivery</h4>
                    <p>Quick and secure shipping to ensure your items arrive safely and on time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fas fa-headset mb-3" style="font-size: 2.5rem; color: var(--primary);"></i>
                    <h4>Expert Support</h4>
                    <p>Our team of experts is always ready to help you with any questions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Carousel Styling */
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

    /* Featured Categories Styling */
    .category-box {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .category-box:hover {
        transform: translateY(-5px);
    }

    .category-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(46, 80, 119, 0.9), transparent);
        color: white;
        text-align: center;
    }

    .category-content h4 {
        margin-bottom: 1rem;
    }

    .category-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    /* Feature Box Styling */
    .feature-box {
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .feature-box:hover {
        transform: translateY(-5px);
    }

    .feature-box h4 {
        color: var(--primary-dark);
        margin: 1rem 0;
    }

    .feature-box p {
        color: #666;
        margin-bottom: 0;
    }

    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--secondary);
    }
</style>

<!-- Tambahkan Font Awesome di bagian head -->
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@endsection
