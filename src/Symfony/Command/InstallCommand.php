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

/**
 * InstallCommand - Console command for installing PHPFlasher resources.
 *
 * This command provides a CLI interface for installing PHPFlasher resources,
 * including assets (JS and CSS files) and configuration files. It discovers
 * all registered PHPFlasher plugins and installs their resources.
 *
 * Design patterns:
 * - Command Pattern: Implements the command pattern for console interaction
 * - Discovery Pattern: Automatically discovers and processes registered plugins
 * - Template Method Pattern: Defines a structured workflow with specific steps
 */
final class InstallCommand extends Command
{
    /**
     * Creates a new InstallCommand instance.
     *
     * @param AssetManagerInterface $assetManager Manager for handling PHPFlasher assets
     */
    public function __construct(private readonly AssetManagerInterface $assetManager)
    {
        parent::__construct();
    }

    /**
     * Configure the command options and help text.
     */
    protected function configure(): void
    {
        $this
            ->setName('flasher:install')
            ->setDescription('Installs all <fg=blue;options=bold>PHPFlasher</> resources to the <comment>public</comment> and <comment>config</comment> directories.')
            ->setHelp('The command copies <fg=blue;options=bold>PHPFlasher</> assets to <comment>public/vendor/flasher/</comment> directory and config files to the <comment>config/packages/</comment> directory without overwriting any existing config files.')
            ->addOption('config', 'c', InputOption::VALUE_NONE, 'Publish all config files to the <comment>config/packages/</comment> directory.')
            ->addOption('symlink', 's', InputOption::VALUE_NONE, 'Symlink <fg=blue;options=bold>PHPFlasher</> assets instead of copying them.');
    }

    /**
     * Execute the command to install PHPFlasher resources.
     *
     * This method processes each registered bundle that implements PluginBundleInterface,
     * installing its assets and configuration files as requested.
     *
     * @param InputInterface  $input  The input interface
     * @param OutputInterface $output The output interface
     *
     * @return int Command status code (SUCCESS or FAILURE)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Display PHPFlasher banner and info message
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

        // Get application and validate it's a Symfony application
        $application = $this->getApplication();
        if (!$application instanceof Application) {
            return self::SUCCESS;
        }

        // Process command options
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

        // Prepare directories
        $publicDir = $this->getPublicDir().'/vendor/flasher/';
        $configDir = $this->getConfigDir();

        $filesystem = new Filesystem();
        $filesystem->remove($publicDir);
        $filesystem->mkdir($publicDir);

        // Process each plugin bundle
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
                // Install assets and config
                $files[] = $this->publishAssets($plugin, $publicDir, $useSymlinks);

                if ($publishConfig) {
                    $this->publishConfig($plugin, $configDir, $configFile);
                }

                // Report success
                $status = \sprintf('<fg=green;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'OK' : "\xE2\x9C\x94" /* HEAVY CHECK MARK (U+2714) */);
                $output->writeln(\sprintf(' %s <fg=blue;options=bold>%s</>', $status, $plugin->getAlias()));
            } catch (\Exception $e) {
                // Report failure
                $exitCode = self::FAILURE;
                $status = \sprintf('<fg=red;options=bold>%s</>', '\\' === \DIRECTORY_SEPARATOR ? 'ERROR' : "\xE2\x9C\x98" /* HEAVY BALLOT X (U+2718) */);
                $output->writeln(\sprintf(' %s <fg=blue;options=bold>%s</> <error>%s</error>', $status, $plugin->getAlias(), $e->getMessage()));
            }
        }

        $output->writeln('');

        // Display final status message
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

        // Create asset manifest
        $this->assetManager->createManifest(array_merge([], ...$files));

        $output->writeln('');

        return $exitCode;
    }

    /**
     * Publishes assets from the plugin's assets directory to the public directory.
     *
     * This method copies or symlinks asset files from the plugin's assets directory
     * to the public directory for web access.
     *
     * @param PluginInterface $plugin      The plugin containing assets
     * @param string          $publicDir   Target directory for assets
     * @param bool            $useSymlinks Whether to symlink files instead of copying
     *
     * @return string[] List of target paths for generated manifest
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

    /**
     * Publishes configuration files to the application's config directory.
     *
     * This method copies plugin configuration files to the Symfony config directory,
     * but only if the target file doesn't already exist (to avoid overwriting user customizations).
     *
     * @param PluginInterface $plugin     The plugin containing configuration
     * @param string|null     $configDir  Target config directory
     * @param string          $configFile Source configuration file path
     */
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

    /**
     * Gets the path to the public directory.
     *
     * This method tries to locate the public directory using multiple strategies:
     * 1. First, it looks for a standard 'public' directory in the project
     * 2. If not found, it falls back to the composer.json configuration
     *
     * @return string|null Path to the public directory or null if not found
     */
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

    /**
     * Gets the path to the config directory.
     *
     * This method tries to locate the config/packages directory using multiple strategies:
     * 1. First, it looks for a standard 'config/packages' directory in the project
     * 2. If not found, it falls back to the composer.json configuration
     *
     * @return string|null Path to the config directory or null if not found
     */
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

    /**
     * Gets the project root directory from the kernel.
     *
     * @return string|null The project directory path or null if not available
     */
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

    /**
     * Gets a directory path from composer.json extra configuration.
     *
     * @param string $dir The directory key to look for in composer.json extra section
     *
     * @return string|null The directory path or null if not found
     */
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

    /**
     * Gets the kernel instance from the application.
     *
     * @return KernelInterface|null The Symfony kernel or null if not available
     */
    private function getKernel(): ?KernelInterface
    {
        $application = $this->getApplication();

        if (!$application instanceof Application) {
            return null;
        }

        return $application->getKernel();
    }
}
