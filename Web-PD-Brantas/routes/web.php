<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\AdminController; // kalau belum ada controllernya, aku sekalian buatin contoh
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::resource('products', ProductController::class);

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
// });

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
