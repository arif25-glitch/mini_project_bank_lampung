<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUserController;

// Public routes
Route::post('/register', [RegisterUserController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    
    // Weather routes for authenticated users with rate limiting (10 requests per minute)
    Route::middleware(['throttle:10,1'])->group(function () {
        Route::post('/weather', [WeatherController::class, 'getWeather']);
        Route::get('/weather/{city}', [WeatherController::class, 'getWeatherByCity']);
    });
    
    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return response()->json([
            'is_success' => true,
            'user' => $request->user()
        ]);
    });
    
    // Admin routes for user management
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UsersController::class, 'index']);
        Route::post('/users', [UsersController::class, 'store']);
        Route::delete('/users/{id}', [UsersController::class, 'destroy']);
    });
    
    // Routes that can be accessed by the user themselves or an admin
    Route::get('/users/{id}', [UsersController::class, 'show']);
    Route::put('/users/{id}', [UsersController::class, 'update'])->middleware('user.ownership');
    Route::delete('/users/{id}', [UsersController::class, 'deleteAccount'])->middleware('user.ownership');
    
    // Route for user to add/update their additional info
    Route::post('/users/{id}/info', [UsersController::class, 'storeOrUpdateInfo'])->middleware('user.ownership');
    
    // Route to get user's additional info (accessible by user or admin)
    Route::get('/users/{id}/info', [UsersController::class, 'showInfo']);
});
