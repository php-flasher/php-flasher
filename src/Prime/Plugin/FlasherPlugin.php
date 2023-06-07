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

    public function getScripts(): array
    {
        return array_filter((array) $this->getRootScript());
    }

    public function getStyles(): array
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
        // @phpstan-ignore-next-line
        return array_replace_recursive([
            'default' => $this->getDefault(),
            'root_script' => $this->getRootScript(),
            'scripts' => [],
            'styles' => $this->getStyles(),
            'options' => [],
            'auto_translate' => true,
            'auto_render' => true,
            'flash_bag' => [
                'enabled' => true,
                'mapping' => [
                    'success' => ['success'],
                    'error' => ['error', 'danger'],
                    'warning' => ['warning', 'alarm'],
                    'info' => ['info', 'notice', 'alert'],
                ],
            ],
            'presets' => [
                'created' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was created'],
                'updated' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was updated'],
                'saved' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was saved'],
                'deleted' => ['type' => NotificationInterface::SUCCESS, 'message' => 'The resource was deleted'],
            ],
            'filter_criteria' => [],
        ], $config);
    }
}
