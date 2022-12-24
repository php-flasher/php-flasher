<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Plugin\Plugin;

class PnotifyPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'cdn' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.2.3/dist/flasher-pnotify.min.js',
            ),
            'local' => array(
                '/vendor/flasher/flasher-pnotify.min.js',
            ),
        );
    }
}
