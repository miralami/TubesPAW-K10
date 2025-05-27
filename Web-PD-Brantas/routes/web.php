<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, AdminController, LandingPageController,
    CatalogController, CartController, CheckoutController, TransactionController,
    AuthController, DashboardController, AccountController, ReviewController,
};

// =======================
// AUTH - GUEST ONLY
// =======================
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
});

// =======================
// PUBLIC ROUTES
// =======================
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::view('/bantuan', 'bantuan')->name('help');

// =======================
// AUTHENTICATED ROUTES
// =======================
Route::middleware('auth')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::controller(AccountController::class)->group(function () {
        Route::get('/profile', 'editProfile')->name('profile.edit');
        Route::put('/profile', 'updateProfile')->name('profile.update');
    });

    // Cart
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'viewCart')->name('view');
        Route::post('/add/{productId}', 'addToCart')->name('add');
        Route::put('/', 'bulkUpdate')->name('update');
        Route::delete('/{id}', 'removeFromCart')->name('remove');
    });

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/order', [CheckoutController::class, 'pesan'])->name('transactions.orderMultiple');

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');


    // Reviews
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');


    // Redirect regular users from dashboard
    Route::get('/dashboard', fn () => redirect()->route('landing.index'))->name('dashboard');

    // =======================
    // ADMIN ROUTES
    // =======================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('products/export', [ProductController::class, 'export'])
            ->name('products.export');
        Route::post('products/import', [ProductController::class, 'import'])
            ->name('products.import');
        Route::resource('products', ProductController::class);
        Route::resource('transactions', TransactionController::class);


        Route::prefix('akun')->name('akun.')->controller(AccountController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
    });
});

use App\Http\Controllers\UserTransactionController;

Route::get('/riwayat-transaksi', [UserTransactionController::class, 'index'])->middleware('auth')->name('transactions.riwayat');
