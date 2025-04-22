<?php
namespace AlanRetubis\LaravelRete;

use Illuminate\Support\ServiceProvider;

class LaravelReteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-rete');
        $this->publishes([
            __DIR__.'/../config/rete.php' => config_path('rete.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/rete.php', 'rete');

        $this->app->singleton('rete-engine', function () {
            return new \AlanRetubis\LaravelRete\ReteEngine(); // Corrected namespace
        });
    }
}
