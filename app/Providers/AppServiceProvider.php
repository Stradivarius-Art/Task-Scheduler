<?php

namespace App\Providers;

use App\Http\Resources\PomodoroSessionResource;
use App\Services\Auth\AuthService;
use App\Services\Task\TaskService;
use App\Services\User\UserService;
use App\Services\Time\TimeBlockService;
use App\Services\Time\TimerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->facades();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PomodoroSessionResource::withoutWrapping();
    }

    private function facades(): void
    {
        $this->app->bind('user.facade', UserService::class);
        $this->app->bind('auth.facade', AuthService::class);
        $this->app->bind('task.facade', TaskService::class);
        $this->app->bind('timeBlock.facade', TimeBlockService::class);
        $this->app->bind('timer.facade', TimerService::class);
    }
}