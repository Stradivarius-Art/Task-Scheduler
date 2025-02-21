<?php

namespace App\Data\User;

use Spatie\LaravelData\Data;
use App\Data\User\PomodoroSettingsData;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;

class UserData extends PomodoroSettingsData
{
    public function __construct(
        #[StringType]
        #[Email]
        public string|Optional $email,

        #[StringType]
        public string|Optional $name,

        #[StringType]
        #[Min(6)]
        public string|Optional $password
    ) {}
}
