<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

final class NotyfPlugin extends Plugin
{
    public function getScripts(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.js';
    }

    public function getStyles(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.css';
    }
}
