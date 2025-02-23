<?php

namespace App\Data\Time;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class TimeBlockData extends Data
{
    public function __construct(
        #[Required]
        #[StringType]
        public string $name,

        #[StringType]
        public string|Optional $color,

        #[Required]
        #[IntegerType]
        public int|Optional $duration,

        #[IntegerType]
        public int|Optional $order,
    ) {}
}