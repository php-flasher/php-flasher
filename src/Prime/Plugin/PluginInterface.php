<?php

declare(strict_types=1);

namespace Flasher\Prime\Plugin;

use Flasher\Prime\Factory\NotificationFactoryInterface;

interface PluginInterface
{
    public function getAlias(): string;

    public function getName(): string;

    public function getServiceID(): string;

    /**
     * @return class-string<NotificationFactoryInterface>
     */
    public function getFactory(): string;

    /**
     * @return string[]
     */
    public function getScripts(): array;

    /**
     * @return string[]
     */
    public function getStyles(): array;

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array;

    public function getAssetsDir(): string;

    public function getResourcesDir(): string;

    /**
     * @param array{
     *     scripts?: string|string[],
     *     styles?: string|string[],
     *     options?: array<string, mixed>,
     * } $config
     * @return array{
     *     scripts: string[],
     *     styles: string[],
     *     options: array<string, mixed>,
     * }
     */
    public function normalizeConfig(array $config): array;
}
