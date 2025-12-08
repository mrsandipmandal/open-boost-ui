<?php

namespace OpenBoost\UI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class OpenBoostServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/open-boost.php', 'open-boost');
        // Register Artisan commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \OpenBoost\UI\Console\InstallResourcesCommand::class,
            ]);
        }
    }

    public function boot()
    {
        // Load views from package
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'boost');

        // Publish config, JS, views, and assets
        $this->publishes([
            __DIR__ . '/../config/open-boost.php' => config_path('open-boost.php'),
        ], 'open-boost-ui');

        $this->publishes([
            __DIR__ . '/../resources/js' => public_path('vendor/open-boost/js'),
        ], 'open-boost-ui');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/open-boost/assets'),
        ], 'open-boost-ui');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/boost'),
        ], 'open-boost-ui');

        // Register Blade components (using the correct namespace for views/components/flash/)
        Blade::component('boost::components.flash.dropdown', 'flash-dropdown');
        Blade::component('boost::components.flash.modal', 'flash-modal');
        Blade::component('boost::components.flash.select', 'flash-select');
        Blade::component('boost::components.flash.datepicker', 'flash-datepicker');
        Blade::component('boost::components.flash.chart', 'flash-chart');
        Blade::component('boost::components.flash.editor', 'flash-editor');

        // Keep backward compatibility aliases
        Blade::component('boost::components.flash.dropdown', 'boost-dropdown');
        Blade::component('boost::components.flash.modal', 'boost-modal');
        Blade::component('boost::components.flash.select', 'boost-select');
        Blade::component('boost::components.flash.datepicker', 'boost-datepicker');
        Blade::component('boost::components.flash.chart', 'boost-chart');
        Blade::component('boost::components.flash.editor', 'boost-editor');
    }
}
