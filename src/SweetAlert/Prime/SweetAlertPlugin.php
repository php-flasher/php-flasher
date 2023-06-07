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

    public function getScripts(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.1/dist/flasher-sweetalert.min.js',
        ];
    }

    public function getStyles(): array
    {
        return [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.1/dist/flasher-sweetalert.min.css',
        ];
    }
}
