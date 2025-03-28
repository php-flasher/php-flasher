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
use Illuminate\Support\Str;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\Finder;

/**
 * InstallCommand - Artisan command for installing PHPFlasher resources.
 *
 * This command provides an elegant CLI experience for installing PHPFlasher resources
 * including assets (JS and CSS files) and configuration files. It discovers
 * all registered PHPFlasher plugins and installs their resources with stunning visuals.
 *
 * @author Younes Khoubza <younes.khoubza@gmail.com>
 */
final class InstallCommand extends Command
{
    /**
     * Command signature with support for multiple options.
     *
     * @var string
     */
    protected $signature = 'flasher:install
                           {--c|config : Publish all config files to the config directory}
                           {--s|symlink : Symlink PHPFlasher assets instead of copying them}
                           {--force : Overwrite existing files without confirmation}
                           {--d|debug : Show detailed debug information during installation}
                           {--minimal : Display minimal output during installation}
                           {--a|ascii : Use ASCII art instead of Unicode characters (for terminals with limited support)}
                           {--no-animation : Disable animations for CI/CD environments}';

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
     * Debug mode flag.
     */
    private bool $debugMode = false;

    /**
     * Minimal output mode flag.
     */
    private bool $minimalMode = false;

    /**
     * Disable animations flag.
     */
    private bool $noAnimation = false;

    /**
     * Use ASCII instead of Unicode.
     */
    private bool $asciiMode = false;

    /**
     * Collection of results for summary.
     */
    private Collection $results;

    /**
     * Performance metrics for debug mode.
     */
    private array $metrics = [];

    /**
     * Advanced spinner characters with more visual variety.
     */
    private array $spinnerChars = ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'];

    /**
     * ASCII fallback spinner characters.
     */
    private array $asciiSpinnerChars = ['|', '/', '-', '\\'];

    /**
     * Debug line count for dynamic collapsing.
     */
    private int $debugLineCount = 0;

    /**
     * Terminal dimensions.
     */
    private array $terminalDimensions = [
        'width' => 80,
        'height' => 24,
    ];

    /**
     * File type icons for visualization (ASCII-friendly version).
     */
    private array $fileTypeIcons = [
        'js' => '[JS]',
        'css' => '[CSS]',
        'json' => '[JSON]',
        'php' => '[PHP]',
        'default' => '[FILE]',
    ];

    /**
     * ASCII fallback icons.
     */
    private array $asciiFileTypeIcons = [
        'js' => '[JS]',
        'css' => '[CSS]',
        'json' => '[JSON]',
        'php' => '[PHP]',
        'default' => '[FILE]',
    ];

    /**
     * Success messages for random selection.
     */
    private array $successMessages = [
        'All set! Your notifications will now look fabulous! ✨',
        'Success! Get ready for notification awesomeness! 🚀',
        'Installation complete! Your users will love these notifications! 💖',
        'PHPFlasher installed! Time to make your app shine! ⭐',
        'Done! Now you have the power of beautiful notifications! 💪',
    ];

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
        $this->configureOutput();

        $this->startTiming('total');

        $this->startTime = microtime(true);
        $this->debugMode = $this->option('debug');
        $this->minimalMode = $this->option('minimal');
        $this->noAnimation = $this->option('no-animation') || $this->runningInCI();
        $this->asciiMode = $this->option('ascii') || !$this->supportsUnicode();

        // Detect terminal dimensions for responsive output
        $this->detectTerminalDimensions();

        // Ensure output is cleared and properly formatted
        if (\function_exists('pcntl_signal')) {
            pcntl_signal(\SIGINT, function () {
                $this->output->writeln('');
                $this->output->writeln('<fg=red;options=bold>Installation aborted!</>');
                exit(1);
            });
        }

        // Display the welcome banner with refined animation
        if (!$this->minimalMode) {
            $this->displayWelcomeBanner();
        } else {
            $this->info('PHPFlasher Installation');
            $this->newLine();
        }

        // Configuration options
        $useSymlinks = $this->option('symlink');
        $publishConfig = $this->option('config');
        $force = $this->option('force');

        $this->startTiming('setup');

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

        $this->stopTiming('setup');

        // Installation configuration summary
        if (!$this->minimalMode) {
            $this->displayInstallationConfig($useSymlinks, $publishConfig, $force);
        }

        // Discover plugins
        $this->startTiming('discovery');
        $providers = $this->discoverPluginProviders();
        $this->stopTiming('discovery');

        if ($this->debugMode) {
            $this->debugGroupStart('Plugin Discovery');
            $this->debug("Found {$providers->count()} service providers", 'info');
            $providers->each(function ($provider, $index) {
                $this->debug("Provider #{$index}: ".$provider::class, 'dim');
            });
            $this->debug("Discovered {$providers->count()} PHPFlasher plugins", 'success');
            $this->debugGroupEnd();
        }

        $this->newLine();
        if (!$this->minimalMode) {
            $this->line('   <fg=blue>⚡</> <fg=cyan;options=bold>Discovering and installing plugins...</>');
        } else {
            $this->info('Discovering and installing plugins...');
        }
        $this->newLine();

        // Create optimized progress bar
        $progressBar = $this->createStylizedProgressBar($providers->count());

        // Process plugins with progress bar
        $files = [];
        $exitCode = self::SUCCESS;

        $this->startTiming('plugins_processing');

        // For smoother output, we'll collect results first then display
        $providers->each(function ($provider, $index) use ($progressBar, &$files, &$exitCode, $useSymlinks, $publishConfig, $force) {
            $this->startTiming("plugin_{$index}");

            $plugin = $provider->createPlugin();
            $configFile = $provider->getConfigurationFile();

            // Update progress with spinning indicator
            if (!$this->minimalMode) {
                $spinners = $this->asciiMode ? $this->asciiSpinnerChars : $this->spinnerChars;
                $char = $spinners[$index % \count($spinners)];
                $progressBar->setMessage("<fg=blue>{$char}</> <fg=blue;options=bold>Processing:</> <fg=cyan>{$plugin->getAlias()}</>");
            }
            $progressBar->advance();

            // Use output buffering for smoother display
            ob_start();

            try {
                // Process assets
                $this->startTiming("assets_{$plugin->getAlias()}");

                if ($this->debugMode) {
                    $this->debugGroupStart("Plugin: {$plugin->getAlias()}");
                }

                $publishedFiles = $this->publishAssets($plugin, App::publicPath('/vendor/flasher/'), $useSymlinks, $force);
                $this->stopTiming("assets_{$plugin->getAlias()}");

                $files[] = $publishedFiles;

                // Process config if needed
                $configPublished = false;
                if ($publishConfig) {
                    $this->startTiming("config_{$plugin->getAlias()}");
                    $configPublished = $this->publishConfig($plugin, $configFile, $force);
                    $this->stopTiming("config_{$plugin->getAlias()}");
                }

                // Store results for summary
                $this->results->push([
                    'plugin' => $plugin->getAlias(),
                    'status' => 'success',
                    'assets' => \count($publishedFiles),
                    'config' => $configPublished ? 'Yes' : 'No',
                    'time' => $this->getElapsedTime("plugin_{$index}"),
                ]);

                if ($this->debugMode) {
                    $this->debug(
                        "Published {$plugin->getAlias()} in ".$this->getElapsedTime("plugin_{$index}").'ms',
                        'success'
                    );
                    $this->debugGroupEnd();
                }
            } catch (\Exception $e) {
                $exitCode = self::FAILURE;
                $this->results->push([
                    'plugin' => $plugin->getAlias(),
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'assets' => 0,
                    'config' => 'No',
                    'time' => $this->getElapsedTime("plugin_{$index}"),
                ]);

                if ($this->debugMode) {
                    $this->debug("Error publishing {$plugin->getAlias()}: ".$e->getMessage(), 'error');
                    $this->debug('Exception trace: '.$e->getTraceAsString(), 'dim');
                    $this->debugGroupEnd();
                }
            }

            $this->stopTiming("plugin_{$index}");

            // Flush output buffer for smoother display
            ob_end_flush();

            // Use minimal delay for visual effect (only if not in minimal mode)
            if (!$this->minimalMode && !$this->noAnimation) {
                usleep(20000); // 20ms is smoother but still visible
            }
        });

        $this->stopTiming('plugins_processing');

        $progressBar->finish();
        $this->newLine(2);

        // Create manifest
        $this->startTiming('manifest');
        $this->task('Creating asset manifest', function () use ($files) {
            $this->assetManager->createManifest(array_merge([], ...$files));

            return true;
        });
        $this->stopTiming('manifest');

        // Display installation summary
        $this->displayComprehensiveSummary($exitCode);

        $this->stopTiming('total');

        return $exitCode;
    }

    /**
     * Configure output styles.
     */
    private function configureOutput(): void
    {
        $formatter = $this->output->getFormatter();

        // Add special styles for debug output
        $formatter->setStyle('success', new OutputFormatterStyle('green'));
        $formatter->setStyle('info', new OutputFormatterStyle('blue'));
        $formatter->setStyle('notice', new OutputFormatterStyle('yellow'));
        $formatter->setStyle('error', new OutputFormatterStyle('red'));
        $formatter->setStyle('dim', new OutputFormatterStyle('gray'));
        $formatter->setStyle('highlight', new OutputFormatterStyle('cyan', null, ['bold']));

        // Box drawing styles
        $formatter->setStyle('box', new OutputFormatterStyle('blue'));
        $formatter->setStyle('box-title', new OutputFormatterStyle('cyan', null, ['bold']));
    }

    /**
     * Detect terminal dimensions for responsive output.
     */
    private function detectTerminalDimensions(): void
    {
        if (\function_exists('exec')) {
            @exec('tput cols 2>/dev/null', $columns, $return_var);
            if (0 === $return_var && isset($columns[0])) {
                $this->terminalDimensions['width'] = (int) $columns[0];
            }

            @exec('tput lines 2>/dev/null', $lines, $return_var);
            if (0 === $return_var && isset($lines[0])) {
                $this->terminalDimensions['height'] = (int) $lines[0];
            }
        }
    }

    /**
     * Check if we're running in a CI environment.
     */
    private function runningInCI(): bool
    {
        return (bool) (
            getenv('CI')
            || getenv('CONTINUOUS_INTEGRATION')
            || getenv('GITHUB_ACTIONS')
            || getenv('GITLAB_CI')
            || getenv('TRAVIS')
            || getenv('CIRCLECI')
        );
    }

    /**
     * Check if terminal supports Unicode characters.
     */
    private function supportsUnicode(): bool
    {
        return false !== stripos(getenv('LANG') ?: '', 'UTF-8')
            || false !== stripos(getenv('LC_ALL') ?: '', 'UTF-8');
    }

    /**
     * Create a stylized progress bar with custom format.
     */
    private function createStylizedProgressBar(int $max): ProgressBar
    {
        $progressBar = $this->output->createProgressBar($max);

        if ($this->minimalMode) {
            $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%%');
        } else {
            if ($this->asciiMode) {
                $progressBar->setFormat(
                    "   %current%/%max% [%bar%] %percent:3s%%\n   %message%"
                );
                $progressBar->setBarCharacter('=');
                $progressBar->setEmptyBarCharacter('-');
                $progressBar->setProgressCharacter('>');
            } else {
                // Enhanced Unicode progress bar
                $progressBar->setFormat(
                    "   %current%/%max% [%bar%] %percent:3s%%\n   %message%"
                );
                $progressBar->setBarCharacter('<fg=cyan>▓</>');
                $progressBar->setEmptyBarCharacter('<fg=blue>░</>');
                $progressBar->setProgressCharacter('<fg=cyan>▓</>');
            }
        }

        return $progressBar;
    }

    /**
     * Display a stylish welcome banner with smoother animation.
     */
    private function displayWelcomeBanner(): void
    {
        $this->startTiming('banner');
        $this->newLine();

        // Select banner based on terminal capabilities
        $banner = $this->asciiMode ? $this->getAsciiBanner() : $this->getUnicodeBanner();

        // If animations are disabled, just output the banner
        if ($this->noAnimation) {
            foreach ($banner as $line) {
                $this->line($line);
            }
        } else {
            // Use output buffering for smoother animation
            ob_start();
            foreach ($banner as $line) {
                $this->line($line);
                // Flush immediately for smoother animation
                ob_flush();
                flush();
                usleep(20000); // 20ms for smoother animation
            }
            ob_end_flush();
        }

        // Title with version
        $this->newLine();

        // Use terminal-aware formatting for the title
        $titleWidth = $this->terminalDimensions['width'] >= 100 ?
            $this->terminalDimensions['width'] - 20 :
            60;

        $title = 'PHPFLASHER RESOURCE INSTALLER v2';
        $padding = max(0, ($titleWidth - \strlen(strip_tags($title))) / 2);
        $paddingStr = str_repeat(' ', (int) $padding);

        $this->line('   '.$paddingStr.'<fg=yellow;options=bold>PHPFLASHER RESOURCE INSTALLER</> <fg=blue>v2</fg=blue>');
        $this->newLine();

        $this->stopTiming('banner');
    }

    /**
     * Get the Unicode banner for terminals that support it.
     */
    private function getUnicodeBanner(): array
    {
        return [
            '<fg=blue;options=bold>            ██████╗ ██╗  ██╗██████╗ ███████╗██╗      █████╗ ███████╗██╗  ██╗███████╗██████╗ </>',
            '<fg=blue;options=bold>            ██╔══██╗██║  ██║██╔══██╗██╔════╝██║     ██╔══██╗██╔════╝██║  ██║██╔════╝██╔══██╗</>',
            '<fg=blue;options=bold>            ██████╔╝███████║██████╔╝█████╗  ██║     ███████║███████╗███████║█████╗  ██████╔╝</>',
            '<fg=blue;options=bold>            ██╔═══╝ ██╔══██║██╔═══╝ ██╔══╝  ██║     ██╔══██║╚════██║██╔══██║██╔══╝  ██╔══██╗</>',
            '<fg=blue;options=bold>            ██║     ██║  ██║██║     ██║     ███████╗██║  ██║███████║██║  ██║███████╗██║  ██║</>',
            '<fg=blue;options=bold>            ╚═╝     ╚═╝  ╚═╝╚═╝     ╚═╝     ╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝</>',
        ];
    }

    /**
     * Get ASCII fallback banner for terminals with limited support.
     */
    private function getAsciiBanner(): array
    {
        return [
            '<fg=blue;options=bold>            ______ _    _ ______ ______ _               _____ _    _ ______ _____  </>',
            '<fg=blue;options=bold>            |  ____| |  | |  ____|  ____| |        /\   / ____| |  | |  ____|  __ \ </>',
            '<fg=cyan;options=bold>            | |__  | |__| | |__  | |__  | |       /  \ | (___ | |__| | |__  | |__) |</>',
            '<fg=cyan;options=bold>            |  __| |  __  |  __| |  __| | |      / /\ \ \___ \|  __  |  __| |  _  / </>',
            '<fg=blue;options=bold>            | |    | |  | | |____| |____| |____ / ____ \____) | |  | | |____| | \ \ </>',
            '<fg=blue;options=bold>            |_|    |_|  |_|______|______|______/_/    \_\_____/|_|  |_|______|_|  \_\</>',
        ];
    }

    /**
     * Confirm directory cleanup with the user, respecting force flag.
     */
    private function confirmDirectoryCleanup(string $directory): bool
    {
        // If force option is enabled, skip confirmation
        if ($this->option('force')) {
            if ($this->debugMode) {
                $this->debug("Force flag enabled, cleaning directory without confirmation: {$directory}", 'notice');
            }

            return true;
        }

        // If not interactive, default to yes
        if (!$this->input->isInteractive()) {
            return true;
        }

        // Otherwise ask for confirmation with enhanced visuals
        if (!$this->minimalMode && !$this->asciiMode) {
            $this->newLine();
            $this->line('   <box>╭'.str_repeat('─', 70).'╮</box>');
            $this->line('   <box>│</box> <box-title>CONFIRM DIRECTORY CLEANUP</box-title>'.str_repeat(' ', 47).'<box>│</box>');
            $this->line('   <box>│</box>'.str_repeat(' ', 70).'<box>│</box>');

            $message = 'The directory exists and needs to be cleaned before installation:';
            $this->line('   <box>│</box> '.$message.str_repeat(' ', 70 - \strlen($message)).'<box>│</box>');

            $dirLine = "  <fg=yellow>{$directory}</>";
            $this->line('   <box>│</box>'.$dirLine.str_repeat(' ', 70 - \strlen(strip_tags($dirLine))).'<box>│</box>');

            $this->line('   <box>│</box>'.str_repeat(' ', 70).'<box>│</box>');
            $this->line('   <box>╰'.str_repeat('─', 70).'╯</box>');
            $this->newLine();

            return $this->confirm('   <fg=blue>•</> Do you want to clean this directory?', true);
        }

        // Simpler version for minimal or ASCII mode
        return $this->confirm(
            "The directory <comment>{$directory}</comment> already exists. Do you want to clean it before installation?",
            true
        );
    }

    /**
     * Display installation configuration summary with simplified styling.
     */
    private function displayInstallationConfig(bool $useSymlinks, bool $publishConfig, bool $force): void
    {
        $this->newLine();

        // Use bracketed header style for all environments
        $this->line('   <fg=blue;options=bold>[ INSTALLATION CONFIGURATION ]</>');

        $this->newLine();

        // Enhanced visual presentation of configuration
        $this->components->twoColumnDetail(
            '<fg=cyan;options=bold>Installation Mode</>',
            $useSymlinks
                ? '<fg=yellow>Symlink</> <fg=gray>(faster, development)</>'
                : '<fg=yellow>Copy</> <fg=gray>(recommended, production)</>'
        );

        $this->components->twoColumnDetail(
            '<fg=cyan;options=bold>Publish Config</>',
            $publishConfig
                ? '<fg=green>Yes</> <fg=gray>(customizable)</>'
                : '<fg=red>No</> <fg=gray>(using defaults)</>'
        );

        $this->components->twoColumnDetail(
            '<fg=cyan;options=bold>Force Override</>',
            $force
                ? '<fg=green>Yes</> <fg=gray>(will replace existing files)</>'
                : '<fg=red>No</> <fg=gray>(will preserve existing files)</>'
        );

        $this->components->twoColumnDetail(
            '<fg=cyan;options=bold>Debug Mode</>',
            $this->debugMode
                ? '<fg=green>Enabled</> <fg=gray>(showing detailed information)</>'
                : '<fg=red>Disabled</> <fg=gray>(standard output)</>'
        );

        $this->components->twoColumnDetail(
            '<fg=cyan;options=bold>Minimal Output</>',
            $this->minimalMode
                ? '<fg=green>Enabled</> <fg=gray>(showing minimal output)</>'
                : '<fg=red>Disabled</> <fg=gray>(showing standard output)</>'
        );

        if (!$this->minimalMode) {
            $this->components->twoColumnDetail(
                '<fg=cyan;options=bold>Animations</>',
                $this->noAnimation
                    ? '<fg=red>Disabled</> <fg=gray>(better for CI/CD environments)</>'
                    : '<fg=green>Enabled</> <fg=gray>(interactive visual feedback)</>'
            );

            $this->components->twoColumnDetail(
                '<fg=cyan;options=bold>Character Set</>',
                $this->asciiMode
                    ? '<fg=yellow>ASCII</> <fg=gray>(compatible with all terminals)</>'
                    : '<fg=yellow>Unicode</> <fg=gray>(enhanced visual experience)</>'
            );
        }

        $this->newLine();
    }

    /**
     * Discover plugin providers from loaded service providers.
     */
    private function discoverPluginProviders(): Collection
    {
        $providers = collect(array_keys(App::getLoadedProviders()))
            ->filter(fn ($provider) => is_a($provider, PluginServiceProvider::class, true))
            ->map(fn ($provider) => App::getProvider($provider))
            ->values();

        return $providers;
    }

    /**
     * Execute a task with enhanced visual feedback.
     *
     * @param string   $title    Task title
     * @param callable $callback Task callback
     */
    private function task(string $title, callable $callback): bool
    {
        $taskName = strtolower(str_replace(' ', '_', $title));
        $this->startTiming("task_{$taskName}");

        if ($this->minimalMode) {
            // Simple display in minimal mode
            $this->output->write("   {$title}... ");
        } else {
            // Enhanced task styling
            $bullet = $this->asciiMode ? '>' : '•';
            $this->output->write("   <fg=blue>{$bullet}</> {$title}: ");
        }

        try {
            // Use output buffering for smoother display
            ob_start();
            $result = $callback();
            ob_end_flush();

            if ($this->minimalMode) {
                $this->output->writeln('<fg=green;options=bold>Done!</>');
            } else {
                $checkmark = $this->asciiMode ? 'Complete!' : '✓ Complete!';
                $this->output->writeln("<fg=green;options=bold>{$checkmark}</>");
            }

            if ($this->debugMode) {
                $time = $this->getElapsedTime("task_{$taskName}");
                $this->debug("Task '{$title}' completed in {$time}ms", 'success');
            }

            $this->stopTiming("task_{$taskName}");

            return (bool) $result;
        } catch (\Exception $e) {
            ob_end_flush();

            if ($this->minimalMode) {
                $this->output->writeln('<fg=red;options=bold>Failed!</>');
                $this->output->writeln("   Error: {$e->getMessage()}");
            } else {
                $failMark = $this->asciiMode ? 'Failed!' : '✗ Failed!';
                $this->output->writeln("<fg=red;options=bold>{$failMark}</>");
                $this->output->writeln("     <fg=red>Error: {$e->getMessage()}</>");
            }

            if ($this->debugMode) {
                $this->debug('Exception trace: '.$e->getTraceAsString(), 'dim');
            }

            $this->stopTiming("task_{$taskName}");

            return false;
        }
    }

    /**
     * Publish assets from a plugin to the public directory with enhanced visual feedback.
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
            if ($this->debugMode) {
                $this->debug("No assets directory found for {$plugin->getAlias()}: {$originDir}", 'notice');
            }

            return [];
        }

        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder->files()->in($originDir);

        if ($this->debugMode) {
            $this->debug("Publishing assets for {$plugin->getAlias()}: ".$finder->count().' files', 'info');
        }

        $files = [];
        $totalSize = 0;
        $filesCount = 0;
        $maxFilesToShow = $this->debugMode ? 12 : 0; // Limit the number of files shown in debug mode

        // Group files by type for better visualization
        $filesByType = [
            'js' => [],
            'css' => [],
            'json' => [],
            'php' => [],
            'other' => [],
        ];

        // Process files with a mini progress animation for debug mode
        foreach ($finder as $file) {
            ++$filesCount;
            $relativePath = trim(str_replace($originDir, '', $file->getRealPath()), \DIRECTORY_SEPARATOR);
            $targetPath = $publicDir.$relativePath;
            $fileSize = $file->getSize();
            $totalSize += $fileSize;
            $extension = strtolower($file->getExtension());

            $filesystem->makeDirectory(\dirname($targetPath), 0755, recursive: true, force: true);

            // Track file types
            if (isset($filesByType[$extension])) {
                $filesByType[$extension][] = ['path' => $relativePath, 'size' => $fileSize];
            } else {
                $filesByType['other'][] = ['path' => $relativePath, 'size' => $fileSize];
            }

            if ($useSymlinks) {
                // For symlinks, we need to delete the existing file/link first
                if (file_exists($targetPath)) {
                    $filesystem->delete($targetPath);
                }
                $filesystem->link($file->getRealPath(), $targetPath);

                if ($this->debugMode && $filesCount <= $maxFilesToShow) {
                    $icon = $this->asciiMode ? $this->asciiFileTypeIcons[$extension] ?? $this->asciiFileTypeIcons['default'] : $this->fileTypeIcons[$extension] ?? $this->fileTypeIcons['default'];
                    $this->debug("  {$icon} Symlinked: {$relativePath} ({$this->formatBytes($fileSize)})", 'dim');
                }
            } else {
                // For file copies, force flag is honored
                $filesystem->copy($file->getRealPath(), $targetPath, $force);

                if ($this->debugMode && $filesCount <= $maxFilesToShow) {
                    $icon = $this->asciiMode ? $this->asciiFileTypeIcons[$extension] ?? $this->asciiFileTypeIcons['default'] : $this->fileTypeIcons[$extension] ?? $this->fileTypeIcons['default'];
                    $this->debug("  {$icon} Copied: {$relativePath} ({$this->formatBytes($fileSize)})", 'dim');
                }
            }

            // Create a subtle pulsing animation if in debug mode
            if ($this->debugMode && !$this->noAnimation && 0 === $filesCount % 3) {
                echo "\033[s"; // Save cursor position
                echo "\033[u"; // Restore cursor position
                usleep(5000); // Short delay for subtle animation
            }

            $files[] = $targetPath;
        }

        if ($this->debugMode) {
            if ($filesCount > $maxFilesToShow) {
                $this->debug('  ... and '.($filesCount - $maxFilesToShow).' more files', 'dim');
            }

            if (\count($files) > 0) {
                $this->debug("Total size: {$this->formatBytes($totalSize)} in ".\count($files).' files', 'success');
            }

            // Add file type breakdown for better visualization
            foreach ($filesByType as $type => $typeFiles) {
                if (\count($typeFiles) > 0) {
                    $totalTypeSize = array_sum(array_column($typeFiles, 'size'));
                    $icon = $this->asciiMode ?
                        ($this->asciiFileTypeIcons[$type] ?? $this->asciiFileTypeIcons['default']) :
                        ($this->fileTypeIcons[$type] ?? $this->fileTypeIcons['default']);
                    $this->debug("  {$icon} {$type}: ".\count($typeFiles)." files ({$this->formatBytes($totalTypeSize)})", 'dim');
                }
            }
        }

        return $files;
    }

    /**
     * Publish a plugin's configuration file with enhanced visual feedback.
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
            if ($this->debugMode) {
                $this->debug("Config file not found for {$plugin->getAlias()}: {$configFile}", 'notice');
            }

            return false;
        }

        $target = App::configPath($plugin->getName().'.php');

        // Only skip if file exists AND force is false
        if (file_exists($target) && !$force) {
            if ($this->debugMode) {
                $this->debug("Config already exists for {$plugin->getAlias()}, skipping (use --force to override)", 'notice');
            }

            return false;
        }

        $filesystem = new Filesystem();

        // Add visual delay for better UX during config copy
        if ($this->debugMode && !$this->noAnimation) {
            $configIcon = $this->asciiMode ? '[CFG]' : '⚙️';
            $this->debug("{$configIcon} Preparing config for {$plugin->getAlias()}...", 'info');
            usleep(100000); // 100ms delay for visual effect
        }

        $filesystem->copy($configFile, $target, $force);

        if ($this->debugMode) {
            $configIcon = $this->asciiMode ? '[CFG]' : '⚙️';
            $this->debug("{$configIcon} Published config for {$plugin->getAlias()}: {$this->getRelativePath($target)}", 'success');
        }

        return true;
    }

    /**
     * Display a comprehensive summary of the installation process with enhanced visuals.
     */
    private function displayComprehensiveSummary(int $exitCode): void
    {
        $this->startTiming('summary');
        $this->newLine();

        // Don't show table in minimal mode
        if ($this->minimalMode) {
            $totalTime = round((microtime(true) - $this->startTime) * 1000);
            $successCount = $this->results->where('status', 'success')->count();
            $errorCount = $this->results->where('status', 'error')->count();

            $this->info("Installation completed in {$totalTime}ms");
            $this->info("Processed {$this->results->count()} plugins ({$successCount} successful, {$errorCount} failed)");

            // Show errors in minimal mode
            if ($errorCount > 0) {
                $this->newLine();
                $this->error('Failed plugins:');
                $this->results->where('status', 'error')->each(function ($result) {
                    $this->line(" - {$result['plugin']}: {$result['message']}");
                });
            }

            $this->newLine();

            return;
        }

        // Enhanced with detailed results and animated success
        if (self::SUCCESS === $exitCode) {
            // Animate the success message for extra wow effect
            if (!$this->noAnimation) {
                $chars = ['⣾', '⣽', '⣻', '⢿', '⡿', '⣟', '⣯', '⣷'];
                for ($i = 0; $i < 5; ++$i) { // 5 animation cycles
                    echo "\033[s"; // Save cursor position
                    $this->line('   <fg=green;options=bold>[ INSTALLATION '.$chars[$i % \count($chars)].' ]</>');
                    usleep(100000); // 100ms delay
                    echo "\033[u"; // Restore cursor position
                }
            }
            // Final success message
            $this->line('   <fg=green;options=bold>[ INSTALLATION COMPLETED SUCCESSFULLY ]</>');

            // Show a random success message for fun
            $randomMessage = $this->successMessages[array_rand($this->successMessages)];
            $this->newLine();
            $this->line('   <fg=green>'.$randomMessage.'</>');
        } else {
            $this->line('   <fg=red;options=bold>[ INSTALLATION COMPLETED WITH ERRORS ]</>');
        }
        $this->newLine();

        // Results section with bracket-style header
        $this->line('   <fg=blue;options=bold>[ INSTALLATION RESULTS ]</>');
        $this->newLine();

        // Detailed results table with color-coded status
        $headers = ['Plugin', 'Status', 'Assets', 'Config', 'Time (ms)'];
        $rows = $this->results->map(function ($result) {
            $checkmark = $this->asciiMode ? '√' : '✓';
            $xmark = $this->asciiMode ? 'x' : '✗';

            $status = 'success' === $result['status']
                ? '<fg=green;options=bold>'.$checkmark.' Success</>'
                : '<fg=red;options=bold>'.$xmark.' Failed</>';

            return [
                '<fg=cyan;options=bold>'.$result['plugin'].'</>',
                $status,
                $result['assets'],
                $result['config'],
                $result['time'],
            ];
        })->toArray();

        $this->table($headers, $rows);

        // Statistics section with bracket-style header
        $totalTime = round((microtime(true) - $this->startTime) * 1000);
        $successCount = $this->results->where('status', 'success')->count();
        $failureCount = $this->results->where('status', 'error')->count();
        $totalAssets = $this->results->sum('assets');

        $this->line('   <fg=blue;options=bold>[ INSTALLATION STATISTICS ]</>');
        $this->newLine();

        // Animated statistics counter for extra wow effect
        if (!$this->noAnimation && !$this->minimalMode) {
            // Animate total plugins count
            echo '   <fg=cyan;options=bold>Total Plugins</> .................................................................. ';
            for ($i = 0; $i <= $this->results->count(); ++$i) {
                echo "\033[s"; // Save cursor position
                echo "<fg=yellow>{$i}</>";
                if ($i < $this->results->count()) {
                    usleep(50000); // 50ms delay between increments
                    echo "\033[u"; // Restore cursor position
                }
            }
            echo \PHP_EOL;

            // Animate successful count
            echo '   <fg=cyan;options=bold>Successful</> ................................................................... ';
            for ($i = 0; $i <= $successCount; ++$i) {
                echo "\033[s"; // Save cursor position
                echo "<fg=green>{$i}</>";
                if ($i < $successCount) {
                    usleep(50000); // 50ms delay between increments
                    echo "\033[u"; // Restore cursor position
                }
            }
            echo \PHP_EOL;

            // Other stats without animation
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Failed</>', "<fg=red>{$failureCount}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Assets Published</>', "<fg=yellow>{$totalAssets}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Total Time</>', "<fg=yellow>{$totalTime}ms</>");
        } else {
            // Static display without animation
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Total Plugins</>', "<fg=yellow>{$this->results->count()}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Successful</>', "<fg=green>{$successCount}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Failed</>', "<fg=red>{$failureCount}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Assets Published</>', "<fg=yellow>{$totalAssets}</>");
            $this->components->twoColumnDetail('<fg=cyan;options=bold>Total Time</>', "<fg=yellow>{$totalTime}ms</>");
        }

        // Documentation section - simplified now that PHPFlasher auto-injects
        $this->newLine();
        $this->line('   <fg=blue;options=bold>[ DOCUMENTATION ]</>');
        $this->newLine();
        $this->line('   <fg=white>• PHPFlasher Documentation:</> <fg=blue>https://php-flasher.io</>');
        $this->newLine();

        $this->stopTiming('summary');
    }

    /**
     * Format a file size in bytes to human-readable format with enhanced styling.
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(log($bytes, 1024));
        $pow = min($pow, \count($units) - 1);

        $bytes /= 1024 ** $pow;

        // Color-code based on size
        $color = 'green';
        if ($pow >= 3) { // GB or larger
            $color = 'red';
        } elseif ($pow >= 2) { // MB
            $color = 'yellow';
        } elseif ($pow >= 1) { // KB
            $color = 'blue';
        }

        return "<fg=$color>".round($bytes, $precision).' '.$units[$pow].'</>';
    }

    /**
     * Start timing an operation.
     */
    private function startTiming(string $name): void
    {
        if (!$this->debugMode) {
            return;
        }

        $this->metrics[$name] = [
            'start' => microtime(true),
        ];
    }

    /**
     * Stop timing an operation and record its duration.
     */
    private function stopTiming(string $name): void
    {
        if (!$this->debugMode || !isset($this->metrics[$name]['start'])) {
            return;
        }

        $this->metrics[$name]['end'] = microtime(true);
        $this->metrics[$name]['duration'] = round(($this->metrics[$name]['end'] - $this->metrics[$name]['start']) * 1000);
    }

    /**
     * Get elapsed time for an operation in milliseconds.
     */
    private function getElapsedTime(string $name): int
    {
        if (!isset($this->metrics[$name]['duration'])) {
            return 0;
        }

        return $this->metrics[$name]['duration'];
    }

    /**
     * Output a debug message.
     */
    private function debug(string $message, string $level = 'info'): void
    {
        if (!$this->debugMode) {
            return;
        }

        ++$this->debugLineCount;
        $timestamp = '['.\sprintf('%.3f', (microtime(true) - $this->startTime) * 1000).'ms]';
        $this->line("   <fg=gray>{$timestamp}</> <{$level}>{$message}</{$level}>");
    }

    /**
     * Start a debug group.
     */
    private function debugGroupStart(string $name): void
    {
        if (!$this->debugMode) {
            return;
        }

        $this->newLine();
        $this->line("   <fg=yellow;options=bold>▼ {$name}</>");
    }

    /**
     * End a debug group.
     */
    private function debugGroupEnd(): void
    {
        if (!$this->debugMode) {
            return;
        }

        $this->newLine();
    }

    /**
     * Get relative path from the application base path.
     */
    private function getRelativePath(string $path): string
    {
        return Str::replaceFirst($this->getBasePath(), '', $path);
    }

    /**
     * Get application base path.
     */
    private function getBasePath(): string
    {
        return App::basePath();
    }
}
