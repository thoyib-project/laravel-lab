<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Laravel\Passport\Passport;  //import Passport here

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
            // $this->app->register(Barryvdh\Debugbar\ServiceProvider::class);
        }
        // Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
