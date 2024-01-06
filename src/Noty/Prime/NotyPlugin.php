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

    public function getServiceAliases(): string|array
    {
        return NotyInterface::class;
    }

    public function getScripts(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.js';
    }

    public function getStyles(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.css';
    }
}
