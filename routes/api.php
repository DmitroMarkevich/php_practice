<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.jwt');

    Route::post('/{provider}/token', [AuthController::class, 'handleProviderCallback'])
        ->where(['provider' => 'google|facebook']);
});

Route::prefix('user')->group(function () {
    Route::prefix('email')->group(function () {
        Route::post('/verify/{token}', [UserController::class, 'verifyEmail']);
        Route::post('/resend/{email}', [UserController::class, 'resendVerificationEmail']);
    });
});

Route::middleware('auth.jwt')->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'Welcome to protected route']);
    });
});
