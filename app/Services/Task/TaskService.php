<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Models\User;
use App\Enums\Priority;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    private Task $task;

    public function getAll(string $userId): Collection
    {
        return Task::query()->select([
            'id',
            'created_at',
            'updated_at',
            'name',
            'priority',
            'is_completed',
            'user_id',
            'qr_code_base64'
        ])->where('user_id', $userId)->get();
    }

    public function create(array $data, string $userId): Model
    {
        $user = User::findOrFail($userId);
        $task =  $user->tasks()
            ->select([
                'id',
                'created_at',
                'updated_at',
                'name',
                'priority',
                'is_completed',
                'user_id',
                'qr_code_base64'
            ])->create([
                'name' => $data['name'] ?? null,
                'is_completed' => $data['is_completed'] ?? false,
                'created_at' => $data['created_at'] ?? now(),
                'priority' => $data['priority'] ?? Priority::low->value
            ]);

        $url = url("/api/v1/user/tasks/{$task->id}/complete");
        $qrCodeBase64 = \base64_encode(QrCode::format('png')->size(300)->generate($url));

        $task->qr_code_base64 = $qrCodeBase64;
        $task->save();

        return $task;
    }

    public function update(array $data): ?Model
    {
        $task = $this->task;

        $task->update([
            'name' => $data['name'] ?? $task->name,
            'is_completed' => $data['is_completed'] ?? $task->is_completed,
            'created_at' => $data['created_at'] ?? $task->created_at,
            'priority' => $data['priority'] ?? $task->priority,
        ]);

        return $task->find($task->id);
    }

    public function qrCodeGenerate(): JsonResponse
    {
        $user = auth()->user();

        $task = Task::query()
            ->where('id', $this->task->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$task->qr_code_base64) {
            $url = url("/api/v1/user/tasks/{$task->id}/complete");
            $qrCodeBase64 = base64_encode(QrCode::format('png')->size(300)->generate($url));
            $task->qr_code_base64 = $qrCodeBase64;
            $task->save();
        }

        return response()->json([
            'qr_code_base64' => $task->qr_code_base64
        ]);
    }

    public function completeTask(): JsonResponse
    {
        $task = $this->task;

        $task->update(['is_completed' => true]);

        return response()->json([
            'message' => 'Task marked as completed',
            'task' => $task
        ]);
    }

    public function setTask(Task $task): static
    {
        $this->task = $task;

        return $this;
    }
}