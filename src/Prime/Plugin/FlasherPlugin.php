<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Type;

/**
 * FlasherPlugin - Core plugin for PHPFlasher.
 *
 * This class represents the core PHPFlasher plugin, which provides the basic
 * notification functionality. It serves as the default plugin and the foundation
 * for other plugins to build upon.
 *
 * Design patterns:
 * - Core Plugin: Provides essential functionality that other plugins extend
 * - Configuration Management: Handles normalization and defaults for system config
 *
 * @phpstan-type ConfigType array{
 *     default: string,
 *     main_script: string,
 *     translate: bool,
 *     inject_assets: bool,
 *     excluded_paths: list<non-empty-string>,
 *     scripts: string[],
 *     styles: string[],
 *     options: array<string, mixed>,
 *     filter: array<string, mixed>,
 *     flash_bag: false|array<string, string[]>,
 *     presets: array<string, array{
 *         type: string,
 *         title: string,
 *         message: string,
 *         options: array<string, mixed>,
 *     }>,
 *     plugins: array<string, array{
 *         scripts?: string[],
 *         styles?: string[],
 *         options?: array<string, mixed>,
 *     }>,
 * }
 */
final class FlasherPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'flasher';
    }

    public function getName(): string
    {
        return 'flasher';
    }

    public function getServiceId(): string
    {
        return 'flasher';
    }

    public function getFactory(): string
    {
        return NotificationFactory::class;
    }

    public function getServiceAliases(): string
    {
        return FlasherInterface::class;
    }

    /**
     * Gets the default plugin name.
     *
     * @return string The default plugin name
     */
    public function getDefault(): string
    {
        return 'flasher';
    }

    /**
     * Gets the path to the main PHPFlasher script.
     *
     * @return string The script path
     */
    public function getRootScript(): string
    {
        return '/vendor/flasher/flasher.min.js';
    }

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return [];
    }

    public function getStyles(): string
    {
        return '/vendor/flasher/flasher.min.css';
    }

    /**
     * {@inheritdoc}
     *
     * This overridden method extends the parent's normalization process with
     * additional steps specific to the core plugin:
     * - Normalizing plugin configurations
     * - Normalizing preset configurations
     * - Adding default configuration values
     * - Normalizing flash bag mappings
     * - Setting preset defaults
     */
    public function normalizeConfig(array $config = []): array
    {
        $config = parent::normalizeConfig($config);

        $config = $this->normalizePlugins($config);
        $config = $this->normalizeThemes($config);
        $config = $this->normalizePresets($config);
        $config = $this->addDefaultConfig($config);
        $config = $this->normalizeFlashBag($config);
        $config = $this->setPresetsDefaults($config);

        return $config;
    }

    /**
     * Normalizes the plugins configuration.
     *
     * This method ensures the core plugin is properly configured, merges global options
     * with plugin-specific options, and normalizes array formats for scripts and styles.
     *
     * @param array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins?: array<string, array{
     *         scripts?: string[],
     *         styles?: string[],
     *         options?: array<string, mixed>,
     *     }>,
     * } $config The raw configuration
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins: array<string, mixed>,
     * } The normalized configuration
     */
    private function normalizePlugins(array $config): array
    {
        if (!isset($config['plugins']['flasher'])) {
            $config['plugins']['flasher'] = [
                'scripts' => [],
                'styles' => [],
                'options' => [],
            ];
        }

        if (!empty($config['scripts'])) {
            $config['plugins']['flasher']['scripts'] ??= [];
            $config['plugins']['flasher']['scripts'] += $config['scripts'];
        }

        if (!empty($config['styles'])) {
            $config['plugins']['flasher']['styles'] ??= [];
            $config['plugins']['flasher']['styles'] += $config['styles'];
        }

        if (!empty($config['options'])) {
            $config['plugins']['flasher']['options'] ??= [];
            $config['plugins']['flasher']['options'] += $config['options'];
        }

        foreach ($config['plugins'] as $name => $options) {
            if (isset($options['scripts'])) {
                $config['plugins'][$name]['scripts'] = (array) $options['scripts'];
            }

            if (isset($options['styles'])) {
                $config['plugins'][$name]['styles'] = (array) $options['styles'];
            }
        }

        return $config;
    }

    /**
     * Normalizes the themes configuration.
     *
     * This method ensures that the themes configuration has the correct structure
     * and includes default themes unless explicitly disabled.
     *
     * @param array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins: array<string, mixed>,
     *     themes?: array<string, array{
     *         scripts?: string[],
     *         styles?: string[],
     *         options?: array<string, mixed>,
     *     }>,
     * } $config The raw configuration
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins: array<string, mixed>,
     *     themes: array<string, mixed>,
     * } The normalized configuration
     */
    private function normalizeThemes(array $config): array
    {
        // Define default themes with their assets
        $defaultThemes = $this->getDefaultThemes();

        // Initialize themes config if not set
        if (!isset($config['themes'])) {
            $config['themes'] = [];
        }

        // Merge default themes with user-defined themes, prioritizing user configs
        foreach ($defaultThemes as $themeName => $themeConfig) {
            if (!isset($config['themes'][$themeName])) {
                $config['themes'][$themeName] = $themeConfig;
            } else {
                // Make sure all required theme properties exist
                if (!isset($config['themes'][$themeName]['scripts'])) {
                    $config['themes'][$themeName]['scripts'] = $themeConfig['scripts'];
                }
                if (!isset($config['themes'][$themeName]['styles'])) {
                    $config['themes'][$themeName]['styles'] = $themeConfig['styles'];
                }
                if (!isset($config['themes'][$themeName]['options'])) {
                    $config['themes'][$themeName]['options'] = $themeConfig['options'];
                }
            }
        }

        // Normalize theme configs
        foreach ($config['themes'] as $name => $options) {
            if (isset($options['scripts'])) {
                $config['themes'][$name]['scripts'] = (array) $options['scripts'];
            }
            if (isset($options['styles'])) {
                $config['themes'][$name]['styles'] = (array) $options['styles'];
            }
            if (!isset($options['options'])) {
                $config['themes'][$name]['options'] = [];
            }
        }

        return $config;
    }

    /**
     * Normalizes the presets configuration.
     *
     * This method ensures that string-only preset definitions are expanded to full arrays
     * with the string value as the message.
     *
     * @param array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, string|array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } $config The raw configuration
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } The normalized configuration
     */
    private function normalizePresets(array $config): array
    {
        foreach ($config['presets'] ?? [] as $name => $options) {
            if (\is_string($options)) {
                $options = ['message' => $options];
            }

            $config['presets'][$name] = $options;
        }

        return $config; // @phpstan-ignore-line
    }

    /**
     * Adds default configuration values.
     *
     * This method ensures that all required configuration keys have values,
     * providing defaults for any that are missing.
     *
     * @param array{
     *     default?: string|null,
     *     main_script?: string|null,
     *     translate?: bool,
     *     inject_assets?: bool,
     *     excluded_paths?: list<non-empty-string>,
     *     filter?: array<string, mixed>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } $config The raw configuration
     *
     * @return array{
     *     default: string|null,
     *     main_script: string|null,
     *     translate: bool,
     *     inject_assets: bool,
     *     excluded_paths?: list<non-empty-string>,
     *     filter: array<string, mixed>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } The configuration with defaults added
     */
    private function addDefaultConfig(array $config): array
    {
        $defaultPresets = [
            'created' => ['type' => Type::SUCCESS, 'message' => 'The resource was created'],
            'updated' => ['type' => Type::SUCCESS, 'message' => 'The resource was updated'],
            'saved' => ['type' => Type::SUCCESS, 'message' => 'The resource was saved'],
            'deleted' => ['type' => Type::SUCCESS, 'message' => 'The resource was deleted'],
        ];

        $config['default'] = \array_key_exists('default', $config) ? $config['default'] : $this->getDefault();
        $config['main_script'] = \array_key_exists('main_script', $config) ? $config['main_script'] : $this->getRootScript();
        $config['translate'] = \array_key_exists('translate', $config) ? $config['translate'] : true;
        $config['inject_assets'] = \array_key_exists('inject_assets', $config) ? $config['inject_assets'] : true;
        $config['filter'] = \array_key_exists('filter', $config) ? $config['filter'] : [];
        $config['presets'] = \array_key_exists('presets', $config) ? $config['presets'] : $defaultPresets;

        return $config;
    }

    /**
     * Normalizes the flash bag configuration.
     *
     * This method ensures that the flash bag mapping has the correct structure
     * and includes default mappings unless explicitly disabled.
     *
     * @param array{
     *     default: string|null,
     *     main_script: string|null,
     *     translate: bool,
     *     inject_assets: bool,
     *     excluded_paths?: list<non-empty-string>,
     *     filter: array<string, mixed>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     *     flash_bag?: bool|array<string, string[]>,
     * } $config The raw configuration
     *
     * @return array{
     *      default: string|null,
     *      main_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      excluded_paths?: list<non-empty-string>,
     *      filter: array<string, mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: false|array<string, string[]>,
     * } The normalized configuration
     */
    private function normalizeFlashBag(array $config): array
    {
        $mapping = [
            'success' => ['success'],
            'error' => ['error', 'danger'],
            'warning' => ['warning', 'alarm'],
            'info' => ['info', 'notice', 'alert'],
        ];

        if (!\array_key_exists('flash_bag', $config) || true === $config['flash_bag']) {
            $config['flash_bag'] = $mapping;
        }

        if (false === $config['flash_bag']) {
            return $config;
        }

        $config['flash_bag'] += array_merge($mapping, $config['flash_bag']);

        return $config;
    }

    /**
     * Sets default values for presets.
     *
     * This method ensures that all presets have required fields with default values.
     *
     * @param array{
     *      default: string|null,
     *      main_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      excluded_paths?: list<non-empty-string>,
     *      filter: array<string, mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: false|array<string, string[]>,
     * } $config The raw configuration
     *
     * @return array{
     *      default: string|null,
     *      main_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      excluded_paths?: list<non-empty-string>,
     *      filter: array<string, mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: false|array<string, string[]>,
     * } The normalized configuration
     */
    private function setPresetsDefaults(array $config): array
    {
        foreach ($config['presets'] as $name => $options) {
            $config['presets'][$name]['type'] ??= Type::INFO;
            $config['presets'][$name]['options'] ??= [];
        }

        return $config;
    }

    /**
     * Returns the default themes configuration.
     *
     * @return array<string, array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>
     * }> The default themes configuration
     */
    private function getDefaultThemes(): array
    {
        return [
            'amazon' => [
                'scripts' => ['/vendor/flasher/themes/amazon/amazon.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/amazon/amazon.min.css',
                ],
                'options' => [],
            ],
            'amber' => [
                'scripts' => ['/vendor/flasher/themes/amber/amber.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/amber/amber.min.css',
                ],
                'options' => [],
            ],
            'jade' => [
                'scripts' => ['/vendor/flasher/themes/jade/jade.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/jade/jade.min.css',
                ],
                'options' => [],
            ],
            'crystal' => [
                'scripts' => ['/vendor/flasher/themes/crystal/crystal.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/crystal/crystal.min.css',
                ],
                'options' => [],
            ],
            'emerald' => [
                'scripts' => ['/vendor/flasher/themes/emerald/emerald.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/emerald/emerald.min.css',
                ],
                'options' => [],
            ],
            'sapphire' => [
                'scripts' => ['/vendor/flasher/themes/sapphire/sapphire.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/sapphire/sapphire.min.css',
                ],
                'options' => [],
            ],
            'ruby' => [
                'scripts' => ['/vendor/flasher/themes/ruby/ruby.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/ruby/ruby.min.css',
                ],
                'options' => [],
            ],
            'onyx' => [
                'scripts' => ['/vendor/flasher/themes/onyx/onyx.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/onyx/onyx.min.css',
                ],
                'options' => [],
            ],
            'neon' => [
                'scripts' => ['/vendor/flasher/themes/neon/neon.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/neon/neon.min.css',
                ],
                'options' => [],
            ],
            'aurora' => [
                'scripts' => ['/vendor/flasher/themes/aurora/aurora.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/aurora/aurora.min.css',
                ],
                'options' => [],
            ],
            'minimal' => [
                'scripts' => ['/vendor/flasher/themes/minimal/minimal.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/minimal/minimal.min.css',
                ],
                'options' => [],
            ],
            'material' => [
                'scripts' => ['/vendor/flasher/themes/material/material.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/material/material.min.css',
                ],
                'options' => [],
            ],
            'google' => [
                'scripts' => ['/vendor/flasher/themes/google/google.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/google/google.min.css',
                ],
                'options' => [],
            ],
            'ios' => [
                'scripts' => ['/vendor/flasher/themes/ios/ios.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/ios/ios.min.css',
                ],
                'options' => [],
            ],
            'slack' => [
                'scripts' => ['/vendor/flasher/themes/slack/slack.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/slack/slack.min.css',
                ],
                'options' => [],
            ],
            'facebook' => [
                'scripts' => ['/vendor/flasher/themes/facebook/facebook.min.js'],
                'styles' => [
                    '/vendor/flasher/flasher.min.css',
                    '/vendor/flasher/themes/facebook/facebook.min.css',
                ],
                'options' => [],
            ],
        ];
    }
}
