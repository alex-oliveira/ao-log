<?php

namespace AoLogs;

use AoLogs\Utils\Facades\AoLogsFacade;
use Illuminate\Support\ServiceProvider as LaraServiceProvider;

class ServiceProvider extends LaraServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Utils/Migrations' => database_path('migrations'),
        ]);
    }

    public function register()
    {
        $this->app->singleton('AoLogs', function ($app) {
            return new \AoLogs\Utils\Tools();
        });

        require_once(__DIR__ . '/Utils/Helpers.php');
    }

}