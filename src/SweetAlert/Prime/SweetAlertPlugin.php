<?php

namespace Flasher\SweetAlert\Prime;

use Flasher\Prime\Plugin\Plugin;

class SweetAlertPlugin extends Plugin
{
    public function getAlias()
    {
        return 'sweetalert';
    }

    public function getScripts()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.1/dist/flasher-sweetalert.min.js',
            ],
            'local' => [
                '/vendor/flasher/flasher-sweetalert.min.js',
            ],
        ];
    }

    public function getStyles()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-sweetalert@1.3.1/dist/flasher-sweetalert.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-sweetalert.min.css',
            ],
        ];
    }
}
