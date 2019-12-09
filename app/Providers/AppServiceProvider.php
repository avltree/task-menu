<?php

namespace App\Providers;

use App\Services\MenuRegistry\MenuRegistry;
use App\Services\MenuRegistry\SimpleEloquentMenuRegistry;
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
        $this->app->singleton(MenuRegistry::class, function () {
            return new SimpleEloquentMenuRegistry();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
