<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;

// ✅ Login routes (untuk guest, pindah ke /login agar tidak bentrok dengan landing page)
Route::middleware(['guest'])->group(function () {
    Route::get('/login-fake', function () {
        return 'Halaman login sementara (dummy)';
    })->name('login');
});

Route::get('/home', function () {
    return redirect('/admin');
});

// ✅ Public-facing routes
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ✅ Cart routes
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// ✅ Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// ✅ Product CRUD
Route::resource('products', ProductController::class);

// ✅ Route khusus untuk transaksi otomatis saat klik tombol "Pesan"
Route::post('/transactions/order/{product}', [TransactionController::class, 'order'])->name('transactions.order');

// ✅ Route untuk transaksi dari banyak item (keranjang/cart)
Route::post('/transactions/order-multiple', [TransactionController::class, 'orderMultiple'])->name('transactions.orderMultiple');

// ✅ Route transaksi (tanpa auth, bisa diakses publik sementara)
Route::resource('transactions', TransactionController::class)->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
]);

// ✅ Authenticated (admin/user) routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/admin', [AdminController::class, 'admin']);
    Route::get('/admin/user', [AdminController::class, 'user']);
    Route::get('/logout', [SesiController::class, 'logout']);

});
