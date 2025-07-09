<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;

Route::post('register', [JWTAuthController::class, 'register'])->name('register');
Route::post('login', [JWTAuthController::class, 'login'])->name('login');
Route::get('/get-blogs', [JWTAuthController::class, 'getData'])->name('get-blog');

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('user', [JWTAuthController::class, 'me'])->name('user');
    Route::post('logout', [JWTAuthController::class, 'logout'])->name('logout');
});
