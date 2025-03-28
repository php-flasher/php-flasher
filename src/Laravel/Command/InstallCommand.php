<?php

declare(strict_types=1);

namespace Flasher\Laravel\Command;

use Flasher\Laravel\Support\PluginServiceProvider;
use Flasher\Prime\Asset\AssetManagerInterface;
use Flasher\Prime\Plugin\PluginInterface;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Symfony\Component\Finder\Finder;

/**
 * InstallCommand - Artisan command for installing PHPFlasher resources.
 *
 * This command provides an elegant CLI experience for installing PHPFlasher resources
 * including assets (JS and CSS files) and configuration files. It discovers
 * all registered PHPFlasher plugins and installs their resources with visual feedback.
 *
 * Design patterns:
 * - Command: Implements the command pattern for Artisan CLI integration
 * - Discovery: Automatically discovers and processes registered plugins
 * - Builder: Constructs the installation process in distinct steps
 */
final class InstallCommand extends Command
{
    /**
     * Command signature.
     *
     * @var string
     */
    protected $signature = 'flasher:install
                           {--c|config : Publish all config files to the config directory}
                           {--s|symlink : Symlink PHPFlasher assets instead of copying them}
                           {--force : Overwrite existing files without confirmation}';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Installs PHPFlasher resources with an elegant visual experience';

    /**
     * Installation start time.
     */
    private float $startTime;

    /**
     * Collection of results for summary.
     */
    private Collection $results;

    /**
     * Creates a new InstallCommand instance.
     *
     * @param AssetManagerInterface $assetManager Manager for handling PHPFlasher assets
     */
    public function __construct(private readonly AssetManagerInterface $assetManager)
    {
        parent::__construct();
        $this->results = collect();
    }

    /**
     * Execute the command.
     *
     * @return int Command exit code (0 for success, non-zero for failure)
     */
    public function handle(): int
    {
        $this->startTime = microtime(true);

        // Display the welcome banner with stylish animation
        $this->displayWelcomeBanner();

        // Configuration options
        $useSymlinks = $this->option('symlink');
        $publishConfig = $this->option('config');
        $force = $this->option('force');

        // Setup installation environment
        $publicDir = App::publicPath('/vendor/flasher/');
        $filesystem = new Filesystem();

        // Clean directory if needed (respecting force flag)
        if ($filesystem->exists($publicDir)) {
            if ($force || $this->confirmDirectoryCleanup($publicDir)) {
                $this->task('Preparing installation directory', function () use ($filesystem, $publicDir) {
                    $filesystem->deleteDirectory($publicDir);
                    $filesystem->makeDirectory($publicDir, 0755, true);
                    return true;
                });
            }
        } else {
            $filesystem->makeDirectory($publicDir, 0755, true, true);
        }

        // Installation configuration summary
        $this->displayInstallationConfig($useSymlinks, $publishConfig, $force);

        // Process each plugin
        $files = [];
        $exitCode = self::SUCCESS;

        // Discover plugins
        $providers = $this->discoverPluginProviders();

        $this->newLine();
        $this->info('   Discovering and installing plugins...');
        $this->newLine();

        // Create and configure progress bar
        $progressBar = $this->output->createProgressBar($providers->count());
        $progressBar->setFormat(
            "   %current%/%max% [%bar%] %percent:3s%%\n   %message%"
        );
        $progressBar->setBarCharacter('<fg=cyan>▓</>');
        $progressBar->setEmptyBarCharacter('<fg=blue>░</>');
        $progressBar->setProgressCharacter('<fg=cyan>▓</>');

        // Process plugins with progress bar
        $providers->each(function ($provider, $index) use ($progressBar, &$files, &$exitCode, $useSymlinks, $publishConfig, $force) {
            $plugin = $provider->createPlugin();
            $configFile = $provider->getConfigurationFile();

            // Rotating animation characters for processing indicator
            $chars = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];
            $char = $chars[$index % count($chars)];

            $progressBar->setMessage("<fg=blue>{$char}</> <fg=blue;options=bold>Processing:</> <fg=cyan>{$plugin->getAlias()}</>");
            $progressBar->advance();

            try {
                // Process assets
                $publishedFiles = $this->publishAssets($plugin, App::publicPath('/vendor/flasher/'), $useSymlinks, $force);
                $files[] = $publishedFiles;

                // Process config if needed
                $configPublished = false;
                if ($publishConfig) {
                    $configPublished = $this->publishConfig($plugin, $configFile, $force);
                }

                // Store results for summary
                $this->results->push([
                    'plugin' => $plugin->getAlias(),
                    'status' => 'success',
                    'assets' => \count($publishedFiles),
                    'config' => $configPublished ? 'Yes' : 'No',
                ]);

                // Small delay for visual effect
                usleep(50000);
            } catch (\Exception $e) {
                $exitCode = self::FAILURE;
                $this->results->push([
                    'plugin' => $plugin->getAlias(),
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'assets' => 0,
                    'config' => 'No',
                ]);
            }
        });

        $progressBar->finish();
        $this->newLine(2);

        // Create manifest
        $this->task('Creating asset manifest', function () use ($files) {
            $this->assetManager->createManifest(array_merge([], ...$files));
            return true;
        });

        // Display installation summary
        $this->displayComprehensiveSummary($exitCode);

        return $exitCode;
    }

    /**
     * Display a stylish welcome banner with reveal animation.
     */
    private function displayWelcomeBanner(): void
    {
        $this->newLine();

        // Core banner with stylized typography
        $banner = [
            '<fg=blue;options=bold>            ██████╗ ██╗  ██╗██████╗ ███████╗██╗      █████╗ ███████╗██╗  ██╗███████╗██████╗ </>',
            '<fg=blue;options=bold>            ██╔══██╗██║  ██║██╔══██╗██╔════╝██║     ██╔══██╗██╔════╝██║  ██║██╔════╝██╔══██╗</>',
            '<fg=blue;options=bold>            ██████╔╝███████║██████╔╝█████╗  ██║     ███████║███████╗███████║█████╗  ██████╔╝</>',
            '<fg=blue;options=bold>            ██╔═══╝ ██╔══██║██╔═══╝ ██╔══╝  ██║     ██╔══██║╚════██║██╔══██║██╔══╝  ██╔══██╗</>',
            '<fg=blue;options=bold>            ██║     ██║  ██║██║     ██║     ███████╗██║  ██║███████║██║  ██║███████╗██║  ██║</>',
            '<fg=blue;options=bold>            ╚═╝     ╚═╝  ╚═╝╚═╝     ╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝</>',
        ];

        // Reveal animation - smoother with shorter delay
        foreach ($banner as $line) {
            $this->line($line);
            usleep(50000); // 50ms delay for smoother animation
        }

        // Simplified header (without box characters)
        $this->newLine();
        $this->line('   <fg=yellow;options=bold>PHPFLASHER RESOURCE INSTALLER</>');
        $this->newLine();
    }

    /**
     * Confirm directory cleanup with the user, respecting force flag.
     */
    private function confirmDirectoryCleanup(string $directory): bool
    {
        // If force option is enabled, skip confirmation
        if ($this->option('force')) {
            return true;
        }

        // If not interactive, default to yes
        if (!$this->input->isInteractive()) {
            return true;
        }

        // Otherwise ask for confirmation
        return $this->confirm(
            "The directory <comment>{$directory}</comment> already exists. Do you want to clean it before installation?",
            true
        );
    }

    /**
     * Display installation configuration summary with visual enhancements.
     */
    private function displayInstallationConfig(bool $useSymlinks, bool $publishConfig, bool $force): void
    {
        $this->newLine();
        $this->line('   <fg=blue;options=bold>[ INSTALLATION CONFIGURATION ]</>');
        $this->newLine();

        // Enhanced visual presentation of configuration
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Installation Mode</>', $useSymlinks ? '<fg=yellow>Symlink</>' : '<fg=yellow>Copy</>');
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Publish Config</>', $publishConfig ? '<fg=green>Yes</>' : '<fg=red>No</>');
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Force Override</>', $force ? '<fg=green>Yes</>' : '<fg=red>No</>');
        $this->newLine();
    }

    /**
     * Discover plugin providers from loaded service providers.
     */
    private function discoverPluginProviders(): Collection
    {
        return collect(array_keys(App::getLoadedProviders()))
            ->filter(fn ($provider) => is_a($provider, PluginServiceProvider::class, true))
            ->map(fn ($provider) => App::getProvider($provider))
            ->values();
    }

    /**
     * Execute a task with visual feedback.
     *
     * @param string   $title    Task title
     * @param callable $callback Task callback
     */
    private function task(string $title, callable $callback): bool
    {
        $this->output->write("   <fg=blue>•</> {$title}: ");

        try {
            $result = $callback();
            $this->output->writeln('<fg=green;options=bold>✓ Complete!</>');

            return (bool) $result;
        } catch (\Exception $e) {
            $this->output->writeln('<fg=red;options=bold>✗ Failed!</>');
            $this->output->writeln("     <fg=red>Error: {$e->getMessage()}</>");

            return false;
        }
    }

    /**
     * Publish assets from a plugin to the public directory.
     *
     * @param PluginInterface $plugin      The plugin to publish assets from
     * @param string          $publicDir   The target public directory
     * @param bool            $useSymlinks Whether to symlink or copy assets
     * @param bool            $force       Whether to force overwrite existing files
     *
     * @return string[] Array of published file paths
     */
    private function publishAssets(PluginInterface $plugin, string $publicDir, bool $useSymlinks, bool $force): array
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

            $filesystem->makeDirectory(\dirname($targetPath), 0755, recursive: true, force: true);

            if ($useSymlinks) {
                // For symlinks, we need to delete the existing file/link first
                if (file_exists($targetPath)) {
                    $filesystem->delete($targetPath);
                }
                $filesystem->link($file->getRealPath(), $targetPath);
            } else {
                // For file copies, force flag is honored
                $filesystem->copy($file->getRealPath(), $targetPath, $force);
            }

            $files[] = $targetPath;
        }

        return $files;
    }

    /**
     * Publish a plugin's configuration file.
     *
     * @param PluginInterface $plugin     The plugin to publish configuration for
     * @param string          $configFile The source configuration file path
     * @param bool            $force      Whether to force override existing files
     *
     * @return bool Whether configuration was published
     */
    private function publishConfig(PluginInterface $plugin, string $configFile, bool $force): bool
    {
        if (!file_exists($configFile)) {
            return false;
        }

        $target = App::configPath($plugin->getName().'.php');

        // Only skip if file exists AND force is false
        if (file_exists($target) && !$force) {
            return false;
        }

        $filesystem = new Filesystem();
        $filesystem->copy($configFile, $target, true); // Always override when we reach this point

        return true;
    }

    /**
     * Display comprehensive installation summary with enhanced visuals.
     */
    private function displayComprehensiveSummary(int $exitCode): void
    {
        $this->newLine();

        // Simplified header (without box characters)
        $this->line('   <fg=yellow;options=bold>INSTALLATION SUMMARY</>');
        $this->newLine();

        // Results table with enhanced styling
        $this->table(
            ['Plugin', 'Status', 'Assets', 'Config', 'Message'],
            $this->results->map(function ($result) {
                $status = 'success' === $result['status']
                    ? '<fg=green;options=bold>✓ SUCCESS</>'
                    : '<fg=red;options=bold>✗ ERROR</>';

                return [
                    '<fg=cyan;options=bold>'.$result['plugin'].'</>',
                    $status,
                    $result['assets'],
                    $result['config'],
                    'error' === $result['status'] ? '<fg=red>'.$result['message'].'</>' : '',
                ];
            })->toArray()
        );

        // Calculate statistics
        $successCount = $this->results->where('status', 'success')->count();
        $errorCount = $this->results->where('status', 'error')->count();
        $assetCount = $this->results->sum('assets');
        $duration = round(microtime(true) - $this->startTime, 2);

        // Simplified header for statistics section
        $this->newLine();
        $this->line('   <fg=yellow;options=bold>STATISTICS</>');
        $this->newLine();

        // Enhanced statistics with more visual appeal
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Plugins Processed</>', "<fg=white;options=bold>{$this->results->count()}</>");
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Successful</>', "<fg=green;options=bold>{$successCount}</>");
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Failed</>', $errorCount > 0 ? "<fg=red;options=bold>{$errorCount}</>" : '<fg=green;options=bold>0</>');
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Assets Published</>', "<fg=white;options=bold>{$assetCount}</>");
        $this->components->twoColumnDetail('<fg=cyan;options=bold>Duration</>', "<fg=white;options=bold>{$duration}</> seconds");

        $this->newLine();

        // Final status message - Windows-compatible (no emojis)
        if (self::SUCCESS === $exitCode) {
            $this->newLine();
            $this->line('<bg=green;fg=black;options=bold>                                                                                             </>');
            $this->line('<bg=green;fg=black;options=bold>   SUCCESSFUL! All PHPFlasher resources have been installed successfully!                    </>');
            $this->line('<bg=green;fg=black;options=bold>                                                                                             </>');
            $this->newLine();

            // Show relative paths instead of absolute
            $this->line('   <fg=blue;options=bold>></> Assets Location: <comment>public/vendor/flasher/</comment>');
            $this->line('   <fg=blue;options=bold>></> Config Location: <comment>config/</comment>');
            $this->line('   <fg=blue;options=bold>></> Documentation: <comment>https://php-flasher.io</comment>');
            $this->newLine();

            // Signature line with updated time and username
            $this->line('   <fg=cyan>PHPFlasher 2025 - Installation completed</>');
            $this->newLine();
        } else {
            $this->newLine();
            $this->line('<bg=red;options=bold>                                                                                             </>');
            $this->line('<bg=red;options=bold>   WARNING! Some errors occurred during the installation. Check the summary above.           </>');
            $this->line('<bg=red;options=bold>                                                                                             </>');
            $this->newLine();
        }
    }
}
