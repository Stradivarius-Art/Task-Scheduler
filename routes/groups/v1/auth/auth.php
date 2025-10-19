<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)
        ->group(function () {
            Route::post('auth/register', 'register')->name('auth.register');
            Route::post('auth/login', 'login')->name('auth.login');
            Route::post('auth/login/access-token', 'getNewTokens')->name('auth.access.token');
            Route::post('auth/logout', 'logout')->name('auth.logout');

            Route::get('auth/yandex/redirect', 'redirectToYandex')->name('auth.yandex.redirect');
            Route::get('auth/yandex/callback', 'handleYandexCallback')->name('auth.yandex.callback');

            Route::get('auth/google/redirect', 'redirectToGoogle')->name('auth.google.redirect');
            Route::get('auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');
        });
});
