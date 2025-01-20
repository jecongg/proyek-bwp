@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Manage Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset($product->url_image) }}" alt="{{ $product->name }}" class="product-image">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProduct({{ $product->id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .section-title {
        font-size: 2.5rem;
    }
    .btn-lg {
        font-size: 1.25rem;
    }
    .table th, .table td {
        font-size: 1.25rem;
    }
    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-group .btn {
        padding: 0.5rem 1rem;
    }
</style>

<script>
    function deleteProduct(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }
</script>
@endsection
