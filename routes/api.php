<?php

use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register'])->name('v1.register');
    Route::post('login', [JWTAuthController::class, 'login'])->name('v1.login');
    Route::get('get-blogs', [BlogController::class, 'getData'])->name('v1.get-blog');

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', [JWTAuthController::class, 'me'])->name('v1.user');
        Route::post('logout', [JWTAuthController::class, 'logout'])->name('v1.logout');
    });
});
