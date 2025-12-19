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
     * Falls back to CDN links if local published assets are missing
     */
    public static function getCSSLinks()
    {
        $html = '';

        $assetMap = [
            'select2' => ['assets/select2/select2.min.css'],
            'choices' => ['assets/choices.js/choices.min.css'],
            'flatpickr' => ['assets/flatpickr/flatpickr.min.css', 'assets/flatpickr/flatpickr.css'],
            'quill' => ['assets/quill/quill.snow.css'],
            'simplemde' => ['assets/simplemde/simplemde.min.css'],
            'trix' => ['assets/trix/trix.css'],
            'apexcharts' => ['assets/apexcharts/apexcharts.css'],
            'datatables' => ['assets/datatables.net/jquery.dataTables.min.css'],
        ];

        // CDN fallbacks for common libraries when local files are not published
        $cdnMap = [
            'select2' => [
                'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css']
            ],
            'choices' => [
                'css' => ['https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css']
            ],
            'flatpickr' => [
                'css' => ['https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css']
            ],
            'quill' => [
                'css' => ['https://cdn.jsdelivr.net/npm/quill/dist/quill.snow.css']
            ],
            'simplemde' => [
                'css' => ['https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.css']
            ],
            'trix' => [
                'css' => ['https://cdn.jsdelivr.net/npm/trix/dist/trix.css']
            ],
            'datatables' => [
                'css' => ['https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css']
            ],
        ];

        $basePath = public_path('vendor/open-boost/');

        foreach (self::$requiredAssets as $library) {
            if (isset($assetMap[$library])) {
                foreach ($assetMap[$library] as $css) {
                    $localPath = $basePath . $css;
                    $localFileLoaded = false;
                    
                    // Try to load from local first
                    if (is_file($localPath) && filesize($localPath) > 200) {
                        $html .= '<link href="' . asset('vendor/open-boost/' . $css) . '" rel="stylesheet">' . "\n";
                        $localFileLoaded = true;
                    }
                    
                    // If local file wasn't loaded, try CDN fallback
                    if (!$localFileLoaded && isset($cdnMap[$library]['css'])) {
                        foreach ($cdnMap[$library]['css'] as $cdnCss) {
                            $html .= '<link href="' . $cdnCss . '" rel="stylesheet">' . "\n";
                        }
                    }
                }
            }
        }

        return $html;
    }

    /**
     * Get JavaScript tags for required assets
     * Falls back to CDN links if local published assets are missing
     */
    public static function getJSScripts()
    {
        $html = '';

        $basePath = public_path('vendor/open-boost/');

        // CDN fallbacks for common libraries
        $cdnMap = [
            'jquery' => [
                'js' => ['https://code.jquery.com/jquery-3.6.0.min.js']
            ],
            'select2' => [
                'js' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js']
            ],
            'choices' => [
                'js' => ['https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js']
            ],
            'flatpickr' => [
                'js' => ['https://cdn.jsdelivr.net/npm/flatpickr']
            ],
            'chartjs' => [
                'js' => ['https://cdn.jsdelivr.net/npm/chart.js']
            ],
            'apexcharts' => [
                'js' => ['https://cdn.jsdelivr.net/npm/apexcharts']
            ],
            'quill' => [
                'js' => ['https://cdn.jsdelivr.net/npm/quill/dist/quill.min.js']
            ],
            'simplemde' => [
                'js' => ['https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.js']
            ],
            'trix' => [
                'js' => ['https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js']
            ],
            'datatables' => [
                'js' => ['https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js']
            ],
        ];

        // Ensure jQuery is available (local if published, otherwise CDN)
        if (!empty(self::$requiredAssets)) {
            $localJq = $basePath . 'assets/jquery/jquery.min.js';
            // prefer CDN when local jQuery is a very small placeholder file
            if (is_file($localJq) && filesize($localJq) > 200) {
                $html .= '<script src="' . asset('vendor/open-boost/assets/jquery/jquery.min.js') . '"></script>' . "\n";
            } elseif (isset($cdnMap['jquery']['js'])) {
                foreach ($cdnMap['jquery']['js'] as $cdn) {
                    $html .= '<script src="' . $cdn . '"></script>' . "\n";
                }
            }
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
                    $localPath = $basePath . $js;
                    $localFileLoaded = false;
                    
                    // Try to load from local first
                    if (is_file($localPath) && filesize($localPath) > 200) {
                        $html .= '<script src="' . asset('vendor/open-boost/' . $js) . '"></script>' . "\n";
                        $localFileLoaded = true;
                    }
                    
                    // If local file wasn't loaded, try CDN fallback
                    if (!$localFileLoaded && isset($cdnMap[$library]['js'])) {
                        foreach ($cdnMap[$library]['js'] as $cdnJs) {
                            $html .= '<script src="' . $cdnJs . '"></script>' . "\n";
                        }
                    }
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

    /**
     * Get CSS link tags for a specific library (with CDN fallback)
     */
    public static function getCSSFor(string $library)
    {
        $assetMap = [
            'select2' => ['assets/select2/select2.min.css'],
            'choices' => ['assets/choices.js/choices.min.css'],
            'flatpickr' => ['assets/flatpickr/flatpickr.min.css', 'assets/flatpickr/flatpickr.css'],
            'quill' => ['assets/quill/quill.snow.css'],
            'simplemde' => ['assets/simplemde/simplemde.min.css'],
            'trix' => ['assets/trix/trix.css'],
            'apexcharts' => ['assets/apexcharts/apexcharts.css'],
            'datatables' => ['assets/datatables.net/jquery.dataTables.min.css'],
        ];

        $cdnMap = [
            'select2' => [
                'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css']
            ],
            'choices' => [
                'css' => ['https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css']
            ],
            'flatpickr' => [
                'css' => ['https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css']
            ],
            'quill' => [
                'css' => ['https://cdn.jsdelivr.net/npm/quill/dist/quill.snow.css']
            ],
            'simplemde' => [
                'css' => ['https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.css']
            ],
            'trix' => [
                'css' => ['https://cdn.jsdelivr.net/npm/trix/dist/trix.css']
            ],
            'datatables' => [
                'css' => ['https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css']
            ],
        ];

        $html = '';
        $basePath = public_path('vendor/open-boost/');

        if (isset($assetMap[$library])) {
            foreach ($assetMap[$library] as $css) {
                $localPath = $basePath . $css;
                $localFileLoaded = false;
                
                // Try to load from local first
                if (is_file($localPath) && filesize($localPath) > 200) {
                    $html .= '<link href="' . asset('vendor/open-boost/' . $css) . '" rel="stylesheet">' . "\n";
                    $localFileLoaded = true;
                }
                
                // If local file wasn't loaded, try CDN fallback
                if (!$localFileLoaded && isset($cdnMap[$library]['css'])) {
                    foreach ($cdnMap[$library]['css'] as $cdnCss) {
                        $html .= '<link href="' . $cdnCss . '" rel="stylesheet">' . "\n";
                    }
                }
            }
        }

        return $html;
    }

    /**
     * Get JS script tags for a specific library (with CDN fallback)
     */
    public static function getJSFor(string $library)
    {
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

        $cdnMap = [
            'select2' => [
                'js' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js']
            ],
            'choices' => [
                'js' => ['https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js']
            ],
            'flatpickr' => [
                'js' => ['https://cdn.jsdelivr.net/npm/flatpickr']
            ],
            'chartjs' => [
                'js' => ['https://cdn.jsdelivr.net/npm/chart.js']
            ],
            'apexcharts' => [
                'js' => ['https://cdn.jsdelivr.net/npm/apexcharts']
            ],
            'quill' => [
                'js' => ['https://cdn.jsdelivr.net/npm/quill/dist/quill.min.js']
            ],
            'simplemde' => [
                'js' => ['https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.js']
            ],
            'trix' => [
                'js' => ['https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js']
            ],
            'datatables' => [
                'js' => ['https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js']
            ],
        ];

        $html = '';
        $basePath = public_path('vendor/open-boost/');

        if (isset($assetMap[$library])) {
            foreach ($assetMap[$library] as $js) {
                $localPath = $basePath . $js;
                if (is_file($localPath) && filesize($localPath) > 200) {
                    $html .= '<script src="' . asset('vendor/open-boost/' . $js) . '"></script>' . "\n";
                } elseif (isset($cdnMap[$library]['js'])) {
                    foreach ($cdnMap[$library]['js'] as $cdnJs) {
                        $html .= '<script src="' . $cdnJs . '"></script>' . "\n";
                    }
                }
            }
        }

        return $html;
    }
}
