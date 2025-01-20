@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="auth-card">
                <h2 class="text-center mb-4">Login</h2>

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Cookie::get('email') }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ Cookie::get('password') }}" required>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ Cookie::get('email') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    <div class="text-center">
                        <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
    }

    .auth-card h2 {
        color: var(--primary-dark);
        font-weight: 600;
    }

    .form-label {
        color: var(--primary-dark);
        font-weight: 500;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(77, 161, 169, 0.25);
    }

    .auth-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .auth-link:hover {
        color: var(--primary-dark);
    }

    .btn-primary {
        padding: 0.75rem;
        font-weight: 500;
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>
@endsection
