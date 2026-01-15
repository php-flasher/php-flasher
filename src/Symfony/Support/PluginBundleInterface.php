<?php

declare(strict_types=1);

namespace Flasher\Symfony\Support;

use Flasher\Prime\Plugin\PluginInterface;

/**
 * Contract for PHPFlasher plugin bundles.
 */
interface PluginBundleInterface
{
    public function createPlugin(): PluginInterface;

    public function getConfigurationFile(): string;
}
