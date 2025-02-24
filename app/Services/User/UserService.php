<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\PomodoroRound;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    private User $user;

    public function show(int $id): Model
    {
        return User::query()
            ->select([
                'id',
                'created_at',
                'updated_at',
                'email',
                'name',
                'password',
                'workInterval',
                'breakInterval',
                'intervalsCount'
            ])
            ->with('tasks')
            ->find($id);
    }

    public function getUserUnique(int $id): Model
    {
        return User::query()
            ->where('id', $id)
            ->select('intervalsCount')
            ->firstOrFail();
    }

    public function getByEmail(string $email): ?Model
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function getByProfile(int $id): array
    {
        /**
         * @var User $profile
         */
        $profile = $this->show($id);
        $tasks = $profile->tasks()->where('user_id', $id);

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('is_completed', true)->count();

        $todayStart = Carbon::now()->startOfDay();
        $weekStart = $todayStart->copy()->addDays(7)->startOfWeek();

        $todayTasks = $tasks->where('created_at', '>=', $todayStart)->count();
        $weekTasks = $tasks->where('created_at', '>=', $weekStart)->count();

        $profileArray = $profile->toArray();
        unset($profileArray['password']);

        return [
            'user' => $profileArray,
            'statistics' => [
                ['label' => 'Total', 'value' => $totalTasks,],
                ['label' => 'Completed tasks', 'value' => $completedTasks],
                ['label' => 'Today tasks', 'value' => $todayTasks],
                ['label' => 'Week tasks', 'value' => $weekTasks]
            ]
        ];
    }

    public function createUser(array $attributes): Model
    {
        return User::query()->create([
            'name' => fake()->name(),
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password'])
        ]);
    }

    public function updateUser(array $attributes): array
    {
        $data = [
            'name' => $attributes['name'] ?? $this->user->name,
            'email' => $attributes['email'] ?? $this->user->email,
        ];

        if (isset($attributes['password']) && $attributes['password']) {
            $data['password'] = Hash::make($attributes['password']);
        }

        $this->user->update($data);

        return [
            'name' => $this->user->name,
            'email' => $this->user->email
        ];
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}