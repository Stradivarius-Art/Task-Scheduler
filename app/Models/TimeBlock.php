<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string|null $color
 * @property int $duration
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeBlock whereUserId($value)
 * @mixin \Eloquent
 */
class TimeBlock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color',
        'duration',
        'order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration' => 'int',
        'order' => 'int'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}