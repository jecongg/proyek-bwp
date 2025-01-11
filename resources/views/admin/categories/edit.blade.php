@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Edit Category</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Category</div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $category->description }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="url_image">Category Image URL</label>
                            <input type="text" class="form-control" id="url_image" name="url_image" value="{{ old('url_image', $category->url_image) }}">
                            @if($category->url_image)
                                <img src="{{ asset($category->url_image) }}" alt="{{ $category->name }}" class="img-fluid mt-2" width="150">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

