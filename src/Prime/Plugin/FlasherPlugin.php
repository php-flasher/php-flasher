<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactory;
use Flasher\Prime\FlasherInterface;
use Flasher\Prime\Notification\Type;

/**
 * @phpstan-type ConfigType array{
 *     default: string,
 *     root_script: string,
 *     translate: bool,
 *     inject_assets: bool,
 *     filter: array<mixed>,
 *     scripts: string[],
 *     styles: string[],
 *     options: array<string, mixed>,
 *     filters: array<string, mixed>,
 *     flash_bag: array{mapping: array<string, string[]>},
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

    public function getServiceAliases(): string|array
    {
        return FlasherInterface::class;
    }

    public function getDefault(): string
    {
        return 'flasher';
    }

    public function getRootScript(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.js';
    }

    public function getScripts(): string|array
    {
        return [];
    }

    public function getStyles(): string|array
    {
        return [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher@1.3.1/dist/flasher.min.css',
        ];
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
     *     plugins?: array<string, array<string, mixed>>,
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
            $config['plugins']['flasher']['scripts'] += $config['scripts'];
        }

        if (!empty($config['styles'])) {
            $config['plugins']['flasher']['styles'] += $config['styles'];
        }

        if (!empty($config['options'])) {
            $config['plugins']['flasher']['options'] += $config['options'];
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
     *     root_script?: string|null,
     *     translate?: bool,
     *     inject_assets?: bool,
     *     filter?: array<mixed>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets?: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     * } $config
     *
     * @return array{
     *     default: string|null,
     *     root_script: string|null,
     *     translate: bool,
     *     inject_assets: bool,
     *     filter: array<mixed>,
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
        $config['root_script'] = \array_key_exists('root_script', $config) ? $config['root_script'] : $this->getRootScript();
        $config['translate'] = \array_key_exists('translate', $config) ? $config['translate'] : true;
        $config['inject_assets'] = \array_key_exists('inject_assets', $config) ? $config['inject_assets'] : true;
        $config['filter'] = \array_key_exists('filter', $config) ? $config['filter'] : [];
        $config['presets'] = \array_key_exists('presets', $config) ? $config['presets'] : $defaultPresets;

        return $config;
    }

    /**
     * @param array{
     *     default: string|null,
     *     root_script: string|null,
     *     translate: bool,
     *     inject_assets: bool,
     *     filter: array<mixed>,
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     *     presets: array<string, array<string, mixed>>,
     *     plugins: array<string, mixed>,
     *     flash_bag?: mixed,
     * } $config
     *
     * @return array{
     *      default: string|null,
     *      root_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      filter: array<mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: array<string, string[]>,
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

        if (\array_key_exists('flash_bag', $config) && $config['flash_bag']) {
            if (!\is_array($config['flash_bag'])) {
                $config['flash_bag'] = [];
            }

            foreach ($config['flash_bag'] as $key => $value) {
                $config['flash_bag'][$key] = array_merge($mapping[$key] ?? [], (array) $value);
            }

            $config['flash_bag'] += $mapping;
        } else {
            $config['flash_bag'] = [];
        }

        return $config;
    }

    /**
     * @param array{
     *      default: string|null,
     *      root_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      filter: array<mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: array<string, string[]>,
     * } $config
     *
     * @return array{
     *      default: string|null,
     *      root_script: string|null,
     *      translate: bool,
     *      inject_assets: bool,
     *      filter: array<mixed>,
     *      scripts: string[],
     *      styles: string[],
     *      options: array<string, mixed>,
     *      presets: array<string, array<string, mixed>>,
     *      plugins: array<string, mixed>,
     *      flash_bag: array<string, string[]>,
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
