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

    public function getServiceAliases(): string
    {
        return NotyfInterface::class;
    }

    public function getScripts(): string|array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.js',
        ];
    }

    public function getStyles(): string|array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.css',
        ];
    }
}
