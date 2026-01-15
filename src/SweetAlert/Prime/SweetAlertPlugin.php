<?php

declare(strict_types=1);

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Plugin\Plugin;

final class SweetAlertPlugin extends Plugin
{
    public function getAlias(): string
    {
        return 'sweetalert';
    }

    public function getFactory(): string
    {
        return SweetAlert::class;
    }

    public function getServiceAliases(): string
    {
        return SweetAlertInterface::class;
    }

    /**
     * @return string[]
     */
    public function getScripts(): array
    {
        return [
            '/vendor/flasher/sweetalert2.min.js',
            '/vendor/flasher/flasher-sweetalert.min.js',
        ];
    }

    /**
     * @return string[]
     */
    public function getStyles(): array
    {
        return [
            '/vendor/flasher/sweetalert2.min.css',
        ];
    }
}
