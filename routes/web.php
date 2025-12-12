<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\FarmerController as AdminFarmerController;
use App\Http\Controllers\CheckoutController;

// Home & About Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Farmers/Community
Route::get('/community', [FarmerController::class, 'index'])->name('farmers.index');
Route::get('/community/{id}', [FarmerController::class, 'show'])->name('farmers.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Search
Route::get('/api/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('api.search');

// Frontend-only cart page 
Route::view('/cart', 'cart')->name('cart');

// Frontend-only checkout page 
Route::view('/checkout', 'checkout')->name('checkout');

// Checkout completion endpoint (called by frontend JS to decrement stock)
Route::post('/checkout/complete', [CheckoutController::class, 'store'])->name('checkout.complete');

// Admin Routes
// Redirect plain /admin to dashboard for convenience
Route::redirect('/admin', '/admin/dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Product CRUD Routes (RESTful)
    Route::resource('products', AdminProductController::class);
    
    // Farmer CRUD Routes (RESTful)
    Route::resource('farmers', AdminFarmerController::class);

    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/approve', [\App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{id}/reject', [\App\Http\Controllers\Admin\UserController::class, 'reject'])->name('users.reject');

    // Order Management
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Orders
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';