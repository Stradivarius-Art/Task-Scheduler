<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="AuthData",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="user@example.com",
 *         description="The email of the user"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="password123",
 *         description="The password of the user (min 6 characters)"
 *     )
 * )
 */
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