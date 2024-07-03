<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Product Route
Route::get('/product', function () {
    return view('product');
})->name('product');

// Category Route
Route::get('/category', function () {
    return view('category');
})->name('category');

// Artist Route
Route::get('/artist', function () {
    return view('artist');
})->name('artist');

// About Route
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Route
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Shopping Cart Route
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Dashboard Route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    
    Route::resource('categories', 'CategoryController');
    Route::resource('artists', 'ArtistController');
    Route::resource('products', 'ProductController');
});

// User Routes
Route::middleware(['auth'])->group(function () {
    // Profile-related routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User dashboard route
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
