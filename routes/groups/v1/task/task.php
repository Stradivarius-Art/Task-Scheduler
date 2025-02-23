<?php

use App\Http\Controllers\Api\v1\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(TaskController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::get('user/tasks', 'index')->name('get.tasks');
            Route::post('user/tasks', 'create')->name('create.tasks');
            Route::put('user/tasks/{task}', 'update')->name('update.tasks');
            Route::delete('user/tasks/{task}', 'delete')->name('delete.tasks');
        });
});