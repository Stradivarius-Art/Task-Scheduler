<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\PomodoroRound;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PomodoroRound
 */
class PomodoroRoundResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'totalSeconds' => $this->totalSeconds,
            'is_completed' => $this->is_completed,
            'pomodoro_session_id' => $this->pomodoro_session_id,
        ];
    }
}