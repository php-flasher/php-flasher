<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Command;

use Flasher\Laravel\Support\ServiceProvider as FlasherServiceProvider;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Laravel\Bridge\Command\FlasherCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->setHelp('The command copies <fg=blue;options=bold>PHPFlasher</> assets to <comment>public/vendor/flasher/</comment> directory and config files to the <comment>config/</comment> directory without overwriting any existing config files.');
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

        $publicDir = App::publicPath().'/vendor/flasher/';
        $exitCode = 0;

        foreach (ServiceProvider::publishableProviders() as $provider) {
            if (!is_a($provider, 'Flasher\Laravel\Support\ServiceProvider', true)) {
                continue;
            }

            /** @var FlasherServiceProvider $provider */
            $provider = App::getProvider($provider);
            $plugin = $provider->createPlugin();
            $configFile = $provider->getConfigurationFile();

            try {
                $this->publishAssets($plugin, $publicDir);
                $this->publishConfig($plugin, $configFile);

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
     * @param string $publicDir
     *
     * @return void
     */
    private function publishAssets(PluginInterface $plugin, $publicDir)
    {
        $originDir = $plugin->getAssetsDir();

        if (!is_dir($originDir)) {
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->ensureDirectoryExists($originDir, 0777);
        $filesystem->copyDirectory($originDir, $publicDir);
    }

    /**
     * @param string $configFile
     *
     * @return void
     */
    private function publishConfig(PluginInterface $plugin, $configFile)
    {
        if (!file_exists($configFile)) {
            return;
        }

        $target = App::configPath($plugin->getName().'.php');
        if (file_exists($target)) {
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->copy($configFile, $target);
    }
}
