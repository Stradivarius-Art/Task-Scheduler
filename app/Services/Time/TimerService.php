<?php

namespace App\Services\Time;

use Carbon\Carbon;
use App\Facades\User;
use App\Models\PomodoroRound;
use App\Models\PomodoroSession;
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\PomodoroSessionResource;

class TimerService
{
    private PomodoroSession $pomodoroSession;
    private PomodoroRound $pomodoroRound;

    public function getTodaySession(string $userId): ?Model
    {
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();

        $pomodoroSession = PomodoroSession::query()
            ->where('created_at', '>=', $todayStart)
            ->where('created_at', '<', $todayEnd)
            ->where('user_id', $userId)
            ->with(['pomodoroRounds' => function ($query) {
                $query->orderBy('id');
            }])
            ->first();
        return $pomodoroSession;
    }

    public function create(string $userId): PomodoroSessionResource
    {
        $todaySession = $this->getTodaySession($userId);

        if ($todaySession) {
            return new PomodoroSessionResource($todaySession);
        }

        /**
         * @var ModelsUser $user
         */
        $user = User::getUserUnique($userId);

        $pomodoroSession = PomodoroSession::create([
            'user_id' => $userId,
        ]);

        $rounds = array_fill(0, $user->intervalsCount, [
            'totalSeconds' => 0,
        ]);

        $pomodoroSession->pomodoroRounds()->createMany($rounds);

        $pomodoroSession->load('pomodoroRounds');

        return new PomodoroSessionResource($pomodoroSession);
    }

    public function updateSession(array $data): ?Model
    {
        $pomodoroSession = $this->pomodoroSession;

        $pomodoroSession->update(
            [
                'is_completed' => $data['is_completed'] ?? $pomodoroSession->is_completed
            ]
        );

        return $pomodoroSession->find($pomodoroSession->id);
    }

    public function updateRound(array $data): ?Model
    {
        $this->pomodoroRound->update(
            [
                'totalSeconds' => $data['totalSeconds'] ?? $this->pomodoroRound->totalSeconds,
                'is_completed' => $data['is_completed'] ?? $this->pomodoroRound->is_completed
            ]
        );

        return $this->pomodoroRound->find($this->pomodoroRound->id);
    }

    public function setPomodoroSession(PomodoroSession $pomodoroSession): static
    {
        $this->pomodoroSession = $pomodoroSession;

        return $this;
    }

    public function setPomodoroRound(PomodoroRound $pomodoroRound): static
    {
        $this->pomodoroRound = $pomodoroRound;

        return $this;
    }
}