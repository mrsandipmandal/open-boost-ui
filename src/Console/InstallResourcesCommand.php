<?php
namespace OpenBoost\UI\Console;

use Illuminate\Console\Command;

class InstallResourcesCommand extends Command
{
    protected $signature = 'openboost:install-resources';
    protected $description = 'Download and configure OpenBoost frontend resources into the package';

    public function handle()
    {
        $this->info('OpenBoost Resource Installer');
        $this->line('');
        $this->line('This command downloads and configures frontend assets for the OpenBoost package.');
        $this->line('Assets will be downloaded to: resources/assets/');
        $this->line('');

        if (!$this->confirm('Do you want to download and configure resources now?', false)) {
            $this->line('Skipping resource configuration.');
            return 0;
        }

        $pkgRoot = dirname(__DIR__, 2);
        $assetsDir = $pkgRoot . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';

        if (!is_dir($assetsDir)) {
            @mkdir($assetsDir, 0755, true);
        }

        // CDN URLs for each library and file
        $libraries = [
            'jquery' => [
                'jquery.min.js' => 'https://code.jquery.com/jquery-3.6.0.min.js',
                'jquery.js' => 'https://code.jquery.com/jquery-3.6.0.js',
            ],
            'select2' => [
                'select2.min.js' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'select2.min.css' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            ],
            'choices.js' => [
                'choices.min.js' => 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js',
                'choices.min.css' => 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css',
            ],
            'flatpickr' => [
                'flatpickr.min.js' => 'https://cdn.jsdelivr.net/npm/flatpickr',
                'flatpickr.css' => 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            ],
            'chart.js' => [
                'chart.min.js' => 'https://cdn.jsdelivr.net/npm/chart.js',
            ],
            'apexcharts' => [
                'apexcharts.min.js' => 'https://cdn.jsdelivr.net/npm/apexcharts',
            ],
            'quill' => [
                'quill.min.js' => 'https://cdn.jsdelivr.net/npm/quill/dist/quill.min.js',
                'quill.snow.css' => 'https://cdn.jsdelivr.net/npm/quill/dist/quill.snow.css',
            ],
            'simplemde' => [
                'simplemde.min.js' => 'https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.js',
                'simplemde.min.css' => 'https://cdn.jsdelivr.net/npm/simplemde/dist/simplemde.min.css',
            ],
            'trix' => [
                'trix.js' => 'https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js',
                'trix.css' => 'https://cdn.jsdelivr.net/npm/trix/dist/trix.css',
            ],
            'datatables.net' => [
                'datatables.min.js' => 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js',
                'datatables.min.css' => 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css',
            ],
        ];

        $this->line('Downloading and configuring asset files...');

        foreach ($libraries as $libName => $files) {
            $libDir = $assetsDir . DIRECTORY_SEPARATOR . $libName;
            if (!is_dir($libDir)) {
                @mkdir($libDir, 0755, true);
            }

            foreach ($files as $file => $url) {
                $filePath = $libDir . DIRECTORY_SEPARATOR . $file;
                
                // Only download if file doesn't exist or is too small (placeholder)
                if (!is_file($filePath) || filesize($filePath) < 200) {
                    try {
                        $content = @file_get_contents($url);
                        if ($content === false || strlen($content) < 100) {
                            // CDN download failed, create placeholder
                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            $content = "/* " . ucfirst($libName) . " - " . $file . " - CDN Download Failed */\n";
                            $this->warn('  ⚠ ' . $libName . '/' . $file . ' (CDN download failed - placeholder created)');
                        } else {
                            $this->line('  ✓ ' . $libName . '/' . $file);
                        }
                        @file_put_contents($filePath, $content);
                    } catch (\Exception $e) {
                        // Fallback to placeholder
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $content = "/* " . ucfirst($libName) . " - " . $file . " - Error: " . $e->getMessage() . " */\n";
                        @file_put_contents($filePath, $content);
                        $this->warn('  ⚠ ' . $libName . '/' . $file . ' (error - placeholder created)');
                    }
                } else {
                    $this->line('  ✓ ' . $libName . '/' . $file . ' (already exists)');
                }
            }
        }

        $this->info('Resources configured successfully at: ' . $assetsDir);
        $this->line('Note: If any CDN downloads failed, CSS and JS will be loaded from CDN automatically.');
        return 0;
    }
}

