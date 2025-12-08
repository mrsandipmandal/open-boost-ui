<?php
namespace OpenBoost\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallResourcesCommand extends Command
{
    protected $signature = 'openboost:install-resources';
    protected $description = 'Interactive installer: copy bundled resources and install frontend packages used by OpenBoost';

    public function handle()
    {
        $this->info('OpenBoost resource installer');

        if (!$this->confirm('Do you want to install frontend resources and required libraries now?', false)) {
            $this->line('Skipping resource installation.');
            return 0;
        }

        $fs = new Filesystem();

        // Determine package root (two levels up from this file)
        $pkgRoot = dirname(__DIR__, 2);

        $pkgResources = $pkgRoot . DIRECTORY_SEPARATOR . 'resources';
        if (!is_dir($pkgResources)) {
            $this->error('No bundled resources found in package.');
            return 1;
        }

        // Copy resources to consuming project's resource path
        $dest = resource_path('js/vendor/open-boost');
        $this->line('Copying resources to ' . $dest);
        $fs->ensureDirectoryExists($dest);
        $fs->copyDirectory($pkgResources, $dest);
        $this->info('Resources copied.');

        // Read this package composer.json to get resource_packages
        $pkgComposer = $pkgRoot . DIRECTORY_SEPARATOR . 'composer.json';
        $packages = [];
        if (is_file($pkgComposer)) {
            $json = json_decode(file_get_contents($pkgComposer), true);
            if (isset($json['extra']['open-boost']['resource_packages']) && is_array($json['extra']['open-boost']['resource_packages'])) {
                $packages = $json['extra']['open-boost']['resource_packages'];
            }
        }

        if (count($packages) === 0) {
            $this->line('No configured frontend packages to require.');
            return 0;
        }

        // Ensure Asset Packagist repository exists in consumer composer.json
        $consumerComposer = base_path('composer.json');
        $needRepo = true;
        if (is_file($consumerComposer)) {
            $cjson = json_decode(file_get_contents($consumerComposer), true) ?: [];
            if (isset($cjson['repositories']) && is_array($cjson['repositories'])) {
                foreach ($cjson['repositories'] as $repo) {
                    if (isset($repo['url']) && strpos($repo['url'], 'asset-packagist.org') !== false) {
                        $needRepo = false;
                        break;
                    }
                }
            }
        }

        if ($needRepo && $this->confirm('Asset Packagist repository not found. Add https://asset-packagist.org to composer.json repositories? (recommended)', true)) {
            if (is_file($consumerComposer)) {
                $cjson = json_decode(file_get_contents($consumerComposer), true) ?: [];
            } else {
                $cjson = [];
            }
            if (!isset($cjson['repositories']) || !is_array($cjson['repositories'])) {
                $cjson['repositories'] = [];
            }
            $cjson['repositories'][] = [
                'type' => 'composer',
                'url' => 'https://asset-packagist.org'
            ];
            file_put_contents($consumerComposer, json_encode($cjson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info('Added Asset Packagist repository to composer.json');
        }

        // Run composer require for each package (single command)
        $this->line('Installing frontend packages via Composer...');
        $cmd = 'composer require ' . implode(' ', array_map('escapeshellarg', $packages));
        $this->line($cmd);

        // Execute and stream output
        $proc = proc_open($cmd, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
        if (is_resource($proc)) {
            while (!feof($pipes[1])) {
                $line = fgets($pipes[1]);
                if ($line !== false) $this->line(trim($line));
            }
            while (!feof($pipes[2])) {
                $err = fgets($pipes[2]);
                if ($err !== false) $this->error(trim($err));
            }
            $status = proc_close($proc);
            if ($status !== 0) {
                $this->error('composer require returned non-zero exit code: ' . $status);
                return 1;
            }
        } else {
            $this->error('Failed to run composer require.');
            return 1;
        }

        $this->info('Frontend packages installed.');
        return 0;
    }
}
