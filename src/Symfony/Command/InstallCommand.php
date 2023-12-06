<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Command;

use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Bridge\Bridge;
use Flasher\Symfony\Bridge\Command\FlasherCommand;
use Flasher\Symfony\Support\Bundle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

class InstallCommand extends FlasherCommand
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('flasher:install')
            ->setDescription('Installs all <fg=blue;options=bold>PHPFlasher</> resources to the <comment>public</comment> and <comment>config</comment> directories.')
            ->setHelp('The command copies <fg=blue;options=bold>PHPFlasher</> assets to <comment>public/vendor/flasher/</comment> directory and config files to the <comment>config/packages/</comment> directory without overwriting any existing config files.');
    }

    /**
     * @return int
     */
    protected function flasherExecute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<fg=blue;options=bold>
            ██████╗ ██╗  ██╗██████╗ ███████╗██╗      █████╗ ███████╗██╗  ██╗███████╗██████╗
            ██╔══██╗██║  ██║██╔══██╗██╔════╝██║     ██╔══██╗██╔════╝██║  ██║██╔════╝██╔══██╗
            ██████╔╝███████║██████╔╝█████╗  ██║     ███████║███████╗███████║█████╗  ██████╔╝
            ██╔═══╝ ██╔══██║██╔═══╝ ██╔══╝  ██║     ██╔══██║╚════██║██╔══██║██╔══╝  ██╔══██╗
            ██║     ██║  ██║██║     ██║     ███████╗██║  ██║███████║██║  ██║███████╗██║  ██║
            ╚═╝     ╚═╝  ╚═╝╚═╝     ╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
        </>');
        $output->writeln('');

        $output->writeln('');
        $output->writeln('<bg=blue;options=bold> INFO </> Copying <fg=blue;options=bold>PHPFlasher</> resources...');
        $output->writeln('');

        $publicDir = $this->getPublicDir().'/vendor/flasher/';
        $configDir = $this->getConfigDir();
        $exitCode = 0;

        /** @var KernelInterface $kernel */
        $kernel = $this->getApplication()->getKernel();
        foreach ($kernel->getBundles() as $bundle) {
            if (!$bundle instanceof Bundle) {
                continue;
            }

            $plugin = $bundle->createPlugin();
            $configFile = $bundle->getConfigurationFile();

            try {
                $this->publishAssets($plugin, $publicDir);
                $this->publishConfig($plugin, $configDir, $configFile);

                $status = sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */);
                $output->writeln(sprintf(' %s <fg=blue;options=bold>%s</>', $status, $plugin->getAlias()));
            } catch (\Exception $e) {
                $exitCode = 1;
                $status = sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */);
                $output->writeln(sprintf(' %s <fg=blue;options=bold>%s</> <error>%s</error>', $status, $plugin->getAlias(), $e->getMessage()));
            }
        }

        $output->writeln('');

        if (0 === $exitCode) {
            $output->writeln('<bg=green;options=bold> SUCCESS </> <fg=blue;options=bold>PHPFlasher</> resources have been successfully installed.');
        } else {
            $output->writeln('<bg=red;options=bold> ERROR </> An error occurred during the installation of <fg=blue;options=bold>PHPFlasher</> resources.');
        }

        $output->writeln('');

        return $exitCode;
    }

    /**
     * @param string|null $publicDir
     *
     * @return void
     */
    private function publishAssets(PluginInterface $plugin, $publicDir)
    {
        if (null === $publicDir) {
            return;
        }

        $originDir = $plugin->getAssetsDir();

        if (!is_dir($originDir)) {
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->mkdir($originDir, 0777);
        $filesystem->mirror($originDir, $publicDir, Finder::create()->ignoreDotFiles(false)->in($originDir));
    }

    /**
     * @param string|null $configDir
     * @param string      $configFile
     *
     * @return void
     */
    private function publishConfig(PluginInterface $plugin, $configDir, $configFile)
    {
        if (null === $configDir || !file_exists($configFile)) {
            return;
        }

        $target = $configDir.$plugin->getName().'.yaml';
        if (file_exists($target)) {
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->copy($configFile, $target);
    }

    /**
     * @return string|null
     */
    private function getPublicDir()
    {
        $projectDir = $this->getProjectDir();

        $publicDir = Bridge::versionCompare('4', '>=') ? '/public' : '/web';
        $publicDir = rtrim($projectDir, '/').$publicDir;

        if (is_dir($publicDir)) {
            return $publicDir;
        }

        return $this->getComposerDir('public-dir');
    }

    /**
     * @return string|null
     */
    private function getConfigDir()
    {
        $projectDir = $this->getProjectDir();

        $configDir = Bridge::versionCompare('4', '>=') ? '/config/packages/' : '/config';
        $configDir = rtrim($projectDir, '/').$configDir;

        if (is_dir($configDir)) {
            return $configDir;
        }

        return $this->getComposerDir('config-dir');
    }

    /**
     * @return string
     */
    private function getProjectDir()
    {
        /** @var Container $container */
        $container = $this->getApplication()->getKernel()->getContainer();

        return $container->hasParameter('kernel.project_dir')
            ? $container->getParameter('kernel.project_dir')
            : $container->getParameter('kernel.root_dir').'/../';
    }

    /**
     * @return string|null
     */
    private function getComposerDir($dir)
    {
        $projectDir = $this->getProjectDir();

        $composerFilePath = $projectDir.'/composer.json';

        if (!file_exists($composerFilePath)) {
            return null;
        }

        $composerConfig = json_decode(file_get_contents($composerFilePath), true);

        return isset($composerConfig['extra'][$dir]) ? $composerConfig['extra'][$dir] : null;
    }
}
