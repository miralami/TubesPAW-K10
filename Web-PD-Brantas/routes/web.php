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
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// =======================
// LANDING PAGE (Publik)
// =======================
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::view('/bantuan','bantuan')->name('help');

// =======================
// CART
// =======================
Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'viewCart'])->name('view');
    Route::post('/add/{productId}', [CartController::class, 'addToCart'])->name('add');
    Route::put('/', [CartController::class, 'bulkUpdate'])->name('update'); // ⬅️ bulk update semua qty
    Route::delete('/{id}', [CartController::class, 'removeFromCart'])->name('remove'); // ⬅️ ubah ke DELETE
});


// =======================
// CHECKOUT
// =======================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

/*
|--------------------------------------------------------------------------
| PUBLIC (guest) ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/',            [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/catalog',     [CatalogController::class,  'index'])->name('catalog.index');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /* -------- Logout ---------- */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /* -------- Profil Pelanggan ---------- */
    Route::controller(AccountController::class)->group(function () {
        Route::get ('/profile', 'editProfile'  )->name('profile.edit');
        Route::put('/profile', 'updateProfile')->name('profile.update');   // pakai PUT agar REST-ful
    });

    /* -------- Redirect user biasa dari /dashboard ke landing ---------- */
    Route::get('/dashboard', fn () => redirect()->route('landing.index'))
         ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN-ONLY ROUTES (prefix: admin, name: admin.*)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
             ->name('dashboard');                                // admin.dashboard

        /* Resource management */
        Route::resource('products',     ProductController::class);          // admin.products.*
        Route::resource('transactions', TransactionController::class)
             ->except(['show']);                                            // admin.transactions.*
        Route::resource('accounts',     AccountController::class)
             ->except(['show']);                                            // admin.accounts.*
    });
});


// =======================

// REVIEW - AUTH ONLY

// =======================

Route::middleware('auth')->post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
