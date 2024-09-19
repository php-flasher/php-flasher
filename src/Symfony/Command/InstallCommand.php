<?php

declare(strict_types=1);

namespace Flasher\Symfony\Command;

use Flasher\Prime\Asset\AssetManagerInterface;
use Flasher\Prime\Plugin\PluginInterface;
use Flasher\Symfony\Support\PluginBundleInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

final class InstallCommand extends Command
{
    public function __construct(private readonly AssetManagerInterface $assetManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('flasher:install')
            ->setDescription('Installs all <fg=blue;options=bold>PHPFlasher</> resources to the <comment>public</comment> and <comment>config</comment> directories.')
            ->setHelp('The command copies <fg=blue;options=bold>PHPFlasher</> assets to <comment>public/vendor/flasher/</comment> directory and config files to the <comment>config/packages/</comment> directory without overwriting any existing config files.')
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

        $application = $this->getApplication();
        if (!$application instanceof Application) {
            return self::SUCCESS;
        }

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

        $publicDir = $this->getPublicDir().'/vendor/flasher/';
        $configDir = $this->getConfigDir();

        $filesystem = new Filesystem();
        $filesystem->remove($publicDir);
        $filesystem->mkdir($publicDir);

        $files = [];
        $exitCode = self::SUCCESS;

        $kernel = $application->getKernel();
        foreach ($kernel->getBundles() as $bundle) {
            if (!$bundle instanceof PluginBundleInterface) {
                continue;
            }

            $plugin = $bundle->createPlugin();
            $configFile = $bundle->getConfigurationFile();

            try {
                $files[] = $this->publishAssets($plugin, $publicDir, $useSymlinks);

                if ($publishConfig) {
                    $this->publishConfig($plugin, $configDir, $configFile);
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

            if ($useSymlinks) {
                $filesystem->symlink($file->getRealPath(), $targetPath);
            } else {
                $filesystem->copy($file->getRealPath(), $targetPath, true);
            }

            $files[] = $targetPath;
        }

        return $files;
    }

    private function publishConfig(PluginInterface $plugin, ?string $configDir, string $configFile): void
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

    private function getPublicDir(): ?string
    {
        $projectDir = $this->getProjectDir();
        if (null === $projectDir) {
            return null;
        }

        $publicDir = rtrim($projectDir, '/').'/public';

        if (is_dir($publicDir)) {
            return $publicDir;
        }

        return $this->getComposerDir('public-dir');
    }

    private function getConfigDir(): ?string
    {
        $projectDir = $this->getProjectDir();

        if (null === $projectDir) {
            return null;
        }

        $configDir = rtrim($projectDir, '/').'/config/packages/';

        if (is_dir($configDir)) {
            return $configDir;
        }

        return $this->getComposerDir('config-dir');
    }

    private function getProjectDir(): ?string
    {
        $kernel = $this->getKernel();

        if (null === $kernel) {
            return null;
        }

        $container = $kernel->getContainer();

        $projectDir = $container->getParameter('kernel.project_dir');

        return \is_string($projectDir) ? $projectDir : null;
    }

    private function getComposerDir(string $dir): ?string
    {
        $projectDir = $this->getProjectDir();

        if (null === $projectDir) {
            return null;
        }

        $composerFilePath = $projectDir.'/composer.json';

        if (!file_exists($composerFilePath)) {
            return null;
        }

        /** @var array{extra: array{string, string}} $composerConfig */
        $composerConfig = json_decode(file_get_contents($composerFilePath) ?: '', true);

        return $composerConfig['extra'][$dir] ?? null;
    }

    private function getKernel(): ?KernelInterface
    {
        $application = $this->getApplication();

        if (!$application instanceof Application) {
            return null;
        }

        return $application->getKernel();
    }
}
