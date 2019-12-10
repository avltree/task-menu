<?php

namespace App\Providers;

use App\Services\ItemsFormatter\DefaultItemsFormatter;
use App\Services\ItemsFormatter\ItemsFormatter;
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
        $this->app->singleton(ItemsFormatter::class, function () {
            return new DefaultItemsFormatter();
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
