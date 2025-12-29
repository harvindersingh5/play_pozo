<?php

use App\Http\Controllers\Api\v1\Auth\{ForgotPasswordController, LoginController, RegisterController};
use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('v1')->group(function() {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('test', function() {
            dd('verified');
        });
    });
});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => __('message.route.not_found')
    ], 404);
});