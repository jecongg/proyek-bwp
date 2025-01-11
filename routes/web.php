<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;

Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');
Route::get('/about', [CatalogController::class, 'about'])->name('about');

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


Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Product Routes (Admin)
    Route::get('/admin/products', [ProductController::class, 'indexAdmin'])->name('admin.products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'deleteProduct'])->name('admin.products.delete');

    // Category Routes
    Route::get('/admin/categories', [CategoryController::class, 'create'])->name('admin.categories');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    // Profile Routes (Admin)
    Route::get('/admin/profile', [ProfileController::class, 'editAdmin'])->name('admin.profile.edit');
    Route::put('/admin/profile', [ProfileController::class, 'updateAdmin'])->name('admin.profile.update');

    // Orders, Reports, Users
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');

});

Route::group(['middleware' => ['auth', 'role:Customer']], function () {
    // Customer Dashboard
    Route::get('/customer/dashboard', function() {
        return view('customer.dashboard');
    });

    // Product Routes (Customer)
    Route::get('/customer/products', [ProductController::class, 'indexCustomer'])->name('customer.products');
    Route::get('/customer/products/{id}', [ProductController::class, 'show'])->name('customer.products.show');

    // Cart Routes
    Route::get('/customer/cart', [CartController::class, 'index'])->name('customer.cart');
    Route::post('/customer/cart/add', [CartController::class, 'add'])->name('customer.cart.add');
    Route::post('/customer/cart/remove', [CartController::class, 'remove'])->name('customer.cart.remove');

    // Wishlist Routes
    Route::get('/customer/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');
    Route::post('/customer/wishlist/add', [WishlistController::class, 'add'])->name('customer.wishlist.add');
    Route::post('/customer/wishlist/remove', [WishlistController::class, 'remove'])->name('customer.wishlist.remove');

    // Profile Routes (Customer)
    Route::get('/customer/profile', [ProfileController::class, 'editCustomer'])->name('customer.profile.edit');
    Route::put('/customer/profile', [ProfileController::class, 'updateCustomer'])->name('customer.profile.update');

    // Checkout Routes
    Route::get('/customer/checkout', [CheckoutController::class, 'index'])->name('customer.checkout');
    Route::post('/customer/checkout', [CheckoutController::class, 'store'])->name('customer.checkout.store');

    // Order Routes
    Route::get('/customer/orders', [OrderController::class, 'index'])->name('customer.orders');
    Route::get('/customer/orders/{id}', [OrderController::class, 'show'])->name('customer.orders.show');
});





