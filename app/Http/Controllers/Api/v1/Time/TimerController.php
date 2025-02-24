<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Time;

use App\Data\Timer\TimerRoundData;
use App\Data\Timer\TimerSessionData;
use App\Facades\Timer;
use App\Models\PomodoroRound;
use App\Http\Controllers\Controller;
use App\Http\Resources\PomodoroSessionResource;
use App\Models\PomodoroSession;
use Illuminate\Database\Eloquent\Model;

class TimerController extends Controller
{
    public function getTodaySession(): ?Model
    {
        return Timer::getTodaySession(auth()->id());
    }

    public function create(): PomodoroSessionResource
    {
        return Timer::create(auth()->id());
    }

    public function updateRound(TimerRoundData $data, PomodoroRound $pomodoroRound): ?Model
    {
        return Timer::setPomodoroRound($pomodoroRound)
            ->updateRound($data->toArray());
    }

    public function update(TimerSessionData $data, PomodoroSession $pomodoroSession): ?Model
    {
        return Timer::setPomodoroSession($pomodoroSession)
            ->updateSession($data->toArray());
    }

    public function delete(PomodoroSession $pomodoroSession): ?PomodoroSession
    {
        $isDeleted = $pomodoroSession->delete();
        return $isDeleted ? $pomodoroSession : null;
    }
}