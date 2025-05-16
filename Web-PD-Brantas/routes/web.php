<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, AdminController, LandingPageController,
    CatalogController, CartController, CheckoutController, TransactionController,
    AuthController, DashboardController, AccountController, ReviewController
};

// =======================
// AUTH - GUEST ONLY
// =======================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
});

// =======================
// LANDING PAGE (Publik)
// =======================
Route::get('/',            [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog',     [CatalogController::class,  'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::view('/bantuan', 'bantuan')->name('help');

// =======================
// CART - AUTH ONLY
// =======================
Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'viewCart'])->name('view');
    Route::post('/add/{productId}', [CartController::class, 'addToCart'])->name('add');
    Route::put('/', [CartController::class, 'bulkUpdate'])->name('update');
    Route::delete('/{id}', [CartController::class, 'removeFromCart'])->name('remove');
});

// =======================
// CHECKOUT - TERBUKA
// =======================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// =======================
// AUTHENTICATED USER ROUTES
// =======================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil Pelanggan
    Route::controller(AccountController::class)->group(function () {
        Route::get('/profile', 'editProfile')->name('profile.edit');
        Route::put('/profile', 'updateProfile')->name('profile.update');
    });

    // Redirect user biasa dari /dashboard
    Route::get('/dashboard', fn () => redirect()->route('landing.index'))->name('dashboard');

    // Review Produk
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    /*
    |--------------------------------------------------------------------------
    | ADMIN-ONLY ROUTES (prefix: admin, name: admin.*)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Resource admin
        Route::resource('products', ProductController::class);
        Route::resource('transactions', TransactionController::class)->except(['show']);
        Route::resource('accounts', AccountController::class)->except(['show']);

        // Tambahan khusus admin.akun.*
        Route::prefix('akun')->name('akun.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::get('/create', [AccountController::class, 'create'])->name('create'); 
            Route::post('/', [AccountController::class, 'store'])->name('store'); // <-- Ini ditambahkan
            Route::get('/{id}/edit', [AccountController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AccountController::class, 'update'])->name('update');
            Route::delete('/{id}', [AccountController::class, 'destroy'])->name('destroy');
        });
    });
});
