@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">Manage Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus"></i> Add New Category
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
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <img src="{{ asset($category->url_image) }}" alt="{{ $category->name }}" class="category-image">
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
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
    .category-image {
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
    function deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            document.getElementById('delete-form-' + categoryId).submit();
        }
    }
</script>
@endsection
