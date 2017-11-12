<?php

namespace AoLogs;

use AoLogs\Facades\AoLogsFacade;
use Illuminate\Support\ServiceProvider as LaraServiceProvider;

class ServiceProvider extends LaraServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'ao-logs');
    }

    public function register()
    {
        $this->app->singleton('AoLogs', function ($app) {
            return new \AoLogs\Tools();
        });

        require_once(__DIR__ . '/helpers.php');
    }

}