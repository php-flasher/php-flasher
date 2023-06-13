<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Plugin\Plugin;

final class PnotifyPlugin extends Plugin
{
    public function getScripts(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.3.1/dist/flasher-pnotify.min.js';
    }

    public function getStyles(): string
    {
        return 'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.3.1/dist/flasher-pnotify.min.css';
    }
}
