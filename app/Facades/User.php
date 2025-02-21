<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Model show(int $id)
 * @method static null|\Illuminate\Database\Eloquent\Model getByEmail(string $email)
 * @method static array getByProfile(int $id)
 * @method static \Illuminate\Database\Eloquent\Model createUser(array $attributes)
 * @method static array updateUser(array $attributes)
 * @method static \App\Services\User\UserService setUser(\App\Models\User $user)
 * @see \App\Services\User\UserService
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user.facade';
    }
}