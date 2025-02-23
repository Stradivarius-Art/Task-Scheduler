<?php

use App\Http\Controllers\Api\v1\Time\TimeBlockController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(TimeBlockController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::get('user/time-blocks', 'index')->name('get.time-blocks');
            Route::post('user/time-blocks', 'create')->name('create.time-blocks');
            Route::put('user/time-blocks/update-order', 'updateOrder')->name('update.order');
            Route::put('user/time-blocks/{timeBlock}', 'update')->name('update.time-blocks');
            Route::delete('user/time-blocks/{timeBlock}', 'delete')->name('delete.time-blocks');
        });
});