<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['auth.jwt'])->group(function () {
    Route::get('/protected', function () {
        return response()->json(['message' => 'Welcome to protected route']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
