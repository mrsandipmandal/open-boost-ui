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

    /** @var string */
    private $pluginPackageRoot;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;

        // Determine this plugin's actual root path in vendor
        // When running from vendor during composer install, __FILE__ points to vendor/.../src/Composer/Plugin.php
        // We need the vendor/open-boost/open-boost-ui directory
        $this->pluginPackageRoot = dirname(__FILE__, 3); // Go up from src/Composer/Plugin.php to package root

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
        // Download CDN assets into THIS PACKAGE's resources/assets/ directory
        // $this->pluginPackageRoot is the actual vendor/open-boost/open-boost-ui path
        $assetsDir = $this->pluginPackageRoot . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';

        if (!is_dir($assetsDir)) {
            @mkdir($assetsDir, 0755, true);
        }

        // Check for CDN configuration in composer extra (consuming project or this package)
        $cdnConfig = null;
        try {
            $rootPackage = $this->composer->getPackage();
            $rootExtra = $rootPackage ? $rootPackage->getExtra() : [];
            if (isset($rootExtra['open-boost']['resource_cdn']) && is_array($rootExtra['open-boost']['resource_cdn'])) {
                $cdnConfig = $rootExtra['open-boost']['resource_cdn'];
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Also check this package's composer.json as fallback
        if ($cdnConfig === null) {
            $pkgComposerFile = $this->pluginPackageRoot . DIRECTORY_SEPARATOR . 'composer.json';
            if (is_file($pkgComposerFile)) {
                $json = @json_decode(@file_get_contents($pkgComposerFile), true);
                if (isset($json['extra']['open-boost']['resource_cdn']) && is_array($json['extra']['open-boost']['resource_cdn'])) {
                    $cdnConfig = $json['extra']['open-boost']['resource_cdn'];
                }
            }
        }

        if (is_array($cdnConfig) && count($cdnConfig) > 0) {
            $this->io->write('<info>OpenBoost:</info> downloading CDN assets into package resources...');
            foreach ($cdnConfig as $libName => $urls) {
                $libDir = $assetsDir . DIRECTORY_SEPARATOR . $libName;
                if (!is_dir($libDir)) {
                    @mkdir($libDir, 0755, true);
                }
                if (!is_array($urls)) {
                    $urls = [$urls];
                }
                foreach ($urls as $url) {
                    $url = trim($url);
                    if ($url === '') {
                        continue;
                    }
                    $path = parse_url($url, PHP_URL_PATH);
                    $fileName = $path ? basename($path) : md5($url);
                    $destFilePath = $libDir . DIRECTORY_SEPARATOR . $fileName;

                    // Try to download via file_get_contents
                    $ctx = stream_context_create(['http' => ['timeout' => 15], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
                    $data = @file_get_contents($url, false, $ctx);
                    if ($data === false && function_exists('curl_version')) {
                        // Try cURL fallback with user-agent and follow redirects
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                        curl_setopt($ch, CURLOPT_USERAGENT, 'OpenBoostComposerPlugin/1.0 (+https://github.com/mrsandipmandal)');
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        $data = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        $curlErr = curl_error($ch);
                        curl_close($ch);
                        if ($data === false || $httpCode >= 400) {
                            $this->io->writeError("  <error>✗</error> Failed to download $url for $libName (curl: $curlErr, http: $httpCode)");
                        }
                    }

                    if ($data !== false) {
                        @file_put_contents($destFilePath, $data);
                        $this->io->write("  <comment>✓</comment> Downloaded $libName/$fileName from CDN");
                    } else {
                        $this->io->writeError("  <error>✗</error> Failed to download $url for $libName");
                        // fallback: placeholder
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        if ($ext === 'js') {
                            $content = "/* " . ucfirst($libName) . " - " . $fileName . " */\n// CDN download failed; placeholder created\n";
                        } elseif ($ext === 'css') {
                            $content = "/* " . ucfirst($libName) . " - " . $fileName . " */\n/* CDN download failed; placeholder created */\n";
                        } else {
                            $content = "";
                        }
                        @file_put_contents($destFilePath, $content);
                    }
                }
            }

            $this->io->write('<info>OpenBoost:</info> CDN resources configured at ' . $assetsDir);
            return;
        }

        // Fallback: if no CDN config, try to copy from vendor npm-asset packages (legacy behavior)
        $this->io->write('<info>OpenBoost:</info> CDN config not found; skipping asset download.');
        $this->io->write('<comment>Note:</comment> To enable CDN downloads, ensure composer.json has extra.open-boost.resource_cdn configured.');

        // Map npm-asset packages to library names and which files to copy
        $libraries = [
            'jquery' => [
                'source' => 'npm-asset/jquery/dist',
                'files' => ['jquery.min.js', 'jquery.js']
            ],
            'select2' => [
                'source' => 'npm-asset/select2/dist',
                'files' => ['js/select2.min.js', 'js/select2.js', 'css/select2.min.css', 'css/select2.css']
            ],
            'choices.js' => [
                'source' => 'npm-asset/choices.js',
                'files' => ['public/assets/scripts/choices.min.js', 'public/assets/styles/choices.min.css']
            ],
            'flatpickr' => [
                'source' => 'npm-asset/flatpickr/dist',
                'files' => ['flatpickr.min.js', 'flatpickr.js', 'flatpickr.min.css', 'flatpickr.css']
            ],
            'chart.js' => [
                'source' => 'npm-asset/chart.js/dist',
                'files' => ['chart.min.js', 'chart.js']
            ],
            'apexcharts' => [
                'source' => 'npm-asset/apexcharts/dist',
                'files' => ['apexcharts.min.js', 'apexcharts.css']
            ],
            'quill' => [
                'source' => 'npm-asset/quill/dist',
                'files' => ['quill.min.js', 'quill.js', 'quill.snow.css', 'quill.core.css']
            ],
            'simplemde' => [
                'source' => 'npm-asset/simplemde/dist',
                'files' => ['simplemde.min.js', 'simplemde.min.css']
            ],
            'trix' => [
                'source' => 'npm-asset/trix/dist',
                'files' => ['trix.js', 'trix.css']
            ],
            'datatables.net' => [
                'source' => 'npm-asset/datatables.net/js',
                'files' => ['jquery.dataTables.min.js', 'jquery.dataTables.js']
            ],
        ];

        $this->io->write('<info>OpenBoost:</info> configuring asset directories...');

        // Determine vendor path - could be in package itself or in consuming project
        $vendorPath = $this->findVendorPath();

        foreach ($libraries as $libName => $config) {
            $libDir = $assetsDir . DIRECTORY_SEPARATOR . $libName;
            if (!is_dir($libDir)) {
                @mkdir($libDir, 0755, true);
            }

            $sourcePath = $vendorPath . DIRECTORY_SEPARATOR . $config['source'];

            foreach ($config['files'] as $sourceFile) {
                $sourceFilePath = $sourcePath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $sourceFile);
                $destFileName = basename($sourceFile);
                $destFilePath = $libDir . DIRECTORY_SEPARATOR . $destFileName;

                // Copy from vendor if file exists, otherwise create placeholder
                if (is_file($sourceFilePath)) {
                    @copy($sourceFilePath, $destFilePath);
                    $this->io->write("  <comment>✓</comment> Copied $libName/$destFileName");
                } else {
                    // Create placeholder if source not found
                    $ext = pathinfo($sourceFile, PATHINFO_EXTENSION);
                    if ($ext === 'js') {
                        $content = "/* " . ucfirst($libName) . " - " . $destFileName . " */\n// Library placeholder - actual file not found\n";
                    } elseif ($ext === 'css') {
                        $content = "/* " . ucfirst($libName) . " - " . $destFileName . " */\n/* Library placeholder - actual file not found */\n";
                    } else {
                        $content = "";
                    }
                    @file_put_contents($destFilePath, $content);
                }
            }
        }

        $this->io->write('<info>OpenBoost:</info> resources configured at ' . $assetsDir);
    }

    private function findVendorPath()
    {
        // Try to find vendor directory
        $pkgRoot = dirname(__DIR__, 2);

        // First try: package's own vendor (if running in monorepo)
        $localVendor = $pkgRoot . DIRECTORY_SEPARATOR . 'vendor';
        if (is_dir($localVendor)) {
            return $localVendor;
        }

        // Second try: consuming project's vendor (typical case)
        $parentVendor = dirname($pkgRoot, 3) . DIRECTORY_SEPARATOR . 'vendor';
        if (is_dir($parentVendor)) {
            return $parentVendor;
        }

        // Fallback: try to use composer's vendor-dir config
        try {
            $config = $this->composer->getConfig();
            $vendorDir = $config->get('vendor-dir');
            if (is_dir($vendorDir)) {
                return $vendorDir;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Last resort: assume typical vendor location relative to package root
        return $pkgRoot . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor';
    }
}
