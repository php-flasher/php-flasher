<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

final class NotyfPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'notyf';
    }

    public function getFactory(): string
    {
        return Notyf::class;
    }

    public function getServiceAliases(): string|array
    {
        return NotyfInterface::class;
    }

    public function getScripts(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.js';
    }

    public function getStyles(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.css';
    }
}
