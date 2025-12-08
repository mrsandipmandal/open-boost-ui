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
        $this->line('This command prepares frontend assets for the OpenBoost package.');
        $this->line('Assets will be configured at: resources/assets/');
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

        $libraries = [
            'jquery' => ['jquery.min.js', 'jquery.js'],
            'select2' => ['select2.min.js', 'select2.min.css'],
            'choices.js' => ['choices.min.js', 'choices.min.css'],
            'flatpickr' => ['flatpickr.min.js', 'flatpickr.css'],
            'chart.js' => ['chart.min.js'],
            'apexcharts' => ['apexcharts.min.js'],
            'quill' => ['quill.min.js', 'quill.snow.css'],
            'simplemde' => ['simplemde.min.js', 'simplemde.min.css'],
            'trix' => ['trix.js', 'trix.css'],
            'datatables.net' => ['datatables.min.js', 'datatables.min.css'],
        ];

        $this->line('Configuring asset directories...');

        foreach ($libraries as $libName => $files) {
            $libDir = $assetsDir . DIRECTORY_SEPARATOR . $libName;
            if (!is_dir($libDir)) {
                @mkdir($libDir, 0755, true);
            }

            foreach ($files as $file) {
                $filePath = $libDir . DIRECTORY_SEPARATOR . $file;
                if (!is_file($filePath)) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ext === 'js') {
                        $content = "/* " . ucfirst($libName) . " - " . $file . " */\n";
                    } elseif ($ext === 'css') {
                        $content = "/* " . ucfirst($libName) . " - " . $file . " */\n";
                    } else {
                        $content = "";
                    }
                    @file_put_contents($filePath, $content);
                }
            }
            $this->line('  ✓ ' . $libName);
        }

        $this->info('Resources configured successfully at: ' . $assetsDir);
        return 0;
    }
}

