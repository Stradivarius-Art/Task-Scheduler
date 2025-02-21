<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\PomodoroRound;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function show(int $id): Model
    {
        return User::query()
            ->select([
                'name',
                'email',
                'password',
                'workInterval',
                'breakInterval',
                'intervalsCount'
            ])
            ->with('tasks')
            ->find($id);
    }

    public function getByEmail(string $email): ?Model
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function createUser(array $attributes): Model
    {
        return User::query()->create([
            'name' => fake()->name(),
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password'])
        ]);
    }
}