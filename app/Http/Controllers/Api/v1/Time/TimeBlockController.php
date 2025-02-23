<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Time;

use App\Data\Time\TimeBlockData;
use App\Data\Time\UpdateOrderData;
use App\Facades\TimeBlock;
use App\Http\Controllers\Controller;
use App\Models\TimeBlock as ModelsTimeBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TimeBlockController extends Controller
{
    public function index(): Collection
    {
        return TimeBlock::getAll(auth()->id());
    }

    public function create(TimeBlockData $data): Model
    {
        return TimeBlock::create($data->toArray(), auth()->id());
    }

    public function updateOrder(UpdateOrderData $data): mixed
    {
        return TimeBlock::updateOrder($data->ids);
    }

    public function update(TimeBlockData $data, ModelsTimeBlock $timeBlock): ?Model
    {
        return TimeBlock::setTimeBlock($timeBlock)->update($data->toArray(), auth()->id());
    }

    public function delete(ModelsTimeBlock $timeBlock): ?ModelsTimeBlock
    {
        $isDeleted = $timeBlock->delete();
        return $isDeleted ? $timeBlock : null;
    }
}