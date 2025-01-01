@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4 section-title">Our Products</h2>

    <!-- Category Filter -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="btn-group d-flex flex-wrap justify-content-center" role="group">
                <button type="button" class="btn btn-outline-primary m-1 active">All</button>
                <button type="button" class="btn btn-outline-primary m-1">Playing Cues</button>
                <button type="button" class="btn btn-outline-primary m-1">Jump Cues</button>
                <button type="button" class="btn btn-outline-primary m-1">Chalk</button>
                <button type="button" class="btn btn-outline-primary m-1">Cases</button>
            </div>
        </div>
    </div>

    <!-- Product Cards -->
    <div class="row">
        <!-- Example Product Card -->
        <div class="col-md-3 mb-4">
            <div class="card category-card h-100">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Playing Cue">
                <div class="card-body">
                    <h5 class="card-title">Professional Playing Cue</h5>
                    <p class="card-text text-muted">High-quality maple wood playing cue with premium finish</p>
                    <p class="price-tag">Rp 2.500.000</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <!-- Duplicate cards for example -->
        <div class="col-md-3 mb-4">
            <div class="card category-card h-100">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Jump Cue">
                <div class="card-body">
                    <h5 class="card-title">Carbon Fiber Jump Cue</h5>
                    <p class="card-text text-muted">Lightweight and powerful jump cue for precise shots</p>
                    <p class="price-tag">Rp 3.200.000</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card category-card h-100">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Chalk">
                <div class="card-body">
                    <h5 class="card-title">Premium Chalk Set</h5>
                    <p class="card-text text-muted">Set of 4 premium chalks for better grip</p>
                    <p class="price-tag">Rp 150.000</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card category-card h-100">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Case">
                <div class="card-body">
                    <h5 class="card-title">Deluxe Cue Case</h5>
                    <p class="card-text text-muted">2x4 leather case with premium protection</p>
                    <p class="price-tag">Rp 1.800.000</p>
                    <a href="#" class="btn btn-primary w-100">Add to Cart</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
