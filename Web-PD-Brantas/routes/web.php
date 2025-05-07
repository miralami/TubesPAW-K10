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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;

// Halaman utama redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Auth - Registrasi & Login
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman profil pelanggan
    Route::get('/profile', [AccountController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');

    // Admin - Kelola akun
    Route::middleware(['admin'])->group(function () {
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
    });
});

Route::middleware(['admin'])->group(function () {
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});



Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
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
