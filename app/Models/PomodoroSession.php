<?php

namespace App\Models;

use App\Models\User;
use App\Models\PomodoroRound;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 *
 * @property int $id
 * @property int|null $user_id
 * @property bool|null $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, PomodoroRound> $pomodoroRounds
 * @property-read int|null $pomodoro_rounds_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PomodoroSession whereUserId($value)
 * @mixin \Eloquent
 */
class PomodoroSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_completed',
        'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_completed' => 'bool'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pomodoroRounds(): HasMany
    {
        return $this->hasMany(PomodoroRound::class);
    }
}
