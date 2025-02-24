<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Task;

use App\Facades\Task;
use App\Data\Task\TaskData;
use App\Http\Controllers\Controller;
use App\Models\Task as ModelsTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TaskController extends Controller
{
    public function index(): Collection
    {
        return Task::getAll(auth()->id());
    }

    public function create(TaskData $data): Model
    {
        return Task::create($data->toArray(), auth()->id());
    }

    public function update(TaskData $data, ModelsTask $task): ?Model
    {
        return Task::setTask($task)->update($data->toArray());
    }

    public function delete(ModelsTask $task): ?ModelsTask
    {
        $isDeleted = $task->delete();
        return $isDeleted ? $task : null;
    }
}