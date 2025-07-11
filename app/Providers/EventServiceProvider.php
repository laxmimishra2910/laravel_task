<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
    }

       /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \App\Events\ProjectCreated::class => [
            \App\Listeners\SendProjectNotification::class,
        ],
    ];


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
