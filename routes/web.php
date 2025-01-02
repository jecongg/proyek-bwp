<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;

Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Routes Example
Route::middleware(['auth'])->group(function () {
    // Routes for all authenticated users
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Routes only for Admin
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'role:Customer'])->group(function () {
    // Routes only for Customer
});

