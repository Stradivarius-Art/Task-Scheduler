<?php

use App\Http\Controllers\Api\v1\Time\TimerController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(TimerController::class)
        ->middleware('auth:api')
        ->group(function () {
            Route::get('user/timer/today', 'getTodaySession')->name('get.timer-session');
            Route::post('user/timer', 'create')->name('create.timer');
            Route::put('user/timer/round/{pomodoroRound}', 'updateRound')->name('update.timer-round');
            Route::put('user/timer/{pomodoroSession}', 'update')->name('update.timer-session');
            Route::delete('user/timer/{pomodoroSession}', 'delete')->name('delete.timer-session');
        });
});