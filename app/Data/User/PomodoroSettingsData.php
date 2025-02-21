<?php

namespace App\Data\User;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class PomodoroSettingsData extends Data
{
    public function __construct(
        #[IntegerType]
        #[Min(1)]
        public int|Optional $workInterval,

        #[IntegerType]
        #[Min(1)]
        public int|Optional $breakInterval,

        #[IntegerType]
        #[Min(1)]
        #[Max(10)]
        public int|Optional $intervalsCount,
    ) {}
}
