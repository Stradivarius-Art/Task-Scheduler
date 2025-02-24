<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Collection getAll(string $userId)
 * @method static \Illuminate\Database\Eloquent\Model create(array $data, string $userId)
 * @method static \Illuminate\Database\Eloquent\Model|null update(array $data)
 * @method static \App\Services\Time\TimeBlockService setTimeBlock(\App\Models\TimeBlock $timeBlock)
 * @method static mixed updateOrder(array $ids)
 * @see \App\Services\Time\TimeBlockService
 */
class TimeBlock extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'timeBlock.facade';
    }
}