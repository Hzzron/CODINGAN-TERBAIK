<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerOrderController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admin/report/sales', [AdminController::class, 'salesReport'])
    ->name('admin.report.sales');

Route::get('/admin/orders', [AdminOrderController::class, 'index'])
    ->name('admin.orders.index');

Route::get('/admin/orders/{orderId}', [AdminOrderController::class, 'show'])
    ->name('admin.orders.show');

Route::post('/admin/orders/{orderId}', [AdminOrderController::class, 'update'])
    ->name('admin.orders.update');

// Product Routes
Route::resource('/product', ProductController::class);

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Protected Routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Customer Routes
    Route::get('/customer/products', [ProductController::class, 'index'])
        ->name('customer.products');

    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');

    Route::get('/customer/orders', [CustomerOrderController::class, 'index'])
        ->name('customer.orders');

    Route::get('/customer/orders/{orderId}', [CustomerOrderController::class, 'show'])
        ->name('customer.order-detail');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])
        ->name('customer.cart');

    Route::post('/cart/add/{productId}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::put('/cart/update/{cartId}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])
        ->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('customer.checkout');

    Route::post('/checkout', [OrderController::class, 'processCheckout'])
        ->name('customer.checkout.process');

    Route::get('/checkout/confirmation/{orderId}', [OrderController::class, 'confirmation'])
        ->name('customer.checkout.confirmation');
});
