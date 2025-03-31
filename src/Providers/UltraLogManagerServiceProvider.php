<?php

namespace Ultra\UltraLogManager\Providers;

use Illuminate\Session\SessionServiceProvider;
use Ultra\UltraLogManager\UltraLogManager;
use Illuminate\Support\ServiceProvider;

class UltraLogManagerServiceProvider extends SessionServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
               
        $this->mergeConfigFrom(__DIR__ . '/../../config/logging.php', 'logging');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Make the logging configuration publishable, so the users can override it if needed
        $this->publishes([
            __DIR__ . '/../../config/logging.php' => config_path('logging.php'),
        ]);
    }
}
