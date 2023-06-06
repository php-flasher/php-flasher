<?php

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

class NotyfPlugin extends Plugin
{
    public function getScripts()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.js',
            ],
            'local' => [
                '/vendor/flasher/flasher-notyf.min.js',
            ],
        ];
    }

    public function getStyles()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-notyf.min.css',
            ],
        ];
    }
}
