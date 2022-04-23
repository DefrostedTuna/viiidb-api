<?php

namespace App\Providers;

use App\Http\Middleware\CaptureInboundRequest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Contracts\Services\Search\SearchService::class,
            \App\Services\Search\MeilisearchService::class
        );

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

        $this->app->bind(
            \App\Contracts\Services\StatusEffectService::class,
            \App\Services\StatusEffectService::class
        );

        $this->app->bind(
            \App\Contracts\Services\ElementService::class,
            \App\Services\ElementService::class
        );

        $this->app->bind(
            \App\Contracts\Services\ItemService::class,
            \App\Services\ItemService::class
        );

        $this->app->singleton(CaptureInboundRequest::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
