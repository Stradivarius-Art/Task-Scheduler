<?php

namespace App\Data\Timer;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;

class TimerRoundData extends Data
{
    public function __construct(
        #[IntegerType]
        public int|Optional $totalSeconds,

        #[BooleanType]
        public bool|Optional $is_completed
    ) {}
}