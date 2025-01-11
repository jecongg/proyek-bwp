@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-center section-title mb-4">Customer Dashboard</h2>
        </div>
    </div>

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
            <a href="{{ route('customer.profile') }}" class="btn btn-outline-primary w-100 mb-3">Edit Profile</a>
        </div>
    </div>

</div>
@endsection
