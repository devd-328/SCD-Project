<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\ContactController;


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

// Frontend-only cart page (no backend integration)
Route::view('/cart', 'cart')->name('cart');