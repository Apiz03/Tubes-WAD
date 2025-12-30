<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');

Route::middleware(['auth', 'role:admin,mahasiswa'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/cart/add/{foodId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'indexCart'])->name('cart.index');
    Route::delete('/cart/remove/{cartId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/foods', [FoodController::class, 'index'])->name('admin.index');
    Route::get('/foods/create', [FoodController::class, 'create'])->name('admin.create');
    Route::post('/foods', [FoodController::class, 'store'])->name('admin.store');
    Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('admin.edit');
    Route::put('/foods/{food}', [FoodController::class, 'update'])->name('admin.update');
    Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('admin.destroy');
    
});