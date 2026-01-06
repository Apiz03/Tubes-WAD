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
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/cart/add/{foodId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'indexCart'])->name('cart.index');
    Route::delete('/cart/remove/{cartId}', [App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout.process');
    Route::get('/statuses', [App\Http\Controllers\StatusController::class, 'index'])->name('status.index');
    Route::get('/statuses/{statusId}/edit', [App\Http\Controllers\StatusController::class, 'edit'])->name('status.edit');
    Route::put('/statuses/{statusId}/update', [App\Http\Controllers\StatusController::class, 'update'])->name('status.update');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/foods', [FoodController::class, 'index'])->name('admin.index');
    Route::get('/foods/create', [FoodController::class, 'create'])->name('admin.create');
    Route::post('/foods', [FoodController::class, 'store'])->name('admin.store');
    Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('admin.edit');
    Route::put('/foods/{food}', [FoodController::class, 'update'])->name('admin.update');
    Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('admin.destroy');
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['index', 'show', 'create', 'edit'])->names([
        'store' => 'admin.categories.store',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    Route::resource('restaurants', App\Http\Controllers\RestaurantController::class)->except(['index', 'show', 'create', 'edit'])->names([
        'store' => 'admin.restaurants.store',
        'update' => 'admin.restaurants.update',
        'destroy' => 'admin.restaurants.destroy',
    ]);
    
});