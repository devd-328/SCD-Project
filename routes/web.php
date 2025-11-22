<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CheckoutController;


// Home & About Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Farmers/Community
Route::get('/community', [FarmerController::class, 'index'])->name('farmers.index');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Frontend-only cart page 
Route::view('/cart', 'cart')->name('cart');

// Frontend-only checkout page 
Route::view('/checkout', 'checkout')->name('checkout');

// Checkout completion endpoint (called by frontend JS to decrement stock)
Route::post('/checkout/complete', [CheckoutController::class, 'store'])->name('checkout.complete');

// Admin Routes
// Redirect plain /admin to dashboard for convenience
Route::redirect('/admin', '/admin/dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Product CRUD Routes (RESTful)
    Route::resource('products', AdminProductController::class);
});