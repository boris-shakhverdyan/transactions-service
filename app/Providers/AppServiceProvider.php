<?php

namespace App\Providers;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use App\Contracts\Services\TransactionServiceInterface;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (app()->environment('production') && config('app.APP_SSL')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        $this->registerServices();

        $this->registerRepositories();
    }

    private function registerServices(): void
    {
        $this->registerSingletons([
            TransactionServiceInterface::class => TransactionService::class,
        ]);
    }

    private function registerRepositories(): void
    {
        $this->registerSingletons([
            TransactionRepositoryInterface::class => TransactionRepository::class,
        ]);
    }

    private function registerSingletons(array $singletons): void
    {
        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
