<?php

use App\Http\Controllers\Api\v1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(UserController::class)
        ->middleware(['auth:api', 'refresh.token'])
        ->group(function () {
            Route::get('user/profile', 'profile')->name('user.profile');
            Route::put('user/profile', 'updateProfile')->name('user.update.profile');
        });
});