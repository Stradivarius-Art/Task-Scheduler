<?php

namespace App\Models;

use App\Models\User;
use App\Enums\Priority;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $name
 * @property Priority|null $priority
 * @property bool|null $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 * @property string|null $qr_code_base64
 * @property string|null $google_calendar_event_id
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereGoogleCalendarEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereQrCodeBase64($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'priority',
        'is_completed',
        'qr_code_base64',
        'google_calendar_event_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'priority' => Priority::class,
        'is_completed' => 'bool'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
