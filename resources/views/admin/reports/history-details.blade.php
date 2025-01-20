@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-4">Order History Details</h2>
        <a href="{{ route('admin.report') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left"></i>Back to Reports
        </a>
    </div>
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Order ID</div>
                <div class="col-md-9 data-text">{{ $htrans->id }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email Pembeli</div>
                <div class="col-md-9 data-text">{{ $htrans->user->email }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama Pembeli</div>
                <div class="col-md-9 data-text">{{ $htrans->user->name }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Total Harga</div>
                <div class="col-md-9 data-text">Rp {{ number_format($htrans->total_price, 0, ',', '.') }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status</div>
                <div class="col-md-9">
                    <span class="badge bg-{{ $htrans->status === 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($htrans->status) }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal Pemesanan</div>
                <div class="col-md-9 data-text">{{ $htrans->created_at->format('d F Y H:i') }}</div>
            </div>
        </div>
    </div><br>
    <h4 class="section-title mb-4">Barang Yang Dibeli</h4>
    @foreach($dtrans as $d)
        <div class="card m-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <img src="{{ asset($d->product->url_image) }}" alt="{{ $d->name }}" class="product-image-detail">
                    </div>
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">ID Produk</div>
                            <div class="col-md-9 data-text">{{ $d->product->id }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Nama Produk</div>
                            <div class="col-md-9 data-text">{{ $d->product->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Harga Produk</div>
                            <div class="col-md-9 data-text">Rp {{ number_format($d->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Quantity Pembelian</div>
                            <div class="col-md-9 data-text">{{ $d->quantity }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Subtotal</div>
                            <div class="col-md-9 data-text">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .section-title {
        font-size: 2.5rem;
    }
    .fw-bold {
        font-size: 1.5rem;
    }
    .data-text {
        font-size: 1.25rem;
    }
    .badge {
        font-size: 1.25rem;
    }
    .product-image-detail {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 8px;
    }
    .btn-lg {
        font-size: 1.25rem;
    }
</style>
@endsection
