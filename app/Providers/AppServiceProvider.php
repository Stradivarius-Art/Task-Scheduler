<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Task\TaskService;
use App\Services\User\UserService;
use App\Services\Time\TimeBlockService;
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
        //
    }

    private function facades(): void
    {
        $this->app->bind('user.facade', UserService::class);
        $this->app->bind('auth.facade', AuthService::class);
        $this->app->bind('task.facade', TaskService::class);
        $this->app->bind('timeBlock.facade', TimeBlockService::class);
    }
}