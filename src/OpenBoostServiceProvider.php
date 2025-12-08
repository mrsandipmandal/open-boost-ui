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
        Blade::component('boost::components.dropdown', 'boost-dropdown');
        Blade::component('boost::components.modal', 'boost-modal');
        Blade::component('boost::components.select', 'boost-select');
        Blade::component('boost::components.datepicker', 'boost-datepicker');
        Blade::component('boost::components.chart', 'boost-chart');
        Blade::component('boost::components.editor', 'boost-editor');
    }
}
