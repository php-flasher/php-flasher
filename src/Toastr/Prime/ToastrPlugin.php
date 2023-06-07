<?php

declare(strict_types=1);

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

final class ToastrPlugin extends Plugin
{
    public function getScripts(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.js',
        ];
    }

    public function getStyles(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.css',
        ];
    }
}
