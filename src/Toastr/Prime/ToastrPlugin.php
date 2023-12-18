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

    public function getScripts(): string|array
    {
        return [
            'https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.js',
        ];
    }

    public function getStyles(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.css';
    }
}
