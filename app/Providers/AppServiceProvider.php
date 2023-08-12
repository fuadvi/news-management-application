<?php

namespace App\Providers;

use App\Repository\Category\CategoryRepository;
use App\Repository\Category\ICategoryRepository;
use App\Repository\News\INewsRepository;
use App\Repository\News\NewsRepository;
use App\Repository\User\IUserRepository;
use App\Repository\User\UserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->singleton(ICategoryRepository::class, CategoryRepository::class);
        $this->app->singleton(INewsRepository::class, NewsRepository::class);
    }

    public function provides(): array
    {
        return [
            IUserRepository::class,
            ICategoryRepository::class,
            INewsRepository::class
        ];
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
