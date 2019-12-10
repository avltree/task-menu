<?php

namespace App\Providers;

use App\Events\MenuDeleting;
use App\Listeners\MenuDeletingListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MenuDeleting::class => [
            MenuDeletingListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
