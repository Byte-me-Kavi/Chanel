<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/exclusives', [ProductController::class, 'exclusives'])->name('exclusives');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Cart Page
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout Page - Requires Login
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin Authentication
Route::get('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Panel Middleware
Route::middleware([App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    
    // Admin Operations
    Route::post('/delivery', [App\Http\Controllers\AdminController::class, 'storeDelivery'])->name('admin.delivery.store');
    Route::put('/delivery/{id}', [App\Http\Controllers\AdminController::class, 'updateDelivery'])->name('admin.delivery.update');
    Route::get('/delivery/{id}/delete', [App\Http\Controllers\AdminController::class, 'deleteDelivery'])->name('admin.delivery.delete');
    
    Route::post('/product', [App\Http\Controllers\AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::put('/product/{id}', [App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::get('/product/{id}/delete', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    
    Route::post('/user', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::put('/user/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::get('/user/{id}/delete', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.user.delete');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // User Order Pages
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/track', [App\Http\Controllers\OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{id}/status', [App\Http\Controllers\OrderController::class, 'status'])->name('orders.status');

    // Wishlist Page
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
});
