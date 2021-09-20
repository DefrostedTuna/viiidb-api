<?php

namespace App\Providers;

use App\Http\Middleware\CaptureInboundRequest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Contracts\Services\SeedRankService::class,
            \App\Services\SeedRankService::class
        );

        $this->app->bind(
            \App\Contracts\Services\SeedTestService::class,
            \App\Services\SeedTestService::class
        );

        $this->app->bind(
            \App\Contracts\Services\TestQuestionService::class,
            \App\Services\TestQuestionService::class
        );

        $this->app->singleton(CaptureInboundRequest::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
