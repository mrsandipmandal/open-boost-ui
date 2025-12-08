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

        // Determine whether we should install/copy resources.
        // Prefer explicit env var or composer extra flag in the consuming project.
        $shouldInstall = false;

        // 1) Old behavior: CLI flags (kept for backward compat when possible)
        if (in_array('--resources', $argv, true) || in_array('-r', $argv, true)) {
            $shouldInstall = true;
        }

        // 2) Environment variable: set OPENBOOST_RESOURCES=1 to enable
        if (!$shouldInstall && getenv('OPENBOOST_RESOURCES')) {
            $shouldInstall = true;
        }

        // 3) Consuming project's composer.json extra config: extra.open-boost.install_resources = true
        if (!$shouldInstall) {
            try {
                $rootPackage = $composer->getPackage();
                $extra = $rootPackage ? $rootPackage->getExtra() : [];
                if (isset($extra['open-boost']['install_resources']) && $extra['open-boost']['install_resources']) {
                    $shouldInstall = true;
                }
            } catch (\Throwable $e) {
                // ignore - not critical
            }
        }

        // If still undecided and Composer is interactive, prompt the user
        if (!$shouldInstall && $this->io->isInteractive()) {
            $question = 'OpenBoost: do you want to install frontend resources now? (y/N) ';
            try {
                $confirm = $this->io->askConfirmation($question, false);
            } catch (\Throwable $e) {
                $answer = $this->io->ask($question, 'n');
                $confirm = in_array(strtolower(trim($answer)), ['y', 'yes'], true);
            }

            if ($confirm) {
                $shouldInstall = true;
            } else {
                $this->io->write('<comment>OpenBoost: skipping resource installation per user response.</comment>');
            }
        }

        if ($shouldInstall) {
            $this->io->write('<info>OpenBoost:</info> installing resources (flag/env/config detected).');
            try {
                $this->publishResources();
                $this->installConfiguredPackages();
            } catch (\Exception $e) {
                $this->io->writeError('<error>OpenBoost: failed to install resources:</error> ' . $e->getMessage());
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

    private function publishResources()
    {
        $vendorDir = $this->composer->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendorDir);

        // package resources directory (two levels up from this file)
        $pkgResources = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'resources';

        if (!is_dir($pkgResources)) {
            $this->io->write('<comment>OpenBoost: no packaged resources directory found, skipping copy.</comment>');
            return;
        }

        $dest = $projectRoot . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'open-boost';

        $this->recursiveCopy($pkgResources, $dest);

        $this->io->write(sprintf('<info>OpenBoost:</info> resources copied to %s', $dest));
    }

    private function installConfiguredPackages()
    {
        // Read resource packages from the OpenBoost package's own composer.json, not the consuming project's
        $vendorDir = $this->composer->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendorDir);
        $pkgComposer = $vendorDir . DIRECTORY_SEPARATOR . 'open-boost' . DIRECTORY_SEPARATOR . 'open-boost-ui' . DIRECTORY_SEPARATOR . 'composer.json';

        // If vendor path doesn't exist yet (early activation), try local package root
        if (!is_file($pkgComposer)) {
            $pkgComposer = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'composer.json';
        }

        $pkgs = [];
        if (is_file($pkgComposer)) {
            $json = json_decode(file_get_contents($pkgComposer), true);
            if (isset($json['extra']['open-boost']['resource_packages']) && is_array($json['extra']['open-boost']['resource_packages'])) {
                $pkgs = $json['extra']['open-boost']['resource_packages'];
            }
        }

        if (count($pkgs) === 0) {
            $this->io->write('<comment>OpenBoost: no extra resource packages configured, skipping composer require.</comment>');
            return;
        }

        // Ensure Asset Packagist repository exists in consuming project's composer.json
        $consumerComposer = $projectRoot . DIRECTORY_SEPARATOR . 'composer.json';

        $needsAssetRepo = true;
        if (is_file($consumerComposer)) {
            $contents = @file_get_contents($consumerComposer);
            if ($contents !== false) {
                $json = json_decode($contents, true);
                if (isset($json['repositories']) && is_array($json['repositories'])) {
                    foreach ($json['repositories'] as $repo) {
                        if (isset($repo['url']) && strpos($repo['url'], 'asset-packagist.org') !== false) {
                            $needsAssetRepo = false;
                            break;
                        }
                    }
                }
            }
        }

        if ($needsAssetRepo) {
            if ($this->io->isInteractive()) {
                $this->io->write('<comment>OpenBoost: Asset Packagist is recommended to resolve npm-asset packages.</comment>');
                $addRepo = $this->io->askConfirmation('OpenBoost: add Asset Packagist repository to your composer.json now? (Y/n) ', true);
                if ($addRepo) {
                    // modify composer.json safely
                    if (is_file($consumerComposer)) {
                        $json = json_decode(@file_get_contents($consumerComposer), true) ?: [];
                    } else {
                        $json = [];
                    }
                    if (!isset($json['repositories']) || !is_array($json['repositories'])) {
                        $json['repositories'] = [];
                    }
                    $json['repositories'][] = [
                        'type' => 'composer',
                        'url' => 'https://asset-packagist.org'
                    ];
                    @file_put_contents($consumerComposer, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    $this->io->write('<info>OpenBoost:</info> added Asset Packagist repository to ' . $consumerComposer);
                } else {
                    $this->io->write('<comment>OpenBoost: will try to require packages but asset repository may be missing.</comment>');
                }
            } else {
                $this->io->write('<comment>OpenBoost: Asset Packagist repository not found; composer may not resolve npm-asset packages.</comment>');
            }
        }

        $escaped = array_map(function ($p) {
            return escapeshellarg($p);
        }, $pkgs);

        $cmd = 'composer require ' . implode(' ', $escaped) . ' --no-interaction';

        $this->io->write('<info>OpenBoost:</info> running: ' . $cmd);

        // execute command and stream output
        $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
        $process = proc_open($cmd, $descriptors, $pipes, null, null);
        if (is_resource($process)) {
            while ($line = fgets($pipes[1])) {
                $this->io->write($line);
            }
            while ($err = fgets($pipes[2])) {
                $this->io->writeError($err);
            }
            $status = proc_close($process);
            if ($status !== 0) {
                throw new \RuntimeException('composer require returned exit code ' . $status);
            }
        } else {
            throw new \RuntimeException('failed to run composer require process');
        }
    }

    private function recursiveCopy($src, $dst)
    {
        $src = rtrim($src, DIRECTORY_SEPARATOR);
        if (!is_dir($src)) {
            return;
        }

        if (!is_dir($dst)) {
            @mkdir($dst, 0755, true);
        }

        $items = scandir($src);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $s = $src . DIRECTORY_SEPARATOR . $item;
            $d = $dst . DIRECTORY_SEPARATOR . $item;
            if (is_dir($s)) {
                $this->recursiveCopy($s, $d);
            } else {
                if (!is_dir(dirname($d))) {
                    @mkdir(dirname($d), 0755, true);
                }
                @copy($s, $d);
            }
        }
    }
}
