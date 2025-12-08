<?php

namespace OpenBoost\UI\Services;

class AssetManager
{
    private static $loadedAssets = [];
    private static $requiredAssets = [];

    /**
     * Mark an asset library as required
     */
    public static function require($library)
    {
        if (!in_array($library, self::$requiredAssets)) {
            self::$requiredAssets[] = $library;
        }
    }

    /**
     * Check if a library is required
     */
    public static function isRequired($library)
    {
        return in_array($library, self::$requiredAssets);
    }

    /**
     * Get all required assets
     */
    public static function getRequired()
    {
        return self::$requiredAssets;
    }

    /**
     * Clear required assets
     */
    public static function clear()
    {
        self::$requiredAssets = [];
        self::$loadedAssets = [];
    }

    /**
     * Get CSS tags for required assets
     */
    public static function getCSSLinks()
    {
        $html = '';
        
        $assetMap = [
            'select2' => ['assets/select2/select2.min.css'],
            'choices' => ['assets/choices.js/choices.min.css'],
            'flatpickr' => ['assets/flatpickr/flatpickr.css'],
            'quill' => ['assets/quill/quill.snow.css'],
            'simplemde' => ['assets/simplemde/simplemde.min.css'],
            'trix' => ['assets/trix/trix.css'],
            'apexcharts' => ['assets/apexcharts/apexcharts.css'],
            'datatables' => ['assets/datatables.net/jquery.dataTables.min.css'],
        ];

        foreach (self::$requiredAssets as $library) {
            if (isset($assetMap[$library])) {
                foreach ($assetMap[$library] as $css) {
                    $html .= '<link href="' . asset('vendor/open-boost/' . $css) . '" rel="stylesheet">' . "\n";
                }
            }
        }

        return $html;
    }

    /**
     * Get JavaScript tags for required assets
     */
    public static function getJSScripts()
    {
        $html = '';
        
        // jQuery is always needed if any library is required
        if (!empty(self::$requiredAssets)) {
            $html .= '<script src="' . asset('vendor/open-boost/assets/jquery/jquery.min.js') . '"></script>' . "\n";
        }

        $assetMap = [
            'select2' => ['assets/select2/select2.min.js'],
            'choices' => ['assets/choices.js/choices.min.js'],
            'flatpickr' => ['assets/flatpickr/flatpickr.min.js'],
            'quill' => ['assets/quill/quill.min.js'],
            'simplemde' => ['assets/simplemde/simplemde.min.js'],
            'apexcharts' => ['assets/apexcharts/apexcharts.min.js'],
            'chartjs' => ['assets/chart.js/chart.min.js'],
            'datatables' => ['assets/datatables.net/jquery.dataTables.min.js'],
            'trix' => ['assets/trix/trix.js'],
        ];

        foreach (self::$requiredAssets as $library) {
            if (isset($assetMap[$library])) {
                foreach ($assetMap[$library] as $js) {
                    $html .= '<script src="' . asset('vendor/open-boost/' . $js) . '"></script>' . "\n";
                }
            }
        }

        return $html;
    }

    /**
     * Get the init script (loads last)
     */
    public static function getInitScript()
    {
        if (empty(self::$requiredAssets)) {
            return '';
        }

        return '<script src="' . asset('vendor/open-boost/js/open-boost-init.js') . '"></script>' . "\n";
    }
}
