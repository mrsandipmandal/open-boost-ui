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

        if (in_array('--resources', $argv, true) || in_array('-r', $argv, true)) {
            $this->io->write('<info>OpenBoost:</info> --resources flag detected — installing resources.');
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
        $rootPackage = $this->composer->getPackage();
        $extra = $rootPackage->getExtra() ?: [];

        $pkgs = [];
        if (isset($extra['open-boost']['resource_packages']) && is_array($extra['open-boost']['resource_packages'])) {
            $pkgs = $extra['open-boost']['resource_packages'];
        }

        if (count($pkgs) === 0) {
            $this->io->write('<comment>OpenBoost: no extra resource packages configured, skipping composer require.</comment>');
            return;
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
