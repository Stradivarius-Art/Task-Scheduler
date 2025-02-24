<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\PomodoroSession;
use App\Http\Resources\PomodoroRoundResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PomodoroSession
 */
class PomodoroSessionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_completed' => $this->is_completed,
            'user_id' => $this->user_id,
            'pomodoro_rounds' => PomodoroRoundResource::collection($this->pomodoroRounds),
        ];
    }
}