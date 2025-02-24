<?php

namespace App\Data\Timer;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Validation\BooleanType;

class TimerSessionData extends Data
{
    public function __construct(
        #[BooleanType]
        public bool|Optional $is_completed
    ) {}
}