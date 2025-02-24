<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Model|null getTodaySession(string $userId)
 * @method static \App\Http\Resources\PomodoroSessionResource create(string $userId)
 * @method static \Illuminate\Database\Eloquent\Model|null updateSession(array $data)
 * @method static \Illuminate\Database\Eloquent\Model|null updateRound(array $data)
 * @method static \App\Services\Time\TimerService setPomodoroSession(\App\Models\PomodoroSession $pomodoroSession)
 * @method static \App\Services\Time\TimerService setPomodoroRound(\App\Models\PomodoroRound $pomodoroRound)
 * @see \App\Services\Time\TimerService
 */
class Timer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'timer.facade';
    }
}