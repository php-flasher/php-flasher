<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Type;

/**
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

    public function getDefault(): string
    {
        return 'flasher';
    }

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

    public function normalizeConfig(array $config = []): array
    {
        $config = parent::normalizeConfig($config);

        $config = $this->normalizePlugins($config);
        $config = $this->normalizePresets($config);
        $config = $this->addDefaultConfig($config);
        $config = $this->normalizeFlashBag($config);
        $config = $this->setPresetsDefaults($config);

        return $config;
    }

    /**
     * @param array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins?: array<string, array{
     *         scripts?: string[],
     *         styles?: string[],
     *         options?: array<string, mixed>,
     *     }>,
     * } $config
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     plugins: array<string, mixed>,
     * }
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
     * @param array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, string|array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } $config
     *
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * }
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
     * } $config
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
     * }
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
     * } $config
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
     * }
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
     * } $config
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
     * }
     */
    private function setPresetsDefaults(array $config): array
    {
        foreach ($config['presets'] as $name => $options) {
            $config['presets'][$name]['type'] ??= Type::INFO;
            $config['presets'][$name]['options'] ??= [];
        }

        return $config;
    }
}
