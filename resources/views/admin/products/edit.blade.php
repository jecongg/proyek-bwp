@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Edit Product</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Product</div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category_id" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="url_image">Product Image URL</label>
                            <input type="text" class="form-control" id="url_image" name="url_image" value="{{ $product->url_image }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Current Image</label>
                            <div>
                                <img src="{{ asset($product->url_image) }}" alt="{{ $product->name }}" class="img-fluid product-image-preview">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg mt-3">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-group label {
        font-size: 1.5rem;
    }
    .form-group input, .form-group textarea, .form-group select {
        font-size: 1.25rem;
    }
    .btn-lg {
        font-size: 1.25rem;
    }
    .card-header {
        font-size: 1.5rem;
    }
    .product-image-preview {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 8px;
        margin-top: 10px;
    }
</style>

@endsection
