<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

class NotyPlugin extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        return array(
            'cdn' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.js',
            ),
            'local' => array(
                '/vendor/flasher/flasher-noty.min.js',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getStyles()
    {
        return array(
            'cdn' => array(
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.css',
            ),
            'local' => array(
                '/vendor/flasher/flasher-noty.min.css',
            ),
        );
    }
}
