<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

final class NotyPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'noty';
    }

    public function getFactory(): string
    {
        return Noty::class;
    }

    public function getServiceAliases(): string
    {
        return NotyInterface::class;
    }

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/noty.min.js',
            '/vendor/flasher/flasher-noty.min.js',
        ];
    }

    /**
     * @return string[]
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/noty.css',
            '/vendor/flasher/mint.css',
        ];
    }
}
