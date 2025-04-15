<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Middleware\BuyerMiddleware;
use App\Http\Middleware\SellerMiddleware;
// Public routes
Route::get('/', function () {
    return redirect()->route('register');
});
// Authentication routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', function () {
        if (auth()->user()->isSeller()) {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('buyer.dashboard');
    })->name('dashboard');
    // Seller routes
    Route::middleware([SellerMiddleware::class])->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        Route::get('/seller/all-products', [SellerController::class, 'allProducts'])->name('seller.products.all');

        // Product routes for sellers
        Route::get('/seller/products', [ProductController::class, 'index'])->name('seller.products.index');
        Route::get('/seller/products/create', [ProductController::class, 'create'])->name('seller.products.create');
        Route::post('/seller/products', [ProductController::class, 'store'])->name('seller.products.store');
        Route::get('/seller/products/{product}/edit', [ProductController::class, 'edit'])->name('seller.products.edit');
        Route::put('/seller/products/{product}', [ProductController::class, 'update'])->name('seller.products.update');
        Route::delete('/seller/products/{product}', [ProductController::class, 'destroy'])->name('seller.products.destroy');

        // User activity routes
        Route::get('/user-activities', [UserActivityController::class, 'index'])->name('user-activities.index');
        Route::get('/user-activities/{user}', [UserActivityController::class, 'show'])->name('user-activities.show');
    });

    // Buyer routes
    Route::middleware([BuyerMiddleware::class])->group(function () {
        Route::get('/buyer/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');

        // Product browsing for buyers
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

        // Order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{order}/download-invoice', [OrderController::class, 'downloadInvoice'])->name('orders.download-invoice');
    });
});
