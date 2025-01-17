<?php

namespace App\Models;

use App\Models\PomodoroSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int|null $pomodoro_session_id
 * @property int $totalSeconds
 * @property bool|null $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read PomodoroSession|null $pomodoroSession
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound query()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound wherePomodoroSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound whereTotalSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroRound whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PomodoroRound extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'totalSeconds',
        'is_completed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'totalSeconds' => 'int',
        'is_completed' => 'bool'
    ];

    public function pomodoroSession(): BelongsTo
    {
        return $this->belongsTo(PomodoroSession::class);
    }
}