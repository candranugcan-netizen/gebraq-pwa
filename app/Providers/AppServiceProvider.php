<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Jika ada variabel PUBLIC_PATH di file .env, gunakan jalur tersebut
        if (env('PUBLIC_PATH')) {
            $this->app->usePublicPath(base_path(env('PUBLIC_PATH')));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
