<?php

namespace OpenBoost\UI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class OpenBoostServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/open-boost.php', 'open-boost');
    }

    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'boost');

        // Publish config + assets
        $this->publishes([
            __DIR__ . '/../config/open-boost.php' => config_path('open-boost.php'),
        ], 'open-boost-ui');

        $this->publishes([
            __DIR__ . '/../resources/js' => resource_path('js/vendor/open-boost'),
        ], 'open-boost-ui');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/boost'),
        ], 'open-boost-ui');

        // Register Blade components
        Blade::component('flash::components.flash.dropdown', 'flash-dropdown');
        Blade::component('flash::components.flash.modal', 'flash-modal');
        Blade::component('flash::components.flash.select', 'flash-select');
        Blade::component('flash::components.flash.datepicker', 'flash-datepicker');
        Blade::component('flash::components.flash.chart', 'flash-chart');
        Blade::component('flash::components.flash.editor', 'flash-editor');
    }
}
