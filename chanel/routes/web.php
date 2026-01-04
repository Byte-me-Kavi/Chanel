<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
Route::get('/exclusives', [ProductController::class, 'exclusives'])->name('exclusives');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{index}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Admin Auth Routes (public)
Route::get('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (protected by admin middleware)
Route::middleware([App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Order Tracking Routes (Auth-protected)
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/track', [App\Http\Controllers\OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{id}/status', [App\Http\Controllers\OrderController::class, 'status'])->name('orders.status');

    // Wishlist Routes (Auth-protected)
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
});
