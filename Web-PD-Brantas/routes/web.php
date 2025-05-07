<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, AdminController, LandingPageController,
    CatalogController, CartController, CheckoutController, TransactionController,
    AuthController, DashboardController, AccountController
};

// =======================
// AUTH - GUEST ONLY
// =======================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// =======================
// LANDING PAGE (Publik)
// =======================
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// =======================
// CART
// =======================
Route::middleware('auth')->prefix('cart')->group(function () {
    Route::post('/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

// =======================
// CHECKOUT
// =======================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// =======================
// TRANSAKSI
// =======================
Route::resource('transactions', TransactionController::class)->only([
    'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
]);
Route::post('/transactions/order/{product}', [TransactionController::class, 'order'])->name('transactions.order');
Route::post('/transactions/order-multiple', [TransactionController::class, 'orderMultiple'])->name('transactions.orderMultiple');

// =======================
// AUTH USER ROUTES
// =======================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User profile
    Route::get('/profile', [AccountController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');

    // Redirect user biasa ke landing, bukan dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('landing.index');
    })->name('dashboard');

    // ===================
    // ADMIN ONLY
    // ===================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // admin.dashboard
        Route::get('/admin', [AdminController::class, 'admin']);
        Route::get('/user', [AdminController::class, 'user']);

        // Resource management
        Route::resource('products', ProductController::class); // admin.products.*
        Route::resource('accounts', AccountController::class)->except(['show']); // admin.accounts.*
    });
});
