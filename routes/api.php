<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserActivityController;
// Public routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::post('/logout', [LoginController::class, 'logout']);
    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::middleware('seller')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    });

    // Orders
    Route::middleware('buyer')->group(function () {
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']);
    });

    // User Activities
    Route::middleware('seller')->group(function () {
        Route::get('/user-activities', [UserActivityController::class, 'index']);
        Route::get('/user-activities/{user}', [UserActivityController::class, 'show']);
    });
}); 
