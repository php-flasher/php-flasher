<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Notification\NotificationInterface;

final class FlasherPlugin extends Plugin
{
    public function getName(): string
    {
        return 'flasher';
    }

    public function getServiceID(): string
    {
        return 'flasher';
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

    public function getResourcesDir(): string
    {
        return realpath(__DIR__.'/../Resources') ?: '';
    }

    public function normalizeConfig(array $config = []): array
    {
        $config = parent::normalizeConfig($config);

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

        foreach ($config['plugins'] ?? [] as $name => $options) {
            $config['plugins'][$name]['scripts'] = (array) ($options['scripts'] ?? []);
            $config['plugins'][$name]['styles'] = (array) ($options['styles'] ?? []);
        }

        foreach ($config['presets'] ?? [] as $name => $options) {
            if (is_string($options)) {
                $options = ['message' => $options];
            }
            $config['presets'][$name] = $options;
        }

        // @phpstan-ignore-next-line
        $config = array_replace([
            'default' => $this->getDefault(),
            'root_script' => $this->getRootScript(),
            'auto_translate' => true,
            'auto_render' => true,
            'filter' => [],
            'scripts' => [],
            'styles' => [],
            'options' => [],
            'presets' => [
                'created' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was created'],
                'updated' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was updated'],
                'saved' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was saved'],
                'deleted' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was deleted'],
            ],
            'plugins' => [
                'flasher' => [
                    'scripts' => [],
                    'styles' => $this->getStyles(),
                    'options' => [],
                ],
            ],
        ], $config);

        $mapping = [
            'success' => ['success'],
            'error' => ['error', 'danger'],
            'warning' => ['warning', 'alarm'],
            'info' => ['info', 'notice', 'alert'],
        ];

        if (array_key_exists('flash_bag', $config) && $config['flash_bag']) {
            if (!is_array($config['flash_bag'])) {
                $config['flash_bag'] = [];
            }

            foreach ($config['flash_bag'] as $key => $value) {
                 $config['flash_bag'][$key] = array_merge($mapping[$key] ?? [], (array) $value);
            }

             $config['flash_bag'] += $mapping;
        } else {
            $config['flash_bag'] = [];
        }

        foreach ($config['presets'] ?? [] as $name => $options) {
            $config['presets'][$name]['type'] ??= NotificationInterface::INFO;
            $config['presets'][$name]['options'] ??= [];
        }

        return $config;
    }
}
