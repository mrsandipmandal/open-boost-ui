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

        // Register Blade components (using the correct namespace for views/components/openBoost/)
        // Original components
        Blade::component('boost::components.openBoost.dropdown', 'openBoost-dropdown');
        Blade::component('boost::components.openBoost.modal', 'openBoost-modal');
        Blade::component('boost::components.openBoost.select', 'openBoost-select');
        Blade::component('boost::components.openBoost.datepicker', 'openBoost-datepicker');
        Blade::component('boost::components.openBoost.chart', 'openBoost-chart');
        Blade::component('boost::components.openBoost.editor', 'openBoost-editor');

        // New Alpine.js-style components
        Blade::component('boost::components.openBoost.accordion', 'openBoost-accordion');
        Blade::component('boost::components.openBoost.accordionItem', 'openBoost-accordionItem');
        Blade::component('boost::components.openBoost.carousel', 'openBoost-carousel');
        Blade::component('boost::components.openBoost.carouselSlide', 'openBoost-carouselSlide');
        Blade::component('boost::components.openBoost.tabs', 'openBoost-tabs');
        Blade::component('boost::components.openBoost.tab', 'openBoost-tab');
        Blade::component('boost::components.openBoost.radioGroup', 'openBoost-radioGroup');
        Blade::component('boost::components.openBoost.radio', 'openBoost-radio');
        Blade::component('boost::components.openBoost.toggle', 'openBoost-toggle');
        Blade::component('boost::components.openBoost.tooltip', 'openBoost-tooltip');
        Blade::component('boost::components.openBoost.notification', 'openBoost-notification');
        Blade::component('boost::components.openBoost.datatable', 'openBoost-datatable');
        Blade::component('boost::components.openBoost.list', 'openBoost-list');
        Blade::component('boost::components.openBoost.listItem', 'openBoost-listItem');

        // Keep backward compatibility aliases
        Blade::component('boost::components.openBoost.dropdown', 'boost-dropdown');
        Blade::component('boost::components.openBoost.modal', 'boost-modal');
        Blade::component('boost::components.openBoost.select', 'boost-select');
        Blade::component('boost::components.openBoost.datepicker', 'boost-datepicker');
        Blade::component('boost::components.openBoost.chart', 'boost-chart');
        Blade::component('boost::components.openBoost.editor', 'boost-editor');

        // Register Blade directives for asset injection
        Blade::directive('openBoostAssets', function () {
            return "<?php echo \\OpenBoost\\UI\\Services\\AssetManager::getCSSLinks(); ?>";
        });

        Blade::directive('openBoostScripts', function () {
            $html = "<?php \$js = \\OpenBoost\\UI\\Services\\AssetManager::getJSScripts() . \\OpenBoost\\UI\\Services\\AssetManager::getInitScript(); ?>";
            $html .= "<?php echo \$js; ?>";
            return $html;
        });
    }
}
