<?php
namespace OpenBoost\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    /** @var Composer */
    private $composer;

    /** @var IOInterface */
    private $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;

        $argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : [];

        // Determine whether we should download/configure resources into the package
        $shouldInstall = false;

        // 1) CLI flags (backward compat)
        if (in_array('--resources', $argv, true) || in_array('-r', $argv, true)) {
            $shouldInstall = true;
        }

        // 2) Environment variable
        if (!$shouldInstall && getenv('OPENBOOST_RESOURCES')) {
            $shouldInstall = true;
        }

        // 3) Consuming project's composer.json extra config
        if (!$shouldInstall) {
            try {
                $rootPackage = $composer->getPackage();
                $extra = $rootPackage ? $rootPackage->getExtra() : [];
                if (isset($extra['open-boost']['install_resources']) && $extra['open-boost']['install_resources']) {
                    $shouldInstall = true;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // 4) Interactive prompt: ask user if Composer is interactive
        if (!$shouldInstall && $this->io->isInteractive()) {
            $question = 'OpenBoost: do you want to download resources? [Y/N] ';
            try {
                $confirm = $this->io->askConfirmation($question, false);
            } catch (\Throwable $e) {
                $answer = $this->io->ask($question, 'n');
                $confirm = in_array(strtolower(trim($answer)), ['y', 'yes'], true);
            }

            if ($confirm) {
                $shouldInstall = true;
            } else {
                $this->io->write('<comment>OpenBoost: skipping resource download.</comment>');
            }
        }

        if ($shouldInstall) {
            $this->io->write('<info>OpenBoost:</info> downloading and configuring resources into package...');
            try {
                $this->downloadAndConfigureResources();
            } catch (\Exception $e) {
                $this->io->writeError('<error>OpenBoost: failed to download resources:</error> ' . $e->getMessage());
            }
        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // no-op
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // no-op
    }

    private function downloadAndConfigureResources()
    {
        // Download frontend assets into THIS PACKAGE's resources/assets/ directory
        $pkgRoot = dirname(__DIR__, 2);
        $assetsDir = $pkgRoot . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';

        if (!is_dir($assetsDir)) {
            @mkdir($assetsDir, 0755, true);
        }

        // List of frontend libraries with their typical asset files
        $libraries = [
            'jquery' => ['jquery.min.js', 'jquery.js'],
            'select2' => ['select2.min.js', 'select2.min.css', 'select2.js', 'select2.css'],
            'choices.js' => ['choices.min.js', 'choices.min.css'],
            'flatpickr' => ['flatpickr.min.js', 'flatpickr.css', 'flatpickr.js'],
            'chart.js' => ['chart.min.js', 'chart.js'],
            'apexcharts' => ['apexcharts.min.js', 'apexcharts.css'],
            'quill' => ['quill.min.js', 'quill.snow.css', 'quill.js'],
            'simplemde' => ['simplemde.min.js', 'simplemde.min.css'],
            'trix' => ['trix.js', 'trix.css'],
            'datatables.net' => ['datatables.min.js', 'datatables.min.css'],
        ];

        $this->io->write('<info>OpenBoost:</info> configuring asset directories...');

        foreach ($libraries as $libName => $files) {
            $libDir = $assetsDir . DIRECTORY_SEPARATOR . $libName;
            if (!is_dir($libDir)) {
                @mkdir($libDir, 0755, true);
            }

            foreach ($files as $file) {
                $filePath = $libDir . DIRECTORY_SEPARATOR . $file;
                if (!is_file($filePath)) {
                    // Create placeholder with description
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ext === 'js') {
                        $content = "/* " . ucfirst($libName) . " - " . $file . " */\n// Add library content here\n";
                    } elseif ($ext === 'css') {
                        $content = "/* " . ucfirst($libName) . " - " . $file . " */\n/* Add library styles here */\n";
                    } else {
                        $content = "";
                    }
                    @file_put_contents($filePath, $content);
                }
            }
        }

        $this->io->write('<info>OpenBoost:</info> resources configured at ' . $assetsDir);
    }
}
