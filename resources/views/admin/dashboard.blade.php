@extends('layouts.app')

@section('content')

<!-- Dashboard Content -->
<div class="container my-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text fs-4">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products Sold</h5>
                    <p class="card-text fs-4">{{ $totalProductsSold }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users Active</h5>
                    <p class="card-text fs-4">{{ $totalUsersActive }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales Chart</h5>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Selling Products</h5>
                    <ul class="list-group">
                        @foreach($topSellingProducts as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name }}
                                <span class="badge bg-primary rounded-pill">{{ $item->total_quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Users</h5>
                    <ul class="list-group">
                        @foreach($recentUsers as $user)
                            <li class="list-group-item">{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 mb-3">Create New Product</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.categories') }}" class="btn btn-primary w-100 mb-3">Create New Category</a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Sales',
                data: @json($salesChartData),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
