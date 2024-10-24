<?php

namespace Fabio\UltraLogManager\Providers;

use Illuminate\Support\ServiceProvider;

class UltraLogManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/logging.php', 'logging');
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
            __DIR__ . '/../Config/logging.php' => config_path('logging.php'),
        ]);
    }
}
