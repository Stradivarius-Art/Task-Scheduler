<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Collection getAll(int $userId)
 * @method static \Illuminate\Database\Eloquent\Model create(array $data, int $userId)
 * @method static \Illuminate\Database\Eloquent\Model|null update(array $data, int $userId)
 * @method static \App\Services\Task\TaskService setTask(\App\Models\Task $task)
 * @see \App\Services\Task\TaskService
 */
class Task extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'task.facade';
    }
}