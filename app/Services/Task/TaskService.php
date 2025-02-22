<?php

namespace App\Services\Task;

use App\Enums\Priority;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    private Task $task;

    public function getAll(int $userId): Collection
    {
        return Task::query()->select([
            'id',
            'created_at',
            'updated_at',
            'name',
            'priority',
            'is_completed',
            'user_id'
        ])->where('user_id', $userId)->get();
    }

    public function create(array $data, int $userId): Model
    {
        $user = User::findOrFail($userId);
        return $user->tasks()
            ->select([
                'id',
                'created_at',
                'updated_at',
                'name',
                'priority',
                'is_completed',
                'user_id'
            ])->create([
                'name' => $data['name'] ?? null,
                'is_completed' => $data['is_completed'] ?? false,
                'created_at' => $data['created_at'] ?? now(),
                'priority' => $data['priority'] ?? Priority::low->value
            ]);
    }

    public function update(array $data, int $userId): ?Model
    {
        $task = $this->task
            ->where('user_id', $userId)
            ->first();

        if (!$task) {
            return null;
        }

        $task->update([
            'name' => $data['name'] ?? $task->name,
            'is_completed' => $data['is_completed'] ?? $task->is_completed,
            'created_at' => $data['created_at'] ?? $task->created_at,
            'priority' => $data['priority'] ?? $task->priority,
        ]);

        return $this->task->find($task->id);
    }

    public function setTask(Task $task): static
    {
        $this->task = $task;

        return $this;
    }
}