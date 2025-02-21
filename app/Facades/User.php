<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Database\Eloquent\Model show(int $id)
 * @method static null|\Illuminate\Database\Eloquent\Model getByEmail(string $email)
 * @method static \Illuminate\Database\Eloquent\Model createUser(array $attributes)
 * @see \App\Services\User\UserService
 */
class User extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user.facade';
    }
}