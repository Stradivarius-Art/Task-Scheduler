<?php

namespace App\Data\Task;

use App\Enums\Priority;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class TaskData extends Data
{
    public function __construct(
        #[StringType]
        public string|Optional $name,

        #[BooleanType]
        public bool|Optional $is_completed,

        #[Date]
        public string|Optional $created_at,

        #[Enum(Priority::class)]
        public string|Optional $priority
    ) {}
}