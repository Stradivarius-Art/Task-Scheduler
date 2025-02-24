<?php

namespace App\Services\Time;

use App\Models\User;
use App\Models\TimeBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TimeBlockService
{
    private TimeBlock $timeBlock;

    public function getAll(string $userId): Collection
    {
        return TimeBlock::query()->select([
            'id',
            'created_at',
            'updated_at',
            'name',
            'color',
            'duration',
            'order',
            'user_id'
        ])
            ->orderBy('order')
            ->where('user_id', $userId)
            ->get();
    }

    public function create(array $data, string $userId): Model
    {
        $user = User::findOrFail($userId);
        return $user->timeBlocks()
            ->select([
                'id',
                'created_at',
                'updated_at',
                'name',
                'color',
                'duration',
                'order',
                'user_id'
            ])->create([
                'name' => $data['name'] ?? null,
                'color' => $data['color'] ?? null,
                'duration' => $data['duration'] ?? null,
                'order' => $data['order'] ?? 1
            ]);
    }

    public function update(array $data): ?Model
    {
        $timeBlock = $this->timeBlock;

        $timeBlock->update([
            'name' => $data['name'] ?? $timeBlock->name,
            'color' => $data['color'] ?? $timeBlock->color,
            'duration' => $data['duration'] ?? $timeBlock->duration,
            'order' => $data['order'] ?? $timeBlock->order,
        ]);

        return $timeBlock->find($timeBlock->id);
    }

    public function updateOrder(array $ids): mixed
    {
        return DB::transaction(function () use ($ids) {
            foreach ($ids as $order => $id) {
                TimeBlock::where('id', $id)->update(['order' => $order]);
            }
        });
    }

    public function setTimeBlock(TimeBlock $timeBlock): static
    {
        $this->timeBlock = $timeBlock;

        return $this;
    }
}