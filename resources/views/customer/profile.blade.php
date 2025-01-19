@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Profile</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if(Auth::user()->url_image)
                        <img src="{{ asset(Auth::user()->url_image) }}" alt="Profile Image" class="profile-image" style="width: 200px; height: 200px;
                         object-fit: cover; border-radius: 50%;">
                    @else
                        <img src="/path/to/default/profile/icon.png" alt="Default Profile Icon" class="profile-image">
                    @endif
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile Information</div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your current password">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter a new password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your new password">
                        </div>
                        <div class="form-group">
                            <label for="profile_image">Profile Image in URL</label>
                            <input type="text" class="form-control" id="profile_image" name="profile_image">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
