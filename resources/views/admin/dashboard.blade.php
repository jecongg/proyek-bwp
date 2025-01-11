@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text">Rp 10,000,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text">150</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text">75</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Orders</div>
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
                <div class="card-header">Notifications</div>
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

    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 mb-3">Create New Product</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.categories') }}" class="btn btn-primary w-100 mb-3">Create New Category</a>
        </div>
    </div>
</div>
@endsection
