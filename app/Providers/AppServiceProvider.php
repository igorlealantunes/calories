<?php

namespace App\Providers;

use App\Modules\LLM\LLMDriver;
use App\Modules\LLM\OpenAIDriver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LLMDriver::class, OpenAIDriver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
