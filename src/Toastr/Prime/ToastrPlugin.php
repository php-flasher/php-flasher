<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

final class ToastrPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'toastr';
    }

    public function getFactory(): string
    {
        return Toastr::class;
    }

    public function getServiceAliases(): string
    {
        return ToastrInterface::class;
    }

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/jquery.min.js',
            '/vendor/flasher/toastr.min.js',
            '/vendor/flasher/flasher-toastr.min.js',
        ];
    }

    /**
     * @return string[]
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/toastr.min.css',
        ];
    }
}
