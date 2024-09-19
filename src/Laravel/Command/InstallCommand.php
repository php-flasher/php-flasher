<?php

declare(strict_types=1);

namespace Flasher\Laravel\Command;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\Asset\AssetManagerInterface;
use Flasher\Prime\Plugin\PluginInterface;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

final class InstallCommand extends Command
{
    protected $description = 'Installs all <fg=blue;options=bold>PHPFlasher</> resources to the <comment>public</comment> and <comment>config</comment> directories.';

    public function __construct(private readonly AssetManagerInterface $assetManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('flasher:install')
            ->setDescription('Installs all <fg=blue;options=bold>PHPFlasher</> resources to the <comment>public</comment> and <comment>config</comment> directories.')
            ->setHelp('The command copies <fg=blue;options=bold>PHPFlasher</> assets to <comment>public/vendor/flasher/</comment> directory and config files to the <comment>config/</comment> directory without overwriting any existing config files.')
            ->addOption('config', 'c', InputOption::VALUE_NONE, 'Publish all config files to the <comment>config/packages/</comment> directory.')
            ->addOption('symlink', 's', InputOption::VALUE_NONE, 'Symlink <fg=blue;options=bold>PHPFlasher</> assets instead of copying them.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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

        $useSymlinks = (bool) $input->getOption('symlink');
        if ($useSymlinks) {
            $output->writeln('<info>Using symlinks to publish assets.</info>');
        } else {
            $output->writeln('<info>Copying assets to the public directory.</info>');
        }

        $publishConfig = (bool) $input->getOption('config');
        if ($publishConfig) {
            $output->writeln('<info>Publishing configuration files.</info>');
        }

        $publicDir = App::publicPath('/vendor/flasher/');

        $filesystem = new Filesystem();
        $filesystem->deleteDirectory($publicDir);
        $filesystem->makeDirectory($publicDir, recursive: true);

        $files = [];

        $exitCode = self::SUCCESS;

        foreach (array_keys(App::getLoadedProviders()) as $provider) {
            if (!is_a($provider, PluginServiceProvider::class, true)) {
                continue;
            }

            /** @var PluginServiceProvider $provider */
            $provider = App::getProvider($provider);
            $plugin = $provider->createPlugin();
            $configFile = $provider->getConfigurationFile();

            try {
                $files[] = $this->publishAssets($plugin, $publicDir, $useSymlinks);

                if ($publishConfig) {
                    $this->publishConfig($plugin, $configFile);
                }

                $status = \sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */);
                $output->writeln(\sprintf(' %s <fg=blue;options=bold>%s</>', $status, $plugin->getAlias()));
            } catch (\Exception $e) {
                $exitCode = self::FAILURE;
                $status = \sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */);
                $output->writeln(\sprintf(' %s <fg=blue;options=bold>%s</> <error>%s</error>', $status, $plugin->getAlias(), $e->getMessage()));
            }
        }

        $output->writeln('');

        if (self::SUCCESS === $exitCode) {
            $message = '<fg=blue;options=bold>PHPFlasher</> resources have been successfully installed.';
            if ($publishConfig) {
                $message .= ' Configuration files have been published.';
            }
            if ($useSymlinks) {
                $message .= ' Assets were symlinked.';
            }
            $output->writeln("<bg=green;options=bold> SUCCESS </> <fg=blue;options=bold>$message</>");
        } else {
            $output->writeln('<bg=red;options=bold> ERROR </> An error occurred during the installation of <fg=blue;options=bold>PHPFlasher</> resources.');
        }

        $this->assetManager->createManifest(array_merge([], ...$files));

        $output->writeln('');

        return $exitCode;
    }

    /**
     * @return string[]
     */
    private function publishAssets(PluginInterface $plugin, string $publicDir, bool $useSymlinks): array
    {
        $originDir = $plugin->getAssetsDir();

        if (!is_dir($originDir)) {
            return [];
        }

        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder->files()->in($originDir);

        $files = [];

        foreach ($finder as $file) {
            $relativePath = trim(str_replace($originDir, '', $file->getRealPath()), \DIRECTORY_SEPARATOR);
            $targetPath = $publicDir.$relativePath;

            $filesystem->makeDirectory(\dirname($targetPath), recursive: true, force: true);

            if ($useSymlinks) {
                $filesystem->link($file->getRealPath(), $targetPath);
            } else {
                $filesystem->copy($file->getRealPath(), $targetPath);
            }

            $files[] = $targetPath;
        }

        return $files;
    }

    private function publishConfig(PluginInterface $plugin, string $configFile): void
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
