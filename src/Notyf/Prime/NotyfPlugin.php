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

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.js',
        ];
    }

    /**
     * @return string[]
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/flasher-notyf.min.css',
        ];
    }
}
