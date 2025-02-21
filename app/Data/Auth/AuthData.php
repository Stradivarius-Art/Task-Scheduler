<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class AuthData extends Data
{
    public function __construct(
        #[Required]
        #[Email]
        public string $email,
        #[Required]
        #[Min(6)]
        public string $password
    ) {}
}