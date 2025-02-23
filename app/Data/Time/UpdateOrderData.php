<?php

namespace App\Data\Time;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Data;

class UpdateOrderData extends Data
{
    public function __construct(
        #[ArrayType]
        public array $ids
    ) {}
}