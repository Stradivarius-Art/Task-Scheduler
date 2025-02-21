<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('auth/register', 'register')->name('auth.register');
        Route::post('auth/login', 'login')->name('auth.login');
        Route::post('auth/login/access-token', 'getNewTokens')->name('auth.access.token');
        Route::post('auth/logout', 'logout')->name('auth.logout');
    });
});